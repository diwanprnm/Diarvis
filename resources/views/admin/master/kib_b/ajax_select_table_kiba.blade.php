@foreach($kib_a as $dt) 
<tr>
    <td> {{ $dt->no_register }}</td>
    <td> {{ $dt->tgl_perolehan }}</td>
    <td> {{ $dt->kode_aset }}</td>
    <td> {{ $dt->harga }}</td>
    <td> {{ $dt->keterangan }}</td>
</tr>
@endforeach