<?php

namespace App\Http\Controllers;

use App\Models\EaSubproducto;
use Illuminate\Http\Request;
use App\Http\Controllers\EaUtilController;

class EaSubproductoController extends Controller
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
    public function store(Request $request)
    {
        $util = (new EaUtilController);
        $datoSubprod = $request->except('_token', '_method', "desc_productoAddSub");

        $datoSubprod['cliente'] = $request->clienteAddSub;
        $datoSubprod['subproducto'] = $util->quitar_tildes($request->subproducto);
        $datoSubprod['contrato_ama'] = $request->contrato_amaAddSub;

        unset($datoSubprod['clienteAddSub'], $datoSubprod['contrato_amaAddSub']);

        $idSubproducto = EaSubproducto::all()->max('id_subproducto');

        if (isset($idSubproducto) &&  $idSubproducto !== 1) {
            $idSubproducto++;
            $datoSubprod['id_subproducto'] = $idSubproducto;
        } else {
            $datoSubprod['id_subproducto'] = 1;
        }

        if (is_null($request->desc_subproducto)) {
            $datoSubproducto['desc_subproducto'] = $util->quitar_tildes($request->subproducto);
        }

        EaSubproducto::insert($datoSubprod);

        return redirect()->route('EaProductoController.index')->with([
            'clienteAddSub' => $request->clienteAddSub,
            'desc_subproducto' => $request->subproducto,
            'productoAddSub' => $request->desc_productoAddSub,
            'trxsubprod' => 'store'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSubproducto(Request  $request)
    {

        $html = '<option value="" selected>Selecciona Sub-Producto</option>';
        $subproductos = EaSubproducto::where('cliente', $request->cliente)
            ->where('contrato_ama', $request->contrato_ama)
            ->get();

        foreach ($subproductos as $subproducto) {

            $html .= '<option value="' . $subproducto->id_subproducto . '">' . $subproducto->desc_subproducto . '</option>';
        }

        return response()->json(['htmlSubproducto' => $html]);
    }

    public function getSubproductoNoAMA(Request  $request)
    {
        $html = '<option value="" selected>Selecciona Producto</option>';
        $subproductos = EaSubproducto::where('cliente', $request->cliente)
            ->get();
        foreach ($subproductos as $subproducto) {
            $html .= '<option value="' . $subproducto->id_subproducto  . '">' . (substr($subproducto->desc_subproducto, -strlen($subproducto->tipo_subproducto)) == $subproducto->tipo_subproducto ? $subproducto->desc_subproducto : ($subproducto->desc_subproducto) . " " . ($subproducto->tipo_subproducto)) . '</option>';
        }
        return response()->json(['htmlProducto' => $html]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSubproductoCli(Request  $request)
    {

        $html = '<option value="" selected>Selecciona Sub-Producto</option>';
        $subproductos = EaSubproducto::where('cliente', $request->cliente)
            ->where('contrato_ama', $request->contrato_ama)
            ->get();

        foreach ($subproductos as $subproducto) {

            $html .= '<option value="' . $subproducto->desc_subproducto . '">' . $subproducto->desc_subproducto . '</option>';
        }

        return response()->json(['htmlSubproducto' => $html]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSubproductoDetalle($id_cliente, $id_subproducto)
    {

        $subProducto = EaSubproducto::where('cliente', $id_cliente)
            ->where('id_subproducto', $id_subproducto)
            ->first();

        return  $subProducto;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSubproductoModel(Request  $request)
    {

        $subproducto = EaSubproducto::where('cliente', $request->cliente)
            ->where('contrato_ama', $request->contrato_ama)
            ->where('id_subproducto', $request->id_subproducto)
            ->get();

        return response()->json(['subProductoModel' => $subproducto]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSubproductoSap(Request  $request)
    {

        $html = '<option value="" selected>Selecciona Sub-Producto</option>';
        $subproductos = EaSubproducto::where('cliente', $request->cliente)
            //->where('contrato_ama', $request->contrato_ama)
            ->get();

        foreach ($subproductos as $subproducto) {

            if (isset($subproducto->nombre_contrato_ama)) {
                # code...
                $html .= '<option value="' . $subproducto->id_subproducto . '">' . $subproducto->nombre_contrato_ama . '</option>';
            }
        }

        return response()->json(['htmlSubproducto' => $html]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EaSubproducto  $eaSubproducto
     * @return \Illuminate\Http\Response
     */
    public function edit(EaSubproducto $eaSubproducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EaSubproducto  $eaSubproducto
     * @return \Illuminate\Http\Response
     */
    public function UpdateMaestroProducto(Request $request)
    {

        $trx = EaSubproducto::where('cliente', $request->cliente)
            ->where('contrato_ama', $request->contrato_amaOLD)
            ->exists();

        if ($trx) {
            EaSubproducto::where('cliente', $request->cliente)
                ->where('contrato_ama', $request->contrato_amaOLD)
                ->update(['contrato_ama' => $request->contrato_ama]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EaSubproducto  $eaSubproducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $util = (new EaUtilController);
        $datoSubproducto = $request->except("_token", "_method", "cod_establecimientoEdit", "cod_establecimientoEditOLD", "contrato_amaEdit", "desc_productoEditSub", "id_subproducto", "subproductoOLD", "desc_subproductoOLD", "valorOld", "deduccion_impuestoEditSubOld", "subtotalEditSubOld", "nom_impuestoEditOld", "deduccion_impuestoEditOld", "subtotalEditOld");

        $datoSubproducto['contrato_ama'] = $request->contrato_amaEdit;
        $datoSubproducto['cod_establecimiento'] = $request->cod_establecimientoEdit;
        $datoSubproducto['cliente'] =  $request->clienteSub;
        $datoSubproducto['graba_impuesto'] = $request->graba_impuestoEdit;
        $datoSubproducto['nom_impuesto'] = $request->nom_impuestoEdit;
        $datoSubproducto['valor_porcentaje'] = $request->valor_porcentajeEdit;
        $datoSubproducto['deduccion_impuesto'] = $request->deduccion_impuestoEditSub;
        $datoSubproducto['subtotal'] = $request->subtotalEditSub;
        $datoSubproducto['valortotal'] = $request->valortotalEditSub;
        $datoSubproducto['subproducto'] = $util->quitar_tildes($request->subproducto);

        unset($datoSubproducto['clienteSub'], $datoSubproducto['graba_impuestoEdit'], $datoSubproducto['graba_impuestoEditOld'], $datoSubproducto['nom_impuestoEdit'], $datoSubproducto['nom_impuestoEditOld'], $datoSubproducto['valor_porcentajeEdit'], $datoSubproducto['deduccion_impuestoEditSub'], $datoSubproducto['subtotalEditSub'],  $datoSubproducto['valortotalEditSub']);

        if (is_null($request->desc_subproducto)) {
            $datoSubproducto['desc_subproducto'] = $util->quitar_tildes($request->subproducto);
        } else {
            $datoSubproducto['desc_subproducto'] = $util->quitar_tildes($request->desc_subproducto);
        }

        EaSubproducto::where('id_subproducto', $request->id_subproducto)
            ->update($datoSubproducto);

        return redirect()->route('EaProductoController.index')->with([
            'cliente' => $request->clienteSub,
            'valor' => $request->valortotalEditSub,
            'valorOLD' => $request->valorOld,
            'producto' => $request->desc_productoEditSub,
            'nom_subproducto' => $request->subproducto,
            'nom_subproductoOLD' => $request->subproductoOLD,
            'desc_subproducto' => $request->desc_subproducto,
            'deduccion_impuestoOld' => $request->deduccion_impuestoEditSubOld,
            'deduccion_impuesto' => $request->deduccion_impuestoEditSub,
            'subtotalEditSubOld' => $request->subtotalEditSub,
            'subtotal' => $request->subtotalEditSub,
            'trxsubprod' => 'update'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EaSubproducto $eaSubproducto
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {

        EaSubproducto::where('id_subproducto', $request->id_subprodFormSub)->delete();

        return redirect()->route('EaProductoController.index')->with([
            'cliente' => $request->clienteFormSub,
            'desc_subproductoForm' => $request->desc_subproductoForm,
            'productoForm' => $request->desc_productoSubForm,
            'trxsubprod' => 'delete'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function updateMaestroCliente(Request $request)
    {

        $existe = EaSubproducto::where('cliente', $request->clienteEditOld)
            ->exists();

        if ($existe) {
            EaSubproducto::where('cliente', $request->clienteEditOld)
                ->update(['cliente' => $request->clienteEdit]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EaSubproducto $eaSubproducto
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyMaestro(Request $request)
    {

        //llamado desde el destroy de producto
        $existe = EaSubproducto::where('cliente', $request->clienteForm)
            ->where('contrato_ama', $request->contrato_amaForm)
            ->exists();

        if ($existe) {
            EaSubproducto::where('cliente', $request->clienteForm)
                ->where('contrato_ama', $request->contrato_amaForm)
                ->delete();
        }
    }
}
