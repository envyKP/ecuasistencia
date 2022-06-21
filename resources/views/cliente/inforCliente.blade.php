<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('EaBaseActivaController.editCli') }}"  id="form-editCliente"  method="POST">
                @csrf
                @method('post')
                <div class="row">
                    <input type="hidden" name="cliente" id="cliente"  value="{{ isset($campana->cliente) ? $campana->cliente : '' }}">
                    <input type="hidden" name="usmod"   value="{{ Auth::user()->username }}">
                    <input type="hidden" name="id_sec"  value=" {{ isset($cliente->id_sec) ? $cliente->id_sec : '' }} ">

                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-opsgenie')}} "></use>
                            </svg>
                            <label>{{'Cliente'}}</label>
                            <input class="form-control" maxlength="40" id="nombre" name="nombre" value="{{ isset($cliente->nombre) ? $cliente->nombre : old('nombre') }}" type="text" placeholder="Nombre del cliente" readonly
                            oninput="this.value = this.value.toUpperCase();">
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-credit-card')}}"></use>
                            </svg>
                            <label>{{'Producto'}}</label>
                            <select class="form-control" name="producto" id="producto" disabled>
                                <option value="">{{'Seleccione un producto'}}</option>
                                @foreach( $productos as $producto)
                                    @if ( isset($cliente->producto) && $cliente->producto == $producto->contrato_ama )
                                    <option value="{{ isset($cliente->producto) ? $cliente->producto : '' }}" selected>{{ $cliente->desc_producto }}</option>
                                    @else
                                    <option value="{{ $producto->contrato_ama }}">{{ $producto->desc_producto }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cc-visa')}}"></use>
                            </svg>
                            <label>{{'SubProducto'}}</label>
                            <select class="form-control" name="subproducto" id="subproducto" disabled required>
                                <option value="{{ isset($cliente->subproducto) ? $cliente->subproducto : '' }}" selected>{{ isset($cliente->subproducto) ? $cliente->subproducto : 'Seleccione un producto' }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.row-->
                <div class="row">
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-contact')}} "></use>
                            </svg>
                            <label>{{'Tipo Identifación'}}</label>
                            <select class="form-control" id="tipide" name="tipide" disabled>
                                @foreach( $tiposIdentificacion as $tipoIden )
                                    @if ( isset($cliente->tipide) && ($cliente->tipide ==  $tipoIden->codigo_id) )
                                    <option value="{{ isset($cliente->tipide) ? $cliente->tipide : '' }}" selected>{{ isset($cliente->dettipide) ? $cliente->dettipide : 'Seleccione un tipo' }}</option>
                                    @else
                                    <option value="{{ isset($tipoIden->codigo_id) ? $tipoIden->codigo_id : '' }}">{{ isset($tipoIden->descripcion_id) ? $tipoIden->descripcion_id : 'Tipo de Identifación' }} </option>
                                    @endif
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
                                <input class="form-control"  maxlength="16"  maxlength="16" id="cedula_id" name="cedula_id" value="{{ isset($cliente->cedula_id) ? $cliente->cedula_id : '' }}" type="number" placeholder="Identificación del cliente" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-credit-card')}} "></use>
                            </svg>
                            <label>{{'Detalle Tipo de Tarjeta'}}</label>
                            <select class="form-control"  id="tiptar" name="tiptar" disabled required>
                                <option value="{{ isset($cliente->tiptar) ? $cliente->tiptar : '' }}" selected>{{ !empty($cliente->dettiptar) ? $cliente->dettiptar : 'Detalle Tipo de Tarjeta' }}</option>
                                @switch( isset( $cliente->tiptar) ? $cliente->tiptar : '' )
                                    @case('A'):
                                        <option value="P">{{'PRINCIPAL'}}</option>
                                    @break
                                    @case('P')
                                        <option value="A">{{'ADICIONAL'}}</option>
                                    @break
                                    @default
                                        <option value="P">{{'PRINCIPAL'}}</option>
                                        <option value="A">{{'ADICIONAL'}}</option>
                                    @break
                                @endswitch
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-people')}} "></use>
                            </svg>
                            <label>{{'Genero'}}</label>
                            <select class="form-control"  id="genero" name="genero" disabled>
                                @switch(isset($cliente->genero) ? $cliente->genero : '')
                                    @case('MASCULINO')
                                    <option value="{{ isset($cliente->genero) ? $cliente->genero : '' }}" selected>{{isset($cliente->genero) ? $cliente->genero : '' }}</option>
                                    <option value="FEMENINO">{{'FEMENINO'}}</option>
                                    @break
                                    @case('FEMENINO')
                                    <option value="{{ isset($cliente->genero) ? $cliente->genero : '' }}" selected>{{isset($cliente->genero) ? $cliente->genero : '' }}</option>
                                    <option value="MASCULINO">{{'MASCULINO'}}</option>
                                    @break
                                    @default
                                    <option value="" selected>{{'Seleccione un tipo'}}</option>
                                    <option value="MASCULINO">{{'MASCULINO'}}</option>
                                    <option value="FEMENINO">{{'FEMENINO'}}</option>
                                @endswitch
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-location-pin')}} "></use>
                            </svg>
                            <label>{{'Ciudad'}}</label>
                            <select class="form-control" id="ciudad" name="ciudad" disabled required>
                                <option value="{{ isset($cliente->ciudad) ? $cliente->ciudad : '' }}">{{ isset($cliente->ciudadet) ? $cliente->ciudadet : 'ciudad de residencia' }}</option>
                                @foreach( $ciudades as $ciudad )
                                <option value="{{ isset($ciudad->ciudad) ? $ciudad->ciudad : '' }}">{{ isset($ciudad->detalle) ? $ciudad->detalle : 'ciudad de residencia' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}} "></use>
                            </svg>
                            <label>{{'Fecha Nacimiento'}}</label>
                            <input class="form-control"  type="date" id="fechanacimiento"  name="fechanacimiento" value="{{ isset($cliente->fechanacimiento) ? $cliente->fechanacimiento : '' }}"  placeholder="Fecha de nacimiento cliente" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-building')}} "></use>
                            </svg>
                            <label>{{'Dirección'}}</label>
                            <input class="form-control" maxlength="79" id="direccion" name="direccion" value="{{ isset($cliente->direccion) ? $cliente->direccion : '' }}" type="text" placeholder="{{'Dirección del cliente'}}" readonly
                            oninput="this.value = this.value.toUpperCase();">
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-mobile')}} "></use>
                            </svg>
                            <label>{{'Telefono contacto'}}</label>
                            <input class="form-control" maxlength="30" id="telefono_contacto"  min="0" pattern="^[0-9]+" name="telefono_contacto" value="{{ isset($cliente->telefono_contacto) ? $cliente->telefono_contacto : '' }}" type="text" placeholder="{{'Teléfono contacto'}}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-gmail')}} "></use>
                            </svg>
                            <label>{{'E-mail'}}</label>
                            <input class="form-control" maxlength="30" id="mail" name="mail" value="{{ isset($cliente->mail) ? $cliente->mail : '' }}" type="email" placeholder="{{'Email del cliente'}}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}} "></use>
                            </svg>
                            <label>{{'Telefono 1'}}</label>
                            <input class="form-control" id="telefono1" name="telefono1"  min="0" pattern="^[0-9]+" value="{{ isset($cliente->telefono1) ? $cliente->telefono1 : '' }}"  type="number" placeholder="{{'Teléfono 1'}}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}} "></use>
                            </svg>
                            <label>{{'Telefono 2'}}</label>
                            <input class="form-control" id="telefono2" name="telefono2" min="0" pattern="^[0-9]+" value="{{ isset($cliente->telefono2) ? $cliente->telefono2 : '' }}"  type="number" placeholder="{{'Teléfono 2'}}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}} "></use>
                            </svg>
                            <label>{{'Telefono 3'}}</label>
                            <input class="form-control" id="telefono3" name="telefono3" min="0" pattern="^[0-9]+" value="{{ isset($cliente->telefono3) ? $cliente->telefono3 : '' }}"  type="number" placeholder="{{'Teléfono 3'}}" readonly>
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
                            <label>{{'Telefono 4'}}</label>
                            <input class="form-control" id="telefono4" min="0" pattern="^[0-9]+" name="telefono4" value="{{ isset($cliente->telefono4) ? $cliente->telefono4 : '' }}"  type="number" placeholder="{{'Teléfono 4'}}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}} "></use>
                            </svg>
                            <label>{{'Telefono 5'}}</label>
                            <input class="form-control" id="telefono5" min="0" pattern="^[0-9]+" name="telefono5" value="{{ isset($cliente->telefono5) ? $cliente->telefono5 : '' }}"  type="number" placeholder="{{'Teléfono 5'}}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}} "></use>
                            </svg>
                            <label>{{'Telefono 6'}}</label>
                            <input class="form-control" id="telefono6" min="0" pattern="^[0-9]+" name="telefono6" value="{{ isset($cliente->telefono6) ? $cliente->telefono6 : '' }}"  type="number" placeholder="{{'Teléfono 6'}}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <svg class="c-icon c-icon-1xl mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}} "></use>
                            </svg>
                            <label>{{'Telefono 7'}}</label>
                            <input class="form-control" id="telefono7" min="0" pattern="^[0-9]+" name="telefono7" value="{{ isset($cliente->telefono7) ? $cliente->telefono7 : '' }}"  type="number" placeholder="{{'Teléfono 7'}}" readonly>
                        </div>
                    </div>
                </div>
                </form>
                <!-- /.row-->
                <div class="row mb-0">
                    <div class="col-sm-3 col-md-3">
                        @if( Auth::user()->rol == 'admin' )
                            <button class="btn btn-success" title="Agregar nuevo cliente" type="button" data-toggle="modal" data-target="#successModal">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-note-add')}} "></use>
                                </svg>
                            </button>
                            @include('cliente.nuevoCliente')
                        @endif

                        @if( !empty($cliente) && Auth::user()->rol == 'admin' )
                        <button class="btn btn-outline-success" title="Editar Registro" id="btn-editCliente" type="button">
                            <svg class="c-icon c-icon-1xl">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pen')}} "></use>
                            </svg>
                        </button>
                        @endif
                        <button class="btn  btn-outline-danger" title="Cancelar operación" id="btn-cancelarCliente" type="button" style="visibility:hidden">
                            <svg class="c-icon c-icon-1xl">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}} "></use>
                            </svg>
                        </button>
                        <button class="btn  btn-outline-success" id="btn-saveCliente" title="Guardar cambios" type="button" style="visibility:hidden" data-toggle="modal" data-target="{{'#guardarDatosCliente'}}">
                            <svg class="c-icon c-icon-1xl">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save')}} "></use>
                            </svg>
                        </button>
                        @include('cliente.guardarDatosCliente')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
