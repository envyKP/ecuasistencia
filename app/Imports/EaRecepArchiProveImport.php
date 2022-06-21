<?php

namespace App\Imports;

use App\Models\EaBaseActiva;
use App\Models\EaCodigoRespuesta;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Http\Controllers\EaBaseActivaController;
use App\Http\Controllers\EaProductoController;
use App\Http\Controllers\EaCabCargaInicialController;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class EaRecepArchiProveImport implements ToCollection, WithHeadingRow
{


    use Importable, SkipsErrors;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {

        $registro_data = array();
        $registro_data['filein_telemarketing'] = $this->fileout_telemarketing;
        $obj_base_activa = (new EaBaseActivaController);

        if ( !empty($this->producto) ) {

            $productoDet = (new EaProductoController)->getProductoDetalle($this->cliente, $this->producto);
            $registro_data['producto'] = $productoDet->contrato_ama;
            $registro_data['desc_producto'] = $productoDet->desc_producto;
            $registro_data['subproducto'] = $productoDet->subproducto;
        }


        foreach ($rows as $row)
        {


            if (!empty($row['cedula'])) {
                $this->total_registros_archivo++;
                $existe = $obj_base_activa->valida_base_activa_recep_provee($this->cliente, $this->cod_carga_corp, $row['cedula'], $this->producto);
            }

            $registro_data['direccion'] = null;
            $registro_data['mail'] = null;
            $registro_data['telefono_contacto'] = null;
            $registro_data['operador'] = null;
            $registro_data['fecha'] = null;
            $registro_data['hora'] =  null;
            $registro_data['tipresp'] = null;
            $registro_data['codresp'] = null;
            $registro_data['detresp'] = null;
            $registro_data['estado_proceso'] = "2";
            $registro_data['codestado'] = null;
            $registro_data['detestado'] = null;
            $registro_data['estado'] = "A";


                if ($existe)
                {

                    if ( !empty($row['cedula']) && !empty($row['telefono_contactado']) && !empty($row['operador']) && !empty($row['fecha'])  && !empty($row['hora'])  && !empty($row['motivo']) )
                    {

                        $call_type_venta= EaCodigoRespuesta::where('detresp', trim($row['motivo']) )->first();

                        if (  strcmp( strtolower($this->tipo_carga), 'parcial' )==0  && ($call_type_venta->codresp == '100' &&  $call_type_venta->tipresp == "1" ) && empty($this->no_ejecucion) )
                        {

                            # code...
                            $this->total_registros_aceptan++;
                            try {

                                $registro_data['direccion'] = $row['direccion_confirmacion'];
                                $registro_data['mail'] = $row['email_confirmacion'];
                                $registro_data['telefono_contacto'] = $row['telefono_contactado'];
                                $registro_data['operador'] = $row['operador'];
                                $registro_data['fecha'] = Date::excelToDateTimeObject( $row['fecha'] )->format('d/m/Y');
                                $registro_data['hora'] =  Date::excelToDateTimeObject( $row['hora'] )->format('H:i:s');
                                $registro_data['tipresp'] = $call_type_venta->tipresp;
                                $registro_data['codresp'] = $call_type_venta->codresp;
                                $registro_data['detresp'] = $row['motivo'];
                                $registro_data['estado_proceso'] = '3';
                                $registro_data['codestado'] = 'A';
                                $registro_data['detestado'] = 'ACTIVO';
                                $registro_data['estado'] = 'Z';


                            } catch (\Exception $e) {

                                $this->errorTecnico = $e->getMessage();
                                return  $this->detalle_proceso['errorTecnico'] = $this->errorTecnico;
                            }



                        }else if (  strcmp( strtolower($this->tipo_carga), 'parcial' )==0  && $this->no_ejecucion == "1" ) {

                            try {

                                $registro_data['direccion'] = $row['direccion_confirmacion'];
                                $registro_data['mail'] = $row['email_confirmacion'];
                                $registro_data['telefono_contacto'] = $row['telefono_contactado'];
                                $registro_data['operador'] = $row['operador'];
                                $registro_data['fecha'] = Date::excelToDateTimeObject( $row['fecha'] )->format('d/m/Y');
                                $registro_data['hora'] =  Date::excelToDateTimeObject( $row['hora'] )->format('H:i:s');
                                $registro_data['tipresp'] = $call_type_venta->tipresp;
                                $registro_data['codresp'] = $call_type_venta->codresp;
                                $registro_data['detresp'] = $row['motivo'];
                                $registro_data['estado_proceso'] = '3';
                                $registro_data['estado'] = 'Z';

                                if (($call_type_venta->codresp == '100' &&  $call_type_venta->tipresp == "1" )) {
                                    # code...
                                    $this->total_registros_aceptan++;
                                    $registro_data['codestado'] = 'A';
                                    $registro_data['detestado'] = 'ACTIVO';

                                }else {
                                    $this->total_otros_call_types++;
                                    $registro_data['codestado'] = 'Z';
                                    $registro_data['detestado'] = 'GESTIONADO';
                                }

                            } catch (\Exception $e) {

                                $this->errorTecnico = $e->getMessage();
                                return  $this->detalle_proceso['errorTecnico'] = $this->errorTecnico;
                            }



                        }else if ( strcmp( strtolower($this->tipo_carga), 'total' )==0  ) {

                            $registro_data['direccion'] = $row['direccion_confirmacion'];
                            $registro_data['mail'] = $row['email_confirmacion'];
                            $registro_data['telefono_contacto'] = $row['telefono_contactado'];
                            $registro_data['operador'] = $row['operador'];
                            $registro_data['fecha'] = Date::excelToDateTimeObject( $row['fecha'] )->format('d/m/Y');
                            $registro_data['hora'] =  Date::excelToDateTimeObject( $row['hora'] )->format('H:i:s');
                            $registro_data['tipresp'] = $call_type_venta->tipresp;
                            $registro_data['codresp'] = $call_type_venta->codresp;
                            $registro_data['detresp'] = $row['motivo'];
                            $registro_data['estado_proceso'] = '3';
                            $registro_data['estado'] = 'Z';


                            if ($call_type_venta->codresp == '100' &&  $call_type_venta->tipresp == "1" )
                            {

                                $this->total_registros_aceptan++;
                                $registro_data['codestado'] = 'A';
                                $registro_data['detestado'] = 'ACTIVO';

                            } else {

                                $this->total_otros_call_types++;
                                $registro_data['codestado'] = 'Z';
                                $registro_data['detestado'] = 'GESTIONADO';

                            }
                        }

                    } else {

                        $this->total_registros_sin_infor++;

                        if ( strcmp( strtolower($this->tipo_carga), 'total' )==0 ) {
                            $registro_data['estado_proceso'] = '3';
                            $registro_data['estado'] = 'Z';
                            $registro_data['codestado'] = 'Z';
                            $registro_data['detestado'] = 'GESTIONADO';

                        }


                        if ( strcmp( strtolower($this->tipo_carga), 'parcial' )==0 && $this->no_ejecucion == "1") {
                            $registro_data['estado_proceso'] = '3';
                            $registro_data['estado'] = 'Z';
                            $registro_data['codestado'] = 'Z';
                            $registro_data['detestado'] = 'GESTIONADO';

                        }

                    }

                    try {

                        EaBaseActiva::where('cliente', $this->cliente)
                                    ->where('cedula_id',  trim($row['cedula']) )
                                    ->where('cod_carga_corp',  $this->cod_carga_corp)
                                    ->where('estado', 'A')
                                    ->where('estado_proceso', 2)
                                    ->update($registro_data);

                    } catch (\Exception $e) {
                        $this->errorTecnico = $e->getMessage();
                        return  $this->detalle_proceso['errorTecnico'] = $this->errorTecnico;
                    }

                }
        }

        $this->detalle_proceso['total_registros_aceptan'] = $this->total_registros_aceptan;
        $this->detalle_proceso['total_otros_call_types'] = $this->total_otros_call_types;
        $this->detalle_proceso['total_registros_archivo'] = $this->total_registros_archivo;
        $this->detalle_proceso['total_registros_sin_infor'] = $this->total_registros_sin_infor;
        $this->detalle_proceso['errorTecnico'] = $this->errorTecnico;

        return $this->detalle_proceso;
    }



    public function __construct(int $cod_carga_corp, string $cliente, string $fileout_telemarketing, string $producto, string $tipo_carga, string $no_ejecucion )
    {

        $this->cliente = $cliente;
        $this->cod_carga_corp = $cod_carga_corp;
        $this->fileout_telemarketing = $fileout_telemarketing;
        $this->producto = $producto;
        $this->tipo_carga = $tipo_carga;
        $this->no_ejecucion = $no_ejecucion;
        $this->total_registros_archivo = 0;
        $this->total_registros_aceptan = 0;
        $this->total_otros_call_types = 0;
        $this->total_registros_sin_infor = 0;
        $this->errorTecnico ='';
        $this->detalle_proceso = array();


    }


}
