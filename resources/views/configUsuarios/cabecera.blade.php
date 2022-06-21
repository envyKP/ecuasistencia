<div class="alert alert-info " role="alert">
    <div class="row justify-content-between">
        <div>
            @if ( session('mensaje') )
                <div class="col-sm-12 col-md-12">
                    <div class="alert alert-success alert-dismissible fade show "  role="alert">
                        <svg class="c-icon c-icon-2xl my-1">
                            <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save')}}"></use>
                        </svg>
                        <strong>{{ session('mensaje') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif
            @if ( session('error') || session('errors') )
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-danger alert-dismissible fade show "  role="alert">
                        <svg class="c-icon c-icon-2xl my-1">
                            <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-user-unfollow')}}"></use>
                        </svg>
                        <strong>{{ session('error') }}</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

        </div>
        <div>
            <svg class="c-icon c-icon-3xl">
                <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-people')}}"></use>
            </svg>
            <h4>{{'Mantenedor Usuarios'}}</h4>
        </div>

    </div>
</div>

<div class="row justify-content-md-start">
    <!-- /.col-->
    <div class="col-sm-6 col-md-4">
        <div class="card">
            <div class="card-header ">
                <svg class="c-icon c-icon-1xl mr-2">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-filter')}} "></use>
                </svg>
                <strong>{{'Filtro de Búsqueda - Usuarios'}}</strong>
            </div>
            <nav class="navbar navbar-light bg-light" >
                <form class="form-inline" action="{{ route ('UserController.show') }}" method="post">
                    @csrf
                    @method('post')
                    <input class="form-control mr-sm-2" type="text" name="username" placeholder="{{'Ingrese username'}}" aria-label="Search" autocomplete="off">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{'Buscar'}}</button>
                </form>
            </nav>
        </div>
    </div>
    <div class="col-sm-6 col-md-4 mt-1">
        <button class="btn btn-success" title="Agregar nuevo usuario" type="button" data-toggle="modal" data-target="#successModal">
            <svg class="c-icon c-icon-1xl">
                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-user-follow')}} "></use>
            </svg>
        </button>
        @include('configUsuarios.nuevoUsuario', [ 'roles' => $roles])
    </div>

</div>
