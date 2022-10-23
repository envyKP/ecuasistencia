<div class="alert alert-dark text-center" role="alert">
    <h4>
        <svg class="c-icon c-icon-2xl mr-2">
            <use xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-settings') }}"></use>
        </svg>
        <!--<div class="popup" onclick="PopUpSalida()">-->

        {{ 'Archivo de Salida' }}
        <!--<span class="popuptext" id="myPopupSalida"> Para la generacion de archivos que se envian a los clientes
                </span>
            </div>-->
    </h4>
</div>
<div class="card">
    <div class="card-header"> {{ 'Descripcion: Exportacion\generacion de texto plano que se enviara a los clientes' }}</div>
    <div class="card-body">
          <div class="card-body">
            <form action="" id="form-Genera-lee" method="post">
                @csrf
                {{ method_field('patch') }}
                <div class="form-group">
                    <div>{{ 'Detalles' }}</div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use
                                        xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign') }}">
                                    </use>
                                </svg>{{ 'Nombre de Opcion' }}
                            </span>
                        </div>
                        <input class="form-control" type="text" id="OpcionName" name="OpcionName"  value="" placeholder="Nombre de opcion" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg class="c-icon mr-1">
                                    <use
                                        xlink:href=" {{ asset('admin/node_modules/@coreui/icons/sprites/brand.svg#cib-adobe-indesign') }}">
                                    </use>
                                </svg>{{ 'Tipo' }}
                            </span>
                        </div>
                        <input class="form-control" type="text" id="tipoCtasPresentacion" name="tipoCtasPresentacion"  value="" placeholder="tipo TC o CTAS" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <!--<button class="btn btn-secondary" type="button" data-dismiss="modal" onclick="window.close();">Cancelar</button>-->
                    <button class="btn btn-success" type="submit">
                        <svg class="c-icon c-icon-xl">
                            <use
                                xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save') }} ">
                            </use>
                        </svg>
                        Editar
                    </button>
                </div>
            </form>
        </div>
        <div class="form-group">
            <button class="btn btn-success" id="btn-Generacion-archivos" type="button" data-toggle="modal" data-target="#exampleModalCenter">
                <svg class="c-icon c-icon-xl ">
                    <use
                        xlink:href="{{ asset('admin/node_modules/@coreui/icons/sprites/free.svg#cil-save') }} ">
                    </use>
                </svg>{{'Generación de archivos salida'}}
            </button>
        </div>
    </div>
    @include('configCampanias.modalGenArchivos')
</div>
</div>
