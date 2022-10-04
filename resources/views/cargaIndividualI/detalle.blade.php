<table class="table table-responsive-sm table-hover table-outline mb-0" id="tabla-det-caraga-corp">
    <thead class="thead-light">
        <tr>
            <th class="text-center">{{ 'Código de carga' }}</th>
            <th>{{ 'Cliente' }}</th>
            <th>{{ 'Producto' }}</th>
            <th>{{ 'Opciones' }}</th>
            <th>{{ 'Usuario genera' }}</th>
            <th>{{ 'Fecha generacion' }}</th>
            <th>{{ 'Nombre Archivo' }}</th>
            <th class="text-center">{{ 'Estado' }}</th>
            <th class="text-center" colspan="4">{{ 'Acciones' }}</th>
        </tr>
    </thead>
    @if (isset($resumen_cabecera))
        @php $row=0; @endphp
        <tbody>
            @foreach ($resumen_cabecera as $registro)
                @php $row++; @endphp
                <tr>
                    <td class="text-center"><strong>{{ $registro->cod_carga }}</strong></td>
                    <td>
                        <div>
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-institution') }} ">
                                </use>
                            </svg>
                            @switch($registro->cliente)
                                @case('BBOLIVARIANO')
                                    BANCO BOLIVARIANO
                                @break

                                @case('BGR')
                                    BANCO GENERAL RUMIÑAHUI
                                @break

                                @case('PICHINCHA')
                                    BANCO PICHINCHA
                                @break

                                @case('INTER')
                                    BANCO INTERNACIONAL
                                @break

                                @case('PRODUBANCO')
                                    BANCO PRODUBANCO
                                @break

                                @case('DINERS')
                                    DINERS CLUB
                                @break

                                @case('MOVISTAR')
                                    MOVISTAR
                                @break

                                @case('NOVA')
                                    NOVA S.A.
                                @break

                                @default
                                    {{ $registro->cliente }}
                            @endswitch
                        </div>
                    </td>
                    <td>{{ $registro->desc_producto }}</td>
                    <!-- bloque para variable opciones -->
                    <td>
                        <div>
                            <svg class="c-icon c-icon-1xl mr-1">
                            </svg> @php 
                                /*
                                $value_custom = '';
                                if(isset($registro->custom_code) && isset($registro->n_custom_code) )
                                {
                                    $value_custom = $registro->n_custom_code;
                                    if(isset($registro->opciones_validacion)){
                                        $opciones_validacion= json_decode($registro->opciones_validacion, true);
                                        for ($i=1; $i <= $opciones_validacion['total']; $i++) { 
                                            if($opciones_validacion['var_camp_'.$i]== $registro->n_custom_code){
                                                $value_custom = $opciones_validacion['var_val_'.$i];
                                            }
                                        }
                                    }
                                }
                                echo $value_custom;
                                */
                                @endphp
                                {{$registro->opciones_validacion}}
                        </div>
                        
                    </td>
                    <!-- -->
                    <td>
                        <div>
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-opsgenie') }} ">
                                </use>
                            </svg>{{ $registro->usuario_registra }}
                        </div>
                    </td>

                    <td>
                        <svg class="c-icon c-icon-1xl">
                            <use
                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calendar') }} ">
                            </use>
                        </svg> {{ \Carbon\Carbon::parse($registro->fec_registro)->format('d/m/Y H:m:s') }}
                    </td>
                    @php
                        $condicio_name = isset($registro->archivo) ? $registro->archivo : '';
                        $name_file = explode('/', $registro->archivo);
                        $value_name = isset($registro->archivo) ? $name_file[count($name_file) - 1] : '';
                    @endphp
                    <td>
                        {{ $value_name }}
                    </td>
                    <td class="text-center">
                        @switch($registro->estado)
                            @case('POR PROCESAR')
                                <strong style='color:red;'>{{ $registro->estado }} </strong>
                            @break

                            @case('REPROCESAR')
                                <strong style='color:green;'>{{ $registro->estado }} </strong>
                            @break

                            @default
                                <strong>{{ $registro->estado }} </strong>
                        @endswitch
                    </td>


                    @php
                        ${'data' . $registro->cod_carga} = $registro;
                    @endphp


                    <td>
                        <div class="row content-center">
                            <!-- $request->cliente, $detalle_subproducto->desc_subproducto $request->carga_resp -->
                            <form id="form-procesarCarga" action="{{ route('EaCargaIndividualExport.exporta') }}"
                                method="get">
                                <input type="hidden" name="carga_resp" value="{{ $registro->cod_carga }}">
                                <input type="hidden" name="cliente" value="{{ $registro->cliente }}">
                                <input type="hidden" name="producto" value="{{ $registro->producto }}">
                                <input type="hidden" name="desc_producto" value="{{ $registro->desc_producto }}">
                                <button class="btn btn-success mx-1" title="descargar generacion" type="submit">
                                    <svg class="c-icon c-icon-1xl">
                                        <use
                                            xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-data-transfer-down') }} ">
                                        </use>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                    <td>
                        @if (strcmp($registro->estado, 'PROCESADO') == 0)
                            <div class="row content-center">
                                <button class="btn btn-info mx-1" title="Carga de respuesta" type="button"
                                    data-toggle="modal" data-target="{{ '#infoDetcarga' . $row }}" disabled>
                                    <svg class="c-icon c-icon-1xl">
                                        <use
                                            xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-upload') }} ">
                                        </use>
                                    </svg>
                                </button>
                            </div>
                        @else
                            <div class="row content-center">
                                <button class="btn btn-info mx-1" title="Carga de respuesta" type="button"
                                    data-toggle="modal" data-target="{{ '#infoDetcarga' . $row }}">
                                    <svg class="c-icon c-icon-1xl">
                                        <use
                                            xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-upload') }} ">
                                        </use>
                                    </svg>
                                </button>
                                @include('cargaIndividualI.detalleCarga', [
                                    'data' => ${'data' . $registro->cod_carga},
                                    'row' => $row,
                                    'cod_carga' => $registro->cod_carga,
                                    'cliente' => $registro->cliente,
                                    'estado_cabecera' => $registro->estado,
                                    'producto' => $registro->producto,
                                    'carga_resp' => $registro->cod_carga,
                                    'desc_producto' => $registro->desc_producto,
                                    'registros_no_cumplen' => session('registros_no_cumplen'),
                                ])
                            </div>
                        @endif

                    </td>
                    <td>

                        <div class="row content-center">
                            <form id="form-factura" action="{{ route('EaCargaIndividualExport.generarFactura') }}"
                                method="get">
                                @if (strcmp($registro->estado, 'PROCESADO') == 0)
                                    <input type="hidden" name="carga_resp" value="{{ $registro->cod_carga }}">
                                    <input type="hidden" name="cliente" value="{{ $registro->cliente }}">
                                    <input type="hidden" name="producto" value="{{ $registro->producto }}">
                                    @csrf
                                    <button class="btn btn-warning mx-1" title="Facturacion" name="Facturacion"
                                        id="btn_Facturacion" type="submit">
                                        <svg class="c-icon c-icon-1xl">
                                            <use
                                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-description') }} ">
                                            </use>
                                        </svg>
                                        <!-- free.svg#cil-description brand.svg#cib-libreoffice  free.svg#cil-task-->
                                    </button>
                                @else
                                    <button class="btn btn-warning mx-1" title="Facturacion" name="Facturacion"
                                        id="btn_Facturacion" type="submit" disabled>
                                        <svg class="c-icon c-icon-1xl">
                                            <use
                                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-description') }} ">
                                            </use>
                                        </svg>
                                        <!-- free.svg#cil-description brand.svg#cib-libreoffice  free.svg#cil-task-->
                                    </button>
                                @endif

                            </form>
                        </div>

                    </td>
                    <td>
                        <div class="row content-center">
                            <form id="form-destroy" action="{{ route('EaCargaIndividualImport.destroy') }}"
                                method="post">
                                @csrf
                                @if (strcmp($registro->estado, 'PROCESADO') == 0)
                                    <button class="btn btn-danger mx-1" title="borrar" name="borrar" id="btn_borrar"
                                        type="submit" disabled>
                                        <svg class="c-icon c-icon-1xl">
                                            <use
                                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-x') }} ">
                                            </use>
                                        </svg>
                                        <!-- free.svg#cil-x-circle brand.svg#cib-experts-exchange brand.svg#cib-x-pack  free.svg#cil-x-->
                                    </button>
                                @else
                                    <input type="hidden" name="carga_resp" value="{{ $registro->cod_carga }}">
                                    <input type="hidden" name="cliente" value="{{ $registro->cliente }}">
                                    <input type="hidden" name="producto" value="{{ $registro->producto }}">
                                    <input type="hidden" name="desc_producto"
                                        value="{{ $registro->desc_producto }}">
                                    <button class="btn btn-danger mx-1" title="borrar" name="borrar"
                                        id="btn_borrar" type="submit">
                                        <svg class="c-icon c-icon-1xl">
                                            <use
                                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-x') }} ">
                                            </use>
                                        </svg>
                                        <!-- free.svg#cil-x-circle brand.svg#cib-experts-exchange brand.svg#cib-x-pack  free.svg#cil-x-->
                                    </button>
                                @endif
                            </form>
                        </div>
                    </td>
                    <!--<button class="btn btn-danger mx-1" title="Eliminar Carga" type="button" data-toggle="modal" data-target="{{ '#eliminar' . $registro->cod_carga }}">
                    <svg class="c-icon c-icon-1xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash') }} "></use>
                    </svg>
                </button>-->
                    @include('cargaInicial.eliminarRegistro', [
                        'row' => $registro->cod_carga,
                        'data' => ${'data' . $registro->cod_carga},
                    ])
                </tr>
            @endforeach
        </tbody>
    @endif
</table>
@if (isset($resumen_cabecera) && count($resumen_cabecera) > 1)
    {{ $resumen_cabecera->links() }}
@endif
