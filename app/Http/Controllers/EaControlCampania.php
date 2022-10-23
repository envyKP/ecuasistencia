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
        //dd($request->codigo_id);
        //Retornar valor individual
        // objetivo solo retornar los valores , el form se puede encargar de recibirlos
        // pór el envio es nescesario que se realize validacion o un parse con ajax y json , o una sucesion de response
        // que pueda transformar en json
        $opciones = EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id)->first();
        //dd($opciones->opciones_validacion);
        //bloque para crear opciones diferenciadas
        $recopilado = array();
        // opciones lectura / archivo Entrada
        if (isset($opciones->opciones_validacion)) {
            //echo "esta en opciones_validacion";
            $opciones_validacion = json_decode($opciones->opciones_validacion, true);
            //dd($opciones_validacion);
            if (isset($opciones_validacion['identificador_secuencia'])) {
                //   echo "esta en opciones_validacion->identificador_secuencia";
                $recopilado['identificador'] = $opciones_validacion['identificador_secuencia'];
            }
            if (isset($opciones_validacion['num_validacion'])) {
                $recopilado['campoValidacionDebitado'] = $opciones_validacion['validacion_campo_1'];
                $recopilado['valorValidacionDebitado'] =  $opciones_validacion['validacion_valor_1'];
            }
            //{"validacion_campo_1":"fecha_autorizacion","validacion_valor_1":"","num_validacion":"1"
            // debe almacenarce vacio en caso que solo exista el campo
            if (isset($opciones->campos_import)) {
                //echo "esta en campos_import";
                $opciones_import = json_decode($opciones->campos_import, true);
                if (isset($opciones_import)) {
                    if (isset($opciones_validacion['identificador_secuencia'])) {
                        $recopilado['campoIdentificador'] = $opciones_import[$opciones_validacion['identificador_secuencia']];
                    }
                    if (isset($opciones_import['valor_debitado'])) {
                        $recopilado['valor_debitado'] = $opciones_import['valor_debitado'];
                    }
                    if (isset($opciones_import['detalle'])) {
                        $recopilado['detalle'] = $opciones_import['detalle'];
                    }
                    if (isset($opciones_import['fecha_actualizacion'])) {
                        $recopilado['fecha_actualizacion'] = $opciones_import['fecha_actualizacion'];
                    }
                    if (isset($opciones_import['num_validacion'])) {
                        $recopilado['validacion_archivo_campo_1'] = $opciones_import['validacion_campo_1'];
                        $recopilado['validacion_archivo_valor_1'] = $opciones_import['validacion_valor_1'];
                    }
                }
            }
        }
        //opciones Generar TXT / archivo Salida
        /*opciones_fijas ,campos_export,campoc,campo0 */
        /* cliente,tipo_subproducto,subproducto,archivo_nombre,formato_fecha,op_caracteristica_ba*/
        if (isset($opciones->codigo_id)) {
            $recopilado['codigo_id'] = $opciones->codigo_id;
        }
        if (isset($opciones->cliente)) {
            $recopilado['cliente'] = $opciones->cliente;
        }
        if (isset($opciones->tipo_subproducto)) {
            $recopilado['tipo_subproducto'] = $opciones->tipo_subproducto;
        }
        if (isset($opciones->subproducto)) {
            $recopilado['subproducto'] = $opciones->subproducto;
        }
        if (isset($opciones->archivo_nombre)) {
            $recopilado['archivo_nombre'] = $opciones->archivo_nombre;
        }
        if (isset($opciones->formato_fecha)) {
            $recopilado['formato_fecha'] = $opciones->formato_fecha;
        }
        if (isset($opciones->op_caracteristica_ba)) {
            $recopilado['op_caracteristica_ba'] = $opciones->op_caracteristica_ba;
        }

        //dd($recopilado);
        return response()->json(['opcionesModel' => $recopilado]);
    }

    // llamar a otro metodo , o que otra funcion llame a lo que es el export , 
    //cedula_id=1712215092&cliente=SEGUROSUNIDOS&proceso=

    public function getOpcionesCampoExport(Request  $request)
    {
        $opciones = EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id)->first();
        $campos_export = json_decode($opciones->campos_export, true);
        return response()->json(['opcionesCampoExport' => $campos_export]);
    }
    public function getOpcionesCampofijos(Request  $request)
    {
        $opciones = EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id)->first();
        $campos_fijos = json_decode($opciones->campos_export, true);
        return response()->json(['opcionesCampofijos' => $campos_fijos]);
    }
    public function getOpcionesCampoC(Request  $request)
    {
        $opciones = EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id)->first();
        $campos_C = json_decode($opciones->campos_export, true);
        return response()->json(['opcionesCampoC' => $campos_C]);
    }

    public function getOpcionesCampo0(Request  $request)
    {
        $opciones = EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id)->first();
        $campos_0 = json_decode($opciones->campos_export, true);
        return response()->json(['opcionesCampo0' => $campos_0]);
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getOpcionesModelAllCliente(Request  $request)
    {
        //retornar valor asociado a un cliente 



        $htmlOption = '<option value="" selected>Selecciona Producto</option>';
        $Opciones = EaOpcionesCargaCliente::where('cliente', $request->cliente)->get();
        foreach ($Opciones as $producto) {
            $htmlOption .= '<option value="' . $producto->codigo_id . '">' . $producto->archivo_nombre . '</option>';
        }
        return response()->json(['htmlProducto' => $htmlOption]);
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post_import_guardar(Request  $request)
    {
        //retornar valor asociado a un cliente 
        /*
        "_token" => "aoMkYKruZH5L9h3mj7aZFLjmhfQNnzHrpi6nR6o7"
      "_method" => "post"
      "codigo_id_import" => "14"
      "IdentificadoEntrada" => "secuencia"
      "campoIdentificador" => "vale"
      "fechaDebitado" => "fecha_autorizacion"
      "detalle" => "descripcion"
      "formatoFecha" => null
      "valorDebitado" => "total"
        */
        $opciones = EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id_import)->first();

        //{"validacion_campo_1":"mensaje_de_procesamiento","validacion_valor_1":"PROCESO OK","num_validacion":"1","identificador_secuencia":"cedula_id"}
        $opciones_validacion = json_decode($opciones->opciones_validacion, true);
        // solo cambiar identificador secuencia
        // $opciones_validacion_new = json_decode($opciones->opciones_validacion, true);
        //{"cedula_id":"numero_identificacion","fecha_actualizacion":"fecha_proceso","valor_debitado":"valor_enviado","detalle":"mensaje_de_procesamiento"}
        $opciones_import = json_decode($opciones->campos_import, true);

        if (isset($request->campoIdentificador)) {
            $opciones_import[$opciones_validacion['identificador_secuencia']];
        }


        if (isset($request->IdentificadoEntrada)) {
            if ($request->IdentificadoEntrada == "selec") {
                unset($opciones_validacion['identificador_secuencia']);
                unset($opciones_import[$opciones_validacion['identificador_secuencia']]);
            } else {
                if ($opciones_validacion['identificador_secuencia'] != $request->IdentificadoEntrada) {
                    if (isset($opciones_import[$opciones_validacion['identificador_secuencia']])) {
                        unset($opciones_import[$opciones_validacion['identificador_secuencia']]);
                    }
                    $opciones_validacion['identificador_secuencia'] = $request->IdentificadoEntrada;
                    //$opciones_import[$opciones_validacion['identificador_secuencia']] = isset($request->campoIdentificador) || $request->campoIdentificador != ""  ? $request->campoIdentificador 
                    if (isset($request->campoIdentificador) && $request->campoIdentificador != "") {
                        $opciones_import[$opciones_validacion['identificador_secuencia']] = $request->campoIdentificador;
                    }
                } else {
                    if (isset($opciones_import[$opciones_validacion['identificador_secuencia']])) {
                        $opciones_import[$opciones_validacion['identificador_secuencia']] = $request->campoIdentificador;
                    }
                }
            }
        }


        $enconde_validacion = json_encode($opciones_validacion);
        $enconde_validacion_data = json_encode($opciones_import);

        dd($enconde_validacion . " data : " . $enconde_validacion_data);





        $datos = $request->except('_token', '_method');
        //EaOpcionesCargaCliente

        /*   $json_text = array();

            if (isset($request->IdentificadoEntrada)) {
            }
        */

        //EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id)->update([' campos_import' => $json_text]);

        return response()->json(['respuesta' => $datos]);
    }


    // no llega nada error
    // algo de index
    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post_import_guardar_validacion(Request  $request)
    {
        //retornar valor asociado a un cliente 
        /*
        "_token" => "aoMkYKruZH5L9h3mj7aZFLjmhfQNnzHrpi6nR6o7"
      "_method" => "post"
      "codigo_id_import" => "14"
      "IdentificadoEntrada" => "secuencia"
      "campoIdentificador" => "vale"
      "fechaDebitado" => "fecha_autorizacion"
      "detalle" => "descripcion"
      "formatoFecha" => null
      "valorDebitado" => "total"
        */
        dd($request);

        //{"cedula_id":"numero_identificacion","fecha_actualizacion":"fecha_proceso","valor_debitado":"valor_enviado","detalle":"mensaje_de_procesamiento"}
        $datos = $request->except('_token', '_method');
        //EaOpcionesCargaCliente

        /*   $json_text = array();

            if (isset($request->IdentificadoEntrada)) {
            }
        */

        //EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id)->update([' campos_import' => $json_text]);

        return response()->json(['respuesta' => $datos]);
    }

    // no llega ID
    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post_import_guardar_datos(Request  $request)
    {

        dd($request);
        //{"cedula_id":"numero_identificacion","fecha_actualizacion":"fecha_proceso","valor_debitado":"valor_enviado","detalle":"mensaje_de_procesamiento"}
        $datos = $request->except('_token', '_method');
        //EaOpcionesCargaCliente

        /*$json_text = array();
        if (isset($request->IdentificadoEntrada)) {
        }*/
        //EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id)->update([' campos_import' => $json_text]);

        return response()->json(['respuesta' => $datos]);
    }


    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post_export_guardar_datos(Request  $request)
    {
        dd($request);
        $datos = $request->except('_token', '_method');


        return response()->json(['respuesta' => $datos]);
    }


    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_export_genera_datos(Request  $request)
    {
        // dd($request);
        $datos = $request->except('_token', '_method');
        /*
    public function getMenuSubproductoOpciones(Request $request)
    {
        $html = '<option value="" selected>Selecciona Producto</option>';
        $subproductos = EaOpcionesCargaCliente::where('cliente', $request->cliente)
            ->get();
        foreach ($subproductos as $subproducto) {
            $html .= '<option value="' . $subproducto->codigo_id  . '">' . $subproducto->archivo_nombre . '</option>';
        }
        return response()->json(['htmlProducto' => $html]);
    }

 $("#div-opcion-archivos").append(
                    '<div class="row col pt-3 justify-content-between" id="fila_' + row + '"></div>');
                $('#fila_' + row).append('<input class="form-control col-1" name="gn-' + row +
                    '-id" value="' + row + '" type="text" id="gn-' + row + '-id" />');

                if ($("#opconfig").val() == 'fijo') {
                    $('#fila_' + row).append('<input class="form-control col-4" name="gn-' + row +
                        '-values" value="" type="text" id="gn-' + row + '-values"/>');
                }

                if ($("#opconfig").val() == 'fecha') {
                    $('#fila_' + row).append('<input class="form-control col-4" name="gn-' + row +
                        '-values_fecha" value="" type="text" id="gn-' + row + '-values_fecha"/>');
                }

                if ($("#opconfig").val() == 'base') {
                    $('#fila_' + row).append('<select class="custom-select col-4" name="gn-' + row +
                        '-values_base"  id="gn-' + row +
                        '-values_base"> <option values="tarjeta" selected>tarjeta</option> <option value="cod_establecimiento">cod_establecimiento</option><option values="subtotal">subtotal</option> <option values="cuenta">cuenta</option> <option values="tipcta">tipcta</option> <option values="tipide">tipide</option> <option values="deduccion_impuesto">deduccion_impuesto</option> <option values="nombre">nombre</option> <option values="direccion">direccion</option> <option values="ciudadet">ciudadet</option> <option values="valortotal">valortotal</option> </select>'
                    );
                }

                $('#fila_' + row).append('<input class="form-control col-1" name="gn-' + row +
                    '-cantidad" value=" " type="text" id="gn-' + row + '-cantidad" />');
                $('#fila_' + row).append('<select class="custom-select col-4" name="gn-' + row +
                    '-campos" id="gn-' + row +
                    '-campos"> <option value selected>NADA</option> <option value="campoED_">Espacio Dereacha</option> <option value="campoE_">Espacio Izquierda</option> <option value="campo0D_">Cero Derecha</option> <option value="campo0_">Cero Izquierda</option> </select>'
                );




*/

        $row_id = 1;
        $field_datos = "<div class=\"row col pt-3 justify-content-between\" id=\"fila_" . $row_id . "\"></div>";
        $field_datos .= "<input class=\"form-control col-1\" name=\"gn-" . $row_id . "-id\" value=\"" . $row_id . "\" type=\"text\" id=\"gn-" . $row_id . "-id\" />";

        return response()->json(['htmlDetalleGenera' => $field_datos]);
    }



    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post_guardar_producto(Request  $request)
    {
        dd($request);
        $datos = $request->except('_token', '_method');

        return response()->json(['respuesta' => $datos]);
    }
}
