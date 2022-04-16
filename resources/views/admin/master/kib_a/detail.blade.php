@extends('admin.layout.index')

@section('title') Tanah (KIB A) @endsection
@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">
<link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css">
<link rel="stylesheet" href="https://js.arcgis.com/4.18/esri/themes/light/main.css">
<link rel="stylesheet" href="{{ asset('assets/css/style_kib.css') }}">
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
                                                    <h4>  {{$tanah->nm_aset5}}</h4>
                                                    <span>Kode {{ $tanah->kode_aset}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">User Profile</a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">User Profile</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
@endsection
 

@section('page-body')
<div class="row">
                                            <div class="col-lg-12">
                                                <div class="cover-profile">
                                                    <div class="profile-bg-img">
                                                        <img class="profile-bg-img img-fluid" src="\assets\images\user-profile\bg-img1.jpg" alt="bg-img">
                                                        <div class="card-block user-info">
                                                            <div class="col-md-12">
                                                                <div class="media-left">
                                                                    <a href="#" class="profile-image">
                                                                        <img class="user-img img-radius" src="\assets\images\kantor.jpg" style="width:108px;height:108px" alt="user-img">
                                                                    </a>
                                                                </div>
                                                                <div class="media-body row">
                                                                    <div class="col-lg-12">
                                                                        <div class="user-title">
                                                                            <h2>{{$tanah->nm_aset5}}</h2>
                                                                            <span class="text-white">{{$tanah->alamat}}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--profile cover end-->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <!-- tab header start -->
                                                <div class="tab-header card">
                                                    <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Informasi Umum</a>
                                                            <div class="slide"></div>
                                                        </li>
                                                        
                                                        
                                                    </ul>
                                                </div>
                                                <!-- tab header end -->
                                                <!-- tab content start -->
                                                <div class="tab-content">
                                                    <!-- tab panel personal start -->
                                                    <div class="tab-pane active" id="personal" role="tabpanel">
                                                        <!-- personal card start -->
                                                        <div class="card">
                                                             
                                                            <div class="card-block">
                                                                <div class="view-info">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="general-info">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-xl-6">
                                                                                        <div class="table-responsive">
                                                                                        <h4> Informasi Detil KIB-A </h4>
                                                                                        <table class="table table-striped   nowrap">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <th scope="row">Tahun</th>
                                                                                                        <td>{{$tanah->tahun}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Kode Pemilik</th>
                                                                                                        <td>{{$tanah->kd_pemilik." ".$tanah->nm_pemilik}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Kode Aset</th>
                                                                                                        <td>{{$tanah->kode_aset}}<br/>
                                                                                                        <b>{{$tanah->nm_aset5}}</b>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">No Register</th>
                                                                                                        <td>{{$tanah->no_register}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Tgl Pembelian</th>
                                                                                                        <td>{{$tanah->tgl_perolehan}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Tgl Pembukuan</th>
                                                                                                        <td>{{$tanah->tgl_pembukuan}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Luas</th>
                                                                                                        <td>{{$tanah->luas_m2}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Alamat</th>
                                                                                                        <td>{{$tanah->alamat}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Hak Tanah</th>
                                                                                                        <td>{{$tanah->hak_tanah}}</td>
                                                                                                    </tr>
                                                                                                 
                                                                                                    <tr>
                                                                                                        <th scope="row">Tanggal Sertifikat</th>
                                                                                                        <td> {{$tanah->sertifikat_tanggal}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Nomor Sertifikat</th>
                                                                                                        <td>{{$tanah->sertifikat_nomor}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Asal Usul</th>
                                                                                                        <td>{{$tanah->asal_usul}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Penggunaan</th>
                                                                                                        <td>{{$tanah->penggunaan}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">harga</th>
                                                                                                        <td>{{$tanah->harga}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">keterangan</th>
                                                                                                        <td>{{$tanah->nm_aset5}}</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- end of table col-lg-6 -->
                                                                                    <div class="col-lg-12 col-xl-6">
                                                                                        <div class="table-responsive">
                                                                                            
                                                                                             
                                                                                            <h4> Dokumen</h4>
                                                                                            <table class="table table-striped   nowrap">
                                                                                                <thead>
                                                                                                <tr><td>No</td><td>Filename</td><td>Aksi</td></tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    @foreach($dokumen as $dt)
                                                                                                    <tr><td>{{$loop->index + 1}}</td>
                                                                                                    <td>{{ $dt->filename}}</td>
                                                                                                    <td>
                                                                                                    <a href=""><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-mini  waves-effect waves-light"><i class="icofont icofont-download"></i></button></a>
                                                                                                    <a href=""><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-mini  waves-effect waves-light"><i class="icofont icofont-ui-zoom-in"></i></button></a>
                                                                                                        
                                                                                                </td>
                                                                                                </tr>
                                                                                                    
                                                                                                    @endforeach
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <div id="preview">
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- end of table col-lg-6 -->
                                                                                </div>
                                                                                <!-- end of row -->
                                                                            </div>
                                                                            <!-- end of general info -->
                                                                        </div>
                                                                        <!-- end of col-lg-12 -->
                                                                    </div>
                                                                    <!-- end of row -->
                                                                </div>
                                                                <!-- end of view-info -->
                                                                 
                                                            </div>
                                                            <!-- end of card-block -->
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h5 class="card-header-text">Lokasi</h5>
                                                                        
                                                                    </div>
                                                                    <div class="card-block user-desc">
                                                                        <div class="view-desc">
                                                                        <div id="mapLatLong" class="full-map mb-2" style="height: 300px; width: 100%"></div>
                                                                        Lat <input id="lat" name="lat" type="text" value="{{ $tanah->latitude }}" class="form-control formatLatLong fill" required="">
                                                                        Long <input id="long" name="lng" type="text"  value="{{ $tanah->longitude }}" class="form-control formatLatLong fill" required="">     
                                                                    </div>
                                                                         
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- personal card end-->
                                                    </div>
                                                    <!-- tab pane personal end -->
                                                    <!-- tab pane info start -->
                                                    <div class="tab-pane" id="binfo" role="tabpanel">
                                                        <!-- info card start -->
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-header-text">User Services</h5>
                                                            </div>
                                                            <div class="card-block">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="card b-l-success business-info services m-b-20">
                                                                            <div class="card-header">
                                                                                <div class="service-header">
                                                                                    <a href="#">
                                                                                        <h5 class="card-header-text">Shivani Hero</h5>
                                                                                    </a>
                                                                                </div>
                                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                         </span>
                                                                                 
                                                                            </div>
                                                                          
                                                                            <!-- end of card-block -->
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="card b-l-danger business-info services">
                                                                            <div class="card-header">
                                                                                <div class="service-header">
                                                                                    <a href="#">
                                                                                        <h5 class="card-header-text">Dress and Sarees</h5>
                                                                                    </a>
                                                                                </div>
                                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                         </span>
                                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                                    <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                                                    <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                                                    <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-block">
                                                                                <div class="row">
                                                                                    <div class="col-sm-12">
                                                                                        <p class="task-detail">Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.</p>
                                                                                    </div>
                                                                                    <!-- end of col-sm-8 -->
                                                                                </div>
                                                                                <!-- end of row -->
                                                                            </div>
                                                                            <!-- end of card-block -->
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="card b-l-info business-info services">
                                                                            <div class="card-header">
                                                                                <div class="service-header">
                                                                                    <a href="#">
                                                                                        <h5 class="card-header-text">Shivani Auto Port</h5>
                                                                                    </a>
                                                                                </div>
                                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                         </span>
                                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                                    <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                                                    <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                                                    <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-block">
                                                                                <div class="row">
                                                                                    <div class="col-sm-12">
                                                                                        <p class="task-detail">Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.</p>
                                                                                    </div>
                                                                                    <!-- end of col-sm-8 -->
                                                                                </div>
                                                                                <!-- end of row -->
                                                                            </div>
                                                                            <!-- end of card-block -->
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="card b-l-warning business-info services">
                                                                            <div class="card-header">
                                                                                <div class="service-header">
                                                                                    <a href="#">
                                                                                        <h5 class="card-header-text">Hair stylist</h5>
                                                                                    </a>
                                                                                </div>
                                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                         </span>
                                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                                    <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                                                    <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                                                    <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-block">
                                                                                <div class="row">
                                                                                    <div class="col-sm-12">
                                                                                        <p class="task-detail">Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.</p>
                                                                                    </div>
                                                                                    <!-- end of col-sm-8 -->
                                                                                </div>
                                                                                <!-- end of row -->
                                                                            </div>
                                                                            <!-- end of card-block -->
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="card b-l-danger business-info services">
                                                                            <div class="card-header">
                                                                                <div class="service-header">
                                                                                    <a href="#">
                                                                                        <h5 class="card-header-text">BMW India</h5>
                                                                                    </a>
                                                                                </div>
                                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                         </span>
                                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                                    <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                                                    <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                                                    <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-block">
                                                                                <div class="row">
                                                                                    <div class="col-sm-12">
                                                                                        <p class="task-detail">Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.</p>
                                                                                    </div>
                                                                                    <!-- end of col-sm-8 -->
                                                                                </div>
                                                                                <!-- end of row -->
                                                                            </div>
                                                                            <!-- end of card-block -->
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="card b-l-success business-info services">
                                                                            <div class="card-header">
                                                                                <div class="service-header">
                                                                                    <a href="#">
                                                                                        <h5 class="card-header-text">Shivani Hero</h5>
                                                                                    </a>
                                                                                </div>
                                                                                <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip">
                                         </span>
                                                                                <div class="dropdown-menu dropdown-menu-right b-none services-list">
                                                                                    <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i> Edit</a>
                                                                                    <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                                                                    <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i> View</a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-block">
                                                                                <div class="row">
                                                                                    <div class="col-sm-12">
                                                                                        <p class="task-detail">Lorem ipsum dolor sit amet, consectet ur adipisicing elit, sed do eiusmod temp or incidi dunt ut labore et.Lorem ipsum dolor sit amet, consecte.</p>
                                                                                    </div>
                                                                                    <!-- end of col-sm-8 -->
                                                                                </div>
                                                                                <!-- end of row -->
                                                                            </div>
                                                                            <!-- end of card-block -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h5 class="card-header-text">Profit</h5>
                                                                    </div>
                                                                    <div class="card-block">
                                                                        <div id="main" style="height:300px;width: 100%;"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- info card end -->
                                                    </div>
                                                    <!-- tab pane info end -->
                                                    <!-- tab pane contact start -->
                                                    <div class="tab-pane" id="contacts" role="tabpanel">
                                                        <div class="row">
                                                            <div class="col-xl-3">
                                                                <!-- user contact card left side start -->
                                                                <div class="card">
                                                                    <div class="card-header contact-user">
                                                                        <img class="img-radius img-40" src="..\files\assets\images\avatar-4.jpg" alt="contact-user">
                                                                        <h5 class="m-l-10">John Doe</h5>
                                                                    </div>
                                                                    <div class="card-block">
                                                                        <ul class="list-group list-contacts">
                                                                            <li class="list-group-item active"><a href="#">All Contacts</a></li>
                                                                            <li class="list-group-item"><a href="#">Recent Contacts</a></li>
                                                                            <li class="list-group-item"><a href="#">Favourite Contacts</a></li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="card-block groups-contact">
                                                                        <h4>Groups</h4>
                                                                        <ul class="list-group">
                                                                            <li class="list-group-item justify-content-between">
                                                                                Project
                                                                                <span class="badge badge-primary badge-pill">30</span>
                                                                            </li>
                                                                            <li class="list-group-item justify-content-between">
                                                                                Notes
                                                                                <span class="badge badge-success badge-pill">20</span>
                                                                            </li>
                                                                            <li class="list-group-item justify-content-between">
                                                                                Activity
                                                                                <span class="badge badge-info badge-pill">100</span>
                                                                            </li>
                                                                            <li class="list-group-item justify-content-between">
                                                                                Schedule
                                                                                <span class="badge badge-danger badge-pill">50</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h4 class="card-title">Contacts<span class="f-15"> (100)</span></h4>
                                                                    </div>
                                                                    <div class="card-block">
                                                                         
                                                                    </div>
                                                                </div>
                                                                <!-- user contact card left side end -->
                                                            </div>
                                                            <div class="col-xl-9">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <!-- contact data table card start -->
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h5 class="card-header-text">Contacts</h5>
                                                                            </div>
                                                                            <div class="card-block contact-details">
                                                                                <div class="data_table_main table-responsive dt-responsive">
                                                                                    <table id="simpletable" class="table  table-striped table-bordered nowrap">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Name</th>
                                                                                                <th>Email</th>
                                                                                                <th>Mobileno.</th>
                                                                                                <th>Favourite</th>
                                                                                                <th>Action</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="bbdad9d88a8988fbdcd6dad2d795d8d4d6">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="a3c2c1c0929190e3c4cec2cacf8dc0ccce">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="1b7a79782a29285b7c767a727735787476">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="0c6d6e6f3d3e3f4c6b616d6560226f6361">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="ccadaeaffdfeff8caba1ada5a0e2afa3a1">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="f7969594c6c5c4b7909a969e9bd994989a">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="f1909392c0c3c2b1969c90989ddf929e9c">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="7d1c1f1e4c4f4e3d1a101c1411531e1210">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="2f4e4d4c1e1d1c6f48424e4643014c4042">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="f4959697c5c6c7b49399959d98da979b99">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="55343736646766153238343c397b363a38">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="5e3f3c3d6f6c6d1e39333f3732703d3133">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="6100030250535221060c00080d4f020e0c">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="74151617454647341319151d185a171b19">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="4a2b28297b78790a2d272b232664292527">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="7312111042414033141e121a1f5d101c1e">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="9dfcfffeacafaeddfaf0fcf4f1b3fef2f0">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="7312111042414033141e121a1f5d101c1e">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="7716151446454437101a161e1b5914181a">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="2c4d4e4f1d1e1f6c4b414d4540024f4341">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="3150535200030271565c50585d1f525e5c">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td>abc1<a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="f0c2c3b0979d91999cde939f9d">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="e3828180d2d1d0a3848e828a8fcd808c8e">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star-o" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="d4b5b6b7e5e6e794b3b9b5bdb8fab7bbb9">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="c6a7a4a5f7f4f586a1aba7afaae8a5a9ab">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="8cedeeefbdbebfccebe1ede5e0a2efe3e1">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="b2d3d0d1838081f2d5dfd3dbde9cd1dddf">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="1a7b78792b28295a7d777b737634797577">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="b0d1d2d3818283f0d7ddd1d9dc9ed3dfdd">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="adcccfce9c9f9eedcac0ccc4c183cec2c0">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="5d3c3f3e6c6f6e1d3a303c3431733e3230">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="6b0a09085a59582b0c060a020745080406">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="5130333260636211363c30383d7f323e3c">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="78191a1b494a4b381f15191114561b1715">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="78191a1b494a4b381f15191114561b1715">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="1d7c7f7e2c2f2e5d7a707c7471337e7270">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="6f0e0d0c5e5d5c2f08020e0603410c0002">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="69080b0a585b5a290e04080005470a0604">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="9afbf8f9aba8a9dafdf7fbf3f6b4f9f5f7">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="9efffcfdafacaddef9f3fff7f2b0fdf1f3">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="5e3f3c3d6f6c6d1e39333f3732703d3133">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="ef8e8d8cdedddcaf88828e8683c18c8082">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="fc9d9e9fcdcecfbc9b919d9590d29f9391">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="bfdedddc8e8d8cffd8d2ded6d391dcd0d2">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="64050607555657240309050d084a070b09">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="4726252476757407202a262e2b6924282a">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="3253505103000172555f535b5e1c515d5f">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="0160636230333241666c60686d2f626e6c">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="badbd8d98b8889faddd7dbd3d694d9d5d7">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="a9c8cbca989b9ae9cec4c8c0c587cac6c4">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Garrett Winters</td>
                                                                                                <td><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="2d4c4f4e1c1f1e6d4a404c4441034e4240">[email&#160;protected]</a></td>
                                                                                                <td>9989988988</td>
                                                                                                <td><i class="fa fa-star" aria-hidden="true"></i></td>
                                                                                                <td class="dropdown">
                                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                                                                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-edit"></i>Edit</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-delete"></i>Delete</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye-alt"></i>View</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-tasks-alt"></i>Project</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-ui-note"></i>Notes</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-eye"></i>Activity</a>
                                                                                                        <a class="dropdown-item" href="#!"><i class="icofont icofont-badge"></i>Schedule</a>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                        <tfoot>
                                                                                            <tr>
                                                                                                <th>Name</th>
                                                                                                <th>Email</th>
                                                                                                <th>Mobileno.</th>
                                                                                                <th>Favourite</th>
                                                                                                <th>Action</th>
                                                                                            </tr>
                                                                                        </tfoot>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- contact data table card end -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- tab pane contact end -->
                                                    <div class="tab-pane" id="review" role="tabpanel">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-header-text">Review</h5>
                                                            </div>
                                                            <div class="card-block">
                                                                <ul class="media-list">
                                                                    <li class="media">
                                                                        <div class="media-left">
                                                                            <a href="#">
                                                                                <img class="media-object img-radius comment-img" src="..\files\assets\images\avatar-1.jpg" alt="Generic placeholder image">
                                                                            </a>
                                                                        </div>
                                                                        <div class="media-body">
                                                                            <h6 class="media-heading">Sortino media<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                            <div class="stars-example-css review-star">
                                                                                <i class="icofont icofont-star"></i>
                                                                                <i class="icofont icofont-star"></i>
                                                                                <i class="icofont icofont-star"></i>
                                                                                <i class="icofont icofont-star"></i>
                                                                                <i class="icofont icofont-star"></i>
                                                                            </div>
                                                                            <p class="m-b-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                                                            <div class="m-b-25">
                                                                                <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                            </div>
                                                                            <hr>
                                                                            <!-- Nested media object -->
                                                                            <div class="media mt-2">
                                                                                <a class="media-left" href="#">
                                                                                    <img class="media-object img-radius comment-img" src="..\files\assets\images\avatar-2.jpg" alt="Generic placeholder image">
                                                                                </a>
                                                                                <div class="media-body">
                                                                                    <h6 class="media-heading">Larry heading <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                                    <div class="stars-example-css review-star">
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                    </div>
                                                                                    <p class="m-b-0"> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                                                                    <div class="m-b-25">
                                                                                        <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <!-- Nested media object -->
                                                                                    <div class="media mt-2">
                                                                                        <div class="media-left">
                                                                                            <a href="#">
                                                                                                <img class="media-object img-radius comment-img" src="..\files\assets\images\avatar-3.jpg" alt="Generic placeholder image">
                                                                                            </a>
                                                                                        </div>
                                                                                        <div class="media-body">
                                                                                            <h6 class="media-heading">Colleen Hurst <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                                            <div class="stars-example-css review-star">
                                                                                                <i class="icofont icofont-star"></i>
                                                                                                <i class="icofont icofont-star"></i>
                                                                                                <i class="icofont icofont-star"></i>
                                                                                                <i class="icofont icofont-star"></i>
                                                                                                <i class="icofont icofont-star"></i>
                                                                                            </div>
                                                                                            <p class="m-b-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                                                                            <div class="m-b-25">
                                                                                                <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <hr>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- Nested media object -->
                                                                            <div class="media mt-2">
                                                                                <div class="media-left">
                                                                                    <a href="#">
                                                                                        <img class="media-object img-radius comment-img" src="..\files\assets\images\avatar-1.jpg" alt="Generic placeholder image">
                                                                                    </a>
                                                                                </div>
                                                                                <div class="media-body">
                                                                                    <h6 class="media-heading">Cedric Kelly<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                                    <div class="stars-example-css review-star">
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                    </div>
                                                                                    <p class="m-b-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                                                                    <div class="m-b-25">
                                                                                        <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>
                                                                            </div>
                                                                            <div class="media mt-2">
                                                                                <a class="media-left" href="#">
                                                                                    <img class="media-object img-radius comment-img" src="..\files\assets\images\avatar-4.jpg" alt="Generic placeholder image">
                                                                                </a>
                                                                                <div class="media-body">
                                                                                    <h6 class="media-heading">Larry heading <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                                    <div class="stars-example-css review-star">
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                    </div>
                                                                                    <p class="m-b-0"> Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                                                                    <div class="m-b-25">
                                                                                        <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <!-- Nested media object -->
                                                                                    <div class="media mt-2">
                                                                                        <div class="media-left">
                                                                                            <a href="#">
                                                                                                <img class="media-object img-radius comment-img" src="..\files\assets\images\avatar-3.jpg" alt="Generic placeholder image">
                                                                                            </a>
                                                                                        </div>
                                                                                        <div class="media-body">
                                                                                            <h6 class="media-heading">Colleen Hurst <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                                            <div class="stars-example-css review-star">
                                                                                                <i class="icofont icofont-star"></i>
                                                                                                <i class="icofont icofont-star"></i>
                                                                                                <i class="icofont icofont-star"></i>
                                                                                                <i class="icofont icofont-star"></i>
                                                                                                <i class="icofont icofont-star"></i>
                                                                                            </div>
                                                                                            <p class="m-b-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                                                                            <div class="m-b-25">
                                                                                                <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <hr>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="media mt-2">
                                                                                <div class="media-left">
                                                                                    <a href="#">
                                                                                        <img class="media-object img-radius comment-img" src="..\files\assets\images\avatar-2.jpg" alt="Generic placeholder image">
                                                                                    </a>
                                                                                </div>
                                                                                <div class="media-body">
                                                                                    <h6 class="media-heading">Mark Doe<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                                    <div class="stars-example-css review-star">
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                        <i class="icofont icofont-star"></i>
                                                                                    </div>
                                                                                    <p class="m-b-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                                                                    <div class="m-b-25">
                                                                                        <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                                    </div>
                                                                                    <hr>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" placeholder="Right addon">
                                                                    <span class="input-group-addon"><i class="icofont icofont-send-mail"></i></span>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- tab content end -->
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
        var table = $('#dttable').DataTable({
            processing: true,
            serverSide: true,
            bFilter: false,
            ajax: {
                url: "{{ url('admin/master-data/barang/intra/tanah/json') }}",
               
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
    @if(hasAccess(Auth::user()->role_id, "Unit", "Delete"))
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

    $('#mapLatLong').ready(() => {
            require([
            "esri/Map",
            "esri/views/MapView",
            "esri/Graphic"
            ], function(Map, MapView, Graphic ) {

                const map = new Map({
                    basemap: "osm"
                });

               
                const view = new MapView({
                    container: "mapLatLong",
                    map: map,
                    center: [107.6191, -6.9175],
                    zoom: 15,
                });
 
                let tempGraphic;
                view.on("click", function(event){
                    if($("#lat").val() != '' && $("#long").val() != ''){
                        view.graphics.remove(tempGraphic);
                    }
                    var graphic = new Graphic({
                        geometry: event.mapPoint,
                        symbol: {
                            type: "picture-marker", // autocasts as new SimpleMarkerSymbol()
                            url: "http://esri.github.io/quickstart-map-js/images/blue-pin.png",
                            width: "14px",
                            height: "24px"
                        }
                    });
                    tempGraphic = graphic;
                    $("#lat").val(event.mapPoint.latitude);
                    $("#long").val(event.mapPoint.longitude);

                    view.graphics.add(graphic);
                });
                $("#lat, #long").keyup(function () {
                    if($("#lat").val() != '' && $("#long").val() != ''){
                        view.graphics.remove(tempGraphic);
                    }
                    var graphic = new Graphic({
                        geometry: {
                            type: "point",
                            longitude: $("#long").val(),
                            latitude: $("#lat").val()
                        },
                        symbol: {
                            type: "picture-marker", // autocasts as new SimpleMarkerSymbol()
                            url: "http://esri.github.io/quickstart-map-js/images/blue-pin.png",
                            width: "14px",
                            height: "24px"
                        }
                    });
                    tempGraphic = graphic;

                    view.graphics.add(graphic);
                });
            });
        }); 
</script>
@endsection
