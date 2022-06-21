<?php

namespace App\Exports;

use App\Models\EaBaseActiva;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class EaSinInforFinancieraExport implements FromView, ShouldAutoSize
{

    use Exportable;

    public function view(): View
    {

        return view ('recaif.reporte', [

           'dataExport' => EaBaseActiva::where('cod_carga_corp', $this->cod_carga_corp)
                                       ->where('estado', 'Z')
                                       ->where('observaciones', "SIN INFORMACIÓN FINANCIERA")
                                       ->get()

        ]);
    }


    public function __construct( string $cod_carga_corp){

        $this->cod_carga_corp = $cod_carga_corp;

    }

}
