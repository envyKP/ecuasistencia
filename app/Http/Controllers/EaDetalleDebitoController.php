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
    //KPE metodo para limpiar tabla temporal
    public function clear_temp($token)
    {
        //cambios KPE
        if (isset($token)) {
            if ($token === 'todos') {
                /// ejecutar comando para realizar la limpieza de datos, posiblemente usar este metodo tambien 

                echo 'procegir a realizar la limpieza';
            } else {
                echo 'servicio denegado ';
            }


            dd($token);
            echo 'dentro de condicion ';
        }
        echo 'final ';
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
    ///KPE bloque de metodos usados para metodos de vista por dertras.
    // existe el contratoAMA que puede ser similar a la ID pero puede usarse con mas de un subproducto
    // que exista dentro del mismo cliente
    // deberia intentar validar ? por no solo nombre si no por contrato ama ? . 
    //para el subproducto estoy usando la ID pero puedo añadir el contratoAMA como filtro
    // validado : si es posible solo añadir el filtro al comienzo de consultar , debido a que 
    // existe un campo que consulta los detalles del subproducto por debajo 
    // los productos juntos son bolivariano ctas, produbanco tarjetas
    // BGR , es la consulta atrasada de 30 dias 
    public function getMenuSubproductoOpciones(Request $request)
    { // es nescesario este bloque por los subproducto que pertenecen a un tipo y existe 
        // subproductos en export que nescesitan estar juntos  ashley noa olmedo
        $html = '<option value="" selected>Selecciona Producto</option>';
        $subproductos = EaOpcionesCargaCliente::where('cliente', $request->cliente)
            ->get();
        foreach ($subproductos as $subproducto) {
            $html .= '<option value="' . $subproducto->codigo_id  . '">' . $subproducto->archivo_nombre . '</option>';
        }
        return response()->json(['htmlProducto' => $html]);
    }

    public function getDetalleDebitoOpciones(Request  $request)
    {   // 2 tipos de validaciones uno con fecha y otro con esto puedo usar la misma opcion de for,
        // pero el espacio debe ser limitado , no puedo 
        // parametro de consulta (campo nuevo . modifica lka base de datos)
        // el campo existente tambien modifica la base de datos.
        // el campo existente extrae el campo a modificar , y añade la opcion de crear un combo de hasta 4 elementos o items
        //getDetalleDebitoOpciones
        //3 corte el 12$                ciclo13 = 3;
        //4 corte el 15                $ciclo15 = 4;
        //9 corte el 30                $ciclo30 = 9;
        //$request['opcional']; // el id que viene del campo ciclo(3,4,9) dettipcic(corte 12..., etc)
        $html = '<option value="" selected>Seleccione una opcion</option>';
        $subproductos = EaOpcionesCargaCliente::where('codigo_id', $request->producto)
            ->first();
        $campo_opciones = json_decode($subproductos->op_caracteristica_ba, true);
        //{"total":"3","var_camp_1":"3","var_val_1":"CORTE EL 12","var_camp_2":"4","var_val_2":"CORTE EL 15","var_camp_3":"9","var_val_3":"CORTE EL 30","camp_ba":"dettipcic"} // falta los ciclos 
        if (isset($campo_opciones['total'])) {
            for ($i = 1; $i <= $campo_opciones['total']; $i++) {
                if (isset($campo_opciones['var_val_' . $i])) {
                    $html .= '<option value="' . $campo_opciones['var_camp_' . $i] . '">' .  $campo_opciones['var_val_' . $i] . '</option>';
                }
            }
        } else {
            $html = '<option value="" selected> No existe Campo opcional</option>';
        }
        return response()->json(['htmlProducto' => $html]);
    }



    public function show($id)
    {
        //
    }


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
