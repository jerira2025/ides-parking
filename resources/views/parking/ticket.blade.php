<div style="font-family: monospace; width: 320px; border:1px solid #000; padding:10px; text-align:center;">

    <!-- Logo centrado y más grande -->
    <img src="{{ asset('images/logo.png') }}" alt="Logo Parqueadero" style="width:180px; height:auto; margin-bottom:15px;">

    <!-- Dirección separada -->
    <p style="font-size:10px; margin:0;">CALLE 11 No 7-98</p>

    <!-- Horarios en la misma línea -->
    <p style="font-size:10px; margin:0;">Horario de atención 7 AM a 7 PM</p>
     <p style="font-size:10px; margin:0;">Domingos y festivos no hay atención</p>

    <hr style="border:1px dashed #000; margin:5px 0;">

    <table style="width:100%; font-size:12px; border-collapse: collapse; text-align:left;">
        <tr>
            <td><strong>Día:</strong> {{ $entrada->entry_time->format('d') }}</td>
            <td><strong>Mes:</strong> {{ $entrada->entry_time->format('m') }}</td>
            <td><strong>Año:</strong> {{ $entrada->entry_time->format('Y') }}</td>
        </tr>
        <tr>
            <!-- Formato de placa ABC-123 -->
            <td colspan="3">
                <strong>Placa Vehículo:</strong> 
                {{ substr($entrada->vehicle->plate, 0, 3) . '-' . substr($entrada->vehicle->plate, 3) }}
            </td>
        </tr>
       <tr>
    <td colspan="3"><strong>Hora Entrada:</strong> {{ now()->format('g:i A') }}</td>
</tr>
        <tr>
            <td colspan="3">
                <strong>Casco:</strong> ☐ &nbsp;&nbsp;
                <strong>Chaleco:</strong> ☐ &nbsp;&nbsp;
                <strong>Llaves:</strong> ☐
            </td>
        </tr>
    </table>

    <!-- Nº de recibo con formato 0000 -->
    <p style="text-align:center; font-size:12px; margin:5px 0;">
      <strong>Recibo Nº:</strong> {{ str_pad($entrada->id, 4, '0', STR_PAD_LEFT) }}
    <!-- QR centrado -->
    <div style="text-align:center; margin-top:5px;">
        <img src="data:image/png;base64,{{ $qr }}" alt="QR Code" style="width:100px; height:100px;" />
    </div>

    <!-- Texto legal -->
    <p style="font-size:9px; text-align:justify; margin-top:5px;">
        El vehículo se entregará al portador del recibo. No se acepta órdenes telefónicas ni escritas. Retirado el vehículo no se acepta ningún tipo de reclamo. No respondemos por objetos dejados en el vehículo. No respondemos por hurto. No respondemos por la pérdida, deterioro o daños ocurridos como consecuencia de incendio, terremoto, asonada, protestas u otras causas similares. El conductor debe asegurarse que el vehículo esté bien asegurado (cerrado). No respondemos por daños al vehículo causados por terceros.
    </p>
</div>
