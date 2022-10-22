@extends('layouts.admin')
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $("#clienteCMB").change(function() {
                if ($("#clienteCMB").val() !== "clienteNull") {
                    $.ajax({
                        url: "{{ route('EaControlCampania.getOpcionesModelAllCliente') }}?cliente=" +
                            $(this).val(),
                        method: "GET",
                        success: function(data) {
                            $('#campaniasOpcionesID').html(data.htmlProducto);
                        }
                    });
                }
            });


            //cambiar a combobox que usa la opciones
            $("#campaniasOpcionesID").change(function() {
                $.ajax({
                    url: "{{ route('EaControlCampania.getOpcionesModel') }}?codigo_id=" +
                        $(this).val(),
                    method: "get",
                    success: function(data) {

                        JSON.stringify(data.opcionesModel, function(key, value) {
                            $select = document.querySelector('#IdentificadoEntrada');
                            $select.value = value.identificador;


                            if (typeof value.codigo_id !== 'undefined') {
                                $("#codigo_id_import").val(value.codigo_id);
                            }

                            if (typeof value.campoIdentificador !== 'undefined') {
                                $("#campoIdentificador").val(value.campoIdentificador);
                            }
                            if (typeof value.detalle !== 'undefined') {
                                $("#detalle").val(value.detalle);
                            }
                            if (typeof value.fecha_actualizacion !== 'undefined') {
                                $("#fechaDebitado").val(value.fecha_actualizacion);
                            }
                            if (typeof value.valor_debitado !== 'undefined') {
                                $("#valorDebitado").val(value.valor_debitado);
                            }
                            if (typeof value.validacion_archivo_campo_1 !==
                                'undefined') {
                                $("#campoValidacionArchivo").val(value
                                    .validacion_archivo_campo_1);
                            }
                            if (typeof value.validacion_archivo_valor_1 !==
                                'undefined') {
                                $("#valorValidacionArchivo").val(value
                                    .validacion_archivo_valor_1);
                            }
                            if (typeof value.valorValidacionDebitado !==
                                'undefined') {
                                $("#valorValidacionDebitado").val(value
                                    .valorValidacionDebitado);
                            }
                            if (typeof value.campoValidacionDebitado !==
                                'undefined') {
                                $("#campoValidacionDebitado").val(value
                                    .campoValidacionDebitado);
                            }
                            /* cliente,tipo_subproducto,subproducto,archivo_nombre,formato_fecha,op_caracteristica_ba*/
                            if (typeof value.cliente !==
                                'undefined') {
                                $("#clienteValue").val(value
                                    .cliente);
                            }
                            if (typeof value.tipo_subproducto !==
                                'undefined') {
                                $("#tipo_subproducto_value").val(value
                                    .tipo_subproducto);
                            }
                            if (typeof value.subproducto !==
                                'undefined') {
                                $("#subproductoValue").val(value
                                    .subproducto);
                            }
                            if (typeof value.archivo_nombre !==
                                'undefined') {
                                $("#archivo_nombre_value").val(value
                                    .archivo_nombre);
                            }
                            if (typeof value.formato_fecha !==
                                'undefined') {
                                $("#formato_fecha_value").val(value
                                    .formato_fecha);
                            }
                            if (typeof value.op_caracteristica_ba !==
                                'undefined') {
                                $("#op_caracteristica_ba_value").val(value
                                    .op_caracteristica_ba);
                            }

                        });
                    }
                }); //fin ajax

                $("#filtroeditarEntradaDetalles").click(function() {
                    if ($("#filtroeditarEntradaDetalles").is(":checked")) {

                        $("#IdentificadoEntrada").prop("disabled", false);
                        $("#campoIdentificador").prop('readonly', false);
                        $("#detalle").prop('readonly', false);
                        $("#fechaDebitado").prop('readonly', false);
                        $("#valorDebitado").prop('readonly', false);
                        $("#formatoFecha").prop('readonly', false);
                    } else {
                        $("#IdentificadoEntrada").prop("disabled", "disabled");
                        $("#campoIdentificador").prop('readonly', true);
                        $("#detalle").prop('readonly', true);
                        $("#fechaDebitado").prop('readonly', true);
                        $("#valorDebitado").prop('readonly', true);
                        $("#formatoFecha").prop('readonly', true);
                    }
                });

                $("#filtroeditarEntradaDetallesDebitado").click(function() {
                    if ($("#filtroeditarEntradaDetallesDebitado").is(":checked")) {
                        $("#campoValidacionDebitado").prop('readonly', false);
                        $("#valorValidacionDebitado").prop('readonly', false);

                    } else {
                        $("#valorValidacionDebitado").prop('readonly', true);
                        $("#campoValidacionDebitado").prop('readonly', true);

                    }
                });

                $("#filtroeditarEntradaValidaA").click(function() {
                    if ($("#filtroeditarEntradaValidaA").is(":checked")) {
                        $("#valorValidacionArchivo").prop('readonly', false);
                        $("#campoValidacionArchivo").prop('readonly', false);

                    } else {
                        $("#valorValidacionArchivo").prop('readonly', true);
                        $("#campoValidacionArchivo").prop('readonly', true);

                    }
                });

            });



            $("#btn-guardar-import_cab").click(function(e) {

                e.preventDefault();

                $.ajax({

                    url: $("#form-genera-imort").prop("action"),
                    method: "post",
                    data: $("#form-genera-imort").serialize(),

                    beforeSend: function() {

                        $("#btn-guardar-import_cab").prop('disabled', true);
                        $("#processCargaDetalle").css('display', 'block');
                    },

                    success: function(data) {
                       //$("#modalGuardar").modal('show');
                    },

                }).done(function(response) {

                    $("#modalGuardar").modal('show');
                    $("#btn-guardar-import_cab").prop('disabled', false);
                    $("#processCargaDetalle").css('display', 'none');
                    location.reload();

                }).error(function(err) {
                    alert(err);
                });

            });


            
            $("#btn-guardar-validacion").click(function(e) {

                e.preventDefault();

                $.ajax({

                    url: $("#form-Validacion").prop("action"),
                    method: "post",
                    data: $("#form-Validacion").serialize(),

                    beforeSend: function() {

                        $("#btn-guardar-validacion").prop('disabled', true);
                        $("#processValidacion").css('display', 'block');
                    },

                    success: function(data) {
                    //$("#modalGuardar").modal('show');
                    },

                }).done(function(response) {

                    $("#modalGuardar").modal('show');
                    $("#btn-guardar-validacion").prop('disabled', false);
                    $("#processValidacion").css('display', 'none');
                    location.reload();

                }).error(function(err) {
                    alert(err);
                });

            });


            $("#btn-guardar-datos-import").click(function(e) {

                e.preventDefault();

                $.ajax({

                    url: $("#frm-import-guadar-datos").prop("action"),
                    method: "post",
                    data: $("#frm-import-guadar-datos").serialize(),

                    beforeSend: function() {

                        $("#btn-guardar-datos-import").prop('disabled', true);
                        $("#processDatosImport").css('display', 'block');
                    },

                    success: function(data) {
                    //$("#modalGuardar").modal('show');
                    },

                }).done(function(response) {

                    $("#modalGuardar").modal('show');
                    $("#btn-guardar-datos-import").prop('disabled', false);
                    $("#processDatosImport").css('display', 'none');
                    location.reload();

                }).error(function(err) {
                    alert(err);
                });

            });


           /*===========================================================================*/
            $("#btnElimprod").click(function(e){
                
                $("#campoIdentificador").val(null);
                $("#IdentificadoEntrada").val("selec");
                $("#fechaDebitado").val(null);
                $("#detalle").val(null);
                $("#formatoFecha").val(null);
                $("#valorDebitado").val(null);
                $("#checkbox").val(null); 

            });

            $("#vaciar_validacion").click(function(e){
                
                $("#campoValidacionDebitado").val(null);
                $("#valorValidacionDebitado").val(null);
             
            });

            $("#btn-vaciar-datos-import").click(function(e){
                                
                $("#campoValidacionArchivo").val(null);
                $("#valorValidacionArchivo").val(null);
            });



        });
    </script>
    <style>
        /* Popup container - can be anything you want */
        .popup {
            position: relative;
            display: inline-block;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* The actual popup */
        .popup .popuptext {
            visibility: hidden;
            width: 347px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -80px;
        }

        /* Popup arrow */
        .popup .popuptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        /* Toggle this class - hide and show the popup */
        .popup .show {
            visibility: visible;
            -webkit-animation: fadeIn 1s;
            animation: fadeIn 1s;
        }

        /* Add animation (fade in the popup) */
        @-webkit-keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
@endsection


@section('content')
    <div class="row">
        @include('configCampanias.campanias')
        @include('configCampanias.archivoSalida')
        @include('configCampanias.archivoEntrada')
    </div>
@endsection
