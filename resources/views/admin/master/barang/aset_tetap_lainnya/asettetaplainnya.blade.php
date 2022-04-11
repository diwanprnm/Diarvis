@extends('admin.layout.index')

@section('title')
    Aset Tetap Lainnya (KIB E)
@endsection
@section('head')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">
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
                    <h4>Aset Tetap Lainnya (KIB E)</h4>
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
                    <a class="accordion-msg" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        <i class="icofont icofont-ui-search"></i> Pencarian Data
                    </a>
                </h3>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="accordion-content accordion-desc">
                    <form action="{{ route('getUnitFilter') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Bidang</label>
                                        <div class="col-md-9">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Nama Unit</label>
                                        <div class="col-md-9">
                                            <input name="nama_unit" id="edit_nama_unit" value=" " type="text"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Kode Unit</label>
                                        <div class="col-md-9">
                                            <input name="kode_unit" type="number" value=" " id="edit_kode_unit"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-round btn-primary mb-3"><i
                                    class="icofont icofont-ui-search"></i> Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-body')
    {{-- form input untuk create, update --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">
                    <form action="{{ route('saveAsetTetapLainnya') }}" method="post">
                        @csrf
                        <div class="form-group row d-flex align-items-center">
                            <label class="col-sm-2 col-form-label">Kode Pemilik</label>
                            <div class="col">
                                <select name="kd_pemilik" id="kd_pemilik" class="form-control">
                                    {{-- <option value="opt1">Pilih Kode Pemilik</option> --}}
                                    <option value=12>12</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <p>Pemerintah Kabupaten/Kota</p>
                            </div>
                        </div>

                        <div class="form-group row kode-aset">
                            <label class="col-sm-2 col-form-label">Kode Aset</label>
                            <div class="col">
                                <div class="col separated-input d-flex row">
                                    <div class="col-sm-1">
                                        <input type="text" id="kd_aset" name="kd_aset" class="form-control" placeholder="...">
                                    </div>
                                    <div class="col-1">
                                        <input type="text" id="kd_aset_0" name="kd_aset_0" class="form-control" placeholder="...">
                                    </div>
                                    <div class="col-1">
                                        <input type="text" id="kd_aset_1" name="kd_aset_1" class="form-control" placeholder="...">
                                    </div>
                                    <div class="col-1">
                                        <input type="text" id="kd_aset_2" name="kd_aset_2" class="form-control" placeholder="...">
                                    </div>
                                    <div class="col-1">
                                        <input type="text" id="kd_aset_3" name="kd_aset_3" class="form-control" placeholder="...">
                                    </div>
                                    <div class="col-1">
                                        <input type="text" id="kd_aset_4" name="kd_aset_4" class="form-control" placeholder="...">
                                    </div>
                                    <div class="col-1">
                                        <input type="text" id="kd_aset_5" name="kd_aset_5" class="form-control" placeholder="...">
                                    </div>
                                    <a data-toggle="modal" href="#kdaset" class="btn btn-sm btn-primary mb-3"><i class="icofont icofont-refresh"></i></a>
                                </div>
                                {{-- perlu diperbaiki --}}
                                <div class="col row mt-3">
                                    <p>{{$text}}</p>
                                </div>
                                <div class="col row">
                                    <p>02.06.01.04.004</p>
                                </div>
                                <div class="col row">
                                    <p>Filling Besi/Metal</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row d-flex align-items-center">
                            <label class="col-sm-2 col-form-label">No. Register</label>
                            <div class="col">
                                <input type="number" id="no_reg" name="no_reg" class="form-control" readonly value="1">
                            </div>
                            <div class="col-sm-2">
                                <p><i>(Otomatis)</i></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Ruang</label>
                            <div class="col">
                                <input type="number" id="kd_ruang" name="kd_ruang" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tgl. Pembelian</label>
                                    <div class="col">
                                        <input id="tgl_perolehan" name="tgl_perolehan" class="form-control" type="datetime-local">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Tgl.
                                        Pembukuan</label>
                                    <div class="col">
                                        <input id="tgl_pembukuan" name="tgl_pembukuan" class="form-control" type="datetime-local">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Bahan</label>
                            <div class="col">
                                <input id="bahan" name="bahan" type="text" class="form-control" placeholder="Masukkan Nama Bahan . . .">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Ukuran</label>
                            <div class="col">
                                <input type="text" id="ukuran" name="ukuran" class="form-control" placeholder="Masukkan Ukuran . . .">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Asal - Usul</label>
                                    <div class="col">
                                        <select id="asal_usul" name="asal_usul" class="form-control">
                                            <option>Pilih Asal - Usul</option>
                                            <option value="Pembelian">Pembelian</option>
                                            <option value="Penyewaan">Penyewaan</option>
                                            <option value="Penyitaan">Penyitaan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Harga</label>
                                    <div class="col">
                                        <input type="number" id="harga" name="harga" class="form-control" placeholder="Masukkan Harga . . .">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Kondisi</label>
                                    <div class="col">
                                        <select id="kondisi" name="kondisi" class="form-control">
                                            <option>Pilih Kondisi</option>
                                            <option value="1">Baik</option>
                                            <option value="2">Buruk</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row d-flex align-items-center">
                                    <label class="col-sm-4 col-form-label">Masa Manfaat</label>
                                    <div class="col">
                                        <input type="number" id="masa_manfaat" name="masa_manfaat" class="form-control" placeholder="Masukkan Masa Manfaat . . .">
                                    </div>
                                    <div class="col-sm-2">
                                        <p>Bulan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nilai Sisa</label>
                            <div class="col">
                                <input type="number" id="nilai_sisa" name="nilai_sisa" class="form-control" placeholder="Masukkan Nilai Sisa . . .">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Kab. Kota</label>
                            <div class="col">
                                <input type="number" id="kab_kota" name="kab_kota" class="form-control" placeholder="Masukkan Kota . . .">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Provinsi</label>
                            <div class="col">
                                <input type="number" id="provinsi" name="provinsi" class="form-control" placeholder="Masukkan Provinsi . . .">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-sm btn-raund waves-effect waves-light " >Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- tabel --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-block">
                    @if (hasAccess(Auth::user()->role_id, 'Unit', 'Create'))
                        <a data-toggle="modal" href="#addModal" class="btn btn-sm btn-round btn-primary mb-3"><i
                                class="icofont icofont-plus-circle"></i> Tambah Aset (KIB E)</a>
                    @endif
                    <div class="dt-responsive table-responsive">
                        <table id="dttable" class="table table-striped table-bordered able-responsive">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun</th>
                                    <th>Kode Pemilik</th>
                                    <th>Kode Aset</th>
                                    <th>No Register</th>
                                    <th>Tgl Perolehan</th>
                                    <th>Tgl Pembukuan</th>
                                    <th>Bahan</th>
                                    <th>Ukuran</th>
                                    <th>Masa Manfaat</th>
                                    <th>Nilai Sisa</th>
                                    <th>Asal Usul</th>
                                    <th>Harga</th>
                                    <!-- <th>Foto</th> -->
                                    <th style="min-width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bodyATL">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-only">
        @if (hasAccess(Auth::user()->role_id, 'Unit', 'Create'))
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form action="{{ route('saveUnit') }}" method="post">
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
                                <button type="button" class="btn btn-default btn-sm btn-raund  waves-effect "
                                    data-dismiss="modal">Tutup</button>
                                <button type="submit"
                                    class="btn btn-primary btn-sm btn-raund waves-effect waves-light ">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @if (hasAccess(Auth::user()->role_id, 'Unit', 'Update'))
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form action="{{ route('updateUnit') }}" method="post">
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
                                        <input name="kode_unit" type="number" id="kode_unit2" class="form-control"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Nama Unit</label>
                                    <div class="col-md-9">
                                        <input name="nama_unit" id="nama_unit2" type="text" class="form-control"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm btn-raund  waves-effect "
                                    data-dismiss="modal">Tutup</button>
                                <button type="submit"
                                    class="btn btn-primary btn-sm btn-raund waves-effect waves-light ">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @if (hasAccess(Auth::user()->role_id, 'Unit', 'Delete'))
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
                            <button type="button" class="btn btn-default btn-sm waves-effect "
                                data-dismiss="modal">Tutup</button>
                            <a id="delHref" href="" class="btn btn-danger  btn-sm waves-effect waves-light ">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
<div class="modal-only">
    <div class="modal fade" id="kdaset" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form >
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Pilih Aset</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Aset</label>
                            <div class="col-md-9">
                                <select class="chosen-select" id="input_kd_aset" name="input_kd_aset" >
                                    <option>Pilih Aset</option>
                                    @foreach ($nmAset5 as $data)
                                        <option value="{{ $data->kode_aset }}">{{ $data->nm_aset5}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm btn-raund  waves-effect " data-dismiss="modal">Tutup</button>
                    </div>
                </form>
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
    <script type="text/javascript" src="{{ asset('assets/vendor/chosen_v1.8.7/chosen.jquery.js') }}"
        type="text/javascript"></script>
    <script>
        $(document).ready(function(){
            $('#input_kd_aset').change{
                $text = 'hello';
            }
        })
    </script>
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
                    url: "{{ url('admin/master-data/barang/intra/aset-tetap-lainnya/json') }}",

                },

                columns: [{
                        'mRender': function(data, type, full, meta) {
                            return +meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'tahun',
                        name: 'tahun'
                    },
                    {
                        data: 'kd_pemilik',
                        name: 'kd_pemilik'
                    },
                    {
                        data: 'kode_aset',
                        name: 'kode_aset'
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
                        data: 'bahan',
                        name: 'bahan'
                    },
                    {
                        data: 'ukuran',
                        name: 'ukuran'
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
                        data: 'asal_usul',
                        name: 'asal_usul'
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


        @if (hasAccess(Auth::user()->role_id, 'Unit', 'Update'))
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
        @if (hasAccess(Auth::user()->role_id, 'Unit', 'Delete'))
            $('#delModal').on('show.bs.modal', function(event) {
            const link = $(event.relatedTarget);
            const id = link.data('id');
            console.log(id);
            const url = `{{ url('admin/master-data/unit-organisasi/unit/delete') }}/` + id;
            console.log(url);
            const modal = $(this);
            modal.find('.modal-footer #delHref').attr('href', url);
            });
        @endif
    </script>
@endsection
