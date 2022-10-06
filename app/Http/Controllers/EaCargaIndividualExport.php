<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EaCabeceraCargaCorp;
use App\Models\EaCabeceraDetalleCarga;
use App\Http\Controllers\EaClienteController;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\EaSubproductoController;
use App\Models\EaOpcionesCargaCliente;
use App\Models\EaCliente;
use App\Models\EaDetalleDebito;
use App\Exports\EaGenCamExport;
use Carbon\Carbon;
//use App\Models\EaProducto;
//use App\Models\EaSubproducto;
//use App\Imports\EaDetCargaCorpImport;
//use App\Http\Controllers\EaBaseActivaController;
//use App\Http\Controllers\EaProductoController;
//use App\Http\Controllers\EaParaInsert;
//use App\Http\Controllers\EaCabCargaInicialBitacoraController;
//use App\Http\Controllers\EaDetalleCargaCorpController;
//use Maatwebsite\Excel\Concerns\Exportable;
//use App\Exports\UsersExport;

//use Illuminate\Http\Response;


require_once "../vendor/autoload.php";

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Illuminate\Support\Arr;
use PhpParser\Node\Expr\Cast\Double;
use PhpParser\Node\Stmt\Break_;

class EaCargaIndividualExport extends Controller
{
    /**
     * Display a listing of the resource.
     * En memoria de FIDO "Gordito"
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes =  (new EaClienteController)->getAllCampanas();
        $RegistrosPendientes = EaCabeceraCargaCorp::where('estado', 'PENDIENTE')->where('is_det_debito', '1')
            ->orderBy('cliente')->paginate(5);
        return view('cargaIndividual.home')->with(compact('clientes'))
            ->with(compact('RegistrosPendientes'));
    }
    /**
     * en memoria de FIDO "Gordito"
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exporta(Request $request)
    {
        //abort(404, ' Configuracion faltante en tabla opciones subproductos');
        try {
            if ($request->btn_genera == 'buscar') {
                $clientes =  (new EaClienteController)->getAllCampanas();
                //\Log::info('funcion exporta clase EaCargaIndividualExport :' . $request->cliente . '    ???   ' . $request->producto);
                if (isset($request->cliente)) {
                    //\Log::info('Consulta a cliente :' . $request->cliente);
                    $resumen_cabecera = EaCabeceraDetalleCarga::select(
                        '*',
                        //EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
                    )->orderBydesc('fec_registro')
                        ->where('is_det_debito', '1')
                        ->where('cliente', $request->cliente)
                        ->paginate(15);
                    if (isset($request->producto)) {
                        \Log::info('Consulta a cliente :' . $request->cliente . ' ' . $request->producto);
                        $resumen_cabecera = EaCabeceraDetalleCarga::select(
                            '*',
                            // EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
                        )->orderBydesc('fec_registro')
                            ->where('is_det_debito', '1')
                            ->where('cliente', $request->cliente)
                            ->where('producto', $request->producto)
                            ->paginate(15);
                    }
                }
                if (isset($request->state)) {
                    $resumen_cabecera = EaCabeceraDetalleCarga::select(
                        '*',
                        //EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
                    )->orderBydesc('fec_registro')
                        ->where('is_det_debito', '1')
                        ->where('estado', $request->state)
                        ->paginate(15);
                    if (isset($request->cliente)) {
                        $resumen_cabecera = EaCabeceraDetalleCarga::select(
                            '*',
                            // EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
                        )->orderBydesc('fec_registro')
                            ->where('is_det_debito', '1')
                            ->where('estado', $request->state)
                            ->where('cliente', $request->cliente)
                            ->paginate(15);
                        if (isset($request->producto)) {
                            $resumen_cabecera = EaCabeceraDetalleCarga::select(
                                '*',
                                //     EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
                            )->orderBydesc('fec_registro')
                                ->where('is_det_debito', '1')
                                ->where('estado', $request->state)
                                ->where('cliente', $request->cliente)
                                ->where('producto', $request->producto)
                                ->paginate(15);
                        }
                    } elseif (isset($request->producto)) {
                        $resumen_cabecera = EaCabeceraDetalleCarga::select(
                            '*',
                            //   EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
                        )->orderBydesc('fec_registro')
                            ->where('is_det_debito', '1')
                            ->where('estado', $request->state)
                            ->where('producto', $request->producto)
                            ->paginate(15);
                    }
                }
                return view('cargaIndividualI.home')
                    ->with(compact('clientes'))
                    ->with(isset($resumen_cabecera) ? compact('resumen_cabecera') : '');
            } else {
                if (isset($request->cliente) || isset($request->desc_subproducto)) {
                    if (!isset($request->carga_resp)) {
                        $this->op_client = EaOpcionesCargaCliente::where('codigo_id', $request->producto)->first();
                        $this->opciones_fijas = json_decode($this->op_client->opciones_fijas, true);
                        $this->campos_export = json_decode($this->op_client->campos_export, true);
                        $this->campoC = json_decode($this->op_client->campoc, true);
                        $this->campo0 = json_decode($this->op_client->campo0, true);
                        $this->op_caracteristica_ba = json_decode($this->op_client->op_caracteristica_ba, true);
                        if (isset($this->op_caracteristica_ba['campo_ba'])) {
                            $request['opcion_campo'] = $this->op_caracteristica_ba['campo_ba'];
                        }

                        $textoPlano = "";
                        $this->cont = 0;
                        if (isset($this->op_client['subproducto'])) {
                            ///bloque de repeticion
                            $prod_id = explode(',', $this->op_client['subproducto']);
                            //ya no tiene realacion con el subproducto de prod si no el de la base en detalles_debitos
                            $ultima_carga = $this->ultima_carga_subproducto($request);
                            $ultima_carga = ($ultima_carga != null ? $ultima_carga : null);
                            if (isset($ultima_carga['id_carga'])) {
                                $ultima_carga['id_carga'] = $ultima_carga['id_carga'] + 1;
                            } else {
                                $ultima_carga['id_carga'] = 1;
                            }
                            $this->ultima_carga = ($ultima_carga != null ? $ultima_carga : null);
                            $conut_adicionales = 0;

                            foreach ($prod_id as $producto) {
                                $conut_adicionales++;
                                $this->detalle_subproducto = ((new EaSubproductoController)->getSubproductoDetalle($request->cliente, $producto));
                                $objEXPORT = new EaGenCamExport(
                                    $request,
                                    $this->detalle_subproducto
                                );
                                $generacion_txt = $this->genera_cadena_subproducto($objEXPORT, $request,  $textoPlano);
                                if (($conut_adicionales < count($prod_id))) {
                                    $textoPlano = $textoPlano . $generacion_txt['textoPlano'];
                                } elseif (($conut_adicionales == count($prod_id))) {
                                    $textoPlano = $generacion_txt['textoPlano'];
                                }
                                if ($textoPlano == "") {
                                    $textoPlano = $textoPlano . $generacion_txt['textoPlano'];
                                }
                            }
                            //dd($conut_pruebas);
                            if (isset($campoC["frase"])) {
                                switch ($request->cliente) {
                                    case 'BGR':
                                        $contador_bgr = 1; // iniciaba el contador aki , y seguia hasta terminar 
                                        // no deberia ser nescesario en la parte de general , ya que el contador normal deberia servir 
                                        $time = strtotime(date("Y-m-d"));
                                        $num2 = 30; // añadir validacion a extraer 
                                        $final = date("Y-m-d", strtotime(" -" . $num2 . " day ", $time));
                                        $primera_linea = str_replace("{{date}}", $final, $this->campoC["frase"]);
                                        $primera_linea .= "\n";
                                        $primera_linea = $primera_linea . $textoPlano;
                                        $textoPlano = $primera_linea;
                                        break;
                                        /*
                                    case 'PRODUBANCO':
                                        if (isset($campoC["fraseF"])) {
                                        } else {
                                            $aproximado_calculo = $generacion_txt['count_recorrido'] * $this->detalle_subproducto['valortotal'];
                                            $textoPlano .= $campoC["frase"] . $this->cont . " " . $aproximado_calculo . " "; //CALCULO
                                            $textoPlano .= "\n";
                                        }
                                        break;
                                        */
                                    default:
                                        //$textoPlano .= $campoC["frase"];
                                        break;
                                }
                            }
                            $tiempo_final = microtime(true);
                            \Log::info('tiempo que termina : ' . $tiempo_final);
                            $extension_file = ".";
                            if (isset($this->campoC["extension"])) {
                                $extension_file .= $this->campoC["extension"];
                            } else {
                                $extension_file .= "txt";
                            }
                            $id_carga = (isset($this->ultima_carga['id_carga']) ? $this->ultima_carga['id_carga'] : 1);
                            $fecha_generacion = (isset($this->ultima_carga->fecha_generacion) ? $this->ultima_carga->fecha_generacion : 0);
                            //bloque de insertar cabezera detalle
                            /*
                        $file_reg_carga = array();
                        $file_reg_carga['cod_carga'] = $id_carga;
                        $file_reg_carga['cliente'] = $request->cliente;
                        $file_reg_carga['producto'] = $request->producto;
                        $file_reg_carga['fec_carga'] = $fecha_generacion;
                        $file_reg_carga['usuario'] = \Auth::user()->username;
                        */
                            $fileName = ($id_carga) . $extension_file;
                            //$file_reg_carga['ruta_gen_debito'] 
                            //$ruta_gen_debito = 'storage/generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . date('Y') . '/' . $fileName;
                            $file_reg_carga['cod_carga'] = $id_carga;
                            //$file_reg_carga['proceso'];
                            $file_reg_carga['cliente'] = $request->cliente;
                            $file_reg_carga['producto'] = $request->producto;
                            $file_reg_carga['desc_producto'] = $this->op_client['archivo_nombre']; // $request->producto;
                            $file_reg_carga['fec_carga'] = $fecha_generacion;
                            //$file_reg_carga['archivo'];
                            $file_reg_carga['usuario_registra'] = \Auth::user()->username;
                            $file_reg_carga['fec_registro'] = Carbon::now();
                            $file_reg_carga['estado'] = 'PENDIENTE';
                            $file_reg_carga['is_det_debito'] = '1';
                            //$file_reg_carga['usuario_actualiza'];
                            $file_reg_carga['custom_code'] = isset($request['opcion_campo']) ? $request['opcion_campo'] : null;
                            $file_reg_carga['n_custom_code'] =  isset($request->opciones_data) ? $request->opciones_data : null;
                            if (isset($request->opciones_data)) {
                                if (isset($this->op_caracteristica_ba['campo_ba'])) {
                                    for ($i = 1; $i <= $this->op_caracteristica_ba['total']; $i++) {
                                        if ($this->op_caracteristica_ba['var_camp_' . $i] == $request->opciones_data) {
                                            $file_reg_carga['opciones_validacion'] = $this->op_caracteristica_ba['var_val_' . $i];
                                        }
                                    }
                                }
                                //$fileName = ($id_carga) . $extension_file;
                                Storage::disk('public')->makeDirectory('generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . $request->opciones_data . '/' . date('Y'));
                                file_put_contents(public_path('storage/generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . $request->opciones_data . '/' . date('Y') . '/' . $fileName), $textoPlano);
                                $ruta_gen_debito = 'storage/generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . $request->opciones_data . '/' . date('Y') . '/' . $fileName;
                            } else {
                                $ruta_gen_debito = 'storage/generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . date('Y') . '/' . $fileName;
                                Storage::disk('public')->makeDirectory('generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . date('Y'));
                                file_put_contents(public_path('storage/generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . date('Y') . '/' . $fileName), $textoPlano);
                            }
                            //$file_reg_carga['opciones_validacion'] = isset($this->op_client['op_caracteristica_ba'])? $this->op_client['op_caracteristica_ba']: null;
                            $file_reg_carga['ruta_gen_debito'] = isset($ruta_gen_debito) ? $ruta_gen_debito : '';
                            //$file_reg_carga['fecha_registro'] = date('d/m/Y H:i:s');
                            $success = 'se genero exitosamente , se procede a realizar la descarga';
                            //dd($file_reg_carga);
                            $objEXPORT->registro_cargas($file_reg_carga);
                            return redirect()->route('EaCargaIndividualImport.index')->with([
                                'success' => isset($generacion_txt['success']) ? $generacion_txt['success'] : '',
                                'generacionVal' => isset($generacion_txt['success']) ? '200' : '',
                                'carga_resp' => ($id_carga),
                                'producto' => isset($request->producto) ? $request->producto : '',
                                'cliente' => isset($request->cliente) ? $request->cliente : '',
                                'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : '',
                                'registros_no_cumplen' => isset($registros_no_cumplen) ? $registros_no_cumplen : ''
                            ]);
                            //return response()->json(['success' => $import->detalle_proceso['msg']]);
                        } else {
                            abort(404, ' Configuracion faltante en tabla opciones subproductos');
                        }
                    } else {
                        $this->op_client = EaOpcionesCargaCliente::where('codigo_id', $request->producto)->first();
                        $prod_id = explode(',', $this->op_client['subproducto']);
                        $objEXPORT = new EaGenCamExport(
                            $request
                        );
                        $file_reg_carga = array();
                        $file_reg_carga['cod_carga'] = strval($request->carga_resp);
                        $file_reg_carga['cliente'] = $request->clinte;
                        $file_reg_carga['producto'] = $request->producto;
                        $extension_file = ".";
                        if (isset($campoC["extension"])) {
                            $extension_file .= $campoC["extension"];
                        } else {
                            $extension_file .= "txt";
                        }
                        $ruta =  $objEXPORT->ruta_carga(); // unico metodo que usa el objexport
                        //$this->detalle_subproducto cambiar al campo personalizado que proviene directamente de opciones, opciones debe ser gol
                        $res = preg_replace('([^A-Za-z0-9 ])', ' ', $this->op_client->archivo_nombre);
                        //$detalle_subproducto->desc_subproducto
                        $fileName = $request->cliente . "-" . $res . "-" . date("d-m-Y") . "-" . strval($request->carga_resp) . $extension_file;
                        $headers = [
                            'Content-type' => 'text/plain',
                            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
                        ];
                        $file = public_path() . '/' . $ruta->ruta_gen_debito;
                        return Response::download($file, $fileName, $headers);
                        //https://www.adictosaltrabajo.com/2015/01/29/regexsam/
                    }
                } else {
                    return redirect()->route('EaCargaIndividualImport.index')->with([
                        'success' => isset($success) ? $success : '',
                        'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : 'Disculpe los inconvenientes puede que usted no selecciono el cliente o subproducto',
                        'registros_no_cumplen' => isset($registros_no_cumplen) ? $registros_no_cumplen : ''
                    ]);
                }
                return redirect()->route('EaCargaIndividualImport.index')->with([
                    'success' => isset($success) ? $success : '',
                    'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : 'hubo un error disculpe los inconvenientes',
                    'registros_no_cumplen' => isset($registros_no_cumplen) ? $registros_no_cumplen : ''
                ]);
            }
        } catch (\Exception $e) {
            abort(409);
        }
    }

    private function genera_cadena_subproducto($objEXPORT, $request, $textoPlano)
    {
        try {
            $campo0 = $this->campo0;
            $campoC = $this->campoC;
            $opciones_fijas = $this->opciones_fijas;
            $op_client = $this->op_client;
            $campos_export = $this->campos_export;
            //$detalle_subproducto = $this->detalle_subproducto;
            $contenido = file_get_contents("../salsa.txt");
            $clave = Key::loadFromAsciiSafeString($contenido);
            \Log::info('Request : ');
            \Log::info('    $request->cliente : ' . $request->cliente);
            \Log::info('    $request->producto : ' . $request->producto);
            //\Log::info('    varcontrolsecuencia : ' . $varcontrolsecuencia);
            if (isset($this->op_caracteristica_ba) && $this->op_caracteristica_ba != null) {
                $request['op_caracteristica_ba'] = $this->op_caracteristica_ba;
            }
            $recorrido = $objEXPORT->generar($request);
            $cont = $this->cont;
            $tiempo_inicial = microtime(true);
            \Log::info('tiempo que inicia : ' . $tiempo_inicial);
            $valido_sec = 1;
            $valido_total = count($recorrido);
            $valido_reg_sec = $valido_total;
            $limit_insert = 150;
            $row_insert_detalle = array();

            $precio_final = null;

            switch ($request->cliente) {
                case 'BGR':
                    $contador_bgr = 1;
                    break;
                case 'PRODUBANCO':
                    // IDEAS PARA USAR EL CAMPO OPCIONAL ?? 
                    // REALIZE TODA LA CONSULTA Y EL CONTINUE SE ENCUENTE EN UN ISSET ??
                    // VAMOS CON ELLO , ASI LA CONSULTA SOLO AUMENTO UN CAMPO Y NO TIENE QUE CAMBIAR
                    // nop se añadio el request para tomar datos de la consulta directamente ,
                    // de echo se puede añadir directamente el resquest en la creacion del
                    // contructor 
                    break;
                default:
                    break;
            }
            foreach ($recorrido as $individual) {
                // ok esto era nescesario , por que no tomaba la date de 30 dias , esto permite el calulo de 30 dias antes de cobro
                // nesesito transformar o conservar esto , debito a que la fecha en consulta no permitia este cobor
                // Recordar cliente BGR
                if (isset($contador_bgr)) {
                    $time = strtotime(date("m/d/Y H:i:s"));
                    $num2 = 30; // añadir validacion a extraer 
                    $final = date("m/d/Y H:i:s", strtotime(" -" . $num2 . " day ", $time));
                    $date_1 = Carbon::createFromFormat('m/d/Y H:i:s', ($individual['fecha'] . '00:00:00'));
                    $date_2 = Carbon::createFromFormat('m/d/Y H:i:s', $final);
                    if ($date_1->lt($date_2)) {
                        $contador_bgr++;
                    } else {
                        continue;
                    }
                }
                // saltaria lo que es la sentencia en el continue , y unicamente es para que de forma interna maneje los datos
                // que esta generando los archivos planos , si se encuentra completamente funcional ANTES.
                // corregir esto mientras muevo los datos de numeracion , el contador BGR solo es nescesario que exista cuando se realiza esta consulta.
                // puede reemplazarse con un valor de validacion que se encuentre en el $this->opciones ?? , si si puede 
                // bloque para la generacion de texto plano en memoria , antes de realizar la insercion de datos 
                //bloque exclusivo para PRODUBANCO
                //3 corte el 12$                ciclo13 = 3;
                //4 corte el 15                $ciclo15 = 4;
                //9 corte el 30                $ciclo30 = 9;
                /*
                if (isset($produbanco_validacion)) {
                    $request['opcional'];
                    if ($individual['ciclo'] == $request['opcional']) {
                        $contador_bgr++; 
                    } else {
                        continue;
                    }
                }
                */

                if (isset($op_client->num_elem_export)) {
                    $cont++;
                    $secuencia = "";
                    for ($i = 1; $i <= $op_client->num_elem_export; $i++) {
                        // variable temporal que tendra el texto
                        $value_field = "";
                        if (isset($campos_export[$i]) || isset($opciones_fijas[$i])) {
                            $value_field =  isset($campos_export[$i]) ? $individual[$campos_export[$i]] : $opciones_fijas[$i];

                            if ((strlen($value_field) > 100)) {

                                $value_field = Crypto::decrypt($value_field, $clave);
                                if (isset($campoC['bin_' . $i])) {
                                    $value_field = substr($value_field, 0, 6);
                                }
                            }
                            if (isset($campos_export[$i])) {
                                if (
                                    $campos_export[$i] == 'deduccion_impuesto'  ||
                                    ($campos_export[$i]) == 'subtotal' ||
                                    ($campos_export[$i]) == 'valortotal'
                                ) {
                                    if (($campos_export[$i]) == 'valortotal') {
                                        $precio_final = $value_field;
                                    }

                                    if (str_contains($value_field, ".")) {
                                        $validateLen = explode('.', $value_field);
                                        if (strlen($validateLen[count($validateLen) - 1]) == 2) {
                                            $value_field =   str_replace(".", "", $value_field);
                                        } else {
                                            $value_field =   str_replace(".", "", $value_field);
                                            $value_field .= "0";
                                        }
                                    } else {
                                        $value_field = $value_field . "00";
                                    }
                                }
                                if (isset($campo0['tranF_' . $i])) {
                                    if ($campos_export[$i] == 'tipcta' || $campo0['tranF_' . $i] == 'tipcta') {
                                        switch ($value_field) {
                                            case 'AHO':
                                                $value_field = '03';
                                                break;
                                            case 'CTE':
                                                $value_field = '04';
                                                break;
                                            default:
                                                break;
                                        }
                                    }
                                }
                            }
                            if (isset($campo0['campo0_' . $i]) || isset($campo0['campo0D_' . $i]) || isset($campo0['campoE_' . $i]) || isset($campo0['campoED_' . $i])) { //iria al final o al comienzo ?    
                                $value_field = $this->validate_0_E($value_field, $i);
                            } else {
                                if (isset($campoC['insert_date_' . $i])) {
                                    $value_field = str_replace('insert_date_' . $i, strtoupper(date($campoC['insert_date_' . $i])), $value_field);
                                }
                            }
                            $textoPlano .= $value_field;
                            if (isset($campoC["espacios"])) {
                                $textoPlano .= $campoC["espacios"];
                            }
                        } elseif (isset($campoC['campoC_' . $i])) {
                            if ($campoC['campoC_' . $i] == "contador_secuencia") {
                                $secuencia = $cont;
                            } else {
                                $secuencia = date($campoC['campoC_' . $i]);
                            }
                            if (isset($campo0['campo0_' . $i]) || isset($campo0['campo0D_' . $i]) || isset($campo0['campoE_' . $i]) || isset($campo0['campoED_' . $i])) { //iria al final o al comienzo ?    
                                $secuencia = $this->validate_0_E($secuencia, $i);
                            }
                            $value_field = $secuencia;
                            $textoPlano .= $value_field;
                            if (isset($campoC[$i])) {
                            } elseif (isset($campoC["espacios"])) {
                                $textoPlano .= $campoC["espacios"];
                            }
                        }
                    }
                } else {
                    \Log::error('Falta una configuracion , porfavor acceda a Ea_opciones_carga_cliente.');
                    abort(404, 'Falta una configuracion , porfavor acceda a Ea_opciones_carga_cliente');
                }
                // bloque para la generacion de texto plano en memoria , antes de realizar la insercion de datos 
                $textoPlano .= "\n";
                //$condicion = true;
                $row_insert_sets = array();
                $id_carga =  isset($this->ultima_carga['id_carga']) ?  $this->ultima_carga['id_carga'] : 1;
                $row_insert_sets['id_sec'] = isset($individual->id_sec) ? trim($individual->id_sec) : null; // ok
                $row_insert_sets['id_carga'] = $id_carga;
                //$row_insert_sets['id_carga'] = $id_carga + 1; // ok
                if (isset($campoC['identificador'])) {
                    if ($campoC['identificador'] == 'secuencia') {
                        $row_insert_sets['secuencia'] = ltrim($secuencia, '0');
                    } elseif ($campoC['identificador'] == 'cedula_id') {
                        //cuentas , cedula por defecto
                        $row_insert_sets['secuencia'] = $individual->cedula_id;
                    } else {
                        \Log::error('Error Fatal , no esta bien configurado el identificador de forma correcta , porfavor especifique si es el campo cedula_id o es una secuencia');
                        abort(404, 'Error Fatal , no esta bien configurado el identificador de forma correcta , porfavor especifique si es el campo cedula_id o es una secuencia');
                    }
                } else {
                    $row_insert_sets['secuencia'] = $individual->cedula_id;
                }
                $row_insert_sets['fecha_registro'] = date('d/m/Y H:i:s');
                $row_insert_sets['subproducto_id'] =  $request->producto; //ok //error el producto es el id que viene en subproducto
                $row_insert_sets['opciones_id'] = isset($request->opciones_data) ?  $request->opciones_data : null;
                $row_insert_sets['cliente'] = $request->cliente; //ok
                $row_insert_sets['estado'] = "0"; //sing
                $row_insert_sets['fecha_generacion'] =  date('mY'); //ok
                $row_insert_sets['valor_debitado'] = $precio_final;
                //bloque que inserta registros dentro de la base

                array_push($row_insert_detalle, $row_insert_sets);
                $row_insert_sets = array();
                if ($valido_sec == $limit_insert) {
                    $valido_sec = 0;
                    $valido_reg_sec = $valido_reg_sec - $limit_insert;
                    //$objEXPORT->view_reg_state($row_insert_detalle);
                    EaDetalleDebito::insert($row_insert_detalle);
                    $row_insert_detalle = array();
                } elseif ($valido_sec == $valido_reg_sec) {
                    //$objEXPORT->view_reg_state($row_insert_detalle);
                    EaDetalleDebito::insert($row_insert_detalle);
                }
                $valido_sec++;
            }
            $resumen = array();
            //$resumen['id_carga'] = $row_insert_sets['id_carga'];
            $resumen['success'] = isset($success) ? $success : '';
            //$resumen['secuencia'] = $secuencia;
            $resumen['textoPlano'] = $textoPlano;
            $resumen['fusion_condicion'] = isset($contador_bgr) ? 'true' : 'false';
            $resumen['secuencia_cont'] = $cont;
            $resumen['count_recorrido'] = count($recorrido);
            $this->cont = $cont;
            // se perdera un poco , no posible repetir si no se encuentra creada como un $THIS->
            //dd($resumen);
            return $resumen;
        } catch (\Exception $e) {
            EaDetalleDebito::rollback();
        }
    }


    public function returnRoute()
    {
        $rutas_debito = EaCabeceraCargaCorp::where('estado', 'PENDIENTE')
            ->orderBy('cliente');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosCliente = $request->except('_token', '_method');
        $datosCliente['estado'] = "A";
        $idCliente = EaCliente::All()->max('id_cliente');
        if (isset($idCliente) && $idCliente !== 1) {
            $idCliente++;
            $datosCliente['id_cliente'] = $idCliente;
        } else {
            $datosCliente['id_cliente'] = 1;
        }
        if ($request->hasfile('logotipo')) {
            $nombre_archivo = $request->file('logotipo')->getClientOriginalName();
            $datosCliente['logotipo'] = $request->file('logotipo')->storeAs('LogosClientes', $nombre_archivo, 'public');
        }
        EaCliente::insert($datosCliente);
        return redirect()->route('EaClienteController.index')->with([
            'cliente' => $request->cliente,
            'trxcliente' => 'store'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  OBJ  $value_field
     * @return \Illuminate\Http\Response
     */
    public function validate_0_E($value_field, $i)
    {
        $campo0 = $this->campo0;
        if (isset($campo0['campo0_' . $i])) { //iria al final o al comienzo ?    
            $cerosCod = (int)$campo0['campo0_' . $i] - strlen((string)$value_field);
            $establecimiento_print = "";
            if ($cerosCod > 0) {
                for ($j = 0; $j < $cerosCod; $j++) {
                    $establecimiento_print .= "0";
                }
                $establecimiento_print .= $value_field;
                $value_field = $establecimiento_print;
            } else {
                $establecimiento_print .= $value_field;
                $value_field = $establecimiento_print;
            }
        } elseif (isset($campo0['campo0D_' . $i])) {
            $cerosCod = (int)$campo0['campo0D_' . $i] - strlen((string)$value_field);
            $establecimiento_print = "";
            if ($cerosCod > 0) {
                for ($j = 0; $j < $cerosCod; $j++) {
                    $establecimiento_print .= "0";
                }
                $value_field .= $establecimiento_print;
                // $value_field = $establecimiento_print;
            } else {
                $establecimiento_print .= $value_field;
                $value_field = $establecimiento_print;
            }
        } elseif (isset($campo0['campoE_' . $i])) {
            $cerosCod = (int)$campo0['campoE_' . $i] - strlen((string)$value_field);
            $establecimiento_print = "";
            if ($cerosCod > 0) {
                for ($j = 0; $j < $cerosCod; $j++) {
                    $establecimiento_print .= " ";
                }
                $establecimiento_print .= $value_field;
                $value_field = $establecimiento_print;
            } else {
                $establecimiento_print .= $value_field;
                $value_field = $establecimiento_print;
            }
        } elseif (isset($campo0['campoED_' . $i])) {
            $cerosCod = (int)$campo0['campoED_' . $i] - strlen((string)$value_field);
            $establecimiento_print = "";
            if ($cerosCod > 0) {
                for ($j = 0; $j < $cerosCod; $j++) {
                    $establecimiento_print .= " ";
                }
                //$establecimiento_print .= $value_field;
                $value_field .= $establecimiento_print;
            } else {
                $establecimiento_print .= $value_field;
                $value_field = $establecimiento_print;
            }
        }
        return $value_field;
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ultima_carga_subproducto($request)
    {

        if (isset($request->opciones_data)) {
            return EaDetalleDebito::where('subproducto_id', $request->producto)
                ->where('opciones_id', $request->opciones_data)
                ->orderbydesc('id_carga')
                ->first();
        }
        return EaDetalleDebito::where('subproducto_id', $request->producto)
            ->orderbydesc('id_carga')
            ->first();
    }

    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generarFactura(Request $request)
    {

        /*
      "carga_resp" => "1"
      "cliente" => "PRODUBANCO"
      "opciones_data" => "4"
      "producto" => "20"
      "_token" => "ht3O7FTa1tvruEdZoedOKD73eAGKDvuKZO2duAxT"
      "Facturacion" => null
        */
        \Log::info('funcion generarFactura clase EaCargaIndividualExport');
        $varcontrolsecuencia = (isset($request->carga_resp) ? strval($request->carga_resp) : null);
        $detalle_subproducto = ((new EaSubproductoController)->getSubproductoDetalle($request->cliente, $request->producto));
        //bloque de pruebas 
        $this->op_client = EaOpcionesCargaCliente::where('codigo_id', $request->producto)->first();
        $prod_id = explode(',', $this->op_client['subproducto']);
        $name_producto = str_replace("/", " ", $this->op_client['archivo_nombre']);
        // no cuadraria se debe aplicar lo mismo que en el else dentro del metodo export
        //KPE CAMBIO EaGenCamExport 
        //$request->cliente, $detalle_subproducto->desc_subproducto, $varcontrolsecuencia, $request->producto, $detalle_subproducto->tipo_subproducto
        return Excel::download(new EaGenCamExport($request), $request->cliente . "-" . $name_producto . "-" . date("Y-m-d") . '.xlsx');
    }
}
