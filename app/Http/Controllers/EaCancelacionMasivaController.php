<?php

namespace App\Http\Controllers;

use App\Models\EaCabeceraCargaCorp;
use App\Models\EaBaseActiva;
use Illuminate\Http\Request;
use App\Imports\EaDetCargaCorpImport;
use App\Models\EaDetalleCargaCorp;
use App\Exports\EaReporteCargaInicialExport;
use App\Models\EaCabeceraDetalleCarga;

class EaCancelacionMasivaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes =  (new EaClienteController)->getAllCampanas();
        //$resumen_cabecera = EaCabeceraCargaCorp::orderBy('cod_carga')->paginate(5);
        $resumen_cabecera = EaCabeceraCargaCorp::orderBy('cod_carga')
            ->where('proceso', 'cancelacion_masiva')
            ->paginate(5);
        return view('EaCancelacionMasiva.home')->with(compact('clientes'))
            ->with(isset($resumen_cabecera) ? compact('resumen_cabecera') : '');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadArchivos(Request  $request)
    {
        $datosCab = $request->except('_token', 'subproducto', 'filtro_cliente', 'filtro_producto', 'filtro_subproducto');
        //ejemplo de condicion que provendria de la vista 
        //$proceso_valor = isset($datosCab['cancelacion_masiva']) ?  'cancelacion_masiva' : 'carga_inicial';
        $proceso_valor = 'cancelacion_masiva';
        //$fecha = Date('Ymd');



        $extension = $request->file('archivo')->extension();
        if (strtolower($extension) == 'xls' || strtolower($extension) == 'xlsx') {
            if (isset($request->cliente) && $request->cliente != null) {
                //echo 'dentro de la condicion de cliente no null';
                $productoDetalle = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
                if (isset($productoDetalle)) {
                    //echo 'dentro de isset productoDetalle';
                    $datosCab['desc_producto'] = $productoDetalle->desc_producto;
                } else {
                    //echo 'dentro del else isset productoDetalle';
                    $datosCab['producto'] = '';
                    $datosCab['desc_producto'] = '';
                }
            } else {
                //echo 'dentro de la condicion de todos';
                $request->cliente = 'TODO';
                $datosCab['cliente'] = 'TODO';
                $datosCab['producto'] = 'TODO';
                $datosCab['desc_producto'] = 'TODO';
            }

            $datosCab['cod_carga'] = (new EaCabCargaInicialBitacoraController)->get_max_cod_carga_bita();
            $datosCab['proceso'] = $proceso_valor;
            $datosCab['usuario_registra'] = $request->usuario_registra;
            $datosCab['fec_registro'] = Date('d/m/Y H:i:s');
            $datosCab['estado'] = 'PENDIENTE';
            $datosCab['visible'] = '';

            if ($request->hasfile('archivo')) {
                $nombre_archivo = $request->file('archivo')->getClientOriginalName();
                //$nombre_archivo = "BASE_COLOCACION_".$request->cliente.'_'.$fecha.'.xlsx';
                $datosCab['archivo'] = $request->file('archivo')->storeAs($proceso_valor . '/' . $request->cliente, $nombre_archivo, 'public');
            }
            $trx = EaCabeceraCargaCorp::insert($datosCab);
            if ($trx) {
                $rsp = (new EaCabCargaInicialBitacoraController)->create_bitacora($datosCab['cod_carga']);
                $success = "Archivo: " . $nombre_archivo . ", del cliente: " . $request->cliente . " cargado en estado pendiente de procesar.";
            }
        } else {
            $error = "Archivos permitidos: xls ó xlsx";
        }
        return redirect()->route('EaCancelacionMasivaController.index')->with([
            'success' => isset($success) ? $success : '',
            'error' => isset($error) ? $error : ''
        ]);
    }


    //borrar : storeBaseActiva
    public function borrarEnBaseActiva(Request $request)
    {
        $fecha = Date('Ymd');
        $obj_base_activa = (new EaBaseActivaController);
        $cabecera = EaCabeceraCargaCorp::where('cod_carga', $request->cod_carga)->first();
        $registro = array();
        $registro['filein_banco_info'] = explode('/', substr($cabecera->archivo, stripos($cabecera->archivo, $cabecera->cliente)))[1];
        $registro['usuario_reg'] = \Auth::user()->username;
        $registro['fec_carga'] = $fecha;
        $registro['cod_carga_corp'] = $cabecera->cod_carga;

        if (($cabecera->cliente) == 'TODO') {
        } elseif (!empty($cabecera->producto)) {
            $productoDet = (new EaProductoController)->getProductoDetalle($cabecera->cliente, $cabecera->producto);
            $registro['producto'] = $productoDet->contrato_ama;
            $registro['desc_producto'] = $productoDet->desc_producto;
            $registro['subproducto'] = $productoDet->subproducto;
        } else {
            $registro['producto'] = null;
            $registro['desc_producto'] = null;
            $registro['subproducto'] = null;
        }
        $data = EaDetalleCargaCorp::where('cod_carga', $request->cod_carga)
            ->where('estado', 'PROCESADO')
            ->get();
        // si pero no aki deberia ir el metodo para eliminar de la BASE ACTIVA
        foreach ($data as $cancelacion_masiva) {
            //dd($data);
            // solo nescesitaria la id_sec , 
            // existe una consulta en la tabla temporal pero es nesesario realizar una tambien en la tabla de la base activa 
            // esto puede demorar , no es un insert por lo que tiene que buscarlo en base
            // pero existe un ID_SEC , lo que practicamente seria buscar el dato y extraer el ID_SEc
            // reunir todo y borrar 
            $registro['cedula_id'] = trim($cancelacion_masiva->cedula_id);
            //en este punto 

            //bloque comentado posiblemente innceseario
            /*
            $registro['cliente'] = $cancelacion_masiva->cliente;
            $registro['nombre'] = $cancelacion_masiva->nombre_completo;
            $registro['tipide'] = 'C';
            $registro['dettipide'] = 'CEDULA';
            $registro['cedula_id'] = trim($cancelacion_masiva->cedula_id);
            $registro['genero'] = $cancelacion_masiva->genero;
            $registro['mail'] = $cancelacion_masiva->email;
            $registro['estado_proceso'] = 1;
            if (!empty($cancelacion_masiva->tipo_de_tarjeta) &&  strtolower(trim($cancelacion_masiva->tipo_de_tarjeta)) === 'principal') {
                $registro['tiptar'] = 'P';
                $registro['dettiptar'] = strtoupper($cancelacion_masiva->tipo_de_tarjeta);
            } else if (!empty($cancelacion_masiva->tipo_de_tarjeta) &&  strtolower(trim($cancelacion_masiva->tipo_de_tarjeta)) === 'adicional') {
                $registro['tiptar'] = 'A';
                $registro['dettiptar'] =  strtoupper($cancelacion_masiva->tipo_de_tarjeta);
            }
            */

            //borrar en base activa 
            /**
             * puedo usar la cedula_id , y datos de cliente y producto
             * puedo usar la cedula_id , y solo eso 
             */

            $this->borrarRegistroBaseActiva($registro);
            /*
            public function storeArchivo($data)
            {
                $id_sec = EaBaseActiva::max('id_sec');
        
                if (isset($id_sec) && $id_sec !== 1) {
                    $id_sec++;
                } else {
                    $id_sec = 1;
                }
        
                $data['id_sec'] = $id_sec;
                $data['fecha_reg']  = Date('d/m/Y H:i:s');
        
                EaBaseActiva::insert($data);
            }
            */
        }
        $cambio_estado = EaDetalleCargaCorp::where('cod_carga', $request->cod_carga)
            ->where('estado', 'PROCESADO')
            ->where('disponible_gestion', 'S')
            ->exists();
        if ($cambio_estado) {
            EaDetalleCargaCorp::where('cod_carga', $request->cod_carga)
                ->where('estado', 'PROCESADO')
                ->update(['estado' => 'BORRADO', 'fec_carga' => $fecha]);
            EaCabeceraCargaCorp::where('proceso', 'cancelacion_masiva')
                ->where('cod_carga', $request->cod_carga)
                ->update(['estado' => 'BORRADO', 'fec_carga' => $fecha]);
        }
        return redirect()->route('EaCancelacionMasivaController.index')->with(['success' => 'Datos borrados en la base activa']);
    }


    public function borrarRegistroBaseActiva($data)
    {
        //$condicion1 = isset($data['cedula_id']) ? 'cedula_id' : 'cedula_id';
        $condicion2 = isset($data['cliente']) ? 'cliente' : 'cedula_id';
        $condicion1 = isset($data['producto']) ? 'producto' : 'cedula_id';
        //contrato_AMA, tiene nombre producto en cabezera , esto se esta usando 
        // como esta en la cabezera debo cambiar la condicion de el producto  , puede existir un registro sin clienten
        // en este caso si por que lo que se quiere eliminar es el registro de todos lados 
        if ($condicion2 === 'cedula_id' && $condicion1 === 'cedula_id') {
            
            
            EaBaseActiva::where('cedula_id', $data['cedula_id'])->delete();;
        } elseif ($condicion2 === 'cliente') {
            
            
            if ($condicion1 === 'producto') {
                EaBaseActiva::where('cedula_id', $data['cedula_id'])->where('cliente', $data['cliente'])->where('producto', $data['producto'])->delete();
            } else {
                EaBaseActiva::where('cedula_id', $data['cedula_id'])->where('cliente', $data['cliente'])->delete();
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //depura los datos para que se pueda insertar de forma limpia a la base activa
    public function procesar(Request $request)
    {
        $cabecera_update = array();
        $registroCarga = EaCabeceraCargaCorp::where('cod_carga', $request->cod_carga)->first();

        //Excel::import(new EaDetCargaCorpImport($cod_carga), $registroCarga->archivo, 'public');

        $import = (new EaDetCargaCorpImport($request->cod_carga, $registroCarga->cliente, $registroCarga->producto));
        $import->import($registroCarga->archivo, 'public');
        if (!empty($import->detalle_proceso['errorTecnico'])) {
            $cabecera_update['estado'] = 'ERROR';
            $cabecera_update['visible'] = 'N';
            $errorTecnico = $import->detalle_proceso['errorTecnico'];
            $trx = $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $cabecera_update);
        } else {
            //problema de que solo carga el proceso que se ha realizado de forma inmediata o el ultimo proceso ,
            // por ende los nuevos o viejos valores en este caso no se muestran , mmmm seria de crear algo asi en base ? o algo asi existe pero no esta bien invocado?
            //si existe en base, si lo muestra , menos el de listado de registros malos, el reporte es lo mismo que se presenta en la vista 
            // Posiblemente pueda añadirlo a lo que es la vista de la ventana de generacion con facilidad si aumento los campos en cabezera , pero deberia crear un campo que indique la liena 
            //la cual es el row en el que viene el error 
            $cabecera_update['total_registros_archivo'] = isset($import->detalle_proceso['total_registros_archivo']) ? $import->detalle_proceso['total_registros_archivo'] : '';
            $cabecera_update['total_registros_sin_infor'] = isset($import->detalle_proceso['total_registros_sin_infor']) ? $import->detalle_proceso['total_registros_sin_infor'] : '';
            $cabecera_update['total_registros_disponibles_gestion'] = isset($import->detalle_proceso['total_registros_disponibles_gestion']) ? $import->detalle_proceso['total_registros_disponibles_gestion'] : '';
            $cabecera_update['total_registros_duplicados'] = isset($import->detalle_proceso['total_registros_duplicados']) ? $import->detalle_proceso['total_registros_duplicados'] : '';
            $cabecera_update['total_registros_gestionados_otras_campanas'] = isset($import->detalle_proceso['total_registros_gestionados_otras_campanas']) ? $import->detalle_proceso['total_registros_gestionados_otras_campanas'] : '';
            $cabecera_update['estado'] = 'PROCESADO';
            $cabecera_update['visible'] = 'N';
            try {
                $update_cab_carga = $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $cabecera_update);
            } catch (\Exception $e) {
                $errorTecnico = $e->getMessage();
            }
            if ($update_cab_carga) {
                if (strtolower(trim($registroCarga->proceso)) == 'cancelacion_masiva') {
                    $cabecera_update['visible'] = '';
                    $rsp = (new EaCabCargaInicialBitacoraController)->update_datos_cod_carga_bita($request->cod_carga, $registroCarga->cliente, 'cancelacion_masiva', $cabecera_update);
                } else {
                    $this->update_cola_proceso_visible('PENDIENTE', 'cancelacion_masiva');
                    $rsp = (new EaCabCargaInicialBitacoraController)->update_datos_cod_carga_bita($request->cod_carga, $registroCarga->cliente, 'cancelacion_masiva', $cabecera_update);
                }
                $nombre_archivo = explode("/", substr($registroCarga->archivo, stripos($registroCarga->archivo, $registroCarga->cliente)))[1];
                $registros_no_cumplen = isset($import->detalle_proceso['registros_no_cumplen']) ? $import->detalle_proceso['registros_no_cumplen'] : '';
                $success = "Carga realizada del archivo: " . $nombre_archivo . ' ver detalles';
            }
        }

        return redirect()->route('EaCancelacionMasivaController.index')->with([
            'success' => isset($success) ? $success : '',
            'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : '',
            'registros_no_cumplen' => isset($registros_no_cumplen) ? $registros_no_cumplen : ''
        ]);
    }

    function exportar_reporte(Request $request)
    {

        $archivo = 'Reporte_de_cancelacion_masiva_cod_carga_' . $request->cod_carga . '.xlsx';
        $export = new EaReporteCargaInicialExport($request->cod_carga, $request->proceso);

        $descarga = $export->download($archivo);

        return $descarga;
    }

    public function update_datos_cab_carga($cliente, $cod_carga, array $datos)
    {

        $trx =  EaCabeceraCargaCorp::where('cliente', $cliente)
            ->where('cod_carga', $cod_carga)
            ->update($datos);
        return $trx;
    }
}


/**

    public function valida_proceso_visible($proceso)
    {
        $existe = EaCabeceraCargaCorp::where('visible', 'S')
            ->where('proceso', $proceso) //carga_inicial
            ->exists();
        //echo "dentro de valida proceso visible"; o que exista una S en visible 
        //sirve para el control en la vista y que nomas desbloquee un proceso a la vez  o boton a la vez en la vista de carga inicial
        // no usado para la vista que se tiene planeada , en cancelacion masiva
        // nescesario evaluar si se duplica el controlador actual de carga inicial en uno nuevo , o simplemente 
        // se realizan modificaciones en el codigo actual , 
        //pros menos codigo , el mantenimiento o cambios mas segmentados.
        // contras : la personalizacion y en caso de añadir otras funcionalidades se realizara de forma mas compleja
        // igual comparte por el momento la misma tabla . 
        // preguntar si usan tablas distinta para que sea posible lo que es duplicar el controlador 
        //->exists();


        return $existe;
    } 
 
 */
