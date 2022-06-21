<!-- Samuel Gavela /.modal editar infor sub-producto-->
<form action="{{ route('EaSubproductoController.update')}}" method="post">
@csrf
{{method_field('patch')}}
<div class="modal fade" id="editSubproModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content" style="width:1000px; right:200px;">
        <div class="modal-header">
            <h4 class="modal-title">
                <svg class="c-icon c-icon-2xl my-1">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                </svg>
                {{'Editar Sub-Producto'}}
            </h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body row">
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cplusplus')}}"></use>
                                </svg>
                                {{'Cliente'}}
                            </span>
                        </div>
                        <input class="form-control" type="text" id="clienteSub" name="clienteSub" value="" placeholder="Cliente" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign')}}"></use>
                                </svg>
                                {{'Contrato AMA'}}
                            </span>
                        </div>
                        <input type="hidden" id="id_subproducto" name="id_subproducto" >
                        <input class="form-control" type="text" name="contrato_amaEdit"  id="contrato_amaEdit" placeholder="Ingrese Nombre del Producto" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-home')}}"></use>
                                </svg>{{'Código Establecimiento'}}
                            </span>
                        </div>
                        <input type="hidden" id="cod_establecimientoEditOLD" name="cod_establecimientoEditOLD">
                        <input class="form-control" type="text" id="cod_establecimientoEdit" name="cod_establecimientoEdit"  placeholder="Código de establecimiento" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cc-visa')}}"></use>
                                </svg>
                                {{'SubProducto'}}
                            </span>
                        </div>
                        <input type="hidden" name="subproductoOLD" id="subproductoOLD">
                        <input class="form-control" maxlength="100" type="text" name="subproducto"  id="subproductoEdit" placeholder="{{'Ingrese nombre del subproducto'}}" oninput="this.value = this.value.toUpperCase()" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text alert"><svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-credit-card')}}"></use>
                                </svg>{{'Tipo SubProducto'}}
                            </span>
                        </div>
                        <select class="form-control" name="tipo_subproducto" id="tipo_subproductoEdit">
                            <option value="" selected>{{'Seleccione un tipo'}}</option>
                            <option value="{{'CTAS'}}">{{'Cuentas'}}</option>
                            <option value="{{'TC'}}">{{'Tarjeta Crédito'}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-speech')}}"></use>
                                </svg>
                                {{'Descripción'}}
                            </span>
                        </div>
                        <input type="hidden" name="desc_subproductoOLD" id="desc_subproductoOLD">
                        <input class="form-control" name="desc_subproducto" id="desc_subproductoEdit" oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cashapp')}}"></use>
                                </svg>
                                {{'Valor Total'}}
                            </span>
                        </div>
                        <input type="hidden" name="valorOld" id="valorOld" >
                        <input class="form-control" type="number" step="0.01"  name="valortotalEditSub" id= "valortotalEditSub" placeholder="{{'$0.00'}}" required autocomplete="off"
                             onKeyPress="if(this.value.length==6 ) return false; return ( event.charCode !=8 && event.charCode ==0   || ( event.charCode == 188 || event.charCode == 46|| (event.charCode >= 48 && event.charCode <= 57) ))" >

                        <div class="input-group-append"><span class="input-group-text">
                            <svg class="c-icon">
                                <use xlink:href="{{ asset ('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-slashdot')}}"></use>
                            </svg></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon mr-1">
                                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-buzzfeed')}}"></use>
                            </svg>{{'Graba impuesto'}}</span>
                        </div>
                        <input type="hidden" id="graba_impuestoEditOld" name="graba_impuestoEditOld" >
                        <select class="custom-select" name="graba_impuestoEdit" id="graba_impuestoEdit" required>
                            <option value="" selected>{{'¿ Graba impuesto Sí ó No ?'}}</option>
                            <option value="SI">{{'Sí'}}</option>
                            <option value="NO">{{'No'}}</option>
                        </select>
                    </div>
                </div>
                <!-- impuestos -->
                <div id="divImpuestoEdit">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg class="c-icon  mr-1">
                                        <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-calculator')}}"></use>
                                    </svg>{{'ID impuesto'}}
                                </span>
                            </div>
                            <input type="hidden" id="nom_impuestoEditOld" name="nom_impuestoEditOld">
                            <select class="custom-select"  name="nom_impuestoEdit" id="nom_impuestoEdit">
                                <option value="" selected>{{'Seleccion un impuesto'}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cashapp')}}"></use>
                                </svg>
                                {{'Valor o porcentaje'}}</span>
                            </div>
                            <input class="form-control" type="number"  name="valor_porcentajeEdit" id="valor_porcentajeEdit" placeholder="{{'Valor ó Porcentaje del impuesto'}}" readonly>
                            <div class="input-group-append"><span class="input-group-text">
                                <svg class="c-icon">
                                    <use xlink:href="{{ asset ('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-slashdot')}}"></use>
                                </svg></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cashapp')}}"></use>
                                </svg>
                                {{'Deduccion de impuesto'}}</span>
                            </div>
                            <input type="hidden" id="deduccion_impuestoEditSubOld" name="deduccion_impuestoEditSubOld">
                            <input class="form-control" type="number" step="0.01" name="deduccion_impuestoEditSub" id="deduccion_impuestoEditSub" placeholder="{{'Deducción del impuesto'}}" readonly>
                            <div class="input-group-append"><span class="input-group-text">
                                <svg class="c-icon">
                                    <use xlink:href="{{ asset ('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-slashdot')}}"></use>
                                </svg></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">
                            <svg class="c-icon mr-1">
                                <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-cashapp')}}"></use>
                            </svg>
                            {{'Subtotal'}}</span>
                        </div>
                        <input type="hidden" id="subtotalEditSubOld" name="subtotalEditSubOld">
                        <input class="form-control" type="number" step="0.01" name="subtotalEditSub" id="subtotalEditSub" placeholder="{{'Subtotal del Subproducto'}}" readonly>
                        <div class="input-group-append"><span class="input-group-text">
                            <svg class="c-icon">
                                <use xlink:href="{{ asset ('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-slashdot')}}"></use>
                            </svg></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-briefcase')}}"></use>
                                </svg>
                                {{'Cuenta'}}
                            </span>
                        </div>
                        <input class="form-control"  type="number" name="cuenta" id="cuenta" oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-wallet')}}"></use>
                                </svg>
                                {{'Deudor'}}
                            </span>
                        </div>
                        <input class="form-control"  type="number" name="deudor" id="deudor" oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-sap')}}"></use>
                                </svg>
                                {{'Cliente SAP'}}
                            </span>
                        </div>
                        <input class="form-control"  type="text" name="cliente_sap" id="cliente_sap" oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-sap')}}"></use>
                                </svg>
                                {{'Producto SAP'}}
                            </span>
                        </div>
                        <input class="form-control"  type="text" name="producto_sap" id="producto_sap" oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-azure-artifacts')}}"></use>
                                </svg>
                                {{'Tipo de negocio'}}
                            </span>
                        </div>
                        <input class="form-control"  type="number" name="tipo_negocio" id="tipo_negocio" oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use xlink:href=" {{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-notes')}}"></use>
                                </svg>
                                {{'Nombre contrato AMA'}}
                            </span>
                        </div>
                        <input class="form-control"  type="text" name="nombre_contrato_ama" id="nombre_contrato_ama" oninput="this.value = this.value.toUpperCase()">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal" onclick="window.close();">{{'Cancelar'}}</button>
            <button class="btn btn-success" type="submit">
                <svg class="c-icon c-icon-xl">
                    <use xlink:href="{{asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save')}} "></use>
                </svg>
            </button>
        </div>
    </div>
    <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>
<!-- /.modal-->
</form>
