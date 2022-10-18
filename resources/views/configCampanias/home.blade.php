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
                        /*
                            campoIdentificador: "vale"
                            detalle: "descripcion"
                            fecha_actualizacion:"fecha_autorizacion"
                            identificador:"secuencia"
                            validacion_archivo_campo_1:"establecimiento"
                            validacion_archivo_valor_1:"872876"
                            valor_debitado:"total"
                        */
                        /*
                        fechaDebitado
                        FormatoFecha
                        valorDebitado
                        campoValidacionArchivo
                        valorValidacionArchivo
                        */
                        JSON.stringify(data.opcionesModel, function(key, value) {

                            $select = document.querySelector('#IdentificadoEntrada');
                            $select.value = value.identificador;


                            if (typeof value.campoIdentificador !== 'undefined') {
                                $("#campoIdentificador").val(value.campoIdentificador);
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
                            //falta detalle

                            /*if (typeof value.FormatoFecha !== 'undefined') {
                                $("#FormatoFecha").innerHTML = value.identificador;
                            }*/

                            /*$("#clienteFormSub").val(value[0].cliente);
                                    $("#contrato_amaSubForm").val(value[0].contrato_ama);
                                    $("#sub-subproductoForm").val(value[0].subproducto);
                                    $("#tipo_subproductoForm").val(value[0].tipo_subproducto);
                                    $("#desc_subproductoForm").val(value[0].desc_subproducto);
                                    $("#valortotalform").val(value[0].valortotal);
                                    $("#nom_impuestoFormSub").val(value[0].nom_impuesto);
                                */
                        });

                    }
                });

            });

            function editEntradaValue() {
                $("#name").prop('readonly', false);
            }


        });

        /*function PopUpSalida() {
            var popup = $("#myPopupSalida");
            popup.classList.toggle("show");
        }*/
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
