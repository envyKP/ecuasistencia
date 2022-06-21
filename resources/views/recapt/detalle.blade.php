<table class="table table-responsive-sm table-hover table-outline mb-0" id="tabla-recep-provee">
<thead class="thead-light">
    <tr>
        <th class="text-center">{{'Código de carga'}}</th>
        <th>{{'Nombre del archivo'}}</th>
        <th>{{'Cliente'}}</th>
        <th>{{'Producto'}}</th>
        <th class="text-center">{{'Tipo de carga'}}</th>
        <th class="text-center">{{'No. de ejecuciones'}}</th>
        <th >{{'Usuario registra'}}</th>
        <th>{{'Fecha registro'}}</th>
        <th class="text-center">{{'Estado'}}</th>
        <th class="text-center">{{'Acciones'}}</th>
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
        <td>{{ $registro->desc_producto }} </td>
        <td class="text-center">
            <svg class="c-icon c-icon-1xl">
                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-upload')}} "></use>
            </svg> {{ $registro->tipo_carga }}
        </td>
        <td class="text-center">
            {{ $registro->no_ejecucion}}
        </td>
        <td>
            <div>
                <svg class="c-icon c-icon-1xl mr-1">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-opsgenie')}} "></use>
                </svg>{{ $registro->usuario_registra }}
            </div>
        </td>
        <td>
            <svg class="c-icon c-icon-1xl">
                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}} "></use>
            </svg> {{ $registro->fec_registro }}
        </td>
        <td class="text-center">
           <strong>{{ $registro->estado }} </strong>
        </td>
        <td>
            @php
                ${'data'.$registro->cod_carga} = $registro;
            @endphp
            <div class="row content-center">
                @if( $registro->no_ejecucion >=1 )
                    <button class="btn btn-info mx-1" title="Ver detalles del registro" type="button" data-toggle="modal" data-target="{{ '#infoDetcarga'.$row }}">
                        <svg class="c-icon c-icon-1xl">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-magnifying-glass')}} "></use>
                        </svg>
                    </button>
                    @include('recapt.detalleCarga', [ 'data' =>  ${'data'.$registro->cod_carga}, 'row' => $row ])
                @endif

                @if( (is_null($registro->no_ejecucion) || $registro->no_ejecucion>= 1 ) &&  strcmp($registro->estado, 'PENDIENTE') ==0  && $registro->visible =='S' )
                <form id="form-procesarCarga" action="{{ route('EaRecepArchiProveTmkController.procesar')}}" method="post">
	                @csrf
                    <input type="hidden" name="cod_carga" value="{{ $registro->cod_carga }}">
                    <input type="hidden" name="archivo"  value="{{ $registro->archivo }}">
                    <input type="hidden" name="cliente"  value="{{ $registro->cliente }}">
                    <input type="hidden" name="producto" value="{{ $registro->producto }}">
                    <input type="hidden" name="tipo_carga" value="{{ $registro->tipo_carga }}">
                    <input type="hidden" name="no_ejecucion" value="{{ $registro->no_ejecucion }}">
                    <button class="btn btn-success mx-1" title="Procesar Archivo" type="submit">
                        <svg class="c-icon c-icon-1xl">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save')}} "></use>
                        </svg>
                    </button>
                </form>
                @endif
                @if( strcmp($registro->estado, 'PENDIENTE') ==0  && strcmp($registro->proceso, 'recepcion_provee_tmk')==0 )
                <button class="btn btn-danger mx-1" title="Eliminar Archivo" type="button" data-toggle="modal" data-target="{{ '#eliminar'.$registro->cod_carga }}">
                    <svg class="c-icon c-icon-1xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}} "></use>
                    </svg>
                </button>
                @endif

            </div>
            @include('recapt.eliminarRegistro', ['row' => $registro->cod_carga, 'data' => ${'data'.$registro->cod_carga} ])
        </td>
    </tr>
    @endforeach
</tbody>
@endif
</table>
@if( isset($resumen_cabecera) && count($resumen_cabecera)>1 )
    {{ $resumen_cabecera->links() }}
@endif
