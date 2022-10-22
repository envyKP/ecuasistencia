<div class="col-sm-6">
    <div class="alert alert-success text-center" role="alert">
        <h4>
            <svg class="c-icon c-icon-2xl mr-2">
                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-settings') }}"></use>
            </svg>
            {{ 'Clientes Disponibles' }}
        </h4>
    </div>
    <div class="card">
        <div class="card-header">{{ 'Selección de Cliente' }}</div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                                <svg class="c-icon">
                                    <use
                                        xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus') }}">
                                    </use>
                                </svg></span>
                        </div>
                        <select class="custom-select mr-sm-2" name="clienteCMB" id="clienteCMB">
                            <option value="clienteNull" selected>{{ 'Seleccione una cliente...' }}</option>
                            @foreach ($Allcampanas as $campana)
                                <option value="{{ isset($campana->cliente) ? $campana->cliente : '' }}">
                                    {{ isset($campana->desc_cliente) ? $campana->desc_cliente : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>{{ 'Configuracion' }}</div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use
                                        xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus') }}">
                                    </use>
                                </svg>{{ 'Configuracion' }}
                            </span>
                        </div>
                        <select class="custom-select" name="campaniasOpcionesID" id="campaniasOpcionesID" required>
                            <option selected>{{ 'Seleccione una Configuracion...' }}</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <!--<button class="btn btn-secondary" type="button" data-dismiss="modal" onclick="window.close();">Cancelar</button>-->
                    <button class="btn btn-success" type="submit">
                        <svg class="c-icon c-icon-xl">
                            <use
                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save') }} ">
                            </use>
                        </svg>
                        Añadir Producto/Editar Opciones
                    </button>
                    <button class="btn btn-sm btn-outline-danger mr-md-2  my-1" id="" type="button"
                        data-toggle="modal" data-target="#dangerModal">
                        <svg class="c-icon c-icon-2xl my-1">
                            <use
                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash') }}">
                            </use>
                        </svg>
                        {{ 'Eliminar Opcion' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
