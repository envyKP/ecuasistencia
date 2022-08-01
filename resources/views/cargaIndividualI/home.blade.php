@extends('layouts.admin')
@section('scripts')

@section('scripts')
    <!-- notas es cargaIndividualI   el final es una i mayuscula-->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#cliente").change(function() {
                $.ajax({
                    url: "{{ route('EaSubproductoController.getSubproductoNoAMA') }}?cliente=" +
                        $(this).val(),
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
            /*
                        $("#form-procesarCarga").submit(function() {
                            $.ajax({
                                beforeSend: function() {
                                    $("#tabla-det-caraga-corp").find('div,button').prop("disabled", true);
                                    $(".modal").remove();
                                    $("#processCarga").css('display', 'block');
                                    var porcentaje = '0';
                                },
                                uploadProgress: function(event,position,total,porcentajecompleto){
                                    var porcentaje = porcentajecompleto;
                                    $('.progress .progress-bar').css("width", porcentaje + '%',function(){return $(this).atrr("aria-valuenow",porcentaje)+ "%";
                                })
                                },
                                complete: function(xhr){
                                    $("#tabla-det-caraga-processCarga").find('div,button').prop("disabled", false);
                                    $("#processCarga").css('hidden', 'block');
                                }
                            });
                        });*/
            $("#btn-genera").change(function() {
                $.ajax({
                    success: function(data) {
                        alert("okay");
                    }
                });
            });
            $("#form-EnviarBaseActiva").submit(function() {
                $.ajax({
                    beforeSend: function() {
                        $("#processCargarBaseActiva").css("display", "block");
                    }
                });
            });
            $("#filtro_cliente").click(function() {
                if ($("#filtro_cliente").is(":checked")) {
                    $("#cliente").css('display', 'block');
                    $("#btn-genera").prop("disabled", false);
                } else {
                    $("#cliente").css('display', 'none');
                    $("#producto").css('display', 'none');
                    $(this).prop("checked", false)
                    $("#filtro_producto").prop("checked", false);
                    $("#btn-genera").prop("disabled", true);
                }
                $("#form-uploadArchivos").submit(function() {
                    $.ajax({
                        alert("okay submit");
                    });
                });
            });
            $("#form-uploadArchivos").click(function() {
                $.ajax({
                    alert("okay click");
                });
            });



            $("#filtro_producto").click(function() {
                if ($("#filtro_producto").is(":checked")) {
                    $("#producto").css("display", "block");
                    $("#btn-genera").prop("disabled", false);
                } else {
                    $("#producto").css("display", "none");
                    $("#filtro_producto").prop("checked", false);
                    $("#btn-genera").prop("disabled", true);

                }
            });



            $("#filtro_genera").click(function() {
                if ($("#filtro_genera").is(":checked")) {
                    $("#btn-genera").css("display", "block");
                    $("#btn-genera").prop("disabled", false);
                } else {
                    $("#subproducto").css("display", "none");
                    $("#btn-genera").css("display", "none");
                    $("#btn-genera").prop("disabled", true);
                }
            });
            $("#bloqueo_subida").click(function() {
                if ($("#bloqueo_subida").is(":checked")) {

                } else {
                    $("#btn-genera").prop("disabled", true);
                }
            });







        });
    </script>
@endsection


@section('content')
    @include('cargaIndividuali.cabecera')
    @include('cargaIndividuali.detalle')
@endsection
