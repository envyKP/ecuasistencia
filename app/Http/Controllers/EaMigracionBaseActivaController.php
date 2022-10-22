<?php

namespace App\Http\Controllers;

use App\Models\EaMigracionBaseActiva;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\EaClienteController;
use App\Http\Controllers\EaBaseActivaController;
use App\Http\Controllers\EaUtilController;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
class EaMigracionBaseActivaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $clientes =  ( new EaClienteController)->getAllCampanas();
        $RegistrosPendientes = EaMigracionBaseActiva::/*where('estado', 'PEN')->*/orderBy('cod_carga')->paginate(5);

        return view ('migrarBaseAct.home')->with(compact('clientes'))
                                          ->with(compact('RegistrosPendientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadArchivos(Request $request)
    {

        $nombre_archivo = "";
        $extension = $request->file('archivo')->extension();

        if ( is_null($request->cliente)) {

            $msj="Debe seleccionar un cliente.";

        } else if ( strtolower($extension) !== "txt" ) {

            $msj="El fichero debe ser de tipo txt.";

        }else {

            $datos = $request->except('_token','archivo');
            $cod_carga = EaMigracionBaseActiva::max('cod_carga');

            if( isset($cod_carga) && $cod_carga !== 1 ){

                $existe_visible =  EaMigracionBaseActiva::where('visible', 'S')->exists();
                !$existe_visible ? $datos['visible'] = 'S' : '';
                $cod_carga ++;

            } else {
                $cod_carga = 1;
                $datos['visible'] = 'S';
            }

            $datos['cod_carga'] = $cod_carga;

            if ( $request->hasfile('archivo')) {

                $nombre_archivo = $request->file('archivo')->getClientOriginalName();
                $datos['nombre_archivo'] = $request->file('archivo')->storeAs('ArchivosMigrar/'.$request->cliente, $nombre_archivo, 'public');

                $datos['fec_registro'] = date('d/m/Y H:i:s');
                $datos['estado'] = 'PENDIENTE';

                EaMigracionBaseActiva::insert($datos);

            }
        }

        return redirect()->route('EaMigracionBaseActivaController.home')->with([ 'success' => 'Archivo '. isset($nombre_archivo) ? $nombre_archivo : '' .' del cliente: '.$request->cliente.' cargado, estado pendiente!',
                                                                                 'error' => isset($msj) ? $msj : null ]);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EaMigracionBaseActiva  $eaMigracionBaseActiva
     * @return \Illuminate\Http\Response
     */
    public function procesar (Request $request)
    {

        $proceso = EaMigracionBaseActiva::where('cod_carga', $request->cod_carga)
                                        ->where('estado', 'PENDIENTE')
                                        ->first();

        $fec_carga = date ('d/m/Y H:i:s');
        $posicion = strpos($proceso->nombre_archivo, $proceso->cliente);
        $nombre_archivo = explode("/", substr($proceso->nombre_archivo, $posicion))[1] ;

        $det = $this->procesarFichero($proceso);
        $total_reg = $det['total_registros'];
        $cargados_registros = $det['cargados_registros'];
        $existentes_registros = $det['existentes_registros'];

        if ( empty($det['error']) ) {

            EaMigracionBaseActiva::where('cod_carga', $request->cod_carga)
                                 ->where('estado', 'PENDIENTE')
                                 ->update(['estado' => 'PROCESADO',
                                           'total_registros' => $total_reg,
                                           'registros_cargados' => $cargados_registros,
                                           'registros_duplicados' => $existentes_registros,
                                           'fec_carga' => $fec_carga,
                                           'visible' => 'N' ]);

            EaMigracionBaseActiva::where('cod_carga', $request->cod_carga+1)
                                 ->where('estado', 'PENDIENTE')
                                 ->update(['visible' => 'S']);

            $success = 'Archivo '. $nombre_archivo.' del cliente: '.$proceso->cliente.' procesado, ver resumen del detalle!';

        } else {

            $error = $det['error'];
            $lineaError = $det['lineaError'];

            EaMigracionBaseActiva::where('cod_carga', $request->cod_carga)
                                 ->where('estado', 'PENDIENTE')
                                 ->update([ 'estado' => 'ERROR',
                                            'total_registros' => $total_reg,
                                            'fec_carga' => $fec_carga,
                                            'visible' => 'N']);

            EaMigracionBaseActiva::where('cod_carga', $request->cod_carga+1)
                                 ->where('estado', 'PENDIENTE')
                                 ->update(['visible' => 'S']);
        }


        return redirect()->route('EaMigracionBaseActivaController.home')->with(['success' => isset($success) ? $success : '',
                                                                                'error' => isset($error) ? $error : '',
                                                                                'lineaError' => isset($lineaError) ? $lineaError : '',
                                                                                'cargados_registros' => isset ($det['cargados_registros']) ? $det['cargados_registros'] : '',
                                                                                'total_registros' =>  isset($det['total_registros']) ? $det['total_registros'] :'' ,
                                                                                'existentes_registros' => isset($det['existentes_registros']) ? $det['existentes_registros'] : '' ,
                                                                                'existentes' => isset($det['existentes']) ? $det['existentes'] : '',
                                                                                'cod_carga' => isset($det['cod_carga']) ? $det['cod_carga'] : ''
                                                                              ]);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EaMigracionBaseActiva  $eaMigracionBaseActiva
     * @return \Illuminate\Http\Response
     */
    public function edit(EaMigracionBaseActiva $eaMigracionBaseActiva)
    {
        //
    }


    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EaMigracionBaseActiva  $eaMigracionBaseActiva
     * @return \Illuminate\Http\Response
     */
    public function procesarFichero(EaMigracionBaseActiva $eaMigracionBaseActiva)
    {
        $contenido = file_get_contents("../salsa.txt");
        $clave = Key::loadFromAsciiSafeString($contenido);
        $fecha_hoy = date('Y-m-d H:i:s');
        $ObjBaseActiva = (new EaBaseActivaController);
        $producto = (new EaProductoController);
        $util = (new EaUtilController);
        $total_registros= 0;
        $existentes_registros = 0;
        $cargados_registros = 0;
        $data = array();
        $detalleCarga = array();
        $existentes = array();
        $posicion = strpos($eaMigracionBaseActiva->nombre_archivo, $eaMigracionBaseActiva->cliente);
        $nombreArchivo = explode("/", substr($eaMigracionBaseActiva->nombre_archivo, $posicion))[1];

        $content = fopen( Storage::path('public/'.$eaMigracionBaseActiva->nombre_archivo), 'r' );

            while(!feof($content)){

                $total_registros++;
                $line = fgets($content);

                if ( !empty($line) ) {

                    $linea_spanish = utf8_encode($line);
                    $columnas = count(explode("\t", $line));

                    /*if ($columnas == 69)
                    {*/
                            # code...preg_replace("/[^A-Za-z0-9\-\']/"

                        $data['fecact']  = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[0]) ));
                        $data['cuenta']  = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[1]) ));
                        $data['cuenta'] =  !empty($data['cuenta']) ? Crypto::encrypt($data['cuenta'], $clave) :  '' ;
                        
                        $data['tarjeta'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[2]) ));
                        $data['tarjeta'] =  !empty($data['tarjeta']) ? Crypto::encrypt($data['tarjeta'], $clave) :  '' ;
                        
                        $data['nombre']  = trim( str_replace("\"", "", explode("\t", $linea_spanish)[3]) );
                        $data['tipide']  = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[4]) ));
                        $data['dettipide'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[5]) ));
                        $data['cedula_id'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[6]) ));
                        $direccion = trim(str_replace("\"", "", explode("\t", $linea_spanish)[7]));
                        $data['direccion'] = trim( substr( $direccion, 0,80) );
                        $data['genero'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[8]) ));
                        $data['fechanacimiento'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '',  str_replace("\"", "", explode("\t", $linea_spanish)[9]) ));
                        $data['tiptar'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[10]) ));
                        $data['dettiptar'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[11]) ));
                        $data['tipcta'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[12]) ));
                        if ( $data['tipcta'] == 'AHO') {
                            $tipo_cuenta = 'AHORRO';
                        }else if (  $data['tipcta'] == 'CTE' ){
                            $tipo_cuenta = 'CORRIENTE';
                        }else{
                            $tipo_cuenta = null;
                        }
                        $data['dettipcta'] = $tipo_cuenta; //str_replace("\"", "", explode("\t", $linea_spanish)[13]);
                        $data['ciclo'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[14]) ));
                        $data['dettipcic'] = trim(str_replace("\"", "", explode("\t", $linea_spanish)[15]));
                        $data['feccad'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[16]) ));
                        $data['tipact'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[17]) ));
                        $data['dettipact'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[18]) ));
                        $data['numeroant'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[19]) ));
                        $data['ciudad'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[20])));
                        $data['ciudadet'] = trim(str_replace("\"", "", explode("\t", $linea_spanish)[21]) );
                        $data['codestado'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[22]) ));
                        $data['detestado'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[23]) ));
                        $data['usmod'] = trim(str_replace("\"", "", explode("\t", $linea_spanish)[24]));
                        $data['fecmod'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[25]) ));
                        $data['hormod'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[26]) ));
                        $data['feccan'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[27]) ));
                        $data['codestar'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[28]) ));
                        $data['detestar'] = trim(str_replace("\"", "", explode("\t", $linea_spanish)[29]));
                        $data['freact'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[30]) ));
                        $data['fsuspt'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[31]) ));
                        $data['fcanct'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[32]) ));
                        $data['estado'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[33]) ));
                        $data['tipresp'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[34]) ));
                        $data['codresp'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[35]) ));
                        $data['detresp'] = trim(str_replace("\"", "", explode("\t", $linea_spanish)[36]));
                        $data['fecha'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[37]) ));
                        $data['hora'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[38]) ));
                        $data['operador'] = trim(str_replace("\"", "", explode("\t", $linea_spanish)[39]));
                        $data['proveedor'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[40]) ));
                        $data['observaciones'] = trim(str_replace("\"", "", explode("\t", $linea_spanish)[41]));
                        $data['telefono_contacto'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '',  str_replace("\"", "", explode("\t", $linea_spanish)[42]) ));
                        $data['telefono1'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[43]) ));
                        $data['telefono2'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[44]) ));
                        $data['telefono3'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[45]) ));
                        $data['telefono4'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[46]) ));
                        $data['telefono5'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[47]) ));
                        $data['telefono6'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[48]) ));
                        $data['telefono7'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[49]) ));
                        $data['mail'] = trim(str_replace("\"", "", explode("\t", $linea_spanish)[50]));
                        $data['origen'] = trim( preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[51]) ));
                        $data['cliente'] = $eaMigracionBaseActiva->cliente;

                        try{

                            $productoDet = $producto->getProductoDetalle($data['cliente'], preg_replace("/[^A-Za-z0-9\-\/:']/", '', str_replace("\"", "", explode("\t", $linea_spanish)[53]) ));
                            $data['producto'] = $productoDet->contrato_ama; //str_replace("\"", "", explode("\t", $linea_spanish)[53]);
                            $data['desc_producto'] = $productoDet->desc_producto;  //strtoupper( str_replace("\"", "", explode("\t", $linea_spanish)[54]) );

                        }catch(\Exception $e ){
                            $detalleCarga['error'] = "Error en ID cliente: ".$data['cliente'] ." o contrato AMA : ".explode("\t", $linea_spanish)[53];
                            $detalleCarga['lineaError'] = $linea_spanish;
                        }

                        $data['subproducto'] = trim(strtoupper( $util->quitar_tildes( str_replace("\"", "", explode("\t", $linea_spanish)[55]) )));
                        $data['fecha_reg'] = $fecha_hoy;
                        $data['usuario_reg'] = $eaMigracionBaseActiva->usuario_registra;
                        $data['file_base_colocacion'] = $nombreArchivo;

                        //$existe = $ObjBaseActiva->validaResgistro($data);
                        //if (!$existe) {
                                try{

                                    $ObjBaseActiva->storeArchivo($data);
                                    $cargados_registros++;

                                }catch(\Exception $e){

                                    $detalleCarga['error'] = $e->getMessage();
                                    $detalleCarga['lineaError'] = $linea_spanish;
                                }

                        /*}else{
                                $existentes_registros++;
                                $duplicado['cedula_id'] = $data['cedula_id'];
                                $duplicado['cliente'] = $data['cliente'];
                                $duplicado['nombre'] = $data['nombre'];

                                array_push($existentes, $duplicado);
                        }*/
                   /* }else {

                        $detalleCarga['error'] = 'No contiene el numero de columnas configuradas';
                        $detalleCarga['lineaError'] = $linea_spanish;

                    } */
                }
            }

            fclose($content);

            if ( !empty($detalleCarga['error']) && !empty($data)) {
                $ObjBaseActiva->reversoArchivo($data); //elimino data cargada.
            }

            $detalleCarga['cod_carga'] = $eaMigracionBaseActiva->cod_carga;
            $detalleCarga['cargados_registros'] = $cargados_registros;
            $detalleCarga['total_registros'] = $total_registros;
            $detalleCarga['existentes_registros'] = $existentes_registros;
            $detalleCarga['existentes'] = $existentes;

            return $detalleCarga;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EaMigracionBaseActiva  $eaMigracionBaseActiva
     * @return \Illuminate\Http\Response
     */
    public function destroy($cod_carga)
    {

        $cliente  = EaMigracionBaseActiva::where('cod_carga', $cod_carga)->first();

        $posicion =  strpos($cliente->nombre_archivo, $cliente->cliente);
        $nombre_archivo = explode('/', substr($cliente->nombre_archivo, $posicion) )[1];

        Storage::disk('public')->delete($cliente->nombre_archivo);

        EaMigracionBaseActiva::where('cod_carga', $cod_carga)
                             ->delete();

        $cod_carga_b = EaMigracionBaseActiva::where('estado', 'PENDIENTE')
                                            ->min('cod_carga');

        if ($cod_carga_b) {

            EaMigracionBaseActiva::where('estado', 'PENDIENTE')
                                 ->where('cod_carga', $cod_carga_b)
                                 ->update([ 'visible' => 'S' ]);
        }


        return redirect()->route('EaMigracionBaseActivaController.home')->with(['delete' => 'Archivo '. $nombre_archivo.' del cliente: '.$cliente->cliente.' eliminado!']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function home(){

        $clientes =  ( new EaClienteController)->getAllCampanas();
        $RegistrosPendientes = EaMigracionBaseActiva::/*where('estado', 'PEN')->*/orderBy('cod_carga')->paginate(4);

        return view ('migrarBaseAct.home')->with(compact('RegistrosPendientes'))
                                          ->with(compact('clientes'));
    }

}
