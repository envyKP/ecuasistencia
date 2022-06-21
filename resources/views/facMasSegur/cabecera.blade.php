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
                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-bamboo')}}"></use>
            </svg>
            <h4>{{'Facturación Masiva SegurViaje'}} </h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <!-- <div class="card-header"><strong>Credit Card</strong> <small>Form</small></div> -->
            <div class="card-body">
                <form action="{{route('EaFactMasSeguviajeController.uploadArchivos')}}" method="post" enctype="multipart/form-data"  accept-charset="utf-8">
                    @csrf
                <div class="row">
                    <input type="hidden" name="usuario_registra" value="{{ Auth::user()->username }}">
                    <div class="form-group col-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text form-control"> <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                                    <label class="c-switch c-switch-label c-switch-success mt-2">
                                        <input class="c-switch-input" required type="checkbox" name="filtro_cliente" id="filtro_cliente" value="cliente"><span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                                    </label>
                                    <strong class="ml-1"> {{'Clientes: '}} </strong>
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
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text form-control"> <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                                        <label class="c-switch c-switch-label c-switch-success mt-2">
                                            <input class="c-switch-input" type="checkbox" name="filtro_subproducto" id="filtro_subproducto" value="producto"><span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                                        </label>
                                        <strong class="ml-1"> {{'Subproductos SAP: '}} </strong>
                                    </span>
                                </div>
                                <select class="form-control" name="subproducto" id="subproducto" style="display:none">
                                    <option value="" selected>{{'Seleccione Producto'}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text form-control"> <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                                        <label class="c-switch c-switch-label c-switch-success mt-2">
                                            <input class="c-switch-input" type="checkbox" name="filtro_estab" id="filtro_estab" value="filtro_estab" required><span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                                        </label>
                                        <strong class="ml-1"> {{'Establecimiento: '}} </strong>
                                    </span>
                                </div>
                                <select class="form-control" name="establecimiento" id="establecimiento" style="display:none">
                                    <option value="" selected>{{'Seleccione Establecimiento'}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5 col-md-5">
                        <div class="form-group">
                            <input class="form-control pt-1" id="archivo" type="file" name="archivo" required><!-- <span class="help-block">{{'Archivo debe ser de extensión .xlsx'}}</span> -->
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text form-control"> <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                                        <label class="c-switch c-switch-label c-switch-success mt-2">
                                            <input class="c-switch-input" type="checkbox" name="filtro_nombreLote" id="filtro_nombreLote" value="nombreLote" required><span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                                        </label>
                                        <strong class="ml-1"> {{'Nombre de lote: '}} </strong>
                                    </span>
                                </div>
                               <input class="form-control col-sm-6 col-md-6" type="text" name="txt_nombreLote" id="txt_nombreLote" style ="display:none">
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

