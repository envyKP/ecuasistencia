<?php

namespace App\Http\Controllers;

use App\Models\EaMotivosDesactivacion;
use Illuminate\Http\Request;

class EaMotivoDesactivacionController extends Controller
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
     * @param  \App\Models\EaMotivosDesactivacion  $eaMotivosDesactivacion
     * @return \Illuminate\Http\Response
     */
    public function show(EaMotivosDesactivacion $eaMotivosDesactivacion)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getMotivosHtml()
    {
        $htmlOption = '<option value="" selected>Seleccione un motivo</option>';

        $motivosDesac = EaMotivosDesactivacion::All();

        foreach ($motivosDesac as $motivo) {
            $htmlOption .= '<option value="'.$motivo->cod.'">'.$motivo->detalle.'</option>';
        }

        return response()->json( ['htmlMotivos' => $htmlOption] );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EaMotivosDesactivacion  $eaMotivosDesactivacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EaMotivosDesactivacion $eaMotivosDesactivacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EaMotivosDesactivacion  $eaMotivosDesactivacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(EaMotivosDesactivacion $eaMotivosDesactivacion)
    {
        //
    }
}
