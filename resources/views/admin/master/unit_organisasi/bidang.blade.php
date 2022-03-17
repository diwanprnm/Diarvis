@extends('admin.layout.index')

@section('title') Master BIdang @endsection
@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net-bs4/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">

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
                                                    <h4>Master Bidang</h4>
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
                                                    <li class="breadcrumb-item"><a href="index-1.htm">Bidang</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
@endsection

@section('page-toolbar')  

@endsection

@section('page-body')
<div class="row">
    <div class="col-sm-12">
   

        <div class="card">
            
           
            <div class="card-block">
            @if (hasAccess(Auth::user()->role_id, "Bidang", "Create"))
                <a data-toggle="modal" href="#addModal" class="btn btn-sm btn-round btn-primary mb-3"><i class="icofont icofont-plus-circle"></i> Tambah Bidang</a>

                @endif
                <div class="dt-responsive table-responsive">
                    <table id="dttable" class="table table-striped table-bordered able-responsive">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Bidang</th>
                                
                                <!-- <th>Foto</th> -->
                                <th style="min-width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                         <tbody id="bodyJembatan">
                            @foreach ($bidang as $data)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{$data->kode_bidang}}</td>
                                <td>{{$data->nama_bidang}}</td>
                              <td class="mx-auto">
                                    <div class="btn-group" style="min-width:300px" role="group" data-placement="top" title="" data-original-title=".btn-xlg">
                                       
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>  
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-only">
    @if (hasAccess(Auth::user()->role_id, "Bidang", "Create"))
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <form action="{{route('createJembatan')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data Jembatan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Id Jembatan</label>
                            <div class="col-md-10">
                                <input name="id_jembatan" type="text" class="form-control" maxlength="10" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama Jembatan</label>
                            <div class="col-md-10 my-auto">
                                <input name="nama_jembatan" type="text" class="form-control" required>
                            </div>
                        </div>

                         

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Ruas Jalan</label>
                            <div class="col-md-10">
                                <select id="ruas_jalan" id="ruas_jalan" name="ruas_jalan" class="form-control" required>
                                     
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">SUP</label>
                            <div class="col-md-10">
                                <select class="form-control" id="sup" name="sup" required>
                                   
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Lokasi</label>
                            <div class="col-md-10">
                                <input name="lokasi" type="text" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Panjang (meter)</label>
                            <div class="col-md-10 my-auto">
                                <input name="panjang" type="text" class="form-control formatRibuan" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Lebar (meter)</label>
                            <div class="col-md-10">
                                <input name="lebar" type="text" class="form-control formatRibuan" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Jumlah Bentang</label>
                            <div class="col-md-10 my-auto">
                                <input name="jumlah_bentang" type="number" class="form-control" step="any" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Koordinat X (Lat)</label>
                            <div class="col-md-10 my-auto">
                                <input name="lat" type="text" class="form-control formatLatLong" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Koordinat Y (Lon)</label>
                            <div class="col-md-10 my-auto">
                                <input name="lng" type="text" class="form-control formatLatLong" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Keterangan</label>
                            <div class="col-md-10">
                                <input name="ket" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Foto Jembatan</label>
                            <div class="col-md-6">
                                <input name="foto" type="file" class="form-control">
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light ">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    @endif

    @if (hasAccess(Auth::user()->internal_role_id, "Jembatan", "Delete"))
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Hapus Data Jembatan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data ini?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Tutup</button>
                    <a id="delHref" href="" class="btn btn-danger waves-effect waves-light ">Hapus</a>
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
<script>
    $(document).ready(function() {
        // $("#dttable").DataTable();
        $('#delModal').on('show.bs.modal', function(event) {
            const link = $(event.relatedTarget);
            const id = link.data('id');
            console.log(id);
            const url = `{{ url('admin/master-data/jembatan/delete') }}/` + id;
            console.log(url);
            const modal = $(this);
            modal.find('.modal-footer #delHref').attr('href', url);
        });

        // Format mata uang.
        $('.formatRibuan').mask('000.000.000.000.000', {
            reverse: true
        });

        // Format untuk lat long.
        $('.formatLatLong').keypress(function(evt) {
            return (/^\-?[0-9]*\.?[0-9]*$/).test($(this).val() + evt.key);
        });

        var table = $('#dttable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/master-data/unit-organisasi/bidang/json') }}",
            columns: [{
                    'mRender': function(data, type, full, meta) {
                        return +meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'kode_bidang',
                    name: 'kode_bidang'
                },
                {
                    data: 'nama_bidang',
                    name: 'nama_bidang'
                },    
                // {
                //     'mRender': function(data, type, full) {
                //         return '<img class="img-fluid" style="max-width: 100px" src="/storage/' + full['foto'] + '" alt="" srcset="">';
                //     }
                // },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });

    function ubahOption() {

        //untuk select Ruas
        val = document.getElementById("uptd").value
        id = parseInt(val.slice(val.length - 1))

        url = "{{ url('admin/input-data/kondisi-jalan/getRuasJalan') }}"
        id_select = '#ruas_jalan'
        text = 'Pilih Ruas Jalan'
        option = 'nama_ruas_jalan'

        setDataSelect(id, url, id_select, text, option, option)

        //untuk select SUP
        url = "{{ url('admin/master-data/ruas-jalan/getSUP') }}"
        id_select = '#sup'
        text = 'Pilih SUP'
        option = 'name'

        setDataSelect(id, url, id_select, text, option, option)
    }
</script>
@endsection
