<!-- /.modal-->
<div class="modal fade" id="{{ 'detalleInfor'.$row }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-info" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">
                    <svg class="c-icon c-icon-2xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-magnifying-glass')}} "></use>
                    </svg>
                    {{'Detalles del registro'}}
            </h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">

           <div class="row text-lg-left">

               <!-- <div class="col-sm-6">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-address-book')}} "></use>
                        </svg>
                        <label>{{'Identificación'}}</label>
                        <input class="form-control"  maxlength="16" id="cedula" maxlength="16" name="cedula" value="{{ isset($cliente->cedula_id) ? $cliente->cedula_id : '' }}" type="number" placeholder="Identificación del cliente" readonly>
                    </div>
                </div> -->
                <div class="col-sm-12 col-md-12">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-opsgenie')}} "></use>
                        </svg>
                        <label>{{'Cliente'}}</label>
                        <input class="form-control" maxlength="40" id="nombre" name="nombre" value="{{ isset($cliente->nombre) ? $cliente->nombre : '' }}" type="text" placeholder="Nombre del cliente" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-location-pin')}} "></use>
                        </svg>
                        <label>{{'Ciudad'}}</label>
                        <input class="form-control" maxlength="20" id="ciudad"  name="ciudad" value="{{ isset($cliente->ciudadet) ? $cliente->ciudadet : '' }}" type="text" placeholder="Ciudad" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-task')}} "></use>
                        </svg>
                        <label>{{'Estado Asistencia'}}</label>
                        <select class="form-control" id="estado" name="estado" disabled>
                            @if ( stripos($registro->estado, 'z') !== false )
                            <option value="{{ isset($cliente->estado) ? $cliente->estado : '' }}"> {{ 'Registro Gestionado' }} </option>
                            @else
                            <option value="{{ isset($cliente->estado) ? $cliente->estado : '' }}"> {{ 'Registro Disponible para gestión' }} </option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-building')}} "></use>
                        </svg>
                        <label>{{'Dirección'}}</label>
                        <input class="form-control" maxlength="79" id="direccion" name="direccion" value="{{ isset($cliente->direccion) ? $cliente->direccion : '' }}" type="text" placeholder="{{'Dirección del cliente'}}" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-gmail')}} "></use>
                        </svg>
                        <label>{{'E-mail'}}</label>
                        <input class="form-control" maxlength="30" id="email" name="mail" value="{{ isset($cliente->mail) ? $cliente->mail : '' }}" type="text" placeholder="{{'Email del cliente'}}" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}} "></use>
                        </svg>
                        <label>{{'Telefono 1'}}</label>
                        <input class="form-control" id="telefono1" name="telefono1" value="{{ isset($cliente->telefono1) ? $cliente->telefono1 : '' }}"  type="number" placeholder="{{'Contacto Telefono 1'}}" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}} "></use>
                        </svg>
                        <label>{{'Telefono 1'}}</label>
                        <input class="form-control" id="telefono1" name="telefono1" value="{{ isset($cliente->telefono1) ? $cliente->telefono1 : '' }}"  type="number" placeholder="{{'Contacto Telefono 1'}}" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-mobile')}} "></use>
                            </svg>
                            <label>{{'Telefono 2'}}</label>
                            <input class="form-control" id="telefono2" name="telefono2" value="{{ isset($cliente->telefono2) ? $cliente->telefono2 : '' }}"  type="number" placeholder="{{'Contacto Telefono 1'}}" readonly>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-info" type="button" data-dismiss="modal">{{'Salir'}}</button>
        </div>
    </div>
    <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>
