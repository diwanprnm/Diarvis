@extends('admin.layout.index')

@section('title') Gedung dan Bangunan (KIB C)@endsection
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
    .separated-input > input {
        margin-right: 2px;
        text-align: center;
    }

    .col-md-4, .col-md-1 {
        align-items: center;
        display: flex;
    }
</style>
@endsection

@section('page-header')

<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4> Gedung dan Bangunan (KIB C)</h4>
                <span></span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-1.htm"><i class="feather icon-home"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Data Barang</a>
                </li>
                <li class="breadcrumb-item"><a href="#">Intra</a>
                </li>
                <li class="breadcrumb-item active"><a href="#">Gedung dan Bangunan</a></li>
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
                <form action="{{ route('getGedung') }}" method="post">
                    @csrf
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="id_pemda">ID Pemda</label>
                                    <div class="col-md-9">
                                        <input name="id_pemda" id="id_pemda" value="{{ (!empty($filter['id_pemda'])) ? $filter['id_pemda'] : '' }}" type="text" class="form-control" placeholder="Masukkan ID Pemda . . .">
                                    </div>
                                </div>
                                <div class="form-group row d-flex">
                                    <label class="col-md-3 col-form-label align-items-center">Kode Aset</label>
                                    <div class="col-md-9">
                                        <div class="col separated-input row" style="padding: 0px !important; margin: 0px !important;">
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
                                            <a data-toggle="modal" href="#modalAsset" class="btn btn-info" style="text-align: center; padding: 0px 10px !important;">
                                                <i style="line-height: 32px; margin-right: 0px !important;" class="icofont icofont-ui-search"></i>
                                            </a>
                                            <span id="nama_aset"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="no_register">No Register</label>
                                    <div class="col-md-9">
                                        <input name="no_register" id="no_register" value="{{ (!empty($filter['no_register'])) ? $filter['no_register'] : '' }}" type="text" class="form-control" placeholder="Masukkan No Register . . .">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Tanggal Pembelian</label>
                                    <div class="col-md-4">
                                        <input name="f_from_tgl_pembelian" id="f_from_tgl_pembelian" value="{{ (!empty($filter['f_from_tgl_pembelian'])) ? $filter['f_from_tgl_pembelian'] : '' }}" placeholder="Dari" type="date" class="form-control"  >
                                    </div>
                                    <div class="col-md-1" style="padding: 0 !important; display: flex; justify-content: center;">
                                        <p style="margin-bottom: 0; text-align: center;">s/d</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input name="f_to_tgl_perolehan" id="f_to_tgl_perolehan" value="{{ (!empty($filter['f_to_tgl_perolehan'])) ? $filter['f_to_tgl_perolehan'] : '' }}" type="date" placeholder="Hingga" class="form-control"  >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Tanggal Pembukuan</label>
                                    <div class="col-md-4">
                                        <input name="f_from_tgl_pembukuan" id="f_from_tgl_pembukuan" value="{{ (!empty($filter['f_from_tgl_pembukuan'])) ? $filter['f_from_tgl_pembukuan'] : '' }}" placeholder="Dari" type="date" class="form-control"  >
                                    </div>
                                    <div class="col-md-1" style="padding: 0 !important; display: flex; justify-content: center;">
                                        <p style="margin-bottom: 0; text-align: center;">s/d</p>
                                    </div>
                                    <div class="col-md-4">
                                        <input name="f_to_tgl_pembukuan" id="f_to_tgl_pembukuan" value="{{ (!empty($filter['f_to_tgl_pembukuan'])) ? $filter['f_to_tgl_pembukuan'] : '' }}" type="date" placeholder="Hingga" class="form-control"  >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Bertingkat Tidak</label>
                                    <div class="col-sm-9">
                                        <select name="bertingkat_tidak" id="bertingkat_tidak" class="form-control chosen-select">
                                            <option value=''>Pilih</option>
                                            <option {{ $filter['bertingkat_tidak'] == "1" ? "selected" : '' }} value="1">Ya</option>
                                            <option {{ $filter['bertingkat_tidak'] == "0" ? "selected" : '' }} value="0">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Beton Tidak</label>
                                    <div class="col-sm-9">
                                        <select name="beton_tidak" id="beton_tidak" class="form-control chosen-select">
                                            <option value=''>Pilih</option>
                                            <option {{ $filter['beton_tidak'] == "1" ? "selected" : '' }} value="1">Ya</option>
                                            <option {{ $filter['beton_tidak'] == "0" ? "selected" : '' }} value="0">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Luas Lantai(M2)</label>
                                    <div class="col-md-9">
                                        <input name="f_luas_lantai" type="text"  id="f_luas_lantai" class="form-control"  >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Lokasi</label>
                                    <div class="col-md-9">
                                        <input name="f_lokasi" type="text"  id="f_lokasi" class="form-control"  >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Nomor Dokumen</label>
                                    <div class="col-md-9">
                                        <input name="f_no_dokumen" type="text"  id="f_no_dokumen" class="form-control"  >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Status Tanah</label>
                                    <div class="col-md-9">
                                    <select name="f_status_tanah" id="f_status_tanah" class="form-control chosen-select">
                                            <option></option>
                                            <option value="Tanah Milik Pemda">Tanah Milik Pemda</option>
                                            <option value="Tanah Hak Pakai">Tanah Hak Pakai</option>
                                            <option value="Tanah Milik Negara">Tanah Milik Negara</option>
                                            <option value="Tanah Hak Ulayat">Tanah Hak Ulayat</option>
                                            <option value="Hak Pengelolaan">Tanah Hak Pengelolaan</option>
                                            <option value="Tanah Hak Guna Banguna">Tanah Hak Guna Bangunan</option>
                                            <option value="Tanah Hak Lainnya">Tanah Hak Lainnya</option>
                                            </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Asal Usul</label>
                                    <div class="col-sm-9">
                                        <select name="asal_usul" id="asal_usul" class="form-control chosen-select">
                                            <option value=''>Pilih Asal Usul</option>
                                            <option {{ $filter['asal_usul'] == "Pembelian" ? "selected" : '' }} value="Pembelian">Pembelian</option>
                                            <option {{ $filter['asal_usul'] == "Hibah" ? "selected" : '' }} value="Hibah">Hibah</option>
                                        </select>
                                    </div>
                                </div>
        
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Harga</label>
                                    <div class="col-sm-4">
                                         <select name="f_operasi" id="f_operasi" class="form-control chosen-select">
                                            <option value=''>Pilih Harga</option>
                                            <option {{ $filter['f_operasi'] == "=" ? "selected" : '' }} value="=">=</option>
                                            <option {{ $filter['f_operasi'] == ">=" ? "selected" : '' }} value=">=">>=</option>
                                            <option {{ $filter['f_operasi'] == "<=" ? "selected" : '' }} value="<="><=</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <input class="form-control" name="harga" id="harga" value="{{ (!empty($filter['harga'])) ? $filter['harga'] : '' }}" type="number" placeholder="Masukkan Harga . . .">
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
                <a  href="{{route('gedung.add')}}" class="btn btn-sm btn-round btn-primary mb-3"><i class="icofont icofont-plus-circle"></i> Tambah Gedung dan Bangunan (KIB C)</a>
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
                                <th>Tgl Perolehan</th>
                                <th>Tgl Pembukuan</th>
                                <th>Bertingkat Tidak</th>
                                <th>Beton Tidak</th>
                                <th>Luas Lantai(M2)</th>
                                <th>Lokasi</th>
                                <th>Dokumen Tanggal</th>
                                <th>Dokumen Nomor</th>
                                <th>Status Tanah</th>
                                <th>Kode Tanah</th>
                                <th>Asal-usul</th>
                                <th>Kondisi</th>
                                <th>Masa Manfaat</th>
                                <th>Nilai Sisa</th>
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
                            <select name="sub_rincian_obyek" id="sub_rincian_obyek" class="form-control chosen-select"></select>
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
                            <select name="sub_sub_rincian_obyek" id="sub_sub_rincian_obyek" class="form-control chosen-select"></select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (hasAccess(Auth::user()->role_id, "Bidang", "Delete"))
        <div class="modal fade" id="delModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
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
                url: "{{ url('admin/master-data/barang/intra/gedung') }}",
                data:function(d){
                    d.id_pemda = $("#id_pemda").val(),
                    d.kd_aset = $("#kd_aset").val(),
                    d.kd_aset0 = $("#kd_aset0").val(),
                    d.kd_aset1 = $("#kd_aset1").val(),
                    d.kd_aset2 = $("#kd_aset2").val(),
                    d.kd_aset3 = $("#kd_aset3").val(),
                    d.kd_aset4 = $("#kd_aset4").val(),
                    d.kd_aset5 = $("#kd_aset5").val(),
                    d.no_register = $("#no_register").val(),
                    d.f_from_tgl_pembelian = $("#f_from_tgl_pembelian").val(),
                    d.f_to_tgl_pembelian = $("#f_to_tgl_pembelian").val(),
                    d.f_from_tgl_pembukuan = $("#f_from_tgl_pembukuan").val(),
                    d.f_to_tgl_pembukuan = $("#f_to_tgl_pembukuan").val(),
                    d.bertingkat_tidak = $("#bertingkat_tidak").val(),
                    d.beton_tidak = $("#beton_tidak").val(),
                    d.f_luas_lantai = $("#f_luas_lantai").val(),
                    d.f_lokasi = $("#f_lokasi").val(),
                    d.f_no_dokumen = $("#f_no_dokumen").val(),
                    d.f_status_tanah= $("#f_status_tanah").val(),
                    d.asal_usul=$("#asal_usul").val(),
                    d.f_operasi=$("f_operasi").val(),
                    d.harga= $("#harga").val()

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
                    data: 'pemilik',
                    name: 'pemilik'
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
                    name: 'tgl_perolehan'
                },
                {
                    data: 'tgl_pembukuan',
                    name: 'tgl_pembukuan'
                },
                {
                    data: 'bertingkat_tidak',
                    name: 'bertingkat_tidak'
                },
                {
                    data: 'beton_tidak',
                    name: 'beton_tidak'
                },
                {
                    data: 'luas_lantai',
                    name: 'luas_lantai'
                },
                {
                    data: 'lokasi',
                    name: 'lokasi'
                },
                {
                    data: 'dokumen_tanggal',
                    name: 'dokumen_tanggal'
                },
                {
                    data: 'dokumen_nomor',
                    name: 'dokumen_nomor'
                }, 
                {
                    data: 'status_tanah',
                    name: 'status_tanah'
                },
                {
                    data: 'kode_tanah',
                    name: 'kode_tanah'
                },
                {
                    data: 'asal_usul',
                    name: 'asal_usul'
                },
                {
                    data: 'kondisi',
                    name: 'kondisi'
                },
                {
                    data: 'masa_manfaat',
                    name: 'masa_manfaat'
                },
                {
                    data: 'nilai_sisa',
                    name: 'nilai_sisa'
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

    $('#rincian_obyek').on('change', function()  {
        $.ajax({
            url: "{{route('gedung.sub-rincian-obyek')}}",
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
        $.ajax ({
            url: "{{route('gedung.sub-sub-rincian-obyek')}}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $('#loader_ssro').show();
            },
            data: {rincian_obyek:this.value },
            success: function (data) {
                $("select[name='sub_sub_rincian_obyek']").html('');
                $("select[name='sub_sub_rincian_obyek']").html(data.options);
                $("select[name='sub_sub_rincian_obyek']").trigger("chosen:updated");
            },
            complete: function () {
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

    $('#delModal').on('show.bs.modal', function(event) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const link = $(event.relatedTarget);
        const id = link.data('id');
        const url = `{{ url('admin/master-data/barang/intra/gedung/delete') }}/` + id;
        const modal = $(this);
        modal.find('.modal-footer #delHref').attr('href', url);
    });

    
    
</script>
@endsection

