<?php

namespace App\Http\Controllers;

use App\Models\EaSegurViaje;
use App\Models\EaCabCargaSegurviajeCarg;
use App\Models\EaCabeceraCargaCorp;
use App\Imports\EaFactSegurViajeImport;
use Illuminate\Http\Request;

class EaFactMasSeguviajeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes =  (new EaClienteController)->getAllCampanas();
        $resumen_cabecera = EaCabCargaSegurviajeCarg::orderBy('cod_carga')
                                                    ->paginate(5);

        return view ('facMasSegur.home')->with(compact('clientes'))
                                        ->with(compact('resumen_cabecera'));
    }




      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSubproductoSap (Request  $request){

       $dataJson = (new EaSubproductoController)->getSubproductoSap($request);

       return $dataJson;

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $data = EaSegurViaje::all();

        return response()->json($data);
    }




      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadArchivos(Request  $request)
    {

        $datosCab = $request->except('_token', 'producto', 'filtro_cliente', 'filtro_producto', 'filtro_subproducto', 'filtro_nombreLote', 'txt_nombreLote' );
        $fecha = Date('Ymd');

        $productoDetalle = (new EaSubproductoController)->getSubproductoDetalle($request->cliente, $request->subproducto);
        $extension = $request->file('archivo')->extension();

        if (strtolower($extension) == 'xls' || strtolower($extension) == 'xlsx') {

            $datosCab['cod_carga'] = $this->get_max_cod_carga();
            $datosCab['proceso'] = 'carga_inicial';
            $datosCab['usuario_registra'] = $request->usuario_registra;
            $datosCab['fec_registro'] = Date('d/m/Y H:i:s');
            $datosCab['estado'] = 'PENDIENTE';

            $existe_visible = $this->valida_proceso_visible('carga_inicial');
            !$existe_visible ? $datosCab['visible'] ='S' : '';

            if (isset($productoDetalle)) {
                $datosCab['nombre_contrato_ama'] = $productoDetalle->nombre_contrato_ama;

            }else {

                $datosCab['subproducto'] = '';
                $datosCab['nombre_contrato_ama'] = '';
            }

            if ($request->hasfile('archivo')) {
                $nombre_archivo = $request->txt_nombreLote; //$request->file('archivo')->getClientOriginalName();
                //$nombre_archivo = "BASE_COLOCACION_".$request->cliente.'_'.$fecha.'.xlsx';
                $datosCab['archivo'] = $request->file('archivo')->storeAs('cargas_segurviaje/'.$request->cliente, $nombre_archivo, 'public');
            }

            $trx = EaCabCargaSegurviajeCarg::insert($datosCab);

            if ($trx) {

                $success = "Archivo: ".$nombre_archivo.", del cliente: ".$request->cliente." cargado en estado pendiente de procesar." ;

            }




        }else {
            $error = "Archivos permitidos: xls ó xlsx";
        }


        return redirect()->route('EaFactMasSeguviajeController.index')->with(['success' => isset($success) ? $success : '',
                                                                             'error' => isset($error) ? $error : '' ]);

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
        $trx = EaCabCargaSegurviajeCarg::where('cod_carga', $request->cod_carga)->delete();
        if ($trx) {
            # code...
            //(new EaDetalleCargaCorpController)->truncate($request->cod_carga, $registroCarga->cliente);
        }

        $cod_carga_b = EaCabCargaSegurviajeCarg::where('estado', 'PENDIENTE')
                                                ->where('proceso', 'carga_inicial')
                                                ->min('cod_carga');

        if ($cod_carga_b) {
            EaCabCargaSegurviajeCarg::where('cod_carga', $cod_carga_b)->update(['visible' => 'S']);
        }


        $error= 'Registros temporales del código de carga: '.$request->cod_carga.'  eliminado del cliente: '.$registroCarga->cliente;

        return redirect()->route('EaFactMasSeguviajeController.index')->with(compact('error'));

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


    public function get_max_cod_carga()
    {

        $cod_carga = EaCabCargaSegurviajeCarg::max('cod_carga');

        if (isset($cod_carga) && $cod_carga>= 1) {
            $cod_carga++;

        }else {
            $cod_carga = 1;
        }

        return  $cod_carga;

    }


    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function valida_proceso_visible( $proceso ){

        $existe = EaCabCargaSegurviajeCarg::where('visible', 'S')
                                          ->exists();
         return $existe;
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

        $import = (new EaFactSegurViajeImport( $request->cod_carga, $registroCarga->cliente, $registroCarga->producto));
        $import->import($registroCarga->archivo, 'public');

        if ( !empty($import->detalle_proceso['errorTecnico']) ){

            $cabecera_update['estado'] = 'ERROR';
            $cabecera_update['visible'] = 'N';
            $errorTecnico = $import->detalle_proceso['errorTecnico'];
            $trx = $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $cabecera_update );


        }else {

            $cabecera_update['total_registros_archivo'] = isset($import->detalle_proceso['total_registros_archivo']) ? $import->detalle_proceso['total_registros_archivo'] : '' ;
            $cabecera_update['estado'] = 'PROCESADO';
            $cabecera_update['visible'] = 'N';

            try {

                $update_cab_carga = $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $cabecera_update );

            } catch (\Exception $e) {
                $errorTecnico = $e->getMessage();
            }




        }

        return redirect()->route('EaCabCargaInicialController.index')->with(['success' => isset($success) ? $success : '',
                                                                             'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : '',
                                                                             'registros_no_cumplen' => isset($registros_no_cumplen) ? $registros_no_cumplen : '' ]);

    }


}
