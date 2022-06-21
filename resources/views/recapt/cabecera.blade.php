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
                <div class="alert alert-primary alert-dismissible fade show "  role="alert">
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
                <div class="alert alert-danger alert-dismissible fade show "  role="alert">
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
                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-description')}}"></use>
            </svg>
            <h4>{{'Recepción de archivo'}}</h4>
            <h4>{{'proveedor TMK'}}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <!-- <div class="card-header"><strong>Credit Card</strong> <small>Form</small></div> -->
            <div class="card-body">
                <form action="{{route('EaRecepArchiProveTmkController.uploadArchivos')}}" method="post" enctype="multipart/form-data"  accept-charset="utf-8">
                    @csrf
                <div class="row">
                    <input type="hidden" name="usuario_registra" value="{{ Auth::user()->username }}">
                    <div class="form-group col-sm-4 col-md-4">
                       <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text form-control"> <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                                    <label class="c-switch c-switch-label c-switch-success mt-2">
                                        <input class="c-switch-input" type="checkbox" required name="filtro_cliente" id="filtro_cliente" value="cliente"><span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                                    </label>
                                    <strong class="ml-1"> {{'Por cliente: '}} </strong>
                                </span>
                            </div>
                            <select class="form-control" name="cliente" id="cliente" required style="display:none">
                                <option value="" selected>{{'Seleccione un cliente'}}</option>
                                @foreach( $clientes as $cliente)
                                <option value="{{ $cliente->cliente}}">{{ $cliente->desc_cliente }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text form-control">
                                        <label class="c-switch c-switch-label c-switch-success mt-2">
                                            <input class="c-switch-input" required  type="checkbox" name="filtro_proce_carga" id="filtro_proce_carga" value="generacion_provee_tmk"><span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                                        </label>
                                        <strong class="ml-1"> {{'Procesos de carga: '}} </strong>
                                    </span>
                                </div>
                                <select class="form-control" name="cod_carga" id="cod_carga" style="display:none" required>
                                    <option value="" selected>{{'Seleccione un código de carga'}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text form-control"> <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                                        <label class="c-switch c-switch-label c-switch-success mt-2">
                                            <input class="c-switch-input" type="checkbox" name="filtro_producto" id="filtro_producto" value="producto"><span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                                        </label>
                                        <strong class="ml-1"> {{'Por Producto: '}} </strong>
                                    </span>
                                </div>
                                <select class="form-control" name="producto" id="producto" style="display:none">
                                    <option value="" selected>{{'Seleccione Producto'}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            <input class="form-control pt-1" id="archivo" type="file" name="archivo" required><!-- <span class="help-block">{{'Archivo debe ser de extensión .xlsx'}}</span> -->
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text form-control"> <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                                        <label class="c-switch c-switch-label c-switch-info mt-2">
                                            <input class="c-switch-input" type="radio" style="checked:false" name="tipo_carga" id="tipo_carga" value="parcial" required><span class="c-switch-slider" data-checked="&#x2713" data-unchecked="&#x2715"></span>
                                        </label><strong class="ml-1">{{'Carga Parcial'}}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text form-control"> <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                                        <label class="c-switch c-switch-label c-switch-success mt-2">
                                            <input class="c-switch-input" type="radio" style="checked:false" name="tipo_carga" id="tipo_carga" value="total" required><span class="c-switch-slider" data-checked="&#x2713" data-unchecked="&#x2715"></span>
                                        </label><strong class="ml-1">{{'Carga Total'}}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-group">
                            <button class="btn btn-success" id="btn-subirArchivo" title="Subir Archivo" type="submit">
                                <svg class="c-icon c-icon-1xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-upload')}} "></use>
                                </svg> {{'Subir Archivo'}}
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
    @if( session('errorTecnico'))
    <div class="col-sm-12 col-md-12">
        <div class="alert alert-danger alert-dismissible fade show "  role="alert">
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

