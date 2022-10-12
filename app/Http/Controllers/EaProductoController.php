<?php

namespace App\Http\Controllers;

use App\Models\EaProducto;
use Illuminate\Http\Request;
use App\Http\Controllers\EaClienteController;
use App\Http\Controllers\EaSubproductoController;
use App\Http\Controllers\EaUtilController;

class EaProductoController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProducto(Request  $request)
    {
        $htmlOption = '<option value="" selected>Selecciona Producto</option>';

        $productos = EaProducto::where('cliente', $request->cliente)->get();

        foreach ($productos as $producto) {
            $htmlOption .= '<option value="'.$producto->contrato_ama.'">'.$producto->desc_producto.'</option>';
        }

        return response()->json( ['htmlProducto' => $htmlOption] );

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function updateMaestroCliente( Request $request ){

        $existe = EaProducto::where('cliente', $request->clienteEditOld)
                            ->exists();

        if ($existe) {
          EaProducto::where('cliente', $request->clienteEditOld)
                    ->update( ['cliente' => $request->clienteEdit] );
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProductoModel(Request $request){

        $producto = EaProducto::where('cliente', $request->cliente)
                              ->where('contrato_ama', $request->contrato_ama)
                              ->get();

        return response()->json( ['productoModel' => $producto] );
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProductosAll(Request $request){

        $producto = EaProducto::where('cliente', $request->cliente)->get();

        return  $producto;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProductoDetalle( $id_cliente, $contrato_ama){

        $producto = EaProducto::where('cliente', $id_cliente)
                              ->where('contrato_ama', $contrato_ama)
                              ->first();

        return  $producto;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Allcampanas = (new EaClienteController)->getAllCampanas();
        return view ('configProdu.home')->with(compact('Allcampanas'));
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
        $datosProducto = $request->except('_token', '_method');

        $datosProducto['cliente'] = $request->clienteAdd;
        $datosProducto['subproducto'] = $util->quitar_tildes($request->subproducto);
        $datosProducto['desc_producto'] = $util->quitar_tildes($request->desc_producto);

        unset($datosProducto['clienteAdd']);

        $idProducto = EaProducto::all()->max('id_producto');

        if ( isset($idProducto) &&  $idProducto > 1 ){
            $idProducto++;
            $datosProducto['id_producto'] = $idProducto;
        }else {
            $datosProducto['id_producto'] = 1;
        }

        EaProducto::Insert($datosProducto);

        return redirect()->route('EaProductoController.index')->with([ 'cliente' => $request->clienteAdd, 'desc_producto' => $request->desc_producto, 'trxprod' => 'store' ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EaProducto  $eaProducto
     * @return \Illuminate\Http\Response
     */
    public function show(EaProducto $eaProducto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EaProducto  $eaProducto
     * @return \Illuminate\Http\Response
     */
    public function edit(EaProducto $eaProducto)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EaProducto  $eaProducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $util = (new EaUtilController);
        $datosProducto = $request->except('_token', '_method', 'id_producto', 'contrato_amaOLD', 'desc_productoOLD' );

        $datosProducto['subproducto'] = $util->quitar_tildes($request->subproducto);
        $datosProducto['desc_producto'] = $util->quitar_tildes($request->desc_producto);

        $trx = EaProducto::where('id_producto', $request->id_producto)
                         ->update($datosProducto);

        //contrato_amaOLD, actualiza a todos los subproductos
        if (strcmp($trx, 1)===0 ) {
                (new EaSubproductoController)->UpdateMaestroProducto($request);
        }

        return redirect()->route('EaProductoController.index')->with([ 'cliente' => $request->cliente,
                                                                       'nom_productoOLD' => $request->contrato_amaOLD,
                                                                       'nom_producto' => $request->contrato_ama,
                                                                       'desc_productoOLD' => $request->desc_productoOLD,
                                                                       'desc_producto' => $request->desc_producto,
                                                                       'trxprod' => 'update' ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EaProducto  $eaProducto
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

       $trx =  EaProducto::where('id_producto', $request->id_productoForm)->delete();

       if (strcmp ($trx,1)===0 ) {
             (new EaSubproductoController)->destroyMaestro($request);
        }

        return redirect()->route('EaProductoController.index')->with([ 'cliente' => $request->clienteForm, 'desc_producto' => $request->desc_productoForm, 'trxprod' => 'delete' ]);;

    }
}
