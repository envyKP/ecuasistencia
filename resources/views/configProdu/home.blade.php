@extends('layouts.admin')
@section('scripts')
<script type="text/javascript">

$(document).ready(function(){


    $("#clienteCMB").change(function(){

        //Acciones off
        $("#btnAddprod").css('visibility', 'hidden');
        $("#btnEditprod").css('visibility', 'hidden');
        $("#btnElimprod").css('visibility', 'hidden');
        $("#btnAddsubprod").css('visibility', 'hidden');
        $("#btnEditsubprod").css('visibility', 'hidden');
        $("#btnElimsubprod").css('visibility', 'hidden');

        if ( $("#clienteCMB").val() !== "clienteNull") {

            //input blade Addproducto
            $("#clienteAdd").val( $(this).val());
            //vacio producto infor
            $("#clienteForm").val(null);
            $("#nom_productoForm").val(null);
            $("#desc_productoForm").val(null);
            //vacio subproducto infor
            $("#id_subprodFormSub").val(null);
            $("#clienteFormSub").val(null);
            $("#contrato_amaSubForm").val(null);
            $("#cod_establecimientoEditForm").val(null);
            $("#nom_subproductoForm").val(null);
            $("#desc_subproductoForm").val(null);
            $("#valortotalform").val(null);
            $("#graba_impuestoForm").val(null);
            $("#nom_impuestoFormSub").val(null);
            $("#subtotalForm").val(null);
            $("#valor_porcentajeForm").val(null);
            $("#deduccion_impuestoForm").val(null);
            $("#divImpuesformSub").css("display", "none");
            //accion agregar producto
            $("#btnAddprod").css('visibility', 'visible');

            $.ajax({
                url:"{{route('EaProductoController.getProducto')}}?cliente="+$(this).val(),
                method: "GET",
                success: function(data){
                    $('#productoID').html(data.htmlProducto);
                }
            });

            $.ajax({
                url:"{{route('EaClienteController.getClienteModel')}}?cliente="+$(this).val(),
                method:"get",
                success: function(data){

                    JSON.stringify(data.clienteModel, function (key, value){
                       $("#clienteLogo").attr("src", "{{ asset('storage') }}/"+value[0].logotipo);
                    });

                }
            });

            $.ajax({
                url:"{{route('EaImpuestosController.getImpuestoHtml')}}?cliente="+$(this).val(),
                method:"get",
                success: function (data){
                    //input - blade Add subproducto
                    $("#nom_impuesto").html(data.impuestoHtml);
                    //input - blade Edit subproducto
                    $("#nom_impuestoEdit").html(data.impuestoHtml);
                }
            });

        }

    });


    $("#productoID").change(function(){

        //acciones
        $("#btnEditprod").css('visibility', 'visible');
        $("#btnElimprod").css('visibility', 'visible');
        $("#btnAddsubprod").css('visibility', 'visible');
        // accion subproducto
        $("#btnEditsubprod").css('visibility', 'hidden');
        $("#btnElimsubprod").css('visibility', 'hidden');

        //vacio infor - subproducto blade
        $("#id_subprodFormSub").val(null);
        $("#clienteFormSub").val(null);
        $("#contrato_amaSubForm").val(null);
        $("#cod_establecimientoEditForm").val(null);
        $("#sub-subproductoForm").val(null);
        $("#desc_subproductoForm").val(null);
        $("#valortotalform").val(null);
        $("#graba_impuestoForm").val(null);
        $("#nom_impuestoFormSub").val(null);
        $("#subtotalForm").val(null);
        $("#valor_porcentajeForm").val(null);
        $("#deduccion_impuestoForm").val(null);
        $("#divImpuesformSub").css("display", "none");


        $.ajax( {
            url:"{{route('EaSubproductoController.getSubproducto')}}?cliente="+$("#clienteCMB").val()+"&contrato_ama="+$(this).val(),
            method:"get",
            success: function(data){
                 $('#subproductoID').html(data.htmlSubproducto);
            }
        });

        $.ajax( {
            url:"{{route('EaProductoController.getProductoModel')}}?cliente="+$("#clienteCMB").val()+"&contrato_ama="+$(this).val(),
            method:"get",
            success: function(data){

                JSON.stringify(data.productoModel, function(key, value){
                    //infor - producto blade
                    $("#id_productoForm").val(value[0].id_producto);
                    $("#clienteForm").val(value[0].cliente);
                    $("#contrato_amaForm").val(value[0].contrato_ama);
                    $("#subproductoForm").val(value[0].subproducto);
                    $("#desc_productoForm").val(value[0].desc_producto);

                    //infor - subproducto blade
                    $("#desc_productoSubForm").val(value[0].desc_producto); //para flashed session data

                    //edit - producto blade
                    $("#id_producto").val(value[0].id_producto);
                    $("#cliente").val(value[0].cliente);
                    $("#contrato_amaOLD").val(value[0].contrato_ama);//update producto - de todos los subproductos
                    $("#contrato_ama").val(value[0].contrato_ama);
                    $("#subproducto").val(value[0].subproducto);
                    $("#desc_productoOLD").val(value[0].desc_producto); // para Flashed Session Data
                    $("#desc_producto").val(value[0].desc_producto);

                    //input create - blade Add subproducto
                    $("#clienteAddSub").val(value[0].cliente);
                    $("#contrato_amaAddSub").val(value[0].contrato_ama);
                    $("#nom_impuestoSub").val(value[0].nom_impuesto);
                    $("#desc_productoAddSub").val(value[0].desc_producto); //para flashed session data

                    //Edit Subproducto
                     $("#desc_productoEditSub").val(value[0].desc_producto); //pata flashed session data

                });
            }

        });

    });


    $("#subproductoID").change(function(){

            // accion subproducto
            $("#btnEditsubprod").css('visibility', 'visible');
            $("#btnElimsubprod").css('visibility', 'visible');

            $.ajax({
                url:"{{route('EaSubproductoController.getSubproductoModel')}}?cliente="+$("#clienteCMB").val()+"&contrato_ama="+$("#productoID").val()+"&id_subproducto="+$(this).val(),
                method: "get",
                success: function(data){
                    JSON.stringify(data.subProductoModel, function(key, value){
                         //infor - subproducto blade
                        $("#id_subprodFormSub").val(value[0].id_subproducto);
                        $("#clienteFormSub").val(value[0].cliente);
                        $("#contrato_amaSubForm").val(value[0].contrato_ama);
                        $("#sub-subproductoForm").val(value[0].subproducto);
                        $("#tipo_subproductoForm").val(value[0].tipo_subproducto);
                        $("#desc_subproductoForm").val(value[0].desc_subproducto);
                        $("#valortotalform").val(value[0].valortotal);
                        $("#nom_impuestoFormSub").val(value[0].nom_impuesto);
                        $("#cod_establecimientoEditForm").val(value[0].cod_establecimiento);
                        $("#graba_impuestoForm").val (value[0].graba_impuesto);
                        $("#subtotalForm").val(value[0].subtotal);
                        $("#deduccion_impuestoForm").val( parseFloat (value[0].deduccion_impuesto) );

                        if ( $("#graba_impuestoForm").val() === 'SI' ) {
                            $("#valor_porcentajeForm").val(value[0].valor_porcentaje);
                            $("#divImpuesformSub").css("display", "block");
                        }else {
                            $("#divImpuesformSub").css("display", "none");
                        }

                        //edit - subproducto blade
                        $("#id_subproducto").val(value[0].id_subproducto);
                        $("#clienteSub").val(value[0].cliente);
                        $("#contrato_amaEdit").val(value[0].contrato_ama);
                        $("#cod_establecimientoEdit").val(value[0].cod_establecimiento);
                        $("#subproductoEdit").val(value[0].subproducto);
                        $("#tipo_subproductoEdit").find('option[value="'+value[0].tipo_subproducto+'"]').attr("selected", "selected");
                        $("#desc_subproductoEdit").val(value[0].desc_subproducto);

                        $("#valor_porcentajeEdit").val(value[0].valor_porcentaje);
                        $("#deduccion_impuestoEditSub").val( parseFloat(value[0].deduccion_impuesto) );
                        $("#subtotalEditSub").val(value[0].subtotal);
                        $("#valortotalEditSub").val(value[0].valortotal)
                        $("#graba_impuestoEdit").find('option[value="'+value[0].graba_impuesto+'"]').attr("selected", "selected"); //seteo combo
                        $("#nom_impuestoEdit").find('option[value="'+value[0].nom_impuesto+'"]').attr("selected", "selected");
                        $("#cuenta").val(value[0].cuenta);
                        $("#deudor").val(value[0].deudor);
                        $("#cliente_sap").val(value[0].cliente_sap);
                        $("#producto_sap").val(value[0].producto_sap);
                        $("#tipo_negocio").val(value[0].tipo_negocio);
                        $("#nombre_contrato_ama").val(value[0].nombre_contrato_ama);

                        $("#valorOld").val(value[0].valortotal);  // para Flashed Session Data
                        $("#deduccion_impuestoEditSubOld").val( parseFloat(value[0].deduccion_impuesto)); // para flashed session data
                        $("#subtotalEditSubOld").val(value[0].subtotal); // para flashed session data
                        $("#graba_impuestoEditOld").val(value[0].graba_impuesto); // para Flashed session data
                        $("#subproductoOLD").val(value[0].subproducto); // para Flashed Session Data subproductoOLD

                    });

                }
            });
    });


    $("#nom_impuesto").change(function(){

        $.ajax({
            url:"{{route('EaImpuestosController.getImpuestoModel')}}?cliente="+$("#clienteCMB").val()+"&nom_impuesto="+$(this).val(),
            method:"get",
            success: function (data){
                JSON.stringify(data.impuestoModel, function(key, value){
                    //input - blade Add subproducto
                    $("#valor_porcentaje").val(value[0].valor_porcentaje);
                });
                var impuesto = 1+$("#valor_porcentaje").val()/100;
                $("#subtotal").val( ($("#valortotal").val()/impuesto).toFixed(2) );
                $("#deduccion_impuesto").val( ($("#valortotal").val() - $("#subtotal").val()).toFixed(2) );
            }
        });
   });


    $("#nom_impuestoEdit").change(function(){

        $.ajax({
            url:"{{route('EaImpuestosController.getImpuestoModel')}}?cliente="+$("#clienteCMB").val()+"&nom_impuesto="+$(this).val(),
            method:"get",
            success: function (data){
                JSON.stringify(data.impuestoModel, function(key, value){
                    //input - blade Edit subproducto
                    $("#valor_porcentajeEdit").val(value[0].valor_porcentaje);
                });

                var impuesto = 1+$("#valor_porcentajeEdit").val()/100;
                $("#subtotalEditSub").val( ($("#valortotalEditSub").val()/impuesto).toFixed(2) );
                $("#deduccion_impuestoEditSub").val( ($("#valortotalEditSub").val() - $("#subtotalEditSub").val()).toFixed(2) );
            }
        });
    });


    //blade Add subproducto
    $("#graba_impuesto").change(function(){

        if ( $(this).val() === 'SI') {

	        $("#divImpuesto").css("display", "block");
	        $("#nom_impuesto").prop("required", true); //seleccion obligada: select is not focusable

        }else if ( $(this).val() === 'NO'){

            $("#divImpuesto").css("display", "none");
            $("#nom_impuesto").val(null);
            $("#valor_porcentaje").val(null);
            $("#deduccion_impuesto").val(null);

            $("#subtotal").val( $("#valortotal").val() );
        }

    });

    //blade Edit subproducto
   $("#graba_impuestoEdit").change(function(){

        if ( $(this).val() === 'SI' ) {

            $("#divImpuestoEdit").css("display", "block");
            $("#nom_impuestoEdit").prop("required", true);

        }else if( $(this).val() === 'NO' ){

            $("#divImpuestoEdit").css("display", "none");
            $("#nom_impuestoEdit").val(null);
            $("#valor_porcentajeEdit").val(null);
            $("#deduccion_impuestoEditSub").val(null);

            $("#subtotalEditSub").val( $("#valortotalEditSub").val());
        }
    });


    //blade add Subproducto
    $("#valortotal").blur(function(){
        var impuesto = 1+$("#valor_porcentaje").val()/100;
        $("#subtotal").val( ($("#valortotal").val()/impuesto).toFixed(2) );
        $("#deduccion_impuesto").val( ($("#valortotal").val() - $("#subtotal").val()).toFixed(2) );
    });


    //blade Editar Subproducto
    $("#valortotalEditSub").blur(function(){
        var impuesto = 1+$("#valor_porcentajeEdit").val()/100;
        $("#subtotalEditSub").val( ($("#valortotalEditSub").val()/impuesto).toFixed(2) );
        $("#deduccion_impuestoEditSub").val( ($("#valortotalEditSub").val() - $("#subtotalEditSub").val()).toFixed(2) );
    });


    $("#btnModalEliminarProducto").click(function (){
        $("#form-delete-pro").submit();
    });


    $("#btnModalEliminarSubproducto").click(function(){
        $("#form-delete-Subpro").submit();
    });


});
</script>
@endsection


