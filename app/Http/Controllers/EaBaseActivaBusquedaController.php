<?php

namespace App\Http\Controllers;

use App\Models\EaBaseActiva;
use App\Models\EaCliente;
use Illuminate\Http\Request;
use App\Http\Controllers\EaClienteController;
use App\Http\Controllers\EaSubproductoController;
use Illuminate\Support\Facades\DB;


class EaBaseActivaBusquedaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( )
    {

        $campanasAll = ( new EaClienteController )->getAllCampanas();

        return view ('busqueda.home')->with(compact('campanasAll'));
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
    public function search(Request $request){

        if ( is_null($request->cliente) && is_null($request->productoCMB) && is_null($request->subproductoCMB) ){

            $msj = "Debe seleccionar al menos un filtro";
            $error = "sinFiltro";


        } else if ( strcmp($request->filtro2, 'cliente')===0  &&  strcmp($request->filtro3, 'producto')===0 && strcmp($request->filtro4, 'subproducto')===0 ){

            $subproducto = (new EaSubproductoController)->getSubproductoDetalle($request->cliente, $request->subproductoCMB);

            $dataBusqueda = $this->getClientesHistCampaProdSub($request, $subproducto->desc_subproducto);

            if (is_null($dataBusqueda)) {
                $error = "notData";
                $msj = "No existe informacion para el filtro: subproducto ";
            }else {
                $msj = "Cliente: ".$request->cliente." Producto: ".$request->productoCMB." Subproducto: ".$subproducto->desc_subproducto;;
            }


        } else if ( strcmp($request->filtro2, 'cliente')===0 &&  strcmp($request->filtro3, 'producto')===0 ){

                $dataBusqueda = $this->getClientesHistCampaProduc($request);

                if (is_null($dataBusqueda)) {
                    $error = "notData";
                    $msj = "No existe informacion para el filtro: producto ";
                }else {
                    $msj = "Cliente: ".$request->cliente." Producto: ".$request->productoCMB;
                }


        } else if( strcmp($request->filtro2,'cliente')===0 ){


                $dataBusqueda = $this->getClienteHistcampana($request);

                if ( is_null($dataBusqueda)) {
                    $error = "notData";
                    $msj = "No existe informacion para el filtro de búsqueda: Cliente ".$request->cliente;
                }else {
                    $msj = "Cliente: ".$request->cliente;
                }

        }


        if (  strcmp($request->filtro1, 'cedula_id')===0  && is_null($request->cedula_id) ) {

            $msj= "Ingrese una identificación";
            $error = "sinFiltro";

        }else if ( strcmp($request->filtro1, 'cedula_id')===0 ) {

            $msj = 'Identificación: '.$request->cedula_id;
            $dataBusqueda =  $this->getClienteHistced($request);

            if (is_null($dataBusqueda)) {
                $error = "notData";
                $msj = 'No existe informacion para la identificación: '.$request->cedula_id;
            }

        }


       return redirect()->route('EaBaseActivaBusquedaController.index')->with( ['filtro' => isset($msj) ? $msj : '',
                                                                                'data' => isset ($dataBusqueda) ? $dataBusqueda : '',
                                                                                'error' => isset($error) ? $error : ''  ] );

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
     * Display the specified resource.
     *
     * @param  \App\Models\EaBaseActiva  $eaBaseActiva
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function show(Request  $request)
    {

        $hora  = Date('H:i:s');
        $fecha = Date('d/m/Y');

        $campana = (new EaClienteController)->getConfigCampana($request);

        $cliente['cliente'] = EaBaseActiva::Where('cedula_id', $request->cedula_id)
                                          ->Where('cliente', $request->cliente)
                                          ->Where('estado_reg', 'A')
                                          ->first();

        $data['dataCliente']= $this->getClienteHist($request);

        return view ('campanas.home')->with($cliente)
                                     ->with($data)
                                     ->with(compact('campana'))
                                     ->with(compact('hora'))
                                     ->with(compact('fecha'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EaBaseActiva  $eaBaseActiva
     * @return \Illuminate\Http\Response
     */
    public function edit(EaBaseActiva $eaBaseActiva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EaBaseActiva  $eaBaseActiva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EaBaseActiva $eaBaseActiva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EaBaseActiva  $eaBaseActiva
     * @return \Illuminate\Http\Response
     */
    public function destroy(EaBaseActiva $eaBaseActiva)
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getClienteHist(Request  $request){

        $data = EaBaseActiva::Where('cedula_id', $request->cedula_id)
                            ->Where('cliente', $request->cliente)
                            ->orderByDesc('fecha')
                            ->orderByDesc('hora')->get();
        return $data;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getClienteHistced (Request $request){

        $data = EaBaseActiva::Addselect(['desc_clienteBA' => EaCliente::select('desc_cliente')
                                                                      ->whereColumn('cliente', 'ea_base_activa.cliente')])
                            ->where($request->filtro1, $request->cedula_id)
                            ->orderByDesc('fecha','hora')
                            ->paginate(25)
                            ->withQueryString();

       return $data;

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getClienteHistcampana(Request  $request){


        $data = EaBaseActiva::Addselect(['desc_clienteBA' => EaCliente::select('desc_cliente')
                                                                      ->whereColumn('cliente', 'ea_base_activa.cliente')])
                            ->where('ea_base_activa.'.$request->filtro2, $request->cliente)
                            ->orderByDesc('id_sec')
                            ->paginate(25)
                            ->withQueryString();
        return $data;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getClientesHistCampaProduc(Request $request){

        $data = EaBaseActiva::Addselect(['desc_clienteBA' => EaCliente::select('desc_cliente')
                                                                      ->whereColumn('cliente', 'ea_base_activa.cliente')])

                            ->where('Ea_base_activa.'.$request->filtro2, $request->cliente)
                            ->where($request->filtro3, $request->productoCMB)
                            ->orderbyDesc('fecha', 'hora')
                            ->paginate(25);

        return $data;

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getClientesHistCampaProdSub (Request $request, $desc_subproducto){


        $data = EaBaseActiva::Addselect(['desc_clienteBA' => EaCliente::select('desc_cliente')
                                                                        ->whereColumn('cliente', 'ea_base_activa.cliente')])

                            ->where($request->filtro2, $request->cliente)
                            ->where($request->filtro3, $request->productoCMB)
                            ->where($request->filtro4, $desc_subproducto)
                            ->orderbyDesc('fecha', 'hora')
                            ->paginate(25);

        return $data;

    }


}
