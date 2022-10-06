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
use App\Http\Controllers\EaDetalleCargaCorpController;
use App\Http\Controllers\EaDetalleDebitoController;
use App\Models\EaDetalleDebito;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EaCancelacionMasivaImport implements ToCollection, WithValidation, WithHeadingRow, WithStartRow
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

        \Log::info('inside colleccion IMPORT class EaCancelacionMasivaImport');
        $obj_base_activa = (new EaBaseActivaController);
        $obj_det_carga_corp = (new EaDetalleCargaCorpController);
        $registros_duplicados = array();
        $registros_archivos = array();
        foreach ($rows as $row) {
            !empty($row['nombre_completo']) ? $this->total_registros_archivo++ : '';
            if (!empty($row['nombre_completo']) && !empty($row['cedula']) ) {
                $registros_archivos['cedula'] = $row['cedula'];
                array_push($registros_duplicados,  $registros_archivos);
                $existe =  $obj_base_activa->valida_resgistro_base_activa($this->cliente, $row['cedula'], $this->producto);
                if (isset($existe)) {
                    $disponible_gestion = 'S';
                    $this->total_registros_disponibles_gestion++;
                    //esto es en la version de la tabla temporal 
                    $reg_duplicado = $obj_det_carga_corp->existe_registro($this->cod_carga, $this->cliente, $row['cedula']);
                    // en caso de existir eliminar
                    if (!$reg_duplicado) {
                        try {
                            EaDetalleCargaCorp::create([
                                'cod_carga' => isset($this->cod_carga)  ? $this->cod_carga : '',
                                'cliente' => isset($this->cliente) ? trim($this->cliente) : '',
                                'ordinal' => isset($row['ordinal']) ? trim($row['ordinal']) : null,
                                'nombre_completo' => isset($row['nombre_completo']) ? $row['nombre_completo'] : '',
                                'cedula_id' => isset($row['cedula']) ? trim($row['cedula']) : null,
                                'genero' => isset($row['genero']) ? $row['genero'] : null,
                                'email' => isset($row['email']) ? $row['email'] : null,
                                'telefono1' => isset($row['telf1']) ? $row['telf1'] : '',
                                'telefono2' => isset($row['telf2']) ? $row['telf2'] : '',
                                'telefono3' => isset($row['telf3']) ? $row['telf3'] : '',
                                'telefono4' => isset($row['telf4']) ? $row['telf4'] : '',
                                'telefono5' => isset($row['telf5']) ? $row['telf5'] : '',
                                'telefono6' => isset($row['telf6']) ? $row['telf6'] : '',
                                'telefono7' => isset($row['telf7']) ? $row['telf7'] : '',
                                'ciudad' => isset($row['ciudad']) ? trim($row['ciudad']) : '',
                                'tipo_de_tarjeta' => isset($row['tipo_de_tarjeta']) ? strtoupper(trim($row['tipo_de_tarjeta'])) : '',
                                'estado' => 'PROCESADO',
                                'disponible_gestion' => isset($disponible_gestion) ? $disponible_gestion : 'N',
                                'fec_carga' => Date('d/m/Y H:i:s'),
                            ]);
                        } catch (\Exception $e) {
                            $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente);
                            $this->errorTecnico = $e->getMessage();
                        }
                    } else {
                        
                        $this->total_registros_duplicados++;
                    }
                } else {

                    $this->total_registros_gestionados_otras_campanas++;
                }
            } else {

                if (!empty($row['ordinal'])) {

                    $this->total_registros_sin_infor++;

                    $linea['nombre_completo'] =  isset($row['nombre_completo']) ? $row['nombre_completo'] : '';
                    $linea['cedula_id'] =  isset($row['cedula']) ? $row['cedula'] : '';
                    $linea['telefono1'] =  isset($row['telf1']) ? $row['telf1'] : '';
                    $linea['telefono2'] =  isset($row['telf2']) ? $row['telf2'] : '';
                    $linea['telefono3'] =  isset($row['telf3']) ? $row['telf3'] : '';
                    $linea['telefono4'] =  isset($row['telf4']) ? $row['telf4'] : '';
                    $linea['telefono5'] =  isset($row['telf5']) ? $row['telf5'] : '';
                    $linea['telefono6'] =  isset($row['telf6']) ? $row['telf6'] : '';
                    $linea['telefono7'] =  isset($row['telf7']) ? $row['telf7'] : '';

                    array_push($this->registros_no_cumplen, $linea);
                    $linea = null;
                }
            }
        }

        $this->detalle_proceso['errorTecnico'] = $this->errorTecnico;
        $this->detalle_proceso['total_registros_archivo'] = $this->total_registros_archivo;
        $this->detalle_proceso['total_registros_disponibles_gestion'] = $this->total_registros_disponibles_gestion;
        $this->detalle_proceso['total_registros_gestionados_otras_campanas'] = $this->total_registros_gestionados_otras_campanas;
        $this->detalle_proceso['registros_no_cumplen'] = $this->registros_no_cumplen;
        $this->detalle_proceso['total_registros_duplicados'] = $this->total_registros_duplicados;
        $this->detalle_proceso['total_registros_sin_infor'] = $this->total_registros_sin_infor;
        // correcciones para SGV , aumentar un campo que inserte los valores que retorna esta colleccion, o en su defecto donde llama validar
        // que se este realizando el insert 
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
        $this->total_registros_archivo = 0;
        $this->total_registros_gestionados_otras_campanas = 0;
        $this->total_registros_disponibles_gestion = 0;
        $this->total_registros_sin_infor = 0;
        $this->total_registros_duplicados = 0;
        $this->errorTecnico = '';
        $this->detalle_proceso = array();
        $this->registros_no_cumplen = array();
    }
}
