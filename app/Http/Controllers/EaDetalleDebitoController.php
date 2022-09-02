<?php

namespace App\Http\Controllers;

use App\Models\EaCabeceraDetalleCarga;
use App\Models\EaOpcionesCargaCliente;
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
    public function getDetalleDebitoOpciones(Request  $request)
    {
// 2 tipos de validaciones uno con fecha y otro con esto puedo usar la misma opcion de for,
// pero el espacio debe ser limitado , no puedo 
//
// parametro de consulta (campo nuevo . modifica lka base de datos)
// el campo existente tambien modifica la base de datos.
// el campo existente extrae el campo a modificar , y añade la opcion de crear un combo de hasta 4 elementos o items
        //getDetalleDebitoOpciones
        $html = '<option value="" selected>Seleccione una opcion</option>';
        $subproductos = EaOpcionesCargaCliente::where('cliente', $request->cliente)->where('subproducto', $request->producto)
            ->get();
        $campo_opciones = json_decode($subproductos->opciones_data, true);
        /* for ($i=0; $i < 4; $i++) { 
                    $campo_opciones['campo_']
                }*/
                $cont=1;
        foreach ($campo_opciones as $op) {
            if (isset($campo_opciones[''])) {
                //$base_op['var_val_' . $k]
                $html .= '<option value="' . $campo_opciones['var_val_' .$cont ] . '">' .  $campo_opciones['var_val_' .$cont ] . '</option>';
            }
            $cont++;
        }
        return response()->json(['htmlProducto' => $html]);
    }


    public function update_debit_detail($cod_carga, $cliente, $producto, $row)
    {
        //$secuencia =  ltrim($row['secuencia'], '0');
        return   EaDetalleDebito::where('id_carga', $cod_carga)
            ->where('cliente', $cliente)
            ->where('subproducto_id', $producto)
            ->where('secuencia', $row['secuencia'])
            ->update($row);
    }

    public function update_debit_detail_join_BA($id_detalle, $row)
    {

        return   EaDetalleDebito::where('id_detalle', $id_detalle)
            ->update($row);
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
