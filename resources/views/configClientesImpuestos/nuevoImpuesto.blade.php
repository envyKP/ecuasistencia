<!-- /.modal-->
<form action="{{ route('EaImpuestosController.store') }}" method="post">
    @csrf
    @method('post')
<div class="modal fade" id="crearImpuesto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-success" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">
                <svg class="c-icon c-icon-2xl mr-1">
                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-thick-to-bottom')}}"></use>
                </svg>
             {{'Crear nuevo impuesto'}}
            </h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <svg class="c-icon mr-1">
                                <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cashapp')}}"></use>
                            </svg>
                            {{'Impuesto'}}
                        </span>
                    </div>
                    <input type="hidden" name="clienteAdd" id="clienteAdd">
                    <input type="hidden" name="id_impuesto" id="id_impuesto">
                    <input class="form-control" maxlength="20"  type="text" id="nom_impuesto" name="nom_impuesto"  placeholder="Ingrese nombre del impuesto" autocomplete="off" required oninput="this.value = this.value.toUpperCase()">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <svg class="c-icon mr-1">
                                <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-speech')}}"></use>
                            </svg>
                            {{'Descripción Impuesto'}}
                        </span>
                    </div>
                    <input class="form-control" maxlength="20"  type="text" id="desc_impuesto" name="desc_impuesto"  placeholder="Ingrese descripción del impuesto" autocomplete="off" required oninput="this.value = this.value.toUpperCase()">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <svg class="c-icon mr-1">
                                <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calculator')}}"></use>
                            </svg>
                            {{'Valor o porcentaje'}}
                        </span>
                    </div>
                    <input class="form-control" step="0.01" type="text" id="valor_porcentaje" name="valor_porcentaje"  placeholder="Ingrese valor ó porcentaje (número entero)" autocomplete="off" required oninput="this.value = this.value.toUpperCase()"
                    onKeyPress="if(this.value.length==6 ) return false; return ( event.charCode !=8 && event.charCode ==0   || ( event.charCode == 188 || event.charCode == 46|| (event.charCode >= 48 && event.charCode <= 57) ))" >
                    <span class="input-group-text">
                        <svg class="c-icon mr-1">
                            <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-slashdot')}}"></use>
                        </svg>
                    </span>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
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
</form>
