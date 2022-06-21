<?php

namespace App\Http\Controllers;

use App\Models\EaRetenciones;
use App\Models\EaMotivosDesactivacion;
use App\Models\EaCallTypeRetencion;
use Illuminate\Http\Request;


class EaRetencionesController extends Controller
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
    public function store( $id_base_activa, $cedula_id, $nombre, $cliente, $producto, $desc_producto, $subproducto, $call_type_retencion, $origen, $motivos_desactivacion, $usuario_reg)
    {

        $datosRetencion['id_sec'] = $id_base_activa;
        $datosRetencion['cliente'] = $cliente;
        $datosRetencion['cedula_id'] = $cedula_id;
        $datosRetencion['nombre'] = $nombre;
        $datosRetencion['producto'] = $producto;
        $datosRetencion['desc_producto'] = $desc_producto;
        $datosRetencion['subproducto'] = $subproducto;
        $datosRetencion['cod_retencion'] = $call_type_retencion;
        $datosRetencion['det_retencion'] = EaCallTypeRetencion::where('cod', $call_type_retencion)->first()->detalle;
        $datosRetencion['origen'] = $origen;
        $datosRetencion['usuario_reg'] = $usuario_reg;
        $datosRetencion['fecha_reg'] = Date('d/m/Y H:i:s');

        if (!is_null($motivos_desactivacion)) {
            $datosRetencion['cod_motivo_desactivacion'] = $motivos_desactivacion;
            $datosRetencion['motivo_desactivacion'] = EaMotivosDesactivacion::where('cod', $motivos_desactivacion)->first()->detalle;
        }

        $id = EaRetenciones::max('id');

        if ( isset($id) &&  $id>=1 ) {
            $id++;
            $datosRetencion['id'] = $id;
        }else {
            $datosRetencion['id'] = 1;

        }

        $r =  EaRetenciones::insert($datosRetencion);

       return $r;


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EaRetenciones  $eaRetenciones
     * @return \Illuminate\Http\Response
     */
    public function retencionGuardar($id_base_activa, $cedula_id, $nombre, $cliente, $producto, $desc_producto, $subproducto, $call_type_retencion, $origen, $motivos_desactivacion, $usuario_reg)
    {
        $existe = EaRetenciones::where('cliente', $cliente)
                               ->where('cedula_id', $cedula_id)
                               ->where('producto', $producto)
                               ->where('subproducto', $subproducto)
                               ->exists();

        //dd($existe, $cliente, $cedula_id, $producto,  $subproducto);
        if ($existe) {
            $this-> edit($id_base_activa, $cedula_id, $nombre, $cliente, $producto, $desc_producto, $subproducto, $call_type_retencion, $origen, $motivos_desactivacion, $usuario_reg);
        }else {
            $this-> store($id_base_activa, $cedula_id, $nombre, $cliente, $producto, $desc_producto, $subproducto, $call_type_retencion, $origen, $motivos_desactivacion, $usuario_reg);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EaRetenciones  $eaRetenciones
     * @return \Illuminate\Http\Response
     */
    public function edit( $id_base_activa, $cedula_id, $nombre, $cliente, $producto, $desc_producto, $subproducto, $call_type_retencion, $origen, $motivos_desactivacion, $usuario_reg)
    {

        $registro = EaRetenciones::where('cliente', $cliente)
                                  ->where('cedula_id', $cedula_id)
                                  ->where('producto', $producto)
                                  ->where('subproducto', $subproducto)
                                  ->first();


        $datosRetencion['id_sec'] = $id_base_activa;
        $datosRetencion['cliente'] = $cliente;
        $datosRetencion['cedula_id'] = $cedula_id;
        $datosRetencion['nombre'] = $nombre;
        $datosRetencion['producto'] = $producto;
        $datosRetencion['desc_producto'] = $desc_producto;
        $datosRetencion['subproducto'] = $subproducto;
        $datosRetencion['cod_retencion'] = $call_type_retencion;
        $datosRetencion['det_retencion'] = EaCallTypeRetencion::where('cod', $call_type_retencion)->first()->detalle;
        $datosRetencion['origen'] = $origen;
        $datosRetencion['usuario_reg'] = $usuario_reg;
        $datosRetencion['fecha_reg'] = Date('d/m/Y H:i:s');

        if ($call_type_retencion == 2) {
            $datosRetencion['cod_motivo_desactivacion'] = $motivos_desactivacion;
            $datosRetencion['motivo_desactivacion'] = EaMotivosDesactivacion::where('cod', $motivos_desactivacion)->first()->detalle;
        }else {
            $datosRetencion['motivo_desactivacion'] = null;
            $datosRetencion['cod_motivo_desactivacion'] = null;
        }

        //dd($datosRetencion);
        $r =  EaRetenciones::where('id', $registro->id)
                           ->update($datosRetencion);

       return $r;

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EaRetenciones  $eaRetenciones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EaRetenciones $eaRetenciones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EaRetenciones  $eaRetenciones
     * @return \Illuminate\Http\Response
     */
    public function destroy(EaRetenciones $eaRetenciones)
    {
        //
    }
}
