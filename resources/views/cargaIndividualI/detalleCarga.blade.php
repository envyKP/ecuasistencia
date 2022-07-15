<!-- /.modal-->
<div class="modal fade" id="{{ 'infoDetcarga'.$row }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-info" role="document">
    <div class="modal-content" style="width:1200px; right:350px"  >
        <div class="modal-header">
            <h4 class="modal-title">{{'Detalle de carga '.$cod_carga}}</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <strong>{{'Detalle del archivo de debito asociado a '.$cliente }}</strong>
            @if ( $estado_cabecera == 'PROCESADO')
            <div class="row col">
                <div class="form-group">
                    <form id="form-EnviarBaseActiva" action="{{route('EaCabCargaInicialController.storeBaseActiva') }}" method="post">
                        @csrf
                        <input type="hidden" name="cod_carga" value="{{ $data->cod_carga }}">
                        <button class="btn btn-success" type="submit" title="Enviar carga a la base Activa">
                            <svg class="c-icon c-icon-1xl mr-2">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cursor')}} "></use>
                            </svg> {{'Enviar data a base activa'}}
                        </button>
                    </form>
                </div>
                <div class="col-sm-12 form-group" id="processCargarBaseActiva" style="display:none" >
                    <strong>{{'Procesando...'}}</strong>
                    <progress class="col-sm-12"  max="100">100%</progress>
                </div>
            </div>
            @endif
            <table class="table table-responsive-sm table-hover table-outline">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">{{''}}</th>
                        <th class="text-center" colspan="2">{{'Acciones'}}</th>
                    </tr>
                </thead>
                <tbody>
                @if (isset($data))
                    <tr>
                        <td class="col-sm-2 col-md-10">  <input class="form-control pt-1" id="archivo" type="file" name="archivo" required> </td>
                        <td > <button class="btn btn-info mx-1" title="Subir archivo XLS/XLSX/txt" type="button" data-toggle="modal" data-target="{{ '#infoDetcarga'.$row }}">
                            <svg class="c-icon c-icon-1xl">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-data-transfer-up')}} "></use>
                            </svg>
                        </button></td>
                        <td > <button class="btn btn-info mx-1" title="Guardar" type="button" data-toggle="modal" data-target="{{ '#infoDetcarga'.$row }}">
                            <svg class="c-icon c-icon-1xl">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save')}} "></use>
                            </svg>
                        </button></td>
                      
                    </tr>
                @endif
                <!--<tr>
                    <td><p><small>{{'Por favor asegurese que el nombre del archivo no tenga espacios o caracteres especiales'}}</small></p></td>
                </tr>-->
                
                </tbody>
                
            </table>
            
            @if ( isset( $registros_no_cumplen))
            <strong>{{'Detalle de regsitros sin información'}}</strong>
            <table class="table table-responsive-sm table-hover table-outline">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">{{'Nombre Completo'}}</th>
                        <th class="text-center">{{'Cédula'}}</th>
                        <th class="text-center">{{'Telefono 1'}}</th>
                        <th class="text-center">{{'Telefono 2'}}</th>
                        <th class="text-center">{{'Telefono 3'}}</th>
                        <th class="text-center">{{'Telefono 4'}}</th>
                        <th class="text-center">{{'Telefono 5'}}</th>
                        <th class="text-center">{{'Telefono 6'}}</th>
                        <th class="text-center">{{'Telefono 7'}}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ( $registros_no_cumplen as $val )
                    <tr>
                        <td><strong>{{ isset($val['nombre_completo']) ? $val['nombre_completo'] : '' }}</strong></td>
                        <td><strong>{{ isset($val['cedula']) ?  $val['cedula'] : '' }}</strong></td>
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
            @if ( $estado_cabecera == 'PROCESADO')
            <div class="col-sm-2 col-md-2">
                <form action="{{route('EaCabCargaInicialController.exportar_reporte')}}" method="post">
                    @csrf
                    @method('post')
                    <input type="hidden" name="cod_carga" value="{{ $data->cod_carga }}" >
                    <input type="hidden" name="proceso" value="{{ $data->proceso }}" >
                    <button class="btn btn-success" id="btn-generar_reporte" title="Subir Archivo" type="submit">
                        <svg class="c-icon c-icon-1xl">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-download')}} "></use>
                        </svg> {{'Descargar reporte'}}
                    </button>
                </form>
            </div>
            @endif
            <button class="btn btn-info" type="button" data-dismiss="modal">{{'Salir'}}</button>
        </div>
    </div>
    <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>
