<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\EaCabeceraCargaCorp;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class EaReporteCargaInicialExport implements FromView, ShouldAutoSize
{


    use Exportable;

    public function view(): View
    {
        return view ('cargaInicial.reporteCargaIni', [
            'dataExport' =>  EaCabeceraCargaCorp::where('cod_carga', $this->cod_carga)
                                                ->where('proceso', $this->proceso)
                                                ->get()
        ]);

    }




    public function __construct(string $cod_carga, string $proceso){

       $this->cod_carga = $cod_carga;
       $this->proceso = $proceso;
    }


}
