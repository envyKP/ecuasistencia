<table class="table table-responsive-sm table-hover table-outline mb-0" id="tabla-det-caraga-corp">
<thead class="thead-light">
    <tr>
        <th style="background-color:#FF0000" class="text-left">{{'Cod Carga'}}</th>
        <th style="background-color:#FF0000" class="text-left">{{'Cedula'}}</th>
        <th style="background-color:#FF0000">{{'Cliente'}}</th>
        <th style="background-color:#90EE90">{{'Numero_de_tarjeta'}}</th>
        <th style="background-color:#90EE90">{{'Fecha_de_Vigencia_de_Tarjeta'}}</th>
        <th style="background-color:#90EE90">{{'Numero_de_Cuenta'}}</th>
        <th style="background-color:#90EE90">{{'Tipo_de_Cuenta'}}</th>
    </tr>
</thead>
@if (isset($dataExport))
@php $row=0; @endphp
<tbody>
    @foreach($dataExport as $registro )
        @php $row++; @endphp
    <tr>
        <td style="text-align: center"><strong>{{ $registro->cod_carga_corp }}</strong></td>
        <td style="text-align: center"><strong>{{ $registro->cedula_id }}</strong></td>
        <td>{{ isset ($registro->nombre) ? $registro->nombre : '' }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    @endforeach
</tbody>
@endif
</table>
