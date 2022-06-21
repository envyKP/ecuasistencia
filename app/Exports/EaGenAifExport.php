<?php

namespace App\Exports;

use App\Models\EaBaseActiva;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class EaGenAifExport implements FromView, ShouldAutoSize
{


    use Exportable;


    public function view(): View
    {

        if ( !empty($this->producto) ) {

            #code...
            return view('genaif.detalle', [

                'dataExport' => EaBaseActiva::where('cliente', $this->cliente )
                                            ->where('estado_proceso', 3)
                                            ->where('producto', $this->producto)
                                            ->where('cod_carga_corp', $this->cod_carga_corp)
                                            ->where('tipresp', '1')
                                            ->where('codresp', '100')
                                            ->where('detresp', 'ACEPTA SERVICIO')
                                            ->where('estado', 'Z')
                                            ->get()

            ]);

        }else {

             #code...
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


    public function __construct ( string $cliente, string $cod_carga_corp, string $producto )
    {

        $this->cliente = $cliente;
        $this->cod_carga_corp = $cod_carga_corp;
        $this->producto = $producto;
    }


}
