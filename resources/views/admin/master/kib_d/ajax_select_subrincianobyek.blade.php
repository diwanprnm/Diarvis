<option>--- Pilih Sub Rincian Obyek  ---</option>
@if(!empty($sub_rincian_obyek))
@foreach ($sub_rincian_obyek as $data)                
<option  value="{{ $data->kd_aset1.'_'.$data->kd_aset4}}">{{ $data->nm_aset4 }}</option> 
@endforeach
@endif