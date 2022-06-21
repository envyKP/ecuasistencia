<table class="table table-responsive-sm table-hover table-outline mb-0" id="tabla-det-caraga-corp">
<thead class="thead-light">
    <tr>
        <th style="text-align:center; background-color:#FFFF00">{{'Cod Carga'}}</th>
        <th style="text-align:center; background-color:#FFFF00">{{'Cedula'}}</th>
        <th style="background-color:#FFFF00">{{'Nombres'}}</th>
        <th style="background-color:#FFFF00">{{'Telefono1'}}</th>
        <th style="background-color:#FFFF00">{{'Telefono2'}}</th>
        <th style="background-color:#FFFF00">{{'Telefono3'}}</th>
        <th style="background-color:#FFFF00">{{'Telefono4'}}</th>
        <th style="background-color:#FFFF00">{{'Telefono5'}}</th>
        <th style="background-color:#FFFF00">{{'Telefono6'}}</th>
        <th style="background-color:#FFFF00">{{'Telefono7'}}</th>
        <th style="background-color:#FFA500">{{'Ciudad'}}</th>
        <th style="background-color:#FFA500">{{'Direccion'}}</th>
        <th style="background-color:#FFA500">{{'Email'}}</th>
        <th style="background-color:#6495ED">{{'Direccion_Confirmacion'}}</th>
        <th style="background-color:#6495ED">{{'Email_Confirmacion'}}</th>
        <th style="background-color:#90EE90">{{'Telefono_Contactado'}}</th>
        <th style="background-color:#90EE90">{{'Operador'}}</th>
        <th style="background-color:#90EE90">{{'Fecha'}}</th>
        <th style="background-color:#90EE90">{{'Hora'}}</th>
        <th style="background-color:#90EE90">{{'Estado'}}</th>
        <th style="background-color:#90EE90">{{'Motivo'}}</th>
    </tr>
</thead>
@if (isset($dataExport))
@php $row=0; @endphp
<tbody>
    @foreach($dataExport as $registro )
        @php $row++; @endphp
    <tr>
        <td  style="text-align:center;">{{ $registro->cod_carga_corp }}</td>
        <td  style="text-align:center;">{{ $registro->cedula_id }}</td>
        <td>{{ isset ($registro->nombre) ? $registro->nombre : '' }}</td>
        <td>{{ isset ($registro->telefono1) ? $registro->telefono1 : '' }}</td>
        <td>{{ isset ($registro->telefono2) ? $registro->telefono2 : '' }}</td>
        <td>{{ isset ($registro->telefono3) ? $registro->telefono3 : '' }}</td>
        <td>{{ isset ($registro->telefono4) ? $registro->telefono4 : '' }}</td>
        <td>{{ isset ($registro->telefono5) ? $registro->telefono5 : '' }}</td>
        <td>{{ isset ($registro->telefono6) ? $registro->telefono6 : '' }}</td>
        <td>{{ isset ($registro->telefono7) ? $registro->telefono7 : '' }}</td>
        <td>{{ isset ($registro->ciudadet) ? $registro->ciudadet : ''  }}</td>
        <td>{{ isset ($registro->direccion) ?  $registro->direccion : '' }}</td>
        <td>{{ isset ($registro->mail) ? $registro->mail : '' }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    @endforeach
</tbody>
@endif
</table>
