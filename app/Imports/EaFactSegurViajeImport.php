<?php

namespace App\Imports;

use App\Models\EaSegurViaje;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class EaFactSegurViajeImport implements ToCollection
{

    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            User::create([
                'Ambiente' => $row['Ambiente'],
                'Cod_Doc' => $row[${'Cod Doc'}],
                'fecha_carg_base' => Date('d-m-Y H:i:s'),
                'Cod_Contr_Especial' => $row[${'Codigo de contribuyente especial'}],
                'Raz_Soc_Compra' => $row[${'Razon Social Comprador'}],
                'tip_ident_Compra' => $row[${'tipo de identificador comprador'}],
                'Ident_Compra' => $row[${'Identificacion Comprador'}],
                'Tot_Sin_Impue' => $row[${'Total Sin Impuestos'}],
                'Tipo_impues' => $row[${'Tipo de impuestos'}],
                'Tarifa_IVA' => $row[${'Tarifa de IVA'}],
                'Base_imponible' => $row[${'Base imponible'}],
                'Total_impuestos' => $row[${'Total impuestos'}],
                'Importe_Total' => $row[${'Importe Total'}],
                'Moneda' => $row[${'Moneda'}],
                'Descripcion' => $row[${'Descripcion'}],
                'Cantidad' => $row[${'Cantidad'}],
                'Precio_Unitario' => $row[${'Precio Unitario'}],
                'Descuento' => $row[${'Descuento'}],
                'Detalle_Adicional' => $row[${'Detalle Adicional'}],
                'Email_fiscal_comerc' => $row[${'Email fiscal y comercial'}],
                'Telefono' => $row[${'Telefono'}],
                'Cuen_Tarj_Vouch' => $row[${'Cuenta/Tarjeta/Voucher'}],
                'Cta_Mayor' => $row[${'Cta Mayor'}],
                'Deudor' => $row[${'Deudor'}],
                'Indica_Impto' => $row[${'Indica Impto'}],
                'Sociedad' => $row[${'Sociedad'}],
                'Con_Sin_Riesgo' => $row[${'Con/Sin Riesgo'}],
                'No_Contr_SAP' => $row[${'No Contrato SAP'}],
                'Tipo_Negocio' => $row[${'Tipo de Negocio'}],
                'Cliente_SAP' => $row[${'Cliente SAP'}],
                'Pais' => $row[${'Pais'}],
                'Tipo_DH' => $row[${'Tipo D/H'}],
                'Val_Deb_Inclu_IVA' => $row[${'Valor Debito Incluido IVA'}],
                'Estab' => $row[${'Estab'}],
                'Pto_Emi' => $row[${'Pto_Emi'}],
                'Secuencial' => $row[${'Secuencia'}],
                'Facturar_a' => $row[${'facturar A'}],
                'Nombre_SGVIA' => $row[${'Razon Social Comprador'}],
                'Cedula_SGVIA' => $row[${'Identificacion Comprador'}],
                'Obli_llevar_contab' => "SI",
                'Precio_Unitario2' =>  $row[ ${'Precio Unitario'}],
                'Nombre_SGVIA2' =>  $row[ ${'Nombre Producto'}],


            ]);
        }



        $this->detalle_proceso['errorTecnico'] = $this->errorTecnico;
        $this->detalle_proceso['total_registros_archivo'] = $this->total_registros_archivo;

        return $this->detalle_proceso;

    }



    public function __construct(int $cod_carga, string $cliente, string $subproducto ){

        $this->cliente = $cliente;
        $this->cod_carga = $cod_carga;
        $this->producto = $producto;
        $this->detalle_proceso = array();
    }
}
