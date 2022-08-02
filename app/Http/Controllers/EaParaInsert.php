<?php

namespace App\Http\Controllers;

//use Lorisleiva\Actions\Concerns\AsAction;
//composer require lorisleiva/laravel-actions

use App\Exports\EaGenCamExport;
use App\Models\EaSubproducto;
use App\Models\EaDetalleDebito;
use App\Models\EaCabeceraDetalleCarga;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;

class EaParaInsert 
{
    /*
    use AsAction;
    
    
    public function handle($objEXPORT, array $rows, bool $fullReport = false): void
    {
           try {

            EaDetalleDebito::create([
                'id_carga' => isset($rows['id_carga']) ? $rows['id_carga'] + 1 : null,
                'id_sec' => isset($rows['id_sec']) ? trim($rows['id_sec']) : null,
                'secuencia' => isset($rows['secuencia']) ? trim($rows['secuencia']) : null,
                'fecha_actualizacion' => isset($rows['fecha_actualizacion']) ? $rows['fecha_actualizacion'] : '',
                'fecha_registro' => isset($rows['fecha_registro']) ? trim($rows['fecha_registro']) : null,
                'producto' => isset($rows['producto']) ? trim($rows['producto']) : '',
                'subproducto' => isset($rows['subproducto']) ? trim($rows['subproducto']) : '',
                'cliente' => isset($rows['cliente']) ? trim($rows['cliente']) : '',
                'estado' => '0',
                'fecha_generacion' => isset($rows['fecha_generacion']) ? trim($rows['fecha_generacion']) : null,
            ]);
        } catch (\Exception $e) {
            //$obj_det_carga_corp->truncate($this->cod_carga, $this->cliente );
            // $this->errorTecnico = $e->getMessage();
        }
       
       // $objEXPORT->view_reg_state( $rows);
    }
    public function asJob(EaGenCamExport $objEXPORT ,array $rows): void
    {
        $this->handle($objEXPORT,$rows, true);
    }
    
*/

}
