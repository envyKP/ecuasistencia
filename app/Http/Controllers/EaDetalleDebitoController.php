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
    public function update_debit_detail_INTER_TC($cod_carga, $cliente, $producto, $row)
    {
        $secuencia = $row['vale'];
        return   EaDetalleDebito::where('id_carga', $cod_carga)
            ->where('cliente', $cliente)
            ->where('subproducto_id', $producto)
            ->where('secuencia', $secuencia)
            ->update($row);
    }

    public function update_debit_detail($cod_carga, $cliente, $producto, $row)
    {
        $secuencia = $row['secuencia'];
        dd($row);
        return   EaDetalleDebito::where('id_carga', $cod_carga)
            ->where('cliente', $cliente)
            ->where('subproducto_id', $producto)
            ->where('secuencia', $secuencia)
            ->update($row);
    }

    public function update_debit_detail_join_BA($row)
    {
        //::join("base_activa", "ea_detalle_debito.desc_subproducto", "=", "ea_base_activa.subproducto")
        // condicion inicial prototipo
        /*  $subquery = DB::table('catch-text')
            ->select(DB::raw("user_id,MAX(created_at) as MaxDate"))
            ->groupBy('user_id');
            $query = User::joinSub($subquery,'MaxDates',function($join){
            $join->on('users.id','=','MaxDates.user_id');
            })->select(['users.*','MaxDates.*']);
        
        DB::table('attributes as a')
        ->join('catalog as c', 'a.parent_id', '=', 'c.id')
        ->update([ 'a.key' => DB::raw("`c`.`left_key`") ]);
        */

        //PROTOTIPO 2 TOMANDO EN CUENTA DIFERENCIA ENTRE TARJETA Y CUENTA 
        /*
        if ($row['secuencia'] == 'tarjeta') {
            return   EaDetalleDebito::where('id_carga', $cod_carga)
                ->where('cliente', $cliente)
                ->where('subproducto_id', $producto)
                ->join("ea_base_activa", "ea_base_activa.id_sec", "=", "ea_detalle_debito.id_sec")
                ->update($row);
        } elseif ($row['secuencia'] == 'cuenta') {
            return   EaDetalleDebito::where('id_carga', $cod_carga)
                ->where('cliente', $cliente)
                ->where('subproducto_id', $producto)
                ->where('secuencia', $secuencia)
                ->update($row);
        } else {
            dd("Error en metodo update, no reconoce la entrada de dato id_sec");
        }
        */
        $id_detalle = $row['id_detalle'];
        //dd($row);
        return   EaDetalleDebito::where('id_detalle', $id_detalle)
            ->update($row);

        //$secuencia = $row['secuencia'];

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
