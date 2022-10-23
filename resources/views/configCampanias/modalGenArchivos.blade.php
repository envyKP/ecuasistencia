<form id="form-export-guardar-datos" method="post" action= "{{ route('EaControlCampania.post_export_guardar_datos')}}">
    @csrf
    @method('post')
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" style="width:1000px; right:100px;">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{ 'Configuración Generación de Achivo'}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-6">
                    <select class="custom-select" name="opconfig" id="opconfig" required>
                        <option selected>{{ 'Seleccione una Configuracion...' }}</option>
                        <option value="fijo">FIJO</option>
                        <option value="base">BASE</option>
                        <option value="fecha">FECHA</option>
                    </select>
                </div>
                <div class="form-group col-3">
                    <button type="button" class="btn btn-primary" id="btn-anadir">{{'Anadir'}}</button>
                     <button type="button" class="btn btn-success" id="btn-guardar">{{'Guardar'}}</button>
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
          <button type="button" class="btn btn-success" id="btn-export-guardar-datos">{{'Guardar'}}</button>
        </div>
      </div>
    </div>
  </div>
</form>