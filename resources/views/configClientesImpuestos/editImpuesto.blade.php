<form action="{{ route('EaImpuestosController.edit') }}" method="post">
    @csrf
    @method('post')
<div class="modal fade" id="editarImpyesto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">
                <svg class="c-icon c-icon-2xl mr-1">
                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                </svg>
               {{'Editar impuesto'}}
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
                    <input type="hidden" id="clienteEditImp" name="clienteEditImp">
                    <input type="hidden" id="id_impuestoEdit" name="id_impuestoEdit">
                    <input type="hidden" id="nom_impuestoEditOld" name="nom_impuestoEditOld">
                    <input class="form-control" maxlength="20"  type="text" id="nom_impuestoEdit" name="nom_impuestoEdit"  placeholder="Ingrese nombre del impuesto" autocomplete="off" oninput="this.value = this.value.toUpperCase()">
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
                    <input type="hidden" id="desc_impuestoEditOld" name="desc_impuestoEditOld">
                    <input class="form-control" step="0.01" type="text" id="desc_impuestoEdit"  name="desc_impuestoEdit" placeholder="Ingrese descripción del impuesto" autocomplete="off" oninput="this.value = this.value.toUpperCase()">
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
                    <input type="hidden" id="valor_porcentajeEditOld" name="valor_porcentajeEditOld">
                    <input class="form-control" step="0.01"  type="text" id="valor_porcentajeEdit"  name="valor_porcentajeEdit"  placeholder="Ingrese valor ó porcentaje (número entero)" autocomplete="off"
                           onKeyPress="if(this.value.length==6 ) return false; return ( event.charCode !=8 && event.charCode ==0   || ( event.charCode == 188 || event.charCode == 46|| (event.charCode >= 48 && event.charCode <= 57) ))">
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
