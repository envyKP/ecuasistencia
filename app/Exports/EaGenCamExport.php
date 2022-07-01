<?php

namespace App\Exports;

use App\Models\EaBaseActiva;
use App\Models\EaSubproducto;
use App\Models\EaDetalleDebito;
use App\Models\EaCabeceraCargaCorpBitacora;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;

class EaGenCamExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        if (!isset($this->cliente)) {
            $this->cliente = "";
        }

        $detalles = $this->is_carga_older();
        //dd($detalles);

        /*$detalles = EaDetalleDebito::where('cliente', $this->cliente)
            ->where('producto', $this->producto)
            ->orderbydesc('id_carga')
            ->first();
        */
        // condicion para cada tema en caso que este en el transcurso del mes , y la otra en caso
        //que ya el mes sea distinto
        /*
        if(($detalles->fecha_generacion) == date('mY')){
            echo ($detalles->fecha_generacion).($detalles->id_sec)." se encuentra dentro del mes";


        }else{
            echo ($detalles->fecha_generacion).($detalles->id_sec)."esta fuera del mes".date('mY');

        }
        */


        switch ($this->cliente) {
            case 'INTER':
                $fecha_generacion = (isset($detalles->fecha_generacion) ? $detalles->fecha_generacion : 0);

                if (($fecha_generacion) == date('mY')) {
                    // echo ($detalles->fecha_generacion) . ($detalles->id_sec) . " se encuentra dentro del mes";
                    $carga_secuencia = "";

                    if (isset($this->cod_carga_corp)) {
                        $carga_secuencia = $this->cod_carga_corp;
                    } else {
                        $carga_secuencia = $detalles->id_carga;
                    }
                    //dd($carga_secuencia);
                    $this->cod_carga_corp = $detalles->id_carga;
                    /*
                    echo $this->cod_carga_corp;
                    echo $detalles->id_carga;
                    echo "  ";
                    echo $detalles->producto;
                    echo $this->producto;*/
                    return EaBaseActiva::join("ea_subproductos", "ea_subproductos.desc_subproducto", "=", "ea_base_activa.subproducto")
                        ->join("ea_detalle_debito", "ea_detalle_debito.id_sec", "=", "ea_base_activa.id_sec")
                        ->select(
                            'tarjeta',
                            'ea_subproductos.cod_establecimiento',
                            EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                            'ea_subproductos.subtotal',
                            EaBaseActiva::raw("'00000000000000000' as constante1"),
                            EaBaseActiva::raw("'202' as constante2"),
                            EaBaseActiva::raw("'000000' as constante3"),
                            EaBaseActiva::raw("'00' as constante4"),
                            EaBaseActiva::raw("'00000' as reemplazar"),
                            EaBaseActiva::raw("'439473' as constante5"),
                            'feccad',
                            'ea_subproductos.deduccion_impuesto',
                            EaBaseActiva::raw("'00' as constante6"),
                            EaBaseActiva::raw("'D' as constante7"),
                            EaBaseActiva::raw("'00000' as constante8"),
                            'ea_subproductos.subtotal',
                            EaBaseActiva::raw("'000000000000000' as constante9"),
                            'ea_base_activa.id_sec',
                            'ea_detalle_debito.id_carga'
                        )
                        ->where('ea_detalle_debito.producto', $this->producto)
                        ->where('ea_detalle_debito.id_carga', $carga_secuencia)
                        ->where('tipresp', '1')
                        ->where('codresp', '100')
                        ->where('detresp', 'ACEPTA SERVICIO')
                        ->where('ea_base_activa.estado', 'Z')
                        ->where('ea_detalle_debito.estado', '0')
                        ->get();
                        //->where('ea_detalle_debito.producto', $this->producto)
                } else {
                    return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                        ->select(
                            'tarjeta',
                            'ea_subproductos.cod_establecimiento',
                            EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                            'ea_subproductos.subtotal',
                            EaBaseActiva::raw("'00000000000000000' as constante1"),
                            EaBaseActiva::raw("'202' as constante2"),
                            EaBaseActiva::raw("'000000' as constante3"),
                            EaBaseActiva::raw("'00' as constante4"),
                            EaBaseActiva::raw("'00000' as reemplazar"),
                            EaBaseActiva::raw("'439473' as constante5"),
                            'feccad',
                            'ea_subproductos.deduccion_impuesto',
                            EaBaseActiva::raw("'00' as constante6"),
                            EaBaseActiva::raw("'D' as constante7"),
                            EaBaseActiva::raw("'00000' as constante8"),
                            'ea_subproductos.subtotal',
                            EaBaseActiva::raw("'000000000000000' as constante9"),
                            'ea_base_activa.id_sec'
                        )
                        ->where('desc_subproducto', $this->producto)
                        ->where('tipresp', '1')
                        ->where('codresp', '100')
                        ->where('detresp', 'ACEPTA SERVICIO')
                        ->where('estado', 'Z')
                        ->get();
                        //->where('producto', $this->producto)
                }
                break;

            case "BBOLIVARIANO":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();

                break;
            case "BGR":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();
                break;
            case "PICHINCHA":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();
                break;
            case "PRODUBANCO":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();

                break;
            case "DINERS":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();
                break;
            case "MOVISTAR":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();
                break;
            case "NOVA":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();
                break;
            case "REALME":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();
                break;
            case "SAMSUNG":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();
                break;


            default:
                // $seUne =  db::EaBaseActiva();


                //1) realizar boton que permita que la condicion retornet todos los activos //esto creara la secuencia
                //, y en caso contrario , 
                //2)compare con la version anterior de la carga. // unicamente realiza comparativa

                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )
                    ->where('producto', $this->producto)
                    ->where('tipresp', '1')
                    ->where('codresp', '100')
                    ->where('detresp', 'ACEPTA SERVICIO')
                    ->where('estado', 'Z')
                    ->get();

                // ->where('producto', '400100012008312') $Producto = contrato_ama


                /*
                    return EaBaseActiva::join("ea_subproductos","ea_subproductos.contrato_ama","=","ea_base_activa.producto")
                ->join("ea_detalle_debito","ea_detalle_debito.id_sec","=","ea_base_activa.id_sec")     
                ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                     )->where('producto', '400100012008312')
                     ->where('tipresp', '1')
                     ->where('codresp', '100')
                     ->where('detresp', 'ACEPTA SERVICIO')
                     ->where('estado', 'Z')
                     ->get();

                     */

                //$this->cliente == INTER
                /* 
                        select [lo de export] from ea_base activa as ea inner join ea_subproductos 
                        on ea.subproductos.contrato_ama = ea_base_activa.productos inner join
                        ea_detalle_debito edet on edet.id_sec = ea_base_activa.id_sec 
                        where ea.producto = '400100012008312' 
                        and edet.estado = '0' 
                        and ea.cliente = 'INTER'
                        and edet.fech_gen_year = $variable1 
                        and ede.fecha_gen_mes = $variable2


                        join ( select * from ea_detalle_debito edet
                        where edet.estado = 0 and edet.id_sec = ea_base_activa.id_sec    
                        edet.fech_gen_year = $variable1 and
                        ede.fecha_gen_mes = $variable2 )


                        */

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
        //$obj_det_carga_corp = (new EaDetalleCargaCorpController);
        // $reg_duplicado = $obj_det_carga_corp->existe_registro($this->cod_carga, $this->cliente, $row['cedula']);
        //   if (!$reg_duplicado) {
        //dd($rows);


        try {
            
            EaDetalleDebito::create([
                'id_carga' => isset($rows['id_carga']) ? $rows['id_carga'] + 1 : null,
                'id_sec' => isset($rows['id_sec']) ? trim($rows['id_sec']) : null,
                'secuencia' => isset($rows['secuencia']) ? trim($rows['secuencia']) : null,
                'fecha_actualizacion' => isset($row['fecha_actualizacion']) ? $rows['fecha_actualizacion'] : '',
                'fecha_registro' => isset($rows['fecha_registro']) ? trim($rows['fecha_registro']) : null,
                'producto' => isset($this->producto) ? trim($this->producto) : '',
                'subproducto' => isset($this->producto) ? trim($this->producto) : '',
                'cliente' => isset($this->cliente) ? trim($this->cliente) : '',
                'estado' => '0',
                'bin' => isset($rows['bin']) ? trim(substr($rows['bin'], 0, 6)) : null,
                'fecha_generacion' => isset($rows['fecha_generacion']) ? trim($rows['fecha_generacion']) : null,
            ]);

        } catch (\Exception $e) {
            // $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente );
            $this->errorTecnico = $e->getMessage();
        }
    }

    public function registro_cargas(array $rows)
    {
        // $obj_cab_carga_cor_bita = (new EaCabeceraCargaCorpBitacora);
        // $reg_duplicado = $obj_det_carga_corp->existe_registro($this->cod_carga, $this->cliente, $row['cedula']);
        //   if (!$reg_duplicado) {
        //dd($rows);
        
        try {
            EaCabeceraCargaCorpBitacora::create([
                'cod_carga' => isset($rows['cod_carga']) ? $rows['cod_carga'] + 1 : null,
                'fecha_actualizacion' => isset($row['fecha_actualizacion']) ? $rows['fecha_actualizacion'] : '',
                'fec_registro' => isset($rows['fecha_registro']) ? trim($rows['fecha_registro']) : null,
                'desc_producto' => isset($this->producto) ? trim($this->producto) : '',
                'cliente' => isset($this->cliente) ? trim($this->cliente) : '',
                'fec_carga' => isset($rows['fecha_generacion']) ? trim($rows['fecha_generacion']) : null,
                'usuario_registra' => 'pruebas',
                'estado' => 'PENDIENTE',
                'is_det_debito' => '1',
            ]);
        } catch (\Exception $e) {
            // $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente );
            $this->errorTecnico = $e->getMessage();
        }
    }

    public function is_carga_older()
    {
        return EaDetalleDebito::where('cliente', $this->cliente)
            ->where('producto', $this->producto)
            ->orderbydesc('id_carga')
            ->first();
    }


    /*
            } else {
                $this->total_registros_duplicados++;
            }
        
    }
    
    public function view(): View
    {

        if (!empty($this->producto)) {

            #code... modificar genaif
            return view('genaif.detalle', [

                'dataExport' => EaBaseActiva::where('cliente', $this->cliente)
                    ->where('estado_proceso', 3)
                    ->where('producto', $this->producto)
                    ->where('cod_carga_corp', $this->cod_carga_corp)
                    ->where('tipresp', '1')
                    ->where('codresp', '100')
                    ->where('detresp', 'ACEPTA SERVICIO')
                    ->where('estado', 'Z')
                    ->get()
            ]);
        } else {
            return view('genaif.detalle', [

                'dataExport' => EaBaseActiva::where('cliente', $this->cliente)
                    ->where('estado_proceso', 3)
                    ->where('cod_carga_corp', $this->cod_carga_corp)
                    ->where('tipresp', '1')
                    ->where('codresp', '100')
                    ->where('detresp', 'ACEPTA SERVICIO')
                    ->where('estado', 'Z')
                    ->get()

            ]);
        }
    }
    */
    public function __construct(string $cliente, string $producto, string $cod_carga_corp = null)
    {

        $this->cliente = $cliente;
        $this->cod_carga_corp = $cod_carga_corp;
        $this->producto = $producto;
    }
}
