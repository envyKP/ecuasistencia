@extends('layouts.admin')
@section('scripts')

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){

    $("#cliente").change(function(){

        $.ajax({
            url: "{{route('EaProductoController.getProducto')}}?cliente="+$(this).val(),
            method:"get",
            success: function(data){
               $("#producto").html(data.htmlProducto);
            }
        });

    });

    $("#cliente").change(function(){

        $.ajax({
            url: "{{route('EaCabCargaInicialController.get_procesos_carga_html')}}?cliente="+$(this).val()+'&filtro_proce_carga='+$("#filtro_proce_carga").val(),
            method: "get",
            success: function(data){
                $("#cod_carga").html(data.procesos_carga_html)
            }
        });
    });


    $("#form-procesarCarga").submit(function(){

        $.ajax({
            beforeSend: function(){
                $("#tabla-recep-provee").find('div,button').prop("disabled", true);
                $(".modal").remove();
                $("#processCarga").css('display', 'block');
            },
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


    $("#filtro_producto").click(function(){

        if( $("#filtro_producto").is(":checked")) {
            $("#producto").css("display", "block");
        }else{
            $("#producto").css("display", "none");
            $("#subproducto").css("display", "none");
            $("#filtro_producto").prop("checked", false);
        }

    });


    $("#filtro_subproducto").click(function(){

        if ( $(this).is(":checked") ){
            $("#subproducto").css("display", "block");
        }else{
            $("#subproducto").css("display", "none");
            $(this).prop("checked", false);
        }
    });

    $("#filtro_proce_carga").click(function(){

        if ( $(this).is(":checked") ) {
            $("#cod_carga").css("display", "block");
        }else{
            $("#cod_carga").css("display", "none");
            $(this).prop("checked", false);
        }

    });



});
</script>
@endsection


@section('content')
    @include('recapt.cabecera')
    @include('recapt.detalle')
@endsection
