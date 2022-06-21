<div class="col-sm-4">
    <div class="alert alert-info  text-center" role="alert">
        <h4>
            <svg class="c-icon c-icon-2xl mr-2">
                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}}"></use>
            </svg>
            {{'Adicionar Producto'}}
        </h4>
    </div>
    <div class="card">
    <div class="card-header">{{'Selección de producto'}}</div>
    <div class="card-body">
         <form action="{{route('EaProductoController.destroy')}}" id="form-delete-pro" method="post">
           @csrf
           {{method_field('patch')}}
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-basket')}}"></use>
                            </svg></span>
                        </div>
                        <select class="custom-select mr-sm-2" name="productoCMB" id="productoID">
                            <option selected>{{'Seleccione un Producto...'}}</option>
                        </select>
                    </div>
                <input type="hidden" id="id_productoForm" name="id_productoForm">
                </div>
                <div>{{'Producto - Detalles'}}</div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}}"></use>
                                </svg>{{'Cliente'}}
                            </span>
                        </div>
                        <input class="form-control" type="text" id="clienteForm" name="clienteForm" value="" placeholder="Cliente" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign')}}"></use>
                                </svg>{{'Contrato AMA'}}
                            </span>
                        </div>
                        <input class="form-control" type="text" id="contrato_amaForm" name="contrato_amaForm" value="" placeholder="Contrato AMA" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text alert">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cc-visa')}}"></use>
                                </svg>{{'SubProducto'}}
                            </span>
                        </div>
                        <input class="form-control" id="subproductoForm" type="text" name="subproductoForm" placeholder="Nombre Subproducto" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text alert"><svg class="c-icon mr-1">
                                <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-speech')}}"></use>
                            </svg>{{'Descripción Producto'}}
                            </span>
                        </div>
                        <input class="form-control" type="text" id="desc_productoForm" name="desc_productoForm" value="" placeholder="Descripción Producto" readonly>
                    </div>
                </div>
            </form>
            <div class="form-group form-actions row d-flex justify-content-center">
                <button class="btn btn-sm btn-outline-danger mr-md-2  my-1" id="btnElimprod" style="visibility:hidden" type="button" data-toggle="modal" data-target="#dangerModal">
                    <svg class="c-icon c-icon-2xl my-1">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                    </svg>
                    {{'Eliminar'}}
                </button>
                @include('configProdu.modalEliminaProducto')

                <button class="btn btn-sm btn-success mr-md-2  my-1" id="btnAddprod" style="visibility:hidden" type="button" data-toggle="modal" data-target="#addModal">
                    <svg class="c-icon c-icon-2xl my-1">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-thick-to-bottom')}}"></use>
                    </svg>
                    {{'Add Nuevo'}}
                </button>
                @include('configProdu.modalAddProducto')

                <button class="btn btn-sm btn-outline-success mr-md-2  my-1" id ="btnEditprod" style="visibility:hidden" type="button" data-toggle="modal" data-target="#editModal">
                    <svg class="c-icon c-icon-2xl my-1">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                    </svg>
                    {{'Editar'}}
                </button>
                  @include('configProdu.modalEditProducto')
            </div>
       </div>
    </div>
</div>

