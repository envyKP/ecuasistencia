<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EaCabeceraCargaCorp;
use App\Models\EaCabeceraDetalleCarga;
use App\Models\EaProducto;
use App\Models\EaSubproducto;
use App\Http\Controllers\EaClienteController;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EaDetCargaCorpImport;
use App\Http\Controllers\EaBaseActivaController;
use App\Http\Controllers\EaProductoController;
use App\Http\Controllers\EaSubproductoController;
use App\Http\Controllers\EaParaInsert;
use App\Http\Controllers\EaCabCargaInicialBitacoraController;
use App\Http\Controllers\EaDetalleCargaCorpController;
use App\Models\EaOpcionesCargaCliente;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\EaCliente;
use App\Exports\EaGenCamExport;
use App\Exports\UsersExport;
use Carbon\Carbon;

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


        if ($request->btn_genera == 'buscar') {

            $clientes =  (new EaClienteController)->getAllCampanas();
            //\Log::info('funcion exporta clase EaCargaIndividualExport :' . $request->cliente . '    ???   ' . $request->producto);

            if (isset($request->cliente)) {
                //\Log::info('Consulta a cliente :' . $request->cliente);
                $resumen_cabecera = EaCabeceraDetalleCarga::select(
                    '*',
                    EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
                )->orderBydesc('fec_registro2')
                    ->where('is_det_debito', '1')
                    ->where('cliente', $request->cliente)
                    ->paginate(15);

                if (isset($request->producto)) {
                    //\Log::info('Consulta a cliente :' . $request->cliente . ' ' . $request->producto);
                    $resumen_cabecera = EaCabeceraDetalleCarga::select(
                        '*',
                        EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
                    )->orderBydesc('fec_registro2')
                        ->where('is_det_debito', '1')
                        ->where('cliente', $request->cliente)
                        ->where('producto', $request->producto)
                        ->paginate(15);
                }
            }

            if (isset($request->state)) {
                $resumen_cabecera = EaCabeceraDetalleCarga::select(
                    '*',
                    EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
                )->orderBydesc('fec_registro2')
                    ->where('is_det_debito', '1')
                    ->where('estado', $request->state)
                    ->paginate(15);
                if (isset($request->cliente)) {
                    $resumen_cabecera = EaCabeceraDetalleCarga::select(
                        '*',
                        EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
                    )->orderBydesc('fec_registro2')
                        ->where('is_det_debito', '1')
                        ->where('estado', $request->state)
                        ->where('cliente', $request->cliente)
                        ->paginate(15);
                    if (isset($request->producto)) {
                        $resumen_cabecera = EaCabeceraDetalleCarga::select(
                            '*',
                            EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
                        )->orderBydesc('fec_registro2')
                            ->where('is_det_debito', '1')
                            ->where('estado', $request->state)
                            ->where('cliente', $request->cliente)
                            ->where('producto', $request->producto)
                            ->paginate(15);
                    }
                } elseif (isset($request->producto)) {
                    $resumen_cabecera = EaCabeceraDetalleCarga::select(
                        '*',
                        EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
                    )->orderBydesc('fec_registro2')
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

                //                dd($request);
                /**  +request: Symfony\Component\HttpFoundation\InputBag {#51
                    #parameters: array:10 [
                     "_token" => "meOHofO5Gi7oEzizF02P2tCb1T7aMJypdTAgj4pJ"
                    "usuario_registra" => "sgavela"
                    "filtro_cliente" => "cliente"
                    "cliente" => "BBOLIVARIANO"
                    "filtro_producto" => "producto"
                    "producto" => "1"
                    "opciones_data" => null
                    "filtro_genera" => "filtroGenera"
                    "btn_genera" => "Generar"
                    "state" => "PENDIENTE"
                      ]
                    } */
                //\Log::info('funcion exporta clase EaCargaIndividualExport');
                //\Log::warning('usuario que realiza la orden: ' . \Auth::user()->username);
                // \Log::warning('Something could be going wrong.');
                // \Log::error('Something is really going wrong.');

                // esto posiblemente deba ir dentro de el inicio de union subproductos
                $this->detalle_subproducto = ((new EaSubproductoController)->getSubproductoDetalle($request->cliente, $request->producto));
                // existe un problema , esto genera o controla unsa secuencia al momento de realizar la generacion de la peticion
                //como puedo manejarla en pares la peticion , otra cosa o traba es al momento de la lectura como puedo manejar la lectura de todo el subproducto?
                //no deberia tener problema ya que usa una version en base para los pagos
                //en el export no deberia existir 


                // campo o similar todavia no se si usar id que este anidado al campo de EaOpcionesCargaCliente
                if (!isset($request->carga_resp)) {


                    //bloque para posibilitar creacion de archivo plano 
                    $this->op_client = EaOpcionesCargaCliente::where('cliente', $request->cliente)->where('subproducto', $request->producto)->first();
                    $this->opciones_fijas = json_decode($this->op_client->opciones_fijas, true);
                    $this->campos_export = json_decode($this->op_client->campos_export, true);
                    $this->campoC = json_decode($this->op_client->campoc, true);
                    $this->campo0 = json_decode($this->op_client->campo0, true);
                    //en este nivel deberia habitar la opcion para los subproductos , por agurpacion o tipo de subproducto
                    $textoPlano = "";
                    $this->cont = 0;
                    // es nesesaria aki el $op_client['subproducto'] ??? puedo omitirlo y que todo entre dentro del for y dentro lo valido ?
                    // de echo si existe 2 id es hasta nescesario validarlo 
                    if (isset($op_client['subproducto'])) {
                        $prod_id = explode(',', $op_client['subproducto']);
                        //-- el texto plano inicializa, tal vez?
                        foreach ($prod_id as $producto) {

                            $objEXPORT = new EaGenCamExport($request->cliente, $this->detalle_subproducto->desc_subproducto, (isset($request->carga_resp) ? strval($request->carga_resp) : null), $producto, $this->detalle_subproducto->tipo_subproducto);
                            $generacion_txt = $this->genera_cadena_subproducto($objEXPORT, $request,  $textoPlano);
                            //$textoPlano = $textoPlano . $generacion_txt['textoPlano'];
                            $textoPlano = $generacion_txt['textoPlano'];
                        }
                        //-- se arma lo que es el texto plano o se almacena el resultado de texto plano 
                        //$contador_bgr, -- alguna variable que permita entrar en la condicion de bgr o de secuencia,({{secuencia_unida}})
                        if (isset($campoC["frase"])) {
                            // CAMPOS CALCULADOS.
                            //{{date}} --> fecha actual
                            //{{date-N}} -->fecha menos N mes
                            //{{total_recaudado}}--> sumatoria del cobor del valor total en validacion con el campo del mes o date, tiene que tener ese disparador
                            // en caso de llamar a a json de validacion en base
                            /*for ($i = 0; $i < strlen($campoC["frase"]); $i++) {
                            }*/
                            switch ($request->cliente) {
                                case 'BGR':
                                    // toda esta seccion debe intentar implementarse antes que este metodo interno
                                    $contador_bgr = 1;
                                     $time = strtotime(date("Y-m-d"));
                                    $num2 = 30; // añadir validacion a extraer 
                                    $final = date("Y-m-d", strtotime(" -" . $num2 . " day ", $time));
                                    $primera_linea = str_replace("{{date}}", $final, $this->campoC["frase"]);
                                    //$primera_linea .= "     " . $secuencia_unida; // probablemente para una validacion , reemplazado con el foreach, no existe nescesidad 
                                    // de que exista ya la variable se la deja por la estructura que respresenta dentro de el codigo
                                    $primera_linea .= "\n";
                                    $primera_linea = $primera_linea . $textoPlano;
                                    $textoPlano = $primera_linea;
                                    break;
                                case 'PRODUBANCO':
                                    if (isset($campoC["fraseF"])) {
                                    } else {
                                        //frase = TREC02210000000
                                        // aki vienen calculos globales. pero como añadir la sumantoria tendria que recorrer todo una vez y luego sumarlo o si tengo el total de registros
                                        // multiplicarlo por el subtotal total o impuestos y mostrar eso .....
                                        $aproximado_calculo = $generacion_txt['count_recorrido'] * $this->detalle_subproducto['valortotal'];
                                        //$cont = 1;
                                        $textoPlano .= $campoC["frase"] . $cont . " " . $aproximado_calculo . " "; //CALCULO
                                        $textoPlano .= "\n";
                                    }
                                    break;
                                default:
                                    $textoPlano .= $campoC["frase"];
                                    break;
                            }
                        }

                        // probablemente para una validacion , reemplazado con el foreach, no existe nescesidad 
                        // de que exista ya la variable se la deja por la estructura que respresenta dentro de el codigo
                        /*
                        if (isset($secuencia_unida)) {
                            switch ($request->cliente) {
                                case 'BGR':
                                   
                                    break;
                                case 'BBOLIVARIANO':
                                    break;
                                case 'PRODUBANCO':
                                    break;
                                default:
                                    dd("no implementado , no deberia haber llegado a esta condicion -9432 ");
                                    break;
                            }
                        }*/ 


                        $tiempo_final = microtime(true);
                        //\Log::info('tiempo que termina : ' . $tiempo_final);
                        //$textoPlano =  str_replace("{{secuencia}}", $cont,  $textoPlano);
                        $extension_file = ".";
                        if (isset($this->campoC["extension"])) {
                            $extension_file .= $this->campoC["extension"];
                        } else {
                            $extension_file .= "txt";
                        }
                        //posible conflicto con this->ultima_carga , posibilidad de manejar esto fuera del bucle 
                        $this->ultima_carga = $objEXPORT->is_carga_older(); //agarrara el ultimo objExport que genere ,
                        //puedo usar el producto como un campo tipo id que me maneje las id de la opciones_cabezera entonces el id que se use para lo que es la carga pertenesera a al campo producto
                        // anidado al campo nuevo de id personalizados dentro de cabezera_detalle
                        $id_carga = (isset($this->ultima_carga->id_carga) ? $this->ultima_carga->id_carga : 0);
                        $fecha_generacion = (isset($this->ultima_carga->fecha_generacion) ? $this->ultima_carga->fecha_generacion : 0);
                        $file_reg_carga = array();
                        $file_reg_carga['cod_carga'] = $id_carga;
                        $file_reg_carga['cliente'] = $request->clinte;
                        $file_reg_carga['producto'] = $request->producto;
                        $file_reg_carga['fecha_registro'] = date('d/m/Y H:i:s');
                        $file_reg_carga['fec_carga'] = $fecha_generacion;
                        $file_reg_carga['usuario'] = \Auth::user()->username;
                        $fileName = ($id_carga + 1) . $extension_file;
                        $success = 'se genero exitosamente , se procede a realizar la descarga ';
                        Storage::disk('public')->makeDirectory('generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . date('Y'));
                        file_put_contents(public_path('storage/generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . date('Y') . '/' . $fileName), $textoPlano);
                        $file_reg_carga['ruta_gen_debito'] = 'storage/generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . date('Y') . '/' . $fileName;
                        $objEXPORT->registro_cargas($file_reg_carga);

                        return redirect()->route('EaCargaIndividualImport.index')->with([
                            'success' => isset($generacion_txt['success']) ? $generacion_txt['success'] : '',
                            'generacionVal' => isset($generacion_txt['success']) ? '200' : '',
                            'carga_resp' => ($generacion_txt['id_carga'] + 1),
                            'producto' => isset($request->producto) ? $request->producto : '',
                            'cliente' => isset($request->cliente) ? $request->cliente : '',
                            'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : '',
                            'registros_no_cumplen' => isset($registros_no_cumplen) ? $registros_no_cumplen : ''
                        ]);
                        //return response()->json(['success' => $import->detalle_proceso['msg']]);
                    } else {
                        //return response()->json(['success' => $import->detalle_proceso['msg']]);
                    }
                    // funcion que genera e inserta en el detalle usando como referencia : cliente , subproducto.
                    // pero como puedo evadir o como deberia realizar la conexion o actualizacion 
                    // puedo utilizar los datos de la consulta anterior , 
                    // especificar en un lado el "tomador" tipo como se realiza en el ws fenix ?¡
                    // mas o menos que puedo realizar para ello como lo armaria
                    // existe un campo de texto que no eh eliminado de la cabezera 
                    // puedo agregar o en un json de validacion dentro del subproducto realizar una asociacion. tipo busqueda ? 
                    // si hago eso siempre realizaria un barrido cuando se realizen las primeras consultas.
                    // me obliga a que lo que se muestra en la vista ya no sea los subproducto que veo en la tabla subproducto
                    // tendria que realizar o enmascarar los datos transformandolo de una forma que lo vea el usuario , y realizando un controlador
                    // directo usando la cabezera como referencia , (un nuevo campo para los 2 elemento , el id tambien seria nuevo yu lo que se usaria como 
                    // campo de referencia es otro campo adicional )
                    // entonces el id que maneja dentro de la vista puede ser no solo (no cambia la vista , pero cuando consulto cabezera si envio no se un nombre de producto o producto con 3,3 similar
                    // representaria que en realidad esta usando  mas de un subproducto , solo buscaria la primera configuracion , y puedo manejarlo de forma , no deberia dar conflictos con 
                    // el campo de impor o lectura de archivos de respuesta si simplemente se ignora un dato del where en el cual interactura el subproducto creo pero con tarjeta mmm
                    // todo esto da conflicto si en algun caso existiese la tarjeta ignora lo que es el id de subproducto pero lo busca con el nombre , debe diferenciarse dentro del subdetalle ? )
                    //el opcionces seria mas sensillo al momento de mostras lo que es los parametrso e id de los ciclos 
                    //proceso o ciclo :
                    /*
                              - crear controlador o metodo que llame a la cabezera detalles como llama a los subproductos en la vista cabezera.blade.php
                              - en la tabla debe existir , un campo o algo aparte que permita llamar a los subproducto de la tabla activa
                            
                              maneja actualmente 2 processos 1 por cuenta tarjeta y otro solo como secuencia, en caso de existir la union com se procesaria en collection ?¡
                              ( y si pudiera antes de invocar el proceso poner un for ? existe otro problema el tipo de formato de archivo )
                             la lectura de respuesta maneja 2 cosas la id_carga (numero de carga) y el id_subproducto, (en la consulta con la base activa usa el id_sec)
                              - la lectura del archivo de respuesta practicamente se realizara dependiendo de la secuencia o simplemente es leyendolo 2 veces ? 
                                    #(el bgr ctas es con secuencia) si es por secuencia , en el detalle viene el subproduco en la lectura tengo que cambiar para que tome en cuenta el 
                                                                    id de subproducto que viene , esto hara que el proceso sea mas lento posiblemente. 
                                    #(el produbanco solo tiene tarjeta) realiza un join a la base activa con el id_secuencia , pero usa el producto tambien con un filtro (where)
                             */
                    //bloque para renombrar las variables //
                    // debe ir fuera del metodo
                    //armar el documento 
                } else {
                    $objEXPORT = new EaGenCamExport($request->cliente, $this->detalle_subproducto->desc_subproducto, (isset($request->carga_resp) ? strval($request->carga_resp) : null), $request->producto, $this->detalle_subproducto->tipo_subproducto);
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
                    $ruta =  $objEXPORT->ruta_carga();
                    //$this->detalle_subproducto cambiar al campo personalizado que proviene directamente de opciones, opciones debe ser gol
                    $res = preg_replace('([^A-Za-z0-9 ])', ' ', $this->detalle_subproducto->desc_subproducto);
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
    }


    private function genera_cadena_subproducto($objEXPORT, $request, $textoPlano)
    {
        $campo0 = $this->campo0;
        $campoC = $this->campoC;
        $opciones_fijas = $this->opciones_fijas;
        $op_client = $this->op_client;
        $detalle_subproducto = $this->detalle_subproducto;

        $contenido = file_get_contents("../salsa.txt");
        $clave = Key::loadFromAsciiSafeString($contenido);
        //\Log::info('Request : ');
        //\Log::info('    $request->cliente : ' . $request->cliente);
        //\Log::info('    $request->producto : ' . $request->producto);
        //\Log::info('    varcontrolsecuencia : ' . $varcontrolsecuencia);
        $recorrido = $objEXPORT->generar($campoC);
        $cont = $this->cont;
        $tiempo_inicial = microtime(true);
        //\Log::info('tiempo que inicia : ' . $tiempo_inicial);
        $valido_sec = 1;
        $valido_total = count($recorrido);
        $valido_reg_sec = $valido_total;
        $limit_insert = 150;
        $row_insert_detalle = array();
        foreach ($recorrido as $individual) {
            //echo " entro enforeach ";
            if (isset($contador_bgr)) {
                //echo " isset bgr ctas val";
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

            if (isset($op_client->num_elem_export)) {
                $cont++;
                $secuencia = "";
                for ($i = 1; $i <= $op_client->num_elem_export; $i++) {
                    // variable temporal que tendra el texto
                    $value_field = "";
                    if (isset($campos_export[$i]) || isset($opciones_fijas[$i])) {
                        $value_field =  isset($campos_export[$i]) ? $individual[$campos_export[$i]] : $opciones_fijas[$i];
                        //$text_temp = strlen($value_field);
                        if ((strlen($value_field) > 100)) {
                            // echo $value_field;
                            $value_field = Crypto::decrypt($value_field, $clave);
                            if (isset($campoC['bin_' . $i])) {
                                $value_field = substr($value_field, 0, 6);
                            }
                            //dd($value_field);
                        }
                        if (isset($campos_export[$i])) {
                            // dd("esta en campos_export");
                            if (
                                $campos_export[$i] == 'deduccion_impuesto'  ||
                                ($campos_export[$i]) == 'subtotal' ||
                                ($campos_export[$i]) == 'valortotal'
                            ) {
                                //dd($campos_export[$i]);
                                if (str_contains($value_field, ".")) {
                                    $validateLen = explode('.', $value_field);
                                    //dd(strlen($validateLen[count($validateLen)-1]));
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
                            // METODO 
                            //  dd("esta en campo0");
                            $value_field = $this->validate_0_E($value_field, $i);
                        } else {
                            if (isset($campoC['insert_date_' . $i])) {
                                $value_field = str_replace('insert_date_' . $i, strtoupper(date($campoC['insert_date_' . $i])), $value_field);
                            }
                        }
                        $textoPlano .= $value_field;
                        //echo  $textoPlano;
                        //dd($value_field);
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
                //\Log::error('Falta una configuracion , porfavor acceda a Ea_opciones_carga_cliente.');
                dd("Falta una configuracion , porfavor acceda a Ea_opciones_carga_cliente");
            }
            $textoPlano .= "\n";
            //$condicion = true;
            $row_insert_sets = array();
            $id_carga = (isset($individual->id_carga) ? $individual->id_carga : 1);
            $fecha_generacion = (isset($this->ultima_carga->fecha_generacion) ? $this->ultima_carga->fecha_generacion : 0);
            if ($fecha_generacion != date('mY')) {
                $id_carga = (isset($this->ultima_carga->id_carga) ? $this->ultima_carga->id_carga : 0);
            }
            $row_insert_sets['id_sec'] = isset($individual->id_sec) ? trim($individual->id_sec) : null; // ok
            $row_insert_sets['id_carga'] = $id_carga + 1; // ok
            if (isset($campoC['identificador'])) {
                if ($campoC['identificador'] == 'secuencia') {
                    $row_insert_sets['secuencia'] = ltrim($secuencia, '0');
                } elseif ($campoC['identificador'] == 'cedula_id') {
                    //cuentas , cedula por defecto
                    $row_insert_sets['secuencia'] = $individual->cedula_id;
                } else {
                    //\Log::error('Error Fatal , no esta bien configurado el identificador de forma correcta , porfavor especifique si es el campo cedula_id o es una secuencia');
                    dd("Error Fatal , no esta bien configurado el identificador de forma correcta , porfavor especifique si es el campo cedula_id o es una secuencia");
                }
            } else {
                $row_insert_sets['secuencia'] = $individual->cedula_id;
            }
            $row_insert_sets['fecha_registro'] = date('d/m/Y H:i:s'); //ok
            $row_insert_sets['subproducto_id'] =  $request->producto; //ok //error el producto es el id que viene en subproducto
            $row_insert_sets['cliente'] = $request->cliente; //ok
            $row_insert_sets['estado'] = "0"; //sing
            $row_insert_sets['fecha_generacion'] =  date('mY'); //ok
            array_push($row_insert_detalle, $row_insert_sets);
            $row_insert_sets = array();
            if ($valido_sec == $limit_insert) {
                $valido_sec = 0;
                $valido_reg_sec = $valido_reg_sec - $limit_insert;
                $objEXPORT->view_reg_state($row_insert_detalle);
                $row_insert_detalle = array();
            } elseif ($valido_sec == $valido_reg_sec) {
                $objEXPORT->view_reg_state($row_insert_detalle);
            }
            $valido_sec++;
        }
        $resumen = array();
        $resumen['id_carga'] = $id_carga;
        $resumen['success'] = isset($success) ? $success : '';
        $resumen['secuencia'] = $secuencia;
        $resumen['textoPlano'] = $textoPlano;
        $resumen['fusion_condicion'] = isset($contador_bgr) ? 'true' : 'false';
        $resumen['secuencia_cont'] = $cont;
        $resumen['count_recorrido'] = count($recorrido);
        $this->cont = $cont;

        return $resumen;
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
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generarFactura(Request $request)
    {
        \Log::info('funcion generarFactura clase EaCargaIndividualExport');
        $varcontrolsecuencia = (isset($request->carga_resp) ? strval($request->carga_resp) : null);
        $detalle_subproducto = ((new EaSubproductoController)->getSubproductoDetalle($request->cliente, $request->producto));
        $name_producto = str_replace("/", " ", $detalle_subproducto->desc_subproducto);
        return Excel::download(new EaGenCamExport($request->cliente, $detalle_subproducto->desc_subproducto, $varcontrolsecuencia, $request->producto, $detalle_subproducto->tipo_subproducto), $request->cliente . "-" . $name_producto . "-" . date("Y-m-d") . '.xlsx');
    }
}
