<?php

namespace App\Http\Controllers;

use App\Models\Eausuario;
use Illuminate\Http\Request;

class EausuarioController extends Controller
{

    //test de doctrine dbal
    public function getDataSGA (){

        return Eausuario::all();

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Eausuario  $eausuario
     * @return \Illuminate\Http\Response
     */
    public function show(Eausuario $eausuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Eausuario  $eausuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Eausuario $eausuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Eausuario  $eausuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Eausuario $eausuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Eausuario  $eausuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Eausuario $eausuario)
    {
        //
    }
}
