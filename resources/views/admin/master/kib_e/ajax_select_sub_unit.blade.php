<option>--- Pilih Sub Unit  ---</option>
@if(!empty($sub_unit))
@foreach ($sub_unit as $data)                
<option  value="{{ $data->kode_bidang.'_'.$data->kode_unit.'_'.$data->kode_sub_unit }}">{{ $data->nama_sub_unit }}</option> 
@endforeach
@endif