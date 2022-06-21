<!DOCTYPE html>
<?php header_remove("X-Powered-By"); ?>
<html lang="es">
  <head>
    <base href="./">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="{{'FOXN'}}">
    <meta name="author" content="{{'FOXN'}}">
    <meta name="keyword" content="{{'FOXN'}}">
    <title>{{'FOXN'}}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage').'/Logos/apple-touch-icon-16x16.png' }}" >
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('admin/assets/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
     <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css')}} " rel="stylesheet">

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

    @yield('scripts')

    <script src="{{ asset('js/app.js') }}" ></script>

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
        <div class="c-sidebar-brand d-lg-down-none" style="background-color:#FFFFFF">
            <div class="c-sidebar-brand-full" width="115" height="46" alt="CoreUI Logo">
                <img src="{{ asset('storage').'/Logos/ecas.png' }}" style="width:13rem" alt="">
            </div>
            <div class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">
                <img src="{{ asset('storage').'/Logos/ecuaAsistencia_minimized.png' }}"  alt="">
            </div>
        </div>
        <!-- menu del sibebar -->
        <ul class="c-sidebar-nav">
            <li class="c-sidebar-nav-title">{{'Clientes'}}</li>

            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" >
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}} "></use>
                    </svg>{{'Diners Club'}}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                            <a class="c-sidebar-nav-link" href="{{ route('EaClienteController.show').'?cliente=DINERS' }}">
                            <span class="c-sidebar-nav-icon"></span>{{'Panel Administrador'}}
                            </a>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}} "></use>
                    </svg>{{'Movistar'}}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('EaClienteController.show').'?cliente=MOVISTAR' }} ">
                            <span class="c-sidebar-nav-icon"></span>{{'Panel Administrador'}}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}} "></use>
                    </svg>{{'Nova S.A.'}}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('EaClienteController.show').'?cliente=NOVA' }}">
                            <span class="c-sidebar-nav-icon"></span>{{'Panel Administrador'}}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}} "></use>
                    </svg>{{'Banco Bolivariano'}}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('EaClienteController.show').'?cliente=BBOLIVARIANO' }}">
                            <span class="c-sidebar-nav-icon"></span>{{'Panel Administrador'}}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}} "></use>
                    </svg>{{'Banco General Rumiñahui'}}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <form action="" method="post" id="form-bgr">
                        @csrf
                            <input type="hidden" name="cliente" value="">
                            <a class="c-sidebar-nav-link" href="{{ route('EaClienteController.show').'?cliente=BGR' }}" >
                                <span class="c-sidebar-nav-icon"></span>{{'Panel Administrador'}}
                            </a>
                        </form>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#" >
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}} "></use>
                    </svg>{{'Banco Internacional'}}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('EaClienteController.show').'?cliente=INTER' }}" >
                            <span class="c-sidebar-nav-icon"></span>{{'Panel Administrador'}}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}} "></use>
                    </svg>{{'Banco Produbanco'}}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route ('EaClienteController.show').'?cliente=PRODUBANCO' }}" >
                            <span class="c-sidebar-nav-icon"></span>{{'Panel Administrador'}}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}} "></use>
                    </svg>{{'Banco Pichincha'}}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('EaClienteController.show').'?cliente=PICHINCHA' }}" >
                            <span class="c-sidebar-nav-icon"></span>{{'Panel Administrador'}}
                        </a>
                    </li>
                </ul>
            </li>

            <li class="c-sidebar-nav-divider"></li>

            <li class="c-sidebar-nav-title">{{'Búsqueda'}}</li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-search')}} "></use>
                    </svg>{{'Panel de búsqueda'}}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{route('EaBaseActivaBusquedaController.index')}}">
                            <span class="c-sidebar-nav-icon"></span>{{'Panel Administrador'}}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-divider"></li>
            @if( strtolower(Auth::user()->rol) == 'admin')
            <li class="c-sidebar-nav-title">{{'Carga de Archivos'}}</li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-upload')}} "></use>
                    </svg>{{'Procesos de carga'}}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{url('menu/procesos/carga/')}}">
                            <span class="c-sidebar-nav-icon"></span>{{'Panel Administrador'}}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-divider"></li>
            @endif
            <li class="c-sidebar-nav-title">{{'Reporteria'}}</li>
        </ul>
      <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
    </div>
    <div class="c-wrapper c-fixed-components">
        <!-- logotipo de cabecera - Se utiliza cuando se reduce pixeles -->
        <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
                <svg class="c-icon c-icon-lg">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-menu')}} "></use>
                </svg>
            </button>
            <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
                <svg class="c-icon c-icon-lg">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-menu')}} "></use>
                </svg>
            </button>
            <ul class="c-header-nav d-md-down-none">
                @if( strtolower(Auth::user()->rol) == 'admin')
                <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="{{ url('/dashboard/admin') }}" >{{'Menú Administrador'}}</a></li>
                @endif
            </ul>
            <!-- Menu Avatar-->
            <ul class="c-header-nav ml-auto mr-4">
                <li class="c-header-nav-item dropdown">
                    <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        @if (!empty( Auth::user()->foto))
                        <div class="c-avatar ml-1"><img class="c-avatar-img" src="{{ asset('storage').'/'.Auth::user()->foto }} " alt="x"></div>
                        @endif
                    <div class="ml-2"><strong>  {{ Auth::user()->name }} </strong> </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pt-0">
                        <div class="dropdown-header bg-light py-2"><strong>Opciones</strong></div>
                        @if( strtolower(Auth::user()->rol) == 'admin')
                        <a class="dropdown-item" href="{{ url('/dashboard/admin') }}">
                            <svg class="c-icon mr-2">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}} "></use>
                            </svg>{{'Settings'}}
                        </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-account-logout')}} "></use>
                            </svg>{{ __('Logout') }}
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                    </div>
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
            <!-- <footer class="c-footer">
                    <div><a>{{'Ecuacodigo'}}</a> &copy; {{'2021.'}}</div>
                    <div class="ml-auto">Powered by&nbsp;<a href="https://coreui.io/">CoreUI</a></div>
            </footer> -->
        </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('admin/node_modules/@coreui/coreui/dist/js/coreui.bundle.min.js')}} "></script>
    <!--[if IE]><!-->
    <script src="{{ asset('admin/node_modules/@coreui/icons/js/svgxuse.min.js')}} "></script>
    <!--<![endif]-->
  </body>
</html>
