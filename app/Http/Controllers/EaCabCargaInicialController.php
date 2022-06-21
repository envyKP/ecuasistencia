<?php

namespace App\Http\Controllers;

use App\Models\EaCabeceraCargaCorp;
use App\Models\EaDetalleCargaCorp;
use App\Models\EaProducto;
use App\Models\EaSubproducto;
use Illuminate\Http\Request;
use App\Http\Controllers\EaClienteController;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EaDetCargaCorpImport;
use App\Http\Controllers\EaBaseActivaController;
use App\Http\Controllers\EaProductoController;
use App\Http\Controllers\EaCabCargaInicialBitacoraController;
use App\Http\Controllers\EaDetalleCargaCorpController;
use App\Exports\EaReporteCargaInicialExport;


class EaCabCargaInicialController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $clientes =  (new EaClienteController)->getAllCampanas();
        $resumen_cabecera = EaCabeceraCargaCorp::orderBy('cod_carga')
                                                ->paginate(5);

        return view ('cargaInicial.home')->with(compact('clientes'))
                                         ->with( isset($resumen_cabecera) ? compact('resumen_cabecera') : '' );

    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {

        $clientes =  (new EaClienteController)->getAllCampanas();
        $RegistrosPendientes = EaCabeceraCargaCorp::where('estado', 'PENDIENTE')
                                                  ->orderBy('cliente')->paginate(5);

        return view ('cargaInicial.home')->with(compact('clientes'))
                                         ->with(compact('RegistrosPendientes'));

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function get_cabecera_carga_inicial_recapt($proceso)
    {

        $cabecera = EaCabeceraCargaCorp::where(function($query){
                                            $query->where('proceso', 'recepcion_provee_tmk')
                                                  ->orWhere('proceso', 'generacion_provee_tmk');
                                        })->orderBy('cliente')
                                          ->paginate(5);
        return $cabecera;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function get_cabecera_carga_inicial_recaif($proceso)
    {

        $cabecera = EaCabeceraCargaCorp::where(function($query){
                                                $query->where('proceso', 'recepcion_infor_finan')
                                                      ->orWhere('proceso', 'generacion_infor_finan');
                                        })->orderBy('cliente')
                                          ->paginate(5);

        return $cabecera;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_cabecera_infor_finan()
    {

        $cabecera = EaCabeceraCargaCorp::where('proceso', 'recepcion_provee_tmk')
                                       ->orderBy('cliente')
                                       ->paginate(5);
        return $cabecera;
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadArchivos(Request  $request)
    {

        $datosCab = $request->except('_token', 'subproducto', 'filtro_cliente', 'filtro_producto', 'filtro_subproducto' );
        $fecha = Date('Ymd');

        $productoDetalle = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
        $extension = $request->file('archivo')->extension();


        if (strtolower($extension) == 'xls' || strtolower($extension) == 'xlsx') {

            $datosCab['cod_carga'] = (new EaCabCargaInicialBitacoraController)->get_max_cod_carga_bita();
            $datosCab['proceso'] = 'carga_inicial';
            $datosCab['usuario_registra'] = $request->usuario_registra;
            $datosCab['fec_registro'] = Date('d/m/Y H:i:s');
            $datosCab['estado'] = 'PENDIENTE';

            $existe_visible = $this->valida_proceso_visible('carga_inicial');
            !$existe_visible ? $datosCab['visible'] ='S' : '';

            if (isset($productoDetalle)) {
                $datosCab['desc_producto'] = $productoDetalle->desc_producto;

            }else {

                $datosCab['producto'] = '';
                $datosCab['desc_producto'] = '';
            }

            if ($request->hasfile('archivo')) {
                $nombre_archivo = $request->file('archivo')->getClientOriginalName();
                //$nombre_archivo = "BASE_COLOCACION_".$request->cliente.'_'.$fecha.'.xlsx';
                $datosCab['archivo'] = $request->file('archivo')->storeAs('cargas_inicial/'.$request->cliente, $nombre_archivo, 'public');
            }

            $trx = EaCabeceraCargaCorp::insert($datosCab);

            if ($trx) {

                $rsp = (new EaCabCargaInicialBitacoraController)->create_bitacora( $datosCab['cod_carga'] );
                $success = "Archivo: ".$nombre_archivo.", del cliente: ".$request->cliente." cargado en estado pendiente de procesar." ;

            }




        }else {
            $error = "Archivos permitidos: xls ó xlsx";
        }


        return redirect()->route('EaCabCargaInicialController.index')->with(['success' => isset($success) ? $success : '',
                                                                             'error' => isset($error) ? $error : '' ]);

    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBaseActiva(Request $request)
    {
        $fecha = Date('Ymd');
        $obj_base_activa = (new EaBaseActivaController);
        $cabecera = EaCabeceraCargaCorp::where('cod_carga', $request->cod_carga)->first();
        $registro = array();
        $registro['filein_banco_info'] = explode('/', substr($cabecera->archivo, stripos($cabecera->archivo, $cabecera->cliente)))[1] ;
        $registro['usuario_reg'] = \Auth::user()->username;
        $registro['fec_carga'] = $fecha;
        $registro['cod_carga_corp'] = $cabecera->cod_carga;

        if ( !empty($cabecera->producto) ) {

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
                                  ->where('disponible_gestion', 'S')
                                  ->get();


        foreach( $data as $carga_inicial){

            $registro['cliente'] = $carga_inicial->cliente;
            $registro['nombre'] = $carga_inicial->nombre_completo;
            $registro['tipide'] = 'C';
            $registro['dettipide'] = 'CEDULA';
            $registro['cedula_id'] = trim($carga_inicial->cedula_id);
            $registro['genero'] = $carga_inicial->genero;
            $registro['mail'] = $carga_inicial->email;
            $registro['telefono1'] = $carga_inicial->telefono1;
            $registro['telefono2'] = $carga_inicial->telefono2;
            $registro['telefono3'] = $carga_inicial->telefono3;
            $registro['telefono4'] = $carga_inicial->telefono4;
            $registro['telefono5'] = $carga_inicial->telefono5;
            $registro['telefono6'] = $carga_inicial->telefono6;
            $registro['telefono7'] = $carga_inicial->telefono7;
            $registro['telefono7'] = $carga_inicial->telefono7;
            $registro['estado'] = 'A'; //DISPONIBLE PA LA GESTION
            $registro['estado_proceso'] = 1;

            if (!empty($carga_inicial->tipo_de_tarjeta) &&  strtolower(trim($carga_inicial->tipo_de_tarjeta)) === 'principal') {
                $registro['tiptar'] = 'P';
                $registro['dettiptar'] = strtoupper($carga_inicial->tipo_de_tarjeta);

            }else if  (!empty($carga_inicial->tipo_de_tarjeta) &&  strtolower(trim($carga_inicial->tipo_de_tarjeta)) === 'adicional') {
                $registro['tiptar'] = 'A';
                $registro['dettiptar'] =  strtoupper($carga_inicial->tipo_de_tarjeta);
            }


            $obj_base_activa->storeArchivo($registro);
        }


        $cambio_estado = EaDetalleCargaCorp::where('cod_carga', $request->cod_carga)
                                           ->where('estado', 'PROCESADO')
                                           ->where('disponible_gestion', 'S')
                                           ->exists();

        if ( $cambio_estado ) {

            EaDetalleCargaCorp::where('cod_carga', $request->cod_carga)
                              ->where('estado', 'PROCESADO')
                              ->where('disponible_gestion', 'S')
                              ->update(['estado' => 'EN_BASE_ACTIVA', 'fec_carga' => $fecha ]);

            EaCabeceraCargaCorp::where('proceso', 'carga_inicial')
                               ->where('cod_carga', $request->cod_carga)
                               ->update([ 'estado' => 'EN_BASE_ACTIVA', 'fec_carga' => $fecha ]);

        }


        return redirect()->route('EaCabCargaInicialController.index')->with(['success' => 'Datos enviado a la base activa']);

    }




    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function procesar(Request $request)
    {

        $cabecera_update = array();
        $registroCarga = EaCabeceraCargaCorp::where('cod_carga', $request->cod_carga)->first();
        //Excel::import(new EaDetCargaCorpImport($cod_carga), $registroCarga->archivo, 'public');

        $import = (new EaDetCargaCorpImport( $request->cod_carga, $registroCarga->cliente, $registroCarga->producto));
        $import->import($registroCarga->archivo, 'public');

        if ( !empty($import->detalle_proceso['errorTecnico']) ){

            $cabecera_update['estado'] = 'ERROR';
            $cabecera_update['visible'] = 'N';
            $errorTecnico = $import->detalle_proceso['errorTecnico'];
            $trx = $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $cabecera_update );


        }else {

            $cabecera_update['total_registros_archivo'] = isset($import->detalle_proceso['total_registros_archivo']) ? $import->detalle_proceso['total_registros_archivo'] : '' ;
            $cabecera_update['total_registros_sin_infor'] = isset($import->detalle_proceso['total_registros_sin_infor']) ? $import->detalle_proceso['total_registros_sin_infor'] : '' ;
            $cabecera_update['total_registros_disponibles_gestion'] = isset($import->detalle_proceso['total_registros_disponibles_gestion']) ? $import->detalle_proceso['total_registros_disponibles_gestion'] : '';
            $cabecera_update['total_registros_duplicados'] = isset($import->detalle_proceso['total_registros_duplicados']) ? $import->detalle_proceso['total_registros_duplicados'] : '';
            $cabecera_update['total_registros_gestionados_otras_campanas'] = isset($import->detalle_proceso['total_registros_gestionados_otras_campanas']) ? $import->detalle_proceso['total_registros_gestionados_otras_campanas'] : '';
            $cabecera_update['estado'] = 'PROCESADO';
            $cabecera_update['visible'] = 'N';

            try {

                $update_cab_carga = $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $cabecera_update );

            } catch (\Exception $e) {
                $errorTecnico = $e->getMessage();
            }


            if ($update_cab_carga) {

                $this->update_cola_proceso_visible( 'PENDIENTE', 'carga_inicial');
                $rsp = (new EaCabCargaInicialBitacoraController)->update_datos_cod_carga_bita( $request->cod_carga, $registroCarga->cliente, 'carga_inicial', $cabecera_update);

                $nombre_archivo = explode("/" , substr( $registroCarga->archivo, stripos($registroCarga->archivo, $registroCarga->cliente)))[1];
                $registros_no_cumplen = isset($import->detalle_proceso['registros_no_cumplen']) ? $import->detalle_proceso['registros_no_cumplen'] : '';
                $success = "Carga realizada del archivo: ".$nombre_archivo.' ver detalles';

            }

        }

        return redirect()->route('EaCabCargaInicialController.index')->with(['success' => isset($success) ? $success : '',
                                                                             'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : '',
                                                                             'registros_no_cumplen' => isset($registros_no_cumplen) ? $registros_no_cumplen : '' ]);

    }




    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request )
    {

        $registroCarga = EaCabeceraCargaCorp::where('cod_carga', $request->cod_carga)->first();
        $pos_nombre_archivo = strpos($registroCarga->archivo, $registroCarga->cliente);
        $nombre_archivo = explode("/", substr($registroCarga->archivo, $pos_nombre_archivo) )[1];

        //Storage::disk('public')->delete($registroCarga->archivo);
        $trx = EaCabeceraCargaCorp::where('cod_carga', $request->cod_carga)->delete();
        if ($trx) {
            # code...
            (new EaDetalleCargaCorpController)->truncate($request->cod_carga, $registroCarga->cliente);
        }

        $cod_carga_b = EaCabeceraCargaCorp::where('estado', 'PENDIENTE')
                                          ->where('proceso', 'carga_inicial')
                                          ->min('cod_carga');

        if ($cod_carga_b) {
            EaCabeceraCargaCorp::where('cod_carga', $cod_carga_b)->update(['visible' => 'S']);
        }


        $error= 'Registros temporales del código de carga: '.$request->cod_carga.'  eliminado del cliente: '.$registroCarga->cliente;

        return redirect()->route('EaCabCargaInicialController.index')->with(compact('error'));

    }




     /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_archivos_html_genapt(Request  $request){


       $archivos = '<option value="">Seleccione un archivo</option>';

       $datos =EaCabeceraCargaCorp::where("cliente", $request->cliente)
                                  ->where("estado", 'EN_BASE_ACTIVA')
                                  ->where("proceso", 'carga_inicial')
                                  ->get();

        foreach ($datos as $value) {
            $archivos .= '<option value="'.$value->cod_carga.'">Cód. carga: '.$value->cod_carga.' :: '.$value->archivo.'</option>';
        }

        return response()->json(['archivo_html' => $archivos]);
    }



    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_procesos_carga_html(Request $request){


        $procesos = '<option value="">Seleccione un archivo</option>';

        $datos =EaCabeceraCargaCorp::where('cliente', $request->cliente)
                                   ->where('proceso', $request->filtro_proce_carga)
                                   ->get();

         foreach ($datos as $value) {
             $procesos .= '<option value="'.$value->cod_carga.'">Cód. carga: '.$value->cod_carga.' :: '.$value->archivo.'</option>';
         }

        return response()->json(['procesos_carga_html' => $procesos]);

     }




    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_archivos_html_genaif(Request  $request)
    {

        $archivos = '<option value="">Seleccione un archivo</option>';

        $datos =EaCabeceraCargaCorp::where('cliente', $request->cliente)
                                   ->where('estado', 'PROCESADO')
                                   ->where('proceso', 'recepcion_provee_tmk')
                                   ->get();

         foreach ($datos as $value) {
             $archivos .=  '<option value="'.$value->cod_carga.'">Cód. carga: '.$value->cod_carga.' :: '.$value->archivo.'</option>';
         }

         return response()->json(['archivo_html' => $archivos]);

     }




    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_detalle_carga_corp($cod_carga)
    {

        $detalle_cab = EaCabeceraCargaCorp::where('cod_carga', $cod_carga)->first();
        return  $detalle_cab;

    }



    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ListGenArchivosProveetmk ()
    {

        $resumen_cabecera = EaCabeceraCargaCorp::where('proceso', 'carga_inicial')
                                               ->where('estado', 'EN_BASE_ACTIVA')
                                               ->orderBy('cliente')
                                               ->paginate(5);
        return  $resumen_cabecera;

    }



    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_proceso_cab_carga( $cliente, $cod_carga, $proceso, $proceso_update)
    {

       $trx =  EaCabeceraCargaCorp::where('cliente', $cliente)
                                  ->where('cod_carga', $cod_carga)
                                  ->where('proceso', $proceso )
                                  ->update([ 'proceso' => $proceso_update ]);
        return $trx;

    }



    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_datos_cab_carga( $cliente, $cod_carga, array $datos)
    {

       $trx =  EaCabeceraCargaCorp::where('cliente', $cliente)
                                  ->where('cod_carga', $cod_carga)
                                  ->update($datos);
       return $trx;

    }




    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function edit_producto_cab_carga_inicial($cod_carga, $cliente, $producto)
    {

        $datosCabecera = array();

        if ( isset($producto) ) {

            $productoDetalle = (new EaProductoController)->getProductoDetalle($cliente, $producto);
            $datosCabecera['producto'] =  $productoDetalle->contrato_ama;
            $datosCabecera['desc_producto'] =  $productoDetalle->desc_producto;

            $trx = EaCabeceraCargaCorp::where('cod_carga', $cod_carga)
                                      ->update($datosCabecera);

        }

        return $trx;

    }



    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function update_cola_proceso_visible ( $estado, $proceso)
    {

        $cod_carga_b = EaCabeceraCargaCorp::where('estado', $estado) //PENDIENTE
                                          ->where('proceso', $proceso) //carga_inicial
                                          ->min('cod_carga');

        if ($cod_carga_b) {
            EaCabeceraCargaCorp::where('cod_carga', $cod_carga_b)->update(['visible' => 'S']);
        }

    }


    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function valida_proceso_visible( $proceso ){

       $existe = EaCabeceraCargaCorp::where('visible', 'S')
                                    ->where('proceso', $proceso) //carga_inicial
                                    ->exists();
        return $existe;
    }




    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    function exportar_reporte(Request $request){

        $archivo = 'Reporte_de_carga_inicial_cod_carga_'.$request->cod_carga.'.xlsx';
        $export = new EaReporteCargaInicialExport($request->cod_carga, $request->proceso);

        $descarga = $export->download($archivo);

        return $descarga;


    }


}
