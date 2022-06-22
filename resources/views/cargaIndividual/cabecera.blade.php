<a href="{{ url('menu/procesos/carga/') }}">
    <button class="btn btn-danger my-2" type="button" title="Regresar al panel">
        <svg class="c-icon c-icon-1xl mr-2  ">
            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-account-logout') }}"></use>
        </svg>
    </button>
</a>
<div class="alert alert-info " role="alert">
    <div class="row justify-content-between">
        <div>
            @if( session('success'))
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-primary alert-dismissible fade show " role="alert">
                    <svg class="c-icon c-icon-2xl">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                    </svg>
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif
            @if( session('error'))
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-danger alert-dismissible fade show " role="alert">
                    <svg class="c-icon c-icon-2xl">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                    </svg>
                    <strong>{{ session('error') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif
        </div>
        <div>
            <svg class="c-icon c-icon-3xl">
                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-download')}}"></use>
            </svg>
            <h4>{{'Generacion de archivo por campaña'}} </h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <!-- <div class="card-header"><strong>Credit Card</strong> <small>Form</small></div> -->
            <div class="card-body">
                <form action="{{route('EaCabCargaInicialController.uploadArchivos')}}" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="usuario_registra" value="{{ Auth::user()->username }}">
                        <div class="form-group col-3">
                            <div class="input-group">
                                <svg class="c-icon c-icon-1xl mr-1">
                                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-credit-card')}}"></use>
                                </svg>
                                <label>Cliente/campaña/producto</label>
                            </div>
                            <select class="form-control" name="cliente" id="cliente" required>
                                <option value="" selected>{{'Seleccione un cliente'}}</option>
                                @foreach( $clientes as $cliente)
                                <option value="{{ $cliente->cliente}}">{{ $cliente->desc_cliente }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <svg class="c-icon c-icon-1xl mr-1">
                                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cc-visa')}}"></use>

                                    </svg>
                                    <label>SubProducto</label>
                                </div>
                                <select class="form-control" name="producto" id="producto">
                                    <option value="" selected>{{'Seleccione Producto'}}</option>
                                </select>

                            </div>
                        </div>

                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <button class="btn btn-success" id="btn-subirArchivo" title="Subir Archivo" type="submit">
                                    <svg class="c-icon c-icon-1xl">
                                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-download')}} "></use>
                                    </svg> {{'Generar archivo'}}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl mr-1">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}} "></use>
                                </svg>
                                <label>{{'Fecha Inicio'}}</label>
                                <input class="form-control" maxlength="20" name="fechanainicio" value="" type="date" placeholder="Fecha de inicio">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl mr-1">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}} "></use>
                                </svg>
                                <label>{{'Fecha fin'}}</label>
                                <input class="form-control" maxlength="20" name="fechanafin" value="" type="date" placeholder="Fecha de fin">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <br>
    <div class="col-sm-12 form-group" id="processCarga" style="display:none">
        <strong>{{'Procesando...'}}</strong>
        <progress class="col-sm-12" max="100">100%</progress>
    </div>
    @if( session('errorTecnico'))
    <div class="col-sm-12 col-md-12">
        <div class="alert alert-danger alert-dismissible fade show " role="alert">
            <svg class="c-icon c-icon-2xl my-1">
                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
            </svg>
            <strong>{{ 'No se procesó el archivo, Error técnico: '}}</strong><br>
            <strong>{{ session('errorTecnico') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    @endif
</div>