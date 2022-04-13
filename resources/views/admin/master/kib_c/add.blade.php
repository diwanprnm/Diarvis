@extends('admin.layout.index')

@section('title') Tambah Data Gedung dan Bangunan (KIB C)@endsection
@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">
<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css">
<link rel="stylesheet" href="https://js.arcgis.com/4.18/esri/themes/light/main.css">
<link rel="stylesheet" href="{{ asset('assets/css/style_kib.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/chosen_v1.8.7/chosen.css') }}">
<style>
    
</style>
@endsection

@section('page-header')

<div class="row align-items-end">
    <div class="col-lg-8">
        <div class="page-header-title">
            <div class="d-inline">
                <h4> Tambah Data Gedung dan Bangunan (KIB C)</h4>
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
                <li class="breadvcrumb-item"><a href="#">Gedung dan Bangunan</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('page-body')
<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5>Form KIB/C</h5>
                <div class="card-header-right">
                    <i class="icofont icofont-spinner-alt-5"></i>
                </div>
            </div>
            <div class="card-block">
                <form action="{{ route('gedung.save') }}" method="post">
                    @csrf
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <h4 class="sub-title">Unit Organisasi</h4>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Unit</label>
                        <div class="col-md-9">
                            <select name="unit" id="unit" class="form-control chosen-select">
                                <option>-</option>
                                    @foreach($unit as $data)
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
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
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
                        <div class="col-md-5">
                             
                            <select name="kode_pemilik" id="kode_pemilik" class="form-control chosen-select">
                            <option>-</option>
                                @foreach ($kode_pemilik as $data)
                                <option value="{{ $data->kd_pemilik }}">{{ $data->nm_pemilik }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                                <div id="loader" style="display:none">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                    </div>
                                </div>
                                <span id="show_pemilik"></span>
                        </div>    
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Kode Asset</label>
                        <div class="col-md-9">
                        <div class="col separated-input d-flex row">
                            <input type="text" id="kd_aset"  class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text" id="kd_aset0" class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text" id="kd_aset1" class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text" id="kd_aset2" class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text" id="kd_aset3" class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text"  id="kd_aset4" class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text" id="kd_aset5" class="form-control" style="width:40px"
                                placeholder="...">
                            <a data-toggle="modal" href="#modalAsset"  class="btn btn-info"><i class="icofont icofont-ui-search"></i></a>
                            <span id="nama_aset"></span>
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">No Register</label>
                        <div class="col-md-6">
                        <input type="number" class="form-control" readonly value="1">
                        </div>
                        <div class="col-sm-3">
                            <p><i>(Otomatis)</i></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-7 col-form-label">Tgl.
                                    Pembelian</label>
                                <div class="col">
                                    <input class="form-control" type="date">
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-7 col-form-label">Tgl.
                                    Pembukuan</label>
                                <div class="col">
                                    <input class="form-control" type="date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Luas Lantai (M2)</label>
                        <div class="col">
                            <input type="number" class="form-control">  
        
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col">
                            <textarea class="form-control" rows="4" placeholder="Masukkan alamat . . ."></textarea>
                        </div>
                    </div>
                   
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Kondisi
                                    </label>
                                <div class="col">
                                    <select name="select" class="form-control">
                                        <option value="opt1">-
                                        </option>
                                        <option value="opt2">Baik</option>
                                        <option value="opt3">Buruk</option>
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Bertingkat
                                    </label>
                                <div class="col">
                                    <select name="select" class="form-control">
                                        <option value="opt1">-
                                        </option>
                                        <option value="opt2">Ya</option>
                                        <option value="opt3">Tidak</option>
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tgl Dokumen
                                    </label>
                                <div class="col">
                                    <input class="form-control" type="date">
                                </div>
                            </div>
                            
                        </div>
                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Asal -
                                    Usul</label>
                                <div class="col">
                                    <select name="select" class="form-control">
                                        <option value="opt1">Pilih Asal - Usul
                                        </option>
                                        <option value="opt2">Pembelian</option>
                                        <option value="opt3">Penyewaan</option>
                                        <option value="opt4">Penyitaan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-sm-6 col-form-label">Beton/Tidak</label>
                                <div class="col">
                                    <select name="select" class="form-control">
                                        <option value="opt1">-
                                        </option>
                                        <option value="opt2">Ya</option>
                                        <option value="opt3">Tidak</option>
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6 col-form-label">No
                                    Dokumen</label>
                                <div class="col">
                                    <input type="number" class="form-control"
                                        placeholder="Masukkan No Dokumen . . .">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group row">
                                <label
                                    class="col-sm-4 col-form-label">Harga</label>
                                <div class="col">
                                    <input type="number" class="form-control"
                                        placeholder="Masukkan Harga . . .">
                                </div>
                            </div>
        
                        </div>
                        <div class="col">
                            <div class="form-group row">
                                <label class="col-sm-5 col-form-label">Nilai Sisa</label>
                                <div class="col">
                                    <input type="number" class="form-control"
                                        placeholder="Masukkan Nilai Sisa . . .">
                                </div>
                            </div>
                        </div>
                    </div> 
                    
                   <div class="form-group row d-flex align-items-left">
                    <label class="col-sm-3 col-form-label">Masa
                        Manfaat</label>
                        <div class="col">
                            <input type="number" class="form-control"
                                placeholder="Masukkan Masa Manfaat . . .">
                        </div>
                        <div class="col-sm-2">
                            <p>Bulan</p>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Keterangan</label>
                        <div class="col">
                            <textarea class="form-control" rows="4" placeholder="Masukkan Keterangan . . ."></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Status Tanah
                            </label>
                        <div class="col">
                            <select name="select" class="form-control">
                                <option value="opt1">Pilih Status Tanah
                                </option>
                                <option value="opt2">Tanah Milik Pemda</option>
                                <option value="opt2">Tanah Milik Negara</option>
                                <option value="opt3">Tanah Hak Pakai</option>
                                <option value="opt4">Tanah Hak Ulayat</option>
                                <option value="opt4">Tanah Hak Guna Bangunan</option>
                                <option value="opt2">Tanah Hak Pengelolaan</option>
                                <option value="opt2">Tanah Hak Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Kode Tanah</label>
                        <div class="col-md-9">
                        <div class="col separated-input d-flex row">
                            <input type="text" id="kd_tanah"  class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text" id="kd_tanah1" class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text" id="kd_tanah2" class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text" id="kd_tanah3" class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text"  id="kd_tanah4" class="form-control" style="width:40px"
                                placeholder="...">
                            <input type="text" id="kd_tanah5" class="form-control" style="width:40px"
                                placeholder="...">
                            <a data-toggle="modal" href="#modalAsset"  class="btn btn-info"><i class="icofont icofont-ui-search"></i></a>
                            <span id="nama_aset"></span>
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kecamatan</label>
                        <div class="col">
                            <input type="number" class="form-control" placeholder="Masukkan Kecamatan . . .">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kelurahan/Desa</label>
                        <div class="col">
                            <input type="number" class="form-control"
                                placeholder="Masukkan Kelurahan/Desa . . .">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <img src="..\files\assets\images\avatar-3.jpg" alt="Generic placeholder image">                                                                    
                        </div>
                    </div>
                    <div class="row d-flex justify-content-end mt-3">
                        <div class="col-sm-3">
                            <input type="file" class="form-control" placeholder="Masukkan Kelurahan/Desa . . .">                                                                    
                        </div>
                    </div>
                            
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5>Basic Form Inputs</h5>
                <span>Add class of <code>.form-control</code> with
                    <code>&lt;input&gt;</code> tag</span>
                <div class="card-header-right">
                    <i class="icofont icofont-spinner-alt-5"></i>
                </div>
            </div>
            <div class="card-block">
                <h4 class="sub-title">Basic Inputs</h4>
                <table class="table table-framed ">
                    <thead>
                        <tr>
                            <th>No. Reg</th>
                            <th>Tgl Perolehan</th>
                            <th>Kode Barang</th>
                            <th>Harga</th>
                            <th>Uraian Aset</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">5</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">6</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">7</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">8</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">9</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">10</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">11</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">12</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">13</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">14</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">15</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">16</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">17</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">18</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">19</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">20</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">21</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">22</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">23</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">24</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">25</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">26</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">27</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">28</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">29</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                        <tr>
                            <th scope="row">30</th>
                            <td>31/12/2003</td>
                            <td>1.3.2.05.001.004.005</td>
                            <td>413.000,00</td>
                            <td>Filling Cabinet Besi</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalAsset" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{route('saveUnit')}}" method="post">
                @csrf
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm btn-raund  waves-effect " data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn-sm btn-raund waves-effect waves-light ">Simpan</button>
                </div>
            </form>
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
<script src="https://js.arcgis.com/4.18/"></script>
<script>
    $(document).ready(function() {
        $(".chosen-select").chosen({
            width: '100%'
        });


        $('#unit').on('change', function() {
       
            $.ajax({ 
            url: "{{route('gedung.sub-unit')}}",
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
                url: "{{route('gedung.upb')}}",
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
            

        $('#kode_pemilik').on('change', function()  {
            $.ajax({ 
                url: "{{route('gedung.kode-pemilik')}}",
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
    
    });

</script>
@endsection


