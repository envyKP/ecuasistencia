<table class="table table-responsive-sm table-hover table-outline mb-0" id="tabla-det-caraga-corp">
<thead class="thead-light">
    <tr>
        <th class="text-center">{{'Código de carga'}}</th>
        <th>{{'Nombre del archivo'}}</th>
        <th>{{'Cliente'}}</th>
        <th>{{'Producto'}}</th>
        <th class="text-center">{{'Total de registros'}}</th>
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
        <td>{{ $registro->desc_producto }}</td>
        <td class="text-center">{{ $registro->total_registros_archivo }}</td>
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
                @if( stripos( $registro->estado,'PROCESADO') !== false )
                    <button class="btn btn-info mx-1" title="Ver detalles del registro" type="button" data-toggle="modal" data-target="{{ '#infoDetcarga'.$row }}">
                        <svg class="c-icon c-icon-1xl">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-magnifying-glass')}} "></use>
                        </svg>
                    </button>
                    @include('recaif.detalleCarga', [ 'data' =>  ${'data'.$registro->cod_carga}, 'row' => $row,  'sin_campos_obligatorios' => session('sin_campos_obligatorios') ])
                @endif

                @if( stripos( $registro->estado,'PENDIENTE') !== false && $registro->visible =='S' )
                <form id="form-procesarCarga" action="{{ route('EaRecepArchiFinanController.procesar')}}" method="post">
	                @csrf
                    <input type="hidden" name="cod_carga" value="{{ $registro->cod_carga }}">
                    <input type="hidden" name="archivo"  value="{{ $registro->archivo }}">
                    <input type="hidden" name="cliente"  value="{{ $registro->cliente }}">
                    <input type="hidden" name="producto" value="{{ $registro->producto }}">
                    <button class="btn btn-success mx-1" title="Procesar Archivo" type="submit">
                        <svg class="c-icon c-icon-1xl">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save')}} "></use>
                        </svg>
                    </button>
                </form>
                @endif

                <button class="btn btn-danger mx-1" title="Eliminar Carga" type="button" data-toggle="modal" data-target="{{ '#eliminar'.$registro->cod_carga }}">
                    <svg class="c-icon c-icon-1xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}} "></use>
                    </svg>
                </button>
            </div>
            @include('recaif.eliminarRegistro', ['row' => $registro->cod_carga, 'data' => ${'data'.$registro->cod_carga} ])
        </td>
    </tr>
    @endforeach
</tbody>
@endif
</table>
@if( isset($resumen_cabecera) && count($resumen_cabecera)>1 )
    {{ $resumen_cabecera->links() }}
@endif
