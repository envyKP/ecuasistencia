<!-- /.modal-->
<form action="{{ route('UserController.store') }}" method="post" enctype="multipart/form-data">
@csrf
{{method_field('post') }}
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-success" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">
                <svg class="c-icon c-icon-2xl mr-1">
                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-thick-to-bottom')}}"></use>
                </svg>
             {{'Crear nuevo usuario'}}
            </h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
            <div class="modal-body">

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
                            <input class="form-control" type="text" name="name" id="name" placeholder="Ingrese nombre del usuario" title="Ingrese nombre del usuario" required>
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
                            <input class="form-control" type="text" name="username" id="username"  placeholder="Ingrese el username"  title="Ingrese el username" required >
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
                            <input class="form-control" type="password" name="password" id="password"  placeholder="Ingrese contraseña" title="Ingrese contraseña" required >
                        </div>
                    </div>
                </div>
                <!--
                <div class="form-group row">
                    <div class="col">
                        <div class="input-group ">
                            <div class="input-group-prepend"><span class="input-group-text">
                                <svg class="c-icon  mr-1">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cil-lock-locked') }}"></use>
                                </svg></span></div>
                            <input class="form-control" type="text" name="email" id="email" placeholder="Confirme contraseña para la plataforma" title="Confirme contraseña para la plataforma" required>
                        </div>
                    </div>
                </div>
                -->
                <div class="form-group row">
                    <div class="col">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">
                                <svg class="c-icon  mr-1">
                                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle') }}"></use>
                                </svg></span></div>
                            <select class="custom-select" name="estado" id="estado">
                                <option value="A" selected>{{'Activo'}}</option>
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
                            <select class="custom-select" name="rol" id="rol" required>
                                <option value="">{{'Selecciona un rol'}}</option>
                                @foreach ($roles as $rolopcion)
                                <option value="{{ isset($rolopcion->name_rol) ? $rolopcion->name_rol : ''  }}">{{ isset($rolopcion->descripcion) ? $rolopcion->descripcion : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-success"   type="submit">
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

