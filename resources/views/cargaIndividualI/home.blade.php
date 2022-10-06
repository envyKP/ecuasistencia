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

        .custom-file-input~.custom-file-label::after {
            content: "Seleccione un archivo";
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {

            
            $("#cliente").change(function() {
                $.ajax({
                    url: "{{route('EaDetalleDebitoController.getMenuSubproductoOpciones')  }}?cliente=" +
                        $(this).val(),
                    method: "get",
                    success: function(data) {
                        $("#producto").html(data.htmlProducto);
                        //$("#opciones_data").html(data.htmlProducto);
                    }
                });
            });
            
           
            $("#producto").change(function() {
                $.ajax({
                    url: "{{ route('EaDetalleDebitoController.getDetalleDebitoOpciones') }}?producto=" +
                        $(this).val(),
                    method: "get",
                    success: function(data) {
                        $("#opciones_data").html(data.htmlProducto);
                    }
                });
            });
            
            $("#btn_genera").change(function() {
                $.ajax({
                    success: function(data) {
                        alert("okay");
                    }
                });
            });

    
            $("#filtro_cliente").click(function() {
                if ($("#filtro_cliente").is(":checked")) {
                    $("#cliente").css('display', 'block');
                    $("#btn_genera").prop("disabled", false);
                } else {
                    $("#cliente").css('display', 'none');
                    $("#producto").css('display', 'none');
                    $(this).prop("checked", false)
                    $("#filtro_producto").prop("checked", false);
                    $("#btn_genera").prop("disabled", true);
                    document.getElementById("processCargaDetalle").style.display = "none";

                }
            });

            $("#filtro_producto").click(function() {
                if ($("#filtro_producto").is(":checked")) {
                    $("#cliente").css('display', 'block');
                    $("#producto").css('display', 'block');
                    $("#filtro_cliente").prop("checked", true);
                    $("#btn_genera").prop("disabled", false);
                    $("#filtro_producto").prop("checked", true);
                } else {
                    $("#producto").css("display", "none");
                    $("#filtro_producto").prop("checked", false);
                    $("#btn_genera").prop("disabled", true);

                }
            });
            $("#filtro_opciones").click(function() {
                if ($("#filtro_opciones").is(":checked")) {
                    $("#filtro_cliente").prop("checked", true);
                    $("#filtro_producto").prop("checked", true);
                    $("#filtro_opciones").prop("checked", true);
                    $("#opciones_data").css("display", "block");
                } else {
                    $("#filtro_opciones").prop("checked", false);
                    $("#opciones_data").css("display", "none");
                }
            });

            $("#filtro_genera").click(function() {
                if ($("#filtro_genera").is(":checked")) {
                    if ($("#filtro_cliente").is(":checked")) {
                        if ($("#filtro_producto").is(":checked")) {
                            $("#btn_genera").css("display", "block");
                            $("#btn_genera").prop("disabled", false);
                        }
                    }

                } else {
                    $("#subproducto").css("display", "none");
                    $("#btn_genera").css("display", "none");
                    $("#btn_genera").prop("disabled", true);
                }
            });
            $("#filtro_estado").click(function() {
                if ($("#filtro_estado").is(":checked")) {
                    $("#state").css("display", "block");
                } else {
                    $("#state").css("display", "none");

                }
            });

            $("#bloqueo_subida").click(function() {
                if ($("#bloqueo_subida").is(":checked")) {

                } else {
                    $("#btn_genera").prop("disabled", true);
                }
            });


            $("#btn_genera").click(function() {
                document.getElementById("processCargaDetalle").style.display = "block";
                $(':button').prop('disabled', false);
            });


        });

        function updateList() {
            var input = document.getElementById('archivo');
            var output = document.getElementById('fileList');
            for (var i = 0; i < input.files.length; ++i) {
                output.innerHTML = input.files.item(i).name;
            }
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
                    var parsed_data = JSON.parse(JSON.stringify(response));
                    let msg_response = parsed_data.msg;
                    document.getElementById(procesbarId).style.display = "none";
                    alert(msg_response);
                    $('.progress .progress-bar').css("width", "0%");
                },
                error: function(response) {

                    document.getElementById(procesbarId).style.display = "none";
                    alert("Error " + response.error);
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
                document.getElementById("onloadForm").submit();
                //$("#testForm").submit();
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
