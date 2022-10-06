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
use Maatwebsite\Excel\Concerns\WithStartRow;

class EaGemCamImport implements ToCollection, WithValidation, WithHeadingRow, WithStartRow
{
    use Importable, SkipsErrors;

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }


    /**
     * @param array $row
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        // sobre la teoria no uso nada del subproduco 
        // todo se hace oo realiza sobre la de destalles
        \Log::info('inside colleccion IMPORT class EaGemCamImport');
        $obj_detalle_debito = (new EaDetalleDebitoController);
        $obj_subproducto = (new EaSubproductoController);
        $registros_duplicados = array();
        $registros_archivos = array();
        //$datos_subproductos = $obj_subproducto->getSubproductoDetalle($this->cliente, $this->producto);
        //$datos_subproductos->desc_subproducto; // subproducto - base activa
        $inner_tables_ba_det = null;
        $op_client = EaOpcionesCargaCliente::where('cliente', $this->cliente)->where('subproducto', $this->producto)->first();
        $opciones_validacion = null;
        $opciones_import = null;
        if (isset($op_client->opciones_validacion) && isset($op_client->campos_import)) {
            $opciones_import = json_decode($op_client->campos_import, true);
            //opcion que viene de la base , valida si existe el campo y en caso que no no pertenece al archivo
            $opciones_validacion = json_decode($op_client->opciones_validacion, true);
            //opciones de identificador secuencia influye en el import , y validacion en caso de cumplirse cambia estado debitado de 0 a 1
        } else {
            dd("Error no existe configuracion en base para realizar esta operacion ");
        }
        if (isset($opciones_import[$opciones_validacion['identificador_secuencia']])) {
            if ($opciones_validacion['identificador_secuencia'] == "cuenta" || $opciones_validacion['identificador_secuencia'] == "tarjeta") {
                $inner_tables_ba_det = $this->merge_inner_import($opciones_validacion['identificador_secuencia']); //
            }
        }
        foreach ($rows as $row) {
            if (isset($row[$opciones_import[$opciones_validacion['identificador_secuencia']]])) {
                $updateRow = array();
                if (isset($opciones_import['num_validacion'])) {
                    for ($i = 0; $i < $opciones_import['num_validacion']; $i++) {
                        if ($row[$opciones_import['validacion_campo_' . ($i + 1)]] != $opciones_import['validacion_valor_' . ($i + 1)]) {
                            //dd("validacion invalida , class EaGemCamImport.php - linea 69 ");
                            $this->detalle_proceso['msg'] = "No tiene los campos nescesarios para realizar la lectura del archivo de respuesta";
                            return $this->detalle_proceso;
                        }
                    }
                }

                if (isset($opciones_validacion['identificador_secuencia'])) {
                    if ($opciones_validacion['identificador_secuencia'] == "cuenta" || $opciones_validacion['identificador_secuencia'] == "tarjeta") {
                        $id_detalle = null;
                        foreach ($inner_tables_ba_det as $indet) {
                            if ($row[$opciones_import[$opciones_validacion['identificador_secuencia']]] == $indet[$opciones_validacion['identificador_secuencia']]) {
                                $id_detalle = $indet['id_detalle']; //
                                unset($indet);
                                break;
                            }
                        }
                        $actualdate = date('Y-m-d');
                        $input = (isset($row[$opciones_import['fecha_actualizacion']])) ? $row[$opciones_import['fecha_actualizacion']] : $actualdate;
                        $date = date('Y-m-d', strtotime($input));
                        $updateRow['fecha_actualizacion'] =  $date;
                        //dd($updateRow['fecha_actualizacion']);
                        //$updateRow['valor_debitado'] = isset($row[$opciones_import['valor_debitado']]) ? $row[$opciones_import['valor_debitado']] : $datos_subproductos->valortotal;
                        $updateRow['valor_debitado'] =  isset($row[$opciones_import['valor_debitado']]) ? $row[$opciones_import['valor_debitado']] : "BORRAR";
                        if ($updateRow['valor_debitado'] == "BORRAR") {
                            unset($updateRow['valor_debitado']);
                        }

                        $updateRow['detalle'] = isset($row[$opciones_import['detalle']]) ? $row[$opciones_import['detalle']] : '';
                        $cont = 0;
                        for ($p = 0; $p < ($opciones_validacion['num_validacion']); $p++) {
                            if ($opciones_validacion['validacion_valor_' . ($p + 1)] == "") {
                                if ($row[$opciones_validacion['validacion_campo_' . ($p + 1)]] != null) {
                                    $cont++;
                                }
                            } elseif ($row[$opciones_validacion['validacion_campo_' . ($p + 1)]] == $opciones_validacion['validacion_valor_' . ($p + 1)]) {
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
                        $this->msg = "completado exitosamente";
                    } elseif ($opciones_validacion['identificador_secuencia'] == "secuencia" || $opciones_validacion['identificador_secuencia'] == "cedula_id") {
                        $actualdate = date('Y-m-d');
                        $input = (isset($row[$opciones_import['fecha_actualizacion']])) ? $row[$opciones_import['fecha_actualizacion']] : $actualdate;
                        $date = date('Y-m-d', strtotime($input));
                        $updateRow['fecha_actualizacion'] =  $date;
                        // campo valor debitado 
                        // en generar , se implemento metodo de insertar el valor total 
                        /// realizar control en caso de que no este o no exista no deberia insertarse.
                        // usar unset() si eL valor del elemento es "BORRAR"
                        $updateRow['valor_debitado'] = isset($row[$opciones_import['valor_debitado']]) ? $row[$opciones_import['valor_debitado']] : "BORRAR";
                        if ($updateRow['valor_debitado'] == "BORRAR") {
                            unset($updateRow['valor_debitado']);
                        }

                        $updateRow['detalle'] = isset($row[$opciones_import['detalle']]) ? $row[$opciones_import['detalle']] : '';
                        $cont = 0;
                        for ($p = 0; $p < ($opciones_validacion['num_validacion']); $p++) {
                            if ($opciones_validacion['validacion_valor_' . ($p + 1)] == "") {
                                if ($row[$opciones_validacion['validacion_campo_' . ($p + 1)]] != null) {
                                    $cont++;
                                }
                            } elseif ($row[$opciones_validacion['validacion_campo_' . ($p + 1)]] == $opciones_validacion['validacion_valor_' . ($p + 1)]) {
                                $cont++;
                            }
                        }
                        if ($cont == $opciones_validacion['num_validacion']) {
                            $updateRow['estado'] = '1';
                        } else {
                            $updateRow['estado'] = '0';
                        }
                        $updateRow['secuencia'] = ltrim($row[$opciones_import[$opciones_validacion['identificador_secuencia']]], '0');
                        $existe =  $obj_detalle_debito->update_debit_detail($this->cod_carga, $this->cliente, $this->producto, $updateRow);
                        $this->msg = "completado exitosamente";
                    } else {
                        // dd("error validando el indentificador o no se encuentra base");
                        $this->detalle_proceso['msg'] = "error validando el indentificador o no se encuentra base";
                        return $this->detalle_proceso;
                    }
                } else {
                    //dd("No se encuentra configurado los campos que resciben la respuestas del banco , para este subproducto");
                    $this->detalle_proceso['msg'] = "No se encuentra configurado los campos que resciben la respuestas del banco , para este subproducto";
                    return $this->detalle_proceso;
                }
            }
        }
        $this->detalle_proceso['valido'] = $this->condicio_1; //falta poner el mensaje
        $this->detalle_proceso['vacio'] = $this->condicion_2;
        $this->detalle_proceso['error_insertar'] = $this->err_insert;
        $this->detalle_proceso['error_validacion'] =  $this->err_validacion; //faLta poner mensaje
        $this->detalle_proceso['msg'] = $this->msg;
        $this->detalle_proceso['condicion_validacion'] = $this->condicion_3;
        return $this->detalle_proceso;
    }


    public function rules(): array
    {
        return [
            '*.0' => ['ordinal', 'unique:ea_detalle_carga_corp,ordinal']
        ];
    }
    /**
     * 
     * Constructor de clase EaGemCamImport
     */
    public function __construct(int $cod_carga, string $cliente, string $producto, $request)
    {
        $this->cliente = $cliente;
        $this->cod_carga = $cod_carga;
        $this->producto = $producto;
        $this->condicio_1 = 0;
        $this->condicion_2 = 0;
        $this->condicion_3 = 0;
        $this->condicion_4 = 0; // No usado 
        $this->condicion_3 = 0;
        $this->err_validacion = 0;
        $this->cumple_validacion = 0; //no usado
        $this->msg = '';
        $this->detalle_proceso = array();
        if (isset($request['opciones_data'])) {
        }
    }


    /**
     * bloque que consulta 1 sola ves los valores de cuenta o tarjeta dependiendo de la configuracion
     * que es dada por el parametro $datos_subproductos
     * Deberia crear una lista de tarjetas o cuentas desencriptadas.
     */
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
                abort(404, "error en datos encriptado" . $row[$datos_subproductos]);
                dd("  no esta encriptado o existe registro -- linea 202 EaGemCamImport --MSG desa");
            }
            $value_field = Crypto::decrypt($row[$datos_subproductos], $clave);
            $row[$datos_subproductos] = $value_field;
        }
        return $merge_inner_import;
    }

    //metodo provicional para transformacion de texto,// descartado por consulta recurrentes
    /*
    function importTXT(){
        $op_client = EaOpcionesCargaCliente::where('cliente', $this->cliente)->where('subproducto', $this->producto)->first();
        $opciones_validacion = null;
        $opciones_import = null;
        if (isset($op_client->opciones_validacion) && isset($op_client->campos_import)) {
            $opciones_import = json_decode($op_client->campos_import, true);
            //opcion que viene de la base , valida si existe el campo y en caso que no no pertenece al archivo
            $opciones_validacion = json_decode($op_client->opciones_validacion, true);
            //opciones de identificador secuencia influye en el import , y validacion en caso de cumplirse cambia estado debitado de 0 a 1
        } else {
            dd("Error no existe configuracion en base para realizar esta operacion ");
        }
    }
    */
}
