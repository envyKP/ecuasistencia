<table class="table table-responsive-sm table-hover table-outline mb-0" id="tabla-det-caraga-corp">
<thead class="thead-light">
    <tr>
        <th style="background-color:#3498DB" class="text-left">{{'Cod Carga'}}</th>
        <th style="background-color:#3498DB" class="text-left">{{'Proceso'}}</th>
        <th style="background-color:#3498DB" class="text-left">{{'Archivo'}}</th>
        <th style="background-color:#90EE90">{{'Total registros en archivo'}}</th>
        <th style="background-color:#90EE90">{{'Total registros duplicados'}}</th>
        <th style="background-color:#90EE90">{{'Total registros sin información'}}</th>
        <th style="background-color:#90EE90">{{'Total registros disponibles para la gestión'}}</th>
        <th style="background-color:#90EE90">{{'Total registros gestionados en otras campañas'}}</th>
    </tr>
</thead>
@if (isset($dataExport))
@php $row=0; @endphp
<tbody>
    @foreach($dataExport as $registro )
        @php $row++; @endphp
    <tr>
        <td style="text-align: center"><strong>{{ $registro->cod_carga }}</strong></td>
        <td style="text-align: center"><strong>{{ $registro->proceso }}</strong></td>
        <td>{{ isset($registro->archivo) ? $registro->archivo : '' }}</td>
        <td>{{ isset($registro->total_registros_archivo) ? $registro->total_registros_archivo : '' }}</td>
        <td>{{ isset($registro->total_registros_duplicados) ? $registro->total_registros_duplicados: '' }}</td>
        <td>{{ isset($registro->total_registros_sin_infor) ? $registro->total_registros_sin_infor: '' }}</td>
        <td>{{ isset($registro->total_registros_disponible_gestion) ? $registro->total_registros_disponible_gestion: '' }}</td>
        <td>{{ isset($registro->total_registros_gestionados_otras_campanas) ? $registro->total_registros_gestionados_otras_campanas: '' }}</td>
    </tr>
    @endforeach
</tbody>
@endif
</table>
