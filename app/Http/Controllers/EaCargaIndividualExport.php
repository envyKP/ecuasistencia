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
use App\Exports\EaReporteCargaInicialExport;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\EaCliente;
use App\Exports\EaGenCamExport;
use App\Exports\UsersExport;

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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes =  (new EaClienteController)->getAllCampanas();
        $RegistrosPendientes = EaCabeceraCargaCorp::where('estado', 'PENDIENTE')
            ->orderBy('cliente')->paginate(5);
        return view('cargaIndividual.home')->with(compact('clientes'))
            ->with(compact('RegistrosPendientes'));
    }
    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exporta(Request $request)
    {
        if ($request->btn_genera == 'buscar') {

            //dd($request);
            // $logFile = 'import.log';
            //Log::useDailyFiles(storage_path().'/logs/'.$logFile);
            //Log::info('This is some useful information.');
            //Log::warning('Something could be going wrong.');
            //Log::error('Something is really going wrong.');
            $clientes =  (new EaClienteController)->getAllCampanas();
            \Log::info('funcion exporta clase EaCargaIndividualExport :' . $request->cliente . '    ???   ' . $request->producto);
            if (isset($request->cliente)) {
                \Log::info('1');
                $resumen_cabecera = EaCabeceraDetalleCarga::orderBydesc('fec_registro')
                    ->where('is_det_debito', '1')
                    ->where('cliente', $request->cliente)
                    ->paginate(15);

                if (isset($request->producto)) {
                    \Log::info('2');
                    $resumen_cabecera = EaCabeceraDetalleCarga::orderBydesc('fec_registro')
                        ->where('is_det_debito', '1')
                        ->where('cliente', $request->cliente)
                        ->where('producto', $request->producto)
                        ->paginate(15);
                }
            }

            if (isset($request->state)) {

                $resumen_cabecera = EaCabeceraDetalleCarga::orderBydesc('fec_registro')
                    ->where('is_det_debito', '1')
                    ->where('estado', $request->state)
                    ->paginate(15);

                if (isset($request->cliente)) {
                    $resumen_cabecera = EaCabeceraDetalleCarga::orderBydesc('fec_registro')->where('is_det_debito', '1')
                        ->where('estado', $request->state)
                        ->where('cliente', $request->cliente)
                        ->paginate(15);
                    if (isset($request->producto)) {
                        $resumen_cabecera = EaCabeceraDetalleCarga::orderBydesc('fec_registro')->where('is_det_debito', '1')
                            ->where('estado', $request->state)
                            ->where('cliente', $request->cliente)
                            ->where('producto', $request->producto)
                            ->paginate(15);
                    }
                } elseif (isset($request->producto)) {
                    $resumen_cabecera = EaCabeceraDetalleCarga::orderBydesc('fec_registro')
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

            //dd($request);
            \Log::info('funcion exporta clase EaCargaIndividualExport');
            \Log::warning('usuario que realiza la orden: ' . \Auth::user()->username);
            // \Log::warning('Something could be going wrong.');
            // \Log::error('Something is really going wrong.');
            $contenido = file_get_contents("../salsa.txt");
            $clave = Key::loadFromAsciiSafeString($contenido);
            $varcontrolsecuencia = (isset($request->carga_resp) ? strval($request->carga_resp) : null);
            $detalle_subproducto = ((new EaSubproductoController)->getSubproductoDetalle($request->cliente, $request->producto));
            $objEXPORT = new EaGenCamExport($request->cliente, $detalle_subproducto->desc_subproducto, $varcontrolsecuencia, $request->producto, $detalle_subproducto->tipo_subproducto);
            \Log::info('Request : ');
            \Log::info('    $request->cliente : ' . $request->cliente);
            \Log::info('    $request->producto : ' . $request->producto);
            \Log::info('    varcontrolsecuencia : ' . $varcontrolsecuencia);
            $recorrido = $objEXPORT->generar();
            $ultima_carga = $objEXPORT->is_carga_older();
            $textoPlano = "";
            $detallevalidacion = array();
            $cont = 0;
            $condicion = false;
            // ARMA LAS RESPUESTA QUE SE INSERTAN EN EL DOCUMENTO TXT , Y ADICIONAL LLAMA AL METODO QUE LO INSTERTA EN LA BASE DE DATOS.
            switch ($request->cliente) {
                case "INTER":
                    if ($detalle_subproducto->tipo_subproducto == 'TC') {
                        $tiempo_inicial = microtime(true);
                        foreach ($recorrido as $individual) {
                            $subtotal = $individual->subtotal;
                            $numberCeros = 17 - strlen((string)(floatval($subtotal) * 100));
                            $cerossub = "";
                            for ($i = 0; $i < $numberCeros; $i++) {
                                $cerossub .= "0";
                            }
                            $subtotalF = $cerossub . floatval($subtotal) * 100;
                            $numberCeros = 17 - strlen((string)(floatval($individual->deduccion_impuesto) * 100));
                            $cerossub = "";
                            for ($i = 0; $i < $numberCeros; $i++) {
                                $cerossub .= "0";
                            }
                            $impuestoF = $cerossub . (floatval($individual->deduccion_impuesto) * 100);
                            //$textoPlano .= "\t";
                            $example = "0";
                            if (isset($individual->tarjeta) and (strlen($individual->tarjeta) > 20)) {
                                $example = Crypto::decrypt($individual->tarjeta, $clave);
                            } else {
                                $example = "ERROR";
                            }
                            //$textoPlano .= "-1-";
                            $textoPlano .= $example;
                            //$textoPlano .= "-2-";
                            $establecimiento_print = "";
                            if (isset($individual->cod_establecimiento)) {
                                $cerosCod = 8 - strlen($individual->cod_establecimiento);
                                if ($cerosCod > 0) {
                                    for ($i = 0; $i < $cerosCod; $i++) {
                                        $establecimiento_print .= "0";
                                    }
                                    $establecimiento_print .= $individual->cod_establecimiento;
                                }
                                /*
                                ok genero un json oinseerto o hago el llamado de la base desde las opciones validacion
                                luego lluego que tengo que realizar ?
                                que podria ser lo llamo lo leo , puedo insertar los espacios personalizados, pero eso esta quemado enm base me ahorro la incertidumbre del tipo de producto , y 
                                en todo caso solo existiria la consulta personalizada , de echo si los otros bancos o cuentas comparten valores, puedo realizar una consulta general.
                                usar otro json que me permita armar o llamar segun el nombre del campo y no tengo que realizar el case para el restos el case por defecto 
                                seria el que estoy realizando y en caso de excepciones como la que realiza segun la secuencia , puedo usar uno o otro 
                                ya que el resto puede utilizar lo que es el cedula_ID o pasaporte para generar el txt entonces , para la importacion es mas sensillo ya que
                                 el campo que estoy armando es nescesario e iterativo , con esta respuesta, de echo puedo crear una tercera opcion de validacion , 
                                 o para mas o menos un prefijo que me permita generar o ser mas sensillo validar que condicion especial tengo que usar , 
                                 las nuevas que vengan unicamente si sigue el formato raro no se podran pero el resto que cuente con la busqueda estandar podra.
                                 actualmente existe 2 maneras de validar los datos por secuencia y por cedula asumo que solo existiran esas 2 manera 

                                entonces 
                                
                                                                EaGenCamExport(){
                                    generar

                                }

                                EaCargaIndividualExport(){
                                    generar()-> 
                                    json("producto":"2") // json(nombre de campo , espacion rango o posicion para la importacion)  // el campo es de base de datos
                                    {"cedula_id":"3","subtotal":"7","tipcta":"8","deduccion_impuesto":"10"}
                                   
                                    // respetar el orden de los id
                                    // hacer posible un merge ? 
                                    o usar un array que lea en asignando el espacion por numero.

                                    json("CO" : "1") // json(valor quemado , posicion ) //
                                    {"CO":"1","632575":"2"}
                                    
                                    //no puede usarse de esta forma // si uso campoF_ y campoB_

                                    podria recorrer e insetar todo en un array , tendria que realizar un orden 
                                    o modificar el array que se autordene 

                                    
                                    actividad , nescesito armar un txt diferenciado , usando el orden de los array , diferenciando si es dato quemado.
                                    o no , 

                                    pruebas seudocodigo: 
                                    //llama los json:
                                    
                                    global(){
                                    $campos = json->campos;
                                    $fijos = json->fijos;
                                    for( i= 0;   campoBase; i++){
                                        
                                        if(isset(campoF_.$i)){
                                            $desisivo= campoF_.$i ;//quemado
                                            //{"cedula_id":"3","subtotal":"7","tipcta":"8","deduccion_impuesto":"10"}
                                        } 
                                        

                                        if(isset(campoB_.$i)){
                                            
                                            
                                            $desisivo= $individual->campoB_.$i ;

                                        }
                                        $texto .=$desivo
                                        if(espacion==si){
                                            $texto .= "\t"
                                        }
                                    }
                                    $texto .= "\n"
                                }


                                    if(condicion valor $opcion) // $opcion  =  
                                    {"validacion_campo_1":"Establecimiento","validacion_valor_1":"873130"}
                                    first_line () -- // crear un json en caso que se nesesite algun valor en la primera linea
                                    // por el momento puedo usar un  case 
                                    // el txt empieza desde campo 0 , validar si existen espacios entre los campos o no 
                                    // empezara sin espacios por enden si se quiere una tabulacion desde el comienzo eso contaria como un tab
                                    // o por defecto como inserta el string , no se si puede insertar directamente el comando desde la base a 
                                    // la creacion del txt.


                                    //existe campo quemado de validacion 
                                    // hacer los mismo , solo con el nombre del campo , para extraer dato.
                                EaCargaIndividualImpor(){
                                    {"validacion_campo_1":"Establecimiento","validacion_valor_1":"873130"}
                                    campo_nombre : version en Detalle_debito , para insert // nombre , campos Importacion

                                }
                                
                                


                                cancelacion masiva () -> nuevo metodo , incluir 
                                */
                            }
                            $textoPlano .= (isset($individual->cod_establecimiento)) ? $establecimiento_print : "00000000";
                            //$textoPlano .= "-3-";
                            $textoPlano .= (isset($individual->date)) ? $individual->date : "000000";
                            //$individual->date;
                            //$textoPlano .= "-4-";
                            $textoPlano .= $subtotalF;
                            //$textoPlano .= "-5-";
                            $textoPlano .= $individual->constante1;
                            //$textoPlano .= "-6-";
                            $textoPlano .= $individual->constante2;
                            //$textoPlano .= "-7-";
                            $textoPlano .= $individual->constante3;
                            //$textoPlano .= "-8-";
                            $textoPlano .= $individual->constante4;
                            $cont++;
                            $cont_prin = 6 - strlen((string)($cont));
                            $cont_ceros2 = "";
                            for ($i = 0; $i < $cont_prin; $i++) {
                                $cont_ceros2 .= "0";
                            }
                            //$textoPlano .= "-9-";
                            $textoPlano .= $cont_ceros2 . $cont;
                            ///bloque para realizar insert en base con la secuencia en la tabla ea_detalle_debito
                            //$textoPlano .= "\t";
                            //$textoPlano .= "-10-";
                            $textoPlano .= $individual->constante5;
                            //$textoPlano .= "-11-";
                            $textoPlano .= (isset($individual->feccad)) ? $individual->feccad : "000000";
                            //preguntar si va quemado 
                            //$textoPlano .= $individual->feccad;
                            //$textoPlano .= "-12-";
                            $textoPlano .= $impuestoF;
                            //$textoPlano .= "-13-";
                            $textoPlano .= $individual->constante6;
                            //$textoPlano .= "-14-";
                            $textoPlano .= $individual->constante7;
                            //$textoPlano .= "-15-";
                            $textoPlano .= $individual->constante8;
                            //$textoPlano .= "-16-";
                            $cerossub = "";
                            $numberCeros = 15 - strlen((string)(floatval($individual->subtotal) * 100));
                            for ($i = 0; $i < $numberCeros; $i++) {
                                $cerossub .= "0";
                            }
                            $subtotalF = $cerossub . floatval($subtotal) * 100;
                            $textoPlano .= $subtotalF;
                            //$textoPlano .= "-17-";
                            $textoPlano .= $individual->constante9;
                            $textoPlano .= "\n";
                            if (!isset($request->carga_resp)) {
                                $condicion = true;
                                $id_carga = (isset($individual->id_carga) ? $individual->id_carga : 1);
                                $fecha_generacion = (isset($ultima_carga->fecha_generacion) ? $ultima_carga->fecha_generacion : 0);
                                if ($fecha_generacion != date('mY')) {
                                    $id_carga = (isset($ultima_carga->id_carga) ? $ultima_carga->id_carga : 0);
                                }
                                $row_insert_detalle = array();
                                $row_insert_detalle['id_sec'] = $individual->id_sec;
                                $row_insert_detalle['id_carga'] = $id_carga;
                                $row_insert_detalle['secuencia'] = $cont_ceros2 . $cont;
                                $row_insert_detalle['fecha_actualizacion'] = null;
                                $row_insert_detalle['fecha_registro'] = date('d/m/Y H:i:s');
                                $row_insert_detalle['producto'] = $request->producto;
                                $row_insert_detalle['subproducto'] = $request->producto;
                                $row_insert_detalle['cliente'] = $request->cliente;
                                $row_insert_detalle['estado'] = "0";
                                $row_insert_detalle['detalle'] = null;
                                $row_insert_detalle['bin'] = $example;
                                $row_insert_detalle['fecha_generacion'] =  date('mY');
                                $objEXPORT->view_reg_state($row_insert_detalle);
                            }
                            //area de validaciones -- por el momemto quemada
                            $detallevalidacion = array('validacion_campo_1' => 'Establecimiento', 'validacion_valor_1' => $individual->cod_establecimiento);
                        }
                        $tiempo_final = microtime(true);
                    }
                    if ($detalle_subproducto->tipo_subproducto == 'CTAS') {
                        foreach ($recorrido as $individual) {
                            $example = "CO";
                            $cont++;
                            $cont_ceros2 = "";
                            $textoPlano .= $example; //codigo de orientacion
                            $textoPlano .= "\t";
                            $textoPlano .= "632575"; // cuenta de la empresa //ver si púedo poner un json
                            $textoPlano .= "\t";
                            $textoPlano .= $cont; //secuencial
                            $textoPlano .= "\t";
                            $textoPlano .= date('Ymd'); //comprobante de cobro//fecha que se realia YYYYMMDD
                            $textoPlano .= "\t";
                            $textoPlano .= $individual->cedula_id; //contrapartida /// cedula_id
                            $textoPlano .= "\t";
                            $textoPlano .= "USD"; //moneda //USD //fijo ?
                            $textoPlano .= "\t";
                            $textoPlano .= str_replace(".", "", $individual->valortotal); //valor // viene de subproducto valorTotal
                            $textoPlano .= "\t";
                            $textoPlano .= "CTA"; /// forma de cobor // CTA // fijo ver si JSON
                            $textoPlano .= "\t";
                            $textoPlano .= "32"; // codigo banco // 32
                            $textoPlano .= "\t";
                            $textoPlano .= $individual->tipcta; // tipo cuenta // tipcta
                            $textoPlano .= "\t";
                            if (isset($individual->cuenta) and (strlen($individual->cuenta) > 20)) {
                                $example = Crypto::decrypt($individual->cuenta, $clave);
                            } else {
                                $example = "ERROR";
                            }
                            $textoPlano .= $example; //numero cuenta // BA - cuenta 
                            $textoPlano .= "\t";
                            $textoPlano .= $individual->tipide; //tipo cliente // tipide
                            $textoPlano .= "\t";
                            $textoPlano .= $individual->cedula_id; //numero id cliente // cedula_id
                            $textoPlano .= "\t";
                            $textoPlano .= $individual->nombre; //nombre completo BA
                            $textoPlano .= "\t";
                            $textoPlano .= ""; // espacion en blanco // direccion del deudor
                            $textoPlano .= "\t";
                            $textoPlano .= ""; // espacion en blanco // ciudad del deudor
                            $textoPlano .= "\t";
                            $textoPlano .= ""; // espacion en blanco // telefono del deudor
                            $textoPlano .= "\t";
                            $textoPlano .= ""; // espacion en blanco // localidad cobor
                            $textoPlano .= "\t";
                            $textoPlano .= "familia"; // referencia // de ley que hay que sacar del json
                            $textoPlano .= "\t";
                            $textoPlano .= ""; // espacion en blanco // referencia adicional
                            $textoPlano .= "\t";
                            $textoPlano .= 'NA'; // NA// base imponible
                            $textoPlano .= "\t";
                            $textoPlano .= 'NA'; // NA// iva bienes 
                            $textoPlano .= "\t";
                            $textoPlano .= str_replace(".", "", $individual->subtotal); // subproducto.subtotal // base imponible 
                            $textoPlano .= "\t";
                            $textoPlano .= str_replace(".", "", $individual->deduccion_impuesto); //iva servicios // subproducto.deduccion_impuesto
                            $textoPlano .= "\t";
                            $textoPlano .= ""; // espacion en blanco //ice
                            $textoPlano .= "\t";
                            $textoPlano .= ""; // espacion en blanco // referencia facturacion
                            $textoPlano .= "\t";
                            $textoPlano .= ""; // espacion en blanco // campo opcional 
                            $textoPlano .= "\n";
                            if (!isset($request->carga_resp)) {
                                $condicion = true;
                                $id_carga = (isset($individual->id_carga) ? $individual->id_carga : 1);
                                $fecha_generacion = (isset($ultima_carga->fecha_generacion) ? $ultima_carga->fecha_generacion : 0);
                                if ($fecha_generacion != date('mY')) {
                                    $id_carga = (isset($ultima_carga->id_carga) ? $ultima_carga->id_carga : 0);
                                }
                                $row_insert_detalle = array();
                                $row_insert_detalle['id_sec'] = $individual->id_sec;
                                $row_insert_detalle['id_carga'] = $id_carga;
                                $row_insert_detalle['secuencia'] = $individual->cedula_id; // cedula 
                                $row_insert_detalle['fecha_actualizacion'] = null;
                                $row_insert_detalle['fecha_registro'] = date('d/m/Y H:i:s');
                                $row_insert_detalle['producto'] = $request->producto;
                                $row_insert_detalle['subproducto'] = $request->producto;
                                $row_insert_detalle['cliente'] = $request->cliente;
                                $row_insert_detalle['estado'] = "0";
                                $row_insert_detalle['detalle'] = null;
                                //$row_insert_detalle['bin'] = $example;
                                $row_insert_detalle['fecha_generacion'] =  date('mY');
                                $objEXPORT->view_reg_state($row_insert_detalle);
                            }
                        }
                    }
                    break;
                case "BBOLIVARIANO":
                    # code...
                    break;
                case "BGR":
                    foreach ($recorrido as $individual) {

                        $subtotal = $individual->subtotal;
                        $numberCeros = 17 - strlen((string)(floatval($subtotal) * 100));
                        $cerossub = "";
                        for ($i = 0; $i < $numberCeros; $i++) {
                            $cerossub .= "0";
                        }
                        $subtotalF = $cerossub . floatval($subtotal) * 100;
                        $numberCeros = 17 - strlen((string)(floatval($individual->deduccion_impuesto) * 100));
                        $cerossub = "";
                        for ($i = 0; $i < $numberCeros; $i++) {
                            $cerossub .= "0";
                        }
                        $impuestoF = $cerossub . (floatval($individual->deduccion_impuesto) * 100);
                        //$textoPlano .= "\t";
                        $example = "0";
                        if (isset($individual->tarjeta) and (strlen($individual->tarjeta) > 20)) {
                            $example = Crypto::decrypt($individual->tarjeta, $clave);
                        } else {
                            $example = "1234560000000078";
                        }
                        //$textoPlano .= "-1-";
                        $textoPlano .= $example;
                        //$textoPlano .= "-2-";
                        $textoPlano .= (isset($individual->cod_establecimiento)) ? $$individual->cod_establecimiento : "00000000";
                        //$textoPlano .= "-3-";
                        $textoPlano .= (isset($individual->date)) ? $individual->date : "000000";
                        //$individual->date;
                        //$textoPlano .= "-4-";
                        $textoPlano .= $subtotalF;
                        //$textoPlano .= "-5-";
                        $textoPlano .= $individual->constante1;
                        //$textoPlano .= "-6-";
                        $textoPlano .= $individual->constante2;
                        //$textoPlano .= "-7-";
                        $textoPlano .= $individual->constante3;
                        //$textoPlano .= "-8-";
                        $textoPlano .= $individual->constante4;
                        $cont++;
                        $cont_prin = 6 - strlen((string)($cont));
                        $cont_ceros2 = "";
                        for ($i = 0; $i < $cont_prin; $i++) {
                            $cont_ceros2 .= "0";
                        }
                        //$textoPlano .= "-9-";
                        $textoPlano .= $cont_ceros2 . $cont;
                        ///bloque para realizar insert en base con la secuencia en la tabla ea_detalle_debito
                        //$textoPlano .= "\t";
                        //$textoPlano .= "-10-";
                        $textoPlano .= $individual->constante5;
                        //$textoPlano .= "-11-";
                        $textoPlano .= (isset($individual->feccad)) ? $individual->feccad : "000000";
                        //$textoPlano .= $individual->feccad;
                        //$textoPlano .= "-12-";
                        $textoPlano .= $impuestoF;
                        //$textoPlano .= "-13-";
                        $textoPlano .= $individual->constante6;
                        //$textoPlano .= "-14-";
                        $textoPlano .= $individual->constante7;
                        //$textoPlano .= "-15-";
                        $textoPlano .= $individual->constante8;
                        //$textoPlano .= "-16-";
                        $cerossub = "";
                        $numberCeros = 15 - strlen((string)(floatval($individual->subtotal) * 100));
                        for ($i = 0; $i < $numberCeros; $i++) {
                            $cerossub .= "0";
                        }
                        $subtotalF = $cerossub . floatval($subtotal) * 100;
                        $textoPlano .= $subtotalF;
                        //$textoPlano .= "-17-";
                        $textoPlano .= $individual->constante9;
                        $textoPlano .= "\n";
                    }
                    break;
                case "PICHINCHA":
                    # code...
                    break;
                case "PRODUBANCO":
                    # code...
                    break;
                case "DINERS":
                    # code...
                    break;
                case "MOVISTAR":
                    # code...
                    break;
                case "NOVA":
                    # code...
                    break;
                case "REALME":
                    # code...
                    break;
                case "SAMSUNG":
                    # code...
                    break;
                default:
                    # code...
                    break;
            }

            if ($condicion == true) {
                $id_carga = (isset($ultima_carga->id_carga) ? $ultima_carga->id_carga : 0);
                $fecha_generacion = (isset($ultima_carga->fecha_generacion) ? $ultima_carga->fecha_generacion : 0);
                $file_reg_carga = array();
                $file_reg_carga['cod_carga'] = $id_carga;
                $file_reg_carga['cliente'] = $request->clinte;
                $file_reg_carga['producto'] = $request->producto;
                $file_reg_carga['fecha_registro'] = date('d/m/Y H:i:s');
                $file_reg_carga['fec_carga'] = $fecha_generacion;
                $file_reg_carga['usuario'] = \Auth::user()->username;
                $validoacion_par = json_encode($detallevalidacion);
                $objEXPORT->registro_cargas($file_reg_carga, $validoacion_par);
                $fileName = $request->cliente . "-" . $detalle_subproducto->desc_subproducto . "-" . date("d-m-Y") . "-" .  $varcontrolsecuencia . ".txt";
                //$request->cliente, $request->producto
                //$request->carga_resp
                $success = 'se genero exitosamente , se procede a realizar la descarga ';
                return redirect()->route('EaCargaIndividualImport.index')->with([
                    'success' => isset($success) ? $success : '',
                    'generacionVal' => isset($success) ? '200' : '',
                    'carga_resp' => ($id_carga + 1),
                    'producto' => isset($request->producto) ? $request->producto : '',
                    'cliente' => isset($request->cliente) ? $request->cliente : '',
                    'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : '',
                    'registros_no_cumplen' => isset($registros_no_cumplen) ? $registros_no_cumplen : ''
                ]);
                /* $headers = [
                    'Content-type' => 'text/plain',
                    'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
                ];
                return Response::make($textoPlano, 200, $headers);*/
            } else {
                $fileName = $request->cliente . "-" . $detalle_subproducto->desc_subproducto . "-" . date("d-m-Y") . "-" . $varcontrolsecuencia .  ".txt";
                $headers = [
                    'Content-type' => 'text/plain',
                    'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
                ];
                return Response::make($textoPlano, 200, $headers);
            }

            return redirect()->route('EaCargaIndividualImport.index')->with([
                'success' => isset($success) ? $success : '',
                'errorTecnico' => isset($errorTecnico) ?  $errorTecnico  : 'hubo un error disculpe los inconvenientes',
                'registros_no_cumplen' => isset($registros_no_cumplen) ? $registros_no_cumplen : ''
            ]);
        }
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
