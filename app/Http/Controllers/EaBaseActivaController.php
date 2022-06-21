<?php

namespace App\Http\Controllers;

use App\Models\EaBaseActiva;
use App\Models\EaCliente;
use App\Models\EaTipoId;
use App\Models\EaCicloCorte;
USE App\Models\EaTipoActivacion;
use App\Models\EaCodigoEstadoGestion;
use App\Models\EaCodigoEstadoCliente;
use App\Models\EaCiudad;
use App\Models\EaCodigoRespuesta;
use App\Models\EaCallTypeRetencion;
use App\Models\EaMotivosDesactivacion;
use App\Models\EaRetenciones;
use Illuminate\Http\Request;
use App\Http\Controllers\EaClienteController;
use App\Http\Controllers\EaProductoController;
use App\Http\Controllers\EaSubproductoController;
use App\Http\Controllers\EaUtilController;
use App\Http\Controllers\EaRetencionesController;
use Closure;
use Carbon\Carbon;

require_once "../vendor/autoload.php";
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

class EaBaseActivaController extends Controller
{



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EaBaseActiva  $eaBaseActiva
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function buscarSeleccion(Request $request)
    {

        $hora  = Date('H:i:s');
        $fecha = Date('d/m/Y');

        $hora = Date('H:i:s');
        $fecha = Date('d/m/Y');

        $campana = (new EaClienteController)->getConfigCampana($request);
        $tiposIdentificacion = EaTipoId::all();
        $ciclosCortes = EaCicloCorte::all();
        $estadosGestion = EaCodigoEstadoGestion::All();
        $tiposActivacion = EaTipoActivacion::All();
        $estadosCliente = EaCodigoEstadoCliente::All();
        $ciudades = EaCiudad::All();
        $productos  = (new EaProductoController)->getProductosAll($request);
        $callTypesRetencion = EaCallTypeRetencion::All();

        if ( strcmp ($campana->cliente, 'PRODUBANCO' )===0 ) {
            unset( $tiposIdentificacion[2], $tiposIdentificacion[3], $tiposIdentificacion[4]);
        } else {
            unset( $tiposIdentificacion[0], $tiposIdentificacion[1]);
        }

        $data['dataCliente'] = $this->getClienteHist($request);
        $cliente['clienteGestionActual'] = EaBaseActiva::Where('id_sec', $request->id_sec)->first();

        if ( !is_null($cliente['clienteGestionActual']) && $cliente['clienteGestionActual']['fechanacimiento'] ){
            $fechanacimiento =  $cliente['clienteGestionActual']['fechanacimiento'];
            $cliente['clienteGestionActual']['fechanacimiento']  = Carbon::createFromFormat('d/m/Y', $fechanacimiento)->format('Y-m-d');

        }

        // Datos de retencion :: por cliente
        if ( !is_null($cliente['clienteGestionActual']) ) {
            $retencionCliente = EaRetenciones::Where('cedula_id', $request->cedula_id)
                                             ->Where('cliente', $request->cliente)
                                             ->where('id_sec', $cliente['clienteGestionActual']['id_sec'])
                                             ->first();
        }




        return view ('cliente.home')->with(compact('campana'))
                                    ->with(compact('hora'))
                                    ->with(compact('fecha'))
                                    ->with( $cliente )
                                    ->with( $data )
                                    ->with(compact('tiposIdentificacion'))
                                    ->with(compact('ciclosCortes'))
                                    ->with(compact('estadosGestion'))
                                    ->with(compact('tiposActivacion'))
                                    ->with(compact('estadosCliente'))
                                    ->with(compact('ciudades'))
                                    ->with(compact('callTypesRetencion'))
                                    ->with( isset($retencionCliente) ? compact('retencionCliente') : '' )
                                    ->with(compact('productos'));


    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EaBaseActiva  $eaBaseActiva
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function serch(Request $request)
    {

        $hora  = Date('H:i:s');
        $fecha = Date('d/m/Y');

        if ( isset($request->cedula_id ) )
        {

            if (  isset($request->proceso) && $request->proceso === 'moduloBuscar' )  {

                $dataCliente = $this->getClienteHistporModuloBuscar($request->cedula_id, $request->cliente, $request->id_sec);

            }else {

                $dataCliente = $this->getClienteHist($request);

            }


            if ( count($dataCliente) ==0 ){

                $error = "No existe información para la identificación: ".$request->cedula_id;
            }


        }else {
            $error ="Debe ingresar la identificacion";

        }


        return redirect()->route('EaBaseActivaController.show', [$request] )->with([ 'error' => isset($error) ? $error : '',
                                                                                     'fromCliente' => 'cliente' ]);


    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) //solo guarda logica para agregar la informacion del nuevo cliente, pestaña de asistencia maneja otra logica
    {

        $datos = $request->except('_token', '_method', 'id_sec' );

        $id_sec = EaBaseActiva::max('id_sec');
        $datos['usuario_reg'] = $request->usmod;
        $datos['fecha_reg']  = Date('d/m/Y H:i:s');

        if ( isset($id_sec) && $id_sec !== 1 ){
            $id_sec = $id_sec + 1;
        }else {
            $id_sec = 1;
        }

        $datos['id_sec'] = $id_sec;
        $datos['fechanacimiento'] = date( 'd/m/Y', strtotime($request->fechanacimiento) );

        //no existe tabla para mapear
        if ( $request->tiptar === 'P' ) {
            $datos['dettiptar'] ='PRINCIPAL';
        }else if ( $request->tiptar === 'A' ){
            $datos['dettiptar'] ='ADICIONAL';
        }

        $datos['operador'] = $request->usmod;
        $datos['proveedor'] = 'Usuario interno';
        $datos['dettipide'] = EaTipoId::where('codigo_id', $request->tipide)->first()->descripcion_id;
        $datos['dettipact'] = EaTipoActivacion::where('tipo', $request->tipact)->first()->detalle;
        $datos['ciudadet']  = EaCiudad::where('ciudad', $request->ciudad)->first()->detalle;
        $datos['detestado'] = EaCodigoEstadoCliente::where('codigo', $request->codestado)->first()->detalle;
        $datos['desc_producto'] = (new EaProductoController)->getProductoDetalle( $request->cliente, $request->producto)->desc_producto;

        EaBaseActiva::Insert($datos);

        return redirect()->route('EaBaseActivaController.show', [$request] )->with( ['ok' => 'TrxOK'  , 'mensaje' => 'Cliente: '.$request->nombre.' ingresado!.',
                                                                                     'fromCliente' => 'cliente' ]);

    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EaBaseActiva  $eaBaseActiva
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request)
    {


        $hora = Date('H:i:s');
        $fecha = Date('d/m/Y');

        $campana = (new EaClienteController)->getConfigCampana($request);
        $tiposIdentificacion = EaTipoId::all();
        $ciclosCortes = EaCicloCorte::all();
        $estadosGestion = EaCodigoEstadoGestion::All();
        $tiposActivacion = EaTipoActivacion::All();
        $estadosCliente = EaCodigoEstadoCliente::All();
        $ciudades = EaCiudad::All();
        $productos  = (new EaProductoController)->getProductosAll($request);
        $callTypesRetencion = EaCallTypeRetencion::All();
        $contenido = file_get_contents("../salsa.txt");
        $clave = Key::loadFromAsciiSafeString($contenido);


        if ( strcmp ($campana->cliente, 'PRODUBANCO' )===0 ) {
            unset( $tiposIdentificacion[2], $tiposIdentificacion[3], $tiposIdentificacion[4]);
        } else {
            unset( $tiposIdentificacion[0], $tiposIdentificacion[1]);
        }


        if ( isset($request->proceso) && $request->proceso === 'moduloBuscar' ) {

            $dataCliente = $this->getClienteHistporModuloBuscar($request->cedula_id, $request->cliente, $request->id_sec);

            $cliente['clienteGestionActual'] = EaBaseActiva::Where('cedula_id', $request->cedula_id)
                                                           ->Where('cliente', $request->cliente)
                                                           ->where('id_sec', $request->id_sec)
                                                           ->first();

            $cliente['clienteGestionActual']['tarjeta'] =  !empty ($cliente['clienteGestionActual']['tarjeta']) ? Crypto::decrypt($cliente['clienteGestionActual']['tarjeta'], $clave) : '' ;
            $cliente['clienteGestionActual']['cuenta'] = !empty ($cliente['clienteGestionActual']['cuenta'])  ? Crypto::decrypt($cliente['clienteGestionActual']['cuenta'], $clave) : '';


        }else {


            $dataCliente = $this->getClienteHist($request);
            $cliente['clienteGestionActual'] = EaBaseActiva::Where('cedula_id', $request->cedula_id)
                                                           ->Where('cliente', $request->cliente)
                                                           ->orderByDesc('id_sec')
                                                           ->first();

            if ( !is_null($cliente['clienteGestionActual']) ) {
                $cliente['clienteGestionActual']['tarjeta'] = !empty ($cliente['clienteGestionActual']['tarjeta']) ? Crypto::decrypt($cliente['clienteGestionActual']['tarjeta'], $clave) : '' ;
                $cliente['clienteGestionActual']['cuenta'] = !empty ($cliente['clienteGestionActual']['cuenta'])  ? Crypto::decrypt($cliente['clienteGestionActual']['cuenta'], $clave) : '';
            }

        }


        if ( !is_null($cliente['clienteGestionActual']) && !empty ($cliente['clienteGestionActual']['fechanacimiento']) ){

            $fechanacimiento =  $cliente['clienteGestionActual']['fechanacimiento'];
            $cliente['clienteGestionActual']['fechanacimiento']  = Carbon::createFromFormat('d/m/Y', $fechanacimiento)->format('Y-m-d');

        }


        // Datos de retencion :: por cliente
        if ( !is_null($cliente['clienteGestionActual']) ) {
            $retencionCliente = EaRetenciones::Where('cedula_id', $request->cedula_id)
                                             ->Where('cliente', $request->cliente)
                                             ->where('id_sec', $cliente['clienteGestionActual']['id_sec'])
                                             ->first();
        }




        return view ('cliente.home')->with(compact('campana'))
                                    ->with(compact('hora'))
                                    ->with(compact('fecha'))
                                    ->with( $cliente )
                                    ->with(compact('dataCliente'))
                                    ->with(compact('tiposIdentificacion'))
                                    ->with(compact('ciclosCortes'))
                                    ->with(compact('estadosGestion'))
                                    ->with(compact('tiposActivacion'))
                                    ->with(compact('estadosCliente'))
                                    ->with(compact('ciudades'))
                                    ->with(compact('callTypesRetencion'))
                                    ->with( isset($retencionCliente) ? compact('retencionCliente') : '' )
                                    ->with(compact('productos'));

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\EaBaseActiva  $EaBaseActiva
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update( Request  $request)
    {

        $id_sec = $request->id_sec;
        $datos = $request->except('_token', '_method', 'id_sec', 'horasys');

        $resp = EaBaseActiva::where('cedula_id', $request->cedula_id)
                            ->where('id_sec', $id_sec)
                            ->update($datos);

        return $resp;
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EaBaseActiva  $eaBaseActiva
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function editCli(Request $request)
    {



        if (!is_null($request->mail)) {
            $valido_email = (new EaUtilController)->is_valid_email($request->mail);
        }


        if ( !$valido_email ) {

            $error ="Direccion de correo invalida";

        }else {

            $cliente = $request->except('_token', '_method');

            $sysdate = Date('d/m/Y');
            $cliente['usmod']  =  $request->usmod;
            $cliente['fecmod'] = $sysdate;
            $cliente['hormod'] = Date('H:i:s');
            $cliente['fechanacimiento'] = date( 'd/m/Y', strtotime($request->fechanacimiento) );

            //no existe tabla para mapear
            if ( $request->tiptar === 'P' ) {
                $cliente['dettiptar'] ='PRINCIPAL';
            }else if ( $request->tiptar === 'A' ){
                $cliente['dettiptar'] ='ADICIONAL';
            }

            if ( strcmp ($request->codestado, 'A')===0 ) {
                $cliente['fecact'] = $sysdate;
            }

            if ( !is_null($request->tipide)) {
                $cliente['dettipide'] = EaTipoId::where('codigo_id', $request->tipide)->first()->descripcion_id;
            }
            if ( !is_null($request->ciudad)) {
                $cliente['ciudadet']  = EaCiudad::where('ciudad', $request->ciudad)->first()->detalle;
            }

            $request->merge($cliente);
            $resp = $this->update($request);

            $success = 'Información del cliente Actualizado!.';

        }

        return redirect()->route('EaBaseActivaController.show', [$request] )->with( [ 'success' =>  isset($success) ? $success : '',
                                                                                      'error' => isset($error) ? $error : '',
                                                                                      'fromCliente' => 'cliente' ] );

    }


     /**
     * Display the specified resource.
     *
     * @param  \App\Models\EaBaseActiva  $eaBaseActiva
     * @param  \Illuminate\Http\Request  $request
     */
    public function getClienteHist(Request  $request)
    {

        $data = EaBaseActiva::Where('cedula_id',$request->cedula_id)
                            ->Where('cliente', $request->cliente)
                            ->orderByDesc('id_sec')
                            ->get();
        return $data;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EaBaseActiva  $eaBaseActiva
     * @param  \Illuminate\Http\Request  $request
     */
    public function getClienteHistporModuloBuscar($cedula, $cliente, $id_sec)
    {

        $data = EaBaseActiva::Where('cedula_id',$cedula)
                            ->Where('cliente', $cliente)
                            ->Where('id_sec', $id_sec)
                            ->orderByDesc('id_sec')
                            ->get();

        return $data;
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EaBaseActiva  $EaBaseActiva
     * @return \Illuminate\Http\Response
     */
    //aunque la accion sea de edit, el requerimiento es de generar un nuevo registro con los nuevos estados de la asistencia
    public function editAsistencia(Request $request)
    {


        $baseActivaCliente = EaBaseActiva::where('cliente', $request->cliente)
                                         ->where('id_sec', $request->id_sec)
                                         ->first();
        $sysdate = Date('d/m/Y');
        $cliente = $request->except('_token', '_method', 'call_type_retencion', 'origen', 'motivos_desactivacion');
        $retencion = $request->only('call_type_retencion', 'origen', 'motivos_desactivacion');


        $cliente['fecmod'] = date($sysdate);
        $cliente['hormod'] = date('H:i:s');
        $cliente['usmod']  =  $request->usmod;
        //datos pestaña de infor cliente
        $cliente['nombre'] = $baseActivaCliente->nombre;
        $cliente['tipide'] = $baseActivaCliente->tipide;
        $cliente['dettipide'] = $baseActivaCliente->dettipide;
        $cliente['cedula_id'] = $baseActivaCliente->cedula_id;
        $cliente['genero'] = $baseActivaCliente->genero;
        $cliente['ciudad'] = $baseActivaCliente->ciudad;
        $cliente['ciudadet']  = $baseActivaCliente->ciudadet;
        $cliente['direccion'] = $baseActivaCliente->direccion;
        $cliente['fechanacimiento'] = $baseActivaCliente->fechanacimiento;
        $cliente['tiptar'] = $baseActivaCliente->tiptar;
        $cliente['dettiptar'] = $baseActivaCliente->dettiptar;
        $cliente['telefono_contacto'] = $baseActivaCliente->telefono_contacto;
        $cliente['mail'] =  $baseActivaCliente->mail;
        $cliente['producto'] =  $baseActivaCliente->producto;
        $cliente['desc_producto'] =  $baseActivaCliente->desc_producto;
        $cliente['subproducto'] =  $baseActivaCliente->subproducto;
        $cliente['telefono1'] = $baseActivaCliente->telefono1;
        $cliente['telefono2'] = $baseActivaCliente->telefono2;
        $cliente['telefono3'] = $baseActivaCliente->telefono3;
        $cliente['telefono4'] = $baseActivaCliente->telefono4;
        $cliente['telefono5'] = $baseActivaCliente->telefono5;
        $cliente['telefono6'] = $baseActivaCliente->telefono6;
        $cliente['telefono7'] = $baseActivaCliente->telefono7;
        $cliente['tipact']  = $baseActivaCliente->tipact;
        $cliente['dettipact'] = $baseActivaCliente->dettipact;
        $cliente['codresp'] = $baseActivaCliente->codresp;
        $cliente['tipresp'] = $baseActivaCliente->tipresp;
        $cliente['detresp'] = $baseActivaCliente->detresp;


        //======================================================================================= Validacion de inputs fuera de rol admin =========================================================================================================//
        if ( !empty( $request->ciclo)) {
            $cliente['dettipcic'] = EaCicloCorte::where('ciclo', $request->ciclo)->first()->corte;
        }else {
            $cliente['ciclo'] = $baseActivaCliente->ciclo;
            $cliente['dettipcic'] = $baseActivaCliente->dettipcic;
        }

        if (!is_null($request->tipcta)) {

            if ($request->tipcta === 'CTE' ) {
                $cliente['dettipcta'] ='CORRIENTE';
            }else if ( $request->tipcta  === 'AHO' ){
                $cliente['dettipcta'] ='AHORRO';
            }

        }else {
            $cliente['tipcta'] = $baseActivaCliente->tipcta;
            $cliente['dettipcta'] = $baseActivaCliente->dettipcta;
        }


        if ( is_null($request->tarjeta) || str_contains($request->tarjeta, "XXXX") ){
            $cliente['tarjeta'] = $baseActivaCliente->tarjeta;
        }

        if ( is_null($request->feccad) || str_contains($request->feccad, "XX")){
            $cliente['feccad'] = $baseActivaCliente->feccad;
        }

        if ( is_null($request->cuenta) || str_contains($request->cuenta, "XXXXXXX")) {
            $cliente['cuenta'] = $baseActivaCliente->cuenta;
        }


        //===================================================================================================================================================================================================================//
            if (  !is_null($request->codestado)) {
                $cliente['detestado'] = EaCodigoEstadoCliente::where('codigo', $request->codestado)->first()->detalle;
            }

            if ( strcmp($baseActivaCliente->codestado, $request->codestado) !== 0 )
            {


                if ( strcmp( $request->codestado, 'P') === 0  ) //si está pendiente el Estado del Cliente ea_codigo_estado_cliente
                {
                    //dd('1');
                    $cliente['fsuspt'] = $sysdate;
                    $request->merge($cliente);

                    $this->storeAsistencia($request);

                }
                else if ( strcmp( $request->codestado, 'C') === 0  ) //si es cancelado el Estado del Cliente ea_codigo_estado_cliente
                {
                     //dd('2');
                     $cliente['feccan'] = $sysdate;
                     $request->merge($cliente);

                    $id_base_activa =  $this->storeAsistencia($request);

                    //Logica de retencion
                    if ( isset($request->call_type_retencion) )
                    {
                       $resp = (new EaRetencionesController)->retencionGuardar( $id_base_activa,  $cliente['cedula_id'], $cliente['nombre'],  $cliente['cliente'], $cliente['producto'], $cliente['desc_producto'], $cliente['subproducto'], $retencion['call_type_retencion'], $retencion['origen'], $retencion['motivos_desactivacion'], $cliente['usmod']   );
                    }

                }


                if ( strcmp( $request->codestado, 'Z') === 0  ) //se ha realizado la gestion de llamar.
                {

                    $request->merge($cliente);

                    $this->storeAsistencia($request);

                }
                else if (  strcmp( $request->codestado, 'A') === 0  ) //si es activado el Estado del Cliente ea_codigo_estado_cliente
                {
                    // dd('3');
                    $cliente['estado'] = 'Z'; //cambia estado a gestionado, se realizar venta
                    $request->merge($cliente);
                    $id_base_activa = $this->storeAsistencia($request);

                    //Logica de retencion
                    if ( isset($request->call_type_retencion) )
                    {
                        $resp = (new EaRetencionesController)->retencionGuardar(  $id_base_activa, $cliente['cedula_id'], $cliente['nombre'],  $cliente['cliente'], $cliente['producto'], $cliente['desc_producto'], $cliente['subproducto'], $retencion['call_type_retencion'], $retencion['origen'], null, $cliente['usmod']   );
                    }
                }



            } else {


                if ( !str_contains($request->tarjeta, "XXXX")  &&  strcmp($baseActivaCliente->tarjeta, $request->tarjeta) !== 0 )
                {

                    //cambia numero de tarjeta entra por canje
                    $contenido = file_get_contents("../salsa.txt");
                    $clave = Key::loadFromAsciiSafeString($contenido);

                    $cliente['tipact'] = 'C';
                    $cliente['dettipact'] = EaTipoActivacion::where('tipo', 'C')->first()->detalle;
                    $cliente['numeroant'] = $baseActivaCliente->tarjeta;
                    $cliente['tarjeta'] = Crypto::encrypt(trim($request->tarjeta), $clave);

                    $request->merge($cliente);

                }


                if ( !str_contains($request->feccad, "XX")  && strcmp($baseActivaCliente->feccad, $request->feccad) !== 0)
                {
                    //entra por cambio de fecha de caducidad del plastico
                    $cliente['tipact'] = 'C';
                    $cliente['dettipact'] = EaTipoActivacion::where('tipo', 'C')->first()->detalle;

                    $request->merge($cliente);

                }


                if ( !str_contains($request->cuenta, "XXXXXXX") && strcmp($baseActivaCliente->cuenta, $request->cuenta) !== 0 ){

                    $contenido = file_get_contents("../salsa.txt");
                    $clave = Key::loadFromAsciiSafeString($contenido);
                    $cliente['tipact'] = 'C';
                    $cliente['dettipact'] = EaTipoActivacion::where('tipo', 'C')->first()->detalle;
                    $cliente['numeroant'] = $baseActivaCliente->cuenta;
                    $cliente['cuenta'] = Crypto::encrypt(trim($request->cuenta), $clave);

                    $request->merge($cliente);

                } else {

                    $request->merge($cliente);
                    $resp = $this->update($request);
                }


                $this->update($request);
            }



        return redirect()->route('EaBaseActivaController.show', [$request])->with([ 'success' => 'Detalle de la asistencia actualizado!.', 'fromDetalle' => 'detalle']);

    }



     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EaBaseActiva  $EaBaseActiva
     * @return \Illuminate\Http\Response
     */

    public function storeAsistencia (Request  $request)
    {

        $datos = $request->except('_token', '_method', 'horasys', 'call_type_retencion', 'origen', 'motivos_desactivacion');

        $id_sec = EaBaseActiva::max('id_sec');

        if ( isset($id_sec) && $id_sec !== 1 ){
            $id_sec = $id_sec + 1;
        }else {
            $id_sec = 1;
        }
        $datos['id_sec'] = $id_sec;

        EaBaseActiva::insert($datos);

        return $id_sec;
    }



    public function storeArchivo ( $data )
    {
        $id_sec = EaBaseActiva::max('id_sec');

        if ( isset($id_sec) && $id_sec !== 1 ){
            $id_sec ++;
        }else {
            $id_sec = 1;
        }

        $data['id_sec'] = $id_sec;
        $data['fecha_reg']  = Date('d/m/Y H:i:s');

        EaBaseActiva::insert($data);

    }



    /* valida registro de carga diaria, segun call type de venta*/
    public function valida_resgistro_base_activa( $cliente, $cedula_id, $producto )
    {

        if ( !empty($producto)) {

            $existe = EaBaseActiva::where('cliente', $cliente)
                                   ->where('cedula_id', $cedula_id)
                                   ->where('producto', trim($producto))
                                   ->where('estado', 'Z')
                                   ->whereNotIn('detresp', array('ACEPTA SERVICIO', 'CLIENTE FALLECIDO', 'CLIENTE NO DESEA QUE LE VUELVAN A LLAMAR'))
                                   ->exists();


        }else {

            $existe = EaBaseActiva::where('cliente', $cliente)
                                   ->where('cedula_id', $cedula_id)
                                   ->where('estado', 'Z')
                                   ->whereNotIn('detresp', array('ACEPTA SERVICIO', 'CLIENTE FALLECIDO', 'CLIENTE NO DESEA QUE LE VUELVAN A LLAMAR'))
                                   ->exists();
        }

        return $existe;

    }


    /*valida registro en estado 2: han sido generados en el archivo para proveedor TMK, y posteriormente sean actualizados como gestionado. */
    public function valida_base_activa_recep_provee( $cliente, $cod_carga_corp, $cedula_id, $producto)
    {


        if ( !empty($producto)) {

            $existe = EaBaseActiva::where('cliente', $cliente)
                                  ->where('cedula_id', trim($cedula_id))
                                  ->where('cod_carga_corp', $cod_carga_corp)
                                  ->where('producto', trim($producto))
                                  ->where('estado', 'A')
                                  ->where('estado_proceso', 2)
                                  ->exists();

        }else {

            $existe = EaBaseActiva::where('cliente', $cliente)
                                  ->where('cedula_id', trim($cedula_id))
                                  ->where('cod_carga_corp', $cod_carga_corp)
                                  ->where('estado', 'A')
                                  ->where('estado_proceso', 2)
                                  ->exists();

        }


        return $existe;
    }


    /* valida registro en estado 4: han sido generados en el archivo Generacion de archivo informacion financiera */
    public function valida_base_activa_recep_infor_finan( $cliente, $cedula_id, $cod_carga_corp, $producto )
    {

        if ($producto !== "0" ) {

            $existe = EaBaseActiva::where('cliente', $cliente)
                                  ->where('cedula_id', trim($cedula_id))
                                  ->where('cod_carga_corp', $cod_carga_corp)
                                  ->where('producto', trim($producto))
                                  ->where('tipresp', '1')
                                  ->where('codresp', '100')
                                  ->where('detresp', 'ACEPTA SERVICIO')
                                  ->where('estado', 'Z')
                                  ->where('estado_proceso', 4)
                                  ->exists();

        }else {

            $existe = EaBaseActiva::where('cliente', $cliente)
                                  ->where('cedula_id', trim($cedula_id))
                                  ->where('cod_carga_corp', $cod_carga_corp)
                                  ->where('tipresp', '1')
                                  ->where('codresp', '100')
                                  ->where('detresp', 'ACEPTA SERVICIO')
                                  ->where('estado', 'Z')
                                  ->where('estado_proceso', 4)
                                  ->exists();
        }

        return $existe;
    }



    public function reversoArchivo( $baseActiva )
    {

        $trx = EaBaseActiva::where('cliente', $baseActiva['cliente'])
                           ->where('file_base_colocacion', $baseActiva['file_base_colocacion'])
                           ->delete();
        return $trx;
    }


    /**
     * Actualiza el estado de proceso a: 2=Generacion de archivo proveedor TMK
     * De registros de carga diaria, en base al archivo de carga inicial
    */
    public function update_ba_estado_proceso_ciclo_2 ( $cliente, $cod_carga_corp, $estado_proceso, $estado_proceso_update, $nombre_archivo_generado)
    {

        $trx = EaBaseActiva::where('cliente', $cliente )
                            ->where('cod_carga_corp', $cod_carga_corp)
                            ->where('estado_proceso', $estado_proceso)
                            ->where('estado', 'A')
                            ->update([ 'estado_proceso' => $estado_proceso_update,
                                       'fileout_telemarketing' => $nombre_archivo_generado ]);

        return $trx;
    }


    /**
     * Actualiza el estado de proceso a: 4=generacion de archivo cliente corporativo información financiera
     * De registros de carga diaria, en base al archivo de filein_telemarketing enviado por el proveedor de TMK.
    */
    public function update_ba_estado_proceso_ciclo_4 ( $cliente, $cod_carga_corp, $estado_proceso, $estado_proceso_act, $nombre_archivo_generado)
    {


        $trx = EaBaseActiva::where('cliente', $cliente )
                           ->where('cod_carga_corp', $cod_carga_corp)
                           ->where('estado_proceso', $estado_proceso) //3
                           ->where('estado', 'Z')
                           ->where('tipresp', '1')
                           ->where('codresp', '100')
                           ->where('detresp', 'ACEPTA SERVICIO')
                           ->update([ 'estado_proceso' => $estado_proceso_act, //4
                                      'fileout_banco_info' => $nombre_archivo_generado ]);

        return $trx;

    }



    public function exists_base_activa_carga_inicial( $cliente, $cod_carga_corp, $estado_proceso)
    {

        $existe = EaBaseActiva::where('cliente',  $cliente )
                              ->where('cod_carga_corp', $cod_carga_corp)
                              ->where('estado_proceso', $estado_proceso) //1
                              ->where('estado', 'A')
                              ->exists();

        return $existe;

    }


    /**
     * Valida registros que esten en cicilo 3:RECEPCION DE ARCHIVO PROVEEDOR TMK
     * y que sean ventas efectivas..
     */
    public function exists_ba_proceso_ciclo_3( $cliente, $cod_carga_corp, $estado_proceso)
    {

        $existe = EaBaseActiva::where('cliente', $cliente )
                               ->where('estado_proceso', $estado_proceso)
                               ->where('cod_carga_corp', $cod_carga_corp )
                               ->where('estado', 'Z')
                               ->where('tipresp', '1')
                               ->where('codresp', '100')
                               ->where('detresp', 'ACEPTA SERVICIO')
                               ->exists();

        return $existe;

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EaBaseActiva  $eaBaseActiva
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_ba_producto_subproducto($cliente, $cod_carga_corp, $producto, $desc_producto, $subproducto){

        $trx = EaBaseActiva::where('cliente', $cliente )
                           ->where('cod_carga_corp', $cod_carga_corp)
                           ->update(['producto' =>$producto,
                                     'desc_producto' => $desc_producto,
                                     'subproducto' => $subproducto ]);

        return $trx;

    }


}
