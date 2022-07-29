<?php

namespace App\Http\Controllers;

use App\Models\EaCamposBa;
use Illuminate\Http\Request;
use App\Models\EaCodigoEstadoCliente;

class EaCamposBaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function get_data_estado_Cliente()
    {

        return (EaCodigoEstadoCliente::all());
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EaCamposBa  $eaCamposBa
     * @return \Illuminate\Http\Response
     */
    public function show(EaCamposBa $eaCamposBa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EaCamposBa  $eaCamposBa
     * @return \Illuminate\Http\Response
     */
    public function edit(EaCamposBa $eaCamposBa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EaCamposBa  $eaCamposBa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EaCamposBa $eaCamposBa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EaCamposBa  $eaCamposBa
     * @return \Illuminate\Http\Response
     */
    public function destroy(EaCamposBa $eaCamposBa)
    {
        //
    }
}
