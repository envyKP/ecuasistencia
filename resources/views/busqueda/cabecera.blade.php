<div class="alert alert-info " role="alert">
    <div class="row justify-content-between">
        <div>
             @if( session('filtro') && session('data') )
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-primary alert-dismissible fade show "  role="alert">
                    <svg class="c-icon c-icon-2xl my-1">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                    </svg>
                    <strong>{{ session('filtro') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif
            @if( session('error') && !session('data'))
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-danger alert-dismissible fade show "  role="alert">
                    @if( strcmp(session('error'), 'notData' )===0 )
                    <svg class="c-icon c-icon-2xl my-1">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-filter-x')}}"></use>
                    </svg>
                    @else
                    <svg class="c-icon c-icon-2xl my-1">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
                    </svg>
                    @endif
                    <strong>{{ session('filtro') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif
        </div>
        <div>
            <svg class="c-icon c-icon-3xl">
                <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-magnifying-glass')}}"></use>
            </svg>
            <h4>{{'Panel de Búsquedas - Base Activa'}}</h4>
        </div>
    </div>
</div>


<div class="from-row">
<div class="card">

<form action="{{ route('EaBaseActivaBusquedaController.search') }}" method="get">
    <div class="card-header">
        <svg class="c-icon c-icon-1xl mr-2">
            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-filter')}} "></use>
        </svg>
        <strong>{{'Filtros de buúsqueda'}}</strong>
        <button class="btn btn-outline-success mx-2 my-2 my-sm-0" id="btn-buscar" style="visibility:hidden" type="submit">{{'Buscar'}}</button>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="form-group col-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text form-control"> <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                            <label class="c-switch c-switch-label c-switch-success mt-2">
                                <input class="c-switch-input" type="checkbox" name="filtro1" id="filtro1" value="cedula_id"><span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                            </label>
                            <strong class="ml-1"> {{'Por cédula: '}} </strong>
                        </span>
                    </div>
                    <input class="form-control" type="text" id="cedula_id"  name="cedula_id" style="visibility:hidden" autocomplete="off" min="1" pattern="^[0-9]+">
                </div>
            </div>
            <div class="form-group col-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text form-control"> <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                            <label class="c-switch c-switch-label c-switch-success mt-2">
                                <input class="c-switch-input" type="checkbox" name="filtro2" id="filtro2" value="cliente"><span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                            </label>
                            <strong class="ml-1"> {{'Por cliente: '}} </strong>
                        </span>
                    </div>
                     <select class="custom-select" name="cliente" id="cliente" style="visibility:hidden">
                         <option value="">{{'Seleccion un cliente'}}</option>
                         @foreach( $campanasAll as $campanas)
                        <option value="{{ isset($campanas->cliente) ? $campanas->cliente : ''}}">{{ isset($campanas->desc_cliente) ? $campanas->desc_cliente : ''}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text form-control"> <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                            <label class="c-switch c-switch-label c-switch-success mt-2">
                                <input class="c-switch-input" type="checkbox" name="filtro3" id="filtro3" value="producto"><span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                            </label>
                            <strong class="ml-1"> {{'Por producto: '}} </strong>
                        </span>
                    </div>
                    <select class="custom-select" name="productoCMB" id="productoCMB" style="visibility:hidden">
                         <option value="">{{'Seleccion un Producto'}}</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text form-control"> <!-- form-control: ajusta el span(sombreado) al texto y al check-->
                            <label class="c-switch c-switch-label c-switch-success mt-2">
                                <input class="c-switch-input" type="checkbox" name="filtro4" id="filtro4" value="subproducto" ><span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                            </label>
                            <strong class="ml-1"> {{'Por sub    producto: '}} </strong>
                        </span>
                    </div>
                    <select class="custom-select"name="subproductoCMB" id="subproductoCMB" style="visibility:hidden">
                         <option value="">{{'Seleccion un Subproducto'}}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

</form>
</div>
</div>


