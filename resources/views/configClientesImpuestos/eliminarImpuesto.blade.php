<!-- Samuel Gavela /.modal Pregunta si desea eliminar un producto-->
<div class="modal fade" id="eliminarImpuesto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-danger" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                </svg>
                {{'Eliminar impuesto'}}
            </h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <strong><p>¿ Desea eliminar el impuesto ?.</strong> </p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" id="btn-eliminaImpuesto" >
                <svg class="c-icon c-icon-1xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                </svg>
                {{'Si'}}
            </button>
            <button class="btn btn-danger" type="button" data-dismiss="modal">
                <svg class="c-icon c-icon-1xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-action-undo')}}"></use>
                </svg>
                {{'No'}}
            </button>
        </div>
    </div>
    <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>

