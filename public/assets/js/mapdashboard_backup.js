function getMap(baseUrl, gsvrUrl) {
    // dimz-add
    require([
        "esri/Map",
        "esri/views/MapView",
        "esri/request",
        "esri/geometry/Point",
        "esri/Graphic",
        "esri/layers/GroupLayer",
        "esri/layers/FeatureLayer",
        "esri/widgets/LayerList",
        "esri/widgets/Legend",
        "esri/widgets/Expand",
        "esri/widgets/Search"
    ], function(Map, MapView, esriRequest, Point, Graphic, GroupLayer,
        FeatureLayer, LayerList, Legend, Expand, Search) {

        let basemap = "hybrid";
        const authKey = "9bea4cef-904d-4e00-adb2-6e1cf67b24ae";

        const map = new Map({
            basemap: basemap
        });
        const view = new MapView({
            container: "viewDiv",
            map: map,
            center: [107.6191, -6.9175], // longitude, latitude
            zoom: 9,
            extent: {
                spatialReference: 4326
            }
        });

        const layerList = new Expand({
            content: new LayerList({
                view: view,
                id: 'layerList'
            }),
            view: view,
            expanded: true,
            expandIconClass: 'esri-icon-layers',
            expandTooltip: 'Layer Aktif'
        });
        const legend = new Expand({
            content: new Legend({
                view: view,
                id: 'lgd',
                // style: "card" // other styles include 'classic'
            }),
            view: view,
            expanded: true,
            expandIconClass: 'esri-icon-legend',
            expandTooltip: 'Legenda'
        });

        // Persiapan Street View
        var msLat = 0,
            msLong = 0;
        view.on("click", function(event) {
            // Get the coordinates of the click on the view
            msLat = Math.round(event.mapPoint.latitude * 10000) / 10000;
            msLong = Math.round(event.mapPoint.longitude * 10000) / 10000;
        });
        // aksi untuk siapkan SV dari selected feature
        let prepSVAction = {
            title: "Lihat Street View",
            id: "prep-sv",
            className: "feather icon-video"
        };
        // fungsi yg dipanggil saat trigger aktif
        function prepSV() {
            window.open('http://maps.google.com/maps?q=&layer=c&cbll=' + msLat + ',' + msLong, 'SV_map_bmpr');
        }
        view.popup.on("trigger-action", function(event) {
            if (event.action.id === "prep-sv") {
                prepSV();
            }
        });
        // Search yeahahhh
        let searchWidget = new Search({
            id: "sch",
            view: view,
            allPlaceholder: "Cari Daerah...",
            sources: []
        });

        // Button Initialization
        view.ui.add('grupKontrol', 'top-right');
        $("#spp_filter, #kegiatan").chosen().change(function() {
            changeBtnProses();
        });
        $("#uptd").chosen().change(async function() {
            await getSUPData();
            changeBtnProses();
        });
        $(".baseMapBtn").click(function(event) {
            basemap = $(this).data('map');
            map.basemap = basemap;
        });
        $("#zoom").change(function() {
            const zoom = this.value;
            view.zoom = zoom;
        });

        function hasTanggal(kegiatan) {
            const result = kegiatan.includes('pembangunan') || kegiatan.includes('rehabilitasi') ||
                kegiatan.includes('peningkatan') || kegiatan.includes('pemeliharaan');
            return result;
        }

        function changeBtnProses() {
            let sup = $("#spp_filter").val().length !== 0;
            let kegiatan = $("#kegiatan").val();

            if (sup) {
                $('#btnProses').addClass('btn-primary');
                $('#btnProses').removeAttr('disabled');
            } else {
                $('#btnProses').removeClass('btn-primary');
                $('#btnProses').attr('disabled', 'disabled');
            }

            if (hasTanggal(kegiatan)) {
                $('#filterDate').removeClass('d-none');

                let today = new Date().toISOString().substr(0, 10);;
                $('.sampaiTanggal').val(today);
                $('.mulaiTanggal').val("2000-01-01");
            } else {
                $('#filterDate').addClass('d-none');
            }
        }
        $("#btnProses").click(function(event) {
            searchWidget.sources = [];
            caseRender();
        });

        // Render Layer
        function caseRender() {
            let sup = $("#spp_filter").val();
            let kegiatan = $("#kegiatan").val();
            let uptd = $("#uptd").val();

            function render(nm,layer,callback){
                if ($.inArray(nm, kegiatan) >= 0) {
                    callback;
                    kegiatan.splice(kegiatan.indexOf(nm), 1);
                } else {
                    map.remove(map.findLayerById(layer));
                }
            }
            render('datarawanbencana', 'rbl', rawanBencana());
            render('ruasjalan', 'rj', addRuteJalan());
            render('kemantapanjalan', 'rj_mantap', addKemantapanJalan());
            render('kondisijalan', 'rjp_skj', addKondisiJalan());
            render('kondisijalan_titik', 'rjp_skj_titik', addTitikKondisiJalan());
            render('pembangunan', 'pr_bangun', addPembangunan());
            render('peningkatan', 'pr_tingkat', addPeningkatan());
            render('rehabilitasi', 'pr_rehab', addRehabilitasi());
            render('tempatwisata', 'tx_wisata', addTempatWisata());
            render('satuanpendidikan', 'tx_sekolah', addSekolah());

            if (kegiatan.length > 0) { // kalau masih ada pilihan lain di kegiatan
                // Request data from API
                let requestUrl = baseUrl + '/api/map/dashboard/data';
                let requestBody = new FormData();

                const date_from = $('.mulaiTanggal').val();
                const date_to = $('.sampaiTanggal').val();
                requestBody.append("date_from", date_from);
                requestBody.append("date_to", date_to);

                for (i in kegiatan) {
                    requestBody.append("kegiatan[]", kegiatan[i]);
                }
                for (i in sup) {
                    requestBody.append("sup[]", sup[i]);
                }
                for (i in uptd) {
                    requestBody.append("uptd[]", uptd[i].charAt(4));
                }

                let requestApi = esriRequest(requestUrl, {
                    responseType: "json",
                    method: "post",
                    body: requestBody
                }).then(function(response) {
                    let json = response.data;
                    let data = json.data;
                    // console.log(date_from);
                    // console.log(date_to);
                    // console.log(json);
                    if (json.status === "success") {
                        if (kegiatan.indexOf('jembatan') >= 0) {
                            addJembatan(data.jembatan);
                        } else {
                            map.remove(map.findLayerById('jembatan'));
                        }
                        if (kegiatan.indexOf('pemeliharaan') >= 0) {
                            addPemeliharaan(data.pemeliharaan);
                        } else {
                            map.remove(map.findLayerById('pr_pem'));
                        }
                        if (kegiatan.indexOf('vehiclecounting') >= 0) {
                            addVehicleCounting(data.vehiclecounting);
                        } else {
                            map.remove(map.findLayerById('vc'));
                        }
                        if (kegiatan.indexOf('rawanbencana') >= 0) {
                            addTitikRawanBencana(data.rawanbencana, data.iconrawanbencana);
                        } else {
                            map.remove(map.findLayerById('tx_rawanbencana'));
                        }
                        if (kegiatan.indexOf('cctv') >= 0) {
                            addCCTV(data.cctv);
                        } else {
                            map.remove(map.findLayerById('tx_cctv'));
                        }
                        if (kegiatan.indexOf('laporanmasyarakat') >= 0) {
                            addLaporanMasyarakat(data.laporanmasyarakat);
                        } else {
                            map.remove(map.findLayerById('tx_laporan'));
                        }
                        if (kegiatan.indexOf('laporanbencana') >= 0) {
                            addLaporanBencana(data.laporanbencana, data.iconlaporanbencana);
                        } else {
                            map.remove(map.findLayerById('tx_laporan_bencana'));
                        }

                    } else { // json.status != success
                        // do something
                    }
                }).catch(function(error) {
                    // do something
                    // console.log(error.httpStatus);
                });
            }

            view.when(function() {
                if (!view.ui.find("layerList")) {
                    // Add widget to the bottom right corner of the view
                    view.ui.add(layerList, "bottom-right");
                }
                if (!view.ui.find("lgd")) {
                    // Add widget to the bottom left corner of the view
                    view.ui.add(legend, "bottom-left");
                }
                if (!view.ui.find("sch")) {
                    view.ui.add([{
                        component: searchWidget,
                        position: "top-left",
                        index: 0
                    }]);
                }
            });
        }

        function addRuteJalan() {
            let rutejalanLayer = map.findLayerById('rj');
            if (!rutejalanLayer) {
                rutejalanLayer = new GroupLayer({
                    title: 'Ruas Jalan',
                    id: 'rj'
                });
                rutejalanLayer.add(jalanTolKonstruksi(), 0);
                rutejalanLayer.add(jalanTolOperasi(), 1);
                rutejalanLayer.add(jalanNasional(), 2);
                // rutejalanLayer.add(gerbangTol(), 4);

                map.add(rutejalanLayer);
            }
            rutejalanLayer.add(jalanProvinsi(), 3);
            // rutejalanLayer.reorder();

            function jalanProvinsi() {
                const popupTemplate = {
                    title: "{nm_ruas}",
                    content: [{
                        type: "fields",
                        fieldInfos: [{
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
                        ]
                    }],
                    expressionInfos: [{
                        name: "pjg_km",
                        title: "Panjang Ruas (KM)",
                        expression: "Round($feature.pjg_ruas_m / 1000, 2)"
                    }],
                    actions: [prepSVAction]
                };
                let uptdSel = $('#uptd').val();
                let whereUptd = 'uptd=' + uptdSel.shift().charAt(4);
                $.each(uptdSel, function(idx, elem) {
                    whereUptd = whereUptd + ' OR uptd=' + elem.charAt(4);
                });
                let rjp = rutejalanLayer.findLayerById('rjp');
                if (!rjp) {
                    rjp = new FeatureLayer({
                        url: gsvrUrl + "/geoserver/gsr/services/temanjabar/FeatureServer/0/",
                        customParameters: {
                            ak: authKey
                        },
                        title: 'Ruas Jalan Provinsi',
                        id: 'rjp',
                        outFields: ["*"],
                        popupTemplate: popupTemplate,
                        renderer: {
                            type: "simple", // autocasts as new SimpleRenderer()
                            symbol: {
                                type: "simple-line", // autocasts as new SimpleLineSymbol()
                                color: "green",
                                width: "2px",
                                style: "solid",
                                //   marker: { // autocasts from LineSymbolMarker
                                //      color: "orange",
                                //   placement: "begin-end",
                                // style: "circle"
                                // }
                            }
                        }
                    });

                }
                rjp.definitionExpression = whereUptd;
                return rjp;
            }

            function jalanNasional() {
                const layer = new FeatureLayer({
                    url: gsvrUrl + "/geoserver/gsr/services/temanjabar/FeatureServer/2/",
                    customParameters: {
                        ak: authKey
                    },
                    title: 'Ruas Jalan Nasional'
                });
                const popupTemplate = {
                    title: "{NAMA_SK}",
                    content: [{
                        type: "fields",
                        fieldInfos: [{
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
                        ]
                    }],
                    actions: [prepSVAction]
                };
                layer.popupTemplate = popupTemplate;
                layer.renderer = {
                    type: "simple", // autocasts as new SimpleRenderer()
                    symbol: {
                        type: "simple-line", // autocasts as new SimpleLineSymbol()
                        color: "red",
                        width: "2px",
                        style: "solid",
                        //   marker: { // autocasts from LineSymbolMarker
                        //      color: "orange",
                        //   placement: "begin-end",
                        // style: "circle"
                        // }
                    }
                }
                return layer;
            }

            function jalanTolOperasi() {
                const layer = new FeatureLayer({
                    url: gsvrUrl + "/geoserver/gsr/services/temanjabar/FeatureServer/3/",
                    customParameters: {
                        ak: authKey
                    },
                    title: 'Ruas Jalan Tol (Operasional)'
                });
                const popupTemplate = {
                    title: "{NAMA}",
                    content: [{
                        type: "fields",
                        fieldInfos: [{
                                fieldName: "PANJANG",
                                label: "Panjang"
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
                        ]
                    }]
                };
                layer.popupTemplate = popupTemplate;
                layer.renderer = {
                    type: "simple", // autocasts as new SimpleRenderer()
                    symbol: {
                        type: "simple-line", // autocasts as new SimpleLineSymbol()
                        color: "yellow",
                        width: "2px",
                        style: "solid",
                        //marker: { // autocasts from LineSymbolMarker
                        //   color: "orange",
                        // placement: "begin-end",
                        //style: "circle"
                        //}
                    }
                }
                return layer;
            }

            function jalanTolKonstruksi() {
                const layer = new FeatureLayer({
                    url: gsvrUrl + "/geoserver/gsr/services/temanjabar/FeatureServer/4/",
                    customParameters: {
                        ak: authKey
                    },
                    title: 'Ruas Jalan Tol (Konstruksi)'
                });
                const popupTemplate = {
                    title: "{Nama}",
                    content: [{
                        type: "fields",
                        fieldInfos: [{
                                fieldName: "panjang",
                                label: "Panjang"
                            },
                            {
                                fieldName: "pengelola",
                                label: "Pengelola"
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
                        ]
                    }]
                };
                layer.popupTemplate = popupTemplate;
                layer.renderer = {
                    type: "simple", // autocasts as new SimpleRenderer()
                    symbol: {
                        type: "simple-line", // autocasts as new SimpleLineSymbol()
                        color: "purple",
                        width: "2px",
                        style: "solid",
                        // marker: { // autocasts from LineSymbolMarker
                        //   color: "orange",
                        // placement: "begin-end",
                        //style: "circle"
                        //}
                    }
                }
                return layer;
            }

            function gerbangTol() {
                const layer = new FeatureLayer({
                    url: gsvrUrl + "/geoserver/gsr/services/temanjabar/FeatureServer/5/",
                    customParameters: {
                        ak: authKey
                    },
                    title: 'Gerbang Tol'
                });
                const popupTemplate = {
                    title: "{Nama}",
                    content: [{
                        type: "media",
                        mediaInfos: [{
                            title: "<b>Foto</b>",
                            type: "image",
                            altText: "Foto Tidak Ada",
                            value: {
                                sourceURL: `${baseUrl}/storage/{foto}`
                            }
                        }]
                    }],
                    expressionInfos: [{
                        name: "status",
                        title: "Status",
                        expression: "Konstruksi"
                    }]
                };
                layer.popupTemplate = popupTemplate;
                return layer;
            }
        }

        function rawanBencana() {
            let rawanBencanaLayer = map.findLayerById('rbl');
            if (!rawanBencanaLayer) {
                rawanBencanaLayer = new GroupLayer({
                    title: 'Rawan Bencana',
                    id: 'rbl'
                });

                rawanBencanaLayer.add(rawanGempaBumi(), 1);
                rawanBencanaLayer.add(rawanGerakanTanah(), 0);
                rawanBencanaLayer.add(rawanLongsor(), 3);
                rawanBencanaLayer.add(indexResikoBanjir(), 4);
                rawanBencanaLayer.add(indexResikoBanjirBandang(), 5);

                map.add(rawanBencanaLayer);
            }

            function rawanGempaBumi() {
                const popupTemplate = {
                    title: "{nm_ruas}",
                    content: [{
                        type: "fields",
                        fieldInfos: [{
                                fieldName: "UNSUR",
                                label: "Unsur"
                            },
                            {
                                fieldName: "KETERANGAN",
                                label: "Keterangan"
                            }
                        ]
                    }]
                }
                let rgt = map.findLayerById('rgtId');
                if (!rgt) {
                    rgt = new FeatureLayer({
                        url: "https://satupeta.jabarprov.go.id/arcgis/rest/services/SATUPETA_BPBD/Kebencanaan/MapServer/1",
                        title: 'Gempa Bumi',
                        id: 'rgtId',
                        popupTemplate: popupTemplate
                    });
                    rgt.refresh();
                }
                return rgt;
            }

            function rawanGerakanTanah() {
                const popupTemplate = {
                    title: "{nm_ruas}",
                    content: [{
                        type: "fields",
                        fieldInfos: [{
                                fieldName: "GERTAN",
                                label: "gertan"
                            },
                            {
                                fieldName: "SUMBER",
                                label: "sumber"
                            }
                        ]
                    }]
                }
                let rgt2 = map.findLayerById('rgt2Id');
                if (!rgt2) {
                    rgt2 = new FeatureLayer({
                        url: "https://satupeta.jabarprov.go.id/arcgis/rest/services/SATUPETA_BPBD/Kebencanaan/MapServer/0",
                        title: 'Rawan Gerakan Tanah',
                        id: 'rgt2Id',
                        popupTemplate: popupTemplate
                    });
                    rgt2.refresh();
                }
                return rgt2;
            }


            function indexResikoBanjir() {
                const popupTemplate = {
                    title: "{nm_ruas}",
                    content: [{
                        type: "fields",
                        fieldInfos: [{
                                fieldName: "kelas",
                                label: "kelas"
                            },
                            {
                                fieldName: "Shape_Leng",
                                label: "Shape Leng"
                            },
                            {
                                fieldName: "Shape_Area",
                                label: "Shape Area"
                            },
                            {
                                fieldName: "Luas_HA",
                                label: "Luas HA"
                            }
                        ]
                    }]
                }
                let irb = map.findLayerById('irbId');
                if (!irb) {
                    irb = new FeatureLayer({
                        url: "https://satupeta.jabarprov.go.id/arcgis/rest/services/SATUPETA_BPBD/Kebencanaan/MapServer/7",
                        title: 'Index Resiko Banjir',
                        id: 'irbId',
                        popupTemplate: popupTemplate
                    });
                    irb.refresh();
                }
                return irb;
            }


            function indexResikoBanjirBandang() {
                const popupTemplate = {
                    title: "{nm_ruas}",
                    content: [{
                        type: "fields",
                        fieldInfos: [{
                                fieldName: "kelas",
                                label: "kelas"
                            },
                            {
                                fieldName: "Shape_Leng",
                                label: "Shape Leng"
                            },
                            {
                                fieldName: "Shape_Area",
                                label: "Shape Area"
                            }

                        ]
                    }]
                }
                let irbb = map.findLayerById('irbbId');
                if (!irbb) {
                    irbb = new FeatureLayer({
                        url: "https://satupeta.jabarprov.go.id/arcgis/rest/services/SATUPETA_BPBD/Kebencanaan/MapServer/8",
                        title: 'Index Resiko Banjir Bandang',
                        id: 'irbbId',
                        popupTemplate: popupTemplate
                    });
                    irbb.refresh();
                }
                return irbb;
            }


            function rawanLongsor() {
                const popupTemplate = {
                    title: "{nm_ruas}",
                    content: [{
                        type: "fields",
                        fieldInfos: [{
                                fieldName: "Shape",
                                label: "Shape"
                            },
                            {
                                fieldName: "OBJECTID",
                                label: "OBJECTID "
                            },
                            {
                                fieldName: "GRIDCODE",
                                label: "GRIDCODE"
                            },
                            {
                                fieldName: "kelas",
                                label: "kelas "
                            },
                            {
                                fieldName: "Shape_Leng",
                                label: "Shape_Leng "
                            },
                            {
                                fieldName: "Shape_Area",
                                label: "Shape_Area "
                            }
                        ]
                    }]
                }
                let longsor = map.findLayerById('longsorId');
                if (!longsor) {
                    longsor = new FeatureLayer({
                        url: "https://satupeta.jabarprov.go.id/arcgis/rest/services/SATUPETA_BPBD/Kebencanaan/MapServer/9",
                        title: 'Longsor',
                        id: 'longsorId',
                        popupTemplate: popupTemplate
                    });
                    longsor.refresh();
                }
                return longsor;
            }

        }

        function addTitikRawanBencana(rawanbencana, iconrawanbencana) {
            let uniqueValue = [];
            // console.log(rawanbencana);
            iconrawanbencana.forEach((data) => {
                uniqueValue.push({
                    value: data.ICON_NAME,
                    symbol: {
                        type: "picture-marker", // autocasts as new PictureMarkerSymbol()
                        url: `${baseUrl}/storage/${data.ICON_IMAGE}`,
                        width: "28px",
                        height: "28px"
                    }
                });
            });

            const popupTemplate = {
                title: "{RUAS_JALAN}",
                content: [{
                        type: "fields",
                        fieldInfos: [{
                                fieldName: "NO_RUAS",
                                label: "Nomor Ruas",
                            },
                            {
                                fieldName: "STATUS",
                                label: "Status",
                            },
                            {
                                fieldName: "LOKASI",
                                label: "Lokasi",
                            },
                            {
                                fieldName: "DAERAH",
                                label: "Daerah",
                            },
                            {
                                fieldName: "LAT",
                                label: "Latitude",
                            },
                            {
                                fieldName: "LONG",
                                label: "Longitude",
                            },
                            {
                                fieldName: "KETERANGAN",
                                label: "Keterangan",
                            },
                            {
                                fieldName: "SUP",
                                label: "SUP",
                            },
                            {
                                fieldName: "UPTD_ID",
                                label: "UPTD",
                            }
                        ]
                    },
                    {
                        type: "media",
                        mediaInfos: [{
                            title: "<b>Foto Aktual</b>",
                            type: "image",
                            altText: "Foto Tidak Ada",
                            value: {
                                sourceURL: `${baseUrl}/storage/{FOTO}`
                            }
                        }]
                    }
                ]
            };

            // cari dan hapus layer bila ada pd map
            let titikRawanBencanaLayer = map.findLayerById('tx_rawanbencana');
            if (titikRawanBencanaLayer) {
                map.remove(titikRawanBencanaLayer);
            }

            // buat layer baru
            let newTitikRawanBencana = [];
            rawanbencana.forEach(item => {
                let point = new Point(item.LONG, item.LAT);
                newTitikRawanBencana.push(new Graphic({
                    geometry: point,
                    attributes: item
                }));
            });
            let newTitikRawanBencanaLayer = new FeatureLayer({
                title: 'Titik Rawan Bencana',
                id: 'tx_rawanbencana',
                fields: [{
                        name: "ID",
                        alias: "ID",
                        type: "integer"
                    },
                    {
                        name: "NO_RUAS",
                        alias: "Nomor Ruas",
                        type: "string"
                    },
                    {
                        name: "STATUS",
                        alias: "Status",
                        type: "string"
                    },
                    {
                        name: "RUAS_JALAN",
                        alias: "Ruas Jalan",
                        type: "string"
                    },
                    {
                        name: "LOKASI",
                        alias: "Lokasi",
                        type: "string"
                    },
                    {
                        name: "DAERAH",
                        alias: "Daerah",
                        type: "string"
                    },
                    {
                        name: "LAT",
                        alias: "Latitude",
                        type: "double"
                    },
                    {
                        name: "LONG",
                        alias: "Longitude",
                        type: "double"
                    },
                    {
                        name: "KETERANGAN",
                        alias: "Keterangan",
                        type: "string"
                    },
                    {
                        name: "FOTO",
                        alias: "Foto",
                        type: "string"
                    },
                    {
                        name: "SUP",
                        alias: "SUP",
                        type: "string"
                    },
                    {
                        name: "ICON_NAME",
                        alias: "Jenis Titik Rawan Bencana",
                        type: "string"
                    },
                    {
                        name: "ICON_IMAGE",
                        alias: "Icon Image",
                        type: "string"
                    },
                    {
                        name: "UPTD_ID",
                        alias: "UPTD",
                        type: "string"
                    }
                ],
                outFields: ["*"],
                objectIdField: "ID",
                geometryType: "point",
                spatialReference: {
                    wkid: 4326
                },
                source: newTitikRawanBencana,
                popupTemplate: popupTemplate,
                renderer: {
                    type: "unique-value", // autocasts as new UniqueValueRenderer()
                    field: "ICON_NAME",
                    uniqueValueInfos: uniqueValue
                }
            });
            map.add(newTitikRawanBencanaLayer);
        }

        function addLaporanBencana(laporanbencana, iconlaporanbencana) {
            let uniqueValue = [];
            // console.log(rawanbencana);
            iconlaporanbencana.forEach((data) => {
                uniqueValue.push({
                    value: data.KETERANGAN,
                    symbol: {
                        type: "picture-marker", // autocasts as new PictureMarkerSymbol()
                        url: `${baseUrl}/storage/${data.ICON_IMAGE}`,
                        width: "28px",
                        height: "28px"
                    }
                });
            });

            const popupTemplate = {
                title: "{RUAS_JALAN}",
                content: [
                    {
                        type: "fields",
                        fieldInfos: [{
                                fieldName: "NO_RUAS",
                                label: "Nomor Ruas",
                            },
                            {
                                fieldName: "LOKASI",
                                label: "Lokasi",
                            },
                            {
                                fieldName: "DAERAH",
                                label: "Daerah",
                            },
                            {
                                fieldName: "LAT",
                                label: "Latitude",
                            },
                            {
                                fieldName: "LONG",
                                label: "Longitude",
                            },
                            {
                                fieldName: "KETERANGAN",
                                label: "Keterangan",
                            },
                            {
                                fieldName: "SUP",
                                label: "SUP",
                            },
                            {
                                fieldName: "UPTD_ID",
                                label: "UPTD",
                            },
                            {
                                fieldName: "WAKTU_KEJADIAN",
                                label: "Waktu Kejadian",
                            }
                        ]
                    },
                    {
                        type: "media",
                        mediaInfos: [{
                            title: "<b>Foto Aktual</b>",
                            type: "image",
                            altText: "Foto Tidak Ada",
                            value: {
                                sourceURL: `${baseUrl}/storage/{FOTO}`
                            }
                        }]
                    },
                    {
                        title: "<b>Video</b>",
                        type: "custom",
                        outFields: ["*"],
                        creator: function(feature) {
                            const video = feature.graphic.attributes.VIDEO;
                            let html = '';
                            if(video != ""){
                                html += `
                                <div class="esri-feature-media__item">
                                    <video controls class="esri-feature-media__item">
                                        <source src="${baseUrl}/storage/${video}" type="video/mp4">
                                    </video>
                                </div>`;
                            }
                            return html;
                        }
                    }
                ]
            };

            // cari dan hapus layer bila ada pd map
            let titikLaporanLayer = map.findLayerById('tx_laporan_bencana');
            if (titikLaporanLayer) {
                map.remove(titikLaporanLayer);
            }

            // buat layer baru
            let newLaporanBencana = [];
            laporanbencana.forEach(item => {
                let point = new Point(item.LONG, item.LAT);
                newLaporanBencana.push(new Graphic({
                    geometry: point,
                    attributes: item
                }));
            });
            let newLaporanBencanaLayer = new FeatureLayer({
                title: 'Laporan Bencana',
                id: 'tx_laporan_bencana',
                fields: [{
                        name: "ID",
                        alias: "ID",
                        type: "integer"
                    },
                    {
                        name: "NO_RUAS",
                        alias: "Nomor Ruas",
                        type: "string"
                    },
                    {
                        name: "RUAS_JALAN",
                        alias: "Ruas Jalan",
                        type: "string"
                    },
                    {
                        name: "LOKASI",
                        alias: "Lokasi",
                        type: "string"
                    },
                    {
                        name: "DAERAH",
                        alias: "Daerah",
                        type: "string"
                    },
                    {
                        name: "LAT",
                        alias: "Latitude",
                        type: "double"
                    },
                    {
                        name: "LONG",
                        alias: "Longitude",
                        type: "double"
                    },
                    {
                        name: "KETERANGAN",
                        alias: "Keterangan",
                        type: "string"
                    },
                    {
                        name: "FOTO",
                        alias: "Foto",
                        type: "string"
                    },
                    {
                        name: "SUP",
                        alias: "SUP",
                        type: "string"
                    },
                    {
                        name: "VIDEO",
                        alias: "Video",
                        type: "string"
                    },
                    {
                        name: "WAKTU_KEJADIAN",
                        alias: "Waktu Kejadian",
                        type: "string"
                    },
                    {
                        name: "ICON_IMAGE",
                        alias: "Icon Image",
                        type: "string"
                    },
                    {
                        name: "UPTD_ID",
                        alias: "UPTD",
                        type: "string"
                    }
                ],
                outFields: ["*"],
                objectIdField: "ID",
                geometryType: "point",
                spatialReference: {
                    wkid: 4326
                },
                source: newLaporanBencana,
                popupTemplate: popupTemplate,
                renderer: {
                    type: "unique-value", // autocasts as new UniqueValueRenderer()
                    field: "KETERANGAN",
                    uniqueValueInfos: uniqueValue
                }
            });
            map.add(newLaporanBencanaLayer);
        }

        function addKemantapanJalan() {
            const popupTemplate = {
                title: "{nm_ruas}",
                content: [{
                        type: "media",
                        mediaInfos: [{
                            title: "<b>Kondisi Jalan</b>",
                            type: "pie-chart",
                            caption: "Dari Luas Jalan {l} m2",
                            value: {
                                fields: ["sangat_baik", "baik", "sedang", "jelek", "parah", "sangat_parah", "hancur"]
                            }
                        }]
                    },
                    {
                        type: "media",
                        mediaInfos: [{
                            title: "<b>Jalan Mantap</b>",
                            type: "pie-chart",
                            value: {
                                fields: ["sangat_baik", "baik", "sedang"]
                            }
                        }]
                    },
                    {
                        type: "media",
                        mediaInfos: [{
                            title: "<b>Jalan Tidak Mantap</b>",
                            type: "pie-chart",
                            value: {
                                fields: ["jelek", "parah", "sangat_parah", "hancur"]
                            }
                        }]
                    },
                    {
                        type: "fields",
                        fieldInfos: [{
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
            let uptdSel = $('#uptd').val();
            let whereUptd = 'uptd=' + uptdSel.shift().charAt(4);
            $.each(uptdSel, function(idx, elem) {
                whereUptd = whereUptd + ' OR uptd=' + elem.charAt(4);
            });
            let rj_mantap = map.findLayerById('rj_mantap');
            if (!rj_mantap) {
                rj_mantap = new FeatureLayer({
                    url: gsvrUrl + "/geoserver/gsr/services/temanjabar/FeatureServer/1/",
                    customParameters: {
                        ak: authKey
                    },
                    title: 'Kemantapan Jalan',
                    id: 'rj_mantap',
                    outFields: ["*"],
                    popupTemplate: popupTemplate,
                    renderer: {
                        type: "simple", // autocasts as new SimpleRenderer()
                        symbol: {
                            type: "simple-line", // autocasts as new SimpleLineSymbol()
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
                });
                map.add(rj_mantap);
            }
            rj_mantap.definitionExpression = whereUptd;
        }

        function addKondisiJalan() {
            const popupTemplate = {
                title: "{nm_ruas}",
                content: [{
                        type: "custom",
                        title: "<b>Survei Kondisi Jalan</b>",
                        outFields: ["*"],
                        creator: function(feature) {
                            var id = feature.graphic.attributes.idruas;
                            var div = document.createElement("div");
                            // console.log(feature.graphic.attributes);
                            div.className = "myClass";
                            div.innerHTML = `<h5>Kode Ruas Jalan: ${id}</h5>
                                            <iframe
                                                src="${baseUrl}/admin/monitoring/roadroid-survei-kondisi-jalan/${id}"
                                                title="W3Schools Free Online Web Tutorials"
                                                style="width:100%"/>
                                            `;
                            return div;
                        }
                    },
                    {
                        type: "fields",
                        fieldInfos: [{
                                fieldName: "idruas",
                                label: "Nomor Ruas"
                            },
                            {
                                fieldName: "idsegmen",
                                label: "Nomor Segmen"
                            },
                            {
                                fieldName: "KOTA_KAB",
                                label: "Kota/Kabupaten"
                            },
                            {
                                fieldName: "e_IRI",
                                label: "Estimasi IRI"
                            },
                            {
                                fieldName: "c_IRI",
                                label: "Kalkulasi IRI"
                            },
                            {
                                fieldName: "avg_speed",
                                label: "Kecepatan Rata-Rata Pengukuran IRI"
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
                ],
                actions: [prepSVAction]
            };
            let uptdSel = $('#uptd').val();
            let whereUptd = 'uptd=' + uptdSel.shift().charAt(4);
            $.each(uptdSel, function(idx, elem) {
                whereUptd = whereUptd + ' OR uptd=' + elem.charAt(4);
            });
            let rjp_skj = map.findLayerById('rjp_skj');
            if (!rjp_skj) {
                rjp_skj = new FeatureLayer({
                    url: gsvrUrl + "/geoserver/gsr/services/temanjabar/FeatureServer/6/",
                    customParameters: {
                        ak: authKey
                    },
                    title: 'Hasil Survei Kondisi Jalan',
                    id: 'rjp_skj',
                    outFields: ["*"],
                    popupTemplate: popupTemplate,
                    renderer: {
                        type: "unique-value", // autocasts as new UniqueValueRenderer()
                        valueExpression: "When($feature.e_iri <= 4, 'Baik', $feature.e_iri > 4 && $feature.e_iri <= 8, 'Sedang', $feature.e_iri > 8 && $feature.e_iri <= 12, 'Rusak Ringan', 'Rusak Berat')",
                        uniqueValueInfos: [{
                                value: 'Baik',
                                symbol: {
                                    type: "simple-line", // autocasts as new SimpleLineSymbol()
                                    color: "green",
                                    width: "2px",
                                    style: "solid",
                                },
                            },
                            {
                                value: 'Sedang',
                                symbol: {
                                    type: "simple-line", // autocasts as new SimpleLineSymbol()
                                    color: "orange",
                                    width: "2px",
                                    style: "solid",
                                },
                            },
                            {
                                value: 'Rusak Ringan',
                                symbol: {
                                    type: "simple-line", // autocasts as new SimpleLineSymbol()
                                    color: "red",
                                    width: "2px",
                                    style: "solid",
                                },
                            },
                            {
                                value: 'Rusak Berat',
                                symbol: {
                                    type: "simple-line", // autocasts as new SimpleLineSymbol()
                                    color: "#990b0b",
                                    width: "2px",
                                    style: "solid",
                                },
                            },
                        ]
                    }
                });
                map.add(rjp_skj);
            }
            rjp_skj.definitionExpression = whereUptd;
        }

        function addTitikKondisiJalan() {
            const popupTemplate = {
                title: "{nm_ruas}",
                content: [{
                    type: "fields",
                    fieldInfos: [{
                            fieldName: "id_ruas_jalan",
                            label: "Nomor Ruas"
                        },
                        {
                            fieldName: "latitude",
                            label: "Latitude"
                        },
                        {
                            fieldName: "longitude",
                            label: "Longitude"
                        },
                        {
                            fieldName: "distance",
                            label: "Jarak"
                        },
                        {
                            fieldName: "altitude",
                            label: "Altitude"
                        },
                        {
                            fieldName: "altitude_10",
                            label: "Altitude / 10"
                        },
                        {
                            fieldName: "eiri",
                            label: "Estimasi IRI"
                        },
                        {
                            fieldName: "ciri",
                            label: "Kalkulasi IRI"
                        }
                    ]
                }],
                actions: [prepSVAction]
            };
            // let uptdSel = $('#uptd').val();
            // let whereUptd = 'uptd=' + uptdSel.shift().charAt(4);
            // $.each(uptdSel, function(idx, elem) {
            //     whereUptd = whereUptd + ' OR uptd=' + elem.charAt(4);
            // });
            let rjp_skj_titik = map.findLayerById('rjp_skj_titik');
            if (!rjp_skj_titik) {
                rjp_skj_titik = new FeatureLayer({
                    url: gsvrUrl + "/geoserver/gsr/services/temanjabar/FeatureServer/7",
                    customParameters: {
                        ak: authKey
                    },
                    title: 'Hasil Survei Kondisi Jalan (Titik)',
                    id: 'rjp_skj_titik',
                    outFields: ["*"],
                    popupTemplate: popupTemplate,
                    renderer: {
                        type: "unique-value", // autocasts as new UniqueValueRenderer()
                        valueExpression: "When($feature.eiri <= 4, 'Baik', $feature.eiri > 4 && $feature.eiri <= 8, 'Sedang', $feature.eiri > 8 && $feature.eiri <= 12, 'Rusak Ringan', 'Rusak Berat')",
                        uniqueValueInfos: [{
                                value: 'Baik',
                                symbol: {
                                    type: "simple-marker", // autocasts as new SimpleMarkerSymbol()
                                    color: "green",
                                    size: "15px",
                                    style: "circle",
                                },
                            },
                            {
                                value: 'Sedang',
                                symbol: {
                                    type: "simple-marker", // autocasts as new SimpleMarkerSymbol()
                                    color: "orange",
                                    size: "15px",
                                    style: "circle",
                                },
                            },
                            {
                                value: 'Rusak Ringan',
                                symbol: {
                                    type: "simple-marker", // autocasts as new SimpleMarkerSymbol()
                                    color: "red",
                                    size: "15px",
                                    style: "circle",
                                },
                            },
                            {
                                value: 'Rusak Berat',
                                symbol: {
                                    type: "simple-marker", // autocasts as new SimpleMarkerSymbol()
                                    color: "#990b0b",
                                    size: "15px",
                                    style: "circle",
                                },
                            },
                        ]
                    }
                });
                map.add(rjp_skj_titik, 0);
            }
            // rjp_skj.definitionExpression = whereUptd;
        }

        function addJembatan(jembatan) {
            var prepImg = {
                title: "Lihat Foto",
                id: "prep-img",
                className: "feather icon-image"
            };
            const symbol = {
                type: "picture-marker", // autocasts as new PictureMarkerSymbol()
                url: baseUrl + "/assets/images/marker/jembatan.png",
                width: "24px",
                height: "24px"
            };
            const popupTemplate = {
                title: "{NAMA_JEMBATAN}",
                content: [{
                        type: "fields",
                        fieldInfos: [{
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
                        ]
                    },
                    {
                        type: "custom",
                        title: "<b>Foto Jembatan</b>",
                        outFields: ["*"],
                        creator: function(graphic) {
                            const vidElem = document.createElement('div');
                            vidElem.id = 'imgjembatan'; // + f.graphic.attributes.ID;
                            return vidElem;
                        }
                    }
                ],
                actions: [prepImg]
            };

            // cari dan hapus layer bila ada pd map
            let jembatanLayer = map.findLayerById('jembatan');
            if (jembatanLayer) {
                map.remove(jembatanLayer);
            }

            // buat layer baru
            let newJembatan = [];
            jembatan.forEach(item => {
                let point = new Point(item.LNG, item.LAT);
                newJembatan.push(new Graphic({
                    geometry: point,
                    attributes: item
                }));
            });
            let newJembatanLayer = new FeatureLayer({
                title: 'Jembatan',
                id: 'jembatan',
                fields: [{
                        name: "ID",
                        alias: "ID",
                        type: "integer"
                    },
                    {
                        name: "PANJANG",
                        alias: "Panjang",
                        type: "integer"
                    },
                    {
                        name: "LEBAR",
                        alias: "Lebar",
                        type: "integer"
                    },
                    {
                        name: "RUAS_JALAN",
                        alias: "Ruas Jalan",
                        type: "string"
                    },
                    {
                        name: "LAT",
                        alias: "Latitude",
                        type: "double"
                    },
                    {
                        name: "LNG",
                        alias: "Longitude",
                        type: "double"
                    },
                    {
                        name: "LOKASI",
                        alias: "Lokasi",
                        type: "string"
                    },
                    {
                        name: "SUP",
                        alias: "SUP",
                        type: "string"
                    },
                    {
                        name: "NAMA_JEMBATAN",
                        alias: "Nama Jembatan",
                        type: "string"
                    },
                    {
                        name: "UPTD",
                        alias: "UPTD",
                        type: "string"
                    },
                    {
                        name: "FOTO",
                        alias: "Foto",
                        type: "string"
                    }
                ],
                objectIdField: "ID",
                geometryType: "point",
                spatialReference: {
                    wkid: 4326
                },
                source: newJembatan,
                popupTemplate: popupTemplate,
                renderer: {
                    type: "simple",
                    symbol: symbol
                }
            });


            view.popup.on("trigger-action", function(event) {
                if (event.action.id === "prep-img") {
                    var attributes = view.popup.viewModel.selectedFeature.attributes;
                    var foto = attributes.FOTO;
                    let fotoArr = foto.split(',');
                    const vidElem = document.getElementById('imgjembatan');
                    fotoArr.forEach(foto => {
                        vidElem.innerHTML += `
                            <img src="${baseUrl}/storage/${foto}"/>
                        `;
                    });
                    $('div.esri-popup__action[title="Lihat Foto"]').remove();
                }
            });

            view.when(function() {
                view.popup.watch("selectedFeature", function(graphic) {
                    if (graphic) {
                        var graphicTemplate = graphic.getEffectivePopupTemplate();
                        graphicTemplate.actions.items[0].visible = (graphic.attributes.FOTO != '') ?
                            true :
                            false;
                    }
                });
            });

            map.add(newJembatanLayer);
        }

        function addPembangunan() {
            const symbol = {
                type: "picture-marker", // autocasts as new PictureMarkerSymbol()
                url: baseUrl + "/assets/images/marker/pembangunan.png",
                width: "28px",
                height: "28px"
            };
            const popupTemplate = {
                title: "{NAMA_PAKET}",
                content: [{
                    type: "fields",
                    fieldInfos: [{
                            fieldName: "NO_KONTRAK",
                            label: "Nomor Kontrak"
                        },
                        {
                            fieldName: "TGL_KONTRAK",
                            label: "Tanggal Kontrak"
                        },
                        {
                            fieldName: "TGL_INPUT",
                            label: "Tanggal Input"
                        },
                        {
                            fieldName: "WAKTU_PELAKSANAAN_HK",
                            label: "Waktu Kontrak (Hari Kerja)"
                        },
                        {
                            fieldName: "distance",
                            label: "Perkiraan Panjang Saat Ini (m)"
                        },
                        {
                            fieldName: "TARGET_PANJANG",
                            label: "Target Panjang"
                        },
                        {
                            fieldName: "JENIS_PENANGANAN",
                            label: "Jenis Penanganan"
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
                            fieldName: "LOKASI_PEKERJAAN",
                            label: "Lokasi"
                        },
                        {
                            fieldName: "KM_BDG1",
                            label: "Segmen"
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
                            fieldName: "PENYEDIA_JASA",
                            label: "Penyedia Jasa"
                        },
                        {
                            fieldName: "UPTD",
                            label: "UPTD"
                        },
                        {
                            fieldName: "updated_at",
                            label: "Terakhir Diperbarui"
                        }
                    ]
                }]
            };
            // cari dan hapus layer bila ada pd map
            let pembangunanLayer = map.findLayerById('pr_bangun');
            if (pembangunanLayer) {
                map.remove(pembangunanLayer);
            }

            // Filter
            let uptdSel = $('#uptd').val();
            let filter = 'uptd=' + uptdSel.shift().charAt(4);
            $.each(uptdSel, function(idx, elem) {
                filter = filter + ' OR uptd=' + elem.charAt(4);
            });

            if($('.sampaiTanggal').val() != '' && $('.mulaiTanggal').val() != ''){
                filter += ` AND (tgl_kontrak BETWEEN '${$('.mulaiTanggal').val()}' AND '${$('.sampaiTanggal').val()}') `;
            }

            let pr_bangun = map.findLayerById('pr_bangun');
            if (!pr_bangun) {
                pr_bangun = new GroupLayer({
                    title: 'Pembangunan',
                    id: 'pr_bangun'
                });
                pr_bangun.add(pembangunanTitik(), 0);
                pr_bangun.add(pembangunanRute(), 1);
                map.add(pr_bangun, 99);
            }

            function pembangunanTitik(){
                const layer = new FeatureLayer({
                    url: gsvrUrl + "/geoserver/gsr/services/temanjabar/FeatureServer/8",
                    customParameters: {
                        ak: authKey
                    },
                    title: 'Titik Pembangunan',
                    id: 'pr_bangun_titik',
                    outFields: ["*"],
                    popupTemplate: popupTemplate,
                    renderer: {
                        type: "simple",
                        symbol: symbol
                    }
                });
                layer.definitionExpression = filter;
                return layer;
            }
            function pembangunanRute(){
                const layer = new FeatureLayer({
                    url: gsvrUrl + "/geoserver/gsr/services/temanjabar/FeatureServer/11",
                    customParameters: {
                        ak: authKey
                    },
                    title: 'Ruas Pembangunan',
                    id: 'pr_bangun_ruas',
                    outFields: ["*"],
                    popupTemplate: popupTemplate,
                    renderer: {
                        type: "simple",
                        symbol: {
                            type: "simple-line",
                            color: "red",
                            width: "2px",
                            style: "solid"
                        }
                    }
                });
                layer.definitionExpression = filter;
                return layer;
            }
        }

        function addPeningkatan() {
            const symbol = {
                type: "picture-marker", // autocasts as new PictureMarkerSymbol()
                url: baseUrl + "/assets/images/marker/peningkatan.png",
                width: "28px",
                height: "28px"
            };
            const popupTemplate = {
                title: "{NAMA_PAKET}",
                content: [{
                    type: "fields",
                    fieldInfos: [{
                            fieldName: "NO_KONTRAK",
                            label: "Nomor Kontrak"
                        },
                        {
                            fieldName: "TGL_KONTRAK",
                            label: "Tanggal Kontrak"
                        },
                        {
                            fieldName: "TGL_INPUT",
                            label: "Tanggal Input"
                        },
                        {
                            fieldName: "WAKTU_PELAKSANAAN_HK",
                            label: "Waktu Kontrak (Hari Kerja)"
                        },
                        {
                            fieldName: "distance",
                            label: "Perkiraan Panjang Saat Ini (m)"
                        },
                        {
                            fieldName: "TARGET_PANJANG",
                            label: "Target Panjang"
                        },
                        {
                            fieldName: "JENIS_PENANGANAN",
                            label: "Jenis Penanganan"
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
                            fieldName: "LOKASI_PEKERJAAN",
                            label: "Lokasi"
                        },
                        {
                            fieldName: "KM_BDG1",
                            label: "Segmen"
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
                            fieldName: "PENYEDIA_JASA",
                            label: "Penyedia Jasa"
                        },
                        {
                            fieldName: "UPTD",
                            label: "UPTD"
                        },
                        {
                            fieldName: "updated_at",
                            label: "Terakhir Diperbarui"
                        }
                    ]
                }]
            };

            // cari dan hapus layer bila ada pd map
            let peningkatanLayer = map.findLayerById('pr_tingkat');
            if (peningkatanLayer) {
                map.remove(peningkatanLayer);
            }

            // buat layer baru
            let uptdSel = $('#uptd').val();
            let filter = 'uptd=' + uptdSel.shift().charAt(4);
            $.each(uptdSel, function(idx, elem) {
                filter = filter + ' OR uptd=' + elem.charAt(4);
            });
            if($('.sampaiTanggal').val() != '' && $('.mulaiTanggal').val() != ''){
                filter += ` AND (tgl_kontrak BETWEEN '${$('.mulaiTanggal').val()}' AND '${$('.sampaiTanggal').val()}') `;
            }

            let pr_tingkat = map.findLayerById('pr_tingkat');
            if (!pr_tingkat) {
                pr_tingkat = new GroupLayer({
                    title: 'Peningkatan',
                    id: 'pr_tingkat'
                });
                pr_tingkat.add(peningkatanTitik(), 0);
                pr_tingkat.add(peningkatanRute(), 1);
                map.add(pr_tingkat, 99);
            }
            function peningkatanTitik(){
                const layer = new FeatureLayer({
                    url: gsvrUrl + "/geoserver/gsr/services/temanjabar/FeatureServer/9",
                    customParameters: {
                        ak: authKey
                    },
                    title: 'Titik Peningkatan',
                    id: 'pr_tingkat_titik',
                    outFields: ["*"],
                    popupTemplate: popupTemplate,
                    renderer: {
                        type: "simple",
                        symbol: symbol
                    }
                });
                layer.definitionExpression = filter;
                return layer;
            }
            function peningkatanRute(){
                const layer = new FeatureLayer({
                    url: gsvrUrl + "/geoserver/gsr/services/temanjabar/FeatureServer/12",
                    customParameters: {
                        ak: authKey
                    },
                    title: 'Ruas Peningkatan',
                    id: 'pr_tingkat_ruas',
                    outFields: ["*"],
                    popupTemplate: popupTemplate,
                    renderer: {
                        type: "simple",
                        symbol: {
                            type: "simple-line",
                            color: "blue",
                            width: "2px",
                            style: "solid"
                        }
                    }
                });
                layer.definitionExpression = filter;
                return layer;
            }
        }

        function addRehabilitasi() {
            const symbol = {
                type: "picture-marker", // autocasts as new PictureMarkerSymbol()
                url: baseUrl + "/assets/images/marker/rehabilitasi.png",
                width: "32px",
                height: "32px"
            };
            const popupTemplate = {
                title: "{NAMA_PAKET}",
                content: [{
                    type: "fields",
                    fieldInfos: [{
                            fieldName: "NO_KONTRAK",
                            label: "Nomor Kontrak"
                        },
                        {
                            fieldName: "TGL_KONTRAK",
                            label: "Tanggal Kontrak"
                        },
                        {
                            fieldName: "TGL_INPUT",
                            label: "Tanggal Input"
                        },
                        {
                            fieldName: "WAKTU_PELAKSANAAN_HK",
                            label: "Waktu Kontrak (Hari Kerja)"
                        },
                        {
                            fieldName: "distance",
                            label: "Perkiraan Panjang Saat Ini (m)"
                        },
                        {
                            fieldName: "TARGET_PANJANG",
                            label: "Target Panjang"
                        },
                        {
                            fieldName: "JENIS_PENANGANAN",
                            label: "Jenis Penanganan"
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
                            fieldName: "LOKASI_PEKERJAAN",
                            label: "Lokasi"
                        },
                        {
                            fieldName: "KM_BDG1",
                            label: "Segmen"
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
                            fieldName: "PENYEDIA_JASA",
                            label: "Penyedia Jasa"
                        },
                        {
                            fieldName: "UPTD",
                            label: "UPTD"
                        },
                        {
                            fieldName: "updated_at",
                            label: "Terakhir Diperbarui"
                        }
                    ]
                }]
            };

            // cari dan hapus layer bila ada pd map
            let rehabilitasiLayer = map.findLayerById('pr_rehab');
            if (rehabilitasiLayer) {
                map.remove(rehabilitasiLayer);
            }

            // buat layer baru dengan filter
            let uptdSel = $('#uptd').val();
            let filter = 'uptd=' + uptdSel.shift().charAt(4);
            $.each(uptdSel, function(idx, elem) {
                filter = filter + ' OR uptd=' + elem.charAt(4);
            });
            if($('.sampaiTanggal').val() != '' && $('.mulaiTanggal').val() != ''){
                filter += ` AND (tgl_kontrak BETWEEN '${$('.mulaiTanggal').val()}' AND '${$('.sampaiTanggal').val()}') `;
            }

            let pr_rehab = map.findLayerById('pr_rehab');
            if (!pr_rehab) {
                pr_rehab = new GroupLayer({
                    title: 'Rehabilitasi',
                    id: 'pr_rehab'
                });
                pr_rehab.add(rehabilitasiTitik(), 0);
                pr_rehab.add(rehabilitasiRute(), 1);
                map.add(pr_rehab, 99);
            }
            function rehabilitasiTitik(){
                const layer = new FeatureLayer({
                    url: gsvrUrl + "/geoserver/gsr/services/temanjabar/FeatureServer/10",
                    customParameters: {
                        ak: authKey
                    },
                    title: 'Titik Rehabilitasi',
                    id: 'pr_rehab_titik',
                    outFields: ["*"],
                    popupTemplate: popupTemplate,
                    renderer: {
                        type: "simple",
                        symbol: symbol
                    }
                });
                layer.definitionExpression = filter;
                return layer;
            }
            function rehabilitasiRute(){
                const layer = new FeatureLayer({
                    url: gsvrUrl + "/geoserver/gsr/services/temanjabar/FeatureServer/13",
                    customParameters: {
                        ak: authKey
                    },
                    title: 'Ruas Rehabilitasi',
                    id: 'pr_rehab_ruas',
                    outFields: ["*"],
                    popupTemplate: popupTemplate,
                    renderer: {
                        type: "simple",
                        symbol: {
                            type: "simple-line",
                            color: "yellow",
                            width: "2px",
                            style: "solid"
                        }
                    }
                });
                layer.definitionExpression = filter;
                return layer;
            }
        }

        function addPemeliharaan(pemeliharaan) {
            const symbol = {
                type: "picture-marker", // autocasts as new PictureMarkerSymbol()
                url: baseUrl + "/assets/images/marker/pemeliharaan.png",
                width: "28px",
                height: "28px"
            };
            const popupTemplate = {
                title: "{RUAS_JALAN}",
                content: [
                    {
                        type: "fields",
                        fieldInfos: [{
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
                        ]
                    },
                    {
                        type: "custom",
                        title: "<b>Survei Kondisi Jalan</b>",
                        outFields: ["*"],
                        creator: function(feature) {
                            var id = feature.graphic.attributes.ID_PEK;
                            return `<a class="btn btn-primary text-white mb-4" href="${baseUrl}/pemeliharaan/pekerjaan/${id}" target="_blank">
                                    Lihat Detail Pekerjaan</a>`;
                        }
                    }
                ],
            };

            // cari dan hapus layer bila ada pd map
            let pemeliharaanLayer = map.findLayerById('pr_pem');
            if (pemeliharaanLayer) {
                map.remove(pemeliharaanLayer);
            }

            // buat layer baru
            let newPemeliharaan = [];
            pemeliharaan.forEach(item => {
                let point = new Point(item.LNG, item.LAT);
                newPemeliharaan.push(new Graphic({
                    geometry: point,
                    attributes: item
                }));
            });
            let newPemeliharaanLayer = new FeatureLayer({
                title: 'Pemeliharaan',
                id: 'pr_pem',
                fields: [{
                        name: "ID_PEK",
                        alias: "ID_PEK",
                        type: "string"
                    },
                    {
                        name: "TANGGAL",
                        alias: "Tanggal",
                        type: "string"
                    },
                    {
                        name: "JENIS_PEKERJAAN",
                        alias: "Jenis Pekerjaan",
                        type: "string"
                    },
                    {
                        name: "NAMA_MANDOR",
                        alias: "Nama Mandor",
                        type: "string"
                    },
                    {
                        name: "PANJANG",
                        alias: "Panjang",
                        type: "string"
                    },
                    {
                        name: "PERALATAN",
                        alias: "Peralatan",
                        type: "string"
                    },
                    {
                        name: "LAT",
                        alias: "Latitude",
                        type: "double"
                    },
                    {
                        name: "LNG",
                        alias: "Longitude",
                        type: "double"
                    },
                    {
                        name: "LOKASI",
                        alias: "Lokasi",
                        type: "string"
                    },
                    {
                        name: "RUAS_JALAN",
                        alias: "Ruas Jalan",
                        type: "string"
                    },
                    {
                        name: "FOTO_AWAL",
                        alias: "Foto Awal",
                        type: "string"
                    },
                    {
                        name: "FOTO_SEDANG",
                        alias: "Foto Sedang",
                        type: "string"
                    },
                    {
                        name: "FOTO_AKHIR",
                        alias: "Foto Akhir",
                        type: "string"
                    },
                    {
                        name: "VIDEO",
                        alias: "Video",
                        type: "string"
                    },
                    {
                        name: "SUP",
                        alias: "SUP",
                        type: "string"
                    },
                    {
                        name: "UPTD",
                        alias: "UPTD",
                        type: "string"
                    }
                ],
                objectIdField: "ID",
                geometryType: "point",
                spatialReference: {
                    wkid: 4326
                },
                source: newPemeliharaan,
                popupTemplate: popupTemplate,
                renderer: {
                    type: "simple",
                    symbol: symbol
                }
            });
            map.add(newPemeliharaanLayer);
        }

        function addVehicleCounting(vehiclecounting) {
            const symbol = {
                type: "picture-marker", // autocasts as new PictureMarkerSymbol()
                url: baseUrl + "/assets/images/marker/vehiclecounting.png",
                width: "24px",
                height: "24px"
            };

            // Aksi untuk siapkan video player dari selected feature
            var prepVidAction = {
                title: "Lihat CCTV",
                id: "prep-vid-vc",
                className: "feather icon-video"
            };
            const popupTemplate = {
                title: "{LOKASI}",
                content: [{
                        type: "custom",
                        outFields: ["*"],
                        creator: (function(f) {
                            const vidElem = document.createElement('video');
                            vidElem.id = 'vid'; // + f.graphic.attributes.ID;
                            vidElem.style = 'background:gray;';
                            vidElem.width = '275';
                            vidElem.height = '200';
                            return vidElem;
                        })
                    },
                    {
                        type: "fields",
                        fieldInfos: [{
                                fieldName: "CHANNEL",
                                label: "Channel"
                            },
                            {
                                fieldName: "LAT",
                                label: "Latitude"
                            },
                            {
                                fieldName: "LONG",
                                label: "Longitude"
                            },
                            {
                                fieldName: "JUMLAH_ORANG_UP",
                                label: "Jumlah Orang Up"
                            },
                            {
                                fieldName: "JUMLAH_ORANG_DOWN",
                                label: "Jumlah Orang Down"
                            },
                            {
                                fieldName: "JUMLAH_ORANG_STAY",
                                label: "Jumlah Orang Stay"
                            },
                            {
                                fieldName: "JUMLAH_MOBIL_UP",
                                label: "Jumlah Mobil Up"
                            },
                            {
                                fieldName: "JUMLAH_MOBIL_DOWN",
                                label: "Jumlah Mobil Down"
                            },
                            {
                                fieldName: "JUMLAH_MOBIL_STAY",
                                label: "Jumlah Mobil Stay"
                            },
                            {
                                fieldName: "JUMLAH_MOTOR_UP",
                                label: "Jumlah Motor Up"
                            },
                            {
                                fieldName: "JUMLAH_MOTOR_DOWN",
                                label: "Jumlah Motor Down"
                            },
                            {
                                fieldName: "JUMLAH_MOTOR_STAY",
                                label: "Jumlah Motor Stay"
                            },
                            {
                                fieldName: "JUMLAH_BIS_UP",
                                label: "Jumlah Bis Up"
                            },
                            {
                                fieldName: "JUMLAH_BIS_DOWN",
                                label: "Jumlah Bis Down"
                            },
                            {
                                fieldName: "JUMLAH_BIS_STAY",
                                label: "Jumlah Bis Stay"
                            },
                            {
                                fieldName: "JUMLAH_TRUK_UP",
                                label: "Jumlah Truk Up"
                            },
                            {
                                fieldName: "JUMLAH_TRUK_DOWN",
                                label: "Jumlah Truk Down"
                            },
                            {
                                fieldName: "JUMLAH_TRUK_STAY",
                                label: "Jumlah Truk Stay"
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
                            {
                                fieldName: "UPDATED_AT",
                                label: "Upload Terakhir"
                            },
                        ]
                    }
                ],
                actions: [prepVidAction]
            };
            var player;

            view.when(function() {
                view.popup.watch("selectedFeature", function(graphic) {
                    if (graphic) {
                        var graphicTemplate = graphic.getEffectivePopupTemplate();
                        graphicTemplate.actions.items[0].visible = graphic.attributes.URL ?
                            true :
                            false;
                    }
                });
            });

            function aprepVid() {
                // bila player udah didefinisikan sebelumnya
                if (typeof(player) != 'undefined') {
                    player = null; // kosongkan pointer player
                }
                var attributes = view.popup.viewModel.selectedFeature.attributes;
                var url = attributes.URL;

                const vidElem = document.getElementById('vid');
                const vidSrcElem = document.createElement('source');
                vidSrcElem.src = url;
                vidSrcElem.type = 'application/x-mpegURL';
                vidElem.appendChild(vidSrcElem);

                player = fluidPlayer(
                    'vid', {
                        layoutControls: {
                            fillToContainer: true,
                            autoPlay: true,
                        }
                    }
                );
            }

            view.popup.on("trigger-action", function(event) {
                if (event.action.id === "prep-vid-vc") {
                    aprepVid();
                    $('div.esri-popup__action[title="Lihat CCTV"]').remove();
                }
            });

            // cari dan hapus layer bila ada pd map
            let veCountLayer = map.findLayerById('vc');
            if (veCountLayer) {
                map.remove(veCountLayer);
            }

            // buat layer baru
            let newVC = [];
            vehiclecounting.forEach(item => {
                let point = new Point(item.LONG, item.LAT);
                newVC.push(new Graphic({
                    geometry: point,
                    attributes: item
                }));
            });
            let newVeCountLayer = new FeatureLayer({
                title: 'Jumlah Kendaraan (VC)',
                id: 'vc',
                fields: [{
                        name: "ID",
                        alias: "ID",
                        type: "integer"
                    },
                    {
                        name: "LOKASI",
                        alias: "Lokasi",
                        type: "string"
                    },
                    {
                        name: "CHANNEL",
                        alias: "Channel",
                        type: "string"
                    },
                    {
                        name: "URL",
                        alias: "URL",
                        type: "string"
                    },
                    {
                        name: "LAT",
                        alias: "Latitude",
                        type: "double"
                    },
                    {
                        name: "LONG",
                        alias: "Longitude",
                        type: "double"
                    },
                    {
                        name: "JUMLAH_ORANG_UP",
                        alias: "Jumlah Orang Up",
                        type: "string"
                    },
                    {
                        name: "JUMLAH_ORANG_DOWN",
                        alias: "Jumlah Orang Down",
                        type: "string"
                    },
                    {
                        name: "JUMLAH_ORANG_STAY",
                        alias: "Jumlah Orang Stay",
                        type: "string"
                    },
                    {
                        name: "JUMLAH_MOBIL_UP",
                        alias: "Jumlah Mobil Up",
                        type: "string"
                    },
                    {
                        name: "JUMLAH_MOBIL_DOWN",
                        alias: "Jumlah Mobil Down",
                        type: "string"
                    },
                    {
                        name: "JUMLAH_MOBIL_STAY",
                        alias: "Jumlah Mobil Stay",
                        type: "string"
                    },
                    {
                        name: "JUMLAH_MOTOR_UP",
                        alias: "Jumlah Motor Up",
                        type: "string"
                    },
                    {
                        name: "JUMLAH_MOTOR_DOWN",
                        alias: "Jumlah Motor Down",
                        type: "string"
                    },
                    {
                        name: "JUMLAH_MOTOR_STAY",
                        alias: "Jumlah Motor Stay",
                        type: "string"
                    },
                    {
                        name: "JUMLAH_BIS_UP",
                        alias: "Jumlah Bis Up",
                        type: "string"
                    },
                    {
                        name: "JUMLAH_BIS_DOWN",
                        alias: "Jumlah Bis Down",
                        type: "string"
                    },
                    {
                        name: "JUMLAH_BIS_STAY",
                        alias: "Jumlah Bis Stay",
                        type: "string"
                    },
                    {
                        name: "JUMLAH_TRUK_UP",
                        alias: "Jumlah Truk Up",
                        type: "string"
                    },
                    {
                        name: "JUMLAH_TRUK_DOWN",
                        alias: "Jumlah Truk Down",
                        type: "string"
                    },
                    {
                        name: "JUMLAH_TRUK_STAY",
                        alias: "Jumlah Truk Stay",
                        type: "string"
                    },
                    {
                        name: "SUP",
                        alias: "SUP",
                        type: "string"
                    },
                    {
                        name: "UPTD",
                        alias: "UPTD",
                        type: "string"
                    },
                    {
                        name: "CREATED_AT",
                        alias: "Terakhir Diperbarui",
                        type: "string"
                    },
                    {
                        name: "UPDATED_AT",
                        alias: "Upload Terakhir",
                        type: "string"
                    },
                ],
                objectIdField: "ID",
                geometryType: "point",
                spatialReference: {
                    wkid: 4326
                },
                source: newVC,
                popupTemplate: popupTemplate,
                renderer: {
                    type: "simple",
                    symbol: symbol
                }
            });
            map.add(newVeCountLayer);
        }

        function addCCTV(cctv) {
            const symbol = {
                type: "picture-marker", // autocasts as new PictureMarkerSymbol()
                url: baseUrl + "/assets/images/marker/cctv.png",
                width: "24px",
                height: "24px"
            };
            // Aksi untuk siapkan video player dari selected feature
            var prepVidAction = {
                title: "Lihat Video",
                id: "prep-vid",
                className: "feather icon-video"
            };
            const popupTemplate = {
                title: "{LOKASI}",
                content: [{
                        title: "Video",
                        type: "custom",
                        outFields: ["*"],
                        creator: function(graphic) {
                            const vidElem = document.createElement('video');
                            vidElem.id = 'vid'; // + f.graphic.attributes.ID;
                            vidElem.style = 'background:gray;';
                            vidElem.width = '275';
                            vidElem.height = '200';
                            return vidElem;
                        }
                    },
                    {
                        type: "fields",
                        fieldInfos: [{
                                fieldName: "LAT",
                                label: "Latitude"
                            },
                            {
                                fieldName: "LONG",
                                label: "Longitude"
                            },
                            {
                                fieldName: "URL",
                                label: "Url"
                            },
                            {
                                fieldName: "DESCRIPTION",
                                label: "Deskripsi"
                            },
                            {
                                fieldName: "CATEGORY",
                                label: "Kategori"
                            },
                            {
                                fieldName: "STATUS",
                                label: "Status"
                            },
                            {
                                fieldName: "SUP",
                                label: "SUP"
                            },
                            {
                                fieldName: "UPTD_ID",
                                label: "UPTD"
                            }
                        ]
                    }
                ],
                actions: [prepVidAction]
            };
            var player;

            view.when(function() {
                view.popup.watch("selectedFeature", function(graphic) {
                    if (graphic) {
                        var graphicTemplate = graphic.getEffectivePopupTemplate();
                        graphicTemplate.actions.items[0].visible = graphic.attributes.URL ?
                            true :
                            false;
                    }
                });
            });

            function prepVid() {
                // bila player udah didefinisikan sebelumnya
                if (typeof(player) != 'undefined') {
                    player = null; // kosongkan pointer player
                }
                var attributes = view.popup.viewModel.selectedFeature.attributes;
                var url = attributes.URL;

                const vidElem = document.getElementById('vid');
                const vidSrcElem = document.createElement('source');
                vidSrcElem.src = url;
                vidSrcElem.type = 'application/x-mpegURL';
                vidElem.appendChild(vidSrcElem);

                player = fluidPlayer(
                    'vid', {
                        layoutControls: {
                            fillToContainer: true,
                            autoPlay: true,
                        }
                    }
                );
            }

            view.popup.on("trigger-action", function(event) {
                if (event.action.id === "prep-vid") {
                    prepVid();
                    $('div.esri-popup__action[title="Lihat Video"]').remove();
                }
            });

            // cari dan hapus layer bila ada pd map
            let cctvLayer = map.findLayerById('tx_cctv');
            if (cctvLayer) {
                map.remove(cctvLayer);
            }

            // buat layer baru
            let newCCTV = [];
            cctv.forEach(item => {
                let point = new Point(item.LONG, item.LAT);
                newCCTV.push(new Graphic({
                    geometry: point,
                    attributes: item
                }));
            });
            let newCCTVLayer = new FeatureLayer({
                title: 'CCTV',
                id: 'tx_cctv',
                fields: [{
                        name: "ID",
                        alias: "ID",
                        type: "integer"
                    },
                    {
                        name: "LOKASI",
                        alias: "Lokasi",
                        type: "string"
                    },
                    {
                        name: "LAT",
                        alias: "Latitude",
                        type: "double"
                    },
                    {
                        name: "LONG",
                        alias: "Longitude",
                        type: "double"
                    },
                    {
                        name: "DESCRIPTION",
                        alias: "Deskripsi",
                        type: "string"
                    },
                    {
                        name: "CATEGORY",
                        alias: "Kategori",
                        type: "string"
                    },
                    {
                        name: "URL",
                        alias: "URL",
                        type: "string"
                    },
                    {
                        name: "STATUS",
                        alias: "Status",
                        type: "string"
                    },
                    {
                        name: "SUP",
                        alias: "SUP",
                        type: "string"
                    },
                    {
                        name: "UPTD_ID",
                        alias: "UPTD_ID",
                        type: "string"
                    }
                ],
                objectIdField: "ID",
                geometryType: "point",
                spatialReference: {
                    wkid: 4326
                },
                source: newCCTV,
                popupTemplate: popupTemplate,
                renderer: {
                    type: "simple",
                    symbol: symbol
                }
            });
            map.add(newCCTVLayer);
        }

        function addLaporanMasyarakat(laporan){
            const symbol = {
                type: "picture-marker", // autocasts as new PictureMarkerSymbol()
                url: "http://esri.github.io/quickstart-map-js/images/blue-pin.png",
                width: "14px",
                height: "24px"
            };
            const popupTemplate = {
                title: "{alamat}",
                content: [{
                        type: "fields",
                        fieldInfos: [
                            {
                                fieldName: "nomorPengaduan",
                                label: "Nomor Pengaduan",
                            },
                            {
                                fieldName: "nama",
                                label: "Nama",
                            },
                            {
                                fieldName: "email",
                                label: "Email",
                            },
                            {
                                fieldName: "alamat",
                                label: "Alamat",
                            },
                            {
                                fieldName: "jenis",
                                label: "Jenis",
                            },
                            {
                                fieldName: "lokasi",
                                label: "Lokasi",
                            },
                            {
                                fieldName: "lat",
                                label: "Latitude",
                            },
                            {
                                fieldName: "long",
                                label: "Longitude",
                            },
                            {
                                fieldName: "deskripsi",
                                label: "Deskripsi",
                            },
                            {
                                fieldName: "status",
                                label: "Status",
                            },
                            {
                                fieldName: "created_at",
                                label: "Tanggal Lapor",
                            },
                            {
                                fieldName: "uptd_id",
                                label: "UPTD",
                            }
                        ]
                    },
                    {
                        type: "media",
                        mediaInfos: [{
                            title: "<b>Foto Kondisi</b>",
                            type: "image",
                            altText: "Foto Tidak Ada",
                            value: {
                                sourceURL: `${baseUrl}/storage/{gambar}`
                            }
                        }]
                    }
                ]
            };

            // cari dan hapus layer bila ada pd map
            let laporanLayer = map.findLayerById('tx_laporan');
            if (laporanLayer) {
                map.remove(laporanLayer);
            }

            // buat layer baru
            let newLaporan = [];
            laporan.forEach(item => {
                let point = new Point(item.long, item.lat);
                newLaporan.push(new Graphic({
                    geometry: point,
                    attributes: item
                }));
            });
            let tx_laporan = new FeatureLayer({
                title: 'Laporan Masyarakat',
                id: 'tx_laporan',
                fields: [{
                        name: "id",
                        alias: "id",
                        type: "integer"
                    },
                    {
                        name: "nomorPengaduan",
                        alias: "nomorPengaduan",
                        type: "string"
                    },
                    {
                        name: "nama",
                        alias: "nama",
                        type: "string"
                    },
                    {
                        name: "email",
                        alias: "Email",
                        type: "string"
                    },
                    {
                        name: "alamat",
                        alias: "Alamat",
                        type: "string"
                    },
                    {
                        name: "jenis",
                        alias: "jenis",
                        type: "string"
                    },
                    {
                        name: "gambar",
                        alias: "gambar",
                        type: "string"
                    },
                    {
                        name: "lokasi",
                        alias: "lokasi",
                        type: "string"
                    },
                    {
                        name: "lat",
                        alias: "Latitude",
                        type: "double"
                    },
                    {
                        name: "long",
                        alias: "Longitude",
                        type: "double"
                    },
                    {
                        name: "deskripsi",
                        alias: "deskripsi",
                        type: "string"
                    },
                    {
                        name: "status",
                        alias: "status",
                        type: "string"
                    },
                    {
                        name: "created_at",
                        alias: "dilaporkan",
                        type: "string"
                    },
                    {
                        name: "uptd_id",
                        alias: "UPTD",
                        type: "string"
                    }
                ],
                objectIdField: "id",
                geometryType: "point",
                spatialReference: {
                    wkid: 4326
                },
                source: newLaporan,
                popupTemplate: popupTemplate,
                renderer: {
                    type: "simple",
                    symbol: symbol
                }
            });
            map.add(tx_laporan);
        }

        function addTempatWisata() {
            const symbol = {
                type: "picture-marker", // autocasts as new PictureMarkerSymbol()
                url: baseUrl + "/assets/images/marker/jalan.png",
                width: "28px",
                height: "28px"
            };
            const popupTemplate = {
                title: "{nama}",
                content: [
                    {
                        type: "media",
                        mediaInfos: [{
                            title: "<b>Foto</b>",
                            type: "image",
                            altText: "Foto Tidak Ada",
                            value: {
                                sourceURL: `${baseUrl}/storage/{foto}`
                            }
                        }]
                    },
                    {
                        type: "custom",
                        outFields: ["*"],
                        creator: function(feature) {
                            var deskripsi = feature.graphic.attributes.deskripsi;
                            return `${deskripsi}`;
                        }
                   }
                ]
            };
            // cari dan hapus layer bila ada pd map
            let tempatWisataLayer = map.findLayerById('tx_wisata');
            if (tempatWisataLayer) {
                map.remove(tempatWisataLayer);
            }

            let tx_wisata = map.findLayerById('tx_wisata');
            if (!tx_wisata) {
                tx_wisata = new FeatureLayer({
                    url: gsvrUrl + "/geoserver/gsr/services/temanjabar/FeatureServer/14",
                    customParameters: {
                        ak: authKey
                    },
                    title: 'Tempat Wisata',
                    id: 'tx_wisata',
                    outFields: ["*"],
                    popupTemplate: popupTemplate,
                    renderer: {
                        type: "simple",
                        symbol: symbol
                    }
                });
                map.add(tx_wisata, 2);
            }

        }

        function addSekolah(){
            // cari dan hapus layer bila ada pd map
            const popupTemplate = {
                title: "{poi_name}",
                content: [{
                    type: "fields",
                    fieldInfos: [
                        {
                            fieldName: "st_name",
                            label: "Alamat"
                        },
                    ]
                }]
            };
            let sekolahLayer = map.findLayerById('tx_sekolah');
            if (sekolahLayer) {
                map.remove(sekolahLayer);
            }


            let tx_sekolah = map.findLayerById('tx_sekolah');
            if (!tx_sekolah) {
                tx_sekolah = new GroupLayer({
                    title: 'Persebaran Satuan Pendidikan',
                    id: 'tx_sekolah'
                });
                tx_sekolah.add(sekolahPG(), 0);
                tx_sekolah.add(sekolahTK(), 1);
                tx_sekolah.add(sekolahSD(), 2);
                tx_sekolah.add(sekolahSMP(), 3);
                tx_sekolah.add(sekolahSMA(), 4);
                tx_sekolah.add(sekolahPT(), 5);
                map.add(tx_sekolah, 2);
            }

            function sekolahPT(){
                const layer = new FeatureLayer({
                    url: "https://satupeta.jabarprov.go.id/arcgis/rest/services/SATUPETA_DISDIK/Sebaran_Sekolah/MapServer/0",
                    title: 'Perguruan Tinggi',
                    id: 'tx_sekolah_pt',
                    outFields: ["*"],
                    popupTemplate: popupTemplate
                });
                return layer;
            }
            function sekolahSMA(){
                const layer = new FeatureLayer({
                    url: "https://satupeta.jabarprov.go.id/arcgis/rest/services/SATUPETA_DISDIK/Sebaran_Sekolah/MapServer/1",
                    title: 'Sekolah Menengah Atas',
                    id: 'tx_sekolah_sma',
                    outFields: ["*"],
                    popupTemplate: popupTemplate
                });
                return layer;
            }
            function sekolahSMP(){
                const layer = new FeatureLayer({
                    url: "https://satupeta.jabarprov.go.id/arcgis/rest/services/SATUPETA_DISDIK/Sebaran_Sekolah/MapServer/2",
                    title: 'Sekolah Menengah Pertama',
                    id: 'tx_sekolah_smp',
                    outFields: ["*"],
                    popupTemplate: popupTemplate
                });
                return layer;
            }
            function sekolahSD(){
                const layer = new FeatureLayer({
                    url: "https://satupeta.jabarprov.go.id/arcgis/rest/services/SATUPETA_DISDIK/Sebaran_Sekolah/MapServer/3",
                    title: 'Sekolah Dasar',
                    id: 'tx_sekolah_sd',
                    outFields: ["*"],
                    popupTemplate: popupTemplate
                });
                return layer;
            }
            function sekolahTK(){
                const layer = new FeatureLayer({
                    url: "https://satupeta.jabarprov.go.id/arcgis/rest/services/SATUPETA_DISDIK/Sebaran_Sekolah/MapServer/4",
                    title: 'Taman Kanak-kanak',
                    id: 'tx_sekolah_tk',
                    outFields: ["*"],
                    popupTemplate: popupTemplate
                });
                return layer;
            }
            function sekolahPG(){
                const layer = new FeatureLayer({
                    url: "https://satupeta.jabarprov.go.id/arcgis/rest/services/SATUPETA_DISDIK/Sebaran_Sekolah/MapServer/5",
                    title: 'Playgroup',
                    id: 'tx_sekolah_pg',
                    outFields: ["*"],
                    popupTemplate: popupTemplate
                });
                return layer;
            }
        }

    });
}

function dep(params) {
 /* Deleted Proyek Kontrak
    if (kegiatan.indexOf('progressmingguan') >= 0) {
        addProgressGroup(data.progressmingguan);
    } else {
        map.remove(map.findLayerById('progress_all'));
    }
*/

/* $("#proyek").chosen().change(function() {
    const proyek = $("#proyek").val();
    const allProyek = ["onprogress", "criticalprogress", "offprogress", "finishprogress"];
    const diff = difference(allProyek, proyek);

    for (i in proyek) {
        allProgressLayer.findLayerById(proyek[i]).visible = true;
    }
    for (i in diff) {
        allProgressLayer.findLayerById(diff[i]).visible = false;
    }
}); */
function addProgressGroup(progress) {
    const symbol = {
        type: "picture-marker", // autocasts as new PictureMarkerSymbol()
        url: baseUrl + "/assets/images/marker/pembangunan.png",
        width: "24px",
        height: "24px"
    };
    const popupTemplate = {
        title: "{NAMA_PAKET}",
        content: [{
                type: "fields",
                fieldInfos: [{
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
                mediaInfos: [{
                    title: "<b>Foto Pekerjaan</b>",
                    type: "image",
                    value: {
                        sourceURL: baseUrl + "/assets/images/sample/sample.png"
                    }
                }]
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
    const fields = [{
            name: "ID",
            alias: "ID",
            type: "integer"
        },
        {
            name: "TANGGAL",
            alias: "Tanggal",
            type: "string"
        },
        {
            name: "WAKTU_KONTRAK",
            alias: "Waktu Kontrak",
            type: "integer"
        },
        {
            name: "TERPAKAI",
            alias: "Terpakai",
            type: "integer"
        },
        {
            name: "JENIS_PEKERJAAN",
            alias: "Jenis Pekerjaan",
            type: "string"
        },
        {
            name: "RUAS_JALAN",
            alias: "Ruas Jalan",
            type: "string"
        },
        {
            name: "LAT",
            alias: "Latitude",
            type: "double"
        },
        {
            name: "LONG",
            alias: "Longitude",
            type: "double"
        },
        {
            name: "LOKASI",
            alias: "Lokasi",
            type: "string"
        },
        {
            name: "SUP",
            alias: "SUP",
            type: "string"
        },
        {
            name: "RENCANA",
            alias: "Rencana",
            type: "double"
        },
        {
            name: "REALISASI",
            alias: "Realisasi",
            type: "double"
        },
        {
            name: "DEVIASI",
            alias: "Deviasi",
            type: "double"
        },
        {
            name: "NILAI_KONTRAK",
            alias: "Nilai Kontrak",
            type: "double"
        },
        {
            name: "PENYEDIA_JASA",
            alias: "Penyedia Jasa",
            type: "string"
        },
        {
            name: "KEGIATAN",
            alias: "Kegiatan",
            type: "string"
        },
        {
            name: "STATUS_PROYEK",
            alias: "Status",
            type: "string"
        },
        {
            name: "UPTD",
            alias: "UPTD",
            type: "string"
        }
    ];

// cari dan hapus layer bila ada pd map
let allProgressLayer = map.findLayerById('progress_all');
if (allProgressLayer) {
    map.remove(allProgressLayer);
}
let newAllProgressLayer = new GroupLayer({
    title: 'Progress  Proyek Kontrak',
    id: 'progress_all'
});

    // buat layer baru
    let newOn = [],
        newOff = [],
        newCrit = [],
        newFin = [];
    progress.forEach(item => {
        let point = new Point(item.LNG, item.LAT);
        let fitur = new Graphic({
            geometry: point,
            attributes: item
        });
        switch (item.STATUS_PROYEK) {
            case "ON PROGRESS":
                newOn.push(fitur);
                break;
            case "OFF PROGRESS":
                newOff.push(fitur);
                break;
            case "CRITICAL CONTRACT":
                newCrit.push(fitur);
                break;
            case "FINISH":
                newFin.push(fitur);
                break;
            default:
                break;
        }
    });

    let onProgress = new FeatureLayer({
        title: "On-Progress",
        id: "onprogress",
        fields: fields,
        objectIdField: "ID",
        geometryType: "point",
        spatialReference: {
            wkid: 4326
        },
        source: newOn,
        popupTemplate: popupTemplate,
        renderer: {
            type: "simple",
            symbol: symbol
        }
    });
    let offProgress = new FeatureLayer({
        title: "Off-Progress",
        id: "offprogress",
        fields: fields,
        objectIdField: "ID",
        geometryType: "point",
        spatialReference: {
            wkid: 4326
        },
        source: newOff,
        popupTemplate: popupTemplate,
        renderer: {
            type: "simple",
            symbol: symbol
        }
    });
    let criticalProgress = new FeatureLayer({
        title: "Critical",
        id: "criticalprogress",
        fields: fields,
        objectIdField: "ID",
        geometryType: "point",
        spatialReference: {
            wkid: 4326
        },
        source: newCrit,
        popupTemplate: popupTemplate,
        renderer: {
            type: "simple",
            symbol: symbol
        }
    });
    let finishProgress = new FeatureLayer({
        title: "Finish",
        id: "finishprogress",
        fields: fields,
        objectIdField: "ID",
        geometryType: "point",
        spatialReference: {
            wkid: 4326
        },
        source: newFin,
        popupTemplate: popupTemplate,
        renderer: {
            type: "simple",
            symbol: symbol
        }
    });

    newAllProgressLayer.add(onProgress);
    newAllProgressLayer.add(offProgress);
    newAllProgressLayer.add(criticalProgress);
    newAllProgressLayer.add(finishProgress);
    map.add(newAllProgressLayer);
}
}

