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
                <form action="{{ route('EaControlCampania.post_import_guardar') }}"  id="form-genera-imort" method="post" accept-charset="utf-8">
                    @csrf
                    {{ method_field('post') }}

                    <input type="hidden" name="codigo_id_import" id="codigo_id_import" value="">
                    <div class="col-sm-12 form-group" id="processCargaDetalle" style="display:none">
                        <strong>{{ 'Procesando...' }}</strong>
                        <progress class="col-sm-12" max="100">100%</progress>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg class="c-icon mr-1">
                                        <use
                                            xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign') }}">
                                        </use>
                                    </svg>{{ 'Tipo de Identificador ' }}
                                </span>
                            </div>
                            <select class="custom-select" name="IdentificadoEntrada" id="IdentificadoEntrada" required>
                                <option value="selec" selected>{{ 'Seleccione Tipo Identificador' }}</option>
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
                                    </svg>{{ 'campo identificador' }}
                                </span>
                            </div>
                            <input class="form-control" type="text" id="campoIdentificador" name="campoIdentificador"
                                placeholder="Nombre de campo identificador" required readonly>
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
                            <input class="form-control" type="text" id="fechaDebitado" name="fechaDebitado" readonly>
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
                                    </svg>{{ 'detalle' }}
                                </span>
                            </div>
                            <input class="form-control" type="text" id="detalle" name="detalle" readonly>
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
                            <input class="form-control" type="text" id="formatoFecha" name="formatoFecha"
                                placeholder="Formato de fecha" readonly>
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
                            <input class="form-control" type="text" id="valorDebitado" name="valorDebitado" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--<button class="btn btn-secondary" type="button" data-dismiss="modal" onclick="window.close();">Cancelar</button>-->

                        <div class="input-group-prepend">
                            <span class="input-group-text form-control">
                                <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                                <label class="c-switch c-switch-label c-switch-success mt-2">
                                    <input class="c-switch-input" type="checkbox" name="filtroeditarEntradaDetalles"  id="filtroeditarEntradaDetalles" ><span class="c-switch-slider" data-checked="SI" data-unchecked="NO"></span>
                                </label>
                                <strong class="ml-1"> {{ 'Editar' }} </strong>
                            </span>
                        </div>
                        <button class="btn btn-success" type="button" id="btn-guardar-import_cab">
                            <svg class="c-icon c-icon-xl">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save') }} ">
                                </use>
                            </svg>
                            Guardar
                        </button>
                        <button class="btn btn-sm btn-outline-danger mr-md-2  my-1" id="btnElimprod" type="button">
                            <svg class="c-icon c-icon-2xl my-1">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash') }}">
                                </use>
                            </svg>
                            {{ 'Vaciar' }}
                        </button>
                    </div>
                    @include('configCampanias.modalGuardar')
                </form>

                <div>{{ 'Validacion Debitado' }}</div>
                <div>{{ 'Descripcion:' }}</div>
                <div>{{ 'en caso que complete el campo si este retorna cualquier valor contara como debitado' }}</div>
                <div>{{ 'en caso que complete el campo y el valor tomara este como condicion para debitar' }}</div>
                <div>{{ 'en caso de estar vacio todos no habra condicion para debitar y debitara todo lo que lea' }}
                </div>
                <form id="form-Validacion" method="post" action="{{ route('EaControlCampania.post_import_guardar_validacion') }}">
                    @csrf
                    @method('post')
                    <input type="hidden" name="codigo_id_import_validacion" id="codigo_id_import_validacion" value="">
                    <div class="col-sm-12 form-group" id="processValidacion" style="display:none">
                        <strong>{{ 'Procesando...' }}</strong>
                        <progress class="col-sm-12" max="100">100%</progress>
                    </div>
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
                            <input class="form-control" type="text" id="campoValidacionDebitado" name="campoValidacionDebitado" readonly>
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
                            <input class="form-control" type="text" id="valorValidacionDebitado"   name="valorValidacionDebitado" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--<button class="btn btn-secondary" type="button" data-dismiss="modal" onclick="window.close();">Cancelar</button>-->
                        <div class="input-group-prepend">
                            <span class="input-group-text form-control">
                                <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                                <label class="c-switch c-switch-label c-switch-success mt-2">
                                    <input class="c-switch-input" type="checkbox" name="filtroeditarEntradaDetallesDebitado"  id="filtroeditarEntradaDetallesDebitado" ><span class="c-switch-slider"  data-checked="SI" data-unchecked="NO"></span>
                                </label>
                                <strong class="ml-1"> {{ 'Editar' }} </strong>
                            </span>
                        </div>
                        <button class="btn btn-success" type="button" id="btn-guardar-validacion">
                            <svg class="c-icon c-icon-xl">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save') }} ">
                                </use>
                            </svg>
                            Guardar
                        </button>
                        <button class="btn btn-sm btn-outline-danger mr-md-2  my-1" id="vaciar_validacion" type="button">
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
                <form id="frm-import-guadar-datos" action= "{{ route('EaControlCampania.post_import_guardar_datos') }}" method="post">
                    @csrf
                    @method('post')
                    <input type="hidden" name="codigo_id_import_guardar_datos" id="codigo_id_import_guardar_datos" value="">
                    <div class="col-sm-12 form-group" id="processDatosImport" style="display:none">
                        <strong>{{ 'Procesando...' }}</strong>
                        <progress class="col-sm-12" max="100">100%</progress>
                    </div>
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
                            <input class="form-control" type="text" id="campoValidacionArchivo"  name="campoValidacionArchivo" readonly>
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
                            <input class="form-control" type="text" id="valorValidacionArchivo"  name="valorValidacionArchivo" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--<button class="btn btn-secondary" type="button" data-dismiss="modal" onclick="window.close();">Cancelar</button>-->
                        <div class="input-group-prepend">
                            <span class="input-group-text form-control">
                                <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                                <label class="c-switch c-switch-label c-switch-success mt-2">
                                    <input class="c-switch-input" type="checkbox" name="filtroeditarEntradaValidaA"  id="filtroeditarEntradaValidaA" ><span class="c-switch-slider"   data-checked="SI" data-unchecked="NO"></span>
                                </label>
                                <strong class="ml-1"> {{ 'Editar' }} </strong>
                            </span>
                        </div>
                        <button class="btn btn-success" id="btn-guardar-datos-import" type="button">
                            <svg class="c-icon c-icon-xl">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save') }} ">
                                </use>
                            </svg>
                            Guardar
                        </button>
                        <button class="btn btn-sm btn-outline-danger mr-md-2  my-1" id="btn-vaciar-datos-import" type="button">
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
