<div class="col-sm-4">
    <div class="alert alert-dark text-center" role="alert">
        <h4>
            <svg class="c-icon c-icon-2xl mr-2">
               <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}}"></use>
            </svg>
            {{'Adicionar detalles del Sub-Producto'}}
        </h4>
    </div>
    <div class="card">
    <div class="card-header">{{'Selección de subproducto'}}</div>
    <div class="card-body">
            <form action="{{route('EaSubproductoController.destroy')}}" id="form-delete-Subpro" method="post">
            @csrf
            {{method_field('patch')}}
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon">
                                <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-basket')}}"></use>
                            </svg></span>
                        </div>
                        <select class="custom-select" name="subproductoCMB" id="subproductoID">
                            <option selected>{{'Seleccione un Sub-Producto...'}}</option>
                        </select>
                    </div>
                    <input type="hidden" id="id_subprodFormSub" name="id_subprodFormSub" value="">
                </div>
                <div>{{'Producto - Parent'}}</div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}}"></use>
                                </svg>{{'Cliente'}}
                            </span>
                        </div>
                        <input class="form-control" id="clienteFormSub" type="text" name="clienteFormSub" placeholder="Cliente" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text alert"><svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign')}}"></use>
                                </svg>{{'Contrato AMA'}}
                            </span>
                        </div>
                        <input type="hidden" id="desc_productoSubForm" name="desc_productoSubForm">
                        <input class="form-control" id="contrato_amaSubForm" type="text" name="contrato_amaSubForm"  placeholder="Contrato AMA" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-home')}}"></use>
                                </svg>{{'Código de Establecimiento'}}
                            </span>
                        </div>
                        <input class="form-control" type="text" id="cod_establecimientoEditForm" name="cod_establecimientoEditForm" value="" placeholder="Código de establecimiento" readonly>
                    </div>
                </div>
                <div>{{'Subproducto - Detalle'}}</div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text alert">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cc-visa')}}"></use>
                                </svg>{{'SubProducto'}}
                            </span>
                        </div>
                        <input class="form-control" maxlength="100" id="sub-subproductoForm" type="text" name="subproductoForm" placeholder="Nombre Subproducto" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text alert"><svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-credit-card')}}"></use>
                                </svg>{{'Tipo SubProducto'}}
                            </span>
                        </div>
                        <input class="form-control" id="tipo_subproductoForm" type="text" name="tipo_subproductoForm" placeholder="Tipo Subproducto" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text alert"><svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-speech')}}"></use>
                                </svg>{{'Descripción'}}
                            </span>
                        </div>
                        <input class="form-control" id="desc_subproductoForm" type="text" name="desc_subproductoForm" placeholder="Descripción Subproducto" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cashapp')}}"></use>
                                </svg>
                                {{'Valor Total'}}
                            </span>
                        </div>
                        <input class="form-control" type="number" step="0.01" id="valortotalform" name="valortotalform" placeholder="{{'$0.00'}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon mr-1">
                                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-buzzfeed')}}"></use>
                            </svg>{{'Graba impuesto'}}</span>
                        </div>
                        <input class="form-control" type="text" id="graba_impuestoForm" name="graba_impuestoForm" placeholder="{{'Graba impuesto'}}" readonly>
                    </div>
                </div>
                <div style="display:none" id="divImpuesformSub">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg class="c-icon  mr-1">
                                        <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calculator')}}"></use>
                                    </svg>
                                    {{'ID impuesto'}}
                                </span>
                            </div>
                            <input class ="form-control" type="text" name="nom_impuestoFormSub" id="nom_impuestoFormSub" placeholder="ID name del impuesto" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cashapp')}}"></use>
                                </svg>
                                {{'Valor o porcentaje'}}</span>
                            </div>
                            <input class="form-control" type="number" name="valor_porcentajeForm" id="valor_porcentajeForm" placeholder="{{'Valor ó Porcentaje del impuesto'}}" readonly>
                            <div class="input-group-append"><span class="input-group-text">
                                <svg class="c-icon">
                                    <use xlink:href="{{ asset ('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-slashdot')}}"></use>
                                </svg></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cashapp')}}"></use>
                                </svg>
                                {{'Deducción de impuesto'}}</span>
                            </div>
                            <input class="form-control" type="number" step="{{'0.01'}}"  name="deduccion_impuestoForm"  id="deduccion_impuestoForm" placeholder="{{'Valor ó Porcentaje del impuesto'}}" readonly>
                            <div class="input-group-append"><span class="input-group-text">
                                <svg class="c-icon">
                                    <use xlink:href="{{ asset ('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-slashdot')}}"></use>
                                </svg></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon mr-1">
                                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cashapp')}}"></use>
                            </svg>
                            {{'Subtotal'}}</span>
                        </div>
                        <input class="form-control" type="number" name="subtotalForm" id="subtotalForm" placeholder="{{'Valor ó Porcentaje del impuesto'}}" readonly>
                        <div class="input-group-append"><span class="input-group-text">
                            <svg class="c-icon">
                                <use xlink:href="{{ asset ('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-slashdot')}}"></use>
                            </svg></span>
                        </div>
                    </div>
                </div>
            </form>
            <div class="form-group form-actions row d-flex justify-content-center">
                <button class="btn btn-sm btn-outline-danger mr-md-2  my-1" id="btnElimsubprod" style ="visibility:hidden" type="button" data-toggle="modal" data-target="#dangerModalSubprod">
                    <svg class="c-icon c-icon-2xl my-1">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                    </svg>
                    {{'Eliminar'}}
                </button>
                @include('configProdu.modalEliminaSubProducto')

                <button class="btn btn-sm btn-success mr-md-2 my-1"  id="btnAddsubprod" style="visibility:hidden" type="button" data-toggle="modal" data-target="#addSubproModal">
                    <svg class="c-icon c-icon-2xl my-1">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-thick-to-bottom')}}"></use>
                    </svg>
                    {{'Add Nuevo'}}
                </button>
                @include('configProdu.modalAddSubpro')

                <button class="btn btn-sm btn-outline-success mr-md-2 my-1" id="btnEditsubprod" style="visibility:hidden" type="button" data-toggle="modal" data-target="#editSubproModal">
                    <svg class="c-icon c-icon-2xl my-1">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                    </svg>
                    {{'Editar'}}
                </button>
                @include('configProdu.modalEditSubpro')

            </div>
    </div>
    </div>
</div>

