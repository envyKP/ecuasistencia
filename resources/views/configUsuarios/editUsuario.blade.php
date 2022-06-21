
<form class="form-horizontal" action="{{ route('UserController.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('post')
<div class="modal fade" id="{{ 'editar'.$row }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content col-10">
        <div class="modal-header">
            <h4 class="modal-title">
                <svg class="c-icon c-icon-2xl mr-1">
                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                </svg>
               {{'Editar usuario'}}
            </h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="id" value="{{ $usuario->id}}"  >

            <div class="form-group row">
                <img class="card-img-top" style="" src="{{ asset('storage').'/'.$usuario->foto }} "  alt="">
            </div>

            <div class="form-group row">
                <div class="col">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon  mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-instagram') }}"></use>
                            </svg></span></div>
                        <input class="form-control pt-1" type="file" name="foto" id="foto">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon c-icon-1xl mr-2">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-opsgenie')}} "></use>
                            </svg></span></div>
                        <input class="form-control" type="text" name="name" id="name" value="{{ $usuario->name}}"  placeholder="Ingrese nombre del usuario" title="Ingrese nombre del usuario">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon  mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-address-book') }}"></use>
                            </svg></span></div>
                        <input class="form-control" type="text" name="username" id="username" value="{{ $usuario->username}}" placeholder="Ingrese el username" title="Ingrese el username" >
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon  mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-lock-locked') }}"></use>
                            </svg></span></div>
                        <input class="form-control" type="password" name="password" id="password"  placeholder="Ingrese contraseña"  title="Ingrese contraseña">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon  mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle') }}"></use>
                            </svg></span></div>
                        <select class="custom-select" name="estado" id="estado">
                            @if ( strcmp( $usuario->estado, 'A') === 0  )
                            <option value="{{ $usuario->estado}}" selected> {{'Activo'}} </option>
                            <option value="I">{{'Inactivo'}}</option>
                            @else
                            <option value="{{ $usuario->estado}}" selected> {{'Inactivo'}} </option>
                            <option value="A">{{'Activo'}}</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon  mr-1">
                                <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-tencent-qq') }}"></use>
                            </svg></span></div>
                        <select class="custom-select" name="rol" id="rol">
                            @foreach ($roles as $rolopcion)
                            @if( $usuario->rol == $rolopcion->name_rol )
                                <option value="{{ $usuario->rol}}" selected>{{ $rolopcion->descripcion }}</option>
                            @else
                                <option value="{{ isset($rolopcion->name_rol) ? $rolopcion->name_rol : ''  }}">{{ isset($rolopcion->descripcion) ? $rolopcion->descripcion : '' }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            <button class="btn btn-success" type="submit">
                <svg class="c-icon c-icon-xl">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save')}} "></use>
                </svg>
            </button>
        </div>
    </div>
    <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>
</form>
