<?php

namespace App\Exports;

use App\Models\EaBaseActiva;
use App\Models\EaDetalleDebito;
use App\Models\EaCabeceraDetalleCarga;
use App\Models\EaOpcionesCargaCliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Defuse\Crypto\Key;
use Carbon\Carbon;
//use Maatwebsite\Excel\Events\BeforeExport;
//use Maatwebsite\Excel\Events\BeforeWriting;
//use Maatwebsite\Excel\Events\BeforeSheet;
//use App\Models\EaSubproducto;
//use Illuminate\Contracts\View\View;
//use Maatwebsite\Excel\Concerns\FromView;
//use Illuminate\Support\Collection;
//use Maatwebsite\Excel\Concerns\ToCollection;
//use Illuminate\Support\Facades\DB;
//use Maatwebsite\Excel\Concerns\WithMultipleSheets;
//use PhpOffice\PhpSpreadsheet\Shared\Date;
//use Defuse\Crypto\Crypto;

//use Illuminate\Support\ServiceProvider;
Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

class EaGenCamExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithEvents, FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithCustomValueBinder
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function generar($request)
    {


        if (!isset($this->cliente)) {
            $this->cliente = "";
        }
        
        $carga_secuencia = "";
        $generar_return = null;
        // caracteristica 1 KPE cambios opciones
        if (isset($request['op_caracteristica_ba'])) {
            $campos_consulta = $request['op_caracteristica_ba'];
            $consulta_personalizada = $campos_consulta['campo_ba'];
            $valor_consulta_per = $request['opciones_data']; // debe ser parte del request
        } else {
            $consulta_personalizada = 'tipresp';
            $valor_consulta_per = '1';
        }
        $detalles = $this->is_carga_older($request);

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
                    // caracteristica 1 KPE cambios opciones
                    if (isset($request['op_caracteristica_ba'])) {
                        $consulta_personalizada = 'ea_detalle_debito.opciones';
                        $valor_consulta_per = $request['opciones_data']; // debe ser parte del request
                    } else {
                        $consulta_personalizada = 'tipresp';
                        $valor_consulta_per = '1';
                    }
                    $this->cod_carga_corp = $carga_secuencia;
                    //puedo usar un nuevo campo en caso que venga vacio {} nada comportamiento normal. se tiene que configurar numero de elemento , valor en base
                    //limite 4
                    //$base_op['camp_ba_1'] = ;// campo creado para cambiar la consulta , puedo usar el ciclo .// quitarle el campo //m renombrar
                    //$base_op['campo_ba'];// 
                    // o similar a bolivariano consulto todo y se depura en la vista donde se invoca la validacion
                    // en ese caso deberia ser el nombre del campo , y se envie los valores del metodo escojido por el request en  la vista.
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
                                'ea_base_activa.fecha',
                                'ea_base_activa.ciclo',
                            )
                            ->where('ea_detalle_debito.subproducto_id', $this->id_subproducto)
                            ->where('ea_detalle_debito.id_carga', $carga_secuencia)
                            ->where('ea_base_activa.cliente', $this->cliente)
                            ->where('tipresp', '1')
                            ->where('codresp', '100')
                            ->where($consulta_personalizada, $valor_consulta_per)
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
                                'ea_base_activa.fecha',
                                'ea_base_activa.ciclo',
                            )
                            ->where('ea_detalle_debito.subproducto_id', $this->id_subproducto)
                            ->where('ea_detalle_debito.id_carga', $carga_secuencia)
                            ->where('ea_base_activa.cliente', $this->cliente)
                            ->where('tipresp', '1')
                            ->where('codresp', '100')
                            ->where($consulta_personalizada, $valor_consulta_per)
                            ->where('ea_base_activa.codestado', 'A')
                            ->where('ea_base_activa.estado', 'Z')
                            ->where('ea_detalle_debito.estado', '0')
                            ->orderby('ea_base_activa.id_sec')
                            ->get();
                        //dd($generar_return);
                        //comportamiento extraños fotos del lugar de tranbajo , mmm me querran botar ? 
                    } else {
                        \Log::error('Error interno conexion a base o problema con sql.');
                        dd('Error interno conexion a base o problema con sql.');
                    }
                } else {
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
                                'ea_base_activa.fecha',
                                'ea_base_activa.ciclo',
                            )
                            ->where('ea_subproductos.desc_subproducto', $this->producto)
                            ->where('ea_base_activa.subproducto', $this->producto)
                            ->where('ea_base_activa.cliente', $this->cliente)
                            ->where('tipresp', '1')
                            ->where($consulta_personalizada, $valor_consulta_per)
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
                                'ea_base_activa.fecha',
                                'ea_base_activa.ciclo',
                            )
                            ->where('ea_subproductos.desc_subproducto', $this->producto)
                            ->where('ea_base_activa.subproducto', $this->producto)
                            ->where('ea_base_activa.cliente', $this->cliente)
                            ->where('tipresp', '1')
                            ->where($consulta_personalizada, $valor_consulta_per)
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
            // puede que no lo borre
            \Log::warning("EaDetalleDebito::where(id_carga," . $cod_carga . " )->where(cliente, " . $cliente);

            // KPE CAMBIO VARIABLE ->where('subproducto_id', $producto)
            EaDetalleDebito::where('id_carga', $cod_carga)
                ->where('cliente', $cliente)
                ->where('subproducto_id', $producto)
                ->delete();

            $this->destroy_cab($cod_carga, $cliente, $producto);

            /* EaCabeceraDetalleCarga::where('cod_carga', $cod_carga)
                ->where('cliente', $cliente)
                ->where('producto', $producto)
                ->delete();
            */
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

    public function registro_cargas(array $rows)
    {
        try {
            $mensaje = EaCabeceraDetalleCarga::create([
                'cod_carga' => isset($rows['cod_carga']) ? $rows['cod_carga'] : null,
                'fecha_actualizacion' => isset($row['fecha_actualizacion']) ? $rows['fecha_actualizacion'] : '',
                'fec_registro' => Carbon::now(),
                'producto' =>  isset($rows['producto']) ? trim($rows['producto']) : null,
                'desc_producto' => isset($this->producto) ? trim($this->producto) : '',
                'cliente' => isset($this->cliente) ? trim($this->cliente) : '',
                'producto' => $this->cab_subproducto,
                'fec_carga' => isset($rows['fecha_generacion']) ? trim($rows['fecha_generacion']) : null,
                'usuario_registra' => isset($rows['usuario']) ? trim($rows['usuario']) : null,
                'estado' => 'PENDIENTE',
                'is_det_debito' => '1',
                'ruta_gen_debito' => isset($rows['ruta_gen_debito']) ? trim($rows['ruta_gen_debito']) : null,
                'opciones' => isset($rows['opciones']) ? $rows['opciones'] : null,
            ]);
            /*
        EaCabeceraDetalleCarga::create([
                'cod_carga' => isset($rows['cod_carga']) ? $rows['cod_carga'] : null,
                'fecha_actualizacion' => isset($row['fecha_actualizacion']) ? $rows['fecha_actualizacion'] : '',
                'fec_registro' => isset($rows['fecha_registro']) ? $date->format('d-m-Y') : null,
                'producto' =>  isset($rows['producto']) ? trim($rows['producto']) : null,
                'desc_producto' => isset($this->producto) ? trim($this->producto) : '',
                'cliente' => isset($this->cliente) ? trim($this->cliente) : '',
                'producto' => $this->id_subproducto,
                'fec_carga' => isset($rows['fecha_generacion']) ? trim($rows['fecha_generacion']) : null,
                'usuario_registra' => isset($rows['usuario']) ? trim($rows['usuario']) : null,
                'estado' => 'PENDIENTE',
                'is_det_debito' => '1',
                'ruta_gen_debito' => isset($rows['ruta_gen_debito']) ? trim($rows['ruta_gen_debito']) : null,
            ]);
        */
        } catch (\Exception $e) {
            // $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente );
            $this->errorTecnico = $e->getMessage();
            dd($this->errorTecnico);
        }
    }
    // la ruta tendra problema ? o se reemplaza con la ultima ? // la ultima!
    public function ruta_carga()
    {

        //dd($this->cod_carga_corp);
        try {
            return EaCabeceraDetalleCarga::where('cod_carga', $this->cod_carga_corp)->where('producto', $this->cab_subproducto)->first();
            //return EaCabeceraDetalleCarga::where('cod_carga', $this->cod_carga_corp)->where('producto', $this->id_subproducto)->where('cliente', $this->cliente)->get()->first();


        } catch (\Exception $e) {
            $this->errorTecnico = $e->getMessage();
        }
    }

    // Usada en generar()
    // extrae la ultima carga segun el cliente
    // cambios para solo tomar ID - pendiente
    // cambios para añadir opciones adicionales - pendiente
    public function is_carga_older($request)
    {
        if (isset($request['op_caracteristica_ba'])) {
            return EaDetalleDebito::where('subproducto_id', $this->id_subproducto)
            ->where('opciones', $request->op_caracteristica_ba)
            ->orderbydesc('id_carga')
            ->first();
        }

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

    public function __construct(string $cliente, string $producto, string $cod_carga_corp = null, string $sub_producto_id, $tipo_subproducto, $cab_subproducto)
    {
        $this->cliente = $cliente;
        $this->producto = $producto; //usanddo la desc
        $this->cab_subproducto = $cab_subproducto;
        $this->cod_carga_corp = $cod_carga_corp;
        $this->id_subproducto = $sub_producto_id;
        $this->tipo_subproducto = $tipo_subproducto;
        $this->collection = null;
    }
}
