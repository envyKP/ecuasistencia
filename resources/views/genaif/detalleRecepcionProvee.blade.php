<table class="table table-responsive-sm table-hover table-outline mb-0" id="tabla-det-genaif">
<thead class="thead-light">
    <tr>
        <th class="text-center">{{'Código de carga'}}</th>
        <th>{{'Nombre del archivo'}}</th>
        <th>{{'Cliente'}}</th>
        <th class="text-center">{{'Estado'}}</th>
        <th>{{'Fecha registro'}}</th>
        <th >{{'Usuario registra'}}</th>
        <th class="col-sm-2 col-md-2">{{'Producto'}}</th>
    </tr>
</thead>
@if (isset($resumen_cabecera))
@php $row=0; @endphp
<tbody>
    @foreach($resumen_cabecera as $registro )
        @php $row++; @endphp
    <tr>
        <td class="text-center"><strong>{{ $registro->cod_carga }}</strong></td>
        <td>{{ explode("/", substr($registro->archivo, strpos($registro->archivo, $registro->cliente)) )[1] }}</td>
        <td>
            <div>
                <svg class="c-icon c-icon-1xl mr-1">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-institution')}} "></use>
                </svg> {{ $registro->cliente }}
            </div>
        </td>
        <td class="text-center">
           <strong>{{ $registro->proceso }} </strong>
        </td>
        <td>
            <svg class="c-icon c-icon-1xl">
                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}} "></use>
            </svg> {{ $registro->fec_registro }}
        </td>
        <td>
            <div>
                <svg class="c-icon c-icon-1xl mr-1">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-opsgenie')}} "></use>
                </svg>{{ $registro->usuario_registra }}
            </div>
        </td>
        <td>{{ $registro->desc_producto }}</td>
    </tr>
    @endforeach

</tbody>
@endif
</table>
@if( isset($resumen_cabecera) && count($resumen_cabecera)>1 )
    {{ $resumen_cabecera->links() }}
@endif
