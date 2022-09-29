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

    public function uploadArchivos(Request  $request)
    {
        $error = " Algo resulto mal";
        if (isset($request->archivo)) {
            $datosCab = $request->except('_token', 'filtro_cliente', 'filtro_producto', 'filtro_genera', 'estado_cabecera', 'registros_no_cumplen', 'row'); //$fecha = Date('Y-m-d');//$productoDetalle = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
            $extension = $request->file('archivo')->extension();
            $op_client = EaOpcionesCargaCliente::where('cliente',  $request->cliente)->where('subproducto', $request->producto)->first();
            $opciones_validacion = json_decode($op_client->opciones_validacion, true);
            if (isset($opciones_validacion['formato'])) {
                if (strtolower($extension) == $opciones_validacion['formato']) {
                    //dd("llego dentro de la opocion personalizada de formato");
                    $datosCab['fec_carga'] = Date('d/m/Y H:i:s');
                    if ($request->hasfile('archivo')) {
                        $nombre_archivo = $request->file('archivo')->getClientOriginalName();
                        $descripcion = preg_replace('([^A-Za-z0-9 ])', '', $request->desc_producto);
                        $datosCab['archivo'] = $request->file('archivo')->storeAs('lecturaDebito/' . $request->cliente . '/' . $descripcion . '/' . $request->cod_carga, $nombre_archivo, 'public');
                    }
                    $trx = EaCabeceraDetalleCarga::where('desc_producto', (isset($datosCab['desc_producto']) ? $datosCab['desc_producto'] : ''))
                        ->where('producto', (isset($datosCab['producto']) ? $datosCab['producto'] : ''))
                        ->where('cliente', (isset($datosCab['cliente']) ? $datosCab['cliente'] : ''))
                        ->where('cod_carga', (isset($datosCab['cod_carga']) ? $datosCab['cod_carga'] : ''))
                        ->update($datosCab);
                    if ($trx) {
                        $success = "Archivo: " . $nombre_archivo . ", del cliente: " . $request->cliente . " cargado en estado pendiente de guardar/procesar.";
                    }
                } else {
                    $error = "Archivo permitido formato: " . $opciones_validacion['formato'];
                }
            } elseif (strtolower($extension) == 'xls' || strtolower($extension) == 'xlsx') {
                $datosCab['fec_carga'] = Date('d/m/Y H:i:s');
                if ($request->hasfile('archivo')) {
                    $nombre_archivo = $request->file('archivo')->getClientOriginalName();
                    $descripcion = preg_replace('([^A-Za-z0-9 ])', '', $request->desc_producto);
                    $datosCab['archivo'] = $request->file('archivo')->storeAs('lecturaDebito/' . $request->cliente . '/' . $descripcion . '/' . $request->cod_carga, $nombre_archivo, 'public');
                }
                $trx = EaCabeceraDetalleCarga::where('desc_producto', (isset($datosCab['desc_producto']) ? $datosCab['desc_producto'] : ''))
                    ->where('producto', (isset($datosCab['producto']) ? $datosCab['producto'] : ''))
                    ->where('cliente', (isset($datosCab['cliente']) ? $datosCab['cliente'] : ''))
                    ->where('cod_carga', (isset($datosCab['cod_carga']) ? $datosCab['cod_carga'] : ''))
                    ->update($datosCab);
                if ($trx) {
                    $success = "Archivo: " . $nombre_archivo . ", del cliente: " . $request->cliente . " cargado en estado pendiente de guardar/procesar.";
                }
            } else {
                $error = "Archivos permitidos: xls o xlsx";
            }
        } else {
            $detalle_proceso['mensaje'] = isset($success) ? $success : "por favor suba un archivo";
            return response()->json($detalle_proceso);
        }
        $detalle_proceso['estado_cabecera'] = isset($request->estado) ? $request->estado : '';
        $detalle_proceso['desc_producto'] = isset($request->desc_producto) ? $request->desc_producto : '';
        $detalle_proceso['success'] = isset($success) ? $success : '';
        $detalle_proceso['error'] = isset($error) ? $error : '';
        $detalle_proceso['mensaje'] = isset($success) ? $success : $error;
        $detalle_proceso['registros_no_cumplen'] = isset($request->registros_no_cumplen) ? $request->registros_no_cumplen : '';
        return response()->json($detalle_proceso);
    }

    public function procesar(Request $request)
    {
        $cabecera_update = array();
        $registroCarga = EaCabeceraDetalleCarga::where('cod_carga', $request->cod_carga)
            ->where('cliente', $request->cliente)
            ->where('producto', $request->producto)->first();
        $import = (new EaGemCamImport($request->cod_carga, $request->cliente, $request->producto));
        $op_client = EaOpcionesCargaCliente::where('cliente',  $request->cliente)->where('subproducto', $request->producto)->first();
        $opciones_validacion = json_decode($op_client->opciones_validacion, true); // no lo valide aki si no en eaGemCamImport // imposible se usa para validar la extension
        // no opcion a agarrar valor que venga en el txt , debido a que no sabre si es entero o decimal
        if (isset($opciones_validacion['formato'])) {
            //bloque para implementar metodos de formato distinto a xls o xlsx
            //opciones_validacion {'formato':'txt'}
            //produbanco, 
            if ('txt' == $opciones_validacion['formato']) {
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
                    if ($count1 == 0) {
                        /// leer la primera linea echo ($line);
                        $count1++;
                        continue;
                    }
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
            }
        } else {
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
        // \Log::warning('Something could be going wrong.');
        // \Log::error('Something is really going wrong.');
        $varcontrolsecuencia = (isset($request->carga_resp) ? strval($request->carga_resp) : null);
        $detalle_subproducto = ((new EaSubproductoController)->getSubproductoDetalle($request->cliente, $request->producto));
        /*
         $request->cliente,"null",(isset($request->carga_resp) ? strval($request->carga_resp) : null),
        $request->producto,$this->op_client->tipo_subproducto,$request->producto
        */
        dd($request);
        /*
      "_token" => "YReBMQBbrPqvRko6wPYP8yZVNHGCUtMrhfgDkD0M" 
      "carga_resp" => "1"           "cliente" => "INTER"
      "producto" => "15"            "desc_producto" => "ASISTENCIA HOMBRE CTAS"
       "borrar" => null puedo usarlo o crear un campo como opcion adicional , pero tambien debe existir en cabezera 
       la condicion incluso para la descarga o lectura 
       mesclar la id/ en la generacion  y lectura 
      */
        $objEXPORT = new EaGenCamExport($request->cliente, $detalle_subproducto->desc_subproducto, $varcontrolsecuencia, $request->producto, $detalle_subproducto->tipo_subproducto, $request->producto);
        \Log::info('Request : ');
        \Log::info('    $request->cliente : ' . $request->cliente);
        \Log::info('    $request->producto : ' . $request->producto);
        \Log::info('    varcontrolsecuencia : ' . $varcontrolsecuencia);
        $row_insert_detalle['id_carga'] = $request->carga_resp;
        $row_insert_detalle['producto'] = $request->producto;
        $row_insert_detalle['subproducto'] = $request->producto;
        $row_insert_detalle['cliente'] = $request->cliente;
        $row_insert_detalle['estado'] = "0";
        //dd($objEXPORT->is_carga_older());
        if (isset(($objEXPORT->is_carga_older($request->cliente, $request->producto)->id_carga))) {
            if ($varcontrolsecuencia == ($objEXPORT->is_carga_older($request->cliente, $request->producto)->id_carga)) {
                \Log::warning('se destruyo la carga :' . $row_insert_detalle['id_carga']);
                $objEXPORT->destroy_cab_detalle($varcontrolsecuencia, $request->cliente, $request->producto);
                $success = 'Borrado registros de : Id_carga =' . $row_insert_detalle['id_carga'] . ' - cliente -' . $row_insert_detalle['cliente'] . ' - producto  : ' . $detalle_subproducto->desc_subproducto;
            } else {
                \Log::info('No pudo destruirse la carga');
                $errorTecnico = 'disculpe el inconveniente no pudo eliminarse el reguistro por favor compruebe que no existe una carga superior al registro que desea eliminar';
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

    private function getFilePath($filePath = null)
    {
        $filePath = $filePath ?? $this->filePath ?? null;
        if (null === $filePath) {
            throw NoFilePathGivenException::import();
        }

        return $filePath;
    }
}
