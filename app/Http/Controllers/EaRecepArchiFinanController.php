<?php

namespace App\Http\Controllers;

use App\Models\EaBaseActiva;
use Illuminate\Http\Request;
use App\Models\EaCabeceraCargaCorp;
use App\Models\EaProducto;
use App\Models\EaSubproducto;
use App\Http\Controllers\EaClienteController;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\EaBaseActivaController;
use App\Imports\EaRecepArchiFinanImport;
use App\Http\Controllers\EaCabCargaInicialController;
use App\Http\Controllers\EaCabCargaInicialBitacoraController;
use App\Exports\EaSinInforFinancieraExport;


class EaRecepArchiFinanController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $clientes =  ( new EaClienteController)->getAllCampanas();
        $resumen_cabecera = (new EaCabCargaInicialController)->get_cabecera_carga_inicial_recaif('recepcion_infor_finan');

        return view ('recaif.home')->with(compact('clientes'))
                                   ->with( isset($resumen_cabecera) ? compact('resumen_cabecera') : '' );
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadArchivos(Request  $request)
    {

        $datosCab = $request->except('_token', 'subproducto', 'filtro_cliente', 'filtro_producto', 'filtro_subproducto', 'filtro_proce_carga' );
        $extension = $request->file('archivo')->extension();
        $obj_cab_carga_ini = (new EaCabCargaInicialController);

        if (isset($request->producto)) {
            # code...
            $productoDetalle = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
        }

        if (strtolower($extension) == 'xls' || strtolower($extension) == 'xlsx') {

            $datosCab['proceso'] = 'recepcion_infor_finan';
            $datosCab['usuario_registra'] = $request->usuario_registra;
            $datosCab['fec_registro'] = Date('d/m/Y H:i:s');
            $datosCab['desc_producto'] = isset($productoDetalle->desc_producto) ? $productoDetalle->desc_producto : '';
            $datosCab['estado'] = 'PENDIENTE';

            if (isset( $productoDetalle)) {
                $datosCab['desc_producto'] = $productoDetalle->desc_producto;
            }else {
                $datosCab['producto'] = '0';
                $datosCab['desc_producto'] = '';
            }


            if ($request->hasfile('archivo')) {
                $nombre_archivo = $request->file('archivo')->getClientOriginalName();
                $datosCab['archivo'] = $request->file('archivo')->storeAs('recepcion_infor_finan/'.$request->cliente, $nombre_archivo, 'public');
            }

            $existe_visible =  $obj_cab_carga_ini->valida_proceso_visible('recepcion_infor_finan');
            !$existe_visible ? $datosCab['visible'] ='S' : '';

            $obj_cab_carga_ini->update_datos_cab_carga($request->cliente, $request->cod_carga,  $datosCab );
            $rsp = (new EaCabCargaInicialBitacoraController)->create_bitacora($request->cod_carga);

            $success = "Archivo: ".$nombre_archivo.", del cliente: ".$request->cliente." cargado en estado pendiente de procesar." ;


        }else {
            $error = "Archivos permitidos: xls ó xlsx";
        }

        return redirect()->route('EaRecepArchiFinanController.index')->with(['success' => isset($success) ? $success : '',
                                                                             'error' => isset($error) ? $error : '' ]);

    }




    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function procesar(Request $request)
    {

        //Excel::import(new EaRecepArchiFinanImport($cod_carga), $registroCarga->archivo, 'public');
        //$fileout_banco_info = explode("/", substr($request->archivo , strpos($request->archivo, $request->cliente)) )[1];
        $producto = isset($request->producto) ? $request->producto : '';
        $obj_cab_carga_ini  = (new EaCabCargaInicialController);

        $import = (new EaRecepArchiFinanImport( $request->cod_carga, $request->cliente, $producto));
        $import->import($request->archivo, 'public');

        if ( !empty($import->detalle_proceso['errorTecnico']) ){

            $errorTecnico = $import->detalle_proceso['errorTecnico'];
            /* por error, dejo listo en cola para una proxima carga*/
            $obj_cab_carga_ini->update_proceso_cab_carga($request->cliente, $request->cod_carga, 'recepcion_infor_finan', 'generacion_infor_finan');

        }else {

            $cabecera_update['total_registros_archivo'] = isset($import->detalle_proceso['total_registros_archivo']) ? $import->detalle_proceso['total_registros_archivo'] : '' ;
            $cabecera_update['total_registros_sin_infor'] = isset($import->detalle_proceso['total_registros_sin_infor']) ? $import->detalle_proceso['total_registros_sin_infor'] : '' ;
            $cabecera_update['estado'] = 'PROCESADO';
            $cabecera_update['visible'] = 'N';

            $trx = $obj_cab_carga_ini->update_datos_cab_carga($request->cliente, $request->cod_carga, $cabecera_update);

            if ($trx) {

                $rsp = (new EaCabCargaInicialBitacoraController)->update_datos_cod_carga_bita( $request->cod_carga, $request->cliente, 'recepcion_provee_tmk', $cabecera_update);
                $nombre_archivo = explode("/" , substr( $request->archivo, stripos($request->archivo, $request->cliente)))[1];
                $success = "Carga realizada del archivo: ".$nombre_archivo.' ver detalles';
                Storage::disk('public')->delete($request->archivo);

            }

        }

        return redirect()->route('EaRecepArchiFinanController.index')->with(['success' => isset($success) ? $success : '',
                                                                             'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : '' ]);

    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EaCabeceraCargaCorp  $eaCabeceraCargaCorp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request )
    {
        $obj_cab_carga_ini = (new EaCabCargaInicialController);
        $registroCarga = $obj_cab_carga_ini->get_detalle_carga_corp($request->cod_carga);
        $pos_nombre_archivo = strpos($registroCarga->archivo, $registroCarga->cliente);
        $nombre_archivo = explode("/", substr($registroCarga->archivo, $pos_nombre_archivo) )[1];

        Storage::disk('public')->delete($registroCarga->archivo);
        EaCabeceraCargaCorp::where('cod_carga', $request->cod_carga)->update(['estado' => 'ELIMINADO', 'visible' => 'N']);

        $cod_carga_b = EaCabeceraCargaCorp::where('estado', 'PENDIENTE')
                                          ->where('proceso', 'recepcion_infor_finan')
                                          ->min('cod_carga');

        if ($cod_carga_b) {
            EaCabeceraCargaCorp::where('cod_carga', $cod_carga_b)->update(['visible' => 'S']);

        }else{
            # por error, o carga parcial lo dejo listo en cola para una proxima carga*/
            $obj_cab_carga_ini->update_proceso_cab_carga($registroCarga->cliente, $request->cod_carga, 'recepcion_provee_tmk', 'generacion_provee_tmk');
       }


        $error= 'Archivo de carga '.$nombre_archivo.'  eliminado del cliente: '.$registroCarga->cliente;

        return redirect()->route('EaRecepArchiFinanController.index')->with(compact('error'));
    }



    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export_sin_infor_finan($cod_carga)
    {

        $det_cab_carga = (new EaCabCargaInicialController)->get_detalle_carga_corp($cod_carga);
        $export_sin_infor_finan = new EaSinInforFinancieraExport($cod_carga);

        $descargar = $export_sin_infor_finan->download('SIN_INFOR_FINAN_'.$det_cab_carga->cliente.'_COD_CARGA_'.$det_cab_carga->cod_carga.'.xlsx');

        return $descargar;
    }


}
