<?php

namespace App\Http\Controllers;

use App\Models\EaImpuestos;
use Illuminate\Http\Request;

class EaImpuestosController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getImpuestoModel(Request $request)
    {
        $impuesto = EaImpuestos::where('cliente', $request->cliente)
                               ->where('nom_impuesto', $request->nom_impuesto)
                               ->get();

        return response()->json ( ['impuestoModel' => $impuesto]);
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

       $datosImpuesto = $request->except("_token", "_method");
       $datosImpuesto ['cliente'] = $request->clienteAdd;

       unset($datosImpuesto['clienteAdd']);

       $id_impuesto = EaImpuestos::all()->max('id_impuesto');

       if (isset($id_impuesto) && $id_impuesto !== 1) {
           $id_impuesto++;
           $datosImpuesto['id_impuesto']=$id_impuesto;
       }else {
           $datosImpuesto['id_impuesto']=1;
       }

       EaImpuestos::insert($datosImpuesto);

       return redirect()->route('EaClienteController.index')->with([ 'impuesto' => $request->desc_impuesto,
                                                                     'cliente' => $request->clienteAdd,
                                                                     'trximpuesto' => 'store' ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EaImpuestos  $eaImpuestos
     * @return \Illuminate\Http\Response
     */
    public function show(EaImpuestos $eaImpuestos)
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getImpuestoHtml(Request $request)
    {
        $html='<option value="" selected>Selecccione un impuesto</option>';

        $impuestomodel = EaImpuestos::where('cliente', $request->cliente)
                                    ->get();


        foreach ($impuestomodel as $impuesto) {
            $html .='<option value="'.$impuesto->nom_impuesto.'">'.$impuesto->desc_impuesto.'</option>';
        }

        return response()->json ( ['impuestoHtml' => $html] );
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EaImpuestos  $eaImpuestos
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request  $request)
    {
        $datosImpuesto = $request->except("_token", "_method", "id_impuestoEdit", "nom_impuestoEditOld", "desc_impuestoEditOld", "valor_porcentajeEditOld");

        $datosImpuesto['cliente'] = $request->clienteEditImp;
        $datosImpuesto['nom_impuesto'] = $request->nom_impuestoEdit;
        $datosImpuesto['desc_impuesto'] = $request->desc_impuestoEdit;
        $datosImpuesto['valor_porcentaje'] = $request->valor_porcentajeEdit;

        unset($datosImpuesto['clienteEditImp'], $datosImpuesto['nom_impuestoEdit'], $datosImpuesto['desc_impuestoEdit'], $datosImpuesto['valor_porcentajeEdit']);

        EaImpuestos::where('id_impuesto', $request->id_impuestoEdit)
                   ->update($datosImpuesto);

        return redirect()->route('EaClienteController.index')->with([ 'cliente' => $request->clienteEditImp,
                                                                      'impuesto' => $request->nom_impuestoEdit,
                                                                      'impuestoOld' => $request->nom_impuestoEditOld,
                                                                      'desc_impuesto' => $request->desc_impuestoEdit,
                                                                      'desc_impuestoOld' => $request->desc_impuestoEditOld,
                                                                      'valor' => $request->valor_porcentajeEdit,
                                                                      'valorOld' => $request->valor_porcentajeEditOld,
                                                                      'trximpuesto' => 'update' ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EaImpuestos  $eaImpuestos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EaImpuestos $eaImpuestos)
    {
        //
    }


    /**
    * @return \Illuminate\Http\Response
    * @param  \Illuminate\Http\Request  $request
    */
    public function updateMaestroCliente(Request  $request){

        $existe = EaImpuestos::where('cliente', $request->clienteEditOld)
                             ->exists();
        if ( $existe ){
            EaImpuestos::where('cliente', $request->clienteEditOld)
                       ->update( ['cliente' => $request->clienteEdit] );
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EaImpuestos  $eaImpuestos
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function destroy(Request  $request)
    {

        EaImpuestos::where('id_impuesto', $request->id_impuesto)
                   ->delete();

        return redirect()->route('EaClienteController.index')->with( ['impuesto' => $request->desc_impuestoForm,
                                                                      'cliente' => $request->clienteImpForm,
                                                                      'trximpuesto' => 'delete'] );
    }
}
