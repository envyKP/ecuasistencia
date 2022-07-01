@extends('layouts.admin')
@section('scripts')

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $("#cliente").change(function() {

                $.ajax({
                    url: "{{ route('EaSubproductoController.getSubproductoNoAMA') }}?cliente=" + $(
                        this).val(),
                    method: "get",
                    success: function(data) {
                        $("#producto").html(data.htmlProducto);
                    }
                });

            });

            $("#producto").change(function() {

                $.ajax({
                    url: "{{ route('EaSubproductoController.getSubproducto') }}?cliente=" + $(
                        "#cliente").val() + "&contrato_ama=" + $(this).val(),
                    method: "get",
                    success: function(data) {
                        $("#subproducto").html(data.htmlSubproducto)
                    }
                });
            });


            $("#form-procesarCarga").submit(function() {
                $.ajax({
                    beforeSend: function() {
                        $("#tabla-det-caraga-corp").find('div,button').prop("disabled", true);
                        $(".modal").remove();
                        $("#processCarga").css('display', 'block');
                    },
                });
            });


            $("#form-EnviarBaseActiva").submit(function() {
                $.ajax({
                    beforeSend: function() {
                        $("#processCargarBaseActiva").css("display", "block");
                    }
                });
            });



            $("#filtro1").click(function() {

                if ($("#filtro1").is(":checked")) {
                    $("#cedula_id").css('visibility', 'visible');
                    $("#btn-buscar").css('visibility', 'visible');
                } else {
                    $("#cedula_id").css('visibility', 'hidden');
                    $("#btn-buscar").css('visibility', 'hidden');
                }
            });


        });
    </script>
@endsection


@section('content')
    @include('cargaIndividuali.cabecera')
    @include('cargaIndividuali.detalle')
@endsection
