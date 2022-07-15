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
                    $this->cod_carga_corp = $detalles->id_carga;
                    return EaBaseActiva::join("ea_subproductos", "ea_subproductos.desc_subproducto", "=", "ea_base_activa.subproducto")
                        ->join("ea_detalle_debito", "ea_detalle_debito.id_sec", "=", "ea_base_activa.id_sec")
                        ->select(
                            'ea_base_activa.id_sec',
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
                        ->where('ea_base_activa.cliente', $this->cliente)
                        ->where('tipresp', '1')
                        ->where('codresp', '100')
                        ->where('detresp', 'ACEPTA')
                        ->where('ea_base_activa.estado', 'Z')
                        ->where('ea_detalle_debito.estado', '0')
                        ->orderby('ea_base_activa.id_sec')
                        ->get();
                    // preguntar luego
                    /*
                        ->where('detresp', 'ACEPTA SERVICIO')
                        ->where('ea_base_activa.estado', 'Z')
                    */


                    //->where('ea_detalle_debito.producto', $this->producto)
                } else {
                    return  EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                        ->select(
                            'ea_base_activa.id_sec',
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
                        ->where('ea_base_activa.cliente', $this->cliente)
                        ->where('tipresp', '1')
                        ->where('detresp', 'ACEPTA')
                        ->where('ea_base_activa.estado', 'Z')
                        ->where('codresp', '100')
                        ->orderby('ea_base_activa.id_sec')
                        ->get();
                    // preguntar luego
                    /*
                        ->where('detresp', 'ACEPTA')
                        ->where('ea_base_activa.estado', 'Z')
                    */
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
                        'ea_base_activa.id_sec'
                    )
                    ->where('desc_subproducto', $this->producto)
                    ->where('ea_base_activa.cliente', $this->cliente)
                    ->where('tipresp', '1')
                    ->where('codresp', '100')
                    ->where('detresp', 'ACEPTA SERVICIO')
                    ->where('estado', 'Z')
                    ->get();

                break;
            case "BGR":
                return EaBaseActiva::where('cliente', 'BGR')->select(
                    'tarjeta',
                    EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                    EaBaseActiva::raw("'00000000000000000' as constante1"),
                    EaBaseActiva::raw("'202' as constante2"),
                    EaBaseActiva::raw("'000000' as constante3"),
                    EaBaseActiva::raw("'00' as constante4"),
                    EaBaseActiva::raw("'00000' as reemplazar"),
                    EaBaseActiva::raw("'439473' as constante5"),
                    'feccad',
                    'detresp',
                    'codresp',
                    EaBaseActiva::raw("'00' as constante6"),
                    EaBaseActiva::raw("'D' as constante7"),
                    EaBaseActiva::raw("'00000' as constante8"),
                    EaBaseActiva::raw("'000000000000000' as constante9"),
                    'id_sec'
                )->where('tipresp', '1')
                    ->where('codresp', '100')
                    ->where('detresp', 'ACEPTA SERVICIO')
                    ->where('estado', 'Z')
                    ->get();
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
                        'ea_base_activa.id_sec'
                    )
                    ->where('desc_subproducto', $this->producto)
                    ->where('ea_base_activa.cliente', $this->cliente)
                    ->where('tipresp', '1')
                    ->where('codresp', '100')
                    ->where('detresp', 'ACEPTA SERVICIO')
                    ->where('estado', 'Z')
                    ->get();
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
                        'ea_base_activa.id_sec'
                    )
                    ->where('desc_subproducto', $this->producto)
                    ->where('ea_base_activa.cliente', $this->cliente)
                    ->where('tipresp', '1')
                    ->where('codresp', '100')
                    ->where('detresp', 'ACEPTA SERVICIO')
                    ->where('estado', 'Z')
                    ->get();

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
                        'ea_base_activa.id_sec'
                    )
                    ->where('desc_subproducto', $this->producto)
                    ->where('ea_base_activa.cliente', $this->cliente)
                    ->where('tipresp', '1')
                    ->where('codresp', '100')
                    ->where('detresp', 'ACEPTA SERVICIO')
                    ->where('estado', 'Z')
                    ->get();
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
                        'ea_base_activa.id_sec'
                    )
                    ->where('desc_subproducto', $this->producto)
                    ->where('ea_base_activa.cliente', $this->cliente)
                    ->where('tipresp', '1')
                    ->where('codresp', '100')
                    ->where('detresp', 'ACEPTA SERVICIO')
                    ->where('estado', 'Z')
                    ->get();
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
                        'ea_base_activa.id_sec'
                    )
                    ->where('desc_subproducto', $this->producto)
                    ->where('ea_base_activa.cliente', $this->cliente)
                    ->where('tipresp', '1')
                    ->where('codresp', '100')
                    ->where('detresp', 'ACEPTA SERVICIO')
                    ->where('estado', 'Z')
                    ->get();
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
                        'ea_base_activa.id_sec'
                    )
                    ->where('desc_subproducto', $this->producto)
                    ->where('ea_base_activa.cliente', $this->cliente)
                    ->where('tipresp', '1')
                    ->where('codresp', '100')
                    ->where('detresp', 'ACEPTA SERVICIO')
                    ->where('estado', 'Z')
                    ->get();
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
                        'ea_base_activa.id_sec'
                    )
                    ->where('desc_subproducto', $this->producto)
                    ->where('ea_base_activa.cliente', $this->cliente)
                    ->where('tipresp', '1')
                    ->where('codresp', '100')
                    ->where('detresp', 'ACEPTA SERVICIO')
                    ->where('estado', 'Z')
                    ->get();
                break;


            default:
                return "error consulte a soporte";
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

            EaDetalleDebito::create([
                'id_carga' => isset($rows['id_carga']) ? $rows['id_carga'] + 1 : null,
                'id_sec' => isset($rows['id_sec']) ? trim($rows['id_sec']) : null,
                'secuencia' => isset($rows['secuencia']) ? trim($rows['secuencia']) : null,
                'fecha_actualizacion' => isset($rows['fecha_actualizacion']) ? $rows['fecha_actualizacion'] : '',
                'fecha_registro' => isset($rows['fecha_registro']) ? trim($rows['fecha_registro']) : null,
                'producto' => isset($this->producto) ? trim($this->producto) : '',
                'subproducto' => isset($this->producto) ? trim($this->producto) : '',
                'cliente' => isset($this->cliente) ? trim($this->cliente) : '',
                'estado' => '0',
                'fecha_generacion' => isset($rows['fecha_generacion']) ? trim($rows['fecha_generacion']) : null,
            ]);
        } catch (\Exception $e) {
            // $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente );
            $this->errorTecnico = $e->getMessage();
        }
    }

    public function registro_cargas(array $rows)
    {

        try {
            EaCabeceraCargaCorpBitacora::create([
                'cod_carga' => isset($rows['cod_carga']) ? $rows['cod_carga'] + 1 : null,
                'fecha_actualizacion' => isset($row['fecha_actualizacion']) ? $rows['fecha_actualizacion'] : '',
                'fec_registro' => isset($rows['fecha_registro']) ? trim($rows['fecha_registro']) : null,
                'producto' =>  isset($rows['producto']) ? trim($rows['producto']) : null,
                'desc_producto' => isset($this->producto) ? trim($this->producto) : '',
                'cliente' => isset($this->cliente) ? trim($this->cliente) : '',
                'fec_carga' => isset($rows['fecha_generacion']) ? trim($rows['fecha_generacion']) : null,
                'usuario_registra' => isset($rows['usuario']) ? trim($rows['usuario']) : null,
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

    public function __construct(string $cliente, string $producto, string $cod_carga_corp = null)
    {

        $this->cliente = $cliente;
        $this->cod_carga_corp = $cod_carga_corp;
        $this->producto = $producto;
    }
}
