<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{ 'Configuración Generación de Achivo'}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-6">
                    <select class="custom-select" name="campaniasOpcionesID" id="campaniasOpcionesID" required>
                        <option selected>{{ 'Seleccione una Configuracion...' }}</option>
                        <option value="cedula_id">Fijo</option>
                        <option value="secuencia">Base</option>
                        <option value="cuenta">Fecha</option>
                    </select>
                </div>
                <div class="form-group col-6">
                    <button type="button" class="btn btn-primary">{{'Anadir'}}</button>
                </div>
                <div class="form-group col-6">
                    <button type="button" class="btn btn-success">{{'Guardar'}}</button>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{'Cerrar'}}</button>
          <button type="button" class="btn btn-success">{{'Guardar'}}</button>
        </div>
      </div>
    </div>
  </div>