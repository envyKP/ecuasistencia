<!DOCTYPE html>
<?php header_remove('X-Powered-By'); ?>
<html lang="es">

<head>
    <base href="./">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="{{ 'FOXN' }}">
    <meta name="author" content="{{ 'FOXN' }}">
    <meta name="keyword" content="{{ 'FOXN' }}">
    <title>{{ 'FOXN' }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage') . '/Logos/apple-touch-icon-16x16.png' }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('admin/assets/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css') }} " rel="stylesheet">

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

    @yield('scripts')

    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        // Shared ID
        gtag('config', 'UA-118965717-3');
        // Bootstrap ID
        gtag('config', 'UA-118965717-5');
    </script>

</head>


<body class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <!-- logotipos 115 x 46 -->
        @php
            use App\Models\EaCliente;
            $Allcampanas = EaCliente::get();
        @endphp
        <div class="c-sidebar-brand d-lg-down-none" style="background-color:#FFFFFF">
            <div class="c-sidebar-brand-full" width="115" height="46" alt="CoreUI Logo">
                <img src="{{ asset('storage') . '/Logos/ecas.png' }}" style="width:13rem" alt="">
            </div>
            <div class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">
                <img src="{{ asset('storage') . '/Logos/ecuaAsistencia_minimized.png' }}" alt="">
            </div>
        </div>
        <!-- menu del sibebar -->

        <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="c-sidebar-minimized"></button>
    </div>
    <div class="c-wrapper c-fixed-components">
        <!-- logotipo de cabecera - Se utiliza cuando se reduce pixeles -->
        <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
            <!-- Menu Avatar-->
            <ul class="c-header-nav ml-auto mr-4">



                <li class="c-header-nav-item dropdown">
                    <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use
                                        xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign') }}">
                                    </use>
                                </svg>{{ 'campo :' }}
                            </span>
                        </div>
                        <select class="custom-select" name="campaniasOpcionesID" id="campaniasOpcionesID" required>
                            <option selected>{{ 'Seleccione una Configuracion...' }}</option>
                            <option value="cedula_id">Fijo</option>
                            <option value="secuencia">Base</option>
                            <option value="cuenta">Fecha</option>
                        </select>

                        <div class="modal-footer">
                            <!--<button class="btn btn-secondary" type="button" data-dismiss="modal" onclick="window.close();">Cancelar</button>-->
                            <button class="btn btn-success" type="submit">
                                Añadir Campo
                            </button>
                        </div>

                        <div class="modal-footer">
                            <!--<button class="btn btn-secondary" type="button" data-dismiss="modal" onclick="window.close();">Cancelar</button>-->
                            <button class="btn btn-success" type="submit">
                                <svg class="c-icon c-icon-xl">
                                    <use
                                        xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save') }} ">
                                    </use>
                                </svg>
                                Guardar cambios
                            </button>
                        </div>
                    </a>
                </li>




                
            </ul>
        </header>


        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    <div class="fade-in"></div>
                    <!-- contenido dinamico SGA -->
                    @yield('content')
                </div>
            </main>

        </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('admin/node_modules/@coreui/coreui/dist/js/coreui.bundle.min.js') }} "></script>
    <!--[if IE]><!-->
    <script src="{{ asset('admin/node_modules/@coreui/icons/js/svgxuse.min.js') }} "></script>
    <!--<![endif]-->
</body>

</html>
