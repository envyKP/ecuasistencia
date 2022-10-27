<form id="form-guardar_producto" method="post" action="{{ route('EaControlCampania.post_guardar_producto') }}">
    @csrf
    @method('post')
    <div class="modal fade" id="modalAgregaProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="width:1000px; right:100px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ 'Configuración Nuevo Producto' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 form-group" id="processGuardarProducto" style="display:none">
                            <strong>{{ 'Procesando...' }}</strong>
                            <progress class="col-sm-12" max="100">100%</progress>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>{{ 'Cliente' }}</label>
                                <input class="form-control" name="clienteForm" id="clienteForm" value=""
                                    type="text" placeholder="Cliente Nombre " required readonly>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>{{ 'Tipo Subprodcuto' }}</label>
                                <select class="custom-select" name="tipoProductodata" id="tipoProductodata" required>
                                    <option value="TC" selected>TC</option>
                                    <option value="CTAS">CTAS</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>{{ 'Nombre Configuracion Producto' }}</label>
                                <input class="form-control" name="nameOpcion" id="nameOpcion" value=""
                                    type="text" placeholder="Nombre Configuracion Producto" required
                                    oninput="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>{{ 'Identificador Salida texto' }}</label>
                                <select class="custom-select" name="Identificadosalidatxt" id="Identificadosalidatxt"
                                    required>
                                    <option value="cedula_id" selected>cedula_id</option>
                                    <option value="secuencia">secuencia</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-8 col-md-8">
                            <div class="form-group">
                                <label>{{ 'opciones adicionales' }}</label>
                                <input class="form-control" name="op_caracteristica_ba" id="op_caracteristica_ba"
                                    value="" type="text"
                                    placeholder="JSON exemplo: {&quot;total&quot;:&quot;1&quot;,&quot;var_camp_1&quot;:&quot;3&quot;,&quot;var_val_1&quot;:&quot;CORTE EL 12&quot;,&quot;campo_ba&quot;:&quot;ciclo&quot;}"
                                    required oninput="this.value = this.value.toUpperCase();">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>{{ 'Espacios Salida' }}</label>
                                <select class="custom-select" name="espaciosSalida" id="espaciosSalida" required>
                                    <option value="\t" selected>Tabulado</option>
                                    <option value="">nada</option>
                                </select>
                            </div>
                        </div>



                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <label>{{ 'Formato Fecha' }}</label>
                                <input class="form-control" maxlength="40" name="formato_fecha" id="formato_fecha"
                                    value="" type="text"
                                    placeholder="formato de fecha excel mm/dd/yy por defecto"
                                    oninput="this.value = this.value.toUpperCase();">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <div id="list1" name="list1" class="dropdown-check-list" tabindex="100">
                                    <span class="anchor">Seleccione SubProductos</span>
                                    <ul class="items">
                                        <li><input type="checkbox" id="list01" name="list01" value="hola"  checked/>Name
                                        </li>
                                        <li><input type="checkbox" id="list02" name="list02" value="hola" />Name
                                        </li>
                                        <li><input type="checkbox" id="list03" name="list03"
                                                value="hola" />Name</li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group" id="processExportGuardarDatos2" style="display:none">
                        <strong>{{ 'Procesando...' }}</strong>
                        <progress class="col-sm-12" max="100">100%</progress>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ 'Cerrar' }}</button>
                    <button type="button" class="btn btn-success"
                        id="btn-guardar_producto">{{ 'Guardar' }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
