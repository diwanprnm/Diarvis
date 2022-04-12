<option>--- Pilih UPB  ---</option>
@if(!empty($upb))
@foreach ($upb as $data)                
<option  value="{{ $data->kode_upb }}">{{ $data->nama_upb }}</option> 
@endforeach
@endif