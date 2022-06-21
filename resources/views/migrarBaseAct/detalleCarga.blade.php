<!-- /.modal-->
<div class="modal fade" id="infoDetcarga" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-info" role="document">
    <div class="modal-content" style="width:1000px; right:250px"  >
        <div class="modal-header">
            <h4 class="modal-title">{{'Detalle de carga'}}</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">

            <table class="table table-responsive-sm table-hover table-outline mb-0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">{{'Registros Procesados'}}</th>
                        <th class="text-center">{{'Total de registro existentes en base'}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $cargados_registros }}</td>
                        <td>{{ $existentes_registros }}</td>
                    </tr>
                </tbody>
            </table>
            <br>
            @if ( isset( $existentes_registros))
                <strong>{{'Detalle de los registros existentes en base'}}</strong>
                <table class="table table-responsive-sm table-hover table-outline mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center">{{'Cliente'}}</th>
                            <th class="text-center">{{'ID Cédula'}}</th>
                            <th class="text-center">{{'Nombre'}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $existentes as $val )
                        <tr>
                            <td>{{ $val['cliente'] }}</td>
                            <td>{{ $val['cedula_id'] }}</td>
                            <td>{{ $val['nombre'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
        <div class="modal-footer">
            <button class="btn btn-info" type="button" data-dismiss="modal">{{'Salir'}}</button>
        </div>
    </div>
    <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>
