<?php

namespace App\Http\Controllers;


use App\Models\EaCabeceraDetalleCarga;
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
        $datosCab = $request->except('_token', 'filtro_cliente', 'filtro_producto', 'filtro_genera', 'estado_cabecera', 'registros_no_cumplen', 'row');

        $fecha = Date('Y-m-d');
        $productoDetalle = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
        $extension = $request->file('archivo')->extension();

        if (strtolower($extension) == 'xls' || strtolower($extension) == 'xlsx') {
            $datosCab['fec_carga'] = Date('d/m/Y H:i:s');
            if ($request->hasfile('archivo')) {
                $nombre_archivo = $request->file('archivo')->getClientOriginalName();
                $descripcion = preg_replace('([^A-Za-z0-9 ])', '', $request->desc_producto);
                $datosCab['archivo'] = $request->file('archivo')->storeAs('lecturaDebito/' . $request->cliente . '/' . $descripcion . '/' . $request->cod_carga, $nombre_archivo, 'public');
            }
            $trx = EaCabeceraDetalleCarga::where('desc_producto', (isset($datosCab['desc_producto']) ? $datosCab['desc_producto'] : ''))
                ->where('producto', (isset($datosCab['producto']) ? $datosCab['producto'] : ''))
                ->where('cliente', (isset($datosCab['cliente']) ? $datosCab['cliente'] : ''))
                ->where('cod_carga', (isset($datosCab['cod_carga']) ? $datosCab['cod_carga'] : ''))
                ->update($datosCab);
            if ($trx) {

                $success = "Archivo: " . $nombre_archivo . ", del cliente: " . $request->cliente . " cargado en estado pendiente de guardar/procesar.";
            }
        } else {
            $error = "Archivos permitidos: xls o xlsx";
        }

        $detalle_proceso['estado_cabecera'] = isset($request->estado) ? $request->estado : '';
        $detalle_proceso['desc_producto'] = isset($request->desc_producto) ? $request->desc_producto : '';
        $detalle_proceso['success'] = isset($success) ? $success : '';
        $detalle_proceso['error'] = isset($error) ? $error : '';
        $detalle_proceso['mensaje'] = isset($success) ? $success : $error;
        $detalle_proceso['registros_no_cumplen'] = isset($request->registros_no_cumplen) ? $request->registros_no_cumplen : '';
        return response()->json($detalle_proceso);
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
        $objEXPORT = new EaGenCamExport($request->cliente, $detalle_subproducto->desc_subproducto, $varcontrolsecuencia, $request->producto, $detalle_subproducto->tipo_subproducto);
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
        if ($varcontrolsecuencia == ($objEXPORT->is_carga_older()->id_carga)) {
            \Log::warning('se destruyo la carga :' . $row_insert_detalle['id_carga']);
            $objEXPORT->destroy_cab_detalle($varcontrolsecuencia, $request->cliente, $request->producto);
            $success = 'Borrado registros de : Id_carga' . $row_insert_detalle['id_carga'] . ' cliente-' . $row_insert_detalle['cliente'] . ' producto : ' . $detalle_subproducto->desc_subproducto;
        } else {
            \Log::info('No pudo destruirse la carga');
            $errorTecnico = 'disculpe el inconveniente no pudo eliminarse el reguistro por favor compruebe que no existe una carga superior al registro que desea eliminar';
        }

        return redirect()->route('EaCargaIndividualImport.index')->with([
            'success' => isset($success) ? $success : '',
            'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : ''
        ]);
    }
}
