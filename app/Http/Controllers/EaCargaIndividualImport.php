<?php

namespace App\Http\Controllers;

use App\Models\EaCabeceraCargaCorp;
use App\Models\EaCabeceraCargaCorpBitacora;
use App\Models\EaDetalleCargaCorp;
use App\Models\EaProducto;
use App\Models\EaSubproducto;
use Illuminate\Http\Request;
use App\Http\Controllers\EaClienteController;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EaDetCargaCorpImport;
use App\Http\Controllers\EaBaseActivaController;
use App\Http\Controllers\EaProductoController;
use App\Http\Controllers\EaCabCargaInicialBitacoraController;
use App\Http\Controllers\EaDetalleCargaCorpController;
use App\Exports\EaReporteCargaInicialExport;
use App\Models\EaCliente;

class EaCargaIndividualImport extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes =  (new EaClienteController)->getAllCampanas();

        $resumen_cabecera = EaCabeceraCargaCorpBitacora::orderBydesc('cod_carga')->where('is_det_debito', '1')
            ->paginate(15);

        // dd($resumen_cabecera);
        return view('cargaIndividualI.home')->with(compact('clientes'))
            ->with(isset($resumen_cabecera) ? compact('resumen_cabecera') : '');
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
        //
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadArchivos(Request  $request)
    {
        // fec_carga ---> utilizado para insertar la ultima fecha en la que se realizo la carga
        $datosCab = $request->except('_token', 'filtro_cliente', 'filtro_producto', 'filtro_proce_carga');
        $fecha = Date('Y-m-d');
        $productoDetalle = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
        $extension = $request->file('archivo')->extension();
        //modificacion     para adjuntar txt
        if (strtolower($extension) == 'xls' || strtolower($extension) == 'xlsx') {
            $datosCab['fec_carga'] = Date('Y-m-d H:i:s');
            if (isset($productoDetalle)) {
                //condiciones para realizar de maneria iterativa lo que es la fecha en el pago (si la saca del campo desc_producto o del campo fecha de registro)
                $datosCab['desc_producto'] = $request->desc_producto;
            } else {
                $datosCab['producto'] = '';
                $datosCab['desc_producto'] = '';
            }
            if ($request->hasfile('archivo')) {
                $nombre_archivo = $request->file('archivo')->getClientOriginalName();
                //$nombre_archivo = "BASE_COLOCACION_".$request->cliente.'_'.$fecha.'.xlsx';
                $datosCab['archivo'] = $request->file('archivo')->storeAs('lecturaDebito/'." $request->cliente".'/' . $request->cliente, $nombre_archivo, 'public');
            }
            
            $trx = EaCabeceraCargaCorpBitacora::where('desc_producto', (isset($datosCab['desc_producto']) ? $datosCab['desc_producto']: '')) ->update($datosCab);
            if ($trx) {
                $rsp = (new EaCabCargaInicialBitacoraController)->create_bitacora($datosCab['cod_carga']);
                $success = "Archivo: " . $nombre_archivo . ", del cliente: " . $request->cliente . " cargado en estado pendiente de procesar.";
            }
        } else {
            $error = "Archivos permitidos: xls ó xlsx";
        }
        return redirect()->route('EaCargaIndividualImport.index')->with([
            'success' => isset($success) ? $success : '',
            'error' => isset($error) ? $error : ''
        ]);

        ///////////
        $datosCab = $request->except('_token', 'filtro_cliente', 'filtro_producto', 'filtro_proce_carga');
        $extension = $request->file('archivo')->extension();
        $fecha = Date('Y-m-d');
        //$obj_cab_carga_ini = (new EaCabCargaInicialController);

        if (isset($request->producto)) {
            
            $productoDetalle = (new EaProductoController)->getProductoDetalle($request->cliente, $request->producto);
            $datosCab['desc_producto'] = $productoDetalle->desc_producto;

        }else {

            $datosCab['producto'] = '';
            $datosCab['desc_producto'] = '';
        }
        if (strtolower($extension) == 'xls' || strtolower($extension) == 'xlsx') {

            $datosCab['proceso'] = 'recepcion_provee_tmk';
            $datosCab['usuario_registra'] = $request->usuario_registra;
            $datosCab['fec_registro'] = Date('d/m/Y H:i:s');
            $datosCab['fec_carga'] = $fecha;
            $datosCab['estado'] = 'PENDIENTE';

            if ($request->hasfile('archivo')) {
                $nombre_archivo = $request->file('archivo')->getClientOriginalName();
                $datosCab['archivo'] = $request->file('archivo')->storeAs('recepcion_provee_tmk/'.$request->cliente, $nombre_archivo, 'public');
            }
            //$existe_visible =  $obj_cab_carga_ini->valida_proceso_visible('recepcion_provee_tmk');
           // !$existe_visible ? $datosCab['visible'] ='S' : '';

           // $obj_cab_carga_ini->update_datos_cab_carga($request->cliente, $request->cod_carga,  $datosCab );
            $rsp = (new EaCabCargaInicialBitacoraController)->create_bitacora($request->cod_carga);
            $success = "Archivo: ".$nombre_archivo.", del cliente: ".$request->cliente." cargado en estado pendiente de procesar." ;
        }else {
            $error = "Archivos permitidos: xls ó xlsx";
        }
        return redirect()->route('EaRecepArchiProveTmkController.index')->with(['success' => isset($success) ? $success : '',
                                                                                'error' => isset($error) ? $error : '' ]);
        /////////

    }
}
