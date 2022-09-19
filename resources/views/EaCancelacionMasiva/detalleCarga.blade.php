<!-- /.modal-->
<div class="modal fade" id="{{ 'infoDetcarga' . $row }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-info" role="document">
        <div class="modal-content" style="width:1200px; right:350px">
            <div class="modal-header">
                <h4 class="modal-title">{{ 'Detalle de carga' }}</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <strong>{{ 'Detalle del archivo procesado' }}</strong>

                <table class="table table-responsive-sm table-hover table-outline">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center">{{ 'Total de registros en archivo' }}</th>
                            <th class="text-center">{{ 'Total de registros duplicados' }}</th>
                            <th class="text-center">{{ 'Total de registros sin información' }}</th>
                            <th class="text-center">{{ 'Total de registros disponibles para la gestión' }}</th>
                            <th class="text-center">{{ 'Total de registros gestionados en otras campañas' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($data))
                            <tr>
                                <td>{{ $data->total_registros_archivo }}</td>
                                <td>{{ $data->total_registros_duplicados }}</td>
                                <td>{{ $data->total_registros_sin_infor }}</td>
                                <td>{{ $data->total_registros_disponibles_gestion }}</td>
                                <td>{{ $data->total_registros_gestionados_otras_campanas }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                @if (isset($registros_no_cumplen))
                    <strong>{{ 'Detalle de regsitros sin información' }}</strong>
                    <table class="table table-responsive-sm table-hover table-outline">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">{{ 'Nombre Completo' }}</th>
                                <th class="text-center">{{ 'Cédula' }}</th>
                                <th class="text-center">{{ 'Telefono 1' }}</th>
                                <th class="text-center">{{ 'Telefono 2' }}</th>
                                <th class="text-center">{{ 'Telefono 3' }}</th>
                                <th class="text-center">{{ 'Telefono 4' }}</th>
                                <th class="text-center">{{ 'Telefono 5' }}</th>
                                <th class="text-center">{{ 'Telefono 6' }}</th>
                                <th class="text-center">{{ 'Telefono 7' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registros_no_cumplen as $val)
                                <tr>
                                    <td><strong>{{ isset($val['nombre_completo']) ? $val['nombre_completo'] : '' }}</strong>
                                    </td>
                                    <td><strong>{{ isset($val['cedula']) ? $val['cedula'] : '' }}</strong></td>
                                    <td><strong>{{ isset($val['telefono1']) ? $val['telefono1'] : '' }}</strong></td>
                                    <td><strong>{{ isset($val['telefono2']) ? $val['telefono2'] : '' }}</strong></td>
                                    <td><strong>{{ isset($val['telefono3']) ? $val['telefono3'] : '' }}</strong></td>
                                    <td><strong>{{ isset($val['telefono4']) ? $val['telefono4'] : '' }}</strong></td>
                                    <td><strong>{{ isset($val['telefono5']) ? $val['telefono5'] : '' }}</strong></td>
                                    <td><strong>{{ isset($val['telefono6']) ? $val['telefono6'] : '' }}</strong></td>
                                    <td><strong>{{ isset($val['telefono7']) ? $val['telefono7'] : '' }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- $registros_no_cumplen->links() --}}
                @endif
            </div>
            <div class="modal-footer">
                @if ($estado_cabecera == 'PROCESADO')
                    <table class="table table-responsive-sm table-hover table-outline">

                        <div class="row col">

                            <div class="form-group">
                                <form id="form-EnviarBaseActiva"
                                    action="{{ route('EaCancelacionMasivaController.borrarEnBaseActiva') }}"
                                    method="post">
                                    @csrf
                                    <td>
                                        <input type="hidden" name="cod_carga" value="{{ $data->cod_carga }}">
                                    </td>
                                    <td>
                                        <strong class="col-sm-2 col-md-2">{{ 'Motivo de cancelacion: ' }}</strong>
                                    </td>

                                    <td>
                                        <textarea class="col-sm-2 col-md-12" id="observaciones" name="observaciones" maxlength="500" required></textarea>
                                        <!--<textarea class="col-sm-2 col-md-12" id="obsercaciones" name="obsercaciones" maxlength="600"></textarea> tambien aplicable , con el limite maximo de caracteres-->
                                    </td>
                                    <td>
                                        <button class="btn btn-success" type="submit" title=" base Activa">
                                            <svg class="c-icon c-icon-1xl mr-2">
                                                <use
                                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cursor') }} ">
                                                </use>
                                            </svg> {{ 'Cancelar registros en base activa' }}
                                        </button>
                                    </td>



                                </form>
                            </div>
                            <div class="col-sm-12 form-group" id="processCargarBaseActiva" style="display:none">
                                <strong>{{ 'Procesando...' }}</strong>
                                <progress class="col-sm-12" max="100">100%</progress>
                            </div>
                        </div>

                    </table>
                @endif
                <button class="btn btn-info" type="button" data-dismiss="modal">{{ 'Salir' }}</button>
            </div>
        </div>
        <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>
