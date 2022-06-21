<div class="modal fade" id="guardarAsistencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header btn-success">
            <h4 class="modal-title">
                <svg class="c-icon c-icon-2xl mr-1">
                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save')}}"></use>
                </svg>
               {{'Guardar cambios'}}
            </h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <strong><p>{{'¿ Desea guardar los cambios ?'}}</p></strong>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">{{'Salir'}}</button>
            <button class="btn btn-success" type="button" id="btn-confirmaGuardarAsistencia">
                <svg class="c-icon c-icon-1xl">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save')}} "></use>
                </svg>
            </button>
        </div>
    </div>
    <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>
