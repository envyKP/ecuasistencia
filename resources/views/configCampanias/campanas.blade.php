<div>
    <div class="alert alert-success text-center" role="alert">
        <h4>
            <svg class="c-icon c-icon-2xl mr-2">
                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}}"></use>
            </svg>
            {{'Clientes Disponibles'}}
        </h4>
    </div>
    <div class="card">
    <div class="card-header">{{'Selección de Cliente'}}</div>
    <div class="card-body">
        <form action="" method="post">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">
                        <svg class="c-icon">
                            <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}}"></use>
                        </svg></span>
                    </div>
                    <select class="custom-select mr-sm-2" name="clienteCMB" id="clienteCMB">
                        <option value ="clienteNull" selected>{{'Seleccione una cliente...'}}</option>
                        @foreach($Allcampanas as $campana)
                        <option value="{{isset($campana->cliente) ? $campana->cliente : '' }}">{{isset($campana->desc_cliente) ? $campana->desc_cliente : ''}}</option>
                        @endforeach
                    </select>
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
                    <div  style="width:25rem; heigth:25rem">
                        <img id="clienteLogo" class="pl-5 card-img-top" src="" alt="">
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
  
</div>
