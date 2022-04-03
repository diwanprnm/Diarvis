@extends('admin.layout.index')

@section('title') Master Jenis @endsection
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
                <h4>Master Jenis</h4>
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
                <li class="breadcrumb-item">
                    <a href="#">Kode Barang</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="#">Jenis</a>
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
                <form action="{{route('getJenisFilter')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Nama Aset 1</label>
                                    <div class="col-md-9">
                                        <select class="form-control chosen-select" id="edit_aset_1" name="aset_1">
                                            <option value="" >Tampilkan Semua</option>
                                            @foreach ($aset1 as $data)
                                            <?php if( $filter['aset_1'] == $data->kode_aset) {  ?>
                                                <option selected value="{{ $data->kode_aset }}">{{ $data->nama_aset }}</option>
                                            <?php } else { ?>
                                                <option  value="{{ $data->kode_aset }}">{{ $data->nama_aset }}</option>
                                            <?php } ?>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Nama Aset 2</label>
                                    <div class="col-md-9">
                                        <select class="form-control chosen-select" id="edit_aset_2" name="aset_2">
                                            <option value="" >Tampilkan Semua</option>
                                            @foreach ($aset2 as $data)
                                            <?php if( $filter['aset_2'] == $data->kode_aset_2) {  ?>
                                                <option selected value="{{ $data->kode_aset_2 }}">{{ $data->nama_aset_2 }}</option>
                                            <?php } else { ?>
                                                <option  value="{{ $data->kode_aset_2 }}">{{ $data->nama_aset_2 }}</option>
                                            <?php } ?>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Nama Aset 3</label>
                                    <div class="col-md-9">
                                        <select class="form-control chosen-select" id="edit_aset_3" name="aset_3">
                                            <option value="" >Tampilkan Semua</option>
                                            @foreach ($aset3 as $data)
                                            <?php if( $filter['aset_3'] == $data->kode_aset_3) {  ?>
                                                <option selected value="{{ $data->kode_aset_3 }}">{{ $data->nama_aset_3 }}</option>
                                            <?php } else { ?>
                                                <option  value="{{ $data->kode_aset_3 }}">{{ $data->nama_aset_3 }}</option>
                                            <?php } ?>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Nama Aset 4</label>
                                    <div class="col-md-9">
                                        <select class="form-control chosen-select" id="edit_aset_4" name="aset_4">
                                            <option value="" >Tampilkan Semua</option>
                                            @foreach ($aset4 as $data)
                                            <?php if( $filter['aset_4'] == $data->kode_aset_4) {  ?>
                                                <option selected value="{{ $data->kode_aset_4 }}">{{ $data->nama_aset_4 }}</option>
                                            <?php } else { ?>
                                                <option  value="{{ $data->kode_aset_4 }}">{{ $data->nama_aset_4 }}</option>
                                            <?php } ?>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Kode Aset 5</label>
                                    <div class="col-md-9">
                                        <input name="aset_5" id="edit_aset_5" value="{{ $filter['aset_5'] }}" type="text" class="form-control" placeholder="Masukkan Nama Unit 5...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Nama Aset 5</label>
                                    <div class="col-md-9">
                                        <input name="nama_aset_5" id="edit_nama_aset_5" value="{{ $filter['nama_aset_5'] }}" type="text" class="form-control" placeholder="Masukkan Nama Unit 5...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"  class="btn btn-sm btn-round btn-primary mb-3"><i class="icofont icofont-ui-search"></i> Cari</button>
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
                <a data-toggle="modal" href="#addModal" class="btn btn-sm btn-round btn-primary mb-3"><i class="icofont icofont-plus-circle"></i> Tambah Unit</a>
                @endif
                <div class="dt-responsive table-responsive">
                    <table id="dttable" class="table table-striped table-bordered able-responsive">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Aset 1</th>
                                <th>Nama Aset 2</th>
                                <th>Nama Aset 3</th>
                                <th>Nama Aset 4</th>
                                <th>Kode Aset 5</th>
                                <th>Nama Aset 5</th>
                                <!-- <th>Foto</th> -->
                                <th style="min-width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyJembatan">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-only">
    @if (hasAccess(Auth::user()->role_id, "Jenis", "Create"))
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{route('saveJenis')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Jenis</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Aset 1</label>
                            <div class="col-md-9">
                                <select class="chosen-select" id="input_kode_aset_1" name="input_kode_aset_1">
                                    <option>Pilih Aset 1</option>
                                    @foreach ($aset1 as $data)
                                        <option value="{{ $data->kode_aset }}">{{ $data->nama_aset }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Aset 2</label>
                            <div class="col-md-9">
                                <select class="chosen-select" id="input_kode_aset_2" name="input_kode_aset_2">
                                    <option>Pilih Aset 2</option>
                                    @foreach ($aset2 as $data)
                                        <option  value="{{ $data->kode_aset_2 }}">{{ $data->nama_aset_2 }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Aset 3</label>
                            <div class="col-md-9">
                                <select class="chosen-select" id="input_kode_aset_3" name="input_kode_aset_3">
                                    <option>Pilih Aset 3</option>
                                    @foreach ($aset3 as $data)
                                        <option  value="{{ $data->kode_aset_3 }}">{{ $data->nama_aset_3 }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Aset 4</label>
                            <div class="col-md-9">
                                <select class="chosen-select" id="input_kode_aset_4" name="input_kode_aset_4">
                                    <option>Pilih Aset 4</option>
                                    @foreach ($aset4 as $data)
                                        <option  value="{{ $data->kode_aset_4 }}">{{ $data->nama_aset_4 }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Kode Aset 5</label>
                            <div class="col-md-9">
                                <input name="input_kode_aset_5" type="number" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Aset 5</label>
                            <div class="col-md-9">
                                <input name="input_nama_aset_5" type="text" class="form-control" required>
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

    @if (hasAccess(Auth::user()->role_id, "Jenis", "Update"))
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('updateJenis') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Ubah Data Jenis</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <input type="hidden" id="jenis_id" name="jenis_id" />
                    </div>

                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Aset 1</label>
                            <div class="col-md-9">
                                <select class="chosen-select aset-1-select" id="input_kode_aset_1" name="input_kode_aset_1">
                                    <option>Pilih Aset 1</option>
                                    @foreach ($aset1 as $data)
                                        <option value="{{ $data->kode_aset }}">{{ $data->nama_aset }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Aset 2</label>
                            <div class="col-md-9">
                                <select class="chosen-select aset-2-select" id="input_kode_aset_2" name="input_kode_aset_2">
                                    <option>Pilih Aset 2</option>
                                    @foreach ($aset2 as $data)
                                        <option value="{{ $data->kode_aset_2 }}">{{ $data->nama_aset_2 }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Aset 3</label>
                            <div class="col-md-9">
                                <select class="chosen-select aset-3-select" id="input_kode_aset_3" name="input_kode_aset_3">
                                    <option>Pilih Aset 3</option>
                                    @foreach ($aset3 as $data)
                                        <option  value="{{ $data->kode_aset_3 }}">{{ $data->nama_aset_3 }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Aset 4</label>
                            <div class="col-md-9">
                                <select class="chosen-select aset-4-select" id="input_kode_aset_4" name="input_kode_aset_4">
                                    <option>Pilih Aset 4</option>
                                    @foreach ($aset4 as $data)
                                        <option value="{{ $data->kode_aset_4 }}">{{ $data->nama_aset_4 }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Kode Aset 5</label>
                            <div class="col-md-9">
                                <input name="input_kode_aset_5" id="edit-kode-aset-5" type="number" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Aset 5</label>
                            <div class="col-md-9">
                                <input name="input_nama_aset_5" id="edit-nama-aset-5" type="text" class="form-control" required>
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

    @if (hasAccess(Auth::user()->role_id, "Jenis", "Delete"))
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
                url: "{{ url('admin/master-data/kode-barang/jenis/json') }}",
                data: {
                    "aset_1" : "{{ !empty($filter['aset_1']) ? $filter['aset_1']  : "" }}",
                    "aset_2" : "{{ !empty($filter['aset_2']) ? $filter['aset_2']  : "" }}",
                    "aset_3" : "{{ !empty($filter['aset_3']) ? $filter['aset_3']  : "" }}",
                    "aset_4" : "{{ !empty($filter['aset_4']) ? $filter['aset_4']  : "" }}",
                    "aset_5" : "{{ !empty($filter['aset_5']) ? $filter['aset_5']  : "" }}",
                    "nama_aset_5" : "{{ !empty($filter['nama_aset_5']) ? $filter['nama_aset_5']  : "" }}"
                }
            },

            columns: [{
                'mRender': function(data, type, full, meta) {
                    return +meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'nama_aset',
                name: 'nama_aset'
            },
            {
                data: 'nama_aset_2',
                name: 'nama_aset_2'
            },
            {
                data: 'nama_aset_3',
                name: 'nama_aset_3'
            },
            {
                data: 'nama_aset_4',
                name: 'nama_aset_4'
            },
            {
                data: 'kode_aset_5',
                name: 'kode_aset_5'
            },
            {
                data: 'nama_aset_5',
                name: 'nama_aset_5'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }]
        });
    });

    @if(hasAccess(Auth::user()->role_id, "Jenis", "Update"))
    $('#editModal').on('show.bs.modal', function(event) {
        const link = $(event.relatedTarget);
        const id = link.data('id');
        console.log(id);
        const baseUrl = `{{ url('admin/master-data/kode-barang/jenis/getJenisById/') }}` + '/' + id;
        $.get(baseUrl, function(response) {
            const data = response.data;
            showData(data);
            console.log();
        });
    });

    function showData(data) {
        $(".aset-1-select").val(data.kode_aset_1).trigger('chosen:updated');
        $(".aset-2-select").val(data.kode_aset_2).trigger('chosen:updated');
        $(".aset-3-select").val(data.kode_aset_3).trigger('chosen:updated');
        $(".aset-4-select").val(data.kode_aset_4).trigger('chosen:updated');
        $("#edit-kode-aset-5").val(data.kode_aset_5);
        $("#edit-nama-aset-5").val(data.nama_aset_5);
        $("#jenis_id").val(data.id);
    }

    @endif
    @if(hasAccess(Auth::user()->role_id, "Jenis", "Delete"))
    $('#delModal').on('show.bs.modal', function(event) {
        const link = $(event.relatedTarget);
        const id = link.data('id');
        console.log(id);
        const url = `{{ url('admin/master-data/kode-barang/jenis/delete') }}/` + id;
        console.log(url);
        const modal = $(this);
        modal.find('.modal-footer #delHref').attr('href', url);
    });
    @endif
</script>
@endsection
