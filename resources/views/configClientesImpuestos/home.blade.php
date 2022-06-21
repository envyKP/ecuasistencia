@extends('layouts.admin')

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){


    $("#clienteCMB").change(function(){

        $("#clienteImpForm").val(null);
        $("#id_impuesto").val(null);
        $("#nom_impuestoForm").val(null);
        $("#desc_impuestoForm").val(null);
        $("#valor_porcentajeForm").val(null);

        if ( $(this).val()!=='' ){
            $("#logocab").css('visibility', 'visible');
            $("#clienteLogo").css('visibility', 'visible');
            $("#flechas").css('visibility', 'visible');
            $("#btn-eliminaCliente").css('visibility', 'visible');
            $("#btn-EditCliente").css('visibility', 'visible');
            $("#btn-crearImpuesto").css('visibility', 'visible');

        }


        $.ajax({
            url: "{{ route('EaClienteController.getClienteModel') }}?cliente="+$(this).val(),
            method: 'get',
            success: function(data){
                JSON.stringify(data.clienteModel, function(key, value){
                    //infor cliente
                    $("#id_cliente").val(value[0].id_cliente);
                    $("#clienteForm").val(value[0].cliente);
                    $("#desc_clienteForm").val(value[0].desc_cliente);

                    //edit cliente
                    $("#id_clienteEdit").val(value[0].id_cliente);
                    $("#clienteEdit").val(value[0].cliente);
                    $("#desc_clienteEdit").val(value[0].desc_cliente);

                    $("#clienteEditOld").val(value[0].cliente); //flashed session data
                    $("#desc_clienteEditOld").val(value[0].desc_cliente); //flashed session data
                    $("#clienteLogo").attr("src", "{{ asset('storage') }}/"+value[0].logotipo );

                    //input blade - crear impuesto
                    $("#clienteAdd").val(value[0].cliente);
                     //input blade - edit impuesto
                    $("#clienteEditImp").val(value[0].cliente);

                });
            }
        });

        $.ajax({
            url:"{{ route('EaImpuestosController.getImpuestoHtml') }}?cliente="+$("#clienteCMB").val(),
            method:"get",
            success: function(data){
                $("#impuestosCMB").html(data.impuestoHtml);
            }
        });

    });



    $("#impuestosCMB").change(function(){

        if ( $(this).val()!=='' ){

            $("#btn-EliminaImpuestoInfor").css('visibility', 'visible');
            $("#btn-editImpuesto").css('visibility', 'visible');
        }


        $.ajax({
            url:"{{ route('EaImpuestosController.getImpuestoModel') }}?cliente="+$("#clienteCMB").val()+"&nom_impuesto="+$(this).val(),
            method:"get",
            success: function(data){
                JSON.stringify(data.impuestoModel, function(key, value){
                    //infor impuesto
                    $("#clienteImpForm").val(value[0].cliente);
                    $("#id_impuesto").val(value[0].id_impuesto);
                    $("#nom_impuestoForm").val(value[0].nom_impuesto);
                    $("#desc_impuestoForm").val(value[0].desc_impuesto);
                    $("#valor_porcentajeForm").val(value[0].valor_porcentaje);

                    //inputs :: Edit impuestos blade
                    $("#nom_impuestoEdit").val(value[0].nom_impuesto);
                    $("#desc_impuestoEdit").val(value[0].desc_impuesto);
                    $("#valor_porcentajeEdit").val(value[0].valor_porcentaje);

                    $("#id_impuestoEdit").val(value[0].id_impuesto);
                    $("#nom_impuestoEditOld").val(value[0].nom_impuesto);
                    $("#desc_impuestoEditOld").val(value[0].desc_impuesto);
                    $("#valor_porcentajeEditOld").val(value[0].valor_porcentaje);



                });
            }
        });

    });




    $("#btn-eliminaCliente").click(function(){
        $("#form-eliminaCliente").submit();
    });


    $("#btn-eliminaImpuesto").click(function(){
        $("#form-eliminaImpuesto").submit();
    });


});

</script>
@endsection


@section('content')

