<div class="col-sm-4">
    <div class="alert alert-dark text-center" role="alert">
        <h4>
            <svg class="c-icon c-icon-2xl mr-2">
                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-settings') }}"></use>
            </svg>
            {{ 'Campaña Generacion/Lectura Archivos' }}
        </h4>
    </div>
    <div class="card">
        <div class="card-header">{{ 'Selección de subproducto' }}</div>
        <div class="card-body">
            <form action="{{ route('EaSubproductoController.destroy') }}" id="form-Genera-lee" method="post">
                @csrf
                {{ method_field('patch') }}
                <div>{{ 'Producto - Principal' }}</div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                                <svg class="c-icon">
                                    <use
                                        xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-basket') }}">
                                    </use>
                                </svg></span>
                        </div>
                        <select class="custom-select" name="campaniasOpcionesID" id="campaniasOpcionesID">
                            <option selected>{{ 'Seleccione una Configuracion...' }}</option>
                        </select>
                    </div>
                    <input type="hidden" id="id_subprodFormSub" name="id_subprodFormSub" value="">
                </div>
                <div>{{ 'Producto - Parent' }}</div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                                <svg class="c-icon">
                                    <use
                                        xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-basket') }}">
                                    </use>
                                </svg></span>
                        </div>
                        <select class="custom-select" name="campaniasProductosOpcionesID"
                            id="campaniasProductosOpcionesID">
                            <option selected>{{ 'Seleccione un Sub-Producto...' }}</option>
                        </select>
                    </div>
                    <input type="hidden" id="id_subprodFormSub" name="id_subprodFormSub" value="">
                </div>
                <!--
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><svg class="c-icon mr-1">
                                    <use
                                        xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus') }}">
                                    </use>
                                </svg>{{ 'Cliente' }}
                            </span>
                        </div>
                        <input class="form-control" id="clienteFormSub" type="text" name="clienteFormSub"
                            placeholder="Cliente" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text alert"><svg class="c-icon mr-1">
                                    <use
                                        xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign') }}">
                                    </use>
                                </svg>{{ 'Contrato AMA' }}
                            </span>
                        </div>
                        <input type="hidden" id="desc_productoSubForm" name="desc_productoSubForm">
                        <input class="form-control" id="contrato_amaSubForm" type="text" name="contrato_amaSubForm"
                            placeholder="Contrato AMA" readonly>
                    </div>
                </div>
                utilizar for o similar desde php para que en el formulario se visualize lo que 
                son las distintas opciones o el encriptado 
                
            -->
                <button class="btn btn-sm btn-success mr-md-2 my-1" id="btnAddsubprod" style="visibility:block"
                    type="button" data-toggle="modal" data-target="#addSubproModal">
                    <svg class="c-icon c-icon-2xl my-1">
                        <use
                            xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-thick-to-bottom') }}">
                        </use>
                    </svg>
                    {{ 'Añadir Subproducto' }}
                </button>
                <!--include('configCampanias.modalAddSubpro')  deberia solo añadir la id o puedo simplemente  mostrar en
                un tipo array o combo los subproductos , no añadir aki -->

                <div>{{ 'Subproducto - Detalle' }}</div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text alert">
                                <svg class="c-icon mr-1">
                                    <use
                                        xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cc-visa') }}">
                                    </use>
                                </svg>{{ 'SubProducto' }}
                            </span>
                        </div>
                        <input class="form-control" maxlength="100" id="sub-subproductoForm" type="text"
                            name="subproductoForm" placeholder="Nombre Subproducto" readonly>
                    </div>
                    <!-- AKI DEBO PONER ALGO COMO UN FOR  o llamarlo desde el php -->

                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text alert"><svg class="c-icon mr-1">
                                    <use
                                        xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-credit-card') }}">
                                    </use>
                                </svg>{{ 'Tipo SubProducto' }}
                            </span>
                        </div>
                        <input class="form-control" id="tipo_subproductoForm" type="text" name="tipo_subproductoForm"
                            placeholder="Tipo Subproducto" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <button class="btn btn-sm btn-success mr-md-2  my-1" id="btnGeneracion" style="visibility:block"
                        type="button" data-toggle="modal" data-target="#addExportJSON">
                        <svg class="c-icon c-icon-2xl my-1">
                            <use
                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-file') }}">
                            </use>
                        </svg>
                        {{ 'Generacion Archivo' }}
                    </button>
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-success mr-md-2  my-1" id="btnGeneracion" style="visibility:block"
                        type="button" data-toggle="modal" data-target="#addExportJSON">
                        <svg class="c-icon c-icon-2xl my-1">
                            <use
                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-find-in-page') }}">
                            </use>
                        </svg>
                        {{ 'Lectura de Archivo Respuesta' }}
                    </button>
                </div>
            </form>
            <div class="form-group form-actions row d-flex justify-content-center">
                <button class="btn btn-sm btn-outline-danger mr-md-2  my-1" id="btnElimsubprod"
                    style="visibility:hidden" type="button" data-toggle="modal" data-target="#dangerModalSubprod">
                    <svg class="c-icon c-icon-2xl my-1">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash') }}">
                        </use>
                    </svg>
                    {{ 'Eliminar' }}
                </button>
                @include('configCampanias.modalEliminaSubProducto')



                <button class="btn btn-sm btn-outline-success mr-md-2 my-1" id="btnEditsubprod"
                    style="visibility:hidden" type="button" data-toggle="modal" data-target="#editSubproModal">
                    <svg class="c-icon c-icon-2xl my-1">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pencil') }}">
                        </use>
                    </svg>
                    {{ 'Editar' }}
                </button>
                @include('configCampanias.modalEditSubpro')

            </div>
        </div>
    </div>
</div>
