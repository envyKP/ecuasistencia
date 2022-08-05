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
//use Illuminate\Support\ServiceProvider;
Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

class EaGenCamExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithEvents, FromCollection, WithHeadings, ShouldAutoSize,WithColumnFormatting,WithCustomValueBinder
{


    /**
     * @return \Illuminate\Support\Collection
     */
    public function generar()
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
                    ///dd($carga_secuencia);
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
        //MODIFICAR EN EL FUTURO LA TABLA QUE SE DEBE INSERTAR O CREAR UN ALTER ESPÉCIFICO PARA PRODUBANCO DEBIDO A QUE ESTE NO CUENTA CON EL CAMPO SECUENCIA



        try {

            EaDetalleDebito::create([
                'id_carga' => isset($rows['id_carga']) ? $rows['id_carga'] + 1 : null,
                'id_sec' => isset($rows['id_sec']) ? trim($rows['id_sec']) : null,
                'secuencia' => isset($rows['secuencia']) ? trim($rows['secuencia']) : null,
                'fecha_registro' => isset($rows['fecha_registro']) ? trim($rows['fecha_registro']) : null,
                'producto' => isset($this->producto) ? trim($this->producto) : '',
                'cliente' => isset($this->cliente) ? trim($this->cliente) : '',
                'estado' => '0',
                'fecha_generacion' => isset($rows['fecha_generacion']) ? trim($rows['fecha_generacion']) : null,
                'subproducto_id' => isset($this->id_subproducto) ? trim($this->id_subproducto) : '',
            ]);
        } catch (\Exception $e) {
            // $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente );
            $this->errorTecnico = $e->getMessage();
        }
    }

    public function registro_cargas(array $rows,$validoacion_par)
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

    public function collection()
    {



        return $this->collection =  EaBaseActiva::join("ea_detalle_debito", "ea_detalle_debito.id_sec", "=", "ea_base_activa.id_sec")
            ->select(
                'ea_base_activa.cedula_id',
                'ea_base_activa.nombre',
                EaBaseActiva::raw("'S/N' as 'Dirección Cliente'"),
                EaBaseActiva::raw("'S/N' as 'Correo Cliente'"),
                EaBaseActiva::raw("'0' as 'Cta / TC'"),
                //EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as 'Fecha Débito'"),
                'ea_detalle_debito.fecha_actualizacion',
                'ea_detalle_debito.valor_debitado'
            )
            ->where('ea_detalle_debito.producto', $this->producto)
            ->where('ea_detalle_debito.id_carga', $this->cod_carga_corp)
            ->where('ea_base_activa.cliente', $this->cliente)
            ->where('ea_detalle_debito.estado', '1')
            ->orderby('ea_base_activa.cedula_id')
            ->get();



        /*
        ,
               
                "IFNULL(ea_detalle_debito.valor_debitado, 'null')"
        return EaBaseActiva::join("ea_detalle_debito", "ea_detalle_debito.id_sec", "=", "ea_base_activa.id_sec")
        ->select(
            'ea_base_activa.cedula_id as \'ID  Cliente\'',
            'ea_base_activa.nombre as \'Nombres Cliente\'',
            EaBaseActiva::raw("'S/N' as 'Dirección Cliente'"),
            EaBaseActiva::raw("'S/N' as 'Correo Cliente'"),
            EaBaseActiva::raw("'S/N' as 'Cta / TC'"),
            EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as 'Fecha Débito'"),
            'ea_detalle_debito.valor_debitado as \'Valor Debitado\''
        )
        ->where('ea_detalle_debito.producto', $this->producto)
        ->where('ea_detalle_debito.id_carga', $this->cod_carga_corp)
        ->where('ea_base_activa.cliente', $this->cliente)
        ->orderby('ea_base_activa.cedula_id')
        ->get();*/

        //return @json_decode(json_encode($obj_facturacion), true);
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

    public function __construct(string $cliente, string $producto, string $cod_carga_corp = null, string $sub_producto_id)
    {

        $this->cliente = $cliente;
        $this->cod_carga_corp = $cod_carga_corp;
        $this->producto = $producto;
        $this->id_subproducto = $sub_producto_id;
        $this->collection = null;
    }
}
