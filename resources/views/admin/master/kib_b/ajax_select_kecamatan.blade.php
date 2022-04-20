<option>--- Pilih Kecamatan  ---</option>
@if(!empty($kecamatan))
@foreach ($kecamatan as $data)                
<option  value="{{ $data->kode_kecamatan}}">{{ $data->nama_kecamatan }}</option> 
@endforeach
@endif