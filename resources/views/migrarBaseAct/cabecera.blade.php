<div class="alert alert-info " role="alert">
    <div class="row justify-content-between">
        <div>
            @if( session('success'))
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-primary alert-dismissible fade show "  role="alert">
                    <svg class="c-icon c-icon-2xl my-1">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                    </svg>
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif
            @if( session('delete'))
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-danger alert-dismissible fade show "  role="alert">
                    <svg class="c-icon c-icon-2xl my-1">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                    </svg>
                    <strong>{{ session('delete') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif
        </div>
        <div>
            <svg class="c-icon c-icon-3xl">
                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-upload')}}"></use>
            </svg>
            <h4>{{'Proceso de carga - Base Activa'}}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <!-- <div class="card-header"><strong>Credit Card</strong> <small>Form</small></div> -->
            <div class="card-body">
                <form action="{{route('EaMigracionBaseActivaController.uploadArchivos')}}" method="post" enctype="multipart/form-data"  accept-charset="utf-8">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="usuario_registra" value="{{ Auth::user()->username }}">
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl mr-2">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-institution')}} "></use>
                                </svg>
                                <label>{{'Seleccione un Cliente'}}</label>
                                <select class="form-control" name="cliente" id="cliente" required>
                                    <option value="" selected>{{'Seleccione un cliente'}}</option>
                                    @foreach( $clientes as $cliente)
                                    <option value="{{ $cliente->cliente}}">{{ $cliente->desc_cliente }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <svg class="c-icon c-icon-1xl mr-2">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-description')}} "></use>
                                </svg>
                                <label>{{'Seleccione el archivo a cargar'}}</label>
                                <input class="form-control pt-1" id="archivo" type="file" name="archivo"><span class="help-block">{{'Archivo debe ser de extensión .txt'}}</span>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2  my-4 mx-4 py-1">
                            <div class="form-group">
                                <button class="btn btn-success" id="btn-subirArchivo" title="Subir Archivo" style="visibility:hidden" type="submit">
                                    <svg class="c-icon c-icon-0xl">
                                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-upload')}} "></use>
                                    </svg> {{'Cargar Archivo'}}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>

    <div class="col-sm-12 form-group" id="processCarga" style="display:none" >
        <strong>{{'Procesando...'}}</strong>
        <progress class="col-sm-12"  max="100">100%</progress>
    </div>
    @if( session('error'))
    <div class="col-sm-12 col-md-12">
        <div class="alert alert-danger alert-dismissible fade show "  role="alert">
            <svg class="c-icon c-icon-2xl my-1">
                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
            </svg><br>
            <strong>{{ 'No se procesó el archivo, error en la linea: '}}</strong><br>
            <strong>{{ session('lineaError') }}</strong><br><br>
            <strong>{{ 'Error técnico: ' }}</strong><br>
            <strong>{{ session('error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    @endif
</div>

