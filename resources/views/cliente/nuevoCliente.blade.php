<!-- /.modal-->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-success modal-lg" role="document">
<div class="modal-content" style="width:1500px; right:350px">
    <form action="{{ route('EaBaseActivaController.store') }}" method="post">
        @csrf
        @method('post')
        <div class="modal-header">
            <h4 class="modal-title">
                <svg class="c-icon c-icon-2xl">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-note-add')}} "></use>
                </svg>
                {{'Nuevo Cliente'}}
            </h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <input type="hidden" name="usmod" value="{{ Auth::user()->username }}">
                <input type="hidden" name="cliente" value="{{ isset($campana->cliente) ? $campana->cliente : '' }}">
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-opsgenie')}} "></use>
                        </svg>
                        <label>{{'Cliente'}}</label>
                        <input class="form-control" maxlength="40" name="nombre" value="" type="text" placeholder="Nombre del cliente" required
                        oninput="this.value = this.value.toUpperCase();">
                    </div>
                </div>
                <div class="col-sm-2 co-md-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-contact')}} "></use>
                        </svg>
                        <label>{{'Tipo Identifación'}}</label>
                        <select class="form-control"  name="tipide" required>
                            <option value="" selected>{{'Seleccione un tipo'}}</option>
                            @foreach( $tiposIdentificacion as $tipoIden )
                            <option value="{{ isset($tipoIden->codigo_id) ? $tipoIden->codigo_id : '' }}">{{ isset($tipoIden->descripcion_id) ? $tipoIden->descripcion_id : 'Tipo de Identifación' }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-address-book')}} "></use>
                            </svg>
                            <label>{{'Identificación'}}</label>
                            <input class="form-control"  maxlength="16" onkeypress="return isNumberKey(event)"
                            maxlength="16" name="cedula_id" value="" type="number" placeholder="Identificación del cliente" required>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-people')}} "></use>
                        </svg>
                        <label>{{'Genero'}}</label>
                        <select class="form-control" name="genero" required>
                            <option value="" selected>{{'Seleccione un tipo'}}</option>
                            <option value="MASCULINO">{{'MASCULINO'}}</option>
                            <option value="FEMENINO">{{'FEMENINO'}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-location-pin')}} "></use>
                        </svg>
                        <label>{{'Ciudad'}}</label>
                        <select class="form-control" id="ciudad" name="ciudad" required>
                            <option value="" selected>{{'Seleccione una ciudad'}}</option>
                            @foreach( $ciudades as $ciudad )
                            <option value="{{ isset($ciudad->ciudad) ? $ciudad->ciudad : '' }}">{{ isset($ciudad->detalle) ? $ciudad->detalle : 'ciudad de residencia' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-md-4">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-building')}} "></use>
                        </svg>
                        <label>{{'Dirección'}}</label>
                        <input class="form-control" maxlength="79"  name="direccion" value="" type="text" placeholder="{{'Dirección del cliente'}}" required
                        oninput="this.value = this.value.toUpperCase();">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}} "></use>
                        </svg>
                        <label>{{'Fecha Nacimiento'}}</label>
                        <input class="form-control" maxlength="20" name="fechanacimiento" value="" type="date" placeholder="Fecha de nacimiento cliente" required>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-credit-card')}} "></use>
                        </svg>
                        <label>{{'Detalle Tipo de Tarjeta'}}</label>
                        <select class="form-control" name="tiptar" required>
                            <option value="" selected>{{'Seleccione un tipo'}}</option>
                            <option value="P">{{'PRINCIPAL'}}</option>
                            <option value="A">{{'ADICIONAL'}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-credit-card')}}"></use>
                        </svg>
                        <label>{{'Producto'}}</label>
                        <select class="form-control" name="producto" id="productoClienteNuevo">
                            <option value="{{ isset($cliente->producto) ? $cliente->producto : '' }}" selected>{{ isset($cliente->producto) ? $cliente->producto : 'Seleccione un producto' }}</option>
                            @foreach($productos as $producto)
                            <option value="{{ $producto->contrato_ama }}">{{ $producto->desc_producto }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cc-visa')}}"></use>
                        </svg>
                        <label>{{'SubProducto'}}</label>
                        <select class="form-control" name="subproducto" id="subprodClienteNuevo">
                            <option value="">{{'Seleccione un subproducto'}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-thumb-up')}} "></use>
                        </svg>
                        <label>{{'Estado Gestión del registro'}}</label>
                        <select class="form-control" name="estado" readonly >
                            <option value="A" selected>{{'Registro Disponible para gestión'}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-mastercard')}} "></use>
                        </svg>
                        <label>{{'Detalle Tipo de Activación'}}</label>
                        <select class="form-control" name="tipact"  readonly>
                            <option value="N" selected>{{'NUEVA'}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-diamond')}} "></use>
                        </svg>
                        <label>{{'Detalle Estado del Cliente'}}</label>
                        <select class="form-control" name="codestado" readonly>
                            <option value="P" selected>{{'PENDIENTE'}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-mobile')}} "></use>
                        </svg>
                        <label>{{'Telefono contacto'}}</label>
                        <input class="form-control" maxlength="30"  name="telefono_contacto" value="" type="text" placeholder="{{'Teléfono contacto'}}" required>
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-gmail')}} "></use>
                        </svg>
                        <label>{{'E-mail'}}</label>
                        <input class="form-control" maxlength="40" name="mail" value="" type="text" placeholder="{{'Email del cliente'}}">
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}} "></use>
                        </svg>
                        <label>{{'Telefono 1'}}</label>
                        <input class="form-control"  name="telefono1" value=""  type="number" placeholder="{{'Teléfono 1'}}">
                    </div>
                </div>
            </div>
           <!-- /.row-->
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}} "></use>
                        </svg>
                        <label>{{'Telefono 2'}}</label>
                        <input class="form-control"  name="telefono2" value=""  type="number" placeholder="{{'Teléfono 2'}}">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}} "></use>
                        </svg>
                        <label>{{'Telefono 3'}}</label>
                        <input class="form-control"  name="telefono3" value=""  type="number" placeholder="{{'Teléfono 3'}}">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}} "></use>
                        </svg>
                        <label>{{'Telefono 4'}}</label>
                        <input class="form-control"  name="telefono4" value=""  type="number" placeholder="{{'Teléfono 4'}}">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}} "></use>
                        </svg>
                        <label>{{'Telefono 5'}}</label>
                        <input class="form-control" name="telefono5" value=""  type="number" placeholder="{{'Teléfono 5'}}">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}} "></use>
                        </svg>
                        <label>{{'Telefono 6'}}</label>
                        <input class="form-control"  name="telefono6" value=""  type="number" placeholder="{{'Teléfono 6'}}">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <svg class="c-icon c-icon-1xl mr-1">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}} "></use>
                        </svg>
                        <label>{{'Telefono 7'}}</label>
                        <input class="form-control" name="telefono7" value=""  type="number" placeholder="{{'Teléfono 7'}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">{{'Salir'}}</button>
            <button class="btn btn-success" type="submit">
                <svg class="c-icon c-icon-1xl">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save')}} "></use>
                </svg>
            </button>
        </div>
    </form>
</div>
<!-- /.modal-content-->
</div>
<!-- /.modal-dialog-->
</div>
