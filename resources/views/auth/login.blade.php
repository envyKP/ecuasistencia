<!DOCTYPE html>


<html lang="es">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="{{'FOXN'}}">
    <meta name="author" content="{{'FOXN'}}">
    <meta name="keyword" content="{{'FOXN'}}">
    <title>{{'FOXN'}}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage').'/Logos/apple-touch-icon-16x16.png' }}" >
    <link rel="manifest" href="{{ asset('admin/assets/favicon/manifest.json')}} ">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('admin/assets/favicon/ms-icon-144x144.png')}} ">
    <meta name="theme-color" content="#ffffff">
     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css')}} " rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <!-- Scripts para ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
  <body class="c-app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-5">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <form action="{{ route('login') }}" method="post">
                 @csrf
                    <div class="text-center">
                        <img class="card-img-top" src="{{ asset('Logos/ecuasistenciaLogin.png') }}"  alt="">
                    </div>
                    <h1>Login</h1>
                    <p class="text-muted">{{'Inicio de sesión'}}</p>
                    @if(session('error'))
                    <div class="col">
                        <div class="card-body">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{'error: '}}</strong>{{ session('error') }}
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-user')}} "></use>
                            </svg></span></div>
                        <input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off" autofocus required oninput="this.value = this.value.toUpperCase();">
                    </div>

                    <div class="input-group mb-4">
                    <div class="input-group-prepend"><span class="input-group-text">
                        <svg class="c-icon">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-lock-locked')}} "></use>
                        </svg></span></div>
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-success px-4" type="submit">Login</button>
                        </div>
                    </div>
                </form>
             </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('admin/node_modules/@coreui/coreui/dist/js/coreui.bundle.min.js')}} "></script>
    <!--[if IE]><!-->
    <script src="{{ asset('admin/node_modules/@coreui/icons/js/svgxuse.min.js')}} "></script>
    <!--<![endif]-->
  </body>
</html>
