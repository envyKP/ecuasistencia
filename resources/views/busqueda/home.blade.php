@extends('layouts.admin')

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){

    $("#cliente").change(function(){


        $.ajax({
            url:"{{route('EaProductoController.getProducto')}}?cliente="+$(this).val(),
            method:'get',
            success: function(data){
                $("#productoCMB").html(data.htmlProducto);
            }
        });
    });


    $("#productoCMB").change(function(){

        $.ajax({
            url:"{{route('EaSubproductoController.getSubproducto')}}?cliente="+$("#cliente").val()+"&contrato_ama="+$(this).val(),
            method:'get',
            success: function(data){
                $("#subproductoCMB").html(data.htmlSubproducto);
            }
        });

    });

    $("#filtro2").click(function(){

        if ( $("#filtro2").is(":checked") ){
            $("#cliente").css('visibility', 'visible');
            $("#btn-buscar").css('visibility', 'visible');

        }else{
            $("#filtro3").prop("checked", false);
            $("#filtro4").prop("checked",false);
            $("#cliente").css('visibility', 'hidden');
            $("#productoCMB").css('visibility', 'hidden');
            $("#subproductoCMB").css('visibility', 'hidden');
            $("#btn-buscar").css('visibility', 'hidden');
        }
    });

    $("#filtro3").click(function(){

        if ( $("#filtro3").is(":checked") ){
            $("#productoCMB").css('visibility', 'visible');
            $("#btn-buscar").css('visibility', 'visible');

        }else {
            $("#productoCMB").css('visibility', 'hidden');
            $("#subproductoCMB").css('visibility', 'hidden');
            $("#btn-buscar").css('visibility', 'hidden');
        }
    });

    $("#filtro4").click(function(){

        if ( $("#filtro4").is(":checked") ){
            $("#subproductoCMB").css('visibility', 'visible');
            $("#btn-buscar").css('visibility', 'visible');
        }else{
            $("#subproductoCMB").css('visibility', 'hidden');
            $("#btn-buscar").css('visibility', 'hidden');
        }
    });


    $("#filtro1").click(function(){

        if ( $("#filtro1").is(":checked") ){
            $("#cedula_id").css('visibility', 'visible');
            $("#btn-buscar").css('visibility', 'visible');
        }else{
            $("#cedula_id").css('visibility', 'hidden');
            $("#btn-buscar").css('visibility', 'hidden');
        }
    });


});
</script>
@endsection


@section('content')
<div class="justify-content-center">

    @include('busqueda.cabecera')

    @include('busqueda.detalle')

</div>
@endsection
