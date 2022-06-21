@extends('layouts.admin')

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){

    var now = new Date();
    var dateString = moment(now).format('YYYY-MM-DD');

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
            url: "{{route('EaCabCargaInicialController.get_archivos_html_genapt')}}?cliente="+$(this).val(),
            method: "get",
            success: function(data){
                $("#archivos").html(data.archivo_html);
            }
        });
    });



    $("#form-GenArchivoProvee").submit( function(e){

        e.preventDefault(e);

        $.ajax({

            url: $(this).prop("action"),
            method: "get",
            data: $(this).serialize(),
            xhrFields:{
                responseType: 'blob'
            },

            beforeSend: function(){
                $("#btn-generar_archivo").prop("disabled", true );
                $("#processGenArchiProvee").css('display', 'block');
                $(".modal").remove();
                $("#tabla-det-genapt").find('div,button').prop("disabled", true);
            },

            success: function(data){

                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(data);
                link.download = 'ENVIO_A_PROVEEDOR_'+ $("#cliente").val()+'_'+dateString+'.xlsx';
                link.click();
            },

        }).done(function(response){
            $("#processGenArchiProvee").css('display', 'none');
            $("#btn-generar_archivo").prop( "disabled", false );
            location.reload();
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

        if ($("#filtro_subproducto").is(":checked") ){
            $("#subproducto").css("display", "block");
        }else{
            $("#subproducto").css("display", "none");
            $(this).prop("checked", false);
        }
    });


    $("#filtro_archivo").click(function(){

        if ( $(this).is(":checked") ) {
            $("#archivos").css("display", "block");
        }else {
            $("#archivos").css("display", "none");
            $("#archivos").val(null);
        }
    });


});
</script>
@endsection

@section('content')
    @include('genapt.cabecera')
    @include('genapt.detalleCargaInicial')
@endsection
