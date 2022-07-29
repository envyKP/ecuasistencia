<?php

namespace App\Http\Controllers;

use App\Models\EaCabeceraCargaCorp;
use App\Models\EaProducto;
use App\Models\EaSubproducto;
use Illuminate\Http\Request;
use App\Http\Controllers\EaClienteController;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EaRecepArchiProveImport;
use App\Http\Controllers\EaBaseActivaController;
use App\Http\Controllers\EaCabCargaInicialController;

class EaRecepArchiProveTmkController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes =  (new EaClienteController)->getAllCampanas();
        $resumen_cabecera = (new EaCabCargaInicialController)->get_cabecera_carga_inicial_recapt('recepcion_provee_tmk');

        return view('recapt.home')->with(compact('clientes'))
            ->with(isset($resumen_cabecera) ? compact('resumen_cabecera') : '');
    }




    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function procesar(Request $request)
    {


        //Excel::import(new EaRecepArchiProveImport($cod_carga, $registroCarga->cliente), $registroCarga->archivo, 'public');
        $cabecera_update = array();
        $obj_cab_carga_ini =  (new EaCabCargaInicialController);
        $fileout_telemarketing = explode("/", substr($request->archivo, strpos($request->archivo, $request->cliente)))[1];
        $producto = isset($request->producto) ? $request->producto : '';
        $no_ejecucion = isset($request->no_ejecucion) ?  $request->no_ejecucion : '';

        if (is_null($request->no_ejecucion) || $request->no_ejecucion == '1') {
            # code...
            $import = (new EaRecepArchiProveImport($request->cod_carga, $request->cliente, $fileout_telemarketing, $producto, $request->tipo_carga, $no_ejecucion));
            $import->import($request->archivo, 'public');

            if (!empty($import->detalle_proceso['errorTecnico'])) {

                $errorTecnico = $import->detalle_proceso['errorTecnico'];
                /* por error, o carga parcial lo dejo listo en cola para una proxima carga*/
                $obj_cab_carga_ini->update_proceso_cab_carga($request->cliente, $request->cod_carga, 'recepcion_provee_tmk', 'generacion_provee_tmk');
            } else {

                $cabecera_update['total_registros_aceptan'] = isset($import->detalle_proceso['total_registros_aceptan']) ? $import->detalle_proceso['total_registros_aceptan'] : '';
                $cabecera_update['total_otros_call_types']  = isset($import->detalle_proceso['total_otros_call_types']) ? $import->detalle_proceso['total_otros_call_types'] : '';
                $cabecera_update['total_registros_archivo'] = isset($import->detalle_proceso['total_registros_archivo']) ? $import->detalle_proceso['total_registros_archivo'] : '';
                $cabecera_update['total_registros_sin_infor'] = isset($import->detalle_proceso['total_registros_sin_infor']) ? $import->detalle_proceso['total_registros_sin_infor'] : '';

                if (strcmp($request->tipo_carga, 'parcial') == 0) {

                    $cabecera_update['estado'] = 'PROCESADO';

                    if (is_null($request->no_ejecucion)) {

                        $cabecera_update['no_ejecucion'] = '1';
                        $cabecera_update['visible'] = 'S';

                        # por error, o carga parcial lo dejo listo en cola para una proxima carga*/
                        $obj_cab_carga_ini->update_proceso_cab_carga($request->cliente, $request->cod_carga, 'recepcion_provee_tmk', 'generacion_provee_tmk');
                    } else if ($request->no_ejecucion == '1') {

                        $cabecera_update['no_ejecucion'] = '2';
                        $cabecera_update['visible'] = 'N';
                    }
                } else if (strcmp($request->tipo_carga, 'total') == 0) {

                    $cabecera_update['no_ejecucion'] = '2';
                    $cabecera_update['estado'] = 'PROCESADO';
                    $cabecera_update['visible'] = 'N';
                }


                $trx = $obj_cab_carga_ini->update_datos_cab_carga($request->cliente, $request->cod_carga, $cabecera_update);

                if ($trx) {
                    $rsp = (new EaCabCargaInicialBitacoraController)->update_datos_cod_carga_bita($request->cod_carga, $request->cliente, 'recepcion_provee_tmk', $cabecera_update);
                    $nombre_archivo = explode("/", substr($request->archivo, stripos($request->archivo, $request->cliente)))[1];
                    $success = "Carga realizada del archivo: " . $nombre_archivo . ' ver detalles';
                }
            }
        }

        return redirect()->route('EaRecepArchiProveTmkController.index')->with([
            'success' => isset($success) ? $success : '',
            'error' => isset($errorTecnico) ?  $errorTecnico  : ''
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadArchivos(Request  $request)
    {
        $datosCab = $request->except('_token', 'filtro_cliente', 'filtro_producto', 'filtro_proce_carga');
        $extension = $request->file('archivo')->extension();
        $fecha = Date('Ymd');
        $obj_cab_carga_ini = (new EaCabCargaInicialController);
        if (isset($request->producto)) {
            # code...
            $productoDetalle = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
            $datosCab['desc_producto'] = $productoDetalle->desc_producto;
        } else {
            $datosCab['producto'] = '';
            $datosCab['desc_producto'] = '';
        }
        if (strtolower($extension) == 'xls' || strtolower($extension) == 'xlsx') {
            $datosCab['proceso'] = 'recepcion_provee_tmk';
            $datosCab['usuario_registra'] = $request->usuario_registra;
            $datosCab['fec_registro'] = Date('d/m/Y H:i:s');
            $datosCab['fec_carga'] = $fecha;
            $datosCab['estado'] = 'PENDIENTE';
            if ($request->hasfile('archivo')) {
                $nombre_archivo = $request->file('archivo')->getClientOriginalName();
                $datosCab['archivo'] = $request->file('archivo')->storeAs('recepcion_provee_tmk/' . $request->cliente, $nombre_archivo, 'public');
            }
            $existe_visible =  $obj_cab_carga_ini->valida_proceso_visible('recepcion_provee_tmk');
            !$existe_visible ? $datosCab['visible'] = 'S' : '';
            $obj_cab_carga_ini->update_datos_cab_carga($request->cliente, $request->cod_carga,  $datosCab);
            $rsp = (new EaCabCargaInicialBitacoraController)->create_bitacora($request->cod_carga);
            $success = "Archivo: " . $nombre_archivo . ", del cliente: " . $request->cliente . " cargado en estado pendiente de procesar.";
        } else {
            $error = "Archivos permitidos: xls ó xlsx";
        }
        return redirect()->route('EaRecepArchiProveTmkController.index')->with([
            'success' => isset($success) ? $success : '',
            'error' => isset($error) ? $error : ''
        ]);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EaCabeceraCargaCorp  $eaCabeceraCargaCorp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $obj_cab_carga_ini = (new EaCabCargaInicialController);
        $registroCarga = $obj_cab_carga_ini->get_detalle_carga_corp($request->cod_carga);
        $pos_nombre_archivo = strpos($registroCarga->archivo, $registroCarga->cliente);
        $nombre_archivo = explode("/", substr($registroCarga->archivo, $pos_nombre_archivo))[1];

        Storage::disk('public')->delete($registroCarga->archivo);
        EaCabeceraCargaCorp::where('cod_carga', $request->cod_carga)->update(['estado' => 'ELIMINADO', 'visible' => 'N']);

        $cod_carga_b = EaCabeceraCargaCorp::where('estado', 'PENDIENTE')
            ->where('proceso', 'recepcion_provee_tmk')
            ->min('cod_carga');

        if ($cod_carga_b) {

            EaCabeceraCargaCorp::where('cod_carga', $cod_carga_b)->update(['visible' => 'S']);
        } else {
            # por error, o carga parcial lo dejo listo en cola para una proxima carga*/
            $obj_cab_carga_ini->update_proceso_cab_carga($registroCarga->cliente, $request->cod_carga, 'recepcion_provee_tmk', 'generacion_provee_tmk');
        }


        $error = 'Registro y archivo de carga ' . $nombre_archivo . '  eliminado del cliente: ' . $registroCarga->cliente;

        return redirect()->route('EaRecepArchiProveTmkController.index')->with(compact('error'));
    }
}
