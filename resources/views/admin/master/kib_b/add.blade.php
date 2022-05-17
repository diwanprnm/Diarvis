@extends('admin.layout.index')

@section('title') Peralatan dan Mesin (KIB B) @endsection
@section('head')
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">
<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css">
<link rel="stylesheet" href="https://js.arcgis.com/4.18/esri/themes/light/main.css">
<link rel="stylesheet" href="{{ asset('assets/css/style_kib.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/chosen_v1.8.7/chosen.css') }}">

<style type="text/css">
    input[type=file] {
        display: inline;
    }

    #imgPreview {
        border: 1px solid #ccc;
        margin-top: 10px;
        padding: 10px;
    }

    #imgPreview img {
        width: 200px;
        padding: 5px;
    }

    .separated-input > input {
        margin-right: 2px;
        text-align: center;
    }

    .col-md-3 {
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
                <h4> Tambah Data Peralatan dan Mesin KIB/B</h4>
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
                    <a href="#!">Peralatan dan Mesin</a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')
<form action="{{ route('peralatan.save') }}" method="post" enctype="multipart/form-data">
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
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Unit</label>
                        <div class="col-md-9">
                            <select name="unit" id="unit" class="form-control chosen-select">
                                <option>Pilih Unit</option>
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
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 100%">
                                    </div>
                                </div>
                            </div>
                            <select name="sub_unit" id="sub_unit" class="form-control chosen-select">
                                <option>Pilih Sub Unit</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">UPB</label>
                        <div class="col-md-9">
                            <div id="loader_upb" style="display:none">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 100%">
                                    </div>
                                </div>
                            </div>
                            <select name="upb" id="upb" class="form-control chosen-select">
                                <option>Pilih UPB</option>
                            </select>
                        </div>
                    </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Kode Pemilik</label>
                            <div class="col-md-9">
                                <select name="kode_pemilik" id="kode_pemilik" class="form-control chosen-select">
                                    <option>-</option>
                                    @foreach ($kode_pemilik as $data)
                                    if($data->kd_pemilik == "")
                                    <option {{ ($data->kd_pemilik == "12") ? "Selected" :"" }}
                                        value="{{ $data->kd_pemilik }}">{{ $data->kd_pemilik }} {{ $data->nm_pemilik }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div id="loader" style="display:none">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Kode Aset</label>
                            <div class="col-md-9">
                                <div class="col separated-input d-flex row" style="padding: 0px !important; margin: 0px !important;">
                                    <input type="text" id="kd_aset" name="kd_aset" class="form-control"
                                        style="width:40px; margin-right:2px;" placeholder="...">
                                    <input type="text" id="kd_aset0" name="kd_aset0" class="form-control"
                                        style="width:40px; margin-right:2px;" placeholder="...">
                                    <input type="text" id="kd_aset1" name="kd_aset1" class="form-control"
                                        style="width:40px; margin-right:2px;" placeholder="...">
                                    <input type="text" id="kd_aset2" name="kd_aset2" class="form-control"
                                        style="width:40px; margin-right:2px;" placeholder="...">
                                    <input type="text" id="kd_aset3" name="kd_aset3" class="form-control"
                                        style="width:40px; margin-right:2px;" placeholder="...">
                                    <input type="text" id="kd_aset4" name="kd_aset4" class="form-control"
                                        style="width:40px; margin-right:2px;" placeholder="...">
                                    <input type="text" id="kd_aset5" name="kd_aset5" class="form-control"
                                        style="width:40px; margin-right:2px;" placeholder="...">
                                    <a data-toggle="modal" href="#modalAsset" class="btn btn-info" style="text-align: center; padding: 0px 12px !important;">
                                        <i style="line-height: 32px; margin-right: 0px !important;" class="icofont icofont-ui-search"></i>
                                    </a>
                                    <span id="nama_aset"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row align-vertical">
                            <label class="col-md-3 col-form-label">No Register</label>
                            <div class="col-md-6">
                                <div id="loader_noreg" style="display:none">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 100%"></div>
                                    </div>
                                </div>
                                <input type="number" class="form-control" name="no_register" id="no_register" readonly>
                            </div>
                            <div class="col-sm-3">
                                <p style="margin-bottom: 0;"><i>(Otomatis)</i></p>
                            </div>
                        </div>
                        <div class="form-group row align-vertical">
                            <label class="col-md-3 col-form-label">Tanggal Pembelian</label>

                            <div class="col-sm-9">
                                <input class="form-control" name="tanggal_pembelian" type="date">
                            </div>
                        </div>
                        <div class="form-group row align-vertical">
                            <label class="col-md-3 col-form-label">Tanggal Pembukuan</label>

                            <div class="col-sm-9">
                                <input class="form-control" name="tanggal_pembukuan" type="date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Merk</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="merk" type="text" placeholder="Masukkan Merk . . .">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Type</label>

                            <div class="col-sm-9">
                                <input class="form-control" name="type" type="text" placeholder="Masukkan Type . . .">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Ukuran / CC</label>

                            <div class="col-sm-9">
                                <input class="form-control" name="cc" type="text" placeholder="Masukkan CC . . .">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="bahan">Bahan</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="bahan" id="bahan" type="text" placeholder="Masukkan Bahan">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="no_pabrik">No Pabrik</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="no_pabrik" id="no_pabrik" type="text" placeholder="Masukkan No Pabrik . . .">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="no_rangka">No Rangka</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="no_rangka" id="no_rangka" type="text" placeholder="Masukkan No Rangka . . .">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="no_mesin">No Mesin</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="no_mesin" id="no_mesin" type="text" placeholder="Masukkan No Mesin . . .">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="no_bpkb">No BPKB</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="no_bpkb" id="no_bpkb" type="text" placeholder="Masukkan No BPKB . . .">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="no_polisi">No Polisi</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="no_polisi" id="no_polisi" type="text" placeholder="Masukkan No Polisi . . .">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="asal_usul">Asal Usul</label>
                            <div class="col-sm-9">
                                <select name="asal_usul" id="asal_usul" class="form-control chosen-select">
                                    <option>Pilih Asal Usul</option>
                                    <option value="Pembelian">Pembelian</option>
                                    <option value="Hibah">Hibah</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="kondisi">Kondisi</label>
                            <div class="col-sm-9">
                                <select name="kondisi" id="kondisi" class="form-control chosen-select">
                                    <option>Pilih Kondisi</option>
                                    <option value="1">Baik</option>
                                    <option value="0">Rusak</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="harga">Harga</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="harga" id="harga" type="number" placeholder="Masukkan Harga . . .">
                            </div>
                        </div>

                        <div class="form-group row align-vertical">
                            <label class="col-md-3 col-form-label">Masa Manfaat</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="masa_manfaat" id="masa_manfaat" placeholder="Masukkan Masa Manfaat . . .">
                            </div>
                            <div class="col-sm-3">
                                <p style="margin-bottom: 0;">Bulan</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="nilai_sisa">Nilai Sisa</label>
                            <div class="col-sm-9">
                                <input class="form-control" name="nilai_sisa" id="nilai_sisa" type="number" placeholder="Masukkan Nilai Sisa . . .">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="keterangan">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan . . ."></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Kabupaten/Kota</label>
                            <div class="col-sm-9">
                                <select name="kab_kota" id="kab_kota" class="form-control chosen-select">
                                    <option>Pilih Kabupaten/Kota</option>
                                    @foreach ($kab_kota as $data)
                                    <option value="{{ $data->kode_kab_kota }}">{{ $data->nama_kab_kota }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Kecamatan</label>
                            <div class="col-sm-9">
                                <div id="loader_kec" style="display: none;">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 100%">
                                        </div>
                                    </div>
                                </div>
                                <select name="kecamatan" id="kecamatan" class="form-control chosen-select">
                                    <option>Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="desa">Kelurahan/Desa</label>
                            <div class="col-sm-9">
                                <div id="loader_desa" style="display: none;">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 100%"></div>
                                    </div>
                                </div>
                                <select name="desa" id="desa" class="form-control chosen-select">
                                    <option>Pilih Kelurahan/Desa</option>
                                </select>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>Data KIB - B</h5>
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
                    <div id="content_kib_b">
                        <table class="table table-striped table-bordered able-responsive" id="table_kib_b">
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
                <div class="card-block" style="overflow-x: auto">
                    <div id="loader_kib_b" style="display:none">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>
                    </div>
                    <input type="file" name="uploadFile[]" multiple class="multi" />
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
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
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
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                            </div>
                        </div>
                        <select name="sub_sub_rincian_obyek" id="sub_sub_rincian_obyek"
                            class="form-control chosen-select">
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

<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}">
</script>
<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive.bootstrap4.min.js') }}">
</script>
<script src="{{ asset('assets/vendor/jquery/js/jquery.mask.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/chosen_v1.8.7/chosen.jquery.js') }}"
    type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="{{ asset('assets/js/jquery.MultiFile.js') }}" type="text/javascript"></script>
<script src="https://js.arcgis.com/4.18/"></script>
<script>
    $(document).ready(function () {
        $(".chosen-select").chosen({
            width: '100%'
        });
        $('#table_kib_b').dataTable({
            "bInfo": false
        });

        $('#unit').on('change', function () {
            $.ajax({
                url: "{{ route('peralatan.sub-unit') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('#loader_unit').show();
                },
                data: {
                    kode_unit: this.value
                },
                success: function (data) {
                    $("select[name='sub_unit']").html('');
                    $("select[name='sub_unit']").html(data.options);
                    $("select[name='sub_unit']").trigger("chosen:updated");
                },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    $('#loader_unit').hide();
                },
            });
        });

        $('#sub_unit').on('change', function () {
            $.ajax({
                url: "{{route('peralatan.upb')}}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader_upb').show();
                },
                data: {
                    kode_sub_unit: this.value
                },
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

        $('#upb').on('change', function () {
            $.ajax({
                url: "{{ route('peralatan.upb.filter.table') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('#loader_kib_b').show();
                },
                data: {
                    kode_upb: this.value
                },
                success: function (data) {
                    $("#content_kib_b").html(data.data);
                },
                complete: function () {
                    $('#loader_kib_b').hide();
                },
            });
        });

        function refreshTable() {
            $('#table_kib_b').each(function () {
                dt = $(this).dataTable();
                dt.fnDraw();
            })
        }

        $('#kode_pemilik2').on('change', function () {
            $.ajax({
                url: "{{ route('peralatan.kode-pemilik') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('#loader').show();
                },
                data: {
                    kode_pemilik: this.value
                },
                success: function (data) {
                    $("#show_pemilik").html(data);
                },
                complete: function () {
                    $('#loader').hide();
                }
            });
        });

        $('#rincian_obyek').on('change', function () {
            $.ajax({
                url: "{{route('peralatan.sub-rincian-obyek')}}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('#loader_sro').show();
                },
                data: {
                    rincian_obyek: this.value
                },
                success: function (data) {
                    $("select[name='sub_rincian_obyek']").html('');
                    $("select[name='sub_rincian_obyek']").html(data.options);
                    $("select[name='sub_rincian_obyek']").trigger("chosen:updated");
                },
                complete: function () {
                    $('#loader_sro').hide();
                }
            });
        });

        $('#sub_rincian_obyek').on('change', function () {
            $.ajax({
                url: "{{route('peralatan.sub-sub-rincian-obyek')}}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader_ssro').show();
                },
                data: {
                    rincian_obyek: this.value
                },
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

        $('#imageUploadForm').on('submit', (function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log("success");
                    console.log(data);
                },
                error: function (data) {
                    console.log("error");
                    console.log(data);
                }
            });
        }));

        $('#kab_kota').on('change', function () {
            $.ajax({
                url: "{{route('peralatan.get.kecamatan')}}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader_kec').show();
                },
                data: {
                    kode_kab_kota: this.value
                },
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

        $('#kecamatan').on('change', function () {
            $.ajax({
                url: "{{route('peralatan.get.desa')}}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader_desa').show();
                },
                data: {
                    kode_kecamatan: this.value
                },
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

        $('#sub_sub_rincian_obyek').on('change', function () {
            var v = this.value;
            var dt = v.split("_");
            $("#kd_aset").attr("value", dt[0]);
            $("#kd_aset0").attr("value", dt[1]);
            $("#kd_aset1").attr("value", dt[2]);
            $("#kd_aset2").attr("value", dt[3]);
            $("#kd_aset3").attr("value", dt[4]);
            $("#kd_aset4").attr("value", dt[5]);
            $("#kd_aset5").attr("value", dt[6]);
            $("#nama_aset").html(dt[7]);
            $('#modalAsset').modal('toggle');
            return false;
        });

        $("#uploadFile").change(function () {
            $('#imgPreview').html("");
            var total_file = document.getElementById("uploadFile").files.length;
            for (var i = 0; i < total_file; i++) {
                $('#imgPreview').append("<img src='" + URL.createObjectURL(event.target.files[i]) +
                    "'>");
            }
        });
    });
</script>
@endsection
