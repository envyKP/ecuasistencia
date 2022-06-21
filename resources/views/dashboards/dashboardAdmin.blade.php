@extends('layouts.admin')
@section('content')
<!-- /.row-->
<div class="row">
    <div class="col-sm-2 col-md-2">
        <div class="card text-white bg-info">
        <div class="card-body">
            <a href="{{ route('UserController.index') }}">
                <div class="text-muted text-right mb-4">
                    <svg class="c-icon c-icon-2xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-people') }}"></use>
                    </svg>
                </div>
                <small class="text-muted text-uppercase font-weight-bold">{{'Módulo Usuarios'}}</small>
                <div class="progress progress-white progress-xs mt-3">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </a>
        </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-3 col-md-3">
        <div class="card text-white bg-warning">
        <div class="card-body">
            <a href="{{ route('EaProductoController.index') }} ">
                <div class="text-muted text-right mb-4">
                    <svg class="c-icon c-icon-2xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-basket') }}"></use>
                    </svg>
                </div>
                <small class="text-muted text-uppercase font-weight-bold">{{'Conf. Productos & Subprod.'}}</small>
                <div class="progress progress-white progress-xs mt-3">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </a>
        </div>
        </div>
    </div>
    <!-- /.col-->
    <div class="col-sm-3 col-md-3">
        <div class="card text-white bg-primary">
        <div class="card-body">
            <a href="{{ route('EaClienteController.index') }}" >
                <div class="text-muted text-right mb-4">
                    <svg class="c-icon c-icon-2xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-bank') }}"></use>
                    </svg>
                </div>
                <small class="text-muted text-uppercase font-weight-bold">{{'Config. Clientes & Impuestos'}}</small>
                <div class="progress progress-white progress-xs mt-3">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </a>
        </div>
        </div>
    </div>
   <!--  /.col -->
    <div class="col-sm-2 col-md-2">
        <div class="card text-white bg-danger">
        <div class="card-body">
            <a href="{{route('EaBaseActivaBusquedaController.index')}}">
                <div class="text-muted text-right mb-4">
                    <svg class="c-icon c-icon-2xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-search') }}"></use>
                    </svg>
                </div>
                <small class="text-muted text-uppercase font-weight-bold">{{'Panel de Búsqueda'}}</small>
                <div class="progress progress-white progress-xs mt-3">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </a>
        </div>
        </div>
    </div>
    <div class="col-sm-2 col-md-2">
        <div class="card text-white bg-success">
        <div class="card-body">
            <a href="{{route('EaMigracionBaseActivaController.index')}}">
                <div class="text-muted text-right mb-4">
                    <svg class="c-icon c-icon-2xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-upload') }}"></use>
                    </svg>
                </div>
                <small class="text-muted text-uppercase font-weight-bold">{{'Cargar Base Activa'}}</small>
                <div class="progress progress-white progress-xs mt-3">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </a>
        </div>
        </div>
    </div>
    <div class="col-sm-2 col-md-2 bg-#9da5b1">
        <div class="card text-white bg-success">
        <div class="card-body">
            <a href="{{ route('EaFactMasSeguviajeController.index')}}">
                <div class="text-muted text-right mb-4">
                    <svg class="c-icon c-icon-2xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-wallet') }}"></use>
                    </svg>
                </div>
                <small class="text-muted text-uppercase font-weight-bold">{{'Facturacion Masiva - SegurViaje'}}</small>
                <div class="progress progress-white progress-xs mt-3">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </a>
        </div>
        </div>
    </div>

</div>
@endsection

