<form id="form-guardar_producto" method="post" action= "{{ route('EaControlCampania.post_guardar_producto')}}">
    @csrf
    @method('post')
<div class="modal fade" id="modalAgregaProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" style="width:1000px; right:100px;">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{ 'Configuración Nuevo Producto'}}</h5>
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
                    <label>{{'Tipo Subprodcuto'}}</label>
                    <input class="form-control" maxlength="40" name="tipo_subproducto"   id="tipo_subproducto"  value="" type="text" placeholder="Nombre del cliente" required oninput="this.value = this.value.toUpperCase();">
                </div>
              </div>
              <div class="col-sm-4 col-md-4">
                <div class="form-group">
                    <label>{{'Subprodcuto'}}</label>
                    <input class="form-control" maxlength="40" name="subproducto" id="subproducto" value="" type="text" placeholder="Nombre del cliente" required oninput="this.value = this.value.toUpperCase();">
                </div>
              </div>
              <div class="col-sm-4 col-md-4">
                <div class="form-group">
                    <label>{{'Identificador'}}</label>
                    <input class="form-control" maxlength="40" name="idenificador"  id="idenificador" value="" type="text" placeholder="Nombre del cliente" required oninput="this.value = this.value.toUpperCase();">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4 col-md-4">
                <div class="form-group">
                    <label>{{'Esapcio'}}</label>
                    <input class="form-control" maxlength="40" name="contador_secuencia" id="contador_secuencia" value="" type="text" placeholder="Nombre del cliente" required oninput="this.value = this.value.toUpperCase();">
                </div>
              </div>
              <div class="col-sm-4 col-md-4">
                <div class="form-group">
                    <label>{{'Formato Fecha'}}</label>
                    <input class="form-control" maxlength="40" name="formato_fecha" id="formato_fecha" value="" type="text" placeholder="Nombre del cliente" required oninput="this.value = this.value.toUpperCase();">
                </div>
              </div>
           </div>
            <div class="col-sm-12 form-group" id="processExportGuardarDatos" style="display:none">
                <strong>{{ 'Procesando...' }}</strong>
                <progress class="col-sm-12" max="100">100%</progress>
            </div>
            <div id="div-opcion-archivos" class="form-group">

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{'Cerrar'}}</button>
          <button type="button" class="btn btn-success" id="btn-guardar_producto">{{'Guardar'}}</button>
        </div>
      </div>
    </div>
  </div>
</form>