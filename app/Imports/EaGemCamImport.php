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

        $obj_detalle_debito = (new EaDetalleDebitoController);
        $obj_subproducto = (new EaSubproductoController);
        $obj_det_carga_corp = (new EaDetalleDebitoController);
        $registros_duplicados = array();
        $registros_archivos = array();
        //EaSubproductoController
        $datos_subproductos = $obj_subproducto->getSubproductoDetalle($this->cliente, $this->producto);
        $op_client = EaOpcionesCargaCliente::where('cliente', $this->cliente)->where('subproducto', $this->producto)->first();
        dd($op_client);
        
        foreach ($rows as $row) {


            // desde aki lee el excel como modificarlo para que acepte nombre customizado de registro
            //
            //idea crear una tabla de customizacion que permita por cliente establecer el nombre predeterminado del campo a extraer el dato de la:
            // fecha de autorizacion y si la descripcion o la posicion en la que el campo valida u nombre (la posicion solo seria en caso de que venga en texto)
            //$this->cliente = $cliente;
            //$this->cod_carga = $cod_carga;
            //$this->producto = $producto;

            dd($op_client->nc_fecha_debito);
            $condicional1 = false;

            if ($row[$op_client->nc_fecha_debito]) {
                $condicional1 = true;
                // se puede validar con los precios de la base del producto. ??
                $row['Total'];
                


                // campos excel de INTER TC
                // debito exitoso
                /*$row['Establecimiento'];
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
                $row['tarjeta'];*/
            }


            $row['vale'];
            //$row['Recap'];
            $row['Descripción'];
            $row['Establecimiento'];
            $row['Cod Error'];
            

            !empty($row['vale']) ? $this->total_registros_archivo++ : '';

            if (!empty($row['']) && !empty($row[''])) {


                $registros_archivos['cedula'] = $row['cedula'];
                array_push($registros_duplicados,  $registros_archivos);
                $existe =  $obj_detalle_debito->valida_resgistro_base_activa($this->cliente, $row['cedula'], $this->producto);
                if (isset($existe)) {
                    $this->total_registros_disponibles_gestion++;
                    // no hay forma de saber si el registro esta duplicado 
                    /*$reg_duplicado = $obj_det_carga_corp->existe_registro($this->cod_carga, $this->cliente, $row['vale']);
                    if (!$reg_duplicado) {
                        # code...*/
                    try {

                        /** utilizar un case con el cliente o de la base de datos redactar el nombre de campo valido y campo invalido ? 
                         * usar un json para encriptar informacion relevante como los campos personalizados la extencion y el nombre ? 
                         * o solo especificar el espacion en donde perteneceran los campos 
                         */
                        //(campos de interes)
                        // () = pertenece a campos de detalle_debito
                        //(()) = Petenece a campo que pueden ir en opcionales o tambien en la cabecera()
                        // INTER TC = total() secuencia() establecimiento(()) codigo_error() fecha debito()
                        //
                        //
                        //
                        //
                        //
                        //
                        $debito_model = EaDetalleDebito::where('id_carga', $this->cod_carga)->where('cliente', $this->cliente)
                            ->where('subproducto_id', $this->producto);
                       /* if(){
                            $debito_model = $debito_model->update(['estado' => '', 'visible' => 'N']);
                        }else{
                            $debito_model = $debito_model->update(['estado' => '', 'visible' => 'N']);
                        }*/
                        /*
                            EaDetalleCargaCorp::create([
                                'id_carga' => isset($this->cod_carga)  ? $this->cod_carga : '',
                                'cliente' => isset($this->cliente) ? trim($this->cliente) : '',
                                'producto' => isset($this->producto)  ? $this->producto : '',
                                'cliente' => isset($this->cliente)  ? $this->cliente : '',
                                'secuencia' => isset($row['vale']) ? trim($row['vale']) : null,
                                'detalle' => isset($row['Descripción']) ? (isset($row['Cod Error']) ? $row['Cod Error'] : "") . "-" . $row['Descripción'] : '',
                                'Establecimiento' => isset($row['Establecimiento']) ? trim($row['Establecimiento']) : null,
                                'bin' => isset($row['Tarjeta']) ? substr($row['Tarjeta'], 0, 6) : null,
                                'fecha_registro' => Date('d/m/Y H:i:s'),
                                'fecha_actualizacion' => Date('d/m/Y H:i:s'),
                                'estado' => isset($row['fecha_autorizacion']) ? '1' : null
                            ]);
                            */
                    } catch (\Exception $e) {
                        $obj_det_carga_corp->truncate($this->cod_carga, $this->cliente);
                        $this->errorTecnico = $e->getMessage();
                    }


                    /* } else {
                        $this->total_registros_duplicados++;
                    }*/
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
        /*
        $this->detalle_proceso['errorTecnico'] = $this->errorTecnico;
        $this->detalle_proceso['total_registros_archivo'] = $this->total_registros_archivo;
        $this->detalle_proceso['total_registros_disponibles_gestion'] = $this->total_registros_disponibles_gestion;
        $this->detalle_proceso['total_registros_gestionados_otras_campanas'] = $this->total_registros_gestionados_otras_campanas;
        $this->detalle_proceso['registros_no_cumplen'] = $this->registros_no_cumplen;
        $this->detalle_proceso['total_registros_duplicados'] = $this->total_registros_duplicados;
        $this->detalle_proceso['total_registros_sin_infor'] = $this->total_registros_sin_infor;
*/
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
