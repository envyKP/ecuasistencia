@extends('layouts.admin')
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $("#clienteCMB").change(function() {
                if ($("#clienteCMB").val() !== "clienteNull") {
                    $.ajax({
                        url: "{{ route('EaControlCampania.getOpcionesModelAllCliente') }}?cliente=" + $(
                                this)
                            .val(),
                        method: "GET",
                        success: function(data) {
                            $('#opcionEntrada').html(data.htmlProducto);
                            $('#opcionSalida').html(data.htmlProducto);
                        }
                    });
                }
            });





        });

        /*function PopUpSalida() {
            var popup = document.getElementById("myPopupSalida");
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
