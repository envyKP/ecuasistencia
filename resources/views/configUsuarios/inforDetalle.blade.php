@php $cont= 0; @endphp
<table class="table table-responsive-sm table-hover table-outline mb-0">
<thead class="thead-light">
    <tr>
        <th>
            <strong>{{'#'}}</strong>
        </th>
        <th>{{'Foto'}}</th>
        <th class="text-left">{{'Nombre'}}</th>
        <th>{{'Username'}}</th>
        <th >{{'Rol'}}</th>
        <th >{{'Email'}}</th>
        <th class="text-center">{{'Estado'}}</th>
        <th class="text-center">{{'Acción'}}</th>
    </tr>
</thead>

@if ( isset($usuarios) )
<tbody>
    @foreach ( $usuarios as $usuario)
       @php $cont++; @endphp
    <tr>
        <td>
          <strong>{{ $cont }}</strong>
        </td>
        <td>
            @if (!is_null( Auth::user()->foto))
            <div class="c-avatar ml-1"><img class="c-avatar-img" src="{{ asset('storage').'/'.$usuario->foto }} " alt="{{ $usuario->username}}"></div>
            @else
            <div class="c-avatar ml-1">{{'Sin imagen'}}</div>
            @endif
        </td>
        <td>
            <div>
                <svg class="c-icon c-icon-1xl mr-2">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-opsgenie')}} "></use>
                </svg>   {{ $usuario->name }}
            </div>
        </td>
        <td>
            <div>
                <svg class="c-icon c-icon-1xl">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-address-book')}} "></use>
                </svg> {{ $usuario->username }}
            </div>
        </td>
        <td>
            <div>
                @if ( stripos($usuario->rol, 'admin') !== false )
                <svg class="c-icon c-icon-1xl">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-tencent-qq')}} "></use>
                </svg> {{ $usuario->rol }}
                @else
                       {{ $usuario->rol }}
                @endif
            </div>
        </td>
        <td>
            <div>
                <svg class="c-icon c-icon-1xl">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-gmail')}} "></use>
                </svg> {{ $usuario->email }}
            </div>
        </td>
        <td class="text-center">
           <strong>{{ $usuario->estado }}</strong>
        </td>

        <td class="text-center">
            @php
                ${ 'usuario'.$cont } = $usuario;
            @endphp
            <button class="btn btn-outline-success" title="Ver detalles de registro" type="button" data-toggle="modal" data-target="{{ '#editar'.$cont }}">
                <svg class="c-icon c-icon-1xl">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pen')}} "></use>
                </svg>
            </button>
            @include('configUsuarios.editUsuario', [ 'usuario' => ${ 'usuario'.$cont } , 'row' => $cont, 'roles' => $roles ])
        </td>

    </tr>
    @endforeach
</tbody>
@endif
</table>
@if ( count($usuarios)>1  )
    {{  $usuarios->links() }}
@endif
