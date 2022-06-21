<div class="modal fade" id="{{ 'eliminar'.$row }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-danger" role="document">
    <div class="modal-content">
    <form action="{{ route('EaRecepArchiFinanController.destroy') }}" method="post">
    @csrf
        <input type="hidden" name="cod_carga" value="{{$data->cod_carga}}">
        <div class="modal-header">
            <h4 class="modal-title">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                </svg>
                {{'Eliminar archivo del servidor'}}
            </h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <strong><p>{{'¿ Desea eliminar el archivo de la carga corporativa ?'}}</strong></p>
            <ul>
                <li>{{ 'Del cliente: '.$data->cliente }}</li>
            </ul>
            <!-- <strong><p style="color:#e55353">{{'Al eliminar el registro, eliminará el registr.'}}</p></strong> -->
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="submit" id="btnModalEliminarProducto" >
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
    </form>
    </div>
    <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>

