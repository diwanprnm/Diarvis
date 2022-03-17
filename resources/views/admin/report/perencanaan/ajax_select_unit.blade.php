<option>--- Pilih Unit  ---</option>
@if(!empty($unit))
@foreach ($unit as $data)                
<option  value="{{ $data->kode_unit }}">{{ $data->nama_unit }}</option> 
@endforeach
@endif