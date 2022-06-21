<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EaCabeceraCargaCorp;
use Maatwebsite\Excel\Excel;
use App\Exports\EaGenAptExport;
use App\Http\Controllers\EaCabCargaInicialController;
use App\Http\Controllers\EaBaseActivaController;
use Illuminate\Support\Facades\Storage;
use Session;


class EaGenArchiProveTmkController extends Controller
{


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $clientes =  ( new EaClienteController)->getAllCampanas();
        $resumen_cabecera = ( new EaCabCargaInicialController)->ListGenArchivosProveetmk();


            return view ('genapt.home')->with(compact('clientes'))
                                       ->with(compact('resumen_cabecera'));

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
        $cab_detalle_carga = (new EaCabCargaInicialController)->get_detalle_carga_corp($request->archivos);

        if ( isset($request->producto) && empty($cab_detalle_carga->producto) ) {
            # code...
            $producto_det = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
            (new EaBaseActivaController)->update_ba_producto_subproducto($request->cliente, $cab_detalle_carga->cod_carga, $producto_det->contrato_ama, $producto_det->desc_producto, $producto_det->subproducto );
            (new EaCabCargaInicialController)->edit_producto_cab_carga_inicial($cab_detalle_carga->cod_carga, $request->cliente, $request->producto);

        }else {

            $producto_det = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
        }

        $producto = isset ($request->producto) ? $producto_det->contrato_ama : '';
        $existe = (new EaBaseActivaController)->exists_base_activa_carga_inicial($cab_detalle_carga->cliente, $cab_detalle_carga->cod_carga, '1');

        if ( $existe ) {

            $export = new EaGenAptExport($request->cliente, $cab_detalle_carga->cod_carga, $producto);
            $nombre_archivo_generado = 'ENVIO_A_PROVEEDOR_'.$cab_detalle_carga->cliente.'_'.$fecha.'.xlsx';

            $descarga = $export->download($nombre_archivo_generado);

            $trx = (new EaBaseActivaController)->update_ba_estado_proceso_ciclo_2($cab_detalle_carga->cliente, $cab_detalle_carga->cod_carga, '1', '2', $nombre_archivo_generado );

            if ( $trx ) {

                (new EaCabCargaInicialController)->update_proceso_cab_carga( $cab_detalle_carga->cliente, $cab_detalle_carga->cod_carga, 'carga_inicial', 'generacion_provee_tmk');
                Storage::disk('public')->delete($cab_detalle_carga->archivo);
                //return ( new EaGenAptExport($request->cliente) )->download('FORMATO_ENVIO A PROVEEDOR TMK_'.$request->cliente.'.xlsx');

                return $descarga;

            }


        }else {

           return redirect()->route('EaGenArchiProveTmkController.index')->with(['error' => 'No existe información para descargar para el filtro '.$carga_cab_detalle->cliente ]);

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

        if (isset($registroCarga->archivo)) {
            # code...
            $pos_nombre_archivo = strpos($registroCarga->archivo, $registroCarga->cliente);
            $nombre_archivo = explode("/", substr($registroCarga->archivo, $pos_nombre_archivo) )[1];
        }

        Storage::disk('public')->delete($registroCarga->archivo);
        EaCabeceraCargaCorp::where('cod_carga', $request->cod_carga)->delete();

        $cod_carga_b = EaCabeceraCargaCorp::where('estado', 'PENDIENTE')
                                          ->where('proceso', 'generacion_provee_tmk')
                                          ->min('cod_carga');

        if ($cod_carga_b) {
            EaCabeceraCargaCorp::where('cod_carga', $cod_carga_b)->update(['visible' => 'S']);
        }


        $error= 'Registro y archivo de carga '.$nombre_archivo.'   eliminado del cliente: '.$registroCarga->cliente;

        return redirect()->route('EaGenArchiProveTmkController.index')->with(compact('error'));

    }


}
