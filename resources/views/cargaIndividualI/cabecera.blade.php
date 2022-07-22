<a href="{{ url('menu/procesos/carga/') }}">
    <button class="btn btn-danger my-2" type="button" title="Regresar al panel">
        <svg class="c-icon c-icon-1xl mr-2  ">
            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-account-logout') }}">
            </use>
        </svg>
    </button>
</a>
<div class="alert alert-info " role="alert">
    <div class="row justify-content-between">
        <div>
            @if (session('success'))
                <div class="col-sm-12 col-md-12">
                    <div class="alert alert-primary alert-dismissible fade show " role="alert">
                        <svg class="c-icon c-icon-2xl">
                            <use
                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle') }}">
                            </use>
                        </svg>
                        <strong>{{ session('success') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="col-sm-12 col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show " role="alert">
                        <svg class="c-icon c-icon-2xl">
                            <use
                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash') }}">
                            </use>
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
                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-upload') }}">
                </use>
            </svg>
            <h4>{{ 'Carga de archivo por campaña' }} </h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <!-- <div class="card-header"><strong>Credit Card</strong> <small>Form</small></div> -->
            <div class="card-body">


                <form id="form-generar" action="{{ route('EaCargaIndividualExport.exporta') }}"method="get"
                    enctype="multipart/form-data" accept-charset="utf-8">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="usuario_registra" value="{{ Auth::user()->username }}">
                        <div class="form-group col-sm-4 col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text form-control">
                                        <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                                        <label class="c-switch c-switch-label c-switch-success mt-2">
                                            <input class="c-switch-input" type="checkbox" required name="filtro_cliente"
                                                id="filtro_cliente" value="cliente"><span class="c-switch-slider"
                                                data-checked="On" data-unchecked="Off"></span>
                                        </label>
                                        <strong class="ml-1"> {{ 'Por cliente: ' }} </strong>
                                    </span>
                                </div>
                                <select class="form-control" name="cliente" id="cliente" required
                                    style="display:none">
                                    <option value="" selected>{{ 'Seleccione un cliente' }}</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->cliente }}">{{ $cliente->desc_cliente }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3 col-md-3">

                            <div class="form-group">
                                <div class="input-group">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text form-control">
                                            <label class="c-switch c-switch-label c-switch-success mt-2">
                                                <input class="c-switch-input" type="checkbox" name="filtro_producto"
                                                    id="filtro_producto" value="producto"><span class="c-switch-slider"
                                                    data-checked="On" data-unchecked="Off"></span>
                                            </label>
                                            <strong class="ml-1"> {{ 'Por Producto: ' }} </strong>
                                        </span>
                                    </div>

                                    <select class="form-control" name="producto" id="producto" style="display:none">
                                        <option value="" selected>{{ 'Seleccione Producto' }}</option>
                                    </select>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">



                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text form-control">
                                            <label class="c-switch c-switch-label c-switch-success mt-2">
                                                <input class="c-switch-input" type="checkbox" name="filtro_genera"
                                                    id="filtro_genera" value="filtroGenera"><span
                                                    class="c-switch-slider" data-checked="SI"
                                                    data-unchecked="NO"></span>
                                            </label>
                                            <strong class="ml-1"> {{ 'generar carga: ' }} </strong>
                                        </span>
                                    </div>

                                    <button class="btn btn-info" id="btn-genera" name="btn-genera"
                                        title="Generar Carga" type="submit" style="display:none" disabled>
                                        <svg class="c-icon c-icon-1xl">
                                            <use
                                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-download') }} ">
                                            </use>
                                        </svg> {{ 'Generar carga' }}
                                    </button>
                                </div>

                            </div>
                        </div>

                    </div>
                </form>



            </div>
        </div>
    </div>
    <br>
    <div class="col-sm-12 form-group" id="processCarga" style="display:none">
        <strong>{{ 'Procesando...' }}</strong>
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>
    </div>

    @if (session('errorTecnico'))
        <div class="col-sm-12 col-md-12">
            <div class="alert alert-danger alert-dismissible fade show " role="alert">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle') }}">
                    </use>
                </svg>
                <strong>{{ 'No se procesó el archivo, Error técnico: ' }}</strong><br>
                <strong>{{ session('errorTecnico') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
</div>
