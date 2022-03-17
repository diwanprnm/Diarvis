<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
    <link rel="icon" href="{{ asset('assets/images/favicon/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/feather/css/feather.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/chosen_v1.8.7/docsupport/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/chosen_v1.8.7/docsupport/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/chosen_v1.8.7/chosen.css') }}">

    <title>Map Dashboard</title>
    <style>


        html,
        body,
        #viewDiv {
            padding: 0;
            margin: 0;
            height: 100%;
            width: 100%;
            z-index: -1;
        }
        #showFilter{
          position: absolute;
          top: 15px;
          right: 15px;
        }
        #showFilter button {
          width: 32px;
          height: 32px;
          background-color: white;
          border: none;
          outline: none;
          cursor: pointer;
        }
        #filter {
          position: fixed;
          padding: 20px;
          top: 15px;
          right: 55px;
          width: 300px;
          max-height: 500px;
          overflow-y: scroll;
          transform: translate(1200px, 0);
          transition: transform 0.3s ease-in-out;
        }
        #filter.open {
          transform: translate(0, 0);
        }
        #filter .form-group > *{
          font-size: 13px;
          margin:0px;
        }
        #logo {
        display: block;
        position: absolute;
        top: 30px;
        right: 80px;
        }
        #showBaseMaps {
            position: absolute;
          top: 47.5px;
          right: 15px;
        }
        #showBaseMaps button {
            width: 32px;
          height: 32px;
          background-color: white;
          border: none;
          outline: none;
          cursor: pointer;
        }
        #fullscreen{
          position: absolute;
          top: 81px;
          right: 15px;
        }
        #fullscreen button {
            width: 32px;
          height: 32px;
          background-color: white;
          border: none;
          outline: none;
          cursor: pointer;
        }
        .form-group {
            margin-bottom: 1px;
        }
        #back {
            position: absolute;
            top: 114px;
            right: 15px;
        }
        #back button {
            width: 32px;
          height: 32px;
          background-color: white;
          border: none;
          outline: none;
          cursor: pointer;
        }
        #baseMaps {
          position: fixed;
          padding: 15px;
          top: 15px;
          right: 55px;
          width: 320px;
          max-height: 500px;
          transform: translate(1200px, 0);
          transition: transform 0.3s ease-in-out;
          overflow-y: scroll;

        }
        #baseMaps.open {
          transform: translate(0, 0);
        }
        #baseMaps .listMaps ul.row {
            display: flex;
        }
        #baseMaps .listMaps ul li{
            padding: 0;
            margin: 5px;
            list-style: none;
        }
        #baseMaps .listMaps ul li button{
            border: 1px solid #222;
            padding: 0;
        }
        #baseMaps .listMaps ul li button:hover {
            border: 3px solid green;
        }
        #baseMaps .listMaps ul li button:focus {
            border: 3px solid green;
        }
        #baseMaps .listMaps ul li img{
            display: block;
            width: 84px;
            background-position: center;
            object-fit: cover;
        }
        #legend {
            display: block;
            position: fixed;
            bottom: 20px;
            left: 15px;
            padding: 10px;
            border-radius: 10px;
            max-width: 200px;
            font-size: 15px;
            color: #eee;
            background: rgba(0, 0, 0, 0.3);
        }
        .strip {
            max-width: 100%;
            height: 3px;
        }
    </style>
    <link rel="stylesheet" href="https://js.arcgis.com/4.17/esri/themes/light/main.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
    <div id="viewDiv"></div>
    <div id="showFilter">
      <button data-toggle="tooltip" data-placement="right" title="Fitur Filter">
        <i class="feather icon-list"></i>
      </button>
    </div>
    <div id="showBaseMaps">
        <button data-toggle="tooltip" data-placement="right" title="Fitur Filter">
            <i class="feather icon-map"></i>
        </button>
    </div>
    <div id="fullscreen">
        <button data-toggle="tooltip" data-placement="right" title="Fullscreen / Normal">
            <i class="feather icon-maximize full-card"></i>
        </button>
    </div>
    <div id="back">
        <a href="{{ url('/admin/monitoring/proyek-kontrak') }}">
            <button data-toggle="tooltip" data-placement="right" title="Kembali kehalaman Sebelumnya">
                <i class="feather icon-arrow-left"></i>
            </button>
        </a>
    </div>
    <div id="logo">
        <img width="200" class="img-fluid" src="{{ asset('assets/images/brand/text_putih.png')}}" alt="Logo DBMPR">
    </div>
    <div id="legend">
        <div class="ruas-jalan mb-2">
            <div class="row">
                <div class="col-3 pr-0">
                    <div class="strip mt-2 bg-warning"></div>
                </div>
                <div class="col">Jalan Tol</div>
            </div>
            <div class="row">
                <div class="col-3 pr-0">
                    <div class="strip mt-2 bg-white"></div>
                </div>
                <div class="col">Kabupaten</div>
            </div>
            <div class="row">
                <div class="col-3 pr-0">
                    <div class="strip mt-2 bg-success"></div>
                </div>
                <div class="col">Provinsi</div>
            </div>
            <div class="row">
                <div class="col-3 pr-0">
                    <div class="strip mt-2 bg-danger"></div>
                </div>
                <div class="col">Nasional</div>
            </div>
        </div>
        <div class="general">
            <div class="row">
                <div class="col-3">
                    <img width="25px" src="{{ asset('assets/images/marker/rawanbencana.png')}}" alt="Rawan Bencana">
                </div>
                <div class="col"><p>Rawan Bencana</p></div>
            </div>
            <div class="row">
                <div class="col-3">
                    <img width="25px" src="{{ asset('assets/images/marker/pembangunan.png')}}" alt="Pembangunan">
                </div>
                <div class="col"><p>Pembangunan</p></div>
            </div>
            <div class="row">
                <div class="col-3">
                    <img width="25px" src="{{ asset('assets/images/marker/peningkatan.png')}}" alt="Peningkatan">
                </div>
                <div class="col"><p>Peningkatan</p></div>
            </div>
            <div class="row">
                <div class="col-3">
                    <img width="25px" src="{{ asset('assets/images/marker/rehabilitasi.png')}}" alt="Rehabilitasi">
                </div>
                <div class="col"><p>Rehabilitasi</p></div>
            </div>
            <div class="row">
                <div class="col-3">
                    <img width="25px" src="{{ asset('assets/images/marker/pemeliharaan.png')}}" alt="Pemeliharaan">
                </div>
                <div class="col"><p>Pemeliharaan</p></div>
            </div>
            <div class="row">
                <div class="col-3">
                    <img width="25px" src="{{ asset('assets/images/marker/vehiclecounting.png')}}" alt="vehicle Counting">
                </div>
                <div class="col"><p>Vehicle Counting</p></div>
            </div>
            <div class="row">
                <div class="col-3">
                    <img width="25px" src="{{ asset('assets/images/marker/jembatan.png')}}" alt="jembatan">
                </div>
                <div class="col"><p>Jembatan</p></div>
            </div>
        </div>
    </div>
    <div id="filter" class="bg-white">
        <div id="preloader" style="display:none">
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
            </div>
        </div>
        <form class="py-3">
            {{-- <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-sm btn-block btn-secondary clustering">Disable Clustering</button>
                </div>
            </div>
            <hr> --}}
            <div class="form-group">
                <label for="kegiatan"><i class="feather icon-target text-primary"></i> UPTD</label>
                <select class="form-control chosen-select chosen-select-uptd" id="uptd" multiple data-placeholder="Pilih UPTD">
                    <option value=""></option>
                </select>
            </div>
            <div class="form-group">
                <label for="uptdSpp"><i class="feather icon-corner-down-right text-danger"></i> SPP / SUP</label>
                <select id="spp_filter" data-placeholder="Pilih UPTD dengan SPP"  class="chosen-select" multiple tabindex="6">
                    <option value=""></option>
                </select>
            </div>
            <div class="form-group">
                <label for="kegiatan"><i class="feather icon-activity text-warning"></i> Kegiatan</label>
                <select data-placeholder="Pilih kegiatan" multiple class="chosen-select" tabindex="8" id="kegiatan">
                    <option value="ruasjalan">Ruas Jalan</option>
                    <option value="pembangunan">Pembangunan</option>
                    <option value="peningkatan">Peningkatan</option>
                    <option value="rehabilitasi">Rehabilitasi</option>
                    <option value="jembatan">Jembatan</option>
                    <option value="datarawanbencana">Data Rawan Bencana</option>
                </select>
            </div>
            <div class="form-group">
                <label for="proyek"><i class="feather icon-calendar text-success"></i> Proyek Kontrak</label>
                <select class="chosen-select form-control" id="proyek" data-placeholder="Pilih kegiatan" multiple tabindex="4">
                    <option value="onprogress">On-Progress</option>
                    <option value="critical">Critical Contract</option>
                    <option value="offprogress">Off Progress</option>
                    <option value="finish">Finish</option>
                </select>
            </div>
            <!-- <div class="form-group">
                <label for="basemap">Basemap</label>
                <select data-placeholder="Basemap..." class="chosen-select form-control" id="basemap" tabindex="-1">
                    <option value="streets">Street</option>
                    <option value="hybrid" selected>Hybrid</option>
                    <option value="satellite">Satelite</option>
                    <option value="topo">Topo</option>
                    <option value="gray">Gray</option>
                    <option value="national-geographic">National Geographic</option>
                </select>
            </div> -->
            <div class="form-group">
                <label for="exampleFormControlSelect1"><i class="feather icon-zoom-in"></i> Zoom</label>
                <select class="chosen-select form-control" id="zoom">
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8" selected>8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </div>
        </form>
    </div>
    <div id="baseMaps" class="bg-white">
            {{-- <div class="row">
                <div class="col">
                    <h6>Tipe Maps</h6>
                </div>
                <div class="col p-0">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-success active">
                            <input type="radio" name="options" id="option1" autocomplete="off" checked>2D
                        </label>
                        <label class="btn btn-success">
                            <input type="radio" name="options" id="option2" autocomplete="off"> 3D
                        </label>
                    </div>
                </div>
            </div>
            <hr> --}}
            <div class="listMaps">
                <div class="row mb-4">
                    <div class="col">
                       <h6>Tampilan jenis maps</h6>
                    </div>
                </div>
                <ul class="row">
                    <li>
                        <button class="baseMapBtn" data-map="streets">
                            <img _ngcontent-btg-c5="" alt="Rupa Bumi Indonesia" title="Rupa Bumi Indonesia"
                            src="https://portal.ina-sdi.or.id/arcgis/rest/services/RBI/Basemap/MapServer/info/thumbnail">
                        </button>
                    </li>
                    <li>
                        <button class="baseMapBtn" data-map="gray">
                            <img _ngcontent-pmm-c5="" alt="Cartodb Light All" title="Cartodb Light All"
                            src="https://satupeta-dev.digitalservice.id/assets/img/basemap-thumbnail/cartodb_light.png">
                        </button>
                    </li>
                    <li>
                        <button class="baseMapBtn" data-map="streets-night-vector">
                            <img _ngcontent-vgg-c5="" alt="Cartodb Dark All" title="Streets Night Vector"
                            src="https://satupeta-dev.digitalservice.id/assets/img/basemap-thumbnail/cartodb_dark.png">
                        </button>
                    </li>
                    <li>
                        <button class="baseMapBtn" data-map="national-geographic">
                            <img _ngcontent-vgg-c5="" alt="National Geographic" title="National Geographic"
                            src="https://js.arcgis.com/4.14/esri/images/basemap/national-geographic.jpg">
                        </button>
                    </li>
                    <li>
                        <button class="baseMapBtn" data-map="topo">
                            <img _ngcontent-lqn-c5="" alt="Topographic" title="Topographic"
                            src="https://satupeta-dev.digitalservice.id/assets/img/basemap-thumbnail/topo.png"></button></li>
                        </button>
                    </li>
                    <li>
                        <button class="baseMapBtn" data-map="dark-gray">
                            <img _ngcontent-lqn-c5="" alt="Dark Gray" title="Dark Gray"
                            src="https://js.arcgis.com/4.14/esri/images/basemap/dark-gray.jpg">
                        </button>
                    </li>
                    <li>
                        <button class="baseMapBtn" data-map="osm">
                            <img _ngcontent-lqn-c5="" alt="Open Street Map" title="Open Street Map"
                            src="https://js.arcgis.com/4.14/esri/images/basemap/osm.jpg">
                        </button>
                    </li>
                    <li>
                        <button class="baseMapBtn" data-map="hybrid">
                            <img _ngcontent-lqn-c5="" alt="hybrid" title="hybrid"
                            src="https://js.arcgis.com/4.14/esri/images/basemap/hybrid.jpg">
                        </button>
                    </li>
                    <li>
                        <button class="baseMapBtn" data-map="terrain">
                            <img _ngcontent-lqn-c5="" alt="terrain" title="terrain"
                            src="https://js.arcgis.com/4.14/esri/images/basemap/terrain.jpg">
                        </button>
                    </li>
                </ul>
            </div>
    </div>
