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
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

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
        //$value_field = Crypto::decrypt($value_field, $clave);
        $registros_duplicados = array();
        $registros_archivos = array();
        $datos_subproductos = $obj_subproducto->getSubproductoDetalle($this->cliente, $this->producto);
        $datos_subproductos->desc_subproducto; // subproducto - base activa
        $inner_tables_ba_det = null;
        $op_client = EaOpcionesCargaCliente::where('cliente', $this->cliente)->where('subproducto', $this->producto)->first();
        $opciones_validacion = null;
        $opciones_import = null;

        if (isset($op_client->opciones_validacion) && isset($op_client->campos_import)) {
            $opciones_import = json_decode($op_client->campos_import, true);
            $opciones_validacion = json_decode($op_client->opciones_validacion, true);
        } else {
            dd("Error no existe configuracion en base para realizar esta operacion ");
        }

        //$inner_tables_ba_det = $this->merge_inner_import($datos_subproductos);
        //dd(($inner_tables_ba_det));

        if (isset($opciones_import[$opciones_validacion['identificador_secuencia']])) {
            if ($opciones_validacion['identificador_secuencia'] == "cuenta" || $opciones_validacion['identificador_secuencia'] == "tarjeta") {
                //$inner_tables_ba_det = $this->merge_inner_import('cuenta'); //para bolivariano
                $inner_tables_ba_det = $this->merge_inner_import($opciones_validacion['identificador_secuencia']);
                //dd(($inner_tables_ba_det));
            }
        }
        foreach ($rows as $row) {
            if (isset($row[$opciones_import[$opciones_validacion['identificador_secuencia']]])) {

                $updateRow = array();
                if (isset($opciones_import['num_validacion'])) {

                    for ($i = 1; $i <= $opciones_import['num_validacion']; $i++) {
                        if ($row($opciones_import['validacion_campo_' . $i]) != $opciones_import['validacion_campo_' . $i]) {
                            dd("validacion invalida , class EaGemCamImport.php - linea 69 ");
                        }
                    }
                }

                if (isset($opciones_validacion['identificador_secuencia'])) {
                    if ($opciones_validacion['identificador_secuencia'] == "cuenta" || $opciones_validacion['identificador_secuencia'] == "tarjeta") {
                        $id_detalle = null;

                        foreach ($inner_tables_ba_det as $indet) {
                            // dejado para que se pueda añadir una condicion posiblemente que incluya otro campo de la base activa

                            if ($row[$opciones_import[$opciones_validacion['identificador_secuencia']]] == $indet[$opciones_validacion['identificador_secuencia']]) {
                                $id_detalle = $indet['id_detalle']; //
                                unset($indet);
                                break;
                            }
                        }
                        //echo "salio de for";
                        //$updateRow['id_detalle'] = $id_detalle;
                        //echo $opciones_import['fecha_actualizacion'];
                        //echo date('Y-m-d', '2022-02-16');
                        //dd($row);
                        $actualdate = date('Y-m-d');
                        $input = (isset($row[$opciones_import['fecha_actualizacion']])) ? $row[$opciones_import['fecha_actualizacion']] : $actualdate;
                        $date = date('Y-m-d', strtotime($input));
                        $updateRow['fecha_actualizacion'] =  $date;
                        //dd($updateRow['fecha_actualizacion']);
                        $updateRow['valor_debitado'] = isset($row[$opciones_import['valor_debitado']]) ? $row[$opciones_import['valor_debitado']] : $datos_subproductos->valortotal;
                        $updateRow['detalle'] = isset($row[$opciones_import['detalle']]) ? $row[$opciones_import['detalle']] : '';
                        $cont = 0;
                        // si es booleano true , de una fecha que venga , o similar , por ejemplo que el campo error tenga null 
                        // "true"
                        // terminar esto antes del 28

                        for ($p = 0; $p < ($opciones_validacion['num_validacion']); $p++) {

                            if ($row[$opciones_validacion['validacion_campo_' . ($p+1)]] == $opciones_validacion['validacion_valor_' . ($p+1)]) {
                                $cont++;
                            }
                        }

                        if ($cont == $opciones_validacion['num_validacion']) {
                            $updateRow['estado'] = '1';
                        } else {
                            $updateRow['estado'] = '0';
                        }
                        //dd($updateRow['estado']);
                        $existe =  $obj_detalle_debito->update_debit_detail_join_BA($id_detalle, $updateRow);
                        $this->condicio_1 = "Se actualizo correctamente";
                    } elseif ($opciones_validacion['identificador_secuencia'] == "secuencia" || $opciones_validacion['identificador_secuencia'] == "cedula_id") {
                        #el modo normal puede usar lo mismo y hago una condicion en el metodo de si es cedula_id , o secuencia
                        $updateRow['secuencia'] = $row[$opciones_import[$opciones_validacion['identificador_secuencia']]]; // cedula - secuencia
                        $updateRow['fecha_actualizacion'] = isset($row[$opciones_import['fecha_actualizacion']]) ? date('Y-m-d', $row[$opciones_import['fecha_actualizacion']]) : date('Y-m-d');
                        //2022-08-04  date('Y-m-d', $date);
                        //sacar el valor total del subproducto
                        $updateRow['valor_debitado'] = isset($row[$opciones_import['valor_debitado']]) ? $row[$opciones_import['valor_debitado']] : $datos_subproductos->valortotal;
                        $updateRow['detalle'] = isset($row[$opciones_import['detalle']]) ? $row[$opciones_import['detalle']] : '';
                        $cont = 0;
                        for ($p = 0; $p < ($opciones_validacion['num_validacion']); $p++) {
                            if ($row[$opciones_validacion['validacion_campo_' . $p]] == $opciones_validacion['validacion_valor_1' . $p]) {
                                $cont++;
                            }
                        }
                        if ($cont == $opciones_validacion['num_validacion']) {
                            $updateRow['estado'] = '1';
                        } else {
                            $updateRow['estado'] = '0';
                        }
                        $existe =  $obj_detalle_debito->update_debit_detail($this->cod_carga, $this->cliente, $this->producto, $updateRow);
                    } else {
                        dd("error validando el indentificador o no se encuentra base");
                    }
                } else {
                    dd("No se encuentra configurado los campos que resciben la respuestas del banco , para este subproducto");
                }
            }
        }


        $this->detalle_proceso['valido'] = $this->condicio_1;//falta poner el mensaje
        $this->detalle_proceso['vacio'] = $this->condicion_2;
        $this->detalle_proceso['error_insertar'] = $this->err_insert;
        $this->detalle_proceso['error_validacion'] =  $this->err_validacion;//faLta poner mensaje
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
    public function merge_inner_import($datos_subproductos)
    {
        //dd($datos_subproductos->tipo_subproducto);
        $merge_inner_import =  EaDetalleDebito::join("ea_base_activa", "ea_base_activa.id_sec", "=", "ea_detalle_debito.id_sec")
            ->select(
                'ea_detalle_debito.id_detalle',
                'ea_detalle_debito.secuencia',
                'ea_base_activa.id_sec',
                'ea_detalle_debito.id_carga',
                'ea_base_activa.cedula_id',
                'ea_base_activa.cuenta',
                'ea_base_activa.tarjeta',
            )
            ->where('ea_detalle_debito.id_carga', $this->cod_carga)
            ->where('ea_detalle_debito.cliente', $this->cliente)
            ->where('ea_detalle_debito.subproducto_id', $this->producto)->orderby('ea_detalle_debito.secuencia')
            ->get();

        $contenido = file_get_contents("../salsa.txt");
        $clave = Key::loadFromAsciiSafeString($contenido);

        //bloque para descomentar luego de pruenbas con datos erroneos en bolivariano.
        // BOLIVARIANO TC , no tiene dato en TC evaluar o corregir luego , no se que tiene los datos 
        // recordar la base de datos en una copia de la que existe en produccion, o existe otros datos
        foreach ($merge_inner_import as $row) {
            //dd(strlen($row[$datos_subproductos]));
            if (strlen($row[$datos_subproductos]) <= 20) {
                dd("  no esta encriptado o existe registro -- linea 202 EaGemCamImport --MSG desa");
            }
            $value_field = Crypto::decrypt($row[$datos_subproductos], $clave);
            $row[$datos_subproductos] = $value_field;
        }


        /*   foreach ($merge_inner_import as $row) {
            if ($datos_subproductos->tipo_subproducto == "TC") {
                if (count($row['tarjeta']) <= 20) {
                    dd("  no esta encriptado o existe registro -- linea 198 EaGemCamImport --MSG desa");
                }
                $value_field = Crypto::decrypt($row['tarjeta'], $clave);
                $row['tarjeta'] = $value_field;
            } elseif ($datos_subproductos->tipo_subproducto == "CTAS") {
                if (count($row['cuenta']) <= 20) {
                    dd("  no esta encriptado o existe registro -- linea 198 EaGemCamImport --MSG desa");
                }
                $value_field = Crypto::decrypt($row['cuenta'], $clave);
                $row['cuenta'] = $value_field;
            } else {
                dd("existe un error metodo merge_inner_import");
            }
        }
        */


        return $merge_inner_import;
    }
}
