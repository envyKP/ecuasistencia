<!-- /.modal-->


<div class="modal fade" id="{{ 'infoDetcarga' . $row }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-info" role="document">
        <strong id='demo' name='demo'></strong>
        <div>
            @if (session('success'))
                <div class="col-sm-12 col-md-12">
                    <div class="alert alert-primary alert-dismissible fade show " role="alert">
                        <svg class="c-icon c-icon-2xl">
                            <use
                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle') }}">
                            </use>
                        </svg>
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="col-sm-12 col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show " role="alert">
                        <svg class="c-icon c-icon-2xl">
                            <use
                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash') }}">
                            </use>
                        </svg>
                        <strong>{{ session('error') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
        </div>



        <div class="modal-content" style="width:1200px; right:350px">
            <div class="modal-header">
                <h4 class="modal-title">{{ 'Detalle de carga ' . $cod_carga }}</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <strong>{{ 'Detalle del archivo de debito asociado a ' . $cliente }}</strong>
                <table class="table table-responsive-sm table-hover table-outline">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center">{{ '' }}</th>
                            <th class="text-center" colspan="2">{{ 'Acciones' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($data))
                            <tr>

                                <form id="form-uploadArchivos" enctype="multipart/form-data" accept-charset="utf-8">
                                    @csrf
                                    <td class="col-sm-2 col-md-10"> <input class="form-control pt-1" id="archivo"
                                            type="file" name="archivo" required> </td>
                                    <input type="hidden" name="cod_carga" value="{{ $carga_resp }}">
                                    <input type="hidden" name="cliente" value="{{ $cliente }}">
                                    <input type="hidden" name="producto" value="{{ $producto }}">
                                    <input type="hidden" name="desc_producto" value="{{ $desc_producto }}">
                                    <input type="hidden" name="estado_cabecera" value="{{ $estado_cabecera }}">
                                    <input type="hidden" name="registros_no_cumplen"
                                        value="{{ $registros_no_cumplen }}">
                                    <input type="hidden" name="usuario_actualiza"
                                        value="{{ \Auth::user()->username }}">
                                    <input type="hidden" name="row" value="{{ $row }}">
                                    <td> <button class="btn btn-info mx-1" title="Subir archivo XLS/XLSX/txt"
                                            type="button" onclick="upload_function(this.form, '{{$row.$cliente.$producto}}')"
                                            enctype="multipart/form-data">
                                            <svg class="c-icon c-icon-1xl">
                                                <use
                                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-data-transfer-up') }} ">
                                                </use>
                                            </svg>
                                        </button></td>
                                </form>
                                <td> <button class="btn btn-info mx-1" title="Guardar" type="button"
                                        onclick="procesar_function('{{ $cod_carga }}','{{ $cliente }}','{{ $producto }}','{{ $desc_producto }}', '{{ $estado_cabecera }}', '{{$row.$cliente.$producto}}')">
                                        <svg class="c-icon c-icon-1xl">
                                            <use
                                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save') }} ">
                                            </use>
                                        </svg>
                                    </button></td>

                            </tr>
                        @endif

                        <!--<tr>
                    <td><p><small>{{ 'Por favor asegurese que el nombre del archivo no tenga espacios o caracteres especiales' }}</small></p></td>
                </tr>-->
                    </tbody>
                </table>
                <!--<table class="table table-responsive-sm table-hover table-outline">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center">{{ 'cliente' }}</th>
                            <th class="text-center">{{ 'cod_carga' }}</th>
                            <th class="text-center">{{ 'data->cod_carga' }}</th>
                            <th class="text-center">{{ 'estado_cabecera' }}</th>
                            <th class="text-center">{{ 'producto' }}</th>
                            <th class="text-center">{{ 'registros_no_cumplen' }}</th>
                            <th class="text-center">{{ 'carga_resp' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                           
                        </tr>
                    </tbody>
                </table>-->
                <!--<div class="col-sm-12 form-group" id="processCarga" style="display:none"> -->
                <div class="col-sm-12 form-group" id="processCargaDetalle{{$row.$cliente.$producto}}" style="display:none">
                    <strong>{{ 'Procesando...' }}</strong>
                    <progress class="col-sm-12" max="100">100%</progress>
                </div>


            </div>
            <div class="modal-footer">
                @if ($estado_cabecera == 'PROCESADO')
                    <div class="col-sm-2 col-md-2">
                        <form action="{{ route('EaCabCargaInicialController.exportar_reporte') }}" method="post">
                            @csrf
                            @method('post')
                            <input type="hidden" name="proceso" value="{{ $data->proceso }}">
                            <input type="hidden" name="cod_carga" value="{{ $carga_resp }}">
                            <input type="hidden" name="cliente" value="{{ $cliente }}">
                            <input type="hidden" name="producto" value="{{ $producto }}">
                            <input type="hidden" name="desc_producto" value="{{ $desc_producto }}">
                            <input type="hidden" name="estado_cabecera" value="{{ $estado_cabecera }}">
                            <input type="hidden" name="registros_no_cumplen" value="{{ $registros_no_cumplen }}">
                            <input type="hidden" name="usuario_actualiza" value="{{ \Auth::user()->username }}">
                           
                        </form>
                    </div>
                @endif
                <button class="btn btn-info" type="button" data-dismiss="modal">{{ 'Salir' }}</button>
            </div>
        </div>
        <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>
