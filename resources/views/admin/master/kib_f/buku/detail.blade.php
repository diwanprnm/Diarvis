@extends('admin.layout.index')

@section('title') Buku (KIB F) @endsection
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
                                                    <h4>  {{$buku->nm_aset5}}</h4>
                                                    <span>Kode {{ $buku->kode_aset}}</span>
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
                                                                        @if(!empty($profile_picture))
                                                                        <img class="user-img img-radius" src="{{ asset($profile_picture->path.'/'.$profile_picture->filename) }}" style="width:108px;height:108px" alt="user-img">
                                                                        @else
                                                                        <img class="user-img img-radius" src="\assets\images\kantor.jpg" style="width:108px;height:108px" alt="user-img">
                                                                      
                                                                        @endif
                                                                    </a>
                                                                </div>
                                                                <div class="media-body row">
                                                                    <div class="col-lg-12">
                                                                        <div class="user-title">
                                                                            <h2>{{$buku->nm_aset5}}</h2>
                                                                            <span class="text-white">{{$buku->lokasi}}</span>
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
                                                                                        <h4> Informasi Detil KIB-F BUKU </h4>
                                                                                        <table class="table table-striped   nowrap">
                                                                                                <tbody>
                                                                                                
                                                                                                    <tr>
                                                                                                        <th scope="row">Kode Pemilik</th>
                                                                                                        <td>{{$buku->kd_pemilik." ".$buku->nm_pemilik}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Kode Aset</th>
                                                                                                        <td>{{$buku->kode_aset}}<br/> 
                                                                                                        <b>{{$buku->nm_aset5}}</b>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">No Register</th>
                                                                                                        <td>{{$buku->no_register}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Tanggal Dokumen</th>
                                                                                                        <td>{{$buku->dokumen_tanggal}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Nomor Dokumen</th>
                                                                                                        <td>{{$buku->dokumen_nomor}}</td>
                                                                                                    </tr>
                                                                                               
                                                                                                    <tr>
                                                                                                        <th scope="row">Tanggal Perolehan</th>
                                                                                                        <td> {{$buku->tgl_perolehan}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Tanggal Pembukuan</th>
                                                                                                        <td>{{$buku->tgl_pembukuan}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Asal Usul</th>
                                                                                                        <td>{{$buku->asal_usul}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">Kondisi</th>
                                                                                                        <td>{{$buku->kondisi}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">harga</th>
                                                                                                        <td>{{$buku->harga}}</td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th scope="row">keterangan</th>
                                                                                                        <td>{{$buku->nm_aset5}}</td>
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
                                                                                                    <a href="{{route('buku.dokumen.download',$dt->id_dokumen)}} " id="{{$dt->id_dokumen}}"  class="btn btn-primary btn-mini  waves-effect waves-light"><i class="icofont icofont-download"></i></a>
                                                                                                         
                                                                                                </td>
                                                                                                </tr>
                                                                                                    
                                                                                                     @endforeach
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <div id="preview">
                                                                                            </div>

                                                                                        </div>


                                                                                        <div class="table-responsive">
                                                                                            
                                                                                             
                                                                                            <h4>Lokasi</h4>
                                                                                       <hr/>

                                                                                       <div class="card-block user-desc">
                                                                        <div class="view-desc">
                                                                        <div id="mapLatLong" class="full-map mb-2" style="height: 300px; width: 100%"></div>
                                                                          <input id="lat" style="display:none" name="lat" type="text" value="{{ $buku->latitude }}" class="form-control formatLatLong fill" required="">
                                                                          <input id="long" name="lng" style="display:none" type="text"  value="{{ $buku->longitude }}" class="form-control formatLatLong fill" required="">     
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
                                                         
                                                        <!-- personal card end-->
                                                    </div>
                                                    <!-- tab pane personal end -->
                                                    <!-- tab pane info start -->
                                                    <div class="tab-pane" id="binfo" role="tabpanel">
                                                        <!-- info card start -->
                                                         
                                                         
                                                        <!-- info card end -->
                                                    </div>
                                                    <!-- tab pane info end -->
                                                    <!-- tab pane contact start -->
                                                  
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
    $(".chosen-select").chosen({
        width: '100%'
    });
    var table = $('#dttable').DataTable({
        processing: true,
        serverSide: true,
        bFilter: false,
        ajax: {
            url: "{{ route('getBukuJson') }}",
            // url: "{{ route('getBukuJson') }}",
           
        },

        columns: [{
                'mRender': function(data, type, full, meta) {
                    return +meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'kode_aset',
                name: 'kode_aset'
            },
            {
                data: 'kd_pemilik',
                name: 'kd_pemilik'
            },

            {
                data: 'nm_pemilik',
                name: 'nm_pemilik'
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
                data: 'asal_usul',
                name: 'asal_usul'
            }, 

            {
                data: 'harga',
                name: 'harga'
            }, 
            {
                data: 'kondisi',
                name: 'kondisi'
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
            
            ], function(Map, MapView, Graphic) {
               // var point = { type: "point", longitude: {{ $buku->latitude}}, latitude: {{ $buku->longitude}} }; 
             
               
                const map = new Map({
                    basemap: "osm"
                });
                 
                const view = new MapView({
                    container: "mapLatLong",
                    map: map,
                    center: [{{ $buku->longitude}},{{ $buku->latitude}}],
                    zoom: 16,
                });

                let tempGraphic;
                var graphic = new Graphic({
                        geometry: {
                            type: "point",
                            longitude: {{ $buku->longitude}},
                            latitude: {{ $buku->latitude}}
                        },
                        symbol: {
                            type: "picture-marker", // autocasts as new SimpleMarkerSymbol()
                            url: "{{ asset('assets/images/marker/marker1.png')}}",
                            width: "16px",
                            height: "26px"
                        }
                    });
                    tempGraphic = graphic;

                    view.graphics.add(graphic);
                    


                view.on("click", function(event){
                    if($("#lat").val() != '' && $("#long").val() != ''){
                        view.graphics.remove(tempGraphic);
                    }
                    var graphic = new Graphic({
                        geometry: event.mapPoint,
                        symbol: {
                            type: "picture-marker", // autocasts as new SimpleMarkerSymbol()
                            url: "{{ asset('assets/images/marker/marker1.png')}}",
                            width: "16px",
                            height: "26px"
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
                            url: "{{ asset('assets/images/marker/marker1.png')}}",
                            width: "16px",
                            height: "26px"
                        }
                    });
                    tempGraphic = graphic;

                    view.graphics.add(graphic);
                });
            });
         
    

    
}); 
</script>
@endsection
