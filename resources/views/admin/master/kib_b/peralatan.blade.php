@extends('admin.layout.index')

@section('title') Peralatan dan Mesin (KIB B) @endsection
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
                <h4>Peralatan dan Mesin (KIB B)</h4>
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
                <li class="breadcrumb-item"><a href="#!">Intra</a>
                </li>
                <li class="breadcrumb-item"><a href="#">KIB-B</a>
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
                <form action="{{ route('getPeralatan') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="id_pemda_filter">Id Pemda</label>
                                    <div class="col-md-9">
                                        <input name="id_pemda" id="id_pemda" value="{{ !empty($filter['id_pemda']) ? $filter['id_pemda'] : ""  }}" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label" for="no_register_filter">No Register</label>
                                    <div class="col-md-9">
                                        <input name="no_register" id="no_register" value="{{ !empty($filter['no_register']) ? $filter['no_register']  : "" }}" type="text" class="form-control">
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
                <a  href="{{route('peralatan.add')}}" class="btn btn-sm btn-round btn-primary mb-3"><i class="icofont icofont-plus-circle"></i> Tambah Peralatan dan Mesin (KIB B)</a>
                @endif
                <div class="dt-responsive table-responsive">
                    <table id="dttable" class="table table-striped table-bordered able-responsive">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Pemda</th>
                                <th>Pemilik</th>
                                <th>Kode Aset</th>
                                <th>No Register</th>
                                <th>Tanggal Perolehan</th>
                                <th>Tanggal Pembukuan</th>
                                <th>Merek</th>
                                <th>Tipe</th>
                                <th>CC</th>
                                <th>Bahan</th>
                                <th>Nomor Pabrik</th>
                                <th>Nomor Rangka</th>
                                <th>Nomor Mesin</th>
                                <th>Nomor Polisi</th>
                                <th>Nomor BPKB</th>
                                <th>Asal Usul</th>
                                <th>Kondisi</th>
                                <th>Harga</th>
                                <th>Masa Manfaat</th>
                                <th>Nilai Sisa</th>
                                <th>Keterangan</th>
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
                url: "{{ url('admin/master-data/barang/intra/peralatandanmesin') }}",
                data: function(d) {
                    d.id_pemda = $("#id_pemda").val(),
                    d.no_register = $("#no_register").val()
                }
            },
            columns: [
                {
                    'mRender': function(data, type, full, meta) {
                        return + meta.row + meta.settings._iDisplayStart + 1;
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
                    name: 'kode_aset'
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
                    data: 'merk',
                    name: 'merek'
                },
                {
                    data: 'type',
                    name: 'type'
                },
                {
                    data: 'cc',
                    name: 'cc'
                },
                {
                    data: 'bahan',
                    name: 'bahan'
                },
                {
                    data: 'nomor_pabrik',
                    name: 'nomor_pabrik'
                },
                {
                    data: 'nomor_rangka',
                    name: 'nomor_rangka'
                },
                {
                    data: 'nomor_mesin',
                    name: 'nomor_mesin'
                },
                {
                    data: 'nomor_polisi',
                    name: 'nomor_polisi'
                },
                {
                    data: 'nomor_bpkb',
                    name: 'nomor_bpkb'
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
                    data: 'harga',
                    name: 'harga'
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
                    data: 'keterangan',
                    name: 'keterangan'
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

    @if(hasAccess(Auth::user()->role_id, "Unit", "Update"))
    $('#delModal').on('show.bs.modal', function(event) {
        const link = $(event.relatedTarget);
        const id = link.data('id');
        console.log(id);
        const url = `{{ url('admin/master-data/barang/intra/peralatandanmesin/delete') }}/` + id;
        console.log(url);
        const modal = $(this);
        modal.find('.modal-footer #delHref').attr('href', url);
    });
    @endif

</script>
@endsection
