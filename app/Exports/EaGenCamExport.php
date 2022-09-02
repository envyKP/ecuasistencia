<?php

namespace App\Exports;

use App\Models\EaBaseActiva;
use App\Models\EaSubproducto;
use App\Models\EaDetalleDebito;
use App\Models\EaCabeceraDetalleCarga;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\EaOpcionesCargaCliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
//use Illuminate\Support\ServiceProvider;
Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

class EaGenCamExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithEvents, FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithCustomValueBinder
{


    /**
     * @return \Illuminate\Support\Collection
     */
    public function generar($campoC)
    {

        if (!isset($this->cliente)) {
            $this->cliente = "";
        }

        $detalles = $this->is_carga_older();
        $carga_secuencia = "";
        $generar_return = null;
        //en caso que exista algo que no se incluya en las consultas

        // bloque de validacion para campos personalizados 
        //pendiente nombr usare el de camposC en caso de combinar
        //$campoC modificable por llamar otro elemnto para consultas
        $campo_1 = 'ea_detalle_debito.subproducto_id';
        $campo_2 = 'ea_detalle_debito.id_carga';
        $campo_3 = 'ea_base_activa.cliente';
        
        $campo_4 = 'tipresp';
        $campo_5 = 'codresp';
        $campo_6 = 'detresp';
        $campo_7 = 'ea_base_activa.estado';
        $campo_8 = 'ea_base_activa.codestado';
        $campo_9 = 'ea_detalle_debito.estado';

        $valor_1 = $this->id_subproducto; //quemado
        $valor_2 = $carga_secuencia; // quemado
        $valor_3 = $this->cliente;// quemado
        
        $valor_4 = '1';
        $valor_5 = '100';
        $valor_6 = 'ACEPTA SERVICIO';// quemado ?
        $valor_7 = 'Z';
        $valor_8 = 'A';
        $valor_9 = '0';







        if (isset($campoC["existe"])) {
            //manejado por si existe desde el primer campo

            /*
                            'ea_detalle_debito.subproducto_id', $this->id_subproducto)
                            'ea_detalle_debito.id_carga', $carga_secuencia)
                            'ea_base_activa.cliente', $this->cliente)
                            'tipresp', '1')
                            'codresp', '100')
                            'detresp', 'ACEPTA SERVICIO')
                            'ea_base_activa.estado', 'Z')
                            'ea_base_activa.codestado', 'A')
                            'ea_detalle_debito.estado', '0')
            */
            $campo_4 = 'tipresp';
            $campo_5 = 'codresp';
            $campo_6 = 'detresp';
            $campo_7 = 'ea_base_activa.estado';
            $campo_8 = 'ea_base_activa.codestado';
            $campo_9 = 'ea_detalle_debito.estado';
            
            $valor_4 = '1';
            $valor_5 = '100';
            $valor_6 = 'ACEPTA SERVICIO';// quemado ?
            $valor_7 = 'Z';
            $valor_8 = 'A';
            $valor_9 = '0';

            /*
                            'ea_detalle_debito.subproducto_id', $this->id_subproducto)
                            'ea_detalle_debito.id_carga', $carga_secuencia)
                            'ea_base_activa.cliente', $this->cliente)
                            'tipresp', '1')
                            'codresp', '100')
                            'detresp', 'ACEPTA SERVICIO')
                            'ea_base_activa.codestado', 'A')
                            'ea_base_activa.estado', 'Z')
                            'ea_detalle_debito.estado', '0')
            */
            $campo_4 = 'tipresp';
            $campo_5 = 'codresp';
            $campo_6 = 'detresp';
            $campo_7 = 'ea_base_activa.estado';
            $campo_8 = 'ea_base_activa.codestado';
            $campo_9 = 'ea_detalle_debito.estado';

            $valor_4 = '1';
            $valor_5 = '100';
            $valor_6 = 'ACEPTA SERVICIO';// quemado ?
            $valor_7 = 'Z';
            $valor_8 = 'A';
            $valor_9 = '0';


            /*              
                            'ea_subproductos.desc_subproducto', $this->producto)
                            'ea_base_activa.subproducto', $this->producto)
                            'ea_base_activa.cliente', $this->cliente)
                            'tipresp', '1')
                            'detresp', 'ACEPTA SERVICIO')
                            'ea_base_activa.estado', 'Z')
                            'codresp', '100')
                            'ea_base_activa.codestado', 'A')
            */
            $campo_4 = 'tipresp';
            $campo_5 = 'codresp';
            $campo_6 = 'detresp';
            $campo_7 = 'ea_base_activa.estado';
            $campo_8 = 'ea_base_activa.codestado';
            $campo_9 = 'ea_detalle_debito.estado';
            
            $valor_4 = '1';
            $valor_5 = '100';
            $valor_6 = 'ACEPTA SERVICIO';// quemado ?
            $valor_7 = 'Z';
            $valor_8 = 'A';
            $valor_9 = '0';
            /*
                            'ea_subproductos.desc_subproducto', $this->producto)
                            'ea_base_activa.subproducto', $this->producto)
                            'ea_base_activa.cliente', $this->cliente)
                            'tipresp', '1')
                            'detresp', 'ACEPTA SERVICIO')
                            'ea_base_activa.estado', 'Z')
                            'codresp', '100')
                            'ea_base_activa.codestado', 'A')

            */
            $campo_4 = 'tipresp';
            $campo_5 = 'codresp';
            $campo_6 = 'detresp';
            $campo_7 = 'ea_base_activa.estado';
            $campo_8 = 'ea_base_activa.codestado';
            $campo_9 = 'ea_detalle_debito.estado';

            $valor_4 = '1';
            $valor_5 = '100';
            $valor_6 = 'ACEPTA SERVICIO';// quemado ?
            $valor_7 = 'Z';
            $valor_8 = 'A';
            $valor_9 = '0';


        }

        switch ($this->cliente) {
            case 'disable':

                break;


            default:
                $fecha_generacion = (isset($detalles->fecha_generacion) ? $detalles->fecha_generacion : 0);
                if (($fecha_generacion) == date('mY')) {
                    // echo ($detalles->fecha_generacion) . ($detalles->id_sec) . " se encuentra dentro del mes";
                    
                    if (isset($this->cod_carga_corp)) {
                        $carga_secuencia = $this->cod_carga_corp;
                    } else {
                        $carga_secuencia = $detalles->id_carga;
                    }
                    $this->cod_carga_corp = $carga_secuencia;

                    //puedo usar un nuevo campo en caso que venga vacio {} nada comportamiento normal. se tiene que configurar numero de elemento , valor en base
                    $base_op = array();
                    //limite 4
                    //$base_op['camp_ba_1'] = ;


                    if ($this->tipo_subproducto == 'TC') {

                        \Log::info('$carga_secuencia : ' . $carga_secuencia);
                        \Log::info('condicion - secuencia - mes - Cliente : INTER CTAS');
                        $generar_return =  EaBaseActiva::join("ea_subproductos", "ea_subproductos.desc_subproducto", "=", "ea_base_activa.subproducto")
                            ->join("ea_detalle_debito", "ea_detalle_debito.id_sec", "=", "ea_base_activa.id_sec")
                            ->select(
                                'ea_base_activa.id_sec',
                                'ea_base_activa.tarjeta',
                                'ea_subproductos.cod_establecimiento',
                                'ea_subproductos.subtotal',
                                'ea_base_activa.feccad',
                                'ea_base_activa.cuenta',
                                'ea_detalle_debito.id_carga',
                                'ea_base_activa.cedula_id',
                                'ea_base_activa.tipcta',
                                'ea_base_activa.tipide',
                                'ea_subproductos.deduccion_impuesto',
                                'ea_base_activa.nombre',
                                'ea_base_activa.direccion',
                                'ea_base_activa.ciudadet',
                                'ea_subproductos.valortotal',
                            )
                            ->where('ea_detalle_debito.subproducto_id', $this->id_subproducto)
                            ->where('ea_detalle_debito.id_carga', $carga_secuencia)
                            ->where('ea_base_activa.cliente', $this->cliente)
                            ->where('tipresp', '1')
                            ->where('codresp', '100')
                            ->where('detresp', 'ACEPTA SERVICIO')
                            ->where('ea_base_activa.estado', 'Z')
                            ->where('ea_base_activa.codestado', 'A')
                            ->where('ea_detalle_debito.estado', '0')
                            ->orderby('ea_base_activa.id_sec')
                            ->get();
                        //dd($generar_return);
                    } elseif ($this->tipo_subproducto == 'CTAS') {
                        //inicio condigo cuentas KPE
                        \Log::info('$carga_secuencia : ' . $carga_secuencia);
                        \Log::info('condicion - secuencia - mes - Cliente : INTER CTAS');
                        $generar_return =  EaBaseActiva::join("ea_subproductos", "ea_subproductos.desc_subproducto", "=", "ea_base_activa.subproducto")
                            ->join("ea_detalle_debito", "ea_detalle_debito.id_sec", "=", "ea_base_activa.id_sec")
                            ->select(
                                'ea_base_activa.id_sec',
                                'ea_subproductos.cod_establecimiento',
                                'ea_subproductos.subtotal',
                                'ea_base_activa.feccad',
                                'ea_detalle_debito.id_carga',
                                'ea_base_activa.cedula_id',
                                'ea_base_activa.cuenta',
                                'ea_base_activa.tipcta',
                                'ea_base_activa.tipide',
                                'ea_subproductos.deduccion_impuesto',
                                'ea_base_activa.nombre',
                                'ea_base_activa.ciudadet',
                                'ea_subproductos.valortotal',
                            )
                            ->where('ea_detalle_debito.subproducto_id', $this->id_subproducto)
                            ->where('ea_detalle_debito.id_carga', $carga_secuencia)
                            ->where('ea_base_activa.cliente', $this->cliente)
                            ->where('tipresp', '1')
                            ->where('codresp', '100')
                            ->where('detresp', 'ACEPTA SERVICIO')
                            ->where('ea_base_activa.codestado', 'A')
                            ->where('ea_base_activa.estado', 'Z')
                            ->where('ea_detalle_debito.estado', '0')
                            ->orderby('ea_base_activa.id_sec')
                            ->get();

                        //dd($generar_return);
                    } else {
                        \Log::error('Error interno conexion a base o problema con sql.');
                        dd('Error interno conexion a base o problema con sql.');
                    }
                } else {

                    //existe una validacion que es un mes atras no se cobra 
                    //un filtro que solo se use una vez
                    //puede ser para 2 objetivos 
                    // púedo usar el filtro/opciones pero eso solo influiria en el mes (¿habra nescesidad de dia o años ?)
                    //Produbanco ---------
                    // existe asistencia total y asistencia total plus
                    // lo del 15 y el 30 practicamente puedo clasificarlo como producto del subproducto
                    // entonces puedo añadirlo como un subproducto , 
                    //evitaria malavares en la consulta , el problema no es cambiarla el problema es saber cuando la cambio
                    // adicional abria que anidar algo al nombre en caso que sea el 15 o el 30
                    // un subquery para identificar esa diferencia ?
                    // puedo utilizar un combobox. pero el manejo del encabezado 
                    // añadir un campo detalle ?
                    /**
                     * como internamente se podria manejar por el detalle , sin afectar tanto la consultas.
                     * lo tiene que manejar o interpretar como si fuera otro subproducto 
                     * un for afuera 
                     * 
                     * pero como lo diferencia detalle_debito??
                     *  usa la cabezera pero , internamente eso cambia la estructura de las cargas
                     *  deberia manejar otras cargas?
                     * 
                     * proceso ALF:
                     *  ingresa el post con el corte 15 , corte 30
                     *      modifico en eaGenCamExport , para que incluya validacion , y en caso de existir llamo al dato.
                     *          y lo incluyo en la consulta
                     *              se realiza la generacion, se asigna la carga dependiendo del subproducto(revision)
                     *  lectura de la respuesta , toma las validaciones de la base lo lee cambia esta a aceptado.
                     *              cambia el estado de la tabla debito.
                     * 
                     * la siguiente vez aplico el proceso de arriba pero al existir una entra a la comparativa si se 
                     * encuentra dentro del mismo mes y existe una generacion anterior,
                     *           existe , toma los que no han sido debitados(estos por ejemplo corte 15 y seleccione 30),
                     *              al consultar entre estos datos no existe "corte 30"  me devuelve un  archivo sin registro
                     *          termina()
                     * 
                     * añadir un campo detalle si existe campo adicional. (se pondria el valor y el campo en base va en cabezera)
                     * 
                     * añado una nueva condicion a la consulta , en caso si concuerda el campo adicional
                     * 
                     * en la vista apareceria como si se repítieran 2 veces el mismo subproducto.(deberia distinguir en la vista)
                     * 
                     * 
                     * / 

                    /**
                     * bolivariano solo tiene actualmente la identificacion por tarjeta , 
                     * como activar identificacion en par,(cambiar el campo ?)
                     * 
                     * 
                     */
                    /**
                     * 
                     * pendientes , identificacion por par opcional, para identificar respuesta de banco
                     * añadir campo de consulta personalizada , variable adicional o de reemplazo { esto puede ser un campo nuevo o usar el existente}
                     * {manejo de produbanco como hacer los de corte el 15 y corte 30} - en teoria se manejaria como 2 subproductos distintos.
                     * 
                     * ¿añadir un campo de opciones por fecha? no tan fiable , legalemente solo exiten unos cuantos campos para ello, 
                     */

                    /** crear el campo personalizado para cambio en la consulta (principal)
                     *  que exista por defecto lo que ya existe
                         no seria nescesario el for , unicamente se le asignaria un orden y que todo valla 

                     */

                    for ($k = 0; $k < 4; $k++) {
                        if (isset($base_op['var_cam_' . $k])) {
                            // $base_op['var_cam_' . $k] = "dettipcic";
                            //$base_op['var_val_' . $k] = "CORTE EL 15";
                            //$var_val_1 = "CORTE EL 30";
                            // {"var_val_1":"CORTE EL 15","var_val_2":"CORTE EL 30","camp_ba":"dettipcic"}
                            $base_op['camp_ba_' . ($k + 1)] = $base_op['camp_ba'];
                            $base_op['var_val_' . ($k + 1)] = '1';
                        } else {
                            $base_op['camp_ba_' . ($k + 1)] = 'tipresp';
                            $base_op['var_val_' . ($k + 1)] = '1';
                        }
                    }

                    /*
                    ->where($base_op['camp_ba_1'], $base_op['var_val_1'])
                    ->where($base_op['camp_ba_2'], $base_op['var_val_2'])
                    ->where($base_op['camp_ba_3'], $base_op['var_val_3'])
                    ->where($base_op['camp_ba_4'], $base_op['var_val_4'])
                    */

                    /*
                    tipcta
                    AHO = 03
                    CTE = 04
                    */

                    if ($this->tipo_subproducto == 'TC') {
                        \Log::info('condicion - Inicio - mes - CTAS');
                        $generar_return =  EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                            ->select(
                                'ea_base_activa.id_sec',
                                'ea_base_activa.tarjeta',
                                'ea_subproductos.cod_establecimiento',
                                'ea_subproductos.subtotal',
                                'ea_base_activa.feccad',
                                'ea_base_activa.cuenta',
                                'ea_base_activa.cedula_id',
                                'ea_base_activa.tipcta',
                                'ea_base_activa.tipide',
                                'ea_subproductos.deduccion_impuesto',
                                'ea_base_activa.nombre',
                                'ea_base_activa.ciudadet',
                                'ea_subproductos.valortotal',
                            )
                            ->where('ea_subproductos.desc_subproducto', $this->producto)
                            ->where('ea_base_activa.subproducto', $this->producto)
                            ->where('ea_base_activa.cliente', $this->cliente)
                            ->where('tipresp', '1')
                            ->where('detresp', 'ACEPTA SERVICIO')
                            ->where('ea_base_activa.estado', 'Z')
                            ->where('codresp', '100')
                            ->where('ea_base_activa.codestado', 'A')
                            ->orderby('ea_base_activa.id_sec')
                            ->get();
                    } elseif ($this->tipo_subproducto == 'CTAS') {
                        \Log::info('condicion - Inicio - mes - CTAS');
                        $generar_return =  EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                            ->select(
                                'ea_base_activa.id_sec',

                                'ea_subproductos.cod_establecimiento',
                                'ea_subproductos.subtotal',
                                'ea_base_activa.feccad',

                                'ea_base_activa.cedula_id',
                                'ea_base_activa.cuenta',
                                'ea_base_activa.tipcta',
                                'ea_base_activa.tipide',
                                'ea_subproductos.deduccion_impuesto',
                                'ea_base_activa.nombre',
                                'ea_base_activa.ciudadet',
                                'ea_subproductos.valortotal',
                            )
                            ->where('ea_subproductos.desc_subproducto', $this->producto)
                            ->where('ea_base_activa.subproducto', $this->producto)
                            ->where('ea_base_activa.cliente', $this->cliente)
                            ->where('tipresp', '1')
                            ->where('detresp', 'ACEPTA SERVICIO')
                            ->where('ea_base_activa.estado', 'Z')
                            ->where('codresp', '100')
                            ->where('ea_base_activa.codestado', 'A')
                            ->orderby('ea_base_activa.id_sec')
                            ->get();
                        //pymes todo esta como acepta , en mi base le cambiare a acepta servicio.
                    } else {
                        \Log::error('Error interno conexion a base o problema con sql.');
                        dd('Error interno conexion a base o problema con sql.');
                    }
                }

                return $generar_return;
                break;
        }
    }

    use Exportable;

    /**
     * @param array $rows
     * @param  \Illuminate\Http\Request  $request
     * */
    public function view_reg_state(array $rows)
    {
        try {
            EaDetalleDebito::insert($rows); // Eloquent approach

        } catch (\Exception $e) {
            \Log::warning('error view_reg_state:  ' . $e);
            dd("error fatal:" . $e->getMessage());
            // $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente );
            $this->errorTecnico = $e->getMessage();
        }
    }

    public function destroy_cab_detalle($cod_carga, $cliente, $producto)
    {
        \Log::warning('funcion destroy_cab_detalle class EaGenCamExport by user ' . \Auth::user()->username);
        try {
            /*
            \Log::warning('EaDetalleDebito::where(id_carga,' . $cod_carga . ')->where(cliente, ' . $cliente . ')
            ->where(subproducto_id, ' . $producto . ')
            ->delete();');
            */

            EaDetalleDebito::where('id_carga', $cod_carga)
                ->where('cliente', $cliente)
                ->where('subproducto_id', $producto)
                ->delete();
            /*
            \Log::warning('EaDetalleDebito::where(id_carga,' . $cod_carga . ')->where(cliente, ' . $cliente . ')
            ->where(subproducto_id, ' . $producto . ')
            ->delete();');
            */

            EaCabeceraDetalleCarga::where('cod_carga', $cod_carga)
                ->where('cliente', $cliente)
                ->where('producto', $producto)
                ->delete();
        } catch (\Exception $e) {
            \Log::warning('error view_reg_state:  ' . $e);
            // $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente );
            $this->errorTecnico = $e->getMessage();
        }
    }

    public function destroy_cab($cod_carga, $cliente, $producto)
    {
        \Log::warning('funcion destroy_cab_detalle class EaGenCamExport by user ' . \Auth::user()->username);
        try {

            EaCabeceraDetalleCarga::where('cod_carga', $cod_carga)
                ->where('cliente', $cliente)
                ->where('producto', $producto)
                ->delete();
        } catch (\Exception $e) {
            \Log::warning('error view_reg_state:  ' . $e);
            // $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente );
            $this->errorTecnico = $e->getMessage();
        }
    }

    public function registro_cargas(array $rows, $validoacion_par)
    {
        try {

            EaCabeceraDetalleCarga::create([
                'cod_carga' => isset($rows['cod_carga']) ? $rows['cod_carga'] + 1 : null,
                'fecha_actualizacion' => isset($row['fecha_actualizacion']) ? $rows['fecha_actualizacion'] : '',
                'fec_registro' => isset($rows['fecha_registro']) ? trim($rows['fecha_registro']) : null,
                'producto' =>  isset($rows['producto']) ? trim($rows['producto']) : null,
                'desc_producto' => isset($this->producto) ? trim($this->producto) : '',
                'cliente' => isset($this->cliente) ? trim($this->cliente) : '',
                'producto' => $this->id_subproducto,
                'fec_carga' => isset($rows['fecha_generacion']) ? trim($rows['fecha_generacion']) : null,
                'usuario_registra' => isset($rows['usuario']) ? trim($rows['usuario']) : null,
                'estado' => 'PENDIENTE',
                'is_det_debito' => '1',
                'opciones_validacion' => $validoacion_par,
                'ruta_gen_debito' => isset($rows['ruta_gen_debito']) ? trim($rows['ruta_gen_debito']) : null,
            ]);
        } catch (\Exception $e) {
            // $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente );
            $this->errorTecnico = $e->getMessage();
        }
    }
    public function ruta_carga()
    {

        #$this->cliente = $cliente;
        #$this->cod_carga_corp = $cod_carga_corp;
        #$this->producto = $producto; //usanddo la desc
        #$this->id_subproducto = $sub_producto_id;
        #$this->tipo_subproducto = $tipo_subproducto;

        try {
            return EaCabeceraDetalleCarga::where('cod_carga', $this->cod_carga_corp)->where('producto', $this->id_subproducto)->where('cliente', $this->cliente)->get()->first();
        } catch (\Exception $e) {
            $this->errorTecnico = $e->getMessage();
        }
    }


    public function is_carga_older()
    {
        return EaDetalleDebito::where('cliente', $this->cliente)
            ->where('subproducto_id', $this->id_subproducto)
            ->orderbydesc('id_carga')
            ->first();
    }

    public function collection()
    {
        $temporal = null;
        $temporal2 = null;
        $temporal3 = null;
        $op_client = EaOpcionesCargaCliente::where('cliente', $this->cliente)->where('subproducto', $this->producto)->first();

        $opciones_factura = null;
        if (isset($op_client->opciones_factura)) {
            $opciones_factura = json_decode($op_client->campos_import, true);
            if (isset($opciones_factura['direccion'])) {
                $temporal = '';
            } else {
                $temporal = EaBaseActiva::raw("'S/N' as 'Dirección Cliente'");
            }
            if (isset($opciones_factura['correo'])) {
                $temporal2 = 'ea_base_activa.mail';
            } else {
                $temporal2 = EaBaseActiva::raw("'S/N' as 'Correo Cliente'");
            }
        } else {
            $temporal = EaBaseActiva::raw("'S/N' as 'Dirección Cliente'");
            $temporal2 = EaBaseActiva::raw("'S/N' as 'Correo Cliente'");
            $temporal3 = EaBaseActiva::raw("'0' as 'Cta / TC'");
        }
        //$temporal3 = 'ea_base_activa.cuenta';
        //$this->tipo_subproducto = 'CTAS';
        $this->collection =  EaBaseActiva::join("ea_detalle_debito", "ea_detalle_debito.id_sec", "=", "ea_base_activa.id_sec")
            ->select(
                'ea_base_activa.cedula_id',
                'ea_base_activa.nombre',
                $temporal,
                $temporal2,
                EaBaseActiva::raw("'0' as 'Cta / TC'"),
                'ea_detalle_debito.fecha_actualizacion',
                'ea_detalle_debito.valor_debitado'
            )
            ->where('ea_detalle_debito.subproducto_id', $this->id_subproducto)
            ->where('ea_detalle_debito.id_carga', $this->cod_carga_corp)
            ->where('ea_base_activa.cliente', $this->cliente)
            ->where('ea_detalle_debito.estado', '1')
            ->orderby('ea_base_activa.cedula_id')
            ->get();
        $contenido = file_get_contents("../salsa.txt");
        $clave = Key::loadFromAsciiSafeString($contenido);
        foreach ($this->collection as $individual) {
            $input =  $individual->fecha_actualizacion;
            $date = strtotime($input);
            $individual->fecha_actualizacion = date('Y-m-d', $date);

            if ($individual->fecha_actualizacion == '1970-01-01') {
                $individual->fecha_actualizacion = 'Date Parse Error , fecha registrada = ' . $input;
            }
        }
        return $this->collection;
    }


    public function headings(): array
    {
        return ["ID Cliente", "Nombres Clientes", "Dirección Cliente", "Correo Cliente", "Cta / TC", "Fecha Débito", "Valor Debitado"];
    }
    /*
    public function registerEvents(): array
    {
        return [
            
            
            AfterSheet::class    => function(AfterSheet $event) {
                $event->writer->setCreator('EnvyKP');
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

                $event->sheet->styleCells(
                    'A1:W1',
                    [
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                                'color' => ['argb' => 'FFFF0000'],
                            ],
                        ]
                    ]
                );
            },
        ];
    }
    }*/

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:' . 'G' . ($this->collection->count() + 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '00000000'],
                        ],
                    ],
                ]);
                $event->sheet->getStyle('C1:E1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '008001',
                        ]
                    ],
                ]);
                $event->sheet->getStyle('A1:B1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'FFFF01',
                        ]
                    ],
                ]);
                $event->sheet->getStyle('F1:G1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'FFFF01',
                        ]
                    ],
                ]);
                /*              $event->sheet->styleCells(
                    'A1:A1',
                    [
                        //Set border Style
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '00000000'],
                            ],
                        ],
                        //Set font style
                         'font' => [
                            'name'      =>  'Calibri',
                            'size'      =>  15,
                            'bold'      =>  true,
                            'color' => ['argb' => 'EB2B02'],
                        ],
                        
                        //Set background style
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => 'FFFF01',
                            ]
                        ],
                    ]
                    {"5":"","6":"202","7":"","8":"00","10":"439473","13":"00","14":"D","15":"00000","16":"","17":""}
                    {"1":"tarjeta", "2":"cod_establecimient" ,"4":"subtotal","11":"feccad","12":"deduccion_impuesto","16":"subtotal"}
                    {"secuencia":"vale","fecha_actualizacion":"","valor_debitado":"VALOR","detalle":"estado","validacion_campo_1":"Establecimiento","validacion_valor_1":"876406","num_validacion":"1"}
                    {"campoC_3":"Ymd","campoC_9":"contador_secuencia","espacios":"","identificador":"secuencia"}
                    {"campo0_2":"8","campo0_4":"17","campo0_5":"17","campo0_7":"6","campo0_9":"6","campo0_12":"17","campo0_16":"15","campo0_17":"15"}

                   subproducto = desc_subproducto

                    {"5":"","6":"202","7":"","8":"00","10":"439473","13":"00","14":"D","15":"00000","16":"","17":""}
                    {"1":"tarjeta", "2":"cod_establecimient" ,"4":"subtotal","11":"feccad","12":"deduccion_impuesto","16":"subtotal"}
                    {"campoC_3":"Ymd","campoC_9":"contador_secuencia","espacios":"","identificador":"secuencia"}
                    {"campo0_2":"8","campo0_4":"17","campo0_5":"17","campo0_7":"6","campo0_9":"6","campo0_12":"17","campo0_16":"15","campo0_17":"15"}
                );*/
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function __construct(string $cliente, string $producto, string $cod_carga_corp = null, string $sub_producto_id, $tipo_subproducto)
    {

        $this->cliente = $cliente;
        $this->cod_carga_corp = $cod_carga_corp;
        $this->producto = $producto; //usanddo la desc
        $this->id_subproducto = $sub_producto_id;
        $this->tipo_subproducto = $tipo_subproducto;
        $this->collection = null;
    }
}
