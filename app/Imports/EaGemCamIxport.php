<?php

namespace App\Imports;

use App\Models\EaDetalleCargaCorp;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Http\Controllers\EaBaseActivaController;
use App\Http\Controllers\EaDetalleCargaCorpController;

class EaGemCamIxport implements ToCollection, WithValidation, WithHeadingRow
{
    use Importable, SkipsErrors;
    /**
     * @param array $row
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function collection(Collection $rows)
    {

        $obj_base_activa = (new EaBaseActivaController);
        $obj_det_carga_corp = (new EaDetalleCargaCorpController);
        $registros_duplicados = array();
        $registros_archivos = array();

        foreach ($rows as $row) {

            if ($row['Fecha_autorizacion']) {
                // debito exitoso
                $row['Establecimiento'];
                $row['vale'];
                $row['tarjeta']; //idea bin 
                $row['recap'];
                $row['tipo consumo'];
                //debito no exitos
                $row['cod Error'];
                $row['descripcion'];
                $row['Establecimiento']; //idea bin 
                $row['recap'];
                $row['vale'];
                $row['tarjeta'];
            }

            !empty($row['vale']) ? $this->total_registros_archivo++ : '';

            if (!empty($row['nombre_completo']) && !empty($row['cedula']) && (!empty($row['telf1']) || !empty($row['telf2']) || !empty($row['telf3']) || !empty($row['telf4']) || !empty($row['telf5']) || !empty($row['telf6']) || !empty($row['telf7']))) {


                $registros_archivos['cedula'] = $row['cedula'];
                array_push($registros_duplicados,  $registros_archivos);

                $existe =  $obj_base_activa->valida_resgistro_base_activa($this->cliente, $row['cedula'], $this->producto);

                if (isset($existe)) {

                    $this->total_registros_disponibles_gestion++;

                    $reg_duplicado = $obj_det_carga_corp->existe_registro($this->cod_carga, $this->cliente, $row['vale']);

                    if (!$reg_duplicado) {
                        # code...
                        try {

                            EaDetalleCargaCorp::create([
                                'id_carga' => isset($this->cod_carga)  ? $this->cod_carga : '',
                                'cliente' => isset($this->cliente) ? trim($this->cliente) : '',
                                'producto' => isset($this->producto)  ? $this->producto : '',
                                'cliente' => isset($this->cliente)  ? $this->cliente : '',
                                'secuencia' => isset($row['vale']) ? trim($row['vale']) : null,
                                'detalle' => isset($row['Descripción']) ? (isset($row['Cod Error']) ? $row['Cod Error'] : "") . "-" . $row['Descripción'] : '',
                                'Establecimiento' => isset($row['Establecimiento']) ? trim($row['Establecimiento']) : null,
                                'bin' => isset($row['Tarjeta']) ? substr($row['Tarjeta'], 0 , 6) : null,
                                'fecha_registro' => Date('d/m/Y H:i:s'),
                                'fecha_actualizacion' => Date('d/m/Y H:i:s'),
                                'estado' => isset($row['fecha_autorizacion']) ? '1' : null
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

//respaldos de export en campos
/*
public function collection(Collection $rows)
    {

        $obj_base_activa = (new EaBaseActivaController);
        $obj_det_carga_corp = (new EaDetalleCargaCorpController);
        $registros_duplicados = array();
        $registros_archivos = array();

        foreach ($rows as $row) {

            if ($row['Fecha_autorizacion']) {
                // debito exitoso
                $row['Establecimiento'];
                $row['vale'];
                $row['tarjeta']; //idea bin 
                $row['recap'];
                $row['tipo consumo'];
                //debito no exitos
                $row['cod Error'];
                $row['descripcion'];
                $row['Establecimiento']; //idea bin 
                $row['recap'];
                $row['vale'];
                $row['tarjeta'];
            }

            !empty($row['vale']) ? $this->total_registros_archivo++ : '';

            if (!empty($row['nombre_completo']) && !empty($row['cedula']) && (!empty($row['telf1']) || !empty($row['telf2']) || !empty($row['telf3']) || !empty($row['telf4']) || !empty($row['telf5']) || !empty($row['telf6']) || !empty($row['telf7']))) {


                $registros_archivos['cedula'] = $row['cedula'];
                array_push($registros_duplicados,  $registros_archivos);

                $existe =  $obj_base_activa->valida_resgistro_base_activa($this->cliente, $row['cedula'], $this->producto);

                if (isset($existe)) {

                    $this->total_registros_disponibles_gestion++;

                    $reg_duplicado = $obj_det_carga_corp->existe_registro($this->cod_carga, $this->cliente, $row['vale']);

                    if (!$reg_duplicado) {
                        # code...
                        try {

                            EaDetalleCargaCorp::create([
                                'id_carga' => isset($this->cod_carga)  ? $this->cod_carga : '',
                                'cliente' => isset($this->cliente) ? trim($this->cliente) : '',
                                'producto' => isset($this->producto)  ? $this->producto : '',
                                'cliente' => isset($this->cliente)  ? $this->cliente : '',
                                'secuencia' => isset($row['vale']) ? trim($row['vale']) : null,
                                'detalle' => isset($row['Descripción']) ? (isset($row['Cod Error']) ? $row['Cod Error'] : "") . "-" . $row['Descripción'] : '',
                                'Establecimiento' => isset($row['Establecimiento']) ? trim($row['Establecimiento']) : null,
                                'bin' => isset($row['Tarjeta']) ? substr($row['Tarjeta'], 0 , 6) : null,
                                'fecha_registro' => Date('d/m/Y H:i:s'),
                                'fecha_actualizacion' => Date('d/m/Y H:i:s'),
                                'estado' => isset($row['fecha_autorizacion']) ? '1' : null
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

        return $this->detalle_proceso;
    }
    */