<?php

namespace App\Http\Controllers;

use App\Models\EaCabeceraCargaCorp;
use App\Models\EaBaseActiva;
use Illuminate\Http\Request;
use App\Imports\EaCancelacionMasivaImport;
use App\Models\EaDetalleCargaCorp;
use App\Exports\EaReporteCancelacionMasiva;
use App\Models\EaCabeceraDetalleCarga;
use Maatwebsite\Excel\Facades\Excel;

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
        $this->contador_interrupcion = 0;
        $fecha = Date('Ymd');
        $obj_base_activa = (new EaBaseActivaController);
        // añadir el campo observacion aki o directamente en el request
        // -> se añadio en el request
        if (!isset($request->observaciones)) {
            return redirect()->route('EaCancelacionMasivaController.index')->with(['success' => 'No existe Motivo de cancelacion']);
            //   echo 'pruebas de isset 1 ' . $request->observaciones;
        }
        // echo 'pruebas de isset 2 ' . $request->observaciones;
        //dd($request);
        $cabecera = EaCabeceraCargaCorp::where('cod_carga', $request->cod_carga)->first();
        $registro = array();
        $registro['filein_banco_info'] = explode('/', substr($cabecera->archivo, stripos($cabecera->archivo, $cabecera->cliente)))[1];
        $registro['usuario_reg'] = \Auth::user()->username;
        $registro['fec_carga'] = $fecha;
        $registro['cod_carga_corp'] = $cabecera->cod_carga;
        if (!empty($cabecera->cliente)) {
            $registro['cliente'] = $cabecera->cliente;
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
        foreach ($data as $cancelacion_masiva) {
            $registro['cedula_id'] = trim($cancelacion_masiva->cedula_id);
            $this->borrarRegistroBaseActiva($registro, $request['observaciones']);
        }
        // mientras 1 registro si exista disponible para el cambio de gestion , no cambia de estado
        $cambio_estado = EaDetalleCargaCorp::where('cod_carga', $request->cod_carga)
            ->where('estado', 'CANCELACION')
            ->where('disponible_gestion', 'S')
            ->exists();
        if ($cambio_estado) {
            EaCabeceraCargaCorp::where('proceso', 'cancelacion_masiva')
                ->where('cod_carga', $request->cod_carga)
                ->update(['estado' => 'CANCELACION', 'fec_carga' => $fecha, 'total_registros_gestionados_otras_campanas' => $this->contador_interrupcion]);
        }
        //deberia ser pop up
        // pero si lo hago asi deberia cambiar a ajax
        if ($this->contador_interrupcion > 0) {
            return redirect()->route('EaCancelacionMasivaController.index')->with(['error' => 'exiten :' . $this->contador_interrupcion . ' que no pertenecen al cliente y no pudieron borrarse mas informacion de click en la lupa.']);
        }
        return redirect()->route('EaCancelacionMasivaController.index')->with(['success' => 'Datos Cancelados en base activa']);
    }


    public function borrarRegistroBaseActiva($data, $observaciones)
    {
        /*
        array:6 [▼
  "filein_banco_info" => "BASE activa BGR pruebas .xlsx"
  "usuario_reg" => "sgavela"
  "fec_carga" => "20220922"
  "cod_carga_corp" => "21"
  "cliente" => "BGR"
  "cedula_id" => "1102127295"
] */
        $condicion2 = 'cliente';
        $condicion1 = isset($data['producto']) ? 'producto' : 'cliente';
        $exite_registro = null;
        if ($condicion2 == 'cliente') {
            if ($condicion1 == 'producto') {
                // producto
                $exite_registro = EaBaseActiva::where('cedula_id', $data['cedula_id'])->where('cliente', $data['cliente'])->where('producto', $data['producto'])->first();
            } else {
                //solo cliente
                $exite_registro = EaBaseActiva::where('cedula_id', $data['cedula_id'])->where('cliente', $data['cliente'])->first();
            }
        }
        //$observaciones = isset($data['observaciones']) ? $data['observaciones'] : 'Utilizo cancelacion masiva, No observacion';
        if (isset($exite_registro['id_sec'])) {
            EaBaseActiva::where('id_sec', (int)$exite_registro['id_sec'])
                ->update([
                    'detresp' => 'CANCELADO',
                    'usmod' => \Auth::user()->username,
                    'fecmod' => date('d/m/Y'), 'hormod' => date('h:i:s'),
                    'feccan' => date('d/m/Y'),
                    'estado' => 'Z',
                    'detestado' => 'CANCELADO',
                    'codestado' => 'C',
                    'observaciones' => $observaciones
                ]);
            EaDetalleCargaCorp::where('cod_carga', $data['cod_carga_corp'])
                ->where('estado', 'PROCESADO')
                ->where('cedula_id', $data['cedula_id'])
                ->update(['estado' => 'CANCELACION', 'fec_carga' => $data['fec_carga']]);
        } else {
            EaDetalleCargaCorp::where('cod_carga', $data['cod_carga_corp'])->where('cedula_id', $data['cedula_id'])
                ->update(['estado' => 'INTERRUPCION', 'disponible_gestion' => 'N', 'fec_carga' => $data['fec_carga']]);
            $this->contador_interrupcion++;
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
    public function destroy(Request $request)
    {
        $registroCarga = EaCabeceraCargaCorp::where('cod_carga', $request->cod_carga)->first();
        $pos_nombre_archivo = strpos($registroCarga->archivo, $registroCarga->cliente);
        $nombre_archivo = explode("/", substr($registroCarga->archivo, $pos_nombre_archivo))[1];
        //Storage::disk('public')->delete($registroCarga->archivo);
        $trx = EaCabeceraCargaCorp::where('cod_carga', $request->cod_carga)->delete();
        if ($trx) {
            (new EaDetalleCargaCorpController)->truncate($request->cod_carga, $registroCarga->cliente);
        }
        $cod_carga_b = EaCabeceraCargaCorp::where('estado', 'PENDIENTE')
            ->where('proceso', 'carga_inicial')
            ->min('cod_carga');
        if ($cod_carga_b) {
            EaCabeceraCargaCorp::where('cod_carga', $cod_carga_b)->update(['visible' => 'S']);
        }
        $error = 'Registros temporales del código de carga: ' . $request->cod_carga . '  eliminado del cliente: ' . $registroCarga->cliente;
        return redirect()->route('EaCancelacionMasivaController.index')->with(compact('error'));
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
        $import = (new EaCancelacionMasivaImport($request->cod_carga, $registroCarga->cliente, $registroCarga->producto));
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
        /*
        $archivo = 'Reporte_de_cancelacion_masiva_cod_carga_' . $request->cod_carga . '.xlsx';
        $export = new EaReporteCancelacionMasiva($request->cod_carga, $request->proceso);
        $descarga = $export->download($archivo);
        */
        return Excel::download(
            new EaReporteCancelacionMasiva(
                $request->cod_carga,
                $request->proceso
            ),
            'Reporte_de_cancelacion_masiva_cod_carga_' . $request->cod_carga
                . '.xlsx'
        );
        // return $descarga;
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
    {$existe = EaCabeceraCargaCorp::where('visible', 'S')
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
