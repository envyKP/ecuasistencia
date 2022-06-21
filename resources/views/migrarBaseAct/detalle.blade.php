<table class="table table-responsive-sm table-hover table-outline mb-0" id="tabla-detalleCarga">
<thead class="thead-light">
    <tr>
        <th class="text-center">{{'Código de carga'}}</th>
        <th>{{'Nombre del archivo'}}</th>
        <th>{{'Cliente'}}</th>
        <th>{{'Fecha de carga'}}</th>
        <th class="text-center">{{'Total de registros'}}</th>
        <th >{{'Usuario registra'}}</th>
        <th>{{'Fecha registro'}}</th>
        <th class="text-center">{{'Estado'}}</th>
        <th class="text-center"></th>
    </tr>
</thead>
@if (isset($RegistrosPendientes))
@php $row = 0;  @endphp
<tbody>
    @foreach($RegistrosPendientes as $registro )
        @php $row++; @endphp
    <tr>
        <td class="text-center"><strong>{{ $registro->cod_carga }}</strong></td>
        <td>{{  substr($registro->nombre_archivo, strpos($registro->nombre_archivo, $registro->cliente)) }}</td>
        <td>
            <div>
                <svg class="c-icon c-icon-1xl mr-2">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-institution')}} "></use>
                </svg> {{ $registro->cliente }}
            </div>
        </td>
        <td>
            <svg class="c-icon c-icon-1xl">
                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}} "></use>
            </svg> {{ $registro->fec_carga }}
        </td>
        <td class="text-center">{{ $registro->total_registros }}</td>
        <td>
            <div>
                <svg class="c-icon c-icon-1xl mr-2">
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
        @php ${'registro'.$registro->cod_carga} = $registro  @endphp
            <div class="row content-center">
                @if( ( session('cargados_registros') && session('cod_carga') == $registro->cod_carga ))
                    <button class="btn btn-info mx-1" title="Ver detalles del registro" type="button" data-toggle="modal" data-target="{{ '#infoDetcarga' }}">
                        <svg class="c-icon c-icon-1xl">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-magnifying-glass')}} "></use>
                        </svg>
                    </button>
                    @include('migrarBaseAct.detalleCarga', [ 'existentes' => session('existentes'), 'cargados_registros' => session('cargados_registros'),  'existentes_registros' => session('existentes_registros') ])
                @endif

                @if( stripos( $registro->estado,'PENDIENTE') !== false  &&  $registro->visible == 'S' )
                <form id="formProcesarArchivo" action="{{ route('EaMigracionBaseActivaController.procesar')}}" method="post">
	                @csrf
                    <input type="hidden" name="cod_carga" value="{{ $registro->cod_carga }}">
                    <button class="btn btn-success mx-1" title="Procesar Archivo" type="submit" id="btn-procesarMigra" >
                        <svg class="c-icon c-icon-1xl">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save')}} "></use>
                        </svg>
                    </button>
                </form>
                @endif
            </div>
        </td>
    </tr>
    @endforeach
</tbody>
@endif
</table>
@if(isset($RegistrosPendientes))
    {{ $RegistrosPendientes->links() }}
@endif