</body>
<script>
  // tonggle filter
  const showFilterElmnt = document.querySelector("#showFilter");
  const filter = document.querySelector("#filter");
  const mainElement = document.querySelector("#viewDiv");
  const showBaseMapsElmnt = document.querySelector("#showBaseMaps");
  const baseMaps = document.querySelector("#baseMaps");

  //create chevron elmn
  let chevron = document.createElement('i');
  chevron.setAttribute('class', 'feather icon-chevrons-right')

  showFilterElmnt.addEventListener("click", event => {
      filter.classList.toggle("open");
      event.stopPropagation();
  });

  showBaseMapsElmnt.addEventListener("click", event => {
      baseMaps.classList.toggle("open");
      event.stopPropagation();
  });

  mainElement.addEventListener("click", event => {
    filter.classList.remove("open");
    baseMaps.classList.remove("open");
    event.stopPropagation();
  })

  //toggle fullscreen
  function getFullscreenElement() {
      return document.fullscreenElement
        || document.webkitFullscreenElement
        || document.mozFullscreenElement
        || document.msFullscreenElement;
  }

  function toggleFullscreen() {
      if(getFullscreenElement()) {
        document.exitFullscreen();
      } else {
        document.documentElement.requestFullscreen().catch((e) => {
          console.log(e);
        });
      }
  }

  const fullScreenElemn =  document.querySelector('#fullscreen');
  fullScreenElemn.addEventListener('click', () => {
    toggleFullscreen();
  });

