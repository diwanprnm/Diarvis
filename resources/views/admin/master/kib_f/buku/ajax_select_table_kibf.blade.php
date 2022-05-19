@foreach($kib_f as $dt) 
<tr>
    <td> {{ $dt->no_register }}</td>
    <td> {{ $dt->tgl_perolehan }}</td>
    <td> {{ $dt->kd_aset1."".$dt->kd_aset2."".$dt->kd_aset3."".$dt->kd_aset4."".$dt->kd_aset5 }}</td>
    <td> {{ $dt->harga }}</td>
    <td> {{ $dt->keterangan }}</td>
</tr>
@endforeach