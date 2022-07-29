<?php

namespace App\Http\Controllers;

use App\Models\EaCabeceraCargaCorp;
use App\Models\EaCabeceraCargaCorpBitacora;
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
use App\Models\EaCliente;

class EaCargaIndividualImport extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes =  (new EaClienteController)->getAllCampanas();

        $resumen_cabecera = EaCabeceraCargaCorpBitacora::orderBydesc('fec_registro')->where('is_det_debito', '1')
            ->paginate(15);
        return view('cargaIndividualI.home')->with(compact('clientes'))
            ->with(isset($resumen_cabecera) ? compact('resumen_cabecera') : '');
    }

    public function detalleCarga()
    {
       
        return view('cargaIndividualI.detalleCarga');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        return redirect()->route('EaClienteController.index')->with([
            'cliente' => $request->cliente,
            'trxcliente' => 'store'
        ]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadArchivos(Request  $request)
    {
        // los datos que envia el request $request->cod_carga  $request->cliente  $request->producto  $request->desc_producto
        // fec_carga ---> utilizado para insertar la ultima fecha en la que se realizo la carga
        $datosCab = $request->except('_token', 'filtro_cliente', 'filtro_producto', 'filtro_genera', 'estado_cabecera', 'registros_no_cumplen', 'row');
        $fecha = Date('Y-m-d');
        $productoDetalle = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
        $extension = $request->file('archivo')->extension();
        //dd($datosCab);
        //modificacion     para adjuntar txt
        if (strtolower($extension) == 'xls' || strtolower($extension) == 'xlsx') {
            $datosCab['fec_carga'] = Date('Y-m-d H:i:s');
            if ($request->hasfile('archivo')) {
                $nombre_archivo = $request->file('archivo')->getClientOriginalName();
                $datosCab['archivo'] = $request->file('archivo')->storeAs('lecturaDebito/' . $request->cliente, $nombre_archivo, 'public');
            }
            $trx = EaCabeceraCargaCorpBitacora::where('desc_producto', (isset($datosCab['desc_producto']) ? $datosCab['desc_producto'] : ''))
                ->where('producto', (isset($datosCab['producto']) ? $datosCab['producto'] : ''))
                ->where('cliente', (isset($datosCab['cliente']) ? $datosCab['cliente'] : ''))
                ->where('cod_carga', (isset($datosCab['cod_carga']) ? $datosCab['cod_carga'] : ''))
                ->update($datosCab);
            if ($trx) {
                //$rsp = (new EaCabCargaInicialBitacoraController)->create_bitacora($datosCab['cod_carga']);
                $success = "Archivo: " . $nombre_archivo . ", del cliente: " . $request->cliente . " cargado en estado pendiente de procesar.";
            }
        } else {
            $error = "Archivos permitidos: xls ó xlsx";
        }
        $cod_carga = isset($request->cod_carga) ? $request->cod_carga : '';
            $cliente = isset($request->cliente) ? $request->cliente : '';
            $producto = isset($request->producto) ? $request->producto  : '';
            $row = isset($request->cod_carga) ? $request->cod_carga : '';
            $data = isset($request->cod_carga) ? $request->cod_carga : '';
            $carga_resp = isset($request->cod_carga) ? $request->cod_carga : '';
            $estado_cabecera =isset($request->estado) ? $request->estado : '';
            $desc_producto =isset($request->desc_producto) ? $request->desc_producto : '';
            $success = isset($success) ? $success : '';
            $error = isset($error) ? $error : '';
            $registros_no_cumplen = isset($request->registros_no_cumplen) ? $request->registros_no_cumplen : '';
            //return 'ok';
            return redirect()->route('EaCargaIndividualImport.index');
        /*return view('cargaIndividualI.detalleCarga')
        ->with(isset($cod_carga) ? compact('cod_carga') : '')
        ->with(isset($row) ? compact('row') : '')
        ->with(isset($cliente) ? compact('cliente') : '')
        ->with(isset($producto) ? compact('producto') : '')
        ->with(isset($data) ? compact('data') : '')
        ->with(isset($carga_resp) ? compact('carga_resp') : '')
        ->with(isset($estado_cabecera) ? compact('estado_cabecera') : '')
        ->with(isset($desc_producto) ? compact('desc_producto') : '')
        ->with(isset($success) ? compact('success') : '')
        ->with(isset($error) ? compact('error') : '')
        ->with(isset($registros_no_cumplen) ? compact('registros_no_cumplen') : '');
       */
       /* return redirect()->route('EaCargaIndividualImport.detalleCarga')->with([
            'cod_carga' => isset($request->cod_carga) ? $request->cod_carga : '',
            'cliente' => isset($request->cliente) ? $request->cliente : '',
            'producto' => isset($request->producto) ? $request->producto  : '',
            'row' => isset($request->cod_carga) ? $request->cod_carga : '',
            'data' => isset($request->cod_carga) ? $request->cod_carga : '',
            'carga_resp' => isset($request->cod_carga) ? $request->cod_carga : '',
            'estado_cabecera' => isset($request->estado) ? $request->estado : '',
            'desc_producto' => isset($request->desc_producto) ? $request->desc_producto : '',
            'success' => isset($success) ? $success : '',
            'error' => isset($error) ? $error : ''
        ]);*/
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
        $import = (new EaDetCargaCorpImport($request->cod_carga, $registroCarga->cliente, $registroCarga->producto));
        $import->import($registroCarga->archivo, 'public');
        if (!empty($import->detalle_proceso['errorTecnico'])) {
            $cabecera_update['estado'] = 'ERROR';
            $cabecera_update['visible'] = 'N';
            $errorTecnico = $import->detalle_proceso['errorTecnico'];
            $trx = $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $cabecera_update);
        } else {
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
                $this->update_cola_proceso_visible('PENDIENTE', 'carga_inicial');
                $rsp = (new EaCabCargaInicialBitacoraController)->update_datos_cod_carga_bita($request->cod_carga, $registroCarga->cliente, 'carga_inicial', $cabecera_update);
                $nombre_archivo = explode("/", substr($registroCarga->archivo, stripos($registroCarga->archivo, $registroCarga->cliente)))[1];
                $registros_no_cumplen = isset($import->detalle_proceso['registros_no_cumplen']) ? $import->detalle_proceso['registros_no_cumplen'] : '';
                $success = "Carga realizada del archivo: " . $nombre_archivo . ' ver detalles';
            }
        }
        return redirect()->route('cargaIndividualI.home.index')->with([
            'success' => isset($success) ? $success : '',
            'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : '',
            'registros_no_cumplen' => isset($registros_no_cumplen) ? $registros_no_cumplen : ''
        ]);
    }
    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
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
            # code...
            (new EaDetalleCargaCorpController)->truncate($request->cod_carga, $registroCarga->cliente);
        }
        $cod_carga_b = EaCabeceraCargaCorp::where('estado', 'PENDIENTE')
            ->where('proceso', 'carga_inicial')
            ->min('cod_carga');
        if ($cod_carga_b) {
            EaCabeceraCargaCorp::where('cod_carga', $cod_carga_b)->update(['visible' => 'S']);
        }
        $error = 'Registros temporales del código de carga: ' . $request->cod_carga . '  eliminado del cliente: ' . $registroCarga->cliente;
        return redirect()->route('cargaIndividualI.home.index')->with(compact('error'));
    }
}
