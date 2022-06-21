<!-- /.modal-->
<div class="modal fade" id="{{ 'infoDetcarga'.$row }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-info" role="document">
    <div class="modal-content" style="width:1200px; right:350px"  >
        <div class="modal-header">
            <h4 class="modal-title">{{'Detalle de carga'}}</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <strong>{{'Detalle del archivo procesado'}}</strong>
            <table class="table table-responsive-sm table-hover table-outline">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">{{'Total de registros en archivo'}}</th>
                        <th class="text-center">{{'Total de registros sin información financiera'}}</th>
                    </tr>
                </thead>
                <tbody>
                @if (isset($data))
                    <tr>
                        <td>{{ $data->total_registros_archivo }}</td>
                        <td>{{ $data->total_registros_sin_infor }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <form action="{{route('EaGenArchiFinanController.export_sin_infor_finan', ['cod_carga' => $data->cod_carga] )}}" method="get">
                <button class="btn btn-success mx-1"  id="btn-generar_archivo" title="Exportar Archivo" type="submit">
                    <svg class="c-icon c-icon-1xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-download')}} "></use>
                    </svg>{{' Exportar Archivo '}}
                </button>
            </form>
            <button class="btn btn-info" type="button" data-dismiss="modal">{{'Salir'}}</button>
        </div>
    </div>
    <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>
