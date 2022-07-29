<?php

namespace App\Http\Controllers;

use App\Models\EaCabeceraCargaCorpBitacora;
use Illuminate\Http\Request;
use App\Http\Controllers\EaCabCargaInicialController;

class EaCabCargaInicialBitacoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_bitacora($cod_carga)
    {

        $datos_carga = (new EaCabCargaInicialController)->get_detalle_carga_corp($cod_carga);

        $trx = EaCabeceraCargaCorpBitacora::create([

            "cod_carga" => $datos_carga->cod_carga,
            "proceso" => $datos_carga->proceso,
            "cliente" => $datos_carga->cliente,
            "producto" => $datos_carga->producto,
            "desc_producto" => $datos_carga->desc_producto,
            "fec_carga" => $datos_carga->fec_carga,
            "archivo" => $datos_carga->archivo,
            "total_registros_archivo" => $datos_carga->total_registros_archivo,
            "total_registros_duplicados" =>  $datos_carga->total_registros_duplicados,
            "total_registros_sin_infor" => $datos_carga->total_registros_sin_infor,
            "total_registros_disponibles_gestion" => $datos_carga->total_registros_disponibles_gestion,
            "total_registros_gestionados_otras_campanas" => $datos_carga->total_registros_gestionados_otras_campanas,
            "total_registros_aceptan" => $datos_carga->total_registros_aceptan,
            "total_otros_call_types" => $datos_carga->total_otros_call_types,
            "usuario_registra" => $datos_carga->usuario_registra,
            "fec_registro" => $datos_carga->fec_registro,
            "estado" => $datos_carga->estado,
            "visible" => $datos_carga->visible,
        ]);

        return $trx;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateBitacora($cod_carga)
    {

        $datos_carga = (new EaCabCargaInicialController)->get_detalle_carga_corp($cod_carga);

        /*
        Flight::where('active', 1)
      ->where('destination', 'San Diego')
      ->update(['delayed' => 1]);

      */

        $trx2 = EaCabeceraCargaCorpBitacora::where('cliente', 'INTER')
            ->where('cod_carga', '2')
            ->where('producto', '14')
            ->update(['archivo' => $datos_carga->archivo]);
        $trx = EaCabeceraCargaCorpBitacora::create([

            "cod_carga" => $datos_carga->cod_carga,
            "proceso" => $datos_carga->proceso,
            "cliente" => $datos_carga->cliente,
            "producto" => $datos_carga->producto,
            "desc_producto" => $datos_carga->desc_producto,
            "fec_carga" => $datos_carga->fec_carga,
            "archivo" => $datos_carga->archivo,
            "total_registros_archivo" => $datos_carga->total_registros_archivo,
            "total_registros_duplicados" =>  $datos_carga->total_registros_duplicados,
            "total_registros_sin_infor" => $datos_carga->total_registros_sin_infor,
            "total_registros_disponibles_gestion" => $datos_carga->total_registros_disponibles_gestion,
            "total_registros_gestionados_otras_campanas" => $datos_carga->total_registros_gestionados_otras_campanas,
            "total_registros_aceptan" => $datos_carga->total_registros_aceptan,
            "total_otros_call_types" => $datos_carga->total_otros_call_types,
            "usuario_registra" => $datos_carga->usuario_registra,
            "fec_registro" => $datos_carga->fec_registro,
            "estado" => $datos_carga->estado,
            "visible" => $datos_carga->visible,
        ]);

        return $trx;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_max_cod_carga_bita()
    {
        $cod_carga = EaCabeceraCargaCorpBitacora::whereNotNull('visible')->max('cod_carga');
        //$cod_carga = EaCabeceraCargaCorpBitacora::max('cod_carga');

        if (isset($cod_carga) && $cod_carga >= 1) {
            $cod_carga++;
        } else {
            $cod_carga = 1;
        }

        return  $cod_carga;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_min_cod_carga_bita()
    {

        $cod_carga = EaCabeceraCargaCorpBitacora::min('cod_carga');

        return  $cod_carga;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_datos_cod_carga_bita($cod_carga, $cliente, $proceso, array $datos)
    {

        $trx = EaCabeceraCargaCorpBitacora::where('cod_carga', $cod_carga)
            ->where('cliente', $cliente)
            ->where('proceso', $proceso)
            ->update($datos);

        return  $trx;
    }
}
