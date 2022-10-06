<?php

namespace App\Http\Controllers;

use App\Models\EaDetalleCargaCorp;
use Illuminate\Http\Request;

class EaDetalleCargaCorpController extends Controller
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
     * @param  \App\Models\EaDetalleCargaCorp  $eaDetalleCargaCorp
     * @return \Illuminate\Http\Response
     */
    public function show(EaDetalleCargaCorp $eaDetalleCargaCorp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EaDetalleCargaCorp  $eaDetalleCargaCorp
     * @return \Illuminate\Http\Response
     */
    public function edit(EaDetalleCargaCorp $eaDetalleCargaCorp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EaDetalleCargaCorp  $eaDetalleCargaCorp
     * @return \Illuminate\Http\Response
     */
    public function existe_registro($cod_carga, $cliente, $cedula_id)
    {
        //
        $trx = EaDetalleCargaCorp::where('cod_carga', $cod_carga)
            ->where('cliente', $cliente)
            ->where('cedula_id', $cedula_id)
            ->exists();

        return $trx;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EaDetalleCargaCorp  $eaDetalleCargaCorp
     * @return \Illuminate\Http\Response
     */
    public function truncate($cod_carga, $cliente)
    {
        // borra todo con ->truncate();
        $trx = EaDetalleCargaCorp::where('cod_carga', $cod_carga)
            ->where('cliente', $cliente)
            ->delete();
        return $trx;
    }

    
}
