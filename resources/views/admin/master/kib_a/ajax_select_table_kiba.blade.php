<table  class="table table-striped table-bordered able-responsive" id="table_kib_a">
        <thead>
            <tr>
            <th>Aksi</th>
                <th>No. Reg</th>
                <th>Tgl Perolehan</th>
                <th>Kode Barang</th>
                <th>Harga</th>
                <th>Uraian Aset</th>
            </tr>
        </thead>
    <tbody>
@foreach($kib_a as $dt) 
<tr>
<td> <a href=""><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-mini  waves-effect waves-light"><i class="icofont icofont-pencil"></i></button></a>    
<a href="#delModal" data-id="' . $dt->id. '" data-toggle="modal"><button data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-mini waves-effect waves-light"><i class="icofont icofont-trash"></i></button></a> 
                
</td>
    
<td> {{ $dt->no_register }}</td>
    <td> {{ $dt->tgl_perolehan }}</td>
    <td> {{ $dt->kode_aset }}</td>
    <td> {{ $dt->harga }}</td>
    <td> {{ $dt->keterangan }}</td>
</tr>
@endforeach </tbody>
</table>

<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script>
       $(document).ready(function() {
$('#table_kib_a').dataTable( {
        "bInfo": false
        } ); } );
</script>