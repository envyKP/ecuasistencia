
    <div class="alert alert-success text-center" role="alert">
        <h4>
            <svg class="c-icon c-icon-2xl mr-2">
                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cashapp')}}"></use>
            </svg>
            {{'Impuestos Asociados al cliente'}}
        </h4>
    </div>
    <div class="card">
    <div class="card-body">
        <form action="{{ route('EaImpuestosController.destroy') }}" method="post" id="form-eliminaImpuesto">
            @csrf
            @method('post')
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">
                        <svg class="c-icon">
                            <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}}"></use>
                        </svg></span>
                    </div>
                    <select class="custom-select mr-sm-2" name="impuestosCMB" id="impuestosCMB">
                        <option value ="" selected>{{'Seleccione un Impuesto...'}}</option>
                    </select>
                </div>
            </div>
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

                    <input type="hidden" name="clienteImpForm" id="clienteImpForm">
                    <input type="hidden" name="id_impuesto" id="id_impuesto">
                    <input class="form-control" maxlength="20"  type="text" id="nom_impuestoForm" name="nom_impuestoForm" placeholder="Ingrese Nombre del Producto" autocomplete="off" readonly oninput="this.value = this.value.toUpperCase()">
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
                    <input class="form-control" maxlength="20"  type="text" id="desc_impuestoForm"  name="desc_impuestoForm"   placeholder="Ingrese Nombre del Producto" autocomplete="off" readonly oninput="this.value = this.value.toUpperCase()">
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
                    <input class="form-control" maxlength="20"  type="text" id="valor_porcentajeForm"  placeholder="Ingrese Nombre del Producto" autocomplete="off" readonly oninput="this.value = this.value.toUpperCase()">
                    <span class="input-group-text">
                        <svg class="c-icon mr-1">
                            <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-slashdot')}}"></use>
                        </svg>
                    </span>
                </div>
            </div>
        </form>
        <div class="form-group form-actions row d-flex justify-content-center">
            <button class="btn btn-sm btn-outline-danger mr-md-2  my-1" id="btn-EliminaImpuestoInfor" style="visibility:hidden"  title="Eliminar impuesto"  type="button" data-toggle="modal" data-target="#eliminarImpuesto">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                </svg>
                {{'Eliminar'}}
            </button>
            @include('configClientesImpuestos.eliminarImpuesto')

            <button class="btn btn-sm btn-success mr-md-2  my-1"  title="Crear nuevo impuesto" id="btn-crearImpuesto"  style="visibility:hidden"  type="button" data-toggle="modal" data-target="#crearImpuesto">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-thick-to-bottom')}}"></use>
                </svg>
                {{'Crear Nuevo'}}
            </button>
            @include('configClientesImpuestos.nuevoImpuesto')

            <button class="btn btn-sm btn-outline-success mr-md-2  my-1"  title="Editar impuesto actual" id ="btn-editImpuesto" style="visibility:hidden"  type="button" data-toggle="modal" data-target="#editarImpyesto">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                </svg>
                {{'Editar'}}
            </button>
            @include('configClientesImpuestos.editImpuesto')
        </div>
    </div>
</div>

