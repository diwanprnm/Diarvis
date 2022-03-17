@extends('admin.layout.index')

@section('title') Laporan Rencana Kebutuhan barang @endsection
@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/chosen_v1.8.7/chosen.css') }}">
<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css">

<style>
    table.table-bordered tbody td {
        word-break: break-word;
        vertical-align: top;
    }
</style>
@endsection

@section('page-header')

<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Laporan Rencana Kebutuhan barang</h4>
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
                <li class="breadcrumb-item"><a href="#!">Unit organisasi</a>
                </li>
                <li class="breadcrumb-item"><a href="#">Unit</a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('filter')
<div class="card">

    <div class="accordion-panel">
        <div class="accordion-heading" role="tab" id="headingOne">
            <h3 class="card-title accordion-title">
                <a class="accordion-msg  " aria-selected="true" aria-expanded="true"data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <span class="ui-accordion-header-icon ui-icon zmdi zmdi-chevron-up"></span>
                Laporan Rencana Kebutuhan Barang
                </a>
            </h3>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in show" role="tabpanel" aria-labelledby="headingOne">
            <div class="accordion-content accordion-desc">

            <h4 class="sub-title"></h4>

                <form  action="{{route('generateReportRKB')}}" method="post" >
                    @csrf
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="modal-body">
                    <div class="row">    
                        <div class="col-sm-5">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Pilih Laporan</label>
                                <div class="col-md-9">
                                    <select class="form-control chosen-select"   id="jenis_laporan" name="jenis_laporan">
                                        <option value="" >Tampilkan Semua</option>
                                        @foreach ($laporan as $data)
                                       <?php if($filter['jenis_laporan'] == $data->id) {  ?>
                                        <option  value="{{ $data->id }}" selected>{{ $data->nama_laporan }}</option>
                                        <?php } else  { ?>
                                            <option  value="{{ $data->id }}">{{ $data->nama_laporan }}</option>
                                        <?php } ?>    
                                        @endforeach
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Footer </label>
                                <div class="col-md-9">
                                    <input name="footer" type="text"  value="{{ !empty($filter['footer']) ?$filter['footer'] : '' }}"  id="footer" class="form-control"  required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Tanggal </label>
                                <div class="col-md-9">
                                <div class="form-group row">
                                     <div class="col-md-6">
                                        <input name="tanggal_dari" type="date"   id="tanggal_dari" class="form-control"  >
                                     </div>
                                     <div class="col-md-6">
                                     <input name="tanggal_ke" type="date"   id="tanggal_ke" class="form-control"  >
                                     </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                           

                            
                      
                        <div class="col-sm-7">
                            <div class="form-group row">
                                    <label class="col-md-4 col-form-label">Bidang</label>
                                    <div class="col-md-8">
                                    <select class="form-control chosen-select" id="bidang" name="bidang">
                                            <option value="" >Tampilkan Semua</option>
                                            @foreach ($bidang as $data)
                                            <?php if($filter['bidang'] == $data->kode_bidang) {  ?>
                                                <option  value="{{ $data->kode_bidang }}" selected>{{ $data->nama_bidang }}</option>
                                        <?php } else { ?>
                                            <option  value="{{ $data->kode_bidang }}">{{ $data->nama_bidang }}</option>
                                            <?php } ?>
                                            @endforeach
                                        </select> 
                                    </div>
                            </div>
                            <div class="form-group row">
                                    <label class="col-md-4 col-form-label">Unit/Perangkat Daerah</label>
                                    <div class="col-md-8" id="show_unit">
                                    <div id="loader" style="display:none">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                        </div>
                                    </div>
                                        <select class="form-control chosen-select" id="unit" name="unit">
                                        <option value="" >Tampilkan Semua</option>
                                        @if(!empty($unit))
                                        @foreach ($unit as $data)
                                            <?php if($filter['unit'] == $data->kode_unit) {  ?>
                                                <option  value="{{ $data->kode_unit }}" selected>{{ $data->nama_unit }}</option>
                                        <?php } else { ?>
                                            <option  value="{{ $data->kode_unit }}">{{ $data->nama_unit }}</option>
                                            <?php } ?>
                                        @endforeach
                                        @endif
                                        </select>
                                    
                                    </div>
                            </div>
                            <div class="form-group row">
                                    <label class="col-md-4 col-form-label">Sub Unit</label>
                                    <div class="col-md-8" id="show_unit">
                                    <div id="loadersu" style="display:none">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                        </div>
                                    </div>
                                        <select class="form-control chosen-select" id="sub_unit" name="sub_unit">
                                        <option value="">Tampilkan Semua</option>
                                        @if(!empty($sub_unit))
                                        @foreach ($sub_unit as $data)
                                            <?php if($filter['sub_unit'] == $data->kode_sub_unit) {  ?>
                                                <option  value="{{ $data->kode_sub_unit }}" selected>{{ $data->nama_sub_unit }}</option>
                                        <?php } else { ?>
                                            <option  value="{{ $data->kode_sub_unit }}">{{ $data->nama_sub_unit }}</option>
                                            <?php } ?>
                                        @endforeach
                                        @else
                                        <option value="">no array</option>
                                        @endif
                                        </select>
                                    
                                    </div>
                            </div>
                        
                    </div>            
                         
                        

                        
                    </div>

                    </div>

                    <div class="modal-footer"> 
                          <button type="submit"  class="btn btn-sm btn-round btn-primary mb-3"><i class="icofont icofont-file-pdf"></i> Preview Laporan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-body')
