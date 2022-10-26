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
        if (isset($opciones->num_elem_export)) {
            $recopilado['num_elem_export'] = $opciones->num_elem_export;
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

        $opciones = EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id_import)->first();

        //{"validacion_campo_1":"mensaje_de_procesamiento","validacion_valor_1":"PROCESO OK","num_validacion":"1","identificador_secuencia":"cedula_id"}
        $opciones_validacion = json_decode($opciones->opciones_validacion, true);

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
            // EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id_import)->update(['opciones_validacion'=>$opciones_import,'campos_import'=>$opciones_import]); 


        }
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

        if (isset($request->fechaDebitado)) {
            $opciones_import['fecha_actualizacion'] = $request->fechaDebitado;
            $enconde_validacion_data = json_encode($opciones_import);
            // EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id_import)->update(['opciones_import' => $enconde_validacion_data]);
        }
        if (isset($request->detalle)) {
            $opciones_import['detalle'] = $request->detalle;
            $enconde_validacion_data = json_encode($opciones_import);
            // EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id_import)->update(['opciones_import' => $enconde_validacion_data]);
        }
        if (isset($request->formatoFecha)) {
            //EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id_import)->update(['formato_fecha' => $request->formatoFecha]);
        }
        if (isset($request->valorDebitado)) {
            $opciones_import['valor_debitado'] = $request->valorDebitado;
            $enconde_validacion_data = json_encode($opciones_import);
            // EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id_import)->update(['opciones_import' => $enconde_validacion_data]);
        }

        $enconde_validacion = json_encode($opciones_validacion);
        $enconde_validacion_data = json_encode($opciones_import);
        // dd($enconde_validacion . " data : " . $enconde_validacion_data);

        $datos = $request->except('_token', '_method');

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
        $opciones = EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id)->first();

        $row_id = 1;
        $field_datos = "";
        $campos_string = array('campo0_', 'campo0D_', 'campoE_', 'campoED_');
        $nombre_campos_string = array('campo0_' => 'Cero Izquierda', 'campo0D_' => 'Cero Derecha', 'campoE_' => 'Espacio Izquierda', 'campoED_' => 'Espacio Derecha');

        $datos_combo = array('contador_secuencia', 'tarjeta', 'valortotal', 'ciudadet', 'direccion', 'nombre', 'deduccion_impuesto', 'tipide', 'tipcta', 'cuenta', 'subtotal', 'cod_establecimiento');
        $opciones_fijas = json_decode($opciones->opciones_fijas, true);
        $opciones_export = json_decode($opciones->campos_export, true);
        $camposC = json_decode($opciones->campoc, true);
        $campos_0 = json_decode($opciones->campo0, true);
        for ($i = 1; $i <= $request->num_elem_export; $i++) {
            if (isset($request['gn-' . $i . "-id"])) {
                $count_existe = 0; // lo almacena en fijo 
                // si hago un unset asi no exista dara error? 
                if (isset($request['gn-' . $i . "-values_base"])) {
                    // guardar en export
                    $opciones_export[$i] = $request['gn-' . $i . "-values_base"];
                    $count_existe = 1;
                    //puedo usar un isset para preguntar si existe y hacer unset o directamente hacer un unset a los que no pertenezcan 
                    //campoC_
                    unset($camposC['campoC_' . $i]);
                    unset($opciones_fijas[$i]);
                    //unset($opciones_export[$i]);
                } elseif (isset($request['gn-' . $i . "-values"])) {
                    //guardar en fijo
                    $opciones_fijas[$i] = $request['gn-' . $i . "-values"];
                    unset($camposC['campoC_' . $i]);
                    //unset($opciones_fijas[$i]);
                    unset($opciones_export[$i]);
                    $count_existe = 1;
                } elseif (isset($request['gn-' . $i . "-values_fecha"])) {
                    $camposC['campoC_' . $i] = $request['gn-' . $i . "-values_fecha"];
                    //unset($camposC['campoC_' . $i]);
                    unset($opciones_fijas[$i]);
                    unset($opciones_export[$i]);
                    //guardar en campoC
                    $count_existe = 1;
                }
                if ($count_existe == 0) {
                    //guardar en campo_C
                    // no tiene nada es vacio pertenece a fijo por defecto
                    unset($camposC['campoC_' . $i]);
                    //unset($opciones_fijas[$i]);
                    unset($opciones_export[$i]);
                    $opciones_fijas[$i] = "";

                }

                if (isset($request["gn-" . $i . "-cantidad"])) {
                    if (isset($request["gn-" . $i . "-campos"])) {
                        $campos_0[$request["gn-" . $i . "-campos"] . $i] = $request["gn-" . $i . "-cantidad"];
                    }
                }
                if (isset($request["gn-" . $i . "-campos"])) {
                    //lo identifique como vacio 
                    //inserte en fijo 
                }
            }
        }
        $opciones_fijas = json_decode($opciones->opciones_fijas, true);
        $opciones_export = json_decode($opciones->campos_export, true);
        $camposC = json_decode($opciones->campoc, true);

        //EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id)->update(['opciones_fijas'=>$opciones_fijas ,'campos_export'=>$opciones_export,'campoc'=>$camposC]);

        return response()->json(['respuesta' => $datos]);
    }


    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_export_genera_datos(Request  $request)
    {
        //dd($request);
        $datos = $request->except('_token', '_method');
        $opciones = EaOpcionesCargaCliente::where('codigo_id', $request->codigo_id)->first();

        $row_id = 1;
        $field_datos = "";
        $campos_string = array('campo0_', 'campo0D_', 'campoE_', 'campoED_');
        $nombre_campos_string = array('campo0_' => 'Cero Izquierda', 'campo0D_' => 'Cero Derecha', 'campoE_' => 'Espacio Izquierda', 'campoED_' => 'Espacio Derecha');
        $datos_combo = array('contador_secuencia', 'tarjeta', 'valortotal', 'ciudadet', 'direccion', 'nombre', 'deduccion_impuesto', 'tipide', 'tipcta', 'cuenta', 'subtotal', 'cod_establecimiento');
        // contador_secuencia // condicion en campoC
        $campos_C = json_decode($opciones->campoc, true);
        //dd($campos_C);
        $opciones_fijas = json_decode($opciones->opciones_fijas, true);
        $opciones_export = json_decode($opciones->campos_export, true);
        $campos_0 = json_decode($opciones->campo0, true);
        //dd($opciones_export);

        for ($i = 1; $i <= $opciones->num_elem_export; $i++) {

            if (isset($opciones_export[$i])) {
                $field_datos .= "<div class=\"row col pt-3 justify-content-between\" id=\"fila_" . $i . "\">";
                $field_datos .= "<input class=\"form-control col-1\" name=\"gn-" . $i . "-id\" value=\"" . $i . "\" type=\"text\" id=\"gn-" . $i . "-id\" />";
                $field_datos .= "<select class=\"custom-select col-4\" name=\"gn-" . $i . "-values_base\" value=\"" . $i . "\" id=\"gn-" . $i . "-values_base\"> ";
                foreach ($datos_combo as $next_c) {
                    if ($next_c == $opciones_export[$i]) {
                        $field_datos .= "<option values=\"" . $next_c . "\" selected>" . $next_c . "</option> ";
                    } else {
                        $field_datos .= "<option values=\"" . $next_c . "\">" . $next_c . "</option> ";
                    }
                }
                $field_datos .= "</select>";

                $count_camp = null;
                $select_camp = null;
                foreach ($campos_string as $cam_stri) {
                    if (isset($campos_0[$cam_stri . $i])) {
                        $count_camp = $i;
                        $field_datos .= "<input class=\"form-control col-1\" name=\"gn-" . $i . "-cantidad\" value=\"" . $campos_0[$cam_stri . $i] . "\" type=\"text\" id=\"gn-" . $i . "-cantidad\" />";
                        $select_camp = $cam_stri;
                    }
                }
                if (!isset($count_camp)) {
                    $field_datos .= "<input class=\"form-control col-1\" name=\"gn-" . $i . "-cantidad\" value=\"\" type=\"text\" id=\"gn-" . $i . "-cantidad\" />";
                }
                $field_datos .= "<select class=\"custom-select col-4\" name=\"gn-" . $i . "-campos\" id=\"gn-" . $i . "-campos\">";
                if (isset($count_camp) && isset($select_camp)) {
                    $field_datos .= "<option value >NADA</option> ";
                    foreach ($campos_string as $cam_stri) {
                        if ($select_camp == $cam_stri) {
                            $field_datos .=    "<option value=\"" . $cam_stri . "\" selected>$nombre_campos_string[$cam_stri]</option> ";
                        } else {
                            $field_datos .=    "<option value=\"" . $cam_stri . "\">$nombre_campos_string[$cam_stri]</option> ";
                        }
                    }
                    $field_datos .=  "</select>";
                } else {

                    $field_datos .=  "<option value selected>NADA</option>";
                    $field_datos .=    "<option value=\"campoED_\">Espacio Derecha</option> ";
                    $field_datos .=    "<option value=\"campoE_\">Espacio Izquierda</option> ";;
                    $field_datos .=   " <option value=\"campo0D_\">Cero Derecha</option> ";
                    $field_datos .=    " <option value=\"campo0_\">Cero Izquierda</option> </select>";
                }
                $field_datos .= "</div>";
            } elseif (isset($opciones_fijas[$i])) {
                $field_datos .= "<div class=\"row col pt-3 justify-content-between\" id=\"fila_" . $i . "\">";
                $field_datos .= "<input class=\"form-control col-1\" name=\"gn-" . $i . "-id\" value=\"" . $i . "\" type=\"text\" id=\"gn-" . $i . "-id\" />";
                $field_datos .= "<input class=\"form-control col-4\" name=\"gn-" . $i . "-values\" value=\"" . $opciones_fijas[$i] . "\" type=\"text\" id=\"gn-" . $i . "-values\"/>";

                $count_camp = null;
                $select_camp = null;
                foreach ($campos_string as $cam_stri) {
                    if (isset($campos_0[$cam_stri . $i])) {
                        $count_camp = $i;
                        $field_datos .= "<input class=\"form-control col-1\" name=\"gn-" . $i . "-cantidad\" value=\"" . $campos_0[$cam_stri . $i] . "\" type=\"text\" id=\"gn-" . $i . "-cantidad\" />";
                        $select_camp = $cam_stri;
                    }
                }
                if (!isset($count_camp)) {
                    $field_datos .= "<input class=\"form-control col-1\" name=\"gn-" . $i . "-cantidad\" value=\"\" type=\"text\" id=\"gn-" . $i . "-cantidad\" />";
                }
                $field_datos .= "<select class=\"custom-select col-4\" name=\"gn-" . $i . "-campos\" id=\"gn-" . $i . "-campos\">";
                if (isset($count_camp) && isset($select_camp)) {
                    $field_datos .= "<option value >NADA</option> ";
                    foreach ($campos_string as $cam_stri) {
                        if ($select_camp == $cam_stri) {
                            $field_datos .=    "<option value=\"" . $cam_stri . "\" selected>$nombre_campos_string[$cam_stri]</option> ";
                        } else {
                            $field_datos .=    "<option value=\"" . $cam_stri . "\">$nombre_campos_string[$cam_stri]</option> ";
                        }
                    }
                    $field_datos .=  "</select>";
                } else {

                    $field_datos .=  "<option value selected>NADA</option>";
                    $field_datos .=    "<option value=\"campoED_\">Espacio Derecha</option> ";
                    $field_datos .=    "<option value=\"campoE_\">Espacio Izquierda</option> ";;
                    $field_datos .=   " <option value=\"campo0D_\">Cero Derecha</option> ";
                    $field_datos .=    " <option value=\"campo0_\">Cero Izquierda</option> </select>";
                }
                $field_datos .= "</div>";
            } elseif (isset($campos_C['campoC_' . $i])) {
                $field_datos .= "<div class=\"row col pt-3 justify-content-between\" id=\"fila_" . $i . "\">";
                $field_datos .= "<input class=\"form-control col-1\" name=\"gn-" . $i . "-id\" value=\"" . $i . "\" type=\"text\" id=\"gn-" . $i . "-id\" />";

                $field_datos .= "<input class=\"form-control col-4\" name=\"gn-" . $i . "-values_fecha\" value=\"" . $campos_C['campoC_' . $i] . "\" type=\"text\" id=\"gn-" . $i . "-values_fecha\"/>";

                $count_camp = null;
                $select_camp = null;
                foreach ($campos_string as $cam_stri) {
                    if (isset($campos_0[$cam_stri . $i])) {
                        $count_camp = $i;
                        $field_datos .= "<input class=\"form-control col-1\" name=\"gn-" . $i . "-cantidad\" value=\"" . $campos_0[$cam_stri . $i] . "\" type=\"text\" id=\"gn-" . $i . "-cantidad\" />";
                        $select_camp = $cam_stri;
                    }
                }
                if (!isset($count_camp)) {
                    $field_datos .= "<input class=\"form-control col-1\" name=\"gn-" . $i . "-cantidad\" value=\"\" type=\"text\" id=\"gn-" . $i . "-cantidad\" />";
                }
                $field_datos .= "<select class=\"custom-select col-4\" name=\"gn-" . $i . "-campos\" id=\"gn-" . $i . "-campos\">";
                if (isset($count_camp) && isset($select_camp)) {
                    $field_datos .= "<option value >NADA</option> ";
                    foreach ($campos_string as $cam_stri) {
                        if ($select_camp == $cam_stri) {
                            $field_datos .=    "<option value=\"" . $cam_stri . "\" selected>$nombre_campos_string[$cam_stri]</option> ";
                        } else {
                            $field_datos .=    "<option value=\"" . $cam_stri . "\">$nombre_campos_string[$cam_stri]</option> ";
                        }
                    }
                    $field_datos .=  "</select>";
                } else {

                    $field_datos .=  "<option value selected>NADA</option>";
                    $field_datos .=    "<option value=\"campoED_\">Espacio Derecha</option> ";
                    $field_datos .=    "<option value=\"campoE_\">Espacio Izquierda</option> ";;
                    $field_datos .=   " <option value=\"campo0D_\">Cero Derecha</option> ";
                    $field_datos .=    " <option value=\"campo0_\">Cero Izquierda</option> </select>";
                }
                $field_datos .= "</div>";
            }
        }


        /*
        $field_datos .= "<option values=\"tarjeta\" selected>tarjeta</option> " .
            "<option value=\"cod_establecimiento\">cod_establecimiento</option>" .
            "<option values=\"subtotal\">subtotal</option>" .
            " <option values=\"cuenta\">cuenta</option> " .
            "<option values=\"tipcta\">tipcta</option>" .
            " <option values=\"tipide\">tipide</option> " .
            "<option values=\"deduccion_impuesto\">deduccion_impuesto</option> " .
            "<option values=\"nombre\">nombre</option>" .
            " <option values=\"direccion\">direccion</option>" .
            " <option values=\"ciudadet\">ciudadet</option>" .
            " <option values=\"valortotal\">valortotal</option> " .
            "</select>";
            */

        // $field_datos .= "<input class=\"form-control col-1\" name=\"gn-" . $row_id . "-cantidad\" value=\" \" type=\"text\" id=\"gn-" . $row_id . "-cantidad\" />";



        // $row_id=null;
        //$field_datos =null;
        return response()->json(['htmlDetalleGenera' => $field_datos, 'last_id' => $row_id]);
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
        $export = array();
        $fijo = array();
        $fecha = array();
        //campos_C , solo esta la fecha falta validacion por parte de la vista 
        // falta de campos_c: contador_secuencia -- identificador
        //{"campoC_3":"contador_secuencia","campoC_4":"Ymd","espacios":"\t","insert_date_18":"M-Y","identificador":"cedula_id"}


        for ($i = 0; $i <= $request->num_elem_export; $i++) {
            foreach ($request as $unique_camp) {
                if (isset($request['gn-' . $i . '-id'])) {
                    if (isset($request['gn-' . $i . '-values'])) {
                        $export[$request['gn-' . $i . '-id']] = $request['gn-' . $i . '-values'];
                    }
                    if (isset($request['gn-' . $i . '-values_base'])) {
                        $export[$request['gn-' . $i . '-id']] = $request['gn-' . $i . '-values_base'];
                    }
                    if (isset($request['gn-' . $i . '-values_fecha'])) {
                    }
                }
            }
        }



        return response()->json(['respuesta' => $datos]);
    }
}
