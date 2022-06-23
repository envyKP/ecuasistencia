<?php

namespace App\Http\Controllers;
use App\Models\EaCabeceraCargaCorp;
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

class EaCargaIndividualExport extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes =  (new EaClienteController)->getAllCampanas();
        $RegistrosPendientes = EaCabeceraCargaCorp::where('estado', 'PENDIENTE')
                                                  ->orderBy('cliente')->paginate(5);

        return view ('cargaIndividual.home')->with(compact('clientes'))
                                         ->with(compact('RegistrosPendientes'));
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
 
        if ( isset($idCliente) && $idCliente !== 1 ) {
             $idCliente++;
             $datosCliente['id_cliente'] = $idCliente;
        }else {
             $datosCliente['id_cliente'] = 1;
        }
 
 
        if ($request->hasfile('logotipo')) {
 
             $nombre_archivo = $request->file('logotipo')->getClientOriginalName();
             $datosCliente['logotipo'] = $request->file('logotipo')->storeAs('LogosClientes', $nombre_archivo, 'public');
        }
 
        EaCliente::insert($datosCliente);
 
        return redirect()->route('EaClienteController.index')->with([ 'cliente' => $request->cliente,
                                                                      'trxcliente' => 'store' ]);
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
     /*   $clientes =  (new EaClienteController)->getAllCampanas();
        $RegistrosPendientes = EaCabeceraCargaCorp::where('estado', 'PENDIENTE')
                                                  ->orderBy('cliente')->paginate(5);

        return view ('cargaInicial.home')->with(compact('clientes'))
                                         ->with(compact('RegistrosPendientes'));
*/
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
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generar(Request $request)
    {
    }
}
