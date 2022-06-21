<?php

namespace App\Http\Controllers;

use App\Models\EaCliente;
use App\Models\EaTipoId;
use App\Models\EaCicloCorte;
USE App\Models\EaTipoActivacion;
use App\Models\EaCodigoEstadoGestion;
use App\Models\EaCodigoEstadoCliente;
use App\Models\EaCiudad;
use App\Models\EaCodigoRespuesta;
use App\Models\EaCallTypeRetencion;
use App\Models\EaMotivosDesactivacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\EaImpuestosController;
use App\Http\Controllers\EaProductoController;
use App\Http\Controllers\EaSubproductoController;

class EaClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes['dataClientes'] = $this->getAllCampanas();

        return view ('configClientesImpuestos.home')->with($clientes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getClienteModel(Request  $request){

        $modelo = EaCliente::where ('cliente', $request->cliente)
                           ->get();

        return response()->json( ['clienteModel' => $modelo ]);

    }



    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getConfigCampana(Request  $request)
    {

        $campana = EaCliente::Where("cliente", $request->cliente)->first();
        return $campana;
    }


    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAllCampanas()
    {
        $campanas = EaCliente::where('estado', 'A')
                             ->get()
                             ->sortBy('desc_cliente');
        return $campanas;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EaCliente  $eaCliente
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request  $request)
    {

        $hora = Date('H:i:s');
        $fecha = Date('d/m/Y');

        $campana = $this->getConfigCampana($request);
        $tiposIdentificacion = EaTipoId::all();
        $ciclosCortes = EaCicloCorte::all();
        $estadosGestion = EaCodigoEstadoGestion::All();
        $tiposActivacion = EaTipoActivacion::All();
        $estadosCliente = EaCodigoEstadoCliente::All();
        $ciudades = EaCiudad::All();
        $codigosRespuesta = EaCodigoRespuesta::All();
        $productos = (new EaProductoController)->getProductosAll($request);
        $callTypesRetencion = EaCallTypeRetencion::All();

        if ( strcmp ($campana->cliente, 'PRODUBANCO' )===0 ) {
            unset( $tiposIdentificacion[2], $tiposIdentificacion[3], $tiposIdentificacion[4]);
        } else {
            unset( $tiposIdentificacion[0], $tiposIdentificacion[1]);
        }

        return view ('cliente.home')->with(compact('campana'))
                                     ->with(compact('hora'))
                                     ->with(compact('fecha'))
                                     ->with(compact('tiposIdentificacion'))
                                     ->with(compact('ciclosCortes'))
                                     ->with(compact('estadosGestion'))
                                     ->with(compact('tiposActivacion'))
                                     ->with(compact('estadosCliente'))
                                     ->with(compact('ciudades'))
                                     ->with(compact('codigosRespuesta'))
                                     ->with(compact('productos'))
                                     ->with(compact('callTypesRetencion'))
                                     ->with(['fromCliente' => 'cliente']);

    }


    /**
     * Show the form for editing the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EaCliente  $eaCliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Request  $request)
    {
        $datosCliente = $request->except('_token', '_method', 'clienteEditOld', 'desc_clienteEditOld');

        $datosCliente['cliente'] = $request->clienteEdit;
        $datosCliente['desc_cliente'] = $request->desc_clienteEdit;

        unset($datosCliente['clienteEdit'], $datosCliente['desc_clienteEdit'], $datosCliente['id_clienteEdit']);

        if ( $request->hasfile('logotipo') ) {

            $cliente = EaCliente::where('id_cliente', $request->id_clienteEdit)->first();

            Storage::disk('public')->delete($cliente->logotipo);

            $nombre_archivo = $request->file('logotipo')->getClientOriginalName();
            $datosCliente['logotipo'] = $request->file('logotipo')->storeAs('LogosClientes', $nombre_archivo, 'public');

        }

        EaCliente::where('id_cliente', $request->id_clienteEdit)
                 ->update($datosCliente);

        //clienteEditOld actualiza cliente, con el nuevo cliente clienteEdit
        (new EaImpuestosController)->updateMaestroCliente($request);
        (new EaProductoController)->updateMaestroCliente($request);
        (new EaSubproductoController)->updateMaestroCliente($request);


        return redirect()->route('EaClienteController.index')->with(['clienteEdit' => $request->clienteEdit,
                                                                     'clienteEditOld' => $request->clienteEditOld,
                                                                     'desc_clienteEdit' => $request->desc_clienteEdit,
                                                                     'desc_clienteEditOld' => $request->desc_clienteEditOld,
                                                                     'trxcliente' => 'update'
                                                                    ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EaCliente  $eaCliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EaCliente $eaCliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EaCliente  $eaCliente
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
        $datosCliente = $request->except("_token", "_method");

        EaCliente::where('id_cliente', $request->id_cliente)
                 ->update(['estado' => 'I']);

        return redirect()->route('EaClienteController.index')->with([ 'cliente' => $request->desc_clienteForm, 'trxcliente' => 'delete']);
    }
}