// <!-- enable clustering -->
  const clusteringElmn = document.querySelector('.clustering');
</script>

<!-- chosen -->

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://js.arcgis.com/4.17/"></script>

<script type="text/javascript" src="{{ asset('assets/vendor/chosen_v1.8.7/chosen.jquery.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/chosen_v1.8.7/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>

<script>
    function fillSUP(uptd){
        return new Promise(function (resolve, reject) {
            $.ajax({
                type:"POST",
                url: "{{ route('api.supdata') }}",
                data: {uptd:uptd},
                success: function(response){
                    $("#spp_filter").empty();
                    let len = ''; let spp = '';
                    if(response['data'] != null){
                        len = response['data']['uptd'];
                        spp = response['data']['spp'];
                    }
                    if(len.length > 0){
                        // Read data and create <option>
                        let select = '';
                        for(let i=0; i<len.length; i++){
                            select += '<optgroup label='+len[i]+'>' ;
                            select +='';
                            for(let j=0; j<spp.length; j++){
                                if(len[i] == spp[j].UPTD) {
                                    select +='<option '+ 'value="'+spp[j].SUP+'" selected>'+spp[j].SUP+'</option>';
                                }
                            }
                            select +='</optgroup>';
                        }

                        $('#spp_filter').html(select).trigger('liszt:updated');
                        $('#spp_filter').trigger("chosen:updated");
                        // $('#spp_filter .chosen-select').append("<li id='spp_filter" + id + "' class='active-result' style>" +name+ "</li>");
                    }
                    $("#preloader").hide();
                    return resolve($("#spp_filter").val());
                }
            });
        });
    }
    async function getSUPData() {
        const uptd =   $("#uptd").val();
        let data = [];
        $("#preloader").show();
        // getMapData(uptd,basemap);
        // option = "";
        if (uptd.length == 0){
            $("#spp_filter").empty();
            $('#spp_filter').trigger("chosen:updated");
        }else{
            data = await fillSUP(uptd);
        }
        return data;
    }
    function initFilter(){
        $("#uptd").empty();
        const roleUptd = `{{ Auth::user()->internalRole->uptd }}`;
        select = "";
        if(roleUptd == ""){
            for(let i=1; i <= 6; i++){
                select += `<option value="uptd${i}">UPTD ${i}</option>`;
            }
        }else{
            select += `<option value="${roleUptd}">UPTD ${roleUptd.replace('uptd','')}</option>`;
        }
        $('#uptd').html(select).trigger('liszt:updated');
        $('#uptd').trigger("chosen:updated");

        $("#spp_filter").empty();
        $('#spp_filter').trigger("chosen:updated");

        $("#kegiatan").empty();
        kegiatan = `<option value="ruasjalan">Ruas Jalan</option>
                    <option value="pembangunan">Pembangunan</option>
                    <option value="peningkatan">Peningkatan</option>
                    <option value="rehabilitasi">Rehabilitasi</option>
                    <option value="pemeliharaan">Pemeliharaan</option>
                    <option value="vehiclecounting">Vehicle Counting</option>
                    <option value="kemantapanjalan">Kemantapan Jalan</option>
                    <option value="jembatan">Jembatan</option>
                    <option value="rawanbencana">Rawan Bencana</option>`;
        $('#kegiatan').html(kegiatan).trigger('liszt:updated');
        $('#kegiatan').trigger("chosen:updated");

        $("#proyek").empty();
        proyek = `<option value="onprogress">On-Progress</option>
                    <option value="criticalprogress">Critical Contract</option>
                    <option value="offprogress">Off Progress</option>
                    <option value="finishprogress">Finish</option>`;
        $('#proyek').html(proyek).trigger('liszt:updated');
        $('#proyek').trigger("chosen:updated");

    }
    function difference(array1, array2) {
        let result = [];
        for (let i = 0; i < array1.length; i++) {
            if (array2.indexOf(array1[i]) === -1) {
                result.push(array1[i]);
            }
        }
        return result;
    }
    $(document).ready(function () {
        initFilter();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let basemap = "hybrid";

        const config = {
            '.chosen-select'           : { width: '100%', padding: '0'},
            '.chosen-select-deselect'  : { allow_single_deselect: true },
            '.chosen-select-no-single' : { disable_search_threshold: 10 },
            '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
            '.chosen-select-rtl'       : { rtl: true },
            '.chosen-select-width'     : { width: '95%' }
        };
        for (let selector in config) {
            $(selector).chosen(config[selector]);
        }
        $("#spp_filter, #kegiatan").chosen().change(function(){
            const sup = $("#spp_filter").val();
            const kegiatan = $("#kegiatan").val();
            kegiatan.push("progressmingguan");
            getMapData(sup, kegiatan);
        });

        $("#uptd").chosen().change(async function(){
            const sup = await getSUPData();
            const kegiatan = $("#kegiatan").val();
            kegiatan.push("progressmingguan");
            getMapData(sup, kegiatan);
        });

        function getMapData(sup, kegiatan) {
            require([
                "esri/Map",
                "esri/views/MapView",
                "esri/request",
                "esri/geometry/Point",
                "esri/Graphic",
                "esri/layers/GraphicsLayer",
                "esri/layers/GroupLayer",
                "esri/tasks/RouteTask",
                "esri/tasks/support/RouteParameters",
                "esri/tasks/support/FeatureSet",
                "esri/layers/FeatureLayer" // dimz-add
            ], function (Map, MapView, esriRequest, Point, Graphic, GraphicsLayer,
                        GroupLayer, RouteTask, RouteParameters, FeatureSet, FeatureLayer) { // dimz-add

                // Map Initialization
                const baseUrl = "{{url('/')}}";
                const map = new Map({
                    basemap: basemap
                });
                const view = new MapView({
                    container: "viewDiv",
                    map: map,
                    center: [107.6191, -6.9175], // longitude, latitude
                    zoom: 9
                });

                const gsvrUrl = "{{ env('GEOSERVER') }}";

                // dimz-add

                let rutejalanLayer = new GroupLayer();
                let kemantapanjalanLayer = new FeatureLayer({
                    url: gsvrUrl+"/geoserver/gsr/services/temanjabar/FeatureServer/1/",
                });

                // end dimz-add
                let jembatanLayer = new GraphicsLayer();
                let pembangunanLayer = new GraphicsLayer();
                let peningkatanLayer = new GraphicsLayer();
                let rehabilitasiLayer = new GraphicsLayer();
                let pemeliharaanLayer = new GraphicsLayer();
                let progressLayer = new GraphicsLayer();
                let vehiclecountingLayer = new GraphicsLayer();
                let allProgressLayer = new GroupLayer();

                // Request API
                const requestUrl = baseUrl + '/api/map/dashboard/data';
                const requestBody = new FormData();
                for (i in kegiatan) { requestBody.append("kegiatan[]",kegiatan[i]); }
                for (i in sup) { requestBody.append("sup[]",sup[i]); }

                const requestApi = esriRequest(requestUrl, {
                    responseType: "json",
                    method: "post",
                    body: requestBody
                }).then(function (response) {
                    const json = response.data;
                    const data = json.data;
                    if(json.status === "success"){
                        rutejalanLayer = addRuteJalan(rutejalanLayer);
                        pembangunanLayer = addPembangunan(data.pembangunan, pembangunanLayer);
                        peningkatanLayer = addPeningkatan(data.peningkatan, peningkatanLayer);
                        rehabilitasiLayer = addRehabilitasi(data.rehabilitasi, rehabilitasiLayer);
                        jembatanLayer = addJembatan(data.jembatan, jembatanLayer);
                        pemeliharaanLayer = addPemeliharaan(data.pemeliharaan, pemeliharaanLayer);
                        vehiclecountingLayer = addVehicleCounting(data.vehiclecounting, vehiclecountingLayer);
                        kemantapanjalanLayer = addKemantapanJalan(data.kemantapanjalan, kemantapanjalanLayer);

                        allProgressLayer = addProgressGroup(data.progressmingguan);
                        map.add(allProgressLayer);

                        $("#proyek").chosen().change(function() {
                            const proyek = $("#proyek").val();
                            const allProyek = ["onprogress","criticalprogress","offprogress","finishprogress"];
                            const diff = difference(allProyek, proyek);

                            for(i in proyek){
                                allProgressLayer.findLayerById(proyek[i]).visible = true;
                            }
                            for(i in diff){
                                allProgressLayer.findLayerById(diff[i]).visible = false;
                            }
                        });
                    }
                }).catch(function(error){
                    console.log(error);
                });

                // Creating Group Layer
                const groupLayer = new GroupLayer();
                groupLayer.add(jembatanLayer);
                if ($.inArray('ruasjalan', $('#kegiatan').val()) >= 0 && $('#uptd').val().length != 0) {groupLayer.add(rutejalanLayer);} // dimz-add
                groupLayer.add(pemeliharaanLayer);
                groupLayer.add(pembangunanLayer);
                groupLayer.add(peningkatanLayer);
                groupLayer.add(rehabilitasiLayer);
                groupLayer.add(vehiclecountingLayer);
                if ($.inArray('kemantapanjalan', $('#kegiatan').val()) >= 0 && $('#uptd').val().length != 0) {groupLayer.add(kemantapanjalanLayer);} // dimz-add
                map.add(groupLayer);

                $(".baseMapBtn").click(function(event){
                    basemap = $(this).data('map');
                    map.basemap = basemap;
                });
                $("#zoom").change(function(){
                    const zoom = this.value;
                    view.zoom = zoom;
                });


                function addPembangunan(pembangunan, layer) {
                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/pembangunan.png",
                        width: "28px",
                        height: "28px"
                    };
                    const popupTemplate = {
                        title: "{NAMA_PAKET}",
                        content: [{
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "NOMOR_KONTRAK",
                                    label: "Nomor Kontrak"
                                },
                                {
                                    fieldName: "TGL_KONTRAK",
                                    label: "Tanggal Kontrak"
                                },
                                {
                                    fieldName: "WAKTU_PELAKSANAAN_HK",
                                    label: "Waktu Kontrak (Hari Kerja)"
                                },
                                {
                                    fieldName: "KEGIATAN",
                                    label: "Jenis Pekerjaan"
                                },
                                {
                                    fieldName: "JENIS_PENANGANAN",
                                    label: "Jenis Penanganan"
                                },
                                {
                                    fieldName: "RUAS_JALAN",
                                    label: "Ruas Jalan"
                                },
                                {
                                    fieldName: "LAT",
                                    label: "Latitude"
                                },
                                {
                                    fieldName: "LNG",
                                    label: "Longitude"
                                },
                                {
                                    fieldName: "LOKASI",
                                    label: "Lokasi"
                                },
                                {
                                    fieldName: "SUP",
                                    label: "SUP"
                                },
                                {
                                    fieldName: "NILAI_KONTRAK",
                                    label: "Nilai Kontrak"
                                },
                                {
                                    fieldName: "PAGU_ANGGARAN",
                                    label: "Pagu Anggaran"
                                },
                                {
                                    fieldName: "PENYEDIA_JASA",
                                    label: "Penyedia Jasa"
                                },
                                {
                                    fieldName: "UPTD",
                                    label: "UPTD"
                                }
                            ]}
                    ]};
                    pembangunan.forEach(item => {
                        let point = new Point(item.LNG, item.LAT);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                    });
                    return layer;
                }
                function addPeningkatan(peningkatan, layer) {
                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/peningkatan.png",
                        width: "28px",
                        height: "28px"
                    };
                    const popupTemplate = {
                        title: "{NAMA_PAKET}",
                        content: [{
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "NOMOR_KONTRAK",
                                    label: "Nomor Kontrak"
                                },
                                {
                                    fieldName: "TGL_KONTRAK",
                                    label: "Tanggal Kontrak"
                                },
                                {
                                    fieldName: "WAKTU_PELAKSANAAN_HK",
                                    label: "Waktu Kontrak (Hari Kerja)"
                                },
                                {
                                    fieldName: "KEGIATAN",
                                    label: "Jenis Pekerjaan"
                                },
                                {
                                    fieldName: "JENIS_PENANGANAN",
                                    label: "Jenis Penanganan"
                                },
                                {
                                    fieldName: "RUAS_JALAN",
                                    label: "Ruas Jalan"
                                },
                                {
                                    fieldName: "LAT",
                                    label: "Latitude"
                                },
                                {
                                    fieldName: "LNG",
                                    label: "Longitude"
                                },
                                {
                                    fieldName: "LOKASI",
                                    label: "Lokasi"
                                },
                                {
                                    fieldName: "SUP",
                                    label: "SUP"
                                },
                                {
                                    fieldName: "NILAI_KONTRAK",
                                    label: "Nilai Kontrak"
                                },
                                {
                                    fieldName: "PAGU_ANGGARAN",
                                    label: "Pagu Anggaran"
                                },
                                {
                                    fieldName: "PENYEDIA_JASA",
                                    label: "Penyedia Jasa"
                                },
                                {
                                    fieldName: "UPTD",
                                    label: "UPTD"
                                }
                            ]
                        }
                    ]};
                    peningkatan.forEach(item => {
                        let point = new Point(item.LNG, item.LAT);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                        console.log("PEMBANGAN");
                    });
                    return layer;
                }
                function addRehabilitasi(rehabilitasi, layer) {
                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/rehabilitasi.png",
                        width: "32px",
                        height: "32px"
                    };
                    const popupTemplate = {
                        title: "{NAMA_PAKET}",
                        content: [{
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "NOMOR_KONTRAK",
                                    label: "Nomor Kontrak"
                                },
                                {
                                    fieldName: "TGL_KONTRAK",
                                    label: "Tanggal Kontrak"
                                },
                                {
                                    fieldName: "WAKTU_PELAKSANAAN_HK",
                                    label: "Waktu Kontrak (Hari Kerja)"
                                },
                                {
                                    fieldName: "KEGIATAN",
                                    label: "Jenis Pekerjaan"
                                },
                                {
                                    fieldName: "JENIS_PENANGANAN",
                                    label: "Jenis Penanganan"
                                },
                                {
                                    fieldName: "RUAS_JALAN",
                                    label: "Ruas Jalan"
                                },
                                {
                                    fieldName: "LAT",
                                    label: "Latitude"
                                },
                                {
                                    fieldName: "LNG",
                                    label: "Longitude"
                                },
                                {
                                    fieldName: "LOKASI",
                                    label: "Lokasi"
                                },
                                {
                                    fieldName: "SUP",
                                    label: "SUP"
                                },
                                {
                                    fieldName: "NILAI_KONTRAK",
                                    label: "Nilai Kontrak"
                                },
                                {
                                    fieldName: "PAGU_ANGGARAN",
                                    label: "Pagu Anggaran"
                                },
                                {
                                    fieldName: "PENYEDIA_JASA",
                                    label: "Penyedia Jasa"
                                },
                                {
                                    fieldName: "UPTD",
                                    label: "UPTD"
                                }
                            ]}
                    ]};
                    rehabilitasi.forEach(item => {
                        let point = new Point(item.LNG, item.LAT);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                    });
                    return layer;
                }
                function addJembatan(jembatan, layer) {
                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/jembatan.png",
                        width: "24px",
                        height: "24px"
                    };
                    const popupTemplate = {
                        title: "{NAMA_JEMBATAN}",
                        content: [{
                        type: "fields",
                        fieldInfos: [
                            {
                                fieldName: "PANJANG",
                                label: "Panjang"
                            },
                            {
                                fieldName: "LEBAR",
                                label: "Lebar"
                            },
                            {
                                fieldName: "RUAS_JALAN",
                                label: "Ruas Jalan"
                            },
                            {
                                fieldName: "LAT",
                                label: "Latitude"
                            },
                            {
                                fieldName: "LNG",
                                label: "Longitude"
                            },
                            {
                                fieldName: "LOKASI",
                                label: "Lokasi"
                            },
                            {
                                fieldName: "SUP",
                                label: "SUP"
                            },
                            {
                                fieldName: "UPTD",
                                label: "UPTD"
                            }
                        ]},
                            {
                                type: "media",
                                mediaInfos: [
                                    {
                                        title: "<b>Foto Pekerjaan</b>",
                                        type: "image",
                                        value: {
                                            sourceURL:
                                                baseUrl + "/assets/images/sample/sample.png"
                                        }
                                    }
                                ]
                            }
                    ]};
                    jembatan.forEach(item => {
                        let point = new Point(item.LNG, item.LAT);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                    });
                    return layer;
                }
                function addPemeliharaan(pemeliharaan, layer) {
                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/pemeliharaan.png",
                        width: "28px",
                        height: "28px"
                    };
                    const popupTemplate = {
                        title: "{RUAS_JALAN}",
                        content: [{
                        type: "fields",
                        fieldInfos: [
                            {
                                fieldName: "TANGGAL",
                                label: "Tanggal"
                            },
                            {
                                fieldName: "JENIS_PEKERJAAN",
                                label: "Jenis Pekerjaan"
                            },
                            {
                                fieldName: "NAMA_MANDOR",
                                label: "Nama Mandor"
                            },
                            {
                                fieldName: "PANJANG",
                                label: "Panjang "
                            },
                            {
                                fieldName: "PERALATAN",
                                label: "Peralatan"
                            },
                            {
                                fieldName: "LAT",
                                label: "Latitude"
                            },
                            {
                                fieldName: "LNG",
                                label: "Longitude"
                            },
                            {
                                fieldName: "LOKASI",
                                label: "Lokasi"
                            },
                            {
                                fieldName: "SUP",
                                label: "SUP"
                            },
                            {
                                fieldName: "UPTD",
                                label: "UPTD"
                            }
                        ]},
                            {
                            type: "media",
                            mediaInfos: [
                                {
                                    title: "<b>Foto Pekerjaan</b>",
                                    type: "image",
                                    value: {
                                        sourceURL:
                                            baseUrl + "/assets/images/sample/sample.png"
                                    }
                                }
                            ]
                            },
                            {
                                title: "<b>Video Pekerjaan</b>",
                                type: "custom",
                                outFields: ["*"],
                                creator: function(graphic) {
                                    return `
                                    <div class="esri-feature-media__item">
                                        <video controls class="esri-feature-media__item">
                                            <source src="${baseUrl}/assets/videos/sample.mp4" type="video/mp4">
                                        </video>
                                    </div>`;
                                }
                            }
                    ]};
                    pemeliharaan.forEach(item => {
                        let point = new Point(item.LNG, item.LAT);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                    });
                    return layer;
                }
                // dimz-edit
                function addRuteJalan(groupLayer) {
                    const provinsiLayer = jalanProvinsi();
                    const nasionalLayer = jalanNasional();
                    const tolOperasiLayer = jalanTolOperasi();
                    const tolKonstruksiLayer = jalanTolKonstruksi();
                    const gerbangLayer = gerbangTol();

                    function jalanProvinsi() {
                        const layer = new FeatureLayer({url: gsvrUrl+"/geoserver/gsr/services/temanjabar/FeatureServer/0/"});
                        const popupTemplate = {
                            title: "{nm_ruas}",
                            content: [{
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "IDruas",
                                    label: "Kode Ruas"
                                },
                                {
                                    fieldName: "LAT_AWAL",
                                    label: "Latitude 0"
                                },
                                {
                                    fieldName: "LONG_AWAL",
                                    label: "Longitude 0"
                                },
                                {
                                    fieldName: "LAT_AKHIR",
                                    label: "Latitude 1"
                                },
                                {
                                    fieldName: "LONG_AKHIR",
                                    label: "Longitude 1"
                                },
                                {
                                    fieldName: "kab_kota",
                                    label: "Kab/Kota"
                                },
                                {
                                    fieldName: "wil_uptd",
                                    label: "UPTD"
                                },
                                {
                                    fieldName: "nm_sppjj",
                                    label: "SUP"
                                },
                                {
                                    fieldName: "expression/pjg_km",
                                }
                            ]}],
                            expressionInfos: [{
                                name: "pjg_km",
                                title: "Panjang Ruas (KM)",
                                expression: "Round($feature.pjg_ruas_m / 1000, 2)"
                            }]
                        };
                        if ($.inArray('ruasjalan', $('#kegiatan').val()) >= 0 && $('#uptd').val().length != 0) {
                            var uptdSel = $('#uptd').val();
                            var whereUptd = 'uptd=' + uptdSel.shift().charAt(4);
                            $.each(uptdSel, function(idx, elem) {
                                whereUptd = whereUptd + ' OR uptd=' + elem.charAt(4);
                            });
                            layer.popupTemplate = popupTemplate;
                            layer.definitionExpression = whereUptd;
                            layer.renderer = {
                                type: "simple",  // autocasts as new SimpleRenderer()
                                symbol: {
                                    type: "simple-line",  // autocasts as new SimpleLineSymbol()
                                    color: "green",
                                    width: "2px",
                                    style: "solid",
                                    marker: { // autocasts from LineSymbolMarker
                                        color: "orange",
                                        placement: "begin-end",
                                        style: "circle"
                                    }
                                }
                            }

                        } else {
                            layer.definitionExpression= '0=1';
                        }
                        return layer;
                    }

                    function jalanNasional() {
                        const layer = new FeatureLayer({url: gsvrUrl+"/geoserver/gsr/services/temanjabar/FeatureServer/3/"});
                        const popupTemplate = {
                            title: "{NAMA_SK}",
                            content: [{
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "NO_RUAS",
                                    label: "Nomor Ruas"
                                },
                                {
                                    fieldName: "PJG_SK",
                                    label: "Panjang (KM)"
                                },
                                {
                                    fieldName: "KLS_JALAN",
                                    label: "Kelas Jalan"
                                },
                                {
                                    fieldName: "LINTAS",
                                    label: "Lintas"
                                },
                                {
                                    fieldName: "TAHUN",
                                    label: "Tahun"
                                }
                            ]}]
                        };
                        layer.popupTemplate = popupTemplate;
                        layer.renderer = {
                            type: "simple",  // autocasts as new SimpleRenderer()
                            symbol: {
                                type: "simple-line",  // autocasts as new SimpleLineSymbol()
                                color: "red",
                                width: "2px",
                                style: "solid",
                                marker: { // autocasts from LineSymbolMarker
                                    color: "orange",
                                    placement: "begin-end",
                                    style: "circle"
                                }
                            }
                        }
                        return layer;
                    }

                    function jalanTolOperasi() {
                        const layer = new FeatureLayer({url: gsvrUrl+"/geoserver/gsr/services/temanjabar/FeatureServer/4/"});
                        const popupTemplate = {
                            title: "{NAMA}",
                            content: [{
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "PANJANG",
                                    label: "Nomor Ruas"
                                },
                                {
                                    fieldName: "PENGELOLA",
                                    label: "Pengelola"
                                },
                                {
                                    fieldName: "STATUS",
                                    label: "Status"
                                },
                                {
                                    fieldName: "Kabupaten",
                                    label: "Kabupaten"
                                },
                                {
                                    fieldName: "Propinsi",
                                    label: "Propinsi"
                                }
                            ]}]
                        };
                        layer.popupTemplate = popupTemplate;
                        layer.renderer = {
                            type: "simple",  // autocasts as new SimpleRenderer()
                            symbol: {
                                type: "simple-line",  // autocasts as new SimpleLineSymbol()
                                color: "yellow",
                                width: "2px",
                                style: "solid",
                                marker: { // autocasts from LineSymbolMarker
                                    color: "orange",
                                    placement: "begin-end",
                                    style: "circle"
                                }
                            }
                        }
                        return layer;
                    }

                    function jalanTolKonstruksi() {
                        const layer = new FeatureLayer({url: gsvrUrl+"/geoserver/gsr/services/temanjabar/FeatureServer/5/"});
                        const popupTemplate = {
                            title: "{Nama}",
                            content: [{
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "panjang",
                                    label: "Nomor Ruas"
                                },
                                {
                                    fieldName: "pengelola",
                                    label: "Pengelola"
                                },
                                {
                                    fieldName: "expression/status",
                                },
                                {
                                    fieldName: "kabupaten",
                                    label: "Kabupaten"
                                },
                                {
                                    fieldName: "propinsi",
                                    label: "Propinsi"
                                },
                                {
                                    fieldName: "keterangan",
                                    label: "Keterangan"
                                }
                            ]}],
                            expressionInfos: [{
                                name: "status",
                                title: "Status",
                                expression: "Konstruksi"
                            }]
                        };
                        layer.popupTemplate = popupTemplate;
                        layer.renderer = {
                            type: "simple",  // autocasts as new SimpleRenderer()
                            symbol: {
                                type: "simple-line",  // autocasts as new SimpleLineSymbol()
                                color: "purple",
                                width: "2px",
                                style: "solid",
                                marker: { // autocasts from LineSymbolMarker
                                    color: "orange",
                                    placement: "begin-end",
                                    style: "circle"
                                }
                            }
                        }
                        return layer;
                    }

                    function gerbangTol() {
                        const layer = new FeatureLayer({url: gsvrUrl+"/geoserver/gsr/services/temanjabar/FeatureServer/6/"});
                        const popupTemplate = {
                            title: "{Nama}",
                            content: [
                                {
                                    type: "media",
                                    mediaInfos: [
                                        {
                                            title: "<b>Foto</b>",
                                            type: "image",
                                            value: {
                                            sourceURL:
                                                "{foto}"
                                            }
                                        }
                                    ]
                                }
                            ],
                            expressionInfos: [{
                                name: "status",
                                title: "Status",
                                expression: "Konstruksi"
                            }]
                        };
                        layer.popupTemplate = popupTemplate;
                        return layer;
                    }

                    groupLayer.add(provinsiLayer);
                    groupLayer.add(nasionalLayer);
                    groupLayer.add(tolOperasiLayer);
                    groupLayer.add(tolKonstruksiLayer);
                    groupLayer.add(gerbangLayer);
                    return groupLayer;
                }
                function addKemantapanJalan(kemantapanjalan, layer) {
                    const popupTemplate = {
                        title: "{nm_ruas}",
                        content: [
                            {
                                type: "media",
                                mediaInfos: [
                                    {
                                        title: "<b>Kondisi Jalan</b>",
                                        type: "pie-chart",
                                        caption: "Dari Luas Jalan {l} m2",
                                        value: {
                                            fields: ["sangat_baik","baik","sedang","jelek","parah","sangat_parah","hancur"]
                                        }
                                    }
                                ]
                            },
                            {
                                type: "media",
                                mediaInfos: [
                                    {
                                        title: "<b>Jalan Mantap</b>",
                                        type: "pie-chart",
                                        value: {
                                            fields: ["sangat_baik","baik","sedang"]
                                        }
                                    }
                                ]
                            },
                            {
                                type: "media",
                                mediaInfos: [
                                    {
                                        title: "<b>Jalan Tidak Mantap</b>",
                                        type: "pie-chart",
                                        value: {
                                            fields: ["jelek","parah","sangat_parah","hancur"]
                                        }
                                    }
                                ]
                            },
                            {
                                type: "fields",
                                fieldInfos: [
                                    {
                                        fieldName: "idruas",
                                        label: "Nomor Ruas"
                                    },
                                    {
                                        fieldName: "KOTA_KAB",
                                        label: "Kota/Kabupaten"
                                    },
                                    {
                                        fieldName: "LAT_AWAL",
                                        label: "Latitude Awal"
                                    },
                                    {
                                        fieldName: "LONG_AWAL",
                                        label: "Longitude Awal"
                                    },
                                    {
                                        fieldName: "LAT_AKHIR",
                                        label: "Latitude Akhir"
                                    },
                                    {
                                        fieldName: "LONG_AKHIR",
                                        label: "Longitude Akhir"
                                    },
                                    {
                                        fieldName: "KETERANGAN",
                                        label: "Keterangan"
                                    },
                                    {
                                        fieldName: "nm_sppjj",
                                        label: "SPP/ SUP"
                                    },
                                    {
                                        fieldName: "wil_uptd",
                                        label: "UPTD"
                                    }
                                ]
                            }
                        ]
                    };
                    if ($.inArray('kemantapanjalan', $('#kegiatan').val()) >= 0 && $('#uptd').val().length != 0) {
                        var uptdSel = $('#uptd').val();
                        var whereUptd = 'uptd=' + uptdSel.shift().charAt(4);
                        $.each(uptdSel, function(idx, elem) {
                            whereUptd = whereUptd + ' OR uptd=' + elem.charAt(4);
                        });
                        layer.popupTemplate = popupTemplate;
                        layer.definitionExpression = whereUptd;
                        layer.renderer = {
                            type: "simple",  // autocasts as new SimpleRenderer()
                            symbol: {
                                type: "simple-line",  // autocasts as new SimpleLineSymbol()
                                color: "green",
                                width: "2px",
                                style: "solid",
                                marker: { // autocasts from LineSymbolMarker
                                    color: "orange",
                                    placement: "begin-end",
                                    style: "circle"
                                }
                            }
                        }

                    } else {
                        layer.definitionExpression= '0=1';
                    }
                    return layer;
                }
                function addProgressGroup(progress) {
                    const layerGroup = new GroupLayer();
                    const onProgress = new GraphicsLayer({id: "onprogress", visible: false});
                    const offProgress = new GraphicsLayer({id: "offprogress", visible: false});
                    const criticalProgress = new GraphicsLayer({id: "criticalprogress", visible: false});
                    const finishProgress = new GraphicsLayer({id: "finishprogress", visible: false});

                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/pembangunan.png",
                        width: "24px",
                        height: "24px"
                    };
                    const popupTemplate = {
                        title: "{NAMA_PAKET}",
                        content: [
                            {
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "TANGGAL",
                                    label: "Tanggal"
                                },
                                {
                                    fieldName: "WAKTU_KONTRAK",
                                    label: "Waktu Kontrak"
                                },
                                {
                                    fieldName: "TERPAKAI",
                                    label: "Terpakai"
                                },
                                {
                                    fieldName: "JENIS_PEKERJAAN",
                                    label: "Jenis Pekerjaan"
                                },
                                {
                                    fieldName: "RUAS_JALAN",
                                    label: "Ruas Jalan"
                                },
                                {
                                    fieldName: "LAT",
                                    label: "Latitude"
                                },
                                {
                                    fieldName: "LNG",
                                    label: "Longitude"
                                },
                                {
                                    fieldName: "LOKASI",
                                    label: "Lokasi"
                                },
                                {
                                    fieldName: "SUP",
                                    label: "SUP"
                                },
                                {
                                    fieldName: "RENCANA",
                                    label: "Rencana"
                                },
                                {
                                    fieldName: "REALISASI",
                                    label: "Realisasi"
                                },
                                {
                                    fieldName: "DEVIASI",
                                    label: "Deviasi"
                                },
                                {
                                    fieldName: "NILAI_KONTRAK",
                                    label: "Nilai Kontrak"
                                },
                                {
                                    fieldName: "PENYEDIA_JASA",
                                    label: "Penyedia Jasa"
                                },
                                {
                                    fieldName: "KEGIATAN",
                                    label: "Kegiatan"
                                },
                                {
                                    fieldName: "STATUS_PROYEK",
                                    label: "Status"
                                },
                                {
                                    fieldName: "UPTD",
                                    label: "UPTD"
                                }
                            ]
                            },
                            {
                            type: "media",
                            mediaInfos: [
                                {
                                    title: "<b>Foto Pekerjaan</b>",
                                    type: "image",
                                    value: {
                                        sourceURL:
                                            baseUrl + "/assets/images/sample/sample.png"
                                    }
                                }
                            ]
                            },
                            {
                                title: "<b>Video Pekerjaan</b>",
                                type: "custom",
                                outFields: ["*"],
                                creator: function(graphic) {
                                    return `
                                    <div class="esri-feature-media__item">
                                        <video controls class="esri-feature-media__item">
                                            <source src="${baseUrl}/assets/videos/sample.mp4" type="video/mp4">
                                        </video>
                                    </div>`;
                                }
                            }
                        ]
                    };
                    progress.forEach(item => {
                        let point = new Point(item.LNG, item.LAT);
                        switch(item.STATUS_PROYEK){
                            case "ON PROGRESS":
                                onProgress.graphics.add(new Graphic({
                                    geometry: point,
                                    symbol: symbol,
                                    attributes: item,
                                    popupTemplate: popupTemplate
                                }));
                                break;
                            case "CRITICAL CONTRACT":
                                criticalProgress.graphics.add(new Graphic({
                                    geometry: point,
                                    symbol: symbol,
                                    attributes: item,
                                    popupTemplate: popupTemplate
                                }));
                                break;
                            case "OFF PROGRESS":
                                offProgress.graphics.add(new Graphic({
                                    geometry: point,
                                    symbol: symbol,
                                    attributes: item,
                                    popupTemplate: popupTemplate
                                }));
                                break;
                            case "FINISH":
                                finishProgress.graphics.add(new Graphic({
                                    geometry: point,
                                    symbol: symbol,
                                    attributes: item,
                                    popupTemplate: popupTemplate
                                }));
                                break;
                            default:
                                break;
                        }
                    });

                    layerGroup.add(onProgress);
                    layerGroup.add(offProgress);
                    layerGroup.add(criticalProgress);
                    layerGroup.add(finishProgress);

                    return layerGroup;
                }
                function addProgress(progress, layer) {
                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/pembangunan.png",
                        width: "24px",
                        height: "24px"
                    };
                    const popupTemplate = {
                        title: "{NAMA_PAKET}",
                        content: [
                            {
                            type: "fields",
                            fieldInfos: [
                                {
                                    fieldName: "TANGGAL",
                                    label: "Tanggal"
                                },
                                {
                                    fieldName: "WAKTU_KONTRAK",
                                    label: "Waktu Kontrak"
                                },
                                {
                                    fieldName: "TERPAKAI",
                                    label: "Terpakai"
                                },
                                {
                                    fieldName: "JENIS_PEKERJAAN",
                                    label: "Jenis Pekerjaan"
                                },
                                {
                                    fieldName: "RUAS_JALAN",
                                    label: "Ruas Jalan"
                                },
                                {
                                    fieldName: "LAT",
                                    label: "Latitude"
                                },
                                {
                                    fieldName: "LNG",
                                    label: "Longitude"
                                },
                                {
                                    fieldName: "LOKASI",
                                    label: "Lokasi"
                                },
                                {
                                    fieldName: "SUP",
                                    label: "SUP"
                                },
                                {
                                    fieldName: "RENCANA",
                                    label: "Rencana"
                                },
                                {
                                    fieldName: "REALISASI",
                                    label: "Realisasi"
                                },
                                {
                                    fieldName: "DEVIASI",
                                    label: "Deviasi"
                                },
                                {
                                    fieldName: "NILAI_KONTRAK",
                                    label: "Nilai Kontrak"
                                },
                                {
                                    fieldName: "PENYEDIA_JASA",
                                    label: "Penyedia Jasa"
                                },
                                {
                                    fieldName: "KEGIATAN",
                                    label: "Kegiatan"
                                },
                                {
                                    fieldName: "STATUS_PROYEK",
                                    label: "Status"
                                },
                                {
                                    fieldName: "UPTD",
                                    label: "UPTD"
                                }
                            ]
                            }
                        ]
                    };
                    progress.forEach(item => {
                        let point = new Point(item.LNG, item.LAT);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                    });
                    return layer;
                }
                function addVehicleCounting(vehiclecounting, layer) {
                    const symbol = {
                        type: "picture-marker",  // autocasts as new PictureMarkerSymbol()
                        url: baseUrl + "/assets/images/marker/vehiclecounting.png",
                        width: "24px",
                        height: "24px"
                    };
                    const popupTemplate = {
                        title: "{RUAS_JALAN}",
                        content: [
                            {
                                type: "fields",
                                fieldInfos: [
                                    {
                                        fieldName: "LAT",
                                        label: "Latitude"
                                    },
                                    {
                                        fieldName: "LONG",
                                        label: "Longitude"
                                    },
                                    {
                                        fieldName: "JUMLAH_MOBIL",
                                        label: "Jumlah Mobil"
                                    },
                                    {
                                        fieldName: "JUMLAH_MOTOR",
                                        label: "Jumlah Motor"
                                    },
                                    {
                                        fieldName: "JUMLAH_BIS",
                                        label: "Jumlah Bis"
                                    },
                                    {
                                        fieldName: "JUMLAH_TRUK_BOX",
                                        label: "Jumlah Truk Box"
                                    },
                                    {
                                        fieldName: "JUMLAH_TRUK_TRAILER",
                                        label: "Jumlah Truk Trailer"
                                    },
                                    {
                                        fieldName: "SUP",
                                        label: "SUP"
                                    },
                                    {
                                        fieldName: "UPTD",
                                        label: "UPTD"
                                    },
                                    {
                                        fieldName: "CREATED_AT",
                                        label: "Terakhir Diperbarui"
                                    },
                                ]
                            },
                            {
                                type: "media",
                                mediaInfos: [
                                    {
                                        title: "<b>Foto Aktual</b>",
                                        type: "image",
                                        caption: "{CREATED_AT}",
                                        value: {
                                        sourceURL:
                                            baseUrl + "/assets/images/sample/sample.png"
                                        }
                                    }
                                ]
                            }
                        ]
                    };

                    vehiclecounting.forEach(item => {
                        let point = new Point(item.LONG, item.LAT);
                        layer.graphics.add(new Graphic({
                            geometry: point,
                            symbol: symbol,
                            attributes: item,
                            popupTemplate: popupTemplate
                        }));
                    });
                    return layer;
                }


            });

        }

        getMapData("","");
    });
</script>
</html>
