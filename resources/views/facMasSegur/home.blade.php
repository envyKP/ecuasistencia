@extends('layouts.admin')
@section('scripts')

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){

    $("#cliente").change(function(){

        $.ajax({
            url: "{{route('EaFactMasSeguviajeController.getSubproductoSap')}}?cliente="+$(this).val(),
            method:"get",
            success: function(data){
               $("#subproducto").html(data.htmlSubproducto);
            }
        });

    });

    /*$("#producto").change(function(){

        $.ajax({
            url: "{{route('EaSubproductoController.getSubproducto')}}?cliente="+$("#cliente").val()+"&contrato_ama="+$(this).val(),
            method: "get",
            success: function(data){
                $("#subproducto").html(data.htmlSubproducto)
            }
        });
    });*/


    $("#form-procesarCarga").submit(function(){
        $.ajax({
            beforeSend: function(){
                $("#tabla-det-caraga-corp").find('div,button').prop("disabled", true);
                $(".modal").remove();
                $("#processCarga").css('display', 'block');
            },
        });
    });


    $("#form-EnviarBaseActiva").submit(function(){
        $.ajax({
            beforeSend: function(){
                $("#processCargarBaseActiva").css("display", "block");
            }
        });
    });



    $("#filtro_cliente").click(function(){
        if ( $("#filtro_cliente").is(":checked") ){
            $("#cliente").css('display', 'block');

        } else {
            $("#cliente").css('display', 'none');
            $("#producto").css('display', 'none');
            $("#subproducto").css('display', 'none');
            $(this).prop("checked", false)
            $("#filtro_producto").prop("checked", false);
            $("#filtro_subproducto").prop("checked", false);
        }
    });


    $("#filtro_nombreLote").click(function(){

        if( $("#filtro_nombreLote").is(":checked")) {
            $("#txt_nombreLote").css("display", "block");
        }else{
            $("#txt_nombreLote").css("display", "none");
            $("#filtro_nombreLote").prop("checked", false);
        }

    });


    $("#filtro_subproducto").click(function(){

        if ($("#filtro_subproducto").is(":checked") ){
            $("#subproducto").css("display", "block");
        }else{
            $("#subproducto").css("display", "none");
            $(this).prop("checked", false);
        }
    });


    $("#filtro_estab").click(function(){

        if ($("#filtro_estab").is(":checked") ){
            $("#establecimiento").css("display", "block");
        }else{
            $("#establecimiento").css("display", "none");
            $(this).prop("checked", false);
        }
    });



});
</script>
@endsection


@section('content')
    @include('facMasSegur.cabecera')
    @include('facMasSegur.detalle')
@endsection
