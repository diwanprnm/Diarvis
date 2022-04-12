<option>--- Pilih Sub Sub Rincian Obyek  ---</option>
@if(!empty($sub_sub_rincian_obyek))
@foreach ($sub_sub_rincian_obyek as $data)                
<option  value="{{ $data->kd_aset.'_'.$data->kd_aset0.'_'.$data->kd_aset1.'_'.$data->kd_aset2.'_'.$data->kd_aset3.'_'.$data->kd_aset4.'_'.$data->kd_aset5}}">{{ $data->nm_aset5 }}</option> 
@endforeach
@endif