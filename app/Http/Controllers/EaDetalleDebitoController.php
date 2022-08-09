<?php

namespace App\Http\Controllers;

use App\Models\EaCabeceraDetalleCarga;
use App\Models\EaDetalleDebito;
use Illuminate\Http\Request;

class EaDetalleDebitoController extends Controller
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * referencia a la tabla cabeceradetallecarga
     */
    public function update_estado_cabecera_det($cod_carga, $cliente, $producto, array $datos)
    {
        EaCabeceraDetalleCarga::where('cod_carga', $cod_carga)
            ->where('cliente', $cliente)
            ->where('producto', $producto)
            ->update($datos);
    }

    //modificacion por INTER TC
    public function valida_resgistro_detalle_debito_INTER_TC($cod_carga, $cliente, $producto, $secuencia,$row)
    {
      return   EaDetalleDebito::where('id_carga', $cod_carga)
            ->where('cliente' , $cliente)
            ->where('subproducto_id', $producto)
            ->where('secuencia', $secuencia)
            ->update(['detalle' => $row['descripcion'], 'valor_debitado' => $row['total'], 'fecha_actualizacion' => $row['fecha_autorizacion'], 'estado' => $row['estado']]);
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
}
