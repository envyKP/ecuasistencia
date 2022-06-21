@php
   $row =0;
   $dataBusqueda = session('data');
@endphp
<table class="table table-responsive-sm table-hover table-outline mb-0">
<thead class="thead-light">
    <tr>
        <th><strong>{{'#'}}</strong></th>
        <th class="text-left col-sm-2 col-md-2">{{'Cliente corporativo'}}</th>
        <th class="text-center">{{'Fecha Getión'}}</th>
        <th class="text-center">{{'Identificación'}}</th>
        <th class="col-sm-2 col-md-2">{{'Cliente'}}</th>
        <th>{{'Producto'}}</th>
        <th>{{'Subproducto'}}</th>
        <th class="text-center col-sm-1 col-md-1">{{'Estado Asistencia'}}</th>
        <th class="text-center">{{'Acciones'}}</th>
    </tr>
</thead>
@if ( !empty($dataBusqueda) )
<tbody>
    @foreach( $dataBusqueda as $registro )
        @php  $row++; @endphp
    <tr>
        <td>
          <strong>{{ $row }}</strong>
        </td>
        <td class="text-left">
          <strong>{{ $registro->desc_clienteBA }}</strong>
        </td>
        <td class="text-center">
            <div>
                <svg class="c-icon c-icon-1xl mr-1">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}} "></use>
                </svg>{{ $registro->fecha}}
            </div>
        </td>
        <td class="text-center">
            <div>
                <svg class="c-icon c-icon-1xl">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-address-book')}} "></use>
                </svg> {{ $registro->cedula_id }}
            </div>
        </td>
        <td>
            <div>
                <svg class="c-icon c-icon-1xl">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-opsgenie')}} "></use>
                </svg>{{ substr($registro->nombre, 0, 25) }}
            </div>
        </td>
        <td>
            {{ $registro->desc_producto }}
        </td>
        <td>
            {{ $registro->subproducto }}
        </td>
        <td class="text-center">
            @if ( stripos($registro->estado, 'z') !== false )
            <strong> {{'Gestionado'}}</strong>
            @else
            <strong> {{'Disponible para gestión'}}</strong>
            @endif
        </td>
        <td>
            <div class="row justify-content-center">
                @php
                    ${ "$row"."Datacliente" } = $registro;
                @endphp
                <button class="btn btn-info mx-1" title="Ver detalles de registro" type="button" data-toggle="modal" data-target="{{ '#detalleInfor'.$row }}">
                    <svg class="c-icon c-icon-1xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-magnifying-glass')}} "></use>
                    </svg>
                </button>
                @include('busqueda.inforCliente', [ 'cliente' => ${ "$row"."Datacliente" }, 'row' => $row ] )

                <form  action="{{ route('EaBaseActivaController.serch') }}" method="post">
                    @csrf
                    @method('post')
                    <input type="hidden" name="proceso" value="moduloBuscar">
                    <input type="hidden" name="cliente" value="{{ $registro->cliente }}">
                    <input type="hidden" name="cedula_id" value="{{ $registro->cedula_id }}">
                    <input type="hidden" name="id_sec" value="{{ $registro->id_sec }}">
                    <button class="btn btn-success mx-1" title="Ir a la gestión del registro" type="submit" >
                        <svg class="c-icon c-icon-1xl">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-share')}} "></use>
                        </svg>
                    </button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</tbody>
@endif
</table>
@if( isset($dataBusqueda) )
    {{ $dataBusqueda->withQueryString()->links() }}
@endif
