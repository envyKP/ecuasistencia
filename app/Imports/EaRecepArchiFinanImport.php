<?php

namespace App\Imports;

use App\Models\EaBaseActiva;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Http\Controllers\EaBaseActivaController;
use App\Http\Controllers\EaProductoController;
use Illuminate\Support\Facades\Crypt;

require_once "../vendor/autoload.php";
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

class EaRecepArchiFinanImport implements ToCollection, WithHeadingRow
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
        $obj_base_activa = (new EaBaseActivaController);

        $contenido = file_get_contents("../salsa.txt");
        $clave = Key::loadFromAsciiSafeString($contenido);

        if ( $this->producto !== '0' ) {

            $productoDet = (new EaProductoController)->getProductoDetalle($this->cliente, $this->producto);
            $registro_data['producto'] = $productoDet->contrato_ama;
            $registro_data['desc_producto'] = $productoDet->desc_producto;
            $registro_data['subproducto'] = $productoDet->subproducto;
        }


        foreach ($rows as $row) {


            !empty($row['cedula']) ? $this->total_registros_archivo++ : '';

            $registro_data['tarjeta'] = '';
            $registro_data['feccad'] = '';
            $registro_data['cuenta'] = '';
            $registro_data['dettipcta']  = '';
            $registro_data['tipcta'] = '';
            $registro_data['observaciones'] = null;
            $registro_data['estado_proceso'] = '5';

            if ( !empty($row['cedula'])  && ( (isset($row['numero_de_tarjeta']) && $row['numero_de_tarjeta'] !== 0)  ||
                                              (isset($row['fecha_de_vigencia_de_tarjeta']) && $row['fecha_de_vigencia_de_tarjeta'] !== 0) ||
                                              (isset($row['numero_de_cuenta']) && $row['numero_de_cuenta'] <> '0') ||
                                              (isset($row['tipo_de_cuenta']) && $row['tipo_de_cuenta'] !== '0') ) )
            {

                $registro_data['nombre'] = $row['cliente'];
                $registro_data['dettipcta'] = $row['tipo_de_cuenta'];
                $registro_data['cuenta'] = Crypto::encrypt(trim($row['numero_de_cuenta']), $clave);
                $registro_data['feccad'] = $row['fecha_de_vigencia_de_tarjeta'];
                $registro_data['tarjeta'] = Crypto::encrypt(trim($row['numero_de_tarjeta']), $clave);


                if ( strtolower(trim($row['tipo_de_cuenta'])) == 'ahorro') {
                    $registro_data['tipcta'] = 'AHO';

                }else if ( strtolower(trim($row['tipo_de_cuenta'])) == 'corriente') {
                    $registro_data['tipcta'] = 'CTE';
                }

                $existe = $obj_base_activa->valida_base_activa_recep_infor_finan($this->cliente, $row['cedula'], $this->cod_carga_corp, $this->producto);

                if ($existe) {

                    try {

                        EaBaseActiva::where('cliente', $this->cliente)
                                    ->where('cod_carga_corp', $this->cod_carga_corp)
                                    ->where('cedula_id', trim($row['cedula']))
                                    ->where('estado', 'Z')
                                    ->where('tipresp', '1')
                                    ->where('codresp', '100')
                                    ->where('detresp', 'ACEPTA SERVICIO')
                                    ->where('estado_proceso', 4)
                                    ->update($registro_data);

                    } catch (\Exception $e) {
                        $this->errorTecnico = $e->getMessage();
                        return  $this->detalle_proceso['errorTecnico'] = $this->errorTecnico;
                    }

                }


            }

            if ( ( !isset($row['numero_de_tarjeta']) || $row['numero_de_tarjeta'] == 0 ) &&  ( !isset($row['fecha_de_vigencia_de_tarjeta']) || $row['fecha_de_vigencia_de_tarjeta'] == 0) &&
                 ( !isset($row['numero_de_cuenta']) || $row['numero_de_cuenta']  == 0 )  &&  ( !isset($row['tipo_de_cuenta']) || $row['tipo_de_cuenta'] == 0 ) )

            {

                $this->total_registros_sin_infor++;
                $registro_data['nombre'] = $row['cliente'];
                $registro_data['observaciones'] = "SIN INFORMACIÓN FINANCIERA";

                EaBaseActiva::where('cliente', $this->cliente)
                            ->where('cod_carga_corp', $this->cod_carga_corp)
                            ->where('cedula_id', trim($row['cedula']))
                            ->where('estado', 'Z')
                            ->where('tipresp', '1')
                            ->where('codresp', '100')
                            ->where('detresp', 'ACEPTA SERVICIO')
                            ->where('estado_proceso', 4)
                            ->update($registro_data);
            }

        }


        $this->detalle_proceso['total_registros_sin_infor'] = $this->total_registros_sin_infor;
        $this->detalle_proceso['total_registros_archivo'] = $this->total_registros_archivo;
        $this->detalle_proceso['errorTecnico'] = $this->errorTecnico;

        return $this->detalle_proceso;
    }



    public function __construct(int $cod_carga_corp, string $cliente,  string $producto)
    {

        $this->cod_carga_corp = $cod_carga_corp;
        $this->cliente = $cliente;
        $this->producto = $producto;
        $this->total_registros_archivo = 0;
        $this->total_registros_sin_infor = 0;
        $this->errorTecnico ='';
        $this->detalle_proceso = array();


    }

}
