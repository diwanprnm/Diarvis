<option>--- Pilih UPB  ---</option>
@if(!empty($upb))
@foreach ($upb as $data)                
<option  value="{{ $data->kode_bidang.'_'.$data->kode_unit.'_'.$data->kode_sub_unit.'_'.$data->kode_upb }}">{{ $data->nama_upb }}</option> 
@endforeach
@endif
