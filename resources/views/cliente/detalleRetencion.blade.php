<!-- /.modal-->
<div class="modal fade" id="infoDetRetencion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-info" role="document">
    <div class="modal-content" style="width:1000px; right:250px"  >
        <div class="modal-header">
            <h4 class="modal-title">{{'Detalle de la Retención'}}</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">

            <table class="table table-responsive-sm table-hover table-outline mb-0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">{{'Detalle Retención'}}</th>
                        <th class="text-center">{{'Motivo Desactivación'}}</th>
                        <th class="text-center">{{'Origen'}}</th>
                        <th class="text-center">{{'Fecha registra'}}</th>
                        <th class="text-center">{{'Usuario registra'}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td>{{ isset($retencionCliente->det_retencion) ? $retencionCliente->det_retencion : '' }}</td>
                        <td>{{ isset($retencionCliente->motivo_desactivacion) ? $retencionCliente->motivo_desactivacion : '' }}</td>
                        @switch( isset($retencionCliente->origen) ? $retencionCliente->origen : '')
                            @case('llamada')
                            <td>{{ 'LLAMADA' }}</td>
                            @break
                            @case('correo_electronico')
                            <td>{{ 'CORREO ELECTRONICO' }}</td>
                            @break
                        @endswitch
                        <td>{{ isset($retencionCliente->fecha_reg) ? $retencionCliente->fecha_reg : '' }}</td>
                        <td>{{ isset($retencionCliente->usuario_reg) ?  $retencionCliente->usuario_reg : '' }}</td>
                    </tr>
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