<div class="alert alert-info" role="alert">
    <div class="row justify-content-between">
        <div>
            @if( strcmp( session('trxcliente'), 'store' )===0 )
            <div class="col-sm-12 col-md-12 my-3">
                <div class="alert alert-success alert-dismissible fade show "  role="alert">
                    <svg class="c-icon c-icon-2xl">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-thick-to-bottom')}}"></use>
                    </svg>
                        <strong>{{'Cliente Agregado!'}}</strong>
                    <div>
                        <strong>{{'Nuevo cliente: '}}</strong> {{ session('cliente') }}
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @elseif ( strcmp( session('trxcliente'), 'update' )===0 )
            <div class="col-sm-12 col-md-12 my-3">
                <div class="alert alert-info  alert-dismissible fade show "  role="alert">
                    <svg class="c-icon c-icon-2xl ">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                    </svg>
                    <strong>{{'Cliente Actualizado!'}}</strong>
                    <div>
                        <strong>{{'Cliente: '}}</strong>{{ session('clienteEdit') }}
                    </div>
                    <div>
                        <strong>{{'Nomnre del Cliente : '}}</strong>{{ session('clienteEditOld') }}   <strong>{{' - Actualizado a: '}}</strong>{{ session('clienteEdit') }}
                    </div>
                    <div>
                        <strong>{{'Descripción del cliente de: '}}</strong>{{ session('desc_clienteEditOld') }}   <strong>{{' - Actualizado a: '}} </strong>{{ session('desc_clienteEdit') }}
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @elseif (strcmp( session('trxcliente'), 'delete' )===0 )
            <div class="col-sm-12 col-md-12 my-3">
                <div class="alert alert-danger alert-dismissible fade show "  role="alert">
                    <svg class="c-icon c-icon-2xl">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                    </svg>
                    <strong>{{'Cliente Eliminado!'}}</strong>
                    <div>
                        <strong>{{'Cliente: '}}</strong> {{ session ('cliente') }}
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif

            @if(strcmp( session('trximpuesto'), 'store' )===0)
            <div class="col-sm-12 col-md-12 my-3">
                <div class="alert alert-success alert-dismissible fade show "  role="alert">
                    <svg class="c-icon c-icon-2xl">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-thick-to-bottom')}}"></use>
                    </svg>
                        <strong>{{'Nuevo impuesto Agregado!'}}</strong>
                    <div>
                        <strong>{{'Impuesto: '}}</strong> {{ session('impuesto') }}
                    </div>
                    <div>
                        <strong>{{'Cliente: '}}</strong> {{ session('cliente') }}
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @elseif( strcmp( session('trximpuesto'), 'delete' )===0 )
            <div class="col-sm-12 col-md-12 my-3">
            <div class="alert alert-danger alert-dismissible fade show "  role="alert">
                <svg class="c-icon c-icon-2xl">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                </svg>
                <strong>{{'Impuesto Eliminado!'}}</strong>
                <div>
                    <strong>{{'Impuesto: '}}</strong> {{ session ('impuesto') }}
                </div>
                <div>
                    <strong>{{'Cliente: '}}</strong> {{ session ('cliente') }}
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            </div>
            @elseif( strcmp( session('trximpuesto'), 'update' )===0 )
            <div class="col-sm-12 col-md-12 my-3">
                <div class="alert alert-info  alert-dismissible fade show "  role="alert">
                    <svg class="c-icon c-icon-2xl ">
                        <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                    </svg>
                    <strong>{{'Impuesto Actualizado!'}}</strong>
                    <div>
                        <strong>{{'Cliente: '}}</strong>{{ session('cliente') }}
                    </div>
                    <div>
                        <strong>{{'Valor ó porcentaje: '}}</strong>{{ session('valorOld') }}   <strong>{{' - Actualizado a: '}}</strong>{{ session('valor') }}
                    </div>
                    <div>
                        <strong>{{'Impuesto: '}}</strong>{{ session('impuestoOld') }}   <strong>{{' - Actualizado a: '}}</strong>{{ session('impuesto') }}
                    </div>
                    <div>
                        <strong>{{'Descripción del impuesto de: '}}</strong>{{ session('desc_impuestoOld') }}   <strong>{{' - Actualizado a: '}} </strong>{{ session('desc_impuesto') }}
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif
        </div>
        <div>
            <h4>
                <svg class="c-icon c-icon-3xl mx-2">
                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-bank')}}"></use>
                </svg>{{'Configuración de Clientes e Impuestos'}}
            </h4>
        </div>
    </div>
</div>


<div class="row justify-content-between">

    <div class="col-sm-4">
        @include('configClientesImpuestos.clientes' )
    </div>

    <div class="col-sm-4">
        @include('configClientesImpuestos.logo')
    </div>

    <div class="col-sm-4">
         @include('configClientesImpuestos.impuestos')
    </div>

</div>


@endsection
