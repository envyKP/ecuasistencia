<!-- /.modal-->
<form action="{{ route('EaClienteController.store') }}" method="post" enctype="multipart/form-data">
@csrf
{{method_field('post') }}
<div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-success" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">
                <svg class="c-icon c-icon-2xl mr-1">
                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-thick-to-bottom')}}"></use>
                </svg>
             {{'Crear nuevo cliente'}}
            </h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-bank')}}"></use>
                                </svg>
                                {{'Cliente'}}
                            </span>
                        </div>
                        <input class="form-control" maxlength="20"  type="text" id="cliente"  name="cliente" placeholder="Ingrese mombre del cliente" autocomplete="off" required oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-speech')}}"></use>
                                </svg>
                                {{'Descripción Cliente'}}
                            </span>
                        </div>
                        <input class="form-control" maxlength="20"  type="text" id="desc_cliente"  name="desc_cliente"  placeholder="Ingrese descripción del cliente" autocomplete="off" required oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend pb-3">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-postgresql')}}"></use>
                                </svg>
                                {{'Logo Tipo'}}
                            </span>
                        </div>
                            <input class="form-control pt-1" type="file" name="logotipo" id="logotipo">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-success"   type="submit">
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
</form>