@section('content')
<div class="alert alert-primary" role="alert">

    <div class="row justify-content-between">

        <div>
        @if ( strcmp (session('trxprod'), 'store')===0 )
        <div class="col-sm-12 col-md-12 my-3">
            <div class="alert alert-success alert-dismissible fade show "  role="alert">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-thick-to-bottom')}}"></use>
                </svg>
                <strong>{{'Producto Agregado!'}}</strong>
                <div>
                    <strong>{{'Nuevo producto: '}}</strong> {{ session('desc_producto') }} <strong>{{' - Cliente: '}}</strong>{{ session('cliente') }}
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @elseif  ( strcmp (session('trxprod'), 'update' )=== 0 )
        <div class="col-sm-12 col-md-12 my-3">
            <div class="alert alert-info  alert-dismissible fade show "  role="alert">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                </svg>
                <strong>{{'Producto Actualizado!'}}</strong>
                <div>
                    <strong>{{'Cliente: '}}</strong>{{ session('cliente') }}
                </div>
                <div>
                    <strong>{{'Contrato AMA: '}}</strong>{{ session('nom_productoOLD') }}   <strong>{{' - Actualizado a: '}}</strong>{{ session('nom_producto') }}
                    </div>
                <div>
                    <strong>{{'Descripción del producto de: '}}</strong>{{ session('desc_productoOLD') }}   <strong>{{' - Actualizado a: '}} </strong>{{ session('desc_producto') }}
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @elseif  ( strcmp (session('trxprod'), 'delete' )=== 0 )
        <div class="col-sm-12 col-md-12 my-3">
            <div class="alert alert-danger alert-dismissible fade show "  role="alert">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                </svg>
                <strong>{{'Producto Eliminado!'}}</strong>
                <div>
                    <strong>{{'Producto: '}}</strong> {{ session ('desc_producto') }}   <strong>{{' - Cliente: '}}</strong>{{ session('cliente') }}
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>


        @elseif ( strcmp (session('trxsubprod'), 'store')===0 )
        <div class="col-sm-12 col-md-12 my-3">
            <div class="alert alert-success alert-dismissible fade show "  role="alert">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-thick-to-bottom')}}"></use>
                </svg>
                <strong>{{'Subproducto Agregado!'}}</strong>
                <div>
                    <strong>{{'Nuevo Subproducto: '}}</strong> {{ session('desc_subproducto') }}  <strong>{{' - Producto asociado: '}}</strong>{{ session('productoAddSub') }} <strong>{{' - Cliente: '}}</strong>{{ session('clienteAddSub') }}
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @elseif  ( strcmp (session('trxsubprod'), 'update' )=== 0 )
        <div class="col-sm-12 col-md-12 my-3">
            <div class="alert alert-warning alert-dismissible fade show "  role="alert">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                </svg>
                <strong>{{'Subproducto Actualizado!'}}</strong>
                <div>
                    <strong>{{'Cliente: '}}</strong>{{ session('cliente') }}
                </div>
                <div>
                    <strong>{{'Producto asociado: '}}</strong>{{ session('producto') }}
                </div>
                <div>
                    <strong>{{'Valor del Subproducto de: $'}}</strong> {{ session('valorOLD') }}   <strong>{{' - Actualizado a: $'}}</strong> {{ session('valor') }}
                </div>
                <div>
                    <strong>{{'Deducción de impuesto de: '}}  </strong> {{ session('deduccion_impuestoOld') }}   <strong>{{' - Actualizado a: '}} </strong> {{ session('deduccion_impuesto') }}
                </div>
                <div>
                    <strong>{{'Subtotal de: '}}  </strong> {{ session('subtotalEditSubOld') }}   <strong>{{' - Actualizado a: '}} </strong> {{ session('subtotal') }}
                </div>
                <div>
                    <strong>{{'Nombre del Subproducto de: '}}</strong> {{ session('nom_subproductoOLD') }}   <strong>{{' - Actualizado a: '}}</strong> {{ session('nom_subproducto') }}
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @elseif  ( strcmp (session('trxsubprod'), 'delete' )=== 0 )
        <div class="col-sm-12 col-md-12 my-3">
            <div class="alert alert-danger alert-dismissible fade show "  role="alert">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                </svg>
                <strong>{{'Subproducto Eliminado!'}}</strong>
                <div>
                    <strong>{{'Subproducto: '}}</strong> {{ session ('desc_subproductoForm') }} <strong>{{'  - Producto asociado: ' }}</strong>{{ session('productoForm') }}  <strong>{{' - Cliente: '}}</strong>{{ session('cliente') }}
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif
        </div>
        <div>
            <h4>
                <svg class="c-icon c-icon-3xl">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cc-discover')}}"></use>
                </svg> {{'Configuración de Productos'}}
            </h4>
        </div>
    </div>

</div>

<div class="row">
    @include('configProdu.campanas', [ 'Allcampanas' => $Allcampanas] )
    @include('configProdu.producto')
    @include('configProdu.subproducto')
</div>
@endsection
