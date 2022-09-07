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
        /*
::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'")::select(
            '*',
            EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
        )

*/

        if ($request->btn_genera == 'buscar') {

            $clientes =  (new EaClienteController)->getAllCampanas();
            \Log::info('funcion exporta clase EaCargaIndividualExport :' . $request->cliente . '    ???   ' . $request->producto);

            if (isset($request->cliente)) {
                \Log::info('1');
                $resumen_cabecera = EaCabeceraDetalleCarga::select(
                    '*',
                    EaCabeceraDetalleCarga::raw("CONVERT(date,fec_registro, 105) as 'fec_registro2'"),
                )->orderBydesc('fec_registro2')
                    ->where('is_det_debito', '1')
                    ->where('cliente', $request->cliente)
                    ->paginate(15);

                if (isset($request->producto)) {
                    \Log::info('2');
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



                \Log::info('funcion exporta clase EaCargaIndividualExport');
                \Log::warning('usuario que realiza la orden: ' . \Auth::user()->username);
                // \Log::warning('Something could be going wrong.');
                // \Log::error('Something is really going wrong.');

                $varcontrolsecuencia = (isset($request->carga_resp) ? strval($request->carga_resp) : null);
                $detalle_subproducto = ((new EaSubproductoController)->getSubproductoDetalle($request->cliente, $request->producto));
                $objEXPORT = new EaGenCamExport($request->cliente, $detalle_subproducto->desc_subproducto, $varcontrolsecuencia, $request->producto, $detalle_subproducto->tipo_subproducto);
                $op_client = EaOpcionesCargaCliente::where('cliente', $request->cliente)->where('subproducto', $request->producto)->first();
                $opciones_fijas = json_decode($op_client->opciones_fijas, true);
                $campos_export = json_decode($op_client->campos_export, true);
                $campoC = json_decode($op_client->campoc, true);
                $campo0 = json_decode($op_client->campo0, true);
                $this->campo0 = $campo0;
                if (!isset($request->carga_resp)) {
                    $contenido = file_get_contents("../salsa.txt");
                    $clave = Key::loadFromAsciiSafeString($contenido);
                    \Log::info('Request : ');
                    \Log::info('    $request->cliente : ' . $request->cliente);
                    \Log::info('    $request->producto : ' . $request->producto);
                    \Log::info('    varcontrolsecuencia : ' . $varcontrolsecuencia);
                    $recorrido = $objEXPORT->generar($campoC);

                    $ultima_carga = $objEXPORT->is_carga_older();
                    $textoPlano = "";
                    $primera_linea = "";
                    $detallevalidacion = array();
                    $cont = 0;
                    $condicion = false;

                    $tiempo_inicial = microtime(true);
                    \Log::info('tiempo que inicia : ' . $tiempo_inicial);
                    $valido_sec = 1;
                    $valido_total = count($recorrido);
                    $valido_reg_sec = $valido_total;
                    // EN GENERACION CAMPOS QUEMADOS
                    if (isset($campoC["frase"])) {
                        // CAMPOS CALCULADOS.

                        //{{date}} --> fecha actual
                        //{{date-N}} -->fecha menos N mes
                        //{{total_recaudado}}--> sumatoria del cobor del valor total en validacion con el campo del mes o date, tiene que tener ese disparador

                        for ($i = 0; $i < strlen($campoC["frase"]); $i++) {
                        }
                        switch ($request->cliente) {
                            case 'BGR':
                                //¿pregunta esto solo afecta principio de mes o afecta en cada generacion ?
                                //si afecta en cada generacion se debe realizar 

                                
                                $contador_bgr = 1;
                                break;
                            case 'PRODUBANCO':
                                if (isset($campoC["fraseF"])) {
                                } else {
                                    //frase = TREC02210000000
                                    // aki vienen calculos globales. pero como añadir la sumantoria tendria que recorrer todo una vez y luego sumarlo o si tengo el total de registros
                                    // multiplicarlo por el subtotal total o impuestos y mostrar eso .....
                                    $aproximado_calculo = count($recorrido) * $detalle_subproducto['valortotal'];
                                    $cont = 1;
                                    $textoPlano .= $campoC["frase"] . $cont . " " . $aproximado_calculo . " "; //CALCULO
                                    $textoPlano .= "\n";
                                }
                                break;
                            default:
                                $textoPlano .= $campoC["frase"];
                                break;
                        }
                    }
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

                            \Log::error('Falta una configuracion , porfavor acceda a Ea_opciones_carga_cliente.');
                            dd("Falta una configuracion , porfavor acceda a Ea_opciones_carga_cliente");
                        }


                        $textoPlano .= "\n";
                        $condicion = true;
                        $row_insert_sets = array();
                        $id_carga = (isset($individual->id_carga) ? $individual->id_carga : 1);
                        $fecha_generacion = (isset($ultima_carga->fecha_generacion) ? $ultima_carga->fecha_generacion : 0);
                        if ($fecha_generacion != date('mY')) {
                            $id_carga = (isset($ultima_carga->id_carga) ? $ultima_carga->id_carga : 0);
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
                                \Log::error('Error Fatal , no esta bien configurado el identificador de forma correcta , porfavor especifique si es el campo cedula_id o es una secuencia');
                                dd("Error Fatal , no esta bien configurado el identificador de forma correcta , porfavor especifique si es el campo cedula_id o es una secuencia");
                            }
                        } else {
                            $row_insert_sets['secuencia'] = $individual->cedula_id;
                        }
                        $row_insert_sets['fecha_registro'] = date('d/m/Y H:i:s'); //ok
                        $row_insert_sets['subproducto_id'] = $request->producto; //ok
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
                    if (isset($contador_bgr)) {
                        $time = strtotime(date("Y-m-d"));
                        $num2 = 30; // añadir validacion a extraer 
                        $final = date("Y-m-d", strtotime(" -" . $num2 . " day ", $time));
                        $primera_linea .= str_replace("{{date}}", $final, $campoC["frase"]);
                        //dd($textoPlano);
                        $primera_linea .= "     " . $contador_bgr;

                        $primera_linea .= "\n";

                        $primera_linea = $primera_linea . $textoPlano;
                        $textoPlano = $primera_linea;
                    }

                    $tiempo_final = microtime(true);
                    \Log::info('tiempo que termina : ' . $tiempo_final);

                    $textoPlano =  str_replace("{{secuencia}}", $cont,  $textoPlano);
                    $extension_file = ".";
                    if (isset($campoC["extension"])) {
                        $extension_file .= $campoC["extension"];
                    } else {
                        $extension_file .= "txt";
                    }
                    $id_carga = (isset($ultima_carga->id_carga) ? $ultima_carga->id_carga : 0);
                    $fecha_generacion = (isset($ultima_carga->fecha_generacion) ? $ultima_carga->fecha_generacion : 0);
                    $file_reg_carga = array();
                    $file_reg_carga['cod_carga'] = $id_carga;
                    $file_reg_carga['cliente'] = $request->clinte;
                    $file_reg_carga['producto'] = $request->producto;
                    $file_reg_carga['fecha_registro'] = date('d/m/Y H:i:s');
                    $file_reg_carga['fec_carga'] = $fecha_generacion;
                    $file_reg_carga['usuario'] = \Auth::user()->username;
                    //$row_insert_sets['id_carga'] = $id_carga + 1;
                    //$detallevalidacion variable que influye o ya esta declara , puedo usar con otro fin
                    // existe tambien el problema con produbanco, los archivos de texto.
                    //corregir los previamente echos, 2 validaciones aumentar un campo y que cambien otro dependiendo si es
                    // aho 03 y si es ctas 04
                    //prevision de bloque de informacion
                    /*
                    tengo la base de datos tengo que usar dentro de la consulta el parametro de un mes atras//-- adicion de campo consulta ?
                    
                    1 //-- validacion es rapida pero tengo que hacer un switch , se añade a campo0 , puede ser ya que esta toma el valor del campo.


                    
                    */
                    $validoacion_par = json_encode($detallevalidacion);
                    //$descripcion = preg_replace('([^A-Za-z0-9 ])', ' ', $detalle_subproducto->desc_subproducto);
                    $fileName = ($id_carga + 1) . $extension_file;
                    $success = 'se genero exitosamente , se procede a realizar la descarga ';
                    Storage::disk('public')->makeDirectory('generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . date('Y'));




                    file_put_contents(public_path('storage/generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . date('Y') . '/' . $fileName), $textoPlano);
                    $file_reg_carga['ruta_gen_debito'] = 'storage/generacion_debito/' . $request->cliente . '/' . $request->producto . '/' . date('Y') . '/' . $fileName;
                    $objEXPORT->registro_cargas($file_reg_carga, $validoacion_par);


                    return redirect()->route('EaCargaIndividualImport.index')->with([
                        'success' => isset($success) ? $success : '',
                        'generacionVal' => isset($success) ? '200' : '',
                        'carga_resp' => ($id_carga + 1),
                        'producto' => isset($request->producto) ? $request->producto : '',
                        'cliente' => isset($request->cliente) ? $request->cliente : '',
                        'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : '',
                        'registros_no_cumplen' => isset($registros_no_cumplen) ? $registros_no_cumplen : ''
                    ]);
                } else {

                    $file_reg_carga = array();
                    $file_reg_carga['cod_carga'] = $varcontrolsecuencia;
                    $file_reg_carga['cliente'] = $request->clinte;
                    $file_reg_carga['producto'] = $request->producto;
                    $extension_file = ".";
                    if (isset($campoC["extension"])) {
                        $extension_file .= $campoC["extension"];
                    } else {
                        $extension_file .= "txt";
                    }
                    $ruta =  $objEXPORT->ruta_carga();
                    $res = preg_replace('([^A-Za-z0-9 ])', ' ', $detalle_subproducto->desc_subproducto);
                    //$detalle_subproducto->desc_subproducto

                    $fileName = $request->cliente . "-" . $res . "-" . date("d-m-Y") . "-" . $varcontrolsecuencia . $extension_file;
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


    /**
     * 
     * 
     * 
     */
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
