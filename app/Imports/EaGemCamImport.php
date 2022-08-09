<?php

namespace App\Imports;

use App\Models\EaDetalleCargaCorp;
use App\Models\EaOpcionesCargaCliente;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Http\Controllers\EaBaseActivaController;
use App\Http\Controllers\EaSubproductoController;
use App\Http\Controllers\EaDetalleDebitoController;
use App\Models\EaDetalleDebito;

class EaGemCamImport implements ToCollection, WithValidation, WithHeadingRow
{
    use Importable, SkipsErrors;
    /**
     * @param array $row
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Model|null
     *  custom code -- field name (extract to subproduct, if case  )
     * //0 no existe 1 toma el string , 2 toma la posicion(celda excel experimental) , 2 toma la posicion(caracteres que se tiene que saltar) 
     */

    public function collection(Collection $rows)
    {
         \Log::info('inside colleccion IMPORT class EaGemCamImport');
        // \Log::warning('Something could be going wrong.');
        // \Log::error('Something is really going wrong.');
        $obj_detalle_debito = (new EaDetalleDebitoController);
        $obj_subproducto = (new EaSubproductoController);
        $obj_det_carga_corp = (new EaDetalleDebitoController);
        $registros_duplicados = array();
        $registros_archivos = array();
        $datos_subproductos = $obj_subproducto->getSubproductoDetalle($this->cliente, $this->producto);
        $op_client = EaOpcionesCargaCliente::where('cliente', $this->cliente)->where('subproducto', $this->producto)->first();
        $opciones_validacion = json_decode($op_client->opciones_validacion, true);
        //$datos_validacion = EaOpcionesCargaCliente::where();{"validacion_campo_1":"Establecimiento","validacion_valor_1":"873134"}
        foreach ($rows as $row) {
            if (is_null($row['vale']) != 1) {
                //bloque condiciones
                //echo $opciones_validacion["validacion_campo_1"];
                //dd([strtolower($opciones_validacion['validacion_valor_' . (0 + 1)])]);

                //bloque validaciones
                if (is_null($opciones_validacion) != 1 || $opciones_validacion != '') {
                    $this->condicion_3 = 0;
                    // echo ($row[strtolower($opciones_validacion['validacion_campo_' . (1)])]);
                    //dd(strtolower($opciones_validacion['validacion_valor_' . (1)]));
                    for ($i = 0; $i < (count($opciones_validacion) / 2); $i++) {
                        if ($row[strtolower($opciones_validacion['validacion_campo_' . ($i + 1)])]  == strtolower($opciones_validacion['validacion_valor_' . ($i + 1)])) {

                            $this->condicion_3++;
                            //dd($this->condicion_3);
                        }
                    }
                    $this->condicio_1++;
                    //echo 'condicion 3 :'.$this->condicion_3;
                    //echo '--------- ';
                    //echo '(count($opciones_validacion) / 2) : '.(count($opciones_validacion) / 2);
                    if ($this->condicion_3 == (count($opciones_validacion) / 2)) {
                        // echo 'usuario o row : ' . $this->condicio_1;
                        // echo 'cumple expectativa de condicion ';
                        $this->cumple_validacion = 1;
                    } else {
                        $this->cumple_validacion = 0;
                        $this->condicion_4++;
                    }
                    ////////
                    //bloque INTER TC -- solo para internacional credito
                    //dd($datos_subproductos);
                    if ($datos_subproductos->cliente == 'INTER' && $datos_subproductos->tipo_subproducto == 'TC') {
                        if (is_null($row['fecha_autorizacion']) == 1) {
                            $row['total'] = null;
                            $row['estado'] = 0;
                        } else {
                            //dd($row['descripcion']);
                            if ($row['descripcion'] == "PROCESO OK") {
                                $row['estado'] = 1;
                            } else {
                                $row['estado'] = 0;
                            }
                        }
                    }
                    //echo  'estado : ' . $row['estado'];

                    //
                    if ($this->cumple_validacion == 1) {
                        //echo  '$this->cumple_validacion : ' . $this->cumple_validacion;
                        try {

                            $existe =  $obj_detalle_debito->valida_resgistro_detalle_debito_INTER_TC($this->cod_carga, $this->cliente, $this->producto, intval($row['vale']), $row);
                            
                        } catch (\Throwable $th) {
                            $this->err_insert++;
                            //$this->errorTecnico_1 = 'Error Insertando datos';
                            $this->errorTecnico_1 = 'ERROR';
                        }
                    } else {
                        $this->err_validacion++;
                        $this->errorTecnico_1 = 'ERROR';
                        //$this->errorTecnico_1 = 'Error en las validaciones';
                    }
                } else {
                    //echo 'no valida';
                    //no hay validaciones 
                    $existe =  $obj_detalle_debito->valida_resgistro_detalle_debito_INTER_TC($this->cod_carga, $this->cliente, $this->producto, intval($row['vale']), $row);
                }
            } else {
                $this->condicion_2++;
            }
        }
        $this->detalle_proceso['valido'] = $this->condicio_1;
        $this->detalle_proceso['vacio'] = $this->condicion_2;
        $this->detalle_proceso['error_insertar'] = $this->err_insert;
        $this->detalle_proceso['error_validacion'] =  $this->err_validacion;
        $this->detalle_proceso['error_msg'] = $this->errorTecnico_1;
        $this->detalle_proceso['condicion_validacion'] = $this->condicion_3;
        return $this->detalle_proceso;
    }


    public function rules(): array
    {
        return [
            '*.0' => ['ordinal', 'unique:ea_detalle_carga_corp,ordinal']
        ];
    }



    // producto = Es el ID de subproducto
    public function __construct(int $cod_carga, string $cliente, string $producto)
    {
        $this->cliente = $cliente;
        $this->cod_carga = $cod_carga;
        $this->producto = $producto;
        $this->condicio_1 = 0;
        $this->condicion_2 = 0;
        $this->condicion_3 = 0;
        $this->condicion_4 = 0;
        $this->err_insert = 0;
        $this->err_validacion = 0;
        $this->cumple_validacion = 0;
        $this->errorTecnico_1 = '';
        $this->detalle_proceso = array();
    }
}
/*


