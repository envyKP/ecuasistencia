<?php

namespace App\Http\Controllers;

use App\Models\EaCabeceraCargaCorp;
use Illuminate\Http\Request;
use App\Exports\EaGenAifExport;
use App\Models\EaBaseActiva;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\EaCabCargaInicialController;

class EaGenArchiFinanController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( )
    {

        $clientes =  ( new EaClienteController)->getAllCampanas();
        $resumen_cabecera = (new EaCabCargaInicialController)->get_cabecera_infor_finan();

        return view ('genaif.home')->with(compact('clientes'))
                                   ->with(compact('resumen_cabecera'))  ;
    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportar_archivo(Request $request)
    {

        $fecha = Date('Ymd');

        $carga_cab_detalle = (new EaCabCargaInicialController)->get_detalle_carga_corp($request->archivos);
        $filein_telemarketing= explode("/", substr( $carga_cab_detalle->archivo, strpos($carga_cab_detalle->archivo, $carga_cab_detalle->cliente)) )[1];

        if ( isset($request->producto)  &&  empty($carga_cab_detalle->producto) ) {
            # code...
            $producto_det = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
            (new EaBaseActivaController)->update_ba_producto_subproducto($request->cliente, $carga_cab_detalle->cod_carga, $producto_det->contrato_ama, $producto_det->desc_producto, $producto_det->subproducto );
            (new EaCabCargaInicialController)->edit_producto_cab_carga_inicial($carga_cab_detalle->cod_carga, $request->cliente, $request->producto);

        }else {
            $producto_det = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
        }


        $existe = (new EaBaseActivaController)->exists_ba_proceso_ciclo_3($request->cliente, $carga_cab_detalle->cod_carga, '3');

        if ( $existe ) {

            $producto = isset($request->producto) ? $producto_det->contrato_ama : '';
            $export = new EaGenAifExport($request->cliente, $carga_cab_detalle->cod_carga, $producto );

            $descarga = $export->download('INFORMACION_FINANCIERA_'.$request->cliente.'_'.$fecha.'.xlsx');

            $trx = (new EaBaseActivaController)->update_ba_estado_proceso_ciclo_4($request->cliente, $carga_cab_detalle->cod_carga, '3', '4',  'INFORMACION_FINANCIERA_'.$request->cliente.'_'.$fecha.'.xlsx' );

            if ($trx) {

                (new EaCabCargaInicialController)->update_proceso_cab_carga($request->cliente, $carga_cab_detalle->cod_carga, 'recepcion_provee_tmk', 'generacion_infor_finan');
                Storage::disk('public')->delete($carga_cab_detalle->archivo);
                //return ( new EaGenAifExport($request->cliente) )->download('FORMATO_ENVIO A PROVEEDOR TMK_'.$request->cliente.'.xlsx');

                return $descarga;

            }


        }else {

            return redirect()->route('EaGenArchiFinanController.index')->with(['error' => 'No existe información para descargar para el filtro '.$request->cliente ]);

        }


    }




    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request )
    {

        $registroCarga = EaCabeceraCargaCorp::where('cod_carga', $request->cod_carga)->first();

        if ( isset($registroCarga->archivo)) {
            $pos_nombre_archivo = strpos($registroCarga->archivo, $registroCarga->cliente);
            $nombre_archivo = explode("/", substr($registroCarga->archivo, $pos_nombre_archivo) )[1];
            Storage::disk('public')->delete($registroCarga->archivo);
        }


        EaCabeceraCargaCorp::where('cod_carga', $request->cod_carga)->delete();

        $cod_carga_b = EaCabeceraCargaCorp::where('estado', 'PENDIENTE')
                                          ->where('proceso', 'generacion_provee_tmk')
                                          ->min('cod_carga');

        if ($cod_carga_b) {
            EaCabeceraCargaCorp::where('cod_carga', $cod_carga_b)->update(['visible' => 'S']);
        }


        $error= 'Registro y archivo de carga '.$nombre_archivo.'   eliminado del cliente: '.$registroCarga->cliente;

        return redirect()->route('EaGenArchiFinanController.index')->with(compact('error'));

    }

}
