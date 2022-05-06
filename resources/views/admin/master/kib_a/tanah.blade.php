@extends('admin.layout.index')

@section('title') Tanah (KIB A) @endsection
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
    <div class="col-lg-10">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Tanah (KIB A)</h4>
                <span></span>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Intra</a>
                </li>
                <li class="breadcrumb-item"><a href="#">KIB-A</a>
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
                <a class="accordion-msg" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class="icofont icofont-ui-search"></i>  Pencarian Data
                </a>
            </h3>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="accordion-content accordion-desc">
                <form action="{{route('getTanah')}}" method="post">
                    @csrf
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">ID Pemda</label>
                                    <div class="col-md-9">
<<<<<<< HEAD
                                    <input name="id_pemda" id="id_pemda" value="{{(!empty($filter['id_pemda'])) ? $filter['id_pemda'] :''}}"  type="text" class="form-control"  >
=======

>>>>>>> e0ad1e26aba42336d0ca2cf751c108869f5e621b
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Kode Aset</label>
                                    <div class="col-md-9">
                                        <div class="col separated-input d-flex row">
                                            <input type="text" id="kd_aset" name="kd_aset" value="{{(!empty($filter['kd_aset'])) ? $filter['kd_aset'] :''}}" class="form-control" style="width:40px"
                                                placeholder="...">
                                            <input type="text" id="kd_aset0" name="kd_aset0" value="{{(!empty($filter['kd_aset0'])) ? $filter['kd_aset0'] :''}}" class="form-control" style="width:40px"
                                                placeholder="...">
                                            <input type="text" id="kd_aset1" name="kd_aset1" value="{{(!empty($filter['kd_aset1'])) ? $filter['kd_aset1'] :''}}" class="form-control" style="width:40px"
                                                placeholder="...">
                                            <input type="text" id="kd_aset2" name="kd_aset2" value="{{(!empty($filter['kd_aset2'])) ? $filter['kd_aset2'] :''}}" class="form-control" style="width:40px"
                                                placeholder="...">
                                            <input type="text" id="kd_aset3" name="kd_aset3" value="{{(!empty($filter['kd_aset3'])) ? $filter['kd_aset3'] :''}}" class="form-control" style="width:40px"
                                                placeholder="...">
                                            <input type="text"  id="kd_aset4" name="kd_aset4" value="{{(!empty($filter['kd_aset4'])) ? $filter['kd_aset4'] :''}}" class="form-control" style="width:40px"
                                                placeholder="...">
                                            <input type="text" id="kd_aset5" name="kd_aset5" value="{{(!empty($filter['kd_aset5'])) ? $filter['kd_aset5'] :''}}" class="form-control" style="width:40px"
                                                placeholder="...">
                                            <a data-toggle="modal" href="#modalAsset"  class="btn btn-info"><i class="icofont icofont-ui-search"></i></a>
                                            <span id="nama_aset"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">No Register</label>
                                    <div class="col-md-9">
                                    <input name="f_no_register" id="f_no_register" value=" " type="number" class="form-control"  >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Tanggal Pembelian</label>
                                    <div class="col-md-4">
                                    <input name="f_from_tgl_pembelian" id="f_from_tgl_pembelian" value="" placeholder="Dari" type="date" class="form-control"  >
                                    </div>
                                    <div class="col-md-4">
                                    <input name="f_to_tgl_pembelian" id="f_to_tgl_pembelian" value="" type="date" placeholder="Hingga" class="form-control"  >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Tanggal Pembukuan</label>
                                    <div class="col-md-4">
                                    <input name="f_from_tgl_pembukuan" id="f_from_tgl_pembukuan" value="" placeholder="Dari" type="date" class="form-control"  >
                                    </div>
                                    <div class="col-md-4">
                                    <input name="f_to_tgl_pembukuan" id="f_to_tgl_pembukuan" value="" type="date" placeholder="Hingga" class="form-control"  >
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Luas (M2)</label>
                                    <div class="col-md-9">
                                        <input name="f_luas" type="text"  id="f_luas" class="form-control"  >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Alamat</label>
                                    <div class="col-md-9">
                                        <input name="f_alamat" type="text"  id="f_alamat" class="form-control"  >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Hak Tanah</label>
                                    <div class="col-md-9">
                                    <select name="f_hak_tanah" id="f_hak_tanah" class="form-control chosen-select">
                                            <option></option>
                                            <option value="Hak Pakai">Hak Pakai</option>
                                            <option value="Hak Pengelolaan">Hak Pengelolaan</option>
                                            </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Nomor Sertifikat</label>
                                    <div class="col-md-9">
                                        <input name="f_no_sertifikat" type="text"  id="f_no_sertifikat" class="form-control"  >
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
                        <label class="col-md-3 col-form-label">Harga</label>  
                            <div class="col-sm-3">
                            <select name="f_operasi" id="f_operasi" class="form-control chosen-select">
                                    <option></option>
                                    <option value="="> = </option>
                                    <option value=">="> >= </option>
                                    <option value="<="> <= </option>
                                    </select>
                            </div>
                            <div class="col-sm-6">
                            <input class="form-control" name="harga" type="number">
                            </div>
                        </div>    
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"  class="btn btn-sm btn-round btn-info mb-3"><i class="icofont icofont-ui-search"></i> Cari</button>
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
            <div class="card-block">
                @if (hasAccess(Auth::user()->role_id, "Unit", "Create"))
                <a  href="{{route('tanah.add')}}" class="btn btn-sm btn-round btn-info mb-3"><i class="icofont icofont-plus-circle"></i> Tambah Tanah (KIB A)</a>
                @endif
                <div class="dt-responsive table-responsive">
                    <table id="dttable" class="table table-striped table-bordered able-responsive">
                        <thead>
                            <tr>
                                <th>No</th>

                                <th>Id Pemda</th>
                                <th>Kode Pemilik</th>
                                <th>Kode Aset</th>
                                <th>No Register</th>
                                <th>Tgl Pembelian</th>
                                <th>Tgl Pembukuan</th>
                                <th>Luas (m2)</th>
                                <th>Alamat</th>
                                <th>Hak Tanah</th>
                                <th>Tgl Sertifikat</th>
                                <th>No Sertifikat</th>
                                <th>Asal Usul</th>
                                <th>Penggunaan</th>
                                <th>Harga</th>
                                <!-- <th>Foto</th> -->
                                <th style="min-width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyTanah">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-only">

    @if (hasAccess(Auth::user()->role_id, "Unit", "Create"))
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{route('saveUnit')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Unit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Bidang</label>
                            <div class="col-md-9">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Kode Unit</label>
                            <div class="col-md-9">
                                <input name="kode_unit" type="number" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Unit</label>
                            <div class="col-md-9">
                                <input name="nama_unit" type="text" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm btn-raund  waves-effect " data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-raund waves-effect waves-light ">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    @if (hasAccess(Auth::user()->role_id, "Unit", "Update"))
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{route('updateUnit')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Ubah Data Unit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <input type="hidden" id="unit_id" name="unit_id" />
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Bidang</label>
                            <div class="col-md-9">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Kode Unit</label>
                            <div class="col-md-9">
                                <input name="kode_unit" type="number" id="kode_unit2" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Unit</label>
                            <div class="col-md-9">
                                <input name="nama_unit" id="nama_unit2" type="text" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm btn-raund  waves-effect " data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-raund waves-effect waves-light ">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

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

    @if (hasAccess(Auth::user()->role_id, "Unit", "Delete"))
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Konfirmasi Hapus Data </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm waves-effect " data-dismiss="modal">Tutup</button>
                    <a id="delHref" href="" class="btn btn-danger  btn-sm waves-effect waves-light ">Hapus</a>
                </div>
            </div>
        </div>
    </div>
    @endif
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

<script>
    $(document).ready(function() {
        $(".chosen-select").chosen({
            width: '100%'
        });
        var table = $('#dttable').DataTable({
            processing: true,
            serverSide: true,
            bFilter: false,
            ajax: {
                url: "{{ url('admin/master-data/barang/intra/tanah') }}",
                data: function (d) {
                    d.id_pemda = $("#id_pemda").val(),
                    d.kd_aset = $("#kd_aset").val(),
                    d.kd_aset0 = $("#kd_aset0").val(),
                    d.kd_aset1 = $("#kd_aset1").val(),
                    d.kd_aset2 = $("#kd_aset2").val(),
                    d.kd_aset3 = $("#kd_aset3").val(),
                    d.kd_aset4 = $("#kd_aset4").val(),
                    d.kd_aset5 = $("#kd_aset5").val(),
                    d.no_register = $("#no_register").val()
                  
                }
               
            },

            columns: [{
                    'mRender': function(data, type, full, meta) {
                        return +meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                 {
                    data: 'id',
                    name: 'id_pemda'
                },
                {
                    data: 'nm_pemilik',
                    name: 'nama_pemilik'
                },
                {
                    data: 'kode_aset',
                    name: 'kode Aset'
                },
                {
                    data: 'no_register',
                    name: 'no_register'
                },
                {
                    data: 'tgl_perolehan',
                    name: 'tgl_pembelian'
                },
                {
                    data: 'tgl_pembukuan',
                    name: 'tgl_pembukuan'
                },
                {
                    data: 'luas_m2',
                    name: 'luas_m2'
                },
                {
                    data: 'alamat',
                    name: 'alamat'
                },
                {
                    data: 'hak_tanah',
                    name: 'hak_tanah'
                },
                {
                    data: 'sertifikat_tanggal',
                    name: 'tgl_sertifikat'
                },
                {
                    data: 'sertifikat_nomor',
                    name: 'no_sertifikat'
                },
                {
                    data: 'asal_usul',
                    name: 'asal_usul'
                },
                {
                    data: 'penggunaan',
                    name: 'penggunaan'
                },
                {
                    data: 'harga',
                    name: 'harga'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });


    @if(hasAccess(Auth::user()->role_id, "Unit", "Update"))
    $('#editModal').on('show.bs.modal', function(event) {
        const link = $(event.relatedTarget);
        const id = link.data('id');
        console.log(id);
        const baseUrl = `{{ url('admin/master-data/unit-organisasi/unit/getUnitById/') }}` + '/' + id;
        $.get(baseUrl,
            function(response) {
                const data = response.data;
                showData(data);
            });
    });

    function showData(data) {
        $(".chosen-select").val(data.kode_bidang).trigger('chosen:updated');
        $("#kode_unit2").val(data.kode_unit);
        $("#nama_unit2").val(data.nama_unit);
        $("#unit_id").val(data.id);
    }

    @endif
    $('#delModal').on('show.bs.modal', function(event) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const link = $(event.relatedTarget);
        const id = link.data('id');
        console.log(id);
        const url = `{{ url('admin/master-data/barang/intra/tanah/delete') }}/` + id;
        console.log(url);
        const modal = $(this);
        modal.find('.modal-footer #delHref').attr('href', url);
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
            

            return false;
        });   

</script>
@endsection
