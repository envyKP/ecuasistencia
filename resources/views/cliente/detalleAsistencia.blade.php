<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('EaBaseActivaController.editAsistencia') }}" method="post" id="form-saveAsis">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <input type="hidden" name="usmod" value="{{ Auth::user()->username }}">
                        <input type="hidden" name="cliente" value="{{ isset($campana->cliente) ? $campana->cliente : '' }}">
                        <input type="hidden" name="id_sec" value="{{ isset($cliente->id_sec) ? $cliente->id_sec : '' }}">
                        <input type="hidden" name="cedula_id" value="{{ isset($cliente->cedula_id) ? $cliente->cedula_id : '' }}">

                        <div  class="col-lg-1 col-md-1 col-lg-1 col-xl-1">
                                <label>{{'Fecha'}}</label>
                                <input class="form-control" id="fecha" type="text" name="fecha" placeholder="date" value="{{ $fecha }}" readonly>
                        </div>
                        <div class="col-lg-1 col-md-1 col-lg-1 col-xl-1">
                            <label>{{'hora'}}</label>
                            <input class="form-control" name="horasys" id="horasys" type="text" id="appt" name="appt" min="09:00" max="18:00" value="" readonly>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-voice-over-record')}} "></use>
                                </svg>
                                <label>{{'Proveedor'}}</label>
                                <input class="form-control" maxlength="50" name="proveedor" id="proveedor" value="{{ isset($cliente->proveedor) ? $cliente->proveedor : '' }}"  type="text" placeholder="Nombre del proveedor" readonly>
                            </div>
                        </div>
                       <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-voice-over-record')}} "></use>
                                </svg>
                                <label>{{'Operador de venta'}}</label>
                                <input class="form-control" maxlength="50" name="operador" id="operador" value="{{ isset($cliente->operador) ? $cliente->operador : '' }}"  type="text" placeholder="Nombre del operador" readonly>
                            </div>
                        </div>
                        @if ( stripos( Auth::user()->rol,'admin') !== false )
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-chart-pie')}} "></use>
                                </svg>
                                <label>{{'Detalle del Ciclo'}}</label>
                                <select class="form-control" id="ciclo" name="ciclo" disabled required>
                                    <option value="" selected>{{'Seleccione un ciclo'}}</option>
                                    @foreach ($ciclosCortes as $ciclos)
                                        @if( isset( $cliente->ciclo) && ($cliente->ciclo == $ciclos->ciclo) )
                                        <option value="{{ isset($cliente->ciclo) ? $cliente->ciclo : '' }}" selected>{{ isset($cliente->dettipcic) ? $cliente->dettipcic : '' }}</option>
                                        @else
                                        <option value="{{$ciclos->ciclo}}">{{ $ciclos->corte }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-money')}} "></use>
                                </svg>
                                <label>{{'Detalle Tipo de Cuenta'}}</label>
                                <select class="form-control" id="tipcta" name="tipcta" disabled required >
                                    @switch( isset( $cliente->tipcta) ? $cliente->tipcta : '' )
                                        @case('AHO')
                                            <option value="{{ isset($cliente->tipcta) ? $cliente->tipcta : '' }}" selected>{{'AHORRO'}}</option>
                                            <option value="CTE">{{'CORRIENTE'}}</option>
                                        @break
                                        @case('CTE')
                                            <option value="{{ isset($cliente->tipcta) ? $cliente->tipcta : '' }}" selected>{{'CORRIENTE'}}</option>
                                            <option value="AHO">{{'AHORRO'}}</option>
                                        @break
                                        @default
                                            <option value="">{{'Seleccione tipo de cuenta'}}</option>
                                            <option value="AHO">{{'AHORRO'}}</option>
                                            <option value="CTE">{{'CORRIENTE'}}</option>
                                        @break
                                    @endswitch
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-money')}} "></use>
                                </svg>
                                <label>{{'Cuenta'}}</label>
                                <input class="form-control" name="cuenta" id="cuenta" value="{{ !empty($cliente->cuenta) ? substr_replace($cliente->cuenta, 'XXXXXXX', 3 ) : '' }}"  type="text" placeholder="0000 0000 0000 0000" readonly>
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- /.row-->
                    <div class="row">
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-thumb-up')}} "></use>
                                </svg>
                                <label>{{'Gestión del registro'}}</label>
                                <select class="form-control" id="estado" name="estado" disabled required>
                                    @switch(isset($cliente->estado) ? $cliente->estado : '')
                                    @case ('A')
                                    <option value="{{ isset($cliente->estado) ? $cliente->estado : '' }}" selected>{{ isset($cliente->estado) ? 'Registro Disponible para gestión' : '' }}</option>
                                    @break
                                    @case('Z')
                                    <option value="{{ isset($cliente->estado) ? $cliente->estado : '' }}" selected>{{ isset($cliente->estado) ? 'Registro Gestionado' : '' }}</option>
                                    @break
                                    @endswitch
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}} "></use>
                                </svg>
                                <label>{{'Fecha de gestión'}}</label>
                                <input class="form-control" type="text" id="fecha" name="fecha" placeholder="date" value="{{ isset($cliente->fecha) ? $cliente->fecha : '' }}"  readonly >
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-clock')}} "></use>
                                </svg>
                                <label>{{'Hora de gestión'}}</label>
                                <input class="form-control"  type="text" name="hora" id="hora" value="{{ isset($cliente->hora) ? $cliente->hora : '' }}"  readonly>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-3 col-xl-2 col-xxl-2">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-mastercard')}} "></use>
                                </svg>
                                <label>{{'Det. Tipo de Activación'}}</label>
                                <input  class="form-control"  type="text"  value="{{ isset($cliente->dettipact) ? $cliente->dettipact : '' }}" readonly>
                            </div>
                        </div>
                        @if ( stripos( Auth::user()->rol,'admin') !== false )
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}} "></use>
                                </svg>
                                <label>{{'Fec. de Caducidad TC'}}</label>
                                <input class="form-control" type="text" pattern="^[0-9]+"  value="{{ isset($cliente->feccad) ? substr_replace( $cliente->feccad, 'XX', -2) : '' }}"  maxlength="6" type="text" id="feccad" name="feccad" placeholder="AAAAMM" readonly
                                       onKeyPress="if(this.value.length==6 ) return false; return isNumberKey(event)">
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-credit-card')}} "></use>
                                </svg>
                                <label>{{'No. Tarjeta'}}</label>

                                <input class="form-control" name="tarjeta" id="tarjeta" value="{{ !empty($cliente->tarjeta) ? substr_replace($cliente->tarjeta, 'XXXX', 6,-4) : '' }}"  type="text"
                                       onKeyPress="return isNumberKey(event)" placeholder="0000 0000 0000 0000" readonly>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-auto col-xxl-4">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-twitch')}} "></use>
                                </svg>
                                <label>{{'Observaciones'}}</label>
                                <input class="form-control" maxlength="80" name="observaciones" id="observaciones" value="{{ isset($cliente->observaciones) ? $cliente->observaciones : '' }}"  type="text" placeholder="Observaciones" readonly required>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-auto col-xxl-4">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-twilio')}} "></use>
                                </svg>
                                <label>{{'Detalle código de respuesta Call Type  de Ventas :'}}</label>
                                <input class="form-control" type="text" name="detresp" id="detresp" value="{{ isset($cliente->detresp) ? $cliente->detresp : 'Códigos de respuesta configurados'  }}" readonly>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 col-xxl-2">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-diamond')}} "></use>
                                </svg>
                                <label>{{'Detalle Estado del Cliente'}}</label>
                                <select class="form-control" id="codestado" name="codestado" disabled required>
                                    <option value="">{{'Detalle Estado del Cliente'}}</option>
                                    @switch ( isset($cliente->codestado) ? $cliente->codestado : '' )
                                        @case('A')
                                            @foreach( $estadosCliente as $estadoCliente)
                                                @if( $cliente->codestado == $estadoCliente->codigo )
                                                <option value="{{ isset($cliente->codestado) ? $cliente->codestado : '' }}" selected>{{ $cliente->detestado  }}</option>
                                                @else
                                                <option value="{{ $estadoCliente->codigo}}"> {{ $estadoCliente->detalle}} </option>
                                                @endif
                                            @endforeach
                                        @break
                                        @case('C')
                                            @foreach( $estadosCliente as $estadoCliente)
                                                @if( $cliente->codestado == $estadoCliente->codigo )
                                                <option value="{{ isset($cliente->codestado) ? $cliente->codestado : '' }}" selected>{{ $cliente->detestado }}</option>
                                                @else
                                                <option value="{{ $estadoCliente->codigo}}"> {{ $estadoCliente->detalle}} </option>
                                                @endif
                                            @endforeach
                                        @break
                                        @case('P')
                                            @foreach( $estadosCliente as $estadoCliente)
                                                @if( $cliente->codestado == $estadoCliente->codigo )
                                                <option value="{{ isset($cliente->codestado) ? $cliente->codestado : '' }}" selected>{{ $cliente->detestado }}</option>
                                                @else
                                                <option value="{{ $estadoCliente->codigo}}"> {{ $estadoCliente->detalle}} </option>
                                                @endif
                                            @endforeach
                                        @break
                                        @case('Z')
                                            @foreach( $estadosCliente as $estadoCliente)
                                                @if( $cliente->codestado == $estadoCliente->codigo )
                                                <option value="{{ isset($cliente->codestado) ? $cliente->codestado : '' }}" selected>{{ $cliente->detestado }}</option>
                                                @else
                                                <option value="{{ $estadoCliente->codigo}}"> {{ $estadoCliente->detalle}} </option>
                                                @endif
                                            @endforeach
                                        @break
                                        @default
                                            @foreach( $estadosCliente as $estadoCliente)
                                                <option value="{{ $estadoCliente->codigo}}"> {{ $estadoCliente->detalle}} </option>
                                            @endforeach
                                        @break
                                    @endswitch
                                </select>
                            </div>
                        </div>
                    </div>
                    @if( strtolower(Auth::user()->rol) == 'retencion' )
                    <hr>
                        <div class="row">
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <h5>{{'Retenciones'}}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-md-2">
                                <div class="form-group">
                                    <svg class="c-icon c-icon-1xl">
                                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-rstudio')}} "></use>
                                    </svg>
                                    <label>{{'Call type de retención'}}</label>
                                    <select class="form-control" id="call_type_retencion"  name="call_type_retencion" disabled>
                                        <option value="" selected>{{'Seleccione call type'}}</option>
                                            @foreach($callTypesRetencion as $ctr)
                                               <option value="{{$ctr->cod}}" >{{$ctr->detalle}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <svg class="c-icon c-icon-1xl">
                                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-json')}} "></use>
                                    </svg>
                                    <label>{{'Origen de la gestión'}}</label>
                                    <select class="form-control" id="origen" name="origen" disabled>
                                        <option value="llamada" selected>{{'LLAMADA'}}</option>
                                        <option value="correo_electronico">{{'CORREO ELECTRONICO'}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2" id="div_mot_desactivacion" style="display:none">
                                <div class="form-group">
                                    <svg class="c-icon c-icon-1xl">
                                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-when-i-work')}} "></use>
                                    </svg>
                                    <label>{{'Motivos de desactivación'}}</label>
                                    <select class="form-control" id="motivos_desactivacion" name="motivos_desactivacion" required>
                                        <option value="" selected>{{'Seleccione un motivo'}}</option>
                                    </select>
                                </div>
                            </div>
                            @if(isset($retencionCliente))
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <div class="form-group">
                                    <svg class="c-icon c-icon-1xl">
                                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-search')}} "></use>
                                    </svg>
                                    <label>{{'Ver detalles de la retención'}}</label>
                                    <button class="btn btn-outline-info" name="detalle_retencion" type="button" title="Ver detalles de la retención" data-toggle="modal" data-target="{{ '#infoDetRetencion' }}">
                                        <svg class="c-icon c-icon-1xl">
                                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-search')}} "></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                    @endif
                </form>
                @include('cliente.detalleRetencion', [ 'retencionCliente' => isset($retencionCliente) ? $retencionCliente : '' ])
                <div class="row">
                    <div class="col-sm-3 col-md-3">
                        @if ( !empty($cliente) && Auth::user()->rol == 'admin' )
                        <button class="btn btn-outline-success" id="btn-editAsis" title="Editar registro" type="button">
                            <svg class="c-icon c-icon-1xl">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pen')}} "></use>
                            </svg>
                        </button>
                        <button class="btn btn-success" id="btn-saveAsis" type="button" title="Guardar cambios" style="visibility:hidden" >
                            <svg class="c-icon c-icon-1xl">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save')}} "></use>
                            </svg>
                        </button>
                        @include('cliente.guardarAsistencia')
                        <button class="btn  btn-outline-danger" id="btn-cancelarAsis" title="Cancelar operación" type="button"  style="visibility:hidden">
                            <svg class="c-icon c-icon-1xl">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}} "></use>
                            </svg>
                        </button>
                        @endif
                        @if ( !empty($cliente) && Auth::user()->rol == 'retencion' )
                        <button class="btn btn-outline-success" id="btn-editRetencion" title="Editar Retención" type="button">
                            <svg class="c-icon c-icon-1xl">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pen')}} "></use>
                            </svg>
                        </button>
                        <button class="btn  btn-outline-danger" id="btn-cancelarRetencion" title="Cancelar retencion" type="button"  style="visibility:hidden">
                            <svg class="c-icon c-icon-1xl">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}} "></use>
                            </svg>
                        </button>
                        <button class="btn btn-success" id="btn-saveAsis" type="button" title="Guardar cambios" style="visibility:hidden" >
                            <svg class="c-icon c-icon-1xl">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save')}} "></use>
                            </svg>
                        </button>
                        @include('cliente.guardarAsistencia')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
