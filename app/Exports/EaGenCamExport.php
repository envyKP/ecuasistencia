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
    public function generar()
    {

        if (!isset($this->cliente)) {
            $this->cliente = "";
        }

        $detalles = $this->is_carga_older();

        $generar_return = null;
        //en caso que exista algo que no se incluya en las consultas
        switch ($this->cliente) {
            case 'disable':

                break;


            default:
                $fecha_generacion = (isset($detalles->fecha_generacion) ? $detalles->fecha_generacion : 0);
                if (($fecha_generacion) == date('mY')) {
                    // echo ($detalles->fecha_generacion) . ($detalles->id_sec) . " se encuentra dentro del mes";
                    $carga_secuencia = "";
                    if (isset($this->cod_carga_corp)) {
                        $carga_secuencia = $this->cod_carga_corp;
                    } else {
                        $carga_secuencia = $detalles->id_carga;
                    }
                    $this->cod_carga_corp = $carga_secuencia;

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
                    } else {
                        dd('Error interno porfavor cominiquese con soporte.');
                    }
                } else {
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
                            ->where('desc_subproducto', $this->producto)
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
                            ->where('desc_subproducto', $this->producto)
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
                        dd('Error interno porfavor cominiquese con soporte.');
                    }
                }
                //dd($generar_return);
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
        //MODIFICAR EN EL FUTURO LA TABLA QUE SE DEBE INSERTAR O CREAR UN ALTER ESPÉCIFICO PARA PRODUBANCO DEBIDO A QUE ESTE NO CUENTA CON EL CAMPO SECUENCIA
        //dd($rows);
        try {
            //optimizar insert block
            /* $row_insert_detalle = array();
            $data =
                array('id_sec' => '448487', 'id_carga' => '777');
            array_push($row_insert_detalle, $data);

            EaDetalleDebito::insert($row_insert_detalle);
            dd($rows);
            */
            EaDetalleDebito::insert($rows); // Eloquent approach
            //DB::table('table')->insert($data); /
            //  old block
            /*EaDetalleDebito::create([
                'id_carga' => isset($rows['id_carga']) ? $rows['id_carga'] + 1 : null,
                'id_sec' => isset($rows['id_sec']) ? trim($rows['id_sec']) : null,
                'secuencia' => isset($rows['secuencia']) ? trim($rows['secuencia']) : null,
                'fecha_registro' => isset($rows['fecha_registro']) ? trim($rows['fecha_registro']) : null,
                'cliente' => isset($this->cliente) ? trim($this->cliente) : '',
                'estado' => '0',
                'fecha_generacion' => isset($rows['fecha_generacion']) ? trim($rows['fecha_generacion']) : null,
                'subproducto_id' => isset($this->id_subproducto) ? trim($this->id_subproducto) : '',
            ]);
            */
        } catch (\Exception $e) {
            dd("error fatal:" . $e->getMessage());
            \Log::warning('error view_reg_state:  ' . $e);
            // $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente );
            $this->errorTecnico = $e->getMessage();
        }
    }

    public function destroy_cab_detalle($cod_carga, $cliente, $producto)
    {
        \Log::warning('funcion destroy_cab_detalle class EaGenCamExport by user ' . \Auth::user()->username);
        try {
            \Log::warning('EaDetalleDebito::where(id_carga,' . $cod_carga . ')->where(cliente, ' . $cliente . ')
            ->where(subproducto_id, ' . $producto . ')
            ->delete();');

            EaDetalleDebito::where('id_carga', $cod_carga)
                ->where('cliente', $cliente)
                ->where('subproducto_id', $producto)
                ->delete();

            \Log::warning('EaDetalleDebito::where(id_carga,' . $cod_carga . ')->where(cliente, ' . $cliente . ')
            ->where(subproducto_id, ' . $producto . ')
            ->delete();');

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
        //iniciaria aki un bloque de condiciones que permitiran consultar el json de validaciones aki antes de realizar la consulta.
        // debido a que es nescesario cambiar o dar valor a los campos del export

        //ejemplo de implementacion 
        /*
        $temporal = null;
        if($this->tipo_subproducto=='CTAS'){
            $temporal='ea_base_activa.cuenta';
        }elseif($this->tipo_subproducto='TC'){
            $temporal='ea_base_activa.tarjeta';
        }

        $this->collection =  EaBaseActiva::join("ea_detalle_debito", "ea_detalle_debito.id_sec", "=", "ea_base_activa.id_sec")
            ->select(
                'ea_base_activa.cedula_id',
                'ea_base_activa.nombre',
                'ea_base_activa.direccion',
                'ea_base_activa.mail',
                
                'ea_detalle_debito.fecha_actualizacion',
                'ea_detalle_debito.valor_debitado'
            )
            ->where('ea_detalle_debito.subproducto_id', $this->id_subproducto)
            ->where('ea_detalle_debito.id_carga', $this->cod_carga_corp)
            ->where('ea_base_activa.cliente', $this->cliente)
            ->where('ea_detalle_debito.estado', '1')
            ->orderby('ea_base_activa.cedula_id')
            ->get();

         */
        /**EaBaseActiva::raw("'S/N' as 'Dirección Cliente'"),
                EaBaseActiva::raw("'S/N' as 'Correo Cliente'"),
                EaBaseActiva::raw("'0' as 'Cta / TC'"), */

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
            if (isset($opciones_factura['pagos'])) {

                if ($this->tipo_subproducto == 'CTAS') {
                    $temporal3 = 'ea_base_activa.cuenta';                    
                } elseif ($this->tipo_subproducto = 'TC') {
                    $temporal3 = 'ea_base_activa.tarjeta';
                }
            } else {
                $temporal3 = EaBaseActiva::raw("'0' as 'Cta / TC'");
            }
        } else {
            $temporal = EaBaseActiva::raw("'S/N' as 'Dirección Cliente'");
            $temporal2 = EaBaseActiva::raw("'S/N' as 'Correo Cliente'");
            $temporal3 = EaBaseActiva::raw("'0' as 'Cta / TC'");
        }
        //$temporal3 = 'ea_base_activa.cuenta';
        //$this->tipo_subproducto = 'CTAS';
    
        //dd($temporal);
        $this->collection =  EaBaseActiva::join("ea_detalle_debito", "ea_detalle_debito.id_sec", "=", "ea_base_activa.id_sec")
            ->select(
                'ea_base_activa.cedula_id',
                'ea_base_activa.nombre',
                $temporal,
                $temporal2,
                $temporal3,
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
            //en caso de error al parsear la fecha
           if ($temporal3 != EaBaseActiva::raw("'0' as 'Cta / TC'")) {
                $value_field = Crypto::decrypt($individual[$this->tipo_subproducto == 'TC' ? 'tarjeta' : 'cuenta'], $clave);
                $individual[$this->tipo_subproducto == 'TC' ? 'tarjeta' : 'cuenta'] = $value_field;
           }
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
