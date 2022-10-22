<!-- Samuel Gavela /.modal agregar nuevo producto-->


<div class="modal fade" id="modalGuardar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-success" role="document">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">
            <svg class="c-icon c-icon-2xl my-1">
                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-thick-to-bottom')}}"></use>
            </svg>
            {{'Import Archivo'}}
        </h4>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        {{'Datos Guardados!'}}
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

    