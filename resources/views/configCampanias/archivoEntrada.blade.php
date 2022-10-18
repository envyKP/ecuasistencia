<div class="col-sm-6">
    <div class="alert alert-dark text-center" role="alert">
        <h4>
            <svg class="c-icon c-icon-2xl mr-2">
                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-settings') }}"></use>
            </svg>
            {{ 'Archivo de Entrada' }}
        </h4>
    </div>
    <div class="card">
        <div class="card-header">{{ 'Descripcion: Lectura de archivo de respuesta del cliente(Banco)' }}
        </div>

        <div class="card-body">


            <div class="card-body">
                <form action="" id="form-Genera-lee" method="post">
                    @csrf
                    {{ method_field('patch') }}
                    <div>{{ 'Configuracion : ' }}</div>
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
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg class="c-icon mr-1">
                                        <use
                                            xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign') }}">
                                        </use>
                                    </svg>{{ 'Identificador ' }}
                                </span>
                            </div>
                            <select class="custom-select" name="campaniasOpcionesID" id="campaniasOpcionesID" required>
                                <option selected>{{ 'Seleccione una Configuracion...' }}</option>
                                <option value="cedula_id">CEDULA ID</option>
                                <option value="secuencia">SECUENCIA</option>
                                <option value="cuenta">CUENTA</option>
                                <option value="tarjeta">TARJETA</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg class="c-icon mr-1">
                                        <use
                                            xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign') }}">
                                        </use>
                                    </svg>{{ 'Fecha Debitado' }}
                                </span>
                            </div>
                            <input class="form-control" type="text" id="contrato_amaForm" name="contrato_amaForm"
                                value="" placeholder="Nombre de campo fecha">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg class="c-icon mr-1">
                                        <use
                                            xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign') }}">
                                        </use>
                                    </svg>{{ 'Formato de fecha' }}
                                </span>
                            </div>
                            <input class="form-control" type="text" id="contrato_amaForm" name="contrato_amaForm"
                                value="" placeholder="Formato de fecha">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg class="c-icon mr-1">
                                        <use
                                            xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign') }}">
                                        </use>
                                    </svg>{{ 'Valor Debitado' }}
                                </span>
                            </div>
                            <input class="form-control" type="text" id="contrato_amaForm" name="contrato_amaForm"
                                value="" placeholder="Nombre de campo Valor debitado">
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
                            Editar
                        </button>
                        <button class="btn btn-success" type="submit">
                            <svg class="c-icon c-icon-xl">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save') }} ">
                                </use>
                            </svg>
                            Guardar
                        </button>
                        <button class="btn btn-sm btn-outline-danger mr-md-2  my-1" id="btnElimprod" type="button"
                        data-toggle="modal" data-target="#dangerModal">
                        <svg class="c-icon c-icon-2xl my-1">
                            <use
                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash') }}">
                            </use>
                        </svg>
                        {{ 'Vaciar' }}
                    </button>
                    </div>
                </form>

                <div>{{ 'Validacion Debitado' }}</div>
                <div>{{ 'Descripcion:' }}</div>
                <div>{{ 'en caso que complete el campo si este retorna cualquier valor contara como debitado' }}</div>
                <div>{{ 'en caso que complete el campo y el valor tomara este como condicion para debitar' }}</div>
                <div>{{ 'en caso de estar vacio todos no habra condicion para debitar y debitara todo lo que lea' }}
                </div>
                <form id="form-Validacion" method="post">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg class="c-icon mr-1">
                                        <use
                                            xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign') }}">
                                        </use>
                                    </svg>{{ 'Campo Validacion' }}
                                </span>
                            </div>
                            <input class="form-control" type="text" id="contrato_amaForm" name="contrato_amaForm"
                                value="" placeholder="Nombre de campo detalle">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg class="c-icon mr-1">
                                        <use
                                            xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign') }}">
                                        </use>
                                    </svg>{{ 'Valor Validacion' }}
                                </span>
                            </div>
                            <input class="form-control" type="text" id="contrato_amaForm" name="contrato_amaForm"
                                value="" placeholder="Nombre de campo detalle">
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
                            Editar
                        </button>
                        <button class="btn btn-success" type="submit">
                            <svg class="c-icon c-icon-xl">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save') }} ">
                                </use>
                            </svg>
                            Guardar
                        </button>
                        <button class="btn btn-sm btn-outline-danger mr-md-2  my-1" id="btnElimprod" type="button"
                            data-toggle="modal" data-target="#dangerModal">
                            <svg class="c-icon c-icon-2xl my-1">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash') }}">
                                </use>
                            </svg>
                            {{ 'Vaciar' }}
                        </button>
                    </div>
                </form>
                <div>{{ 'Validacion archivo' }}</div>
                <div>{{ 'Descripcion:' }}</div>
                <div>{{ 'Si esta vacio no aplica' }}</div>
                <div>
                    {{ 'Obligatorio llenar los 2 campos debido a que en caso en caso de que no exista ese campo con el valor en el archivo indicara que
                                                                                                existe un conflicto o el archivo no pertene a ese producto' }}
                </div>
                <form id="form-Validacion" method="post">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg class="c-icon mr-1">
                                        <use
                                            xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign') }}">
                                        </use>
                                    </svg>{{ 'Campo Validacion' }}
                                </span>
                            </div>
                            <input class="form-control" type="text" id="contrato_amaForm" name="contrato_amaForm"
                                value="" placeholder="Nombre de campo detalle">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg class="c-icon mr-1">
                                        <use
                                            xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign') }}">
                                        </use>
                                    </svg>{{ 'Valor Validacion' }}
                                </span>
                            </div>
                            <input class="form-control" type="text" id="contrato_amaForm" name="contrato_amaForm"
                                value="" placeholder="Nombre de campo detalle">
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
                            Editar
                        </button>
                        <button class="btn btn-success" type="submit">
                            <svg class="c-icon c-icon-xl">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save') }} ">
                                </use>
                            </svg>
                            Guardar
                        </button>
                        <button class="btn btn-sm btn-outline-danger mr-md-2  my-1" id="btnElimprod" type="button"
                            data-toggle="modal" data-target="#dangerModal">
                            <svg class="c-icon c-icon-2xl my-1">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash') }}">
                                </use>
                            </svg>
                            {{ 'Vaciar' }}
                        </button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
