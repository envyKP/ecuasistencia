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

        $resumen_cabecera = EaCabeceraCargaCorpBitacora::orderBydesc('cod_carga')->where('is_det_debito', '1')
            ->paginate(15);

        // dd($resumen_cabecera);
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
        $datosCliente = $request->except('_token', '_method');
        $datosCliente['estado'] = "A";

        $idCliente = EaCliente::All()->max('id_cliente');

        if (isset($idCliente) && $idCliente !== 1) {
            $idCliente++;
            $datosCliente['id_cliente'] = $idCliente;
        } else {
            $datosCliente['id_cliente'] = 1;
        }


        if ($request->hasfile('logotipo')) {

            $nombre_archivo = $request->file('logotipo')->getClientOriginalName();
            $datosCliente['logotipo'] = $request->file('logotipo')->storeAs('LogosClientes', $nombre_archivo, 'public');
        }

        EaCliente::insert($datosCliente);

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
        //no nescesario ---
        $datosCab = $request->except('_token', 'subproducto', 'filtro_cliente', 'filtro_producto', 'filtro_subproducto');
        $fecha = Date('Ymd');
        //$productoDetalle = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
        $extension = $request->file('archivo')->extension();
        if (strtolower($extension) == 'xls' || strtolower($extension) == 'xlsx') {
            $datosCab['fec_carga'] = Date('d/m/Y H:i:s');
            if (isset($productoDetalle)) {
                $datosCab['desc_producto'] = $request->ff;
            } else {
                $datosCab['producto'] = '';
                $datosCab['desc_producto'] = '';
            }
            if ($request->hasfile('archivo')) {
                $nombre_archivo = $request->file('archivo')->getClientOriginalName();
                //$nombre_archivo = "BASE_COLOCACION_".$request->cliente.'_'.$fecha.'.xlsx';
                $datosCab['archivo'] = $request->file('archivo')->storeAs('cargas_inicial/' . $request->cliente, $nombre_archivo, 'public');
            }
            $trx = EaCabeceraCargaCorp::insert($datosCab);
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
