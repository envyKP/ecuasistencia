<?php

namespace App\Exports;

use App\Models\EaBaseActiva;
use App\Models\EaSubproducto;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class EaGenCamExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        if (!isset($this->cliente)) {
            $this->cliente = "";
        }
        switch ($this->cliente) {
            case 'INTER':

                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();


                break;

            case "BBOLIVARIANO":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();

                break;
            case "BGR":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();
                break;
            case "PICHINCHA":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();
                break;
            case "PRODUBANCO":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();

                break;
            case "DINERS":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();
                break;
            case "MOVISTAR":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();
                break;
            case "NOVA":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();
                break;
            case "REALME":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();
                break;
            case "SAMSUNG":
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();
                break;


            default:
                return EaBaseActiva::join("ea_subproductos", "ea_subproductos.contrato_ama", "=", "ea_base_activa.producto")
                    ->select(
                        'tarjeta',
                        'ea_subproductos.cod_establecimiento',
                        EaBaseActiva::raw("FORMAT (getdate(), 'yyyyMMdd') as date"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'00000000000000000' as constante1"),
                        EaBaseActiva::raw("'202' as constante2"),
                        EaBaseActiva::raw("'000000' as constante3"),
                        EaBaseActiva::raw("'00' as constante4"),
                        EaBaseActiva::raw("'00000' as reemplazar"),
                        EaBaseActiva::raw("'439473' as constante5"),
                        'feccad',
                        'ea_subproductos.deduccion_impuesto',
                        EaBaseActiva::raw("'00' as constante6"),
                        EaBaseActiva::raw("'D' as constante7"),
                        EaBaseActiva::raw("'00000' as constante8"),
                        'ea_subproductos.subtotal',
                        EaBaseActiva::raw("'000000000000000' as constante9"),
                    )->where('producto', '400100012008312')->get();
                break;
        }
    }
    use Exportable;

    /*
    public function view(): View
    {

        if (!empty($this->producto)) {

            #code... modificar genaif
            return view('genaif.detalle', [

                'dataExport' => EaBaseActiva::where('cliente', $this->cliente)
                    ->where('estado_proceso', 3)
                    ->where('producto', $this->producto)
                    ->where('cod_carga_corp', $this->cod_carga_corp)
                    ->where('tipresp', '1')
                    ->where('codresp', '100')
                    ->where('detresp', 'ACEPTA SERVICIO')
                    ->where('estado', 'Z')
                    ->get()
            ]);
        } else {
            return view('genaif.detalle', [

                'dataExport' => EaBaseActiva::where('cliente', $this->cliente)
                    ->where('estado_proceso', 3)
                    ->where('cod_carga_corp', $this->cod_carga_corp)
                    ->where('tipresp', '1')
                    ->where('codresp', '100')
                    ->where('detresp', 'ACEPTA SERVICIO')
                    ->where('estado', 'Z')
                    ->get()

            ]);
        }
    }
    
    public function __construct(string $cliente, string $cod_carga_corp, string $producto)
    {

        $this->cliente = $cliente;
        $this->cod_carga_corp = $cod_carga_corp;
        $this->producto = $producto;
    }*/
}
