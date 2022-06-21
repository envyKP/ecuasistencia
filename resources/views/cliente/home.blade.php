@extends('layouts.admin')

@php
    $cont = 0;
@endphp


@section('scripts')
<script type="text/javascript">
$(document).ready(function(){

    setInterval(function(){

        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();

        // Add leading zeros
        minutes = (minutes < 10 ? "0" : "") + minutes;
        seconds = (seconds < 10 ? "0" : "") + seconds;
        hours = (hours < 10 ? "0" : "") + hours;

        // Compose the string for display
        var currentTimeString = hours + ":" + minutes + ":" + seconds;

        $("#horasys").val(currentTimeString);

    },1000);



    $("#btn-editCliente").click(function(){

        $("#btn-saveCliente").css('visibility', 'visible');
        $("#btn-cancelarCliente").css('visibility', 'visible');

        $("#nombre").prop('readonly', false);
        $("#tipide").prop('disabled', false);
        $("#cedula_id").prop('readonly', false);
        $("#genero").prop('disabled', false);
        $("#ciudad").prop('disabled', false);
        $("#direccion").prop('readonly', false);
        $("#fechanacimiento").prop('readonly', false);
        $("#tiptar").prop('disabled', false);
        $("#tipcta").prop('disabled', false);
        $("#ciclo").prop('disabled', false);
        $("#telefono_contacto").prop('readonly', false);
        $("#mail").prop('readonly', false);
        $("#telefono1").prop('readonly', false);
        $("#telefono2").prop('readonly', false);
        $("#telefono3").prop('readonly', false);
        $("#telefono4").prop('readonly', false);
        $("#telefono5").prop('readonly', false);
        $("#telefono6").prop('readonly', false);
        $("#telefono7").prop('readonly', false);
        $("#producto").prop('disabled', false);
        $("#subproducto").prop('disabled', false);

    });

    $("#btn-cancelarCliente").click(function(){

        $("#btn-saveCliente").css('visibility', 'hidden');
        $(this).css('visibility', 'hidden');

        $("#nombre").prop('readonly', true);
        $("#tipide").prop('disabled', true);
        $("#cedula_id").prop('readonly', true);
        $("#genero").prop('disabled', true);
        $("#ciudad").prop('disabled', true);
        $("#direccion").prop('readonly', true);
        $("#fechanacimiento").prop('readonly', true);
        $("#tiptar").prop('disabled', true);
        $("#tipcta").prop('disabled', true);
        $("#ciclo").prop('disabled', true);
        $("#telefono_contacto").prop('readonly', true);
        $("#mail").prop('readonly', true);
        $("#telefono1").prop('readonly', true);
        $("#telefono2").prop('readonly', true);
        $("#telefono3").prop('readonly', true);
        $("#telefono4").prop('readonly', true);
        $("#telefono5").prop('readonly', true);
        $("#telefono6").prop('readonly', true);
        $("#telefono7").prop('readonly', true);
        $("#producto").prop('disabled', true);
        $("#subproducto").prop('disabled', true);

    });


    $("#btn-confirmaGuardarDatosCliente").click(function(){
        $("#form-editCliente").submit();
    });


    /*#####################  Detalle de asistencia  ##################### */

    $("#btn-editAsis").click(function(){
        $("#btn-saveAsis").css('visibility', 'visible');
        $("#btn-cancelarAsis").css('visibility', 'visible');

        $("#producto").prop('readonly', false);
        $("#subproducto").prop('readonly', false);
        //$("#estado").prop('disabled', false);
        $("#tipcta").prop('disabled', false);
        $("#ciclo").prop('disabled', false);

        $("#codestado").prop('disabled', false);
        $("#tarjeta").prop('readonly', false);
        $("#feccad").prop('readonly', false);
        $("#observaciones").prop('readonly', false);
        $("#observaciones").val(null);
        $("#codresp").prop('disabled', false);
        $("#cuenta").prop('readonly', false);

    });


    $("#btn-cancelarAsis").click(function(){
        $("#btn-saveAsis").css('visibility', 'hidden');
        $(this).css('visibility', 'hidden');

        $("#producto").prop('readonly', true);
        $("#subproducto").prop('readonly', true);
        //$("#estado").prop('disabled', true);
        $("#tipcta").prop('disabled', true);
        $("#ciclo").prop('disabled', true);

        $("#codestado").prop('disabled', true);
        $("#tarjeta").prop('readonly', true);
        $("#feccad").prop('readonly', true);
        $("#observaciones").prop('readonly', true);
        $("#codresp").prop('disabled', true);
        $("#cuenta").prop('readonly', true);

    });


    $("#producto").change(function(){
        $.ajax({
            url:"{{route('EaSubproductoController.getSubproductoCli')}}?cliente="+$("#cliente").val()+"&contrato_ama="+$(this).val(),
            method:'get',
            success: function(data){
                $("#subproducto").html(data.htmlSubproducto);
            }
        });

    });


    $("#productoClienteNuevo").change(function(){

        $.ajax({
            url:"{{route('EaSubproductoController.getSubproductoCli')}}?cliente="+$("#cliente").val()+"&contrato_ama="+$(this).val(),
            method:'get',
            success: function(data){
                $("#subprodClienteNuevo").html(data.htmlSubproducto);
            }
        });

    });


    $("#estado_reg").change(function(){
        $("#comentario").focus();
    });


    $("#btn-saveAsis").click(function(){

        $("#div_mot_desactivacion").prop("required", true);

        if (  $("#observaciones").val() == '' || $("#motivos_desactivacion").val() == ''  ) {

            if ( $("#observaciones").val() == '' ){
                $("#observaciones").removeClass('form-control');
                $("#observaciones").addClass('form-control is-invalid');
                $("#observaciones").focus();
            }

            if (  $("#motivos_desactivacion").val() == '') {
                $("#motivos_desactivacion").removeClass('form-control');
                $("#motivos_desactivacion").addClass('form-control is-invalid');
                $("#motivos_desactivacion").focus();
            }

        }else {
            //pregunta si desea guardar cambios
           $("#guardarAsistencia").modal('show');
        }
    });

    //confirma guarda cambios asistencia campaña
    $("#btn-confirmaGuardarAsistencia").click(function(){
        $("#form-saveAsis").submit();
    });



    //================= RETENCION ======================//

    $("#btn-editRetencion").click(function(){

        $("#btn-saveAsis").css('visibility', 'visible');
        $("#btn-cancelarRetencion").css('visibility', 'visible');
        $("#call_type_retencion").prop('disabled', false);
        $("#origen").prop('disabled', false);
        $("#codestado").prop('disabled', false);
        $("#observaciones").prop('readonly', false);
        $("#observaciones").val(null);

    });


    $("#btn-cancelarRetencion").click(function(){

        $("#call_type_retencion").val(null);
        $("#call_type_retencion").find('option[value=""]').attr('selected', 'selected');
        $("#motivos_desactivacion").val();
        $("#div_mot_desactivacion").css("display", "none");
        $("#codestado").prop('disabled', true);
        $("#observaciones").prop('readonly', true);

        $("#call_type_retencion").prop('disabled', true);
        $("#origen").prop('disabled', true);
        $(this).css('visibility', 'hidden');
        $("#btn-saveAsis").css('visibility', 'hidden');

    });


    $("#call_type_retencion").change(function(){

       //combo del estado del cliente, quito seleccion
        $("#codestado").find('option[value="'+ $("#codestado").val() +'"]').attr("selected", false);


        if(  $("#call_type_retencion").val()== 1 ||  $("#call_type_retencion").val()== 3 ||  $("#call_type_retencion").val()== 4)
        {
            $("#codestado").find('option[value="A"]').attr("selected", "selected");//agrego nueva seleccion, en base a CT de retencion
            //quito motivos de desactivacion si CT de rentencion: es 1=Activacion, 3=informacion, 4=retencion
            $("#motivos_desactivacion").html('<option value="" selected>Seleccione un motivo</option>');
            $("#motivos_desactivacion").val();
            $("#div_mot_desactivacion").css("display", "none");
        }

        //Si CT de retencion: 2=Cancelacion
        if (  $("#call_type_retencion").val()== 2)
        {
            $.ajax({
                url:"{{route('EaMotivoDesactivacionController.getMotivosHtml')}}",
                method: "get",
                success: function(data){
                    $("#motivos_desactivacion").html(data.htmlMotivos);
                    $("#div_mot_desactivacion").css("display", "block");
                }

            });

            $("#codestado").find('option[value="C"]').attr("selected", "selected");
        }


        if ( $("#call_type_retencion").val()=='' )
        {
            $("#codestado").find('option[value="'+ $("#codestado").val() +'"]').attr("selected", false);

            $("#motivos_desactivacion").html('<option value="" selected>Seleccione un motivo</option>');
            $("#motivos_desactivacion").val();
            $("#div_mot_desactivacion").css("display", "none");
        }


    });


});

    //javaScript puro, valida solo el ingreso de numeros en inputs text
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

