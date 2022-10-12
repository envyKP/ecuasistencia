<?php

namespace App\Http\Controllers;


use App\Models\EaCabeceraDetalleCarga;
use Illuminate\Http\Request;
use App\Http\Controllers\EaClienteController;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EaGemCamImport;
use App\Http\Controllers\EaBaseActivaController;
use App\Http\Controllers\EaProductoController;
use App\Http\Controllers\EaCabCargaInicialBitacoraController;
use App\Http\Controllers\EaDetalleCargaCorpController;
use App\Exports\EaReporteCargaInicialExport;
use App\Models\EaCliente;
use App\Exports\EaGenCamExport;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Search;
use App\Models\EaOpcionesCargaCliente;
use Maatwebsite\Excel\Exceptions\NoFilePathGivenException;

class EaCargaIndividualImport extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes =  (new EaClienteController)->getAllCampanas();

        $resumen_cabecera = EaCabeceraDetalleCarga::select(
            '*',
            ///EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
        )
            ->where('is_det_debito', '1')
            ->where('estado', 'PENDIENTE')
            ->orderBydesc('fec_registro')
            ->paginate(15);
        /*
        $resumen_cabecera = EaCabeceraDetalleCarga::select(
            'cod_carga',
            'proceso',
            'cliente',
            'producto',
            'desc_producto',
            'fec_carga',
            'archivo',
            'usuario_registra',
            EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
            'fec_registro',
            'estado',
            'is_det_debito',
            'usuario_actualiza',
            'opciones_validacion',
            'ruta_gen_debito'
        )
            ->where('is_det_debito', '1')
            ->where('estado', 'PENDIENTE')
            ->orderBydesc('fec_registro2')
            ->paginate(15);
        */
        /*
        $resumen_cabecera = EaCabeceraDetalleCarga::where('is_det_debito', '1')
            ->where('estado', 'PENDIENTE')
            ->orderBydesc('fec_registro')
            ->orderBydesc('cod_carga')
            ->paginate(15);
        */
        return view('cargaIndividualI.home')->with(compact('clientes'))
            ->with(isset($resumen_cabecera) ? compact('resumen_cabecera') : '');
    }

    public function detalleCarga()
    {
        return view('cargaIndividualI.detalleCarga');
    }

    public function store(Request $request)
    {
        return redirect()->route('EaClienteController.index')->with([
            'cliente' => $request->cliente,
            'trxcliente' => 'store'
        ]);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function condicion_opciones_cabezera($valores)
    {
        $campos_opciones = array();
        if (isset($valores)) {
            $campos_opciones['campo'] = 'ea_cabecera_detalle_carga.n_custom_code';
            $campos_opciones['valor'] = $valores;
        } else {
            $campos_opciones['campo'] = 'ea_cabecera_detalle_carga.is_det_debito';
            $campos_opciones['valor'] = '1';
        }
        return $campos_opciones;
    }


    private function control_archivos($datosCab, $request, $op_client)
    {
        $datosCab['fec_carga'] = Date('d/m/Y H:i:s');
        if ($request->hasfile('archivo')) {
            $nombre_archivo = $request->file('archivo')->getClientOriginalName();
            $descripcion = preg_replace('([^A-Za-z0-9 ])', '', $op_client->archivo_nombre);
            if (isset($request->opciones_data)) {
                $datosCab['archivo'] = $request->file('archivo')->storeAs('lecturaDebito/' . $request->cliente . '/' . $descripcion . '/' . $request->cod_carga . '/' . $request->opciones_data, $nombre_archivo, 'public');
            } else {
                $datosCab['archivo'] = $request->file('archivo')->storeAs('lecturaDebito/' . $request->cliente . '/' . $descripcion . '/' . $request->cod_carga, $nombre_archivo, 'public');
            }
        }
        $valores_campo_opciones = isset($request->opciones_data) ? $request->opciones_data : null;
        $campos_opciones = $this->condicion_opciones_cabezera($valores_campo_opciones);
        $trx = EaCabeceraDetalleCarga::where('producto', (isset($datosCab['producto']) ? $datosCab['producto'] : ''))
            ->where($campos_opciones['campo'], $campos_opciones['valor'])
            ->where('cod_carga', (isset($datosCab['cod_carga']) ? $datosCab['cod_carga'] : ''))
            ->update($datosCab);
        if ($trx) {
            $success = "Archivo: " . $nombre_archivo . ", del cliente: " . $request->cliente . " cargado en estado pendiente de guardar/procesar.";
        }
        $control_archivos = array();
        $control_archivos['success'] = isset($success) ?  $success : null;
        return $control_archivos;
    }


    public function uploadArchivos(Request  $request)
    {
        //$error = " Algo resulto mal";
        $error = "";
        $success = "";
        if (isset($request->archivo)) {
            $datosCab = $request->except('_token', 'filtro_cliente', 'filtro_producto', 'filtro_genera', 'estado_cabecera', 'registros_no_cumplen', 'row'); //$fecha = Date('Y-m-d');//$productoDetalle = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
            $extension = $request->file('archivo')->extension();
            $op_client = EaOpcionesCargaCliente::where('codigo_id', $request->producto)->first();
            $opciones_validacion = json_decode($op_client->opciones_validacion, true);
            if (isset($opciones_validacion['formato'])) {
                if (strtolower($extension) == $opciones_validacion['formato']) {
                    // iniio de metodo para crear codigo recursivo                    
                    $control_archivos = $this->control_archivos($datosCab, $request, $op_client);
                    $success = $control_archivos['success'];
                    // fin metodo , para crear codigo recursivo
                } else {
                    $error = "Archivo permitido formato: " . $opciones_validacion['formato'];
                }
            } elseif (strtolower($extension) == 'xls' || strtolower($extension) == 'xlsx') {
                $control_archivos = $this->control_archivos($datosCab, $request, $op_client);
                $success = $control_archivos['success'];
            } else {
                $error = "Archivos permitidos: xls o xlsx";
            }
        } else {
            $detalle_proceso['mensaje'] = isset($success) ? $success : "por favor suba un archivo";
            return response()->json($detalle_proceso);
        }
        $detalle_proceso['estado_cabecera'] = isset($request->estado) ? $request->estado : '';
        $detalle_proceso['desc_producto'] = isset($op_client->archivo_nombre) ? $op_client->archivo_nombre : '';
        $detalle_proceso['success'] = isset($success) ? $success : '';
        $detalle_proceso['error'] = isset($error) ? $error : '';
        $detalle_proceso['mensaje'] = isset($success) ? $success : $error;
        $detalle_proceso['registros_no_cumplen'] = isset($request->registros_no_cumplen) ? $request->registros_no_cumplen : '';
        return response()->json($detalle_proceso);
    }










    // solo tiene que reconocer 2 cosas opciones_id y aparte el original carga y subproducto_id
    public function procesar(Request $request)
    {
        //falta el campo para opcion
        //n_custom_code//listo
        /**
      "cod_carga" => "1"
      "cliente" => "INTER"
      "producto" => "4"
      "desc_producto" => "ASISTENCIA HOMBRE TC"
      "estado_cabecera" => "PENDIENTE"
      "n_custom_code" => null
         */
        dd($request);
        $cabecera_update = array();
        $registroCarga = EaCabeceraDetalleCarga::where('cod_carga', $request->cod_carga)
            ->where('cliente', $request->cliente)
            ->where('producto', $request->producto)
            ->first();
        $import = (new EaGemCamImport($request->cod_carga, $request->cliente, $request->producto, $request));
        $op_client = EaOpcionesCargaCliente::where('cliente',  $request->cliente)->where('subproducto', $request->producto)->first();
        $opciones_validacion = json_decode($op_client->opciones_validacion, true); // no lo valide aki si no en eaGemCamImport // imposible se usa para validar la extension
        // no opcion a agarrar valor que venga en el txt , debido a que no sabre si es entero o decimal

        $formato = "";
        if (isset($opciones_validacion['formato'])) {
            $formato = $opciones_validacion['formato'];
            /*if ('txt' == $opciones_validacion['formato']) {}*/
        } else {
        }

        // metodo dividido 
        switch ($formato) {
            case 'txt':
                /*
            metodo de lectura de txt , por espaciado , como se implementaria ? existe limite se puede usar la misma estructura implementada en el collector()
            */
                $opciones_validacion = null;
                $opciones_import = null;
                if (isset($op_client->opciones_validacion) && isset($op_client->campos_import)) {
                    $opciones_import = json_decode($op_client->campos_import, true);
                    $opciones_validacion = json_decode($op_client->opciones_validacion, true);
                } else {
                    $cabecera_update['estado'] = 'ERROR';
                    $detalle_proceso['errorTecnico'] = "No pudo terminar la operacion revise la configuracion ";
                    $import->detalle_proceso['msg'] = "error tecnico : " . $detalle_proceso['errorTecnico'];
                    $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $request->producto, $cabecera_update);
                    return response()->json(['success' => $import->detalle_proceso['msg']]);
                }
                $fh = fopen(public_path('storage\\' . $this->getFilePath($registroCarga->archivo)), 'r');
                $count1 = 0;
                while ($line = fgets($fh)) {
                    
                    // creado para saltar la primera linea // no lo hare editable// exclusivo para Produbanco
                    // solo debe leer tarjeta si existe ha sido debitado
                   
                    // no nescesario en la lectura , si en la creacion 
                   /*
                    if ($count1 == 0) {
                        /// leer la primera linea echo ($line);
                        $count1++;
                        continue;
                    }
                    */

                    //$opciones_validacion['definicion'] --> cambiar luego de insertar una estructura 
                    //$opciones_validacion['limite']// nueva variable a insertar 
                    // algo como secuencia_:
                    // secuencia_v_:
                    // 1:tarjeta
                    // 2 : fecha
                    // 3 : secuencia
                    // solo nescesitaria esto en cualquier lectura de archivo
                    // if () isset si no existe , salta y quema algo 
                    //inacceciu
                    // no es posible crear un bucle dentro del mismo while para manejar las validadciones en base 
                    /*
                for ($i = 0; $i < $opciones_validacion['limite']; $i++) {
                    echo "\n" . (substr($line, $opciones_validacion['campo_' . $i], $opciones_validacion['valor_' . $i]));
                }*/
                    //{"validacion_campo_1":"tip_afecta","validacion_valor_1":"0","num_validacion":"1","identificador_secuencia":"tarjeta"}//opciones validacion
                    //{"tarjeta":"6,16","fecha_actual":"26,6","detalle":"32,8"}//campos import
                    // utilizo for o directamente uso variables, llamaria 10 variables , en vez de simplemente continuar ?
                    // for es confiable, esta vez el json sera en pares.
                    //{"campo_1":0,"valor_1":6,"campo_2":6,"valor_2":16,"campo_3":22,"valor_3":4,"campo_4":26,"valor_4":6,"campo_5":32,"valor_5":8, }
                    $opciones_import[$opciones_validacion['identificador_secuencia']]; // $opciones_import['tarjeta'] = 6,16 // no usa el nombre de campo si no numero 
                    //$secuencia = $opciones_import[$opciones_validacion['identificador_secuencia']];
                    if (isset($opciones_import[$opciones_validacion['identificador_secuencia']])) {
                        $limite_secuencia = explode(",", $opciones_import[$opciones_validacion['identificador_secuencia']]); // deberia separalos con el , volviendo array la variable
                        $identificador_secuencia =  substr($line, $limite_secuencia[0], $limite_secuencia[1]);
                    } else {
                        $cabecera_update['estado'] = 'ERROR';
                        $detalle_proceso['errorTecnico'] = "No pudo terminar la operacion revise la configuracion en el limite secuencia";
                        $import->detalle_proceso['msg'] = "error tecnico : " . $detalle_proceso['errorTecnico'];
                        $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $request->producto, $cabecera_update);
                        return response()->json(['success' => $import->detalle_proceso['msg']]);
                    }
                    if (isset($opciones_import['fecha_actualizacion'])) {
                        $limite_secuencia = explode(",", $opciones_import['fecha_actualizacion']); // deberia separalos con el , volviendo array la variable
                        $fecha_actualizacion =  substr($line, $limite_secuencia[0], $limite_secuencia[1]);
                        $actualdate = date('Y-m-d');
                        $input = (isset($row[$opciones_import['fecha_actualizacion']])) ? $row[$opciones_import['fecha_actualizacion']] : $actualdate;
                        $date = date('Y-m-d', strtotime($input));
                        $updateRow['fecha_actualizacion'] =  $date;
                    } else {
                    }
                    if (isset($opciones_import['detalle'])) {
                        $limite_secuencia = explode(",", $opciones_import['detalle']); // deberia separalos con el , volviendo array la variable
                        $detalle =  substr($line, $limite_secuencia[0], $limite_secuencia[1]);
                    } else {
                    }
                    /**nop lo que venga en el txt significara que es un valor debitado
                     * // generar una condicion que solo valide que cambie de estado si existe el identificador
                     */
                    // distincion entre tarjeta y cuenta , para el insert , el inser deberia ser el mismo que el que se usa en el collection()
                    // de verdad lo implementare de esta forma , es toda una estructura nueva practicamente , 
                    // unicamente para el texto haciendo inviable o mas dificil el almacenamiento en formulario para base 
                    /*
                if(tarjeta || cuenta){}elseif(secuencia || cedula){}if (isset($opciones_validacion['secuencia'])) {echo "\n" . (substr($line, 0, 6)); // secuencia}
                if (isset($opciones_validacion['secuencia'])) {    echo "\n" . (substr($line, 0, 6)); // secuencia}if (isset($opciones_validacion['secuencia'])) {    echo "\n" . (substr($line, 0, 6)); // secuencia}if (isset($opciones_validacion['secuencia'])) {    echo "\n" . (substr($line, 0, 6)); // secuencia}echo "\n" . (substr($line, 0, 6)); // secuenciaecho "<===>"; // limboecho "\n" . (substr($line, 6, 16)); // tarjetaecho "<===>"; // limboecho "\n" . (substr($line, 22, 4)); // 0000echo "<===>"; // limboecho "\n" . (substr($line, 26, 6)); //fecha y mes talvez ?echo "<===>";echo "\n" . (substr($line, 32, 8)); //02320101 //descripcion o aprovacion $count1++;
                */
                    //poner una condicion con breack y adicional llenar el campo $detalle_proceso['errorTecnico'] = 
                }
                fclose($fh);
                if (!empty($detalle_proceso['errorTecnico'])) {
                    $cabecera_update['estado'] = 'ERROR';
                    $import->detalle_proceso['msg'] = "error tecnico : " . $detalle_proceso['errorTecnico'];
                    $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $request->producto, $cabecera_update);
                    return response()->json(['success' => $import->detalle_proceso['msg']]);
                } else {
                    try {
                        $cabecera_update['estado'] = 'PROCESADO';
                        $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $request->producto, $cabecera_update);
                        return response()->json($import->detalle_proceso);
                    } catch (\Exception $e) {
                        $errorTecnico = $e->getMessage();
                        return response()->json($errorTecnico);
                    }
                }



                // terminacion metodo de texto
                break;

            default:
                /*case 'xls':break;
            case 'xlsx':break;*/
                // Por defecto es xls y xlsx procesar
                $import->import($registroCarga->archivo, 'public'); // metodo para EXCEL 
                if (!empty($import->detalle_proceso['errorTecnico'])) {
                    $cabecera_update['estado'] = 'ERROR';
                    $errorTecnico = $import->detalle_proceso['errorTecnico'];
                    //puedo simplemente invocar la cabezera en caso que cordine o un isset con el campo y un else ok 
                    if (isset($opciones_validacion['union_subproductos'])) {
                        $producto = explode('', $opciones_validacion['union_subproductos']);
                        foreach ($producto as $prod_id) {
                            //probar el dato de $prod_id , de esto depende si existe la lectura de varior archivos
                            $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $prod_id, $cabecera_update);
                        }
                        return response()->json(['success' => $import->detalle_proceso['msg']]);
                    } else {
                        $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $request->producto, $cabecera_update);
                        return response()->json(['success' => $import->detalle_proceso['msg']]);
                    }
                } else {
                    try {
                        $cabecera_update['estado'] = 'PROCESADO';
                        $this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $request->producto, $cabecera_update);
                        return response()->json($import->detalle_proceso);
                    } catch (\Exception $e) {
                        $errorTecnico = $e->getMessage();
                        return response()->json($errorTecnico);
                    }
                }
                return response()->json(['success' => 'Procesado Existosamente']);
                break;
        }

        return response()->json(['success' => 'Existe un inconveniente']);
    }
















    public function update_datos_cab_carga($cliente, $cod_carga, $producto, array $datos)
    {

        $trx =  EaCabeceraDetalleCarga::where('cliente', $cliente)
            ->where('cod_carga', $cod_carga)
            ->where('producto', $producto)
            ->update($datos);
        return $trx;
    }


    public function existe_duplicado($cliente, $cod_carga, $producto, array $datos)
    {
        $trx =  EaCabeceraDetalleCarga::where('cliente', $cliente)
            ->where('cod_carga', $cod_carga)
            ->where('producto', $producto)
            ->update($datos);
        return $trx;
    }

    private function error_return_view()
    {
        $cabecera_update['estado'] = 'ERROR';
        $detalle_proceso['errorTecnico'] = "No pudo terminar la operacion revise la configuracion ";
        $detalle_proceso['msg'] = "error tecnico : " . $detalle_proceso['errorTecnico'];
        //$this->update_datos_cab_carga($registroCarga->cliente, $request->cod_carga, $request->producto, $cabecera_update);
        return response()->json(['success' => $detalle_proceso['msg']]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request)
    {
        dd($request);
        \Log::info('FUNCION DESTROY: ');
        \Log::warning('usuario que realiza la orden DESTROY: ' . \Auth::user()->username);
        $objEXPORT = new EaGenCamExport($request);
        \Log::info('Request : ');
        \Log::info('    $request->cliente : ' . $request->cliente);
        \Log::info('    $request->producto : ' . $request->producto);
        // \Log::info('    varcontrolsecuencia : ' . $varcontrolsecuencia);
        $row_insert_detalle['id_carga'] = $request->carga_resp;
        $row_insert_detalle['producto'] = $request->producto;
        $row_insert_detalle['subproducto'] = $request->producto;
        $row_insert_detalle['cliente'] = $request->cliente;
        $row_insert_detalle['estado'] = "0";
        $varcontrolsecuencia = $request->carga_resp;
        if (isset(($objEXPORT->is_carga_older_solo_id($request->n_custom_code)->id_carga))) {
            if ($varcontrolsecuencia == ($objEXPORT->is_carga_older($request->cliente, $request->producto)->id_carga)) {
                \Log::warning('se destruyo la carga :' . $row_insert_detalle['id_carga']);
                $adicional_opcion = isset($request->n_custom_code) ? $request->n_custom_code : null;
                //dd($adicional_opcion);
                $objEXPORT->destroy_cab_detalle($varcontrolsecuencia, $request->cliente, $request->producto, $adicional_opcion);
                $success = 'Borrado registros de : Id_carga =' . $row_insert_detalle['id_carga'] . ' - cliente -' . $row_insert_detalle['cliente'] . ' - producto  : ';
            } else {
                \Log::info('No pudo destruirse la carga');
                $errorTecnico = 'disculpe el inconveniente no pudo eliminarse el reguistro por favor compruebe que no existe una carga superior al registro que desea eliminar';
                //abort(409, $errorTecnico);
            }
        } else {
            $objEXPORT->destroy_cab($varcontrolsecuencia, $request->cliente, $request->producto);
            return redirect()->route('EaCargaIndividualImport.index')->with([
                'success' =>  'no existe registro en tabla detalle se elimino datos en cabezera'
            ]);
        }
        return redirect()->route('EaCargaIndividualImport.index')->with([
            'success' => isset($success) ? $success : '',
            'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : ''
        ]);
    }

    // pensado como metodo para usarse junto a un toquen o boton en campañas almacenadas
    public function destroy_detalles_debito($request)
    {
        $objEXPORT = new EaGenCamExport($request);
        // debe tener estos valores el array llamado request , armar un array y enviarlo a este metodo para borrar
        /*
      "carga_resp" => "2"
      "cliente" => "PRODUBANCO"
      "producto" => "20"
      "n_custom_code" => "3"
      "desc_producto" => "ASISTENCIA TOTAL Y TOTAL PLUS"
        */
        $varcontrolsecuencia = $request->carga_resp;
        if (isset(($objEXPORT->is_carga_older_solo_id($request->n_custom_code)->id_carga))) {
            if ($varcontrolsecuencia == ($objEXPORT->is_carga_older($request->cliente, $request->producto)->id_carga)) {

                $adicional_opcion = isset($request->n_custom_code) ? $request->n_custom_code : null;
                //dd($adicional_opcion);
                $objEXPORT->destroy_cab_detalle($varcontrolsecuencia, $request->cliente, $request->producto, $adicional_opcion);
                $success = 'Borrado registros';
            } else {
                \Log::info('No pudo destruirse la carga');
                $errorTecnico = 'disculpe el inconveniente no pudo eliminarse el reguistro';
                //abort(409, $errorTecnico);
            }
        }
        // por el moemnto esto es un metodo solo para borrar
        /* return redirect()->route('EaCargaIndividualImport.index')->with([
            'success' => isset($success) ? $success : '',
            'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : ''
        ]);*/
    }

    private function getFilePath($filePath = null)
    {
        $filePath = $filePath ?? $this->filePath ?? null;
        if (null === $filePath) {
            throw NoFilePathGivenException::import();
        }
        return $filePath;
    }
}
