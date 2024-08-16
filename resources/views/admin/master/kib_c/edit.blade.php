@extends('admin.layout.index')

@section('title') Gedung dan Bangunan (KIB C) @endsection
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

    .separated-input > input {
        margin-right: 2px;
        text-align: center;
    }

    .col-md-3, .col-sm-3, .col-md-9, .col-sm-9 {
        display: flex;
        align-items: center;
    }

</style>
@endsection

@section('page-header')
<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4>Edit Data Gedung dan Bangunan KIB/C</h4>
                <span></span>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-1.htm"><i class="feather icon-home"></i> </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#!">Intra</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#!">Gedung dan Bangunan</a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection


@section('page-body')
<form action="{{route('gedung.update')}}" method="post"  enctype="multipart/form-data">
    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>Form KIB/B</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-spinner-alt-5"></i>
                    </div>
                </div>
                <div class="card-block">
                    <input type="hidden" name="idpemda" value="{{ $gedung->id }} " />
                    <input type="hidden" name="upb_val" id="upb_val" value="{{ $gedung->kd_bidang.'_'.$gedung->kd_unit.'_'.$gedung->kd_sub.'_'.$gedung->kd_upb }}">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Unit</label>
                        <div class="col-md-9">
                            {{ $gedung->nama_unit }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Sub Unit</label>
                        <div class="col-md-9">
                            {{ $gedung->nama_sub_unit }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">UPB</label>
                        <div class="col-md-9">
                            {{ $gedung->nama_upb }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Kode Pemilik</label>
                        <div class="col-md-9">
                            <select name="kode_pemilik" id="kode_pemilik" class="form-control chosen-select">
                            <option>-</option>
                                @foreach ($kode_pemilik as $data)
                                <option {{ ($data->kd_pemilik == $gedung->kd_pemilik) ? "Selected" :"" }} value="{{ $data->kd_pemilik }}">{{ $data->kd_pemilik }} {{ $data->nm_pemilik }}</option>
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
                            <div class="col separated-input d-flex row" style="padding: 0px !important; margin: 0px !important;">
                                <input type="text" id="kd_aset" name="kd_aset" value="{{ $gedung->kd_aset8 }}" class="form-control" style="width:40px"
                                    placeholder="...">
                                <input type="text" id="kd_aset0" name="kd_aset0" value="{{ $gedung->kd_aset80 }}" class="form-control" style="width:40px"
                                    placeholder="...">
                                <input type="text" id="kd_aset1" name="kd_aset1" value="{{ $gedung->kd_aset81 }}" class="form-control" style="width:40px"
                                    placeholder="...">
                                <input type="text" id="kd_aset2" name="kd_aset2" value="{{ $gedung->kd_aset82 }}" class="form-control" style="width:40px"
                                    placeholder="...">
                                <input type="text" id="kd_aset3" name="kd_aset3" value="{{ $gedung->kd_aset83 }}" class="form-control" style="width:40px"
                                    placeholder="...">
                                <input type="text"  id="kd_aset4" name="kd_aset4" value="{{ $gedung->kd_aset84 }}" class="form-control" style="width:40px"
                                    placeholder="...">
                                <input type="text" id="kd_aset5" name="kd_aset5" value="{{ $gedung->kd_aset85 }}" class="form-control" style="width:40px"
                                    placeholder="...">
                                <a data-toggle="modal" href="#modalAsset" class="btn btn-info" style="text-align: center; padding: 0px 12px !important;">
                                    <i style="line-height: 32px; margin-right: 0px !important;" class="icofont icofont-ui-search"></i>
                                </a>
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
                            <input type="number" class="form-control"value="{{ $gedung->no_register }}" name="no_register"  id="no_register" readonly >
                        </div>
                        <div class="col-sm-3">
                            <p style="margin-bottom: 0;"><i>(Otomatis)</i></p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Tanggal Perolehan</label>
                        <div class="col-sm-9">
                            <input class="form-control fill" value="{{ substr($gedung->tgl_perolehan, 0, 10) }}" name="tanggal_perolehan" type="date">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Tanggal Pembukuan</label>
                        <div class="col-sm-9">
                            <input class="form-control" value="{{ substr($gedung->tgl_pembukuan, 0, 10) }}" name="tanggal_pembukuan" type="date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="bertingkat_tidak">Bertingkat Tidak</label>
                        <div class="col-sm-9">
                            <select name="bertingkat_tidak" id="bertingkat_tidak" class="form-control chosen-select">
                                <option>Pilih</option>
                                <option {{ ($gedung->bertingkat_tidak == "Bertingkat") ? "Selected" : "" }} value="Bertingkat">Bertingkat</option>
                                <option {{ ($gedung->bertingkat_tidak == "Tidak") ? "Selected" : "" }} value="Tidak">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="beton_tidak">Beton Tidak</label>
                        <div class="col-sm-9">
                            <select name="beton_tidak" id="beton_tidak" class="form-control chosen-select">
                                <option>Pilih</option>
                                <option {{ ($gedung->beton_tidak == "Beton") ? "Selected" : "" }} value="Beton">Beton</option>
                                <option {{ ($gedung->beton_tidak == "Tidak") ? "Selected" : "" }} value="Tidak">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Luas Lantai(M2)</label>
                        <div class="col-sm-9">
                        <input class="form-control" value="{{ $gedung->luas_lantai }}" name="luas_lantai" type="text">
                        </div>
                    </div>

                

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Asal Usul</label>
                        <div class="col-sm-9">
                            <select name="asal_usul" id="asal_usul" class="form-control chosen-select">
                                <option>Pilih Asal Usul</option>
                                <option {{ ($gedung->asal_usul == "Pembelian") ? "Selected" : "" }} value="Pembelian">Pembelian</option>
                                <option {{ ($gedung->asal_usul == "Hibah") ? "Selected" : "" }} value="Hibah">Hibah</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="kondisi">Kondisi</label>
                        <div class="col-sm-9">
                            <select name="kondisi" id="kondisi" class="form-control chosen-select">
                                <option>Pilih Kondisi</option>
                                <option {{ ($gedung->kondisi == 1) ? "Selected" : "" }} value="1">Baik</option>
                                <option {{ ($gedung->kondisi == 0) ? "Selected" : "" }} value="0">Rusak</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="harga">Harga</label>
                        <div class="col-sm-9">
                            <input class="form-control" name="harga" value="{{ intval($gedung->harga) }}" id="harga" type="number" placeholder="Masukkan Harga . . .">
                        </div>
                    </div>

                    <div class="form-group row align-vertical">
                        <label class="col-md-3 col-form-label">Masa Manfaat</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" name="masa_manfaat" value="{{ intval($gedung->masa_manfaat) }}" id="masa_manfaat" placeholder="Masukkan Masa Manfaat . . .">
                        </div>
                        <div class="col-sm-3">
                            <p style="margin-bottom: 0;">Bulan</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="nilai_sisa">Nilai Sisa</label>
                        <div class="col-sm-9">
                            <input class="form-control" name="nilai_sisa" value="{{ intval($gedung->nilai_sisa) }}" id="nilai_sisa" type="number" placeholder="Masukkan Nilai Sisa . . .">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="keterangan">Keterangan</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan . . .">{{ $gedung->keterangan }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Kabupaten/Kota</label>
                        <div class="col-sm-9">
                            <select name="kab_kota" id="kab_kota" class="form-control chosen-select">
                                <option>-</option>
                                @foreach ($kab_kota as $data)
                                    <option {{ ($gedung->kd_kab_kota == $data->kode_kab_kota) ? "selected" :""  }} value="{{ $data->kode_kab_kota }}">{{ $data->nama_kab_kota }}</option>
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
                                @foreach ($kecamatan as $data)
                                    <option {{ ($gedung->kd_kecamatan == $data->kode_kecamatan) ? "selected" :""  }} value="{{ $data->kode_kecamatan }}">{{ $data->nama_kecamatan }}</option>
                                @endforeach
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
                                @foreach ($desa as $data)
                                    <option {{ ($gedung->kd_desa == $data->kode_desa) ? "selected" :""  }} value="{{ $data->kode_desa }}">{{ $data->nama_desa }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>Data KIB - C</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-spinner-alt-5"></i>
                    </div>
                </div>
                <div class="card-block" style="overflow-x: auto">
                    <div id="loader_kib_b" style="display:none">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>
                    </div>
                    <div id="content_kib_c">
                        <table class="table table-striped table-bordered able-responsive" id="table_kib_c">
                            <thead>
                                <tr>
                                    <th>No. Reg</th>
                                    <th>Tgl Perolehan</th>
                                    <th>Kode Barang</th>
                                    <th>Harga</th>
                                    <th>Uraian Aset</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Dokumen</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-upload"></i>
                    </div>
                </div>
                <div class="card-block" style="overflow-x: auto" >
                    <div id="loader_kib_c" style="display:none">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>
                    </div>
                    <input type="file" name="uploadFile[]"  multiple class="multi"/>
                    <table class="table">
                        @foreach($dokumen as $file)
                        <tr>
                            <td> {{ $file->filename}}</td>
                            <td>
                                <a href="#"><i class="icofont icofont-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="modal-footer">
                    <button type="button"
                        class="btn btn-default btn-sm btn-raund waves-effect" data-dismiss="modal">Tutup</button>
                    <button type="submit"
                        class="btn btn-primary btn-sm btn-raund waves-effect waves-light">Simpan</button>
                </div>
            </div>
        </div>
    </div>
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
                            <option {{ (($gedung->kd_aset81."_".$gedung->kd_aset83) ==  ($data->kd_aset1.'_'.$data->kd_aset3)) ? "selected" : "" }} value="{{ $data->kd_aset1.'_'.$data->kd_aset3}}">{{ $data->nm_aset3 }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Sub Rincian Obyek</label>
                    <div class="col-md-8">
                        <div id="loader_sro" style="display:none">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                            </div>
                        </div>
                        <select name="sub_rincian_obyek" id="sub_rincian_obyek" class="form-control chosen-select">
                            @if(!empty($sub_rincian_obyek))
                                @foreach ($sub_rincian_obyek as $data)
                                    <option {{ (($gedung->kd_aset81."_".$gedung->kd_aset84) ==  ($data->kd_aset1.'_'.$data->kd_aset4)) ? "selected" : "" }} value="{{ $data->kd_aset1.'_'.$data->kd_aset4}}">{{ $data->nm_aset4 }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Sub Sub Rincian Obyek</label>
                    <div class="col-md-8">
                        <div id="loader_ssro" style="display:none">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                </div>
                            </div>
                        </div>
                        <select name="sub_sub_rincian_obyek" id="sub_sub_rincian_obyek"
                            class="form-control chosen-select">
                                @if(!empty($sub_sub_rincian_obyek))
                                    @foreach ($sub_sub_rincian_obyek as $data)
                                        {{ $kd_aset8 = $gedung->kd_aset8.'_'.$gedung->kd_aset80.'_'.$gedung->kd_aset81.'_'.$gedung->kd_aset82.'_'.$gedung->kd_aset83.'_'.$gedung->kd_aset84.'_'.$gedung->kd_aset85  }}
                                        {{ $kd_aset = $data->kd_aset.'_'.$data->kd_aset0.'_'.$data->kd_aset1.'_'.$data->kd_aset2.'_'.$data->kd_aset3.'_'.$data->kd_aset4.'_'.$data->kd_aset5  }}
                                        <option  {{ (($kd_aset8 == $kd_aset) ? "selected" :"") }} value="{{ $data->kd_aset.'_'.$data->kd_aset0.'_'.$data->kd_aset1.'_'.$data->kd_aset2.'_'.$data->kd_aset3.'_'.$data->kd_aset4.'_'.$data->kd_aset5.'_'.$data->nm_aset5}}">{{ $data->nm_aset5 }}</option>
                                    @endforeach
                                @endif
                        </select>
                    </div>
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
<script src="{{ asset('assets/js/jquery.MultiFile.js') }}"  type="text/javascript"></script>


<script src="https://js.arcgis.com/4.18/"></script>
<script>
    $(document).ready(function() {
        setDataTable($("#upb_val").val());
        $(".chosen-select").chosen({
            width: '100%'
        });

        $('#table_kib_c').dataTable({
            "bInfo": false
        });

        $('#unit').on('change', function() {
            $.ajax({
                url: "{{ route('gedung.sub-unit') }}",
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
                url: "{{ route('gedung.upb') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('#loader_upb').show();
                },
                data: {kode_sub_unit:this.value },

                success: function (data) {
                    $("select[name='upb']").html('');
                    $("select[name='upb']").html(data.options);
                    $("select[name='upb']").trigger("chosen:updated");
                },
                complete: function () {
                    $('#loader_upb').hide();
                },
            });
        });

        $('#kode_pemilik2').on('change', function()  {
            $.ajax({
                url: "{{ route('gedung.kode-pemilik') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('#loader').show();
                },
                data: {kode_pemilik:this.value },

                success: function (data) {
                    $("#show_pemilik").html(data);
                },
                complete: function () {
                    $('#loader').hide();
                }
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
            $.ajax({
                url: "{{route('gedung.sub-sub-rincian-obyek')}}",
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
                url: "{{route('gedung.get.kecamatan')}}",
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
                url: "{{route('gedung.get.desa')}}",
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
            return false;
        });

        $("#uploadFile").change(function(){
            $('#imgPreview').html("");
            var total_file=document.getElementById("uploadFile").files.length;
            for(var i=0;i<total_file;i++)  {
                $('#imgPreview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'>");
            }
        });

        function refreshTable() {
            $('#table_kib_c').each(function () {
                dt = $(this).dataTable();
                dt.fnDraw();
            })
        }

        function setDataTable(upb_kode){

            console.log(upb_kode);

            $.ajax({
                url: "{{ route('gedung.upb.filter.table') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('#loader_kib_c').show();
                },
                data: {
                    kode_upb: upb_kode
                },
                success: function (data) {
                    $("#content_kib_c").html(data.data);
                },
                complete: function () {
                    $('#loader_kib_c').hide();
                },
            });
        }
    });

</script>
@endsection