<?php

namespace App\Http\Controllers;


use App\Models\EaCabeceraDetalleCarga;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\EaClienteController;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EaGemCamImport;
use App\Http\Controllers\EaBaseActivaController;
use App\Http\Controllers\EaProductoController;
use App\Http\Controllers\EaCabCargaInicialBitacoraController;
use App\Http\Controllers\EaDetalleCargaCorpController;
use App\Exports\EaReporteCargaInicialExport;
use App\Models\EaCliente;
use App\Exports\EaGenCamExport;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Search;

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

        $resumen_cabecera = EaCabeceraDetalleCarga::orderBydesc('fec_registro')->where('is_det_debito', '1')
            ->paginate(15);
        return view('cargaIndividualI.home')->with(compact('clientes'))
            ->with(isset($resumen_cabecera) ? compact('resumen_cabecera') : '');
    }

    public function detalleCarga()
    {

        return view('cargaIndividualI.detalleCarga');
    }

    public function search($request)
    {
        // $logFile = 'import.log';
        //Log::useDailyFiles(storage_path().'/logs/'.$logFile);
        //Log::info('This is some useful information.');
        //Log::warning('Something could be going wrong.');
        //Log::error('Something is really going wrong.');
        if (is_null($request->cliente) && is_null($request->producto)) {
            $msj = "Debe seleccionar al menos un filtro";
            $error = "sinFiltro";
        } else if (strcmp($request->filtro2, 'cliente') === 0  &&  strcmp($request->filtro3, 'producto') === 0 && strcmp($request->filtro4, 'subproducto') === 0) {
            $subproducto = (new EaSubproductoController)->getSubproductoDetalle($request->cliente, $request->subproductoCMB);
            $dataBusqueda = $this->getClientesHistCampaProdSub($request, $subproducto->desc_subproducto);
            if (is_null($dataBusqueda)) {
                $error = "notData";
                $msj = "No existe informacion para el filtro: subproducto ";
            } else {
                $msj = "Cliente: " . $request->cliente . " Producto: " . $request->productoCMB . " Subproducto: " . $subproducto->desc_subproducto;
            }
        } else if (strcmp($request->filtro2, 'cliente') === 0 &&  strcmp($request->filtro3, 'producto') === 0) {
            $dataBusqueda = $this->getClientesHistCampaProduc($request);
            if (is_null($dataBusqueda)) {
                $error = "notData";
                $msj = "No existe informacion para el filtro: producto ";
            } else {
                $msj = "Cliente: " . $request->cliente . " Producto: " . $request->productoCMB;
            }
        } else if (strcmp($request->filtro2, 'cliente') === 0) {
            $dataBusqueda = $this->getClienteHistcampana($request);
            if (is_null($dataBusqueda)) {
                $error = "notData";
                $msj = "No existe informacion para el filtro de búsqueda: Cliente " . $request->cliente;
            } else {
                $msj = "Cliente: " . $request->cliente;
            }
        }
        if (strcmp($request->filtro1, 'cedula_id') === 0  && is_null($request->cedula_id)) {
            $msj = "Ingrese una identificación";
            $error = "sinFiltro";
        } else if (strcmp($request->filtro1, 'cedula_id') === 0) {
            $msj = 'Identificación: ' . $request->cedula_id;
            $dataBusqueda =  $this->getClienteHistced($request);
            if (is_null($dataBusqueda)) {
                $error = "notData";
                $msj = 'No existe informacion para la identificación: ' . $request->cedula_id;
            }
        }
        return redirect()->route('cargaIndividualI.home')->with([
            'filtro' => isset($msj) ? $msj : '',
            'data' => isset($dataBusqueda) ? $dataBusqueda : '',
            'error' => isset($error) ? $error : ''
        ]);
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
        //dd($request);
        $fecha = Date('Y-m-d');
        $productoDetalle = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
        $extension = $request->file('archivo')->extension();
        //dd($datosCab);
        //modificacion     para adjuntar txt
        if (strtolower($extension) == 'xls' || strtolower($extension) == 'xlsx') {
            $datosCab['fec_carga'] = Date('d/m/Y H:i:s');
            if ($request->hasfile('archivo')) {
                $nombre_archivo = $request->file('archivo')->getClientOriginalName();
                $datosCab['archivo'] = $request->file('archivo')->storeAs('lecturaDebito/' . $request->cliente . '/' . $request->desc_producto . '/' . $request->cod_carga, $nombre_archivo, 'public');
            }
            $trx = EaCabeceraDetalleCarga::where('desc_producto', (isset($datosCab['desc_producto']) ? $datosCab['desc_producto'] : ''))
                ->where('producto', (isset($datosCab['producto']) ? $datosCab['producto'] : ''))
                ->where('cliente', (isset($datosCab['cliente']) ? $datosCab['cliente'] : ''))
                ->where('cod_carga', (isset($datosCab['cod_carga']) ? $datosCab['cod_carga'] : ''))
                ->update($datosCab);
            if ($trx) {
                //$rsp = (new EaCabCargaInicialBitacoraController)->create_bitacora($datosCab['cod_carga']);
                $success = "Archivo: " . $nombre_archivo . ", del cliente: " . $request->cliente . " cargado en estado pendiente de guardar/procesar.";
            }
        } else {
            $error = "Archivos permitidos: xls ó xlsx";
        }
        //$cod_carga = isset($request->cod_carga) ? $request->cod_carga : '';
        //$cliente = isset($request->cliente) ? $request->cliente : '';
        //$producto = isset($request->producto) ? $request->producto  : '';
        //$row = isset($request->cod_carga) ? $request->cod_carga : '';
        //$data = isset($request->cod_carga) ? $request->cod_carga : '';
        //$carga_resp = isset($request->cod_carga) ? $request->cod_carga : '';
        $detalle_proceso['estado_cabecera'] = isset($request->estado) ? $request->estado : '';
        $detalle_proceso['desc_producto'] = isset($request->desc_producto) ? $request->desc_producto : '';
        $detalle_proceso['success'] = isset($success) ? $success : '';
        $detalle_proceso['error'] = isset($error) ? $error : '';
        $detalle_proceso['mensaje'] = isset($success) ? $success : $error;
        $detalle_proceso['registros_no_cumplen'] = isset($request->registros_no_cumplen) ? $request->registros_no_cumplen : '';
        //return 'ok';
        //return response()->json(['success' => 'Contact form submitted successfully']);
        //dd(response()->json($detalle_proceso));
        return response()->json($detalle_proceso);

        //return redirect()->route('EaCargaIndividualImport.index');

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
        $registroCarga = EaCabeceraDetalleCarga::where('cod_carga', $request->cod_carga)
            ->where('cliente', $request->cliente)
            ->where('producto', $request->producto)->first();
        $import = (new EaGemCamImport($request->cod_carga, $request->cliente, $request->producto));
        $import->import($registroCarga->archivo, 'public');
        //dd($import);
        if (!empty($import->detalle_proceso['errorTecnico'])) {
            $cabecera_update['estado'] = 'ERROR';
            $errorTecnico = $import->detalle_proceso['errorTecnico'];

            $trx = $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $request->producto, $cabecera_update);
        } else {
            try {
                $cabecera_update['estado'] = 'PROCESADO';
                $update_cab_carga =  $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $request->producto, $cabecera_update);
            } catch (\Exception $e) {

                $errorTecnico = $e->getMessage();
            }
        }

        return response()->json(['success' => 'Procesado Existosamente']);
    }
    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function procesar_respaldo(Request $request)
    {
        echo 'llegaste hasta aki extraño';
        dd($request);
        $cabecera_update = array();
        $registroCarga = EaCabeceraDetalleCarga::where('cod_carga', $request->cod_carga)
            ->where('cliente', $request->cliente)
            ->where('producto', $request->producto)->first();

        //$registroCarga = EaCabeceraCargaCorp::where('cod_carga', $request->cod_carga)->first();
        //Excel::import(new EaDetCargaCorpImport($cod_carga), $registroCarga->archivo, 'public');
        $import = (new EaGemCamImport($request->cod_carga, $request->cliente, $request->producto));
        $import->import($registroCarga->archivo, 'public');
        if (!empty($import->detalle_proceso['errorTecnico'])) {
            $cabecera_update['estado'] = 'ERROR';
            //$cabecera_update['visible'] = 'N';
            $errorTecnico = $import->detalle_proceso['errorTecnico'];
            $trx = $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $request->producto, $cabecera_update);
        } else {

            try {
                $update_cab_carga =  $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $request->producto, $cabecera_update);
            } catch (\Exception $e) {
                $errorTecnico = $e->getMessage();
            }
            if ($update_cab_carga) {
                //$this->update_cola_proceso_visible('PENDIENTE', 'carga_inicial');
                $rsp = (new EaCabCargaInicialBitacoraController)->update_datos_cod_carga_bita($request->cod_carga, $request->cliente, 'carga_inicial', $cabecera_update);

                $nombre_archivo = explode("/", substr($registroCarga->archivo, stripos($registroCarga->archivo, $request->cliente)))[1];
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
    public function update_datos_cab_carga($cliente, $cod_carga, $producto, array $datos)
    {

        $trx =  EaCabeceraDetalleCarga::where('cliente', $cliente)
            ->where('cod_carga', $cod_carga)
            ->where('producto', $producto)
            ->update($datos);
        return $trx;
    }


    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function existe_duplicado($cliente, $cod_carga, $producto, array $datos)
    {

        $trx =  EaCabeceraDetalleCarga::where('cliente', $cliente)
            ->where('cod_carga', $cod_carga)
            ->where('producto', $producto)
            ->update($datos);
        return $trx;
    }



    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request)
    {
        \Log::info('FUNCION DESTROY: ');
        \Log::warning('usuario que realiza la orden DESTROY: ' . \Auth::user()->username);
        // \Log::warning('Something could be going wrong.');
        // \Log::error('Something is really going wrong.');
        $varcontrolsecuencia = (isset($request->carga_resp) ? strval($request->carga_resp) : null);
        $detalle_subproducto = ((new EaSubproductoController)->getSubproductoDetalle($request->cliente, $request->producto));
        $objEXPORT = new EaGenCamExport($request->cliente, $detalle_subproducto->desc_subproducto, $varcontrolsecuencia, $request->producto);
        \Log::info('Request : ');
        \Log::info('    $request->cliente : ' . $request->cliente);
        \Log::info('    $request->producto : ' . $request->producto);
        \Log::info('    varcontrolsecuencia : ' . $varcontrolsecuencia);
        $row_insert_detalle['id_carga'] = $request->carga_resp;
        $row_insert_detalle['producto'] = $request->producto;
        $row_insert_detalle['subproducto'] = $request->producto;
        $row_insert_detalle['cliente'] = $request->cliente;
        $row_insert_detalle['estado'] = "0";
        //dd($objEXPORT->is_carga_older());
        if($varcontrolsecuencia == ($objEXPORT->is_carga_older()->id_carga)){
            \Log::warning('se destruyo la carga :'.$row_insert_detalle['id_carga']);
            $objEXPORT->destroy_cab_detalle($varcontrolsecuencia,$request->cliente,$request->producto);
            $success = 'Borrado registros de : Id_carga'. $row_insert_detalle['id_carga'].' cliente-'. $row_insert_detalle['cliente'].' producto : '.$detalle_subproducto->desc_subproducto;
        }else{
            \Log::info('No pudo destruirse la carga');
            $errorTecnico= 'disculpe el inconveniente no pudo eliminarse el reguistro por favor compruebe que no existe una carga superior al registro que desea eliminar';
        }
        
        return redirect()->route('EaCargaIndividualImport.index')->with([
            'success' => isset($success) ? $success : '',
            'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : ''
        ]);
    }
}
