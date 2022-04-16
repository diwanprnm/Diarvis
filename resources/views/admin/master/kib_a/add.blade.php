@extends('admin.layout.index')

@section('title') Tanah (KIB A) @endsection
@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">
<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css">
<link rel="stylesheet" href="https://js.arcgis.com/4.18/esri/themes/light/main.css">
<link rel="stylesheet" href="{{ asset('assets/css/style_kib.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/chosen_v1.8.7/chosen.css') }}">
 

<style type="text/css">
 
 input[type=file]{

   display: inline;

 }

 #imgPreview{

    border:1px solid #ccc;
    margin-top:10px;
   padding: 10px;

 }

 #imgPreview img{

   width: 200px;

   padding: 5px;

 }

</style>
@endsection

@section('page-header')

<div class="row align-items-end">
                                        <div class="col-lg-8">
                                            <div class="page-header-title">
                                                <div class="d-inline">
                                                    <h4> Tambah Data Tanah KIB/A</h4>
                                                    <span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">User Profile</a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">User Profile</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
@endsection
 

@section('page-body') 
<form action="{{route('tanah.save')}}" method="post">
                    @csrf
<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5>Form KIB/A</h5>
               
                <div class="card-header-right">
                    <i class="icofont icofont-spinner-alt-5"></i>
                </div>
            </div>
            <div class="card-block">
                
                <form action="{{route('tanah.save')}}" method="post">
                        @csrf 
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                     
                        <div class="form-group row">
                        <label class="col-md-3 col-form-label">Unit</label>
                        <div class="col-md-9">
                        
                        <select name="unit" id="unit" class="form-control chosen-select">
                                <option>-</option>
                                    @foreach ($unit as $data)
                                    <option value="{{ $data->kode_unit.'_'.$data->kode_bidang }}">{{ $data->nama_unit }}</option>
                                    @endforeach
                                </select> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Sub Unit</label>
                        <div class="col-md-9">
                        <div id="loader_unit" style="display:none">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                            </div>
                        </div>
                        <select name="sub_unit" id="sub_unit" class="form-control chosen-select">
                        </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">UPB</label>
                        <div class="col-md-9">
                        <div id="loader_upb" style="display:none">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                            </div>
                        </div>
                        <select name="upb" id="upb" class="form-control chosen-select">
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Kode Pemilik</label>
                        <div class="col-md-9">
                             
                            <select name="kode_pemilik" id="kode_pemilik" class="form-control chosen-select">
                            <option>-</option>
                                @foreach ($kode_pemilik as $data)
                                <option value="{{ $data->kd_pemilik }}">{{ $data->kd_pemilik }} {{ $data->nm_pemilik }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                                <div id="loader" style="display:none">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                    </div>
                                </div>
                            
                        </div>    
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Kode Aset</label>
                        <div class="col-md-9">
                        <div class="col separated-input d-flex row">
                            <input type="text" id="kd_aset" name="kd_aset"  class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text" id="kd_aset0" name="kd_aset0" class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text" id="kd_aset1" name="kd_aset1" class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text" id="kd_aset2" name="kd_aset2" class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text" id="kd_aset3" name="kd_aset3" class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text"  id="kd_aset4" name="kd_aset4" class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text" id="kd_aset5" name="kd_aset5" class="form-control" style="width:40px"
                                placeholder="...">
                            <a data-toggle="modal" href="#modalAsset"  class="btn btn-info"><i class="icofont icofont-ui-search"></i></a>
                            <span id="nama_aset"></span>
                        </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">No Register</label>
                        <div class="col-md-6">
                        <div id="loader_noreg" style="display:none">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                    </div>
                                </div>
                        <input type="number" class="form-control" name="no_register"  id="no_register" readonly value="1">
                        </div>
                        <div class="col-sm-3">
                            <p><i>(Otomatis)</i></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Tanggal Pembelian</label>
   
                        <div class="col-sm-9">
                        <input class="form-control" name="tanggal_pembelian" type="date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Tanggal Pembukuan</label>
   
                        <div class="col-sm-9">
                        <input class="form-control" name="tanggal_pembukuan" type="date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Luas (M2)</label>
   
                        <div class="col-sm-9">
                        <input class="form-control" name="luas" type="text">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Alamat</label>
   
                        <div class="col-sm-9">
                        <textarea class="form-control" name="alamat"></textarea> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Hak Tanah</label>
   
                        <div class="col-sm-9">
                            <select name="hak_tanah" id="hak_tanah" class="form-control chosen-select">
                            <option></option>
                            <option value="Hak Pakai">Hak Pakai</option>
                            <option value="Hak Pengelolaan">Hak Pengelolaan</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Tanggal Sertifikat</label>
   
                        <div class="col-sm-9">
                        <input class="form-control" name="tanggal_sertifikat" type="date">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">No Sertifikat</label>
   
                        <div class="col-sm-9">
                        <input class="form-control" name="no_sertifikat" type="text">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Asal Usul</label>
   
                        <div class="col-sm-9">
                            <select name="asal_usul" id="asal_usul" class="form-control chosen-select">
                            <option></option>
                            <option value="Pembelian">Pembelian</option>
                            <option value="Hibah">Hibah</option>
                            </select>
                        </div>
                    </div>
                     
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Penggunaan</label>
   
                        <div class="col-sm-9">
                        <input class="form-control" name="penggunaan" type="text">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Harga</label>
   
                        <div class="col-sm-9">
                        <input class="form-control" name="harga" type="number">
                        </div>
                    </div>
                                  
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Keterangan</label>
   
                        <div class="col-sm-9">
                        <textarea class="form-control" name="keterangan"></textarea> 
                        </div>
                    </div>     
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Kabupaten/Kota</label>
   
                        <div class="col-sm-9">
                        <select name="kab_kota" id="kab_kota" class="form-control chosen-select">
                            <option>-</option>
                                @foreach ($kab_kota as $data)
                                <option value="{{ $data->kode_kab_kota }}">{{ $data->nama_kab_kota }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Kecamatan</label>
   
                        <div class="col-sm-9">
                        <div id="loader_kec" style="display:none">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                    </div>
                                </div>
                        <select name="kecamatan" id="kecamatan" class="form-control chosen-select">
                            <option>-</option>
                             </select>
                        </div>
                    </div>      
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Kelurahan/Desa</label>
   
                        <div class="col-sm-9">
                        <div id="loader_desa" style="display:none">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                    </div>
                                </div>
                        <select name="desa" id="desa" class="form-control chosen-select">
                            <option>-</option>
                             </select>
                        </div>
                    </div>                                    
                              
                      
                    </div>
                    
                </div>
            </div>

            
                                            <div class="col-xl-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Data KIB - A </h5>
                                                         
                                                        <div class="card-header-right">
                                                            <i class="icofont icofont-spinner-alt-5"></i>
                                                        </div>
                                                    </div>
                                                    <div class="card-block" style="overflow-x: auto" >
                                                    <div id="loader_kib_a" style="display:none">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                                        </div>
                                                    </div>
                                                         <table  class="table table-striped table-bordered able-responsive" id="table_kib_a">
                                                            <thead>
                                                                <tr>
                                                                    <th>No. Reg</th>
                                                                    <th>Tgl Perolehan</th>
                                                                    <th>Kode Barang</th>
                                                                    <th>Harga</th>
                                                                    <th>Uraian Aset</th>
                                                                </tr>
                                                            </thead>
                                                                 <tbody id="content_kib_a">
                                                                </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Lokasi</h5>
                                                         
                                                        <div class="card-header-right">
                                                            <i class="icofont icofont-spinner-alt-5"></i>
                                                        </div>
                                                    </div>
                                                    <div class="card-block" style="overflow-x: auto" >
                                                    <div id="loader_kib_a" style="display:none">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                                        </div>
                                                    </div>
                                                    <div id="mapLatLong" class="full-map mb-2" style="height: 300px; width: 100%"></div>
                                                                        Lat <input id="lat" name="lat" type="text" class="form-control formatLatLong fill" required="">
                                                                        Long <input id="long" name="lng" type="text" class="form-control formatLatLong fill" required="">     
                                                                   
                                                    </div>
                                                </div>
 
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Foto</h5>
                                                         
                                                        <div class="card-header-right">
                                                            <i class="icofont icofont-spinner-alt-5"></i>
                                                        </div>
                                                    </div>
                                                    <div class="card-block" style="overflow-x: auto" >
                                                    <div id="loader_kib_a" style="display:none">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                                        </div>
                                                    </div>

                                                             <input type="file" id="uploadFile" name="uploadFile[]" multiple/> 
                                                         
                                                        <div id="imgPreview" ></div>
                                                </div>

                                            </div>


                                            
                                        </div>
                                    
       
    </div>
    <div class="row">
    <div class="col-xl-12">
        <div class="card">

    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm btn-raund  waves-effect " data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-raund waves-effect waves-light ">Simpan</button>
                    </div>
</div></div></div>
                </form>
    
                <div class="modal fade" id="modalAsset" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
               
                    <div class="modal-header">
                        <h4 class="modal-title">Pemilihan Kode Barang</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Rincian Obyek</label>
                            <div class="col-md-8">
                            
                            <select name="rincian_obyek" id="rincian_obyek" class="form-control chosen-select">
                                    <option>-</option>
                                        @foreach ($rincian_object as $data)
                                        <option value="{{ $data->kd_aset1.'_'.$data->kd_aset3}}">{{ $data->nm_aset3 }}</option>
                                        @endforeach
                                    </select> 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Sub Rincian Obyek</label>
                            <div class="col-md-8">
                            <div id="loader_sro" style="display:none">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                </div>
                            </div>
                            <select name="sub_rincian_obyek" id="sub_rincian_obyek" class="form-control chosen-select">
                            </select> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Sub Sub Rincian Obyek</label>
                            <div class="col-md-8"> 
                            <div id="loader_ssro" style="display:none">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                </div>
                            </div>
                            <select name="sub_sub_rincian_obyek" id="sub_sub_rincian_obyek" class="form-control chosen-select">
                            </select> 
                            </div>
                        </div>

                        
                         
                    </div>
                    
            </div>
        </div>   
 @endsection
@section('script')

<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/js/jquery.mask.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/chosen_v1.8.7/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
 
<script src="https://js.arcgis.com/4.18/"></script>
<script>
    $(document).ready(function() {
        $(".chosen-select").chosen({
            width: '100%'
        }); 
        $('#table_kib_a').dataTable( {
        "bInfo": false
        } );
        $('#unit').on('change', function() {
       
            $.ajax({ 
            url: "{{route('tanah.sub-unit')}}",
            method: 'POST',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#loader_unit').show();
            },
            data: {kode_unit:this.value },

            success: function (data) {
                // On Success, build our rich list up and append it to the #richList div.
                $("select[name='sub_unit']").html('');
                $("select[name='sub_unit']").html(data.options);
                $("select[name='sub_unit']").trigger("chosen:updated");
            },
            complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                $('#loader_unit').hide();
            },
            });
        });

        $('#sub_unit').on('change', function() {
                
                $.ajax({ 
                url: "{{route('tanah.upb')}}",
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader_upb').show();
                },
                data: {kode_sub_unit:this.value },

                success: function (data) {
                    // On Success, build our rich list up and append it to the #richList div.
                    $("select[name='upb']").html('');
                    $("select[name='upb']").html(data.options);
                    $("select[name='upb']").trigger("chosen:updated");
                },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    $('#loader_upb').hide();
                },
            });
        });

        $('#upb').on('change', function() {
                
                $.ajax({ 
                url: "{{route('tanah.upb.filter.table')}}",
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader_kib_a').show();
                },
                data: {kode_upb:this.value },

                success: function (data) {
                    // On Success, build our rich list up and append it to the #richList div.
                    $("#content_kib_a").html(data.data);
                    //$('#content_kib_a').append(data.data);
                   // refreshTable();
                   //$('#table_kib_a').DataTable().ajax.reload();
                },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    $('#loader_kib_a').hide();
                },
            });
        });
        function refreshTable() {
  $('#table_kib_a').each(function() {
      dt = $(this).dataTable();
      dt.fnDraw();
  })
}
            

        $('#kode_pemilik2').on('change', function()  {
            $.ajax({ 
                url: "{{route('tanah.kode-pemilik')}}",
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader').show();
                },
                data: {kode_pemilik:this.value },

                success: function (data) {
                    // On Success, build our rich list up and append it to the #richList div.
                    $("#show_pemilik").html(data);
                    },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    $('#loader').hide();
                } 
                });
        }); 


        $('#rincian_obyek').on('change', function()  {
            $.ajax({ 
                url: "{{route('tanah.sub-rincian-obyek')}}",
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader_sro').show();
                },
                data: {rincian_obyek:this.value },

                success: function (data) {
                    // On Success, build our rich list up and append it to the #richList div.
                    $("select[name='sub_rincian_obyek']").html('');
                    $("select[name='sub_rincian_obyek']").html(data.options);
                    $("select[name='sub_rincian_obyek']").trigger("chosen:updated");
                    },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    $('#loader_sro').hide();
                } 
                });
        }); 

        $('#sub_rincian_obyek').on('change', function()  {
            $.ajax({ 
                url: "{{route('tanah.sub-sub-rincian-obyek')}}",
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader_ssro').show();
                },
                data: {rincian_obyek:this.value },

                success: function (data) {
                    // On Success, build our rich list up and append it to the #richList div.
                    $("select[name='sub_sub_rincian_obyek']").html('');
                    $("select[name='sub_sub_rincian_obyek']").html(data.options);
                    $("select[name='sub_sub_rincian_obyek']").trigger("chosen:updated");
                    },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    $('#loader_ssro').hide();
                } 
            });
        }); 

        $('#imageUploadForm').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                console.log("success");
                console.log(data);
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });
    }));

   
        $('#kab_kota').on('change', function()  {
            $.ajax({ 
                url: "{{route('tanah.get.kecamatan')}}",
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader_kec').show();
                },
                data: {kode_kab_kota:this.value },

                success: function (data) {
                    // On Success, build our rich list up and append it to the #richList div.
                    $("select[name='kecamatan']").html('');
                    $("select[name='kecamatan']").html(data.options);
                    $("select[name='kecamatan']").trigger("chosen:updated");
                    },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    $('#loader_kec').hide();
                } 
            });
        }); 

        $('#kecamatan').on('change', function()  {
            $.ajax({ 
                url: "{{route('tanah.get.desa')}}",
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader_desa').show();
                },
                data: {kode_kecamatan:this.value },

                success: function (data) {
                    // On Success, build our rich list up and append it to the #richList div.
                    $("select[name='desa']").html('');
                    $("select[name='desa']").html(data.options);
                    $("select[name='desa']").trigger("chosen:updated");
                    },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    $('#loader_desa').hide();
                } 
            });
        }); 


        $('#sub_sub_rincian_obyek').on('change', function()  {
            var v = this.value;
            
            var dt = v.split("_");
            $("#kd_aset").attr("value",dt[0]);
            $("#kd_aset0").attr("value",dt[1]);
            $("#kd_aset1").attr("value",dt[2]);
            $("#kd_aset2").attr("value",dt[3]);
            $("#kd_aset3").attr("value",dt[4]);
            $("#kd_aset4").attr("value",dt[5]);
            $("#kd_aset5").attr("value",dt[6]);
            $("#nama_aset").html(dt[7]);
            $('#modalAsset').modal('toggle');
            $.ajax({ 
                url: "{{route('tanah.noregister')}}",
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader_noreg').show();
                },
                data: {kd_aset:dt[0],kd_aset0:dt[1],kd_aset1:dt[2],kd_aset2:dt[3],kd_aset3:dt[4],kd_aset4:dt[5],kd_aset5:dt[6] },

                success: function (data) {
                    // On Success, build our rich list up and append it to the #richList div.
                    $("input[name='no_register']").attr("value",data.no_register);
                    },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    $('#loader_noreg').hide();
                } 
            });

            return false;
        });    
    

        $("#uploadFile").change(function(){  
            $('#imgPreview').html(""); 
            var total_file=document.getElementById("uploadFile").files.length; 
                for(var i=0;i<total_file;i++)  { 
                 $('#imgPreview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'>"); 
                } 
            }); 

            

        $('#mapLatLong').ready(() => {
            require([
            "esri/Map",
            "esri/views/MapView",
            "esri/Graphic"
            ], function(Map, MapView, Graphic) {

                const map = new Map({
                    basemap: "osm"
                });

                const view = new MapView({
                    container: "mapLatLong",
                    map: map,
                    center: [107.6191, -6.9175],
                    zoom: 8,
                });

                let tempGraphic;
                view.on("click", function(event){
                    if($("#lat").val() != '' && $("#long").val() != ''){
                        view.graphics.remove(tempGraphic);
                    }
                    var graphic = new Graphic({
                        geometry: event.mapPoint,
                        symbol: {
                            type: "picture-marker", // autocasts as new SimpleMarkerSymbol()
                            url: "http://esri.github.io/quickstart-map-js/images/blue-pin.png",
                            width: "14px",
                            height: "24px"
                        }
                    });
                    tempGraphic = graphic;
                    $("#lat").val(event.mapPoint.latitude);
                    $("#long").val(event.mapPoint.longitude);

                    view.graphics.add(graphic);
                });
                $("#lat, #long").keyup(function () {
                    if($("#lat").val() != '' && $("#long").val() != ''){
                        view.graphics.remove(tempGraphic);
                    }
                    var graphic = new Graphic({
                        geometry: {
                            type: "point",
                            longitude: $("#long").val(),
                            latitude: $("#lat").val()
                        },
                        symbol: {
                            type: "picture-marker", // autocasts as new SimpleMarkerSymbol()
                            url: "http://esri.github.io/quickstart-map-js/images/blue-pin.png",
                            width: "14px",
                            height: "24px"
                        }
                    });
                    tempGraphic = graphic;

                    view.graphics.add(graphic);
                });
            });
        }); 
    });

</script>
@endsection
