<!-- Samuel Gavela /.modal agregar nuevo producto-->
<form action="{{route('EaProductoController.store')}}" method="post">
@csrf
{{method_field('patch')}}
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-success" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-thick-to-bottom')}}"></use>
                </svg>
                {{'Agregar Producto'}}
            </h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
                <div class="form-group">
                    <div class="form-group">
                        <div class="input-group">
                           <div class="input-group-prepend">
                                <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}}"></use>
                                </svg>
                                 {{'Cliente'}}
                                </span>
                            </div>
                           <input class="form-control" type="text" id="clienteAdd" name="clienteAdd" value="" placeholder="Cliente" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign')}}"></use>
                                </svg>
                                {{'Contrato AMA'}}
                            </span>
                        </div>
                        <input class="form-control" maxlength="20"  type="text" name="contrato_ama"  placeholder="Ingrese Nombre del Producto" autocomplete="off" required oninput="this.value = this.value.toUpperCase()">
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
                        <input class="form-control"  type="text" name="subproducto" placeholder="Nombre Subproducto" oninput="this.value = this.value.toUpperCase();">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-speech')}}"></use>
                                </svg>
                                {{'Descripción Producto'}}
                            </span>
                        </div>
                        <input class="form-control" maxlength="50" type="text" name="desc_producto"  placeholder="{{'Ingrese descripción del producto'}}" autocomplete ="off" required oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal" onclick="window.close();">{{'Cancelar'}}</button>
            <button class="btn btn-success" type="submit">
                <svg class="c-icon c-icon-xl">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save')}} "></use>
                </svg>
            </button>
        </div>
    </div>
    <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>
<!-- /.modal-->
</form>
