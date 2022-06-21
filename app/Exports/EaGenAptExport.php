<?php

namespace App\Exports;

use App\Models\EaBaseActiva;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class EaGenAptExport implements FromView, ShouldAutoSize
{

    use Exportable;

    public function view(): View
    {

        if ( !empty($this->producto) ) {

            return view('genapt.detalle', [

                'dataExport' => EaBaseActiva::where('cliente', $this->cliente )
                                            ->where('cod_carga_corp', $this->cod_carga_corp)
                                            ->where('producto', $this->producto)
                                            ->where('estado_proceso', 1)
                                            ->where('estado', 'A')
                                            //->take(10)
                                            ->get()

            ]);


        } else {

            return view('genapt.detalle', [

                'dataExport' => EaBaseActiva::where('cliente', $this->cliente )
                                            ->where('cod_carga_corp', $this->cod_carga_corp)
                                            ->where('estado_proceso', 1)
                                            ->where('estado', 'A')
                                            //->take(10)
                                            ->get()

            ]);

        }
    }


    public function __construct ( string $cliente, string $cod_carga_corp, string $producto ){

        $this->cliente = $cliente;
        $this->cod_carga_corp = $cod_carga_corp;
        $this->producto = $producto;
    }


}
