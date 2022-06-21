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
                        <th class="text-center">{{'Total registros en archivo'}}</th>
                        <th class="text-center">{{'No. de ejecuciones o cargas'}}</th>
                        <th class="text-center">{{'Total registros sin información'}}</th>
                        <th class="text-center">{{'Total ventas efectivas'}}</th>
                        <th class="text-center">{{'Total otros call types de ventas'}}</th>
                    </tr>
                </thead>
                <tbody>
                @if (isset($data))
                    <tr>
                        <td>{{ $data->total_registros_archivo }}</td>
                        <td>{{ $data->no_ejecucion }}</td>
                        <td>{{ $data->total_registros_sin_infor }}</td>
                        <td>{{ $data->total_registros_aceptan }}</td>
                        <td>{{ $data->total_otros_call_types }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button class="btn btn-info" type="button" data-dismiss="modal">{{'Salir'}}</button>
        </div>
    </div>
    <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>
