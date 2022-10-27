@extends('layouts.admin')
@section('content')
    <!-- /.row-->
    <div class="alert alert-info " role="alert">
        <div class="row justify-content-between">
            <div>
            </div>
            <div>
                <svg class="c-icon c-icon-3xl">
                    <use xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-settings') }}"></use>
                </svg>
                <h4>{{ 'Panel de Procesos' }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <a href="{{ route('EaCabCargaInicialController.index') }}">
                        <div class="text-muted text-right mb-4">
                            <svg class="c-icon c-icon-2xl">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-upload') }}">
                                </use>
                            </svg>
                        </div>
                        <small class="text-muted text-uppercase font-weight-bold">{{ 'Carga Inicial' }}</small>
                        <div class="progress progress-white progress-xs mt-3">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <a href="{{ route('EaGenArchiProveTmkController.index') }}">
                        <div class="text-muted text-right mb-4">
                            <svg class="c-icon c-icon-2xl">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-quantopian') }}">
                                </use>
                            </svg>
                        </div>
                        <small
                            class="text-muted text-uppercase font-weight-bold">{{ 'Generacion de archivo proveedor TMK' }}</small>
                        <div class="progress progress-white progress-xs mt-3">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.col-->
        <div class="col-sm-3 col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <a href="{{ route('EaRecepArchiProveTmkController.index') }} ">
                        <div class="text-muted text-right mb-4">
                            <svg class="c-icon c-icon-2xl">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-description') }}">
                                </use>
                            </svg>
                        </div>
                        <small
                            class="text-muted text-uppercase font-weight-bold">{{ 'Recepcion de archivo proveedor TMK' }}</small>
                        <div class="progress progress-white progress-xs mt-3">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- /.col-->
        <div class="col-sm-3 col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <a href="{{ route('EaGenArchiFinanController.index') }}">
                        <div class="text-muted text-right mb-4">
                            <svg class="c-icon c-icon-2xl">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-buzzfeed') }}">
                                </use>
                            </svg>
                        </div>
                        <small
                            class="text-muted text-uppercase font-weight-bold">{{ 'Generacion de archivo cliente corporativo información financiera' }}</small>
                        <div class="progress progress-white progress-xs mt-3">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!--  /.col -->
        <div class="col-sm-3 col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <a href="{{ route('EaRecepArchiFinanController.index') }}">
                        <div class="text-muted text-right mb-4">
                            <svg class="c-icon c-icon-2xl">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-description') }}">
                                </use>
                            </svg>
                        </div>
                        <small
                            class="text-muted text-uppercase font-weight-bold">{{ 'Recepcion de archivo cliente corportativo informacion financiera' }}</small>
                        <div class="progress progress-white progress-xs mt-3">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!--<div class="col-sm-3 col-md-3">
                    <div class="card text-white bg-success">
                    <div class="card-body">
                        <a href="/{/{ route('EaCargaIndividualExport.index') /}/}" >
                            <div class="text-muted text-right mb-4">
                                <svg class="c-icon c-icon-2xl">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-download') }}"></use>
                                </svg>
                            </div>
                            <small class="text-muted text-uppercase font-weight-bold">{{ 'Generacion de archivo de campañas' }}</small>
                            <div class="progress progress-white progress-xs mt-3">
                                <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </a>
                    </div>
                    </div>
                </div>-->
        <div class="col-sm-3 col-md-3">
            <div class="card text-black bg-secondary">
                <div class="card-body">
                    <a href="{{ route('EaCargaIndividualImport.index') }}">
                        <div class="text-muted text-right mb-4">
                            <svg class="c-icon c-icon-2xl">
                                <use
                                    xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-upload') }}">
                                </use>
                            </svg>
                        </div>
                        <small
                            class="text-muted text-uppercase font-weight-bold">{{ 'Entrada / Salida de archivo de campañas' }}</small>
                        <div class="progress progress-white progress-xs mt-3">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <a href="<?php echo e(route('EaCancelacionMasivaController.index')); ?>">
                        <div class="text-muted text-right mb-4">
                            <svg class="c-icon c-icon-2xl">
                                <use xlink:href="<?php echo e(asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash')); ?>">
                                </use>
                            </svg>
                        </div>
                        <small class="text-muted text-uppercase font-weight-bold"><?php echo e('Cancelacion Masiva'); ?></small>
                        <div class="progress progress-white progress-xs mt-3">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="card text-black bg-secondary">
                <div class="card-body">
                    <a href="<?php echo e(route('EaControlCampania.index')); ?>">
                        <div class="text-muted text-right mb-4">
                            <svg class="c-icon c-icon-2xl">
                                <use xlink:href="<?php echo e(asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cog')); ?>">
                                </use>
                            </svg>
                        </div>
                        <small class="text-muted text-uppercase font-weight-bold"><?php echo e('Modulo de control campañas'); ?></small>
                        <div class="progress progress-white progress-xs mt-3">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="card text-black bg-secondary">
                <div class="card-body">
                    <a href="<?php echo e(route('EaControlCampania.index')); ?>">
                        <div class="text-muted text-right mb-4">
                            <svg class="c-icon c-icon-2xl">
                                <use xlink:href="<?php echo e(asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cog')); ?>">
                                </use>
                            </svg>
                        </div>
                        <small class="text-muted text-uppercase font-weight-bold"><?php echo e('Campañas Almacenadas'); ?></small>
                        <div class="progress progress-white progress-xs mt-3">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>



    </div>
@endsection
