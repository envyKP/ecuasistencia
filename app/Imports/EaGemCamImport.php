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
     */

    public function collection(Collection $rows)
    {
        \Log::info('inside colleccion IMPORT class EaGemCamImport');

        $obj_detalle_debito = (new EaDetalleDebitoController);
        $obj_subproducto = (new EaSubproductoController);
        $obj_det_carga_corp = (new EaDetalleDebitoController);
        $registros_duplicados = array();
        $registros_archivos = array();
        $datos_subproductos = $obj_subproducto->getSubproductoDetalle($this->cliente, $this->producto);
        $op_client = EaOpcionesCargaCliente::where('cliente', $this->cliente)->where('subproducto', $this->producto)->first();
        $opciones_validacion = null;
        $opciones_import = null;
        if (isset($op_client->opciones_validacion) && isset($op_client->campos_import)) {
            $opciones_import = json_decode($op_client->campos_import, true);
            $opciones_validacion = json_decode($op_client->opciones_validacion, true);
        } else {
            dd("Error no existe configuracion en base para realizar esta operacion ");
        }
        //$datos_validacion = EaOpcionesCargaCliente::where();{"validacion_campo_1":"Establecimiento","validacion_valor_1":"873134"}

        foreach ($rows as $row) {

            // recorre todo el excel , tengo un campo validacion y el otro campo es el valor que viene desde el export
            //siempre tiene que estar el campo quemado 
            if (isset($row[$opciones_import[$opciones_validacion['identificador_secuencia']]])) {
                //if(isset(campor_identificacion[cedula_id ! tarjeta ! cuenta ! secuencia]) )
                /// se tiene que transforma los nombres de los campos pero como soluciono la confucion =? 
                //ok puede ser , identificador : "cedula_id"

                // op_validador{"identificador_secuencia":"cedula_id","validacion_campo_1":"Referencia_adicional","validacion_valor_1":"ESTUDIANTE SEGURO%"} -- estar en el validador
                // op_import{"cedula_id":"contrapartida","cuenta":"cuenta","estado":"1","estado_1":"estado","valor_debitado":"valor"}

                $updateRow = array();
                if (isset($op_validador['identificador_secuencia'])) {

                    if ($op_validador['identificador_secuencia'] == "cuenta" || $op_validador['identificador_secuencia'] == "tarjeta") {
                        //# experimental tarjeta-cuenta
                        #cifra el campo
                        #compara el campo
                        #si existe actualiza por el id_sec
                        #no salta no actualiza

                    } elseif ($op_validador['identificador_secuencia'] == "secuencia" || $op_validador['identificador_secuencia'] == "cedula_id") {
                        #el modo normal puede usar lo mismo y hago una condicion en el metodo de si es cedula_id , o secuencia
                        $updateRow['secuencia'] = $row[$opciones_import[$opciones_validacion['identificador_secuencia']]]; // cedula - secuencia

                        $updateRow['fecha_actualizacion'] = isset($row[$opciones_import['fecha_actualizacion']]) ? date('Y-m-d', $row[$opciones_import['fecha_actualizacion']]) : date('Y-m-d');
                        //2022-08-04  date('Y-m-d', $date);
                        //sacar el valor total del subproducto
                        $updateRow['valor_debitado'] = isset($row[$opciones_import['valor_debitado']]) ? $row[$opciones_import['valor_debitado']] : $datos_subproductos->valortotal;

                        $updateRow['detalle'] = isset($row[$opciones_import['detalle']]) ? $row[$opciones_import['detalle']] : '';

                        $existe =  $obj_detalle_debito->update_debit_detail($this->cod_carga, $this->cliente, $this->producto, $updateRow);
                    } else {
                        dd("error validando el indentificador o no se encuentra base");
                    }
                } else {
                    dd("No se encuentra configurado los campos que resciben la respuestas del banco , para este subproducto");
                }
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

                    if ($this->cumple_validacion == 1) {
                        //echo  '$this->cumple_validacion : ' . $this->cumple_validacion;
                        try {

                            $existe =  $obj_detalle_debito->update_debit_detail_INTER_TC($this->cod_carga, $this->cliente, $this->producto, intval($row['vale']), $row);
                            
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
                    $existe =  $obj_detalle_debito->update_debit_detail_INTER_TC($this->cod_carga, $this->cliente, $this->producto, intval($row['vale']), $row);
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

*/
