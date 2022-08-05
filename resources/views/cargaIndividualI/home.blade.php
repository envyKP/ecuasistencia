@extends('layouts.admin')


@section('scripts')
    <!-- notas es cargaIndividualI   el final es una i mayuscula-->
    <style>
        div.fileinputs {
            position: relative;
        }

        div.fakefile {
            position: absolute;
            top: 0px;
            left: 0px;
            z-index: 1;
        }

        input.file {
            position: relative;
            text-align: left;
            -moz-opacity: 0;
            filter: alpha(opacity: 0);
            opacity: 0;
            z-index: 2;
        }
    </style>
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


            $("#btn-genera").click(function() {
                document.getElementById("processCargaDetalle").style.display = "block";

            });


        });
        /*
        function upload_function(cod_carga, cliente, producto, desc_producto, estado_cabecera,registros_no_cumplen,username) {
            
        
        */
        function evgenera() {
            document.getElementById("processCargaDetalle").style.display = "block";
        }

        function procesar_function(cod_carga, cliente, producto, desc_producto, estado_cabecera, idbar) {
            //document.getElementById("demo").innerHTML = "Frame Pruebas function , intentemos ajax .";
            //var form = $("#form-uploadArchivos");
            //var url = form.attr('action');
            let url = '<?php echo url('/recepcion/archivo/cargaIndividual/procesar/'); ?>';
            // $("div").text(form.serialize());
            let form = JSON.stringify({
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'cod_carga': cod_carga,
                'cliente': cliente,
                'producto': producto,
                'desc_producto': desc_producto,
                'estado_cabecera': estado_cabecera
            });
            var procesbarId = "processCargaDetalle" + idbar;
            //document.getElementById("processCargaDetalle").style.display = "block";
            document.getElementById(procesbarId).style.display = "block";
            $.ajax({
                type: "POST",
                url: url,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: form,
                success: function(response) {
                    document.getElementById(procesbarId).style.display = "none";
                    alert('Procesado exitoso ');

                },
                error: function(response) {
                    alert("some Error " + data.msg);
                    document.getElementById(procesbarId).style.display = "none";
                }
            });

        }

        function upload_function(form, idbar) {
            let url = '<?php echo url('recepcion/archivo/cargaIndividual/subirArchivo'); ?>';
            let formulario = new FormData($(form)[0]);
            //let idbar = 1;
            var procesbarId = "processCargaDetalle" + idbar;
            //document.getElementById("processCargaDetalle1").style.display = "block";
            document.getElementById(procesbarId).style.display = "block";
            //var refButton = document.getElementById("processCargaDetalle");
            //refButton.style.display = "none";

            $.ajax({
                type: "POST",
                url: url,
                data: formulario,
                async: false,
                processData: false,
                contentType: false,
                dataType: "json",

                success: function(response) {

                    var parsed_data = JSON.parse(JSON.stringify(response));
                    let msg_response = parsed_data.mensaje;
                    document.getElementById(procesbarId).style.display = "none";
                    alert(msg_response);
                    var percentVal = 'Wait, Saving';
                    $('.progress .progress-bar').css("width", "0%");

                },
                error: function(response) {
                    document.getElementById(procesbarId).style.display = "none";
                    alert("Error " + response.error);
                }
            });

        }


        window.onload = function() {
            var generacionVal = "{{ session('generacionVal') }}";
            if (generacionVal == '200') {
              
            }

        }




        function validate(formData, jqForm, options) {
            var form = jqForm[0];
        }
    </script>
@endsection


@section('content')
    @include('cargaIndividuali.cabecera')
    @include('cargaIndividuali.detalle')
@endsection
