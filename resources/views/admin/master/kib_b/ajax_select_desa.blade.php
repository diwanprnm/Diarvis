<option>--- Pilih Kelurahan/Desa  ---</option>
@if(!empty($desa))
@foreach ($desa as $data)                
<option  value="{{ $data->kode_desa}}">{{ $data->nama_desa }}</option> 
@endforeach
@endif