<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\EaCabeceraCargaCorp;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\EaBaseActiva;
use App\Models\EaSubproducto;
use App\Models\EaDetalleCargaCorp;
use App\Models\EaCabeceraDetalleCarga;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\EaOpcionesCargaCliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
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

Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

class EaReporteCancelacionMasiva extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithEvents, FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithCustomValueBinder
{
    use Exportable;
    public function view(): View
    {
        return view('EaCancelacionMasivaController.reporteCargaIni', [
            'dataExport' =>  EaCabeceraCargaCorp::where('cod_carga', $this->cod_carga)
                ->where('proceso', $this->proceso)
                ->get()
        ]);
    }


    public function collection()
    {

        $this->collection =  EaDetalleCargaCorp::where('cod_carga', $this->cod_carga)
            ->where('estado', 'INTERRUPCION')
            ->where('disponible_gestion', 'N')
            ->select(
                'cedula_id',
                'nombre_completo',
            )
            ->get();

        return $this->collection;
    }


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
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
        ];
    }
    public function headings(): array
    {
        return ["CEDULA", "NOMBRE"];
    }





    public function __construct(string $cod_carga, string $proceso)
    {
        $this->cod_carga = $cod_carga;
        $this->proceso = $proceso;
        $this->collection = null;
    }
}
