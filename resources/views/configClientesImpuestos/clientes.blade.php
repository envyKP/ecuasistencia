
<div class="alert alert-dark text-center" role="alert">
    <h4>
        <svg class="c-icon c-icon-2xl mr-2">
            <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}}"></use>
        </svg>
        {{'Clientes Disponibles'}}
    </h4>
</div>
<div class="card">
<div class="card-body">
        <form action=" {{ route('EaClienteController.destroy') }}" id="form-eliminaCliente" method="post">
            @csrf
            @method('post')
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">
                        <svg class="c-icon">
                            <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}}"></use>
                        </svg></span>
                    </div>
                    <select class="custom-select mr-sm-2" name="clienteCMB" id="clienteCMB">
                        <option value ="" selected>{{'Seleccione un cliente...'}}</option>
                        @foreach($dataClientes as $cliente)
                        <option value="{{ isset($cliente->cliente) ? $cliente->cliente : '' }}">{{ isset($cliente->desc_cliente) ? $cliente->desc_cliente : '' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
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
                    <input type="hidden" id="id_cliente" name="id_cliente">
                    <input class="form-control" maxlength="40"  type="text" id="clienteForm"  placeholder="Ingrese Nombre del Producto" autocomplete="off" readonly>
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
                    <input class="form-control" maxlength="40"  type="text" id="desc_clienteForm" name="desc_clienteForm"  placeholder="Ingrese Nombre del Producto" autocomplete="off" readonly>
                </div>
            </div>
        </form>
        <div class="form-group form-actions row d-flex justify-content-center">
            <button class="btn btn-sm btn-outline-danger mr-md-2  my-1" title="Eliminar el cliente actual"  id="btn-eliminaCliente" style="visibility:hidden" type="button" data-toggle="modal" data-target="#elimnarCliente">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                </svg>
                {{'Eliminar'}}
            </button>
            @include('configClientesImpuestos.eliminarCliente')

            <button class="btn btn-sm btn-success mr-md-2  my-1" id="btn-creaCliente"  title="Crear un cliente" type="button" data-toggle="modal" data-target="#nuevoCliente">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-thick-to-bottom')}}"></use>
                </svg>
                {{'Crear Nuevo'}}
            </button>
            @include('configClientesImpuestos.nuevoCliente')

            <button class="btn btn-sm btn-outline-success mr-md-2  my-1" title="Editar información del cliente"  id ="btn-EditCliente"  style="visibility:hidden" type="button" data-toggle="modal" data-target="#editarCliente">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                </svg>
                {{'Editar'}}
            </button>
            @include('configClientesImpuestos.editCliente')
        </div>
</div>
</div>