<div class="row">
    <div class="col-sm-12">


        <div class="card">


            <div class="card-block" id="show_content">
            
            @if(!empty($param))
            <iframe src="{{ url('admin/laporan/perencanaan/previewLaporanRKB/').'/'.$param }} " frameborder='0' height='465px' width='100%' scrolling='no'>pilih filter terlebih dahulu</iframe>
            @else 
            <div class="alert alert-info icons-alert">
           {{-- <img src="{{ asset('assets/icon/report.png') }}" style="width:100px"  alt="User-Profile-Image"> --}}                  
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="icofont icofont-close-line-circled"></i>
                </button>
                <p>Silahkan lengkapi form laporan rencana kebutuhan barang terlebih dahulu !</p>
            </div>
            
            @endif
        </div>
        </div>
    </div>
</div></div>
@endsection
@section('script')  
   
<script type="text/javascript" src="{{ asset('assets/vendor/chosen_v1.8.7/chosen.jquery.js') }}" type="text/javascript"></script>

<script>
    $(document).ready(function() {

        $(".chosen-select").chosen({
            width: '100%'
        });

       

            

         
        $('#bidang').on('change', function() {
       
            $.ajax({ 
            url: "{{ url('admin/laporan/perencanaan/getunitfiter') }}",
            method: 'POST',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
 		    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#loader').show();
            },
            data: {kode_bidang:this.value },
	
            success: function (data) {
                // On Success, build our rich list up and append it to the #richList div.
                $("select[name='unit']").html('');
                $("select[name='unit']").html(data.options);
                $("select[name='unit']").trigger("chosen:updated");
            },
            complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                $('#loader').hide();
            },
        });

        $('#unit').on('change', function() {
       
        $.ajax({ 
        url: "{{ url('admin/laporan/perencanaan/getsubunitfiter') }}",
        method: 'POST',
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
            $('#loadersu').show();
        },
        data: {kode_unit:this.value },

        success: function (data) {
            // On Success, build our rich list up and append it to the #richList div.
            $("select[name='sub_unit']").html('');
            $("select[name='sub_unit']").html(data.options);
            $("select[name='sub_unit']").trigger("chosen:updated");
        },
        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
            $('#loadersu').hide();
        }});
    });



        $("#myReport").submit(function(e) {

            //prevent Default functionality
            e.preventDefault();

            var actionurl = e.currentTarget.action;
            var jenis_laporan = $("#jenis_laporan").val();
            var footer = $("#footer").val();
            var bidang = $("#bidang").val();
            var unit= $("#unit").val();
            $.ajax({ 
            url: actionurl,
            method: 'POST',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#loader').show();
            },
            data: {jenis_laporan: jenis_laporan, footer:footer, bidang:bidang, unit:unit},

            success: function (data) {
                // On Success, build our rich list up and append it to the #richList div.
                $("#show_content").html(tag);

             },
            complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                $('#loader').hide();
            }
            });

        });});

         // On click, execute the ajax call.
         

        });

           
</script>
@endsection