<?php

namespace App\Http\Controllers;

use App\Models\EaProducto;
use Illuminate\Http\Request;
use App\Http\Controllers\EaClienteController;
use App\Http\Controllers\EaSubproductoController;
use App\Models\EaOpcionesCargaCliente;
use App\Http\Controllers\EaUtilController;


class EaControlCampania extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Allcampanas = (new EaClienteController)->getAllCampanas();
        return view('configCampanias.home')->with(compact('Allcampanas'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJsonEntrada()
    {
        /*
        {
        $campanas = EaCliente::where('estado', 'A')
            ->get()
            ->sortBy('desc_cliente');
        */

        $Allcampanas = (new EaClienteController)->getAllCampanas(); // modificar por campo

        return view('configCampanias.jsonCadenaSalida')->with(compact('Allcampanas')); // modificar por campo
        //return view('configCampanias.jsonCadenaSalida');
    }
    /**
     * metodo para vaciar detalles_debito , y cambiar el estado de la cabezera a 
     * archivado
     */

    /**
     * deberia mostrar los mismo que el anterior ?
     * una vista tiene que ser igual a la anterior
     * la otra se mostraran los subproducto , replicare la configuracion campanias añadiendo mi opcion 
     * y bloqueando todo lo que pueda interferir en la configuracion 
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
     * Return the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function informacionArchivoEntrada($request)
    {
        $this->opciones_fijas = json_decode($this->op_client->opciones_fijas, true);
    }


    /**
     * Return the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function informacionArchivoSalida()
    {
        // $this->opciones_fijas = json_decode($this->op_client->opciones_fijas, true);
    }
    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getOpcionesModel(Request  $request)
    {
        //$request   debe ser un AJAX , posiblemente como lo llena en 
        $Opciones = EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id)
            ->firts();
        return response()->json(['OpcionesModel' => $Opciones]);
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getOpcionesModelAllCliente(Request  $request)
    {
        //$request   debe ser un AJAX , posiblemente como lo llena en 
        $Opciones = EaOpcionesCargaCliente::where('cliente', $request->cliente)->get();
        return response()->json(['OpcionesModelAll' => $Opciones]);
    }
}