</script>
@endsection


@section('content')
<a href="{{ route('EaBaseActivaBusquedaController.index') }}">
<button class="btn btn-danger my-2" type="button" title="Regresar!.">
        <svg class="c-icon c-icon-1xl mr-2  ">
            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-account-logout') }}"></use>
        </svg>
</button>
</a>
<div class="row justify-content-between">
    <!-- /.col-->
    <div class="col-sm-6 col-md-4">
        <div class="card">
            <div class="card-header ">
                <svg class="c-icon c-icon-1xl mr-2">
                   <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-filter')}} "></use>
                </svg>
                <strong>{{'Filtro de Búsqueda - Base Activa'}}</strong>
            </div>
            <nav class="navbar navbar-light bg-light" >
                <form class="form-inline" action="{{ route ('EaBaseActivaController.serch') }}" method="post" id="form-busqueda">
                 @csrf
                 @method('post')
                    <input type="hidden" name="proceso" value="">
                    <input type="hidden" name="cliente" value="{{ isset($campana->cliente) ? $campana->cliente : '' }}">
                    <input class="form-control mr-sm-2" type="number" name="cedula_id" placeholder="{{'Identificación'}}"  min="1" pattern="^[0-9]+" aria-label="Search" autocomplete="off">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{'Buscar'}}</button>
                </form>
            </nav>
        </div>
    </div>

    <!-- /.col-->
    @if( session('success') )
    <div class="col-sm-3 col-md-3">
        <div class="alert alert-success alert-dismissible fade show "  role="alert">
            <svg class="c-icon c-icon-2xl my-1">
                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save')}}"></use>
            </svg>
            <strong>{{ session('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    @endif
    @if( session('error') )
    <div class="col-sm-4 col-md-4 ">
        <div class="alert alert-danger alert-dismissible fade show "  role="alert">
            @if( strcmp(session('error'), 'Debe ingresar la identificacion' )===0 )
            <svg class="c-icon c-icon-2xl my-1">
                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
            </svg>
            @else
            <svg class="c-icon c-icon-2xl my-1">
                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-filter-x')}}"></use>
            </svg>
            @endif
            <strong>{{ session('error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    @endif
    <!-- /.col-->
    <div>
        <img class="card-img-top mb-2 mr-4" src="{{ asset('storage').'/'.$campana->logotipo }}"  style="width: 18rem;" alt="">
    </div>

</div>

<div class="justify-content-center">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                    <div class="col">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            @if ( empty($fromCliente) && !session('fromDetalle') )
                            <li class="nav-item"><a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">{{'Información Cliente'}}</a></li>
                            @else
                            <li class="nav-item"><a class="{{ session('fromCliente') ? 'nav-link active' : 'nav-link' }}" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="{{ session('fromCliente') ? 'true' : 'false' }}">{{'Información Cliente'}}</a></li>
                            @endif
                            <li class="nav-item"><a class="{{ session('fromDetalle') ? 'nav-link active' : 'nav-link' }}" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="{{ session('fromDetalle') ? 'true' : 'false' }}">{{'Detalles de Campaña'}}</a></li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            @if ( empty($fromCliente) && !session('fromDetalle') )
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                @include('cliente.inforCliente', [ 'cliente' => isset( $clienteGestionActual ) ? $clienteGestionActual : '' , 'productos' => isset($productos) ? $productos : ''])
                            </div>
                            @else
                            <div class="{{ session('fromCliente') ? 'tab-pane fade show active' : 'tab-pane fade' }}" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                @include('cliente.inforCliente', [ 'cliente' => isset( $clienteGestionActual ) ? $clienteGestionActual : '' , 'productos' => isset($productos) ? $productos : ''])
                            </div>
                            @endif
                            <!--Detalle Asistencia -->
                            <div class="{{ session('fromDetalle') ? 'tab-pane fade show active' : 'tab-pane fade' }}" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                @include('cliente.detalleAsistencia', [ 'cliente' => isset( $clienteGestionActual ) ? $clienteGestionActual : ''  ])
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<table class="table table-responsive-sm table-hover table-outline mb-0" id="tablaDetalleAsistencia">
<thead class="thead-light">
    <tr>
        <th><strong>{{'#'}}</strong></th>
        <th class="text-center"></th>
        <th class="text-center">{{'Fecha Mod.'}}</th>
        <th class="col-sm-1 col-md-1">{{'Identificación'}}</th>
        <th class="col-sm-2 col-md-2">{{'Cliente'}}</th>
        <th class="col-sm-1 col-md-1">{{'Gestión registro'}}</th>
        <th></th>
        <th class="text-left col-sm-2 col-md-2">{{'Producto'}}</th>
        <th class="text-left col-sm-2 col-md-2">{{'Subproducto'}}</th>
        <th class="text-center">{{'Fecha de la Gestión'}}</th>
        <th class="text-center">{{'Estado Cliente'}}</th>
        <th class="col-sm-2 col-md-2" >{{'Usuario modificador'}}</th>
        <th class="col-sm-3 col-md-3" >{{'Observaciones'}}</th>
    </tr>
</thead>

@if ( isset($dataCliente) )
<tbody>
    @foreach ( $dataCliente as $cliente)
       @php $cont++; @endphp
    <tr>
            <td><strong>{{ $cont }}</strong></td>
            <td>
                @if( $cont == 1 )
                    @if( strcmp($cliente->codestado, 'C') == 0 )
                    <strong class="text-danger">
                        <svg class="c-icon c-icon-2xl">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}} "></use>
                        </svg>
                    </strong>
                    @elseif ( strcmp($cliente->codestado, 'A') == 0 )
                    <strong class="text-success">
                        <svg class="c-icon c-icon-2xl">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}} "></use>
                        </svg>
                    </strong>
                    @endif
                @endif
            </td>
            <td class="text-center">
                <div>
                    <svg class="c-icon c-icon-1xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}} "></use>
                    </svg>
                </div>
                <div>
                {{ isset($cliente->fecmod) ? $cliente->fecmod : $cliente->fecha_reg  }}
                </div>
                <div>{{ $cliente->hormod}}</div>
            </td>
            <td>
                <div>
                    <svg class="c-icon c-icon-1xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-address-book')}} "></use>
                    </svg>{{ $cliente->cedula_id }}
                </div>
            </td>
            <td>
                <div>
                    <svg class="c-icon c-icon-1xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-opsgenie')}} "></use>
                    </svg>{{ substr($cliente->nombre, 0,20) }}
                </div>
            </td>
            <td>
                @if ( strcmp($cliente->estado, 'Z') ===0  )
                <strong>{{ 'Gestionado' }}</strong>
                @else
                <strong>{{ 'Disponible para gestión' }}</strong>
                @endif
            </td>
            <td>
                <form id="form-busquedaResgistro" action="{{route('EaBaseActivaController.buscarSeleccion')}}" method="post">
                    @csrf
                    <!--<input type="hidden" name="proceso" value="{{'buscarSeleccion'}}">-->
                    <input type="hidden" name="id_sec" value="{{ isset($cliente->id_sec) ? $cliente->id_sec : '' }}">
                    <input type="hidden" name="cliente" value="{{ isset($cliente->cliente) ? $cliente->cliente : '' }}">
                    <input type="hidden" name="cedula_id" value="{{ isset($cliente->cedula_id) ? $cliente->cedula_id : '' }}">
                    <button class="btn btn-success" title="Ir a la gestión del registro" type="submit" >
                        <svg class="c-icon c-icon-1xl">
                            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-share')}} "></use>
                        </svg>
                    </button>
                </form>
            </td>
            <td  class="text-left">
                <div  class="small text-muted">
                    <strong>{{ $cliente->desc_producto }}</strong>
                </div>
            </td>
            <td  class="text-left">
                <div  class="small text-muted">
                <strong>{{ $cliente->subproducto }}</strong>
                </div>
            </td>
            <td class="text-center">
                <div>
                    <svg class="c-icon c-icon-1xl">
                        <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calendar')}} "></use>
                    </svg>
                </div>
                {{ $cliente->fecha.' '. $cliente->hora }}
            </td>
            <td class="text-center">
                <strong>{{ $cliente->detestado}}</strong>
            </td>
            <td>
                {{ substr($cliente->usmod,0,22) }}
            </td>
            <td class="row text-left">
                <svg class="c-icon c-icon-1xl mr-1">
                    <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-twitch')}} "></use>
                </svg>
                <div class="small text-muted"><strong>{{ substr($cliente->observaciones, 0, 80) }}</strong></div>
            </td>
    </tr>
    @endforeach
</tbody>
@endif

</table>
@endsection
