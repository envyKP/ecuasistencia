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
        "IdentificadoEntrada" => "secuencia"
        "campoIdentificador" => "vale"
        "fechaDebitado" => "fecha_autorizacion"
        "detalle" => "descripcion"
        "formatoFecha" => null
        "valorDebitado" => "total"
        */

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

     /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post_import_guardar_validacion(Request  $request)
    {
        //retornar valor asociado a un cliente 

         /*
        "IdentificadoEntrada" => "secuencia"
        "campoIdentificador" => "vale"
        "fechaDebitado" => "fecha_autorizacion"
        "detalle" => "descripcion"
        "formatoFecha" => null
        "valorDebitado" => "total"
        */

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


     /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post_import_guardar_datos(Request  $request)
    {
        //retornar valor asociado a un cliente 

         /*
        "IdentificadoEntrada" => "secuencia"
        "campoIdentificador" => "vale"
        "fechaDebitado" => "fecha_autorizacion"
        "detalle" => "descripcion"
        "formatoFecha" => null
        "valorDebitado" => "total"
        */

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


}
