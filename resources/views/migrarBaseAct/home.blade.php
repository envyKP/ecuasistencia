@extends('layouts.admin')
@section('scripts')

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $("#archivo").change(function() {
            if ($("#archivo").val() !== "") {
                $("#btn-subirArchivo").css("visibility", "visible");
            }
        });

        $("#formProcesarArchivo").submit(function() {
            $.ajax({
                beforeSend: function() {
                    $("#tabla-detalleCarga").find("button,div").prop("disabled", true);
                    $('.modal').remove();
                    $('#processCarga').css('display', 'block');
                },
            });
        });

    });
</script>


@endsection


@section('content')
@include('migrarBaseAct.cabecera')
@include('migrarBaseAct.detalle')
@endsection