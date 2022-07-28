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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
        // fec_carga ---> utilizado para insertar la ultima fecha en la que se realizo la carga
        $datosCab = $request->except('_token', 'filtro_cliente', 'filtro_producto', 'filtro_genera');
        $fecha = Date('Y-m-d');
        $productoDetalle = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
        $extension = $request->file('archivo')->extension();
        //modificacion     para adjuntar txt
        if (strtolower($extension) == 'xls' || strtolower($extension) == 'xlsx') {
            $datosCab['fec_carga'] = Date('Y-m-d H:i:s');

            if ($request->hasfile('archivo')) {
                $nombre_archivo = $request->file('archivo')->getClientOriginalName();
                $datosCab['archivo'] = $request->file('archivo')->storeAs('lecturaDebito/' . $request->cliente, $nombre_archivo, 'public');
            }

            $trx = EaCabeceraCargaCorpBitacora::where('desc_producto', (isset($datosCab['desc_producto']) ? $datosCab['desc_producto'] : ''))->update($datosCab);
            if ($trx) {
                $rsp = (new EaCabCargaInicialBitacoraController)->create_bitacora($datosCab['cod_carga']);
                $success = "Archivo: " . $nombre_archivo . ", del cliente: " . $request->cliente . " cargado en estado pendiente de procesar.";
            }
        } else {
            $error = "Archivos permitidos: xls ó xlsx";
        }
        return redirect()->route('EaCargaIndividualImport.index')->with([
            'success' => isset($success) ? $success : '',
            'error' => isset($error) ? $error : ''
        ]);
    }
}
