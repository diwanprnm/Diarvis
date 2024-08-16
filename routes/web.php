<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// ufSjz8hjzvtyKr_zBXsM

Route::get('test', function () {
    return view('admin.layout.index');
});

// {SiteURL}
Route::get('/', 'LandingController@login')->name('/');
Route::get('403', function () {
    return view('403')->render();
})->name('403');
Route::get('login', 'LandingController@login')->name('login');
Route::get('logout', 'AuthController@logout');
Route::get('verify-email/{token}', 'AuthController@verifyEmail');

Route::post('auth', 'AuthController@login');
Route::get('forced-login/{encrypted_id}', 'AuthController@loginUsingId');

// Route::post('role-akses/store', 'MasterData\UserController@storeRoleAccess')->name('storeRoleAccess');

Route::post('tambah-pesan', 'LandingController@createPesan');
Route::get('admin/master/ruas_jalan', 'MasterController@getRuasJalan')->name('admin.master.ruas_jalan');
Route::get('map/map-dashboard-masyarakat', 'MapLandingController@mapMasyarakat')->name('landing.map.map-dashboard-masyarakat');
Route::get('map/map-dashboard-uptd/{uptd_id}', 'MapLandingController@mapUptd')->name('landing.map.map-dashboard-uptd');

Route::post('dependent-dropdown', 'DropdownAddressController@store')
    ->name('dependent-dropdown.store');
Route::get('getCity', 'DropdownAddressController@getCity');
Route::get('/announcement/show/{id}', 'AnnouncementController@show')->name('announcementShow');
Route::get('pemeliharaan/pekerjaan/{id}', 'InputData\PekerjaanController@detailPemeliharaan')->name('detailPemeliharaan');

Route::prefix('status_jalan')->group(function () {
    Route::get('/', 'StatusJalanController@index');
    Route::prefix('api')->group(function () {
        Route::get('/', 'StatusJalanController@api_index');
    });
});

// {SiteURL}/uptd/*
Route::group(['prefix' => 'uptd'], function () {
    Route::get('/{slug}', 'LandingController@uptd');
    Route::get('/labkon/home', 'LandingController@labkon');
    Route::get('/labkon/posts', 'LandingController@createpost');
    Route::post('/labkon/posts', 'LandingController@storepost');
});

Route::get('user', 'CobaController@index');
Route::get('user/json', 'CobaController@json');

// {SiteURL}/admin/*
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/', function () {
        return redirect(route('monitoring-kontrak'));
    });

    Route::get('/', 'Home@index');
    Route::get('announcement/destroy/{id}', 'AnnouncementController@destroy');
    Route::resource('/announcement', 'AnnouncementController');

    Route::get('profile/{id}', 'DetailUserController@show')->name('editProfile');
    Route::get('activity/{id}', 'LandingController@getLogUser')->name('log.user.index');

    Route::get('edit/profile/{id}', 'DetailUserController@edit')->name('editDetailProfile');
    Route::put('edit/profile/{id}', 'DetailUserController@update');
    Route::post('user/account/{id}', 'DetailUserController@updateaccount');
    Route::get('pesan', 'LandingController@getPesan');
    Route::get('log', 'LandingController@getLog')->middleware('role:Log,View');
    Route::get('home', 'Home@index')->name('admin-home');

    Route::get('file', 'Home@downloadFile');
    Route::view('map-dashboard', 'admin.map.map-dashboard')->middleware('role:Executive Dashboard,View');
    Route::view('map-dashboard-canggih', 'admin.map.map-dashboard-canggih');
    // {SiteURL}/admin/monitoring/*
    Route::group(['prefix' => 'monitoring'], function () {
        Route::get('progress-pekerjaan', 'MonitoringController@getProgressPekerjaan');
        Route::get('pekerjaan_resume', 'Monitoring\ResumeController@pekerjaan')->name('resume_pekerjaan');
        Route::get('main-dashboard', 'MonitoringController@getMainDashboard');
    });

    // {SiteURL}/admin/landing-page/
    Route::group(['prefix' => 'landing-page'], function () {
        // {SiteURL}/admin/landing-page/profil
        Route::group(['prefix' => 'profil'], function () {
            Route::get('/', 'LandingController@getProfil');
            Route::post('update', 'LandingController@updateProfil')->name('updateLandingProfil');
        });
    });

    Route::group(['prefix' => 'laporan'], function () {
        Route::group(['prefix' => 'perencanaan'], function () {
            Route::get('rencana-kebutuhan-barang', 'Report\ReportController@generateReportRKB')->name('generateReportRKB');
            Route::post('rencana-kebutuhan-barang', 'Report\ReportController@generateReportRKB')->name('generateReportRKB');
            Route::post('getunitfiter', 'Report\ReportController@getUnitFilter')->name('getUnitFilter');
            Route::post('getsubunitfiter', 'Report\ReportController@getSubUnitFiter')->name('getSubUnitFiter');
            Route::post('getReportPerencanaanFilter', 'Report\ReportController@getReportPerencanaanFilter')->name('getReportPerencanaanFilter');
            Route::get('previewLaporanRKB/{param}', 'Report\ReportController@previewLaporanRKB')->name('previewLaporanRKB');
            Route::get('generatePDFRKB/{param}', 'Report\ReportController@generatePDFRKB')->name('generatePDFRKB');
            Route::view('generate_pdf_rkb', 'admin.report.perencanaan.generate_pdf_rkb');
        });
    });

    Route::group(['prefix' => 'master-data'], function () {
        Route::group(['prefix' => 'barang'], function () {
            Route::group(['prefix' => 'intra'], function () {

                // Tanah

                Route::get('tanah', 'MasterData\Barang\TanahController@index')->name('getTanah');
                Route::post('tanah', 'MasterData\Barang\TanahController@index')->name('getTanah');
                Route::get('tanah/add', 'MasterData\Barang\TanahController@add')->name('tanah.add');
                Route::get('tanah/edit/{id}', 'MasterData\Barang\TanahController@edit')->name('tanah.edit');
                Route::get('tanah/dokumen/download/{id}', 'MasterData\Barang\TanahController@download')->name('tanah.dokumen.download');
                Route::get('tanah/delete/{id}', 'MasterData\Barang\TanahController@delete')->name('tanah.delete');

                Route::post('tanah/getKecamatan', 'MasterData\Barang\TanahController@getKecamatan')->name('tanah.get.kecamatan');
                Route::post('tanah/getDesa', 'MasterData\Barang\TanahController@getDesa')->name('tanah.get.desa');
                Route::post('tanah/images-upload', 'ImageController@imagesUploadPost')->name('tanah/images-upload');

                Route::post('tanah/getNoRegister', 'MasterData\Barang\TanahController@getNoRegister')->name('tanah.noregister');
                Route::post('tanah/save', 'MasterData\Barang\TanahController@save')->name('tanah.save');
                Route::post('tanah/update', 'MasterData\Barang\TanahController@update')->name('tanah.update');
                Route::post('tanah/getKodePemilik', 'MasterData\Barang\TanahController@getKodePemilik')->name('tanah.kode-pemilik');
                Route::post('tanah/get-sub-unit', 'MasterData\Barang\TanahController@getSubUnit')->name('tanah.sub-unit');

                Route::post('tanah/get-upb', 'MasterData\Barang\TanahController@getUPB')->name('tanah.upb');
                Route::post('tanah/get-upb-filter-table', 'MasterData\Barang\TanahController@getUPBFilterTable')->name('tanah.upb.filter.table');
                Route::post('tanah/get-sub-rincian-obyek', 'MasterData\Barang\TanahController@getSubRincianObyek')->name('tanah.sub-rincian-obyek');
                Route::post('tanah/get-sub-sub-rincian-obyek', 'MasterData\Barang\TanahController@getSubSubRincianObyek')->name('tanah.sub-sub-rincian-obyek');
                Route::get('tanah/save', 'MasterData\Barang\TanahController@save')->name('tanah.save');
                Route::get('tanah/detail/{id}', 'MasterData\Barang\TanahController@detail')->name('getDetailKIBA');

                // Peralatan dan Mesin

                Route::get('peralatandanmesin', 'MasterData\Barang\PeralatanController@index')->name('getPeralatan');
                Route::post('peralatandanmesin', 'MasterData\Barang\PeralatanController@index')->name('getPeralatan');

                Route::get('peralatandanmesin/add', 'MasterData\Barang\PeralatanController@add')->name('peralatan.add');
                Route::post('peralatandanmesin/save', 'MasterData\Barang\PeralatanController@save')->name('peralatan.save');
                Route::get('peralatandanmesin/edit/{id}', 'MasterData\Barang\PeralatanController@edit')->name('peralatan.edit');
                Route::post('peralatandanmesin/update', 'MasterData\Barang\PeralatanController@update')->name('peralatan.update');
                Route::get('peralatandanmesin/delete/{id}', 'MasterData\Barang\PeralatanController@delete')->name('deleteJsonPeralatan');

                Route::get('peralatandanmesin/dokumen/download/{id}', 'MasterData\Barang\PeralatanController@download')->name('peralatan.dokumen.download');
                Route::get('peralatandanmesin/detail/{id}', 'MasterData\Barang\PeralatanController@detail')->name('getDetailPeralatan');

                Route::post('peralatandanmesin/getKecamatan', 'MasterData\Barang\PeralatanController@getKecamatan')->name('peralatan.get.kecamatan');
                Route::post('peralatandanmesin/getDesa', 'MasterData\Barang\PeralatanController@getDesa')->name('peralatan.get.desa');
                Route::post('peralatandanmesin/get-upb', 'MasterData\Barang\PeralatanController@getUPB')->name('peralatan.upb');
                Route::post('peralatandanmesin/get-sub-unit', 'MasterData\Barang\PeralatanController@getSubUnit')->name('peralatan.sub-unit');
                Route::post('peralatandanmesin/get-upb-filter-table', 'MasterData\Barang\PeralatanController@getUPBFilterTable')->name('peralatan.upb.filter.table');
                Route::post('peralatandanmesin/get-sub-rincian-obyek', 'MasterData\Barang\PeralatanController@getSubRincianObyek')->name('peralatan.sub-rincian-obyek');
                Route::post('peralatandanmesin/get-sub-sub-rincian-obyek', 'MasterData\Barang\PeralatanController@getSubSubRincianObyek')->name('peralatan.sub-sub-rincian-obyek');
                Route::post('peralatandanmesin/getKodePemilik', 'MasterData\Barang\PeralatanController@getKodePemilik')->name('peralatan.kode-pemilik');

                // Gedung

                Route::get('gedung', 'MasterData\Barang\GedungController@index')->name('getGedung');
                Route::post('gedung', 'MasterData\Barang\GedungController@index')->name('getGedung');
                Route::get('gedung/add', 'MasterData\Barang\GedungController@add')->name('gedung.add');
                Route::get('gedung/edit/{id}', 'MasterData\Barang\GedungController@edit')->name('gedung.edit');
                Route::get('gedung/dokumen/download/{id}', 'MasterData\Barang\GedungController@download')->name('gedung.dokumen.download');
                Route::get('gedung/delete/{id}', 'MasterData\Barang\GedungController@delete')->name('gedung.delete');

                Route::post('gedung/getKecamatan', 'MasterData\Barang\GedungController@getKecamatan')->name('gedung.get.kecamatan');
                Route::post('gedung/getDesa', 'MasterData\Barang\GedungController@getDesa')->name('gedung.get.desa');
                Route::post('gedung/images-upload', 'ImageController@imagesUploadPost')->name('gedung/images-upload');

                Route::post('gedung/getNoRegister', 'MasterData\Barang\GedungController@getNoRegister')->name('gedung.noregister');
                Route::post('gedung/save', 'MasterData\Barang\GedungController@save')->name('gedung.save');
                Route::post('gedung/update', 'MasterData\Barang\GedungController@update')->name('gedung.update');
                Route::post('gedung/getKodePemilik', 'MasterData\Barang\GedungController@getKodePemilik')->name('gedung.kode-pemilik');
                Route::post('gedung/get-sub-unit', 'MasterData\Barang\GedungController@getSubUnit')->name('gedung.sub-unit');

                Route::post('gedung/get-upb', 'MasterData\Barang\GedungController@getUPB')->name('gedung.upb');
                Route::post('gedung/get-upb-filter-table', 'MasterData\Barang\GedungController@getUPBFilterTable')->name('gedung.upb.filter.table');
                Route::post('gedung/get-sub-rincian-obyek', 'MasterData\Barang\GedungController@getSubRincianObyek')->name('gedung.sub-rincian-obyek');
                Route::post('gedung/get-sub-sub-rincian-obyek', 'MasterData\Barang\GedungController@getSubSubRincianObyek')->name('gedung.sub-sub-rincian-obyek');
                Route::get('gedung/save', 'MasterData\Barang\GedungController@save')->name('gedung.save');
                Route::get('gedung/detail/{id}', 'MasterData\Barang\GedungController@detail')->name('getDetailGedung');


                // jalan

                Route::get('jalan', 'MasterData\Barang\JalanController@index')->name('getJalan');
                Route::post('jalan', 'MasterData\Barang\JalanController@index')->name('getJalan');
                Route::get('jalan/add', 'MasterData\Barang\JalanController@add')->name('jalan.add');
                Route::get('jalan/edit/{id}', 'MasterData\Barang\JalanController@edit')->name('jalan.edit');
                Route::post('jalan/getKodePemilik', 'MasterData\Barang\JalanController@getKodePemilik')->name('jalan.kode-pemilik');
                Route::post('jalan/get-sub-unit', 'MasterData\Barang\JalanController@getSubUnit')->name('jalan.sub-unit');
                Route::post('jalan/get-upb', 'MasterData\Barang\JalanController@getUPB')->name('jalan.upb');
                Route::post('jalan/get-upb-filter-table', 'MasterData\Barang\JalanController@getUPBFilterTable')->name('jalan.upb.filter.table');
                Route::post('jalan/get-sub-rincian-obyek', 'MasterData\Barang\JalanController@getSubRincianObyek')->name('jalan.sub-rincian-obyek');
                Route::post('jalan/get-sub-sub-rincian-obyek', 'MasterData\Barang\JalanController@getSubSubRincianObyek')->name('jalan.sub-sub-rincian-obyek');
                Route::post('jalan/save', 'MasterData\Barang\JalanController@save')->name('jalan.save');
                Route::get('jalan/json', 'MasterData\Barang\JalanController@json')->name('getJsonJalan');
                Route::get('jalan/detail/{id}', 'MasterData\Barang\JalanController@detail')->name('getDetailKIBD');

                // lainnya
                // Aset Tetap Lainnya
                Route::get('aset-tetap-lainnya', 'MasterData\Barang\AsetTetapLainnyaController@index')->name('getAsetTetapLainnya');
                Route::post('aset-tetap-lainnya', 'MasterData\Barang\AsetTetapLainnyaController@index')->name('getAsetTetapLainnyaFilter');
                Route::get('aset-tetap-lainnya/add', 'MasterData\Barang\AsetTetapLainnyaController@add')->name('aset-tetap-lainnya.add');
                Route::get('aset-tetap-lainnya/edit/{id}', 'MasterData\Barang\AsetTetapLainnyaController@edit')->name('aset-tetap-lainnya.edit');
                Route::get('aset-tetap-lainnya/dokumen/download/{id}', 'MasterData\Barang\AsetTetapLainnyaController@download')->name('Gedung.dokumen.download');

                Route::post('aset-tetap-lainnya/getKecamatan', 'MasterData\Barang\AsetTetapLainnyaController@getKecamatan')->name('aset-tetap-lainnya.get.kecamatan');
                Route::post('aset-tetap-lainnya/getDesa', 'MasterData\Barang\AsetTetapLainnyaController@getDesa')->name('aset-tetap-lainnya.get.desa');
                Route::post('aset-tetap-lainnya/images-upload', 'ImageController@imagesUploadPost')->name('aset-tetap-lainnya/images-upload');

                Route::post('aset-tetap-lainnya/getNoRegister', 'MasterData\Barang\AsetTetapLainnyaController@getNoRegister')->name('aset-tetap-lainnya.noregister');
                Route::post('aset-tetap-lainnya/save', 'MasterData\Barang\AsetTetapLainnyaController@save')->name('aset-tetap-lainnya.save');
                Route::post('aset-tetap-lainnya/update', 'MasterData\Barang\AsetTetapLainnyaController@update')->name('aset-tetap-lainnya.update');

                Route::post('aset-tetap-lainnya/getKodePemilik', 'MasterData\Barang\AsetTetapLainnyaController@getKodePemilik')->name('aset-tetap-lainnya.kode-pemilik');
                Route::post('aset-tetap-lainnya/get-sub-unit', 'MasterData\Barang\AsetTetapLainnyaController@getSubUnit')->name('aset-tetap-lainnya.sub-unit');

                Route::post('aset-tetap-lainnya/get-upb', 'MasterData\Barang\AsetTetapLainnyaController@getUPB')->name('aset-tetap-lainnya.upb');
                Route::post('aset-tetap-lainnya/get-upb-filter-table', 'MasterData\Barang\AsetTetapLainnyaController@getUPBFilterTable')->name('aset-tetap-lainnya.upb.filter.table');
                Route::post('aset-tetap-lainnya/get-sub-rincian-obyek', 'MasterData\Barang\AsetTetapLainnyaController@getSubRincianObyek')->name('aset-tetap-lainnya.sub-rincian-obyek');
                Route::post('aset-tetap-lainnya/get-sub-sub-rincian-obyek', 'MasterData\Barang\AsetTetapLainnyaController@getSubSubRincianObyek')->name('aset-tetap-lainnya.sub-sub-rincian-obyek');
                Route::get('aset-tetap-lainnya/save', 'MasterData\Barang\AsetTetapLainnyaController@save')->name('aset-tetap-lainnya.save');
                Route::get('aset-tetap-lainnya/delete/{id}', 'MasterData\Barang\AsetTetapLainnyaController@delete')->name('deleteAsetById');
                Route::get('aset-tetap-lainnya/json', 'MasterData\Barang\AsetTetapLainnyaController@json')->name('getJsonAsetTetapLainnya');
                Route::get('aset-tetap-lainnya/detail/{id}', 'MasterData\Barang\AsetTetapLainnyaController@detail')->name('getDetailKIBE');


                //

                Route::get('kebudayaan', 'MasterData\Barang\KebudayaanController@index')->name('getKebudayaan');
                Route::post('kebudayaan', 'MasterData\Barang\KebudayaanController@index')->name('getKebudayaan');
                Route::get('kebudayaan/json', 'MasterData\Barang\KebudayaanController@json')->name('getJsonKebudayaan');
                Route::get('kebudayaan/add', 'MasterData\Barang\KebudayaanController@add')->name('kebudayaan.add');
                Route::post('kebudayaan/save', 'MasterData\Barang\KebudayaanController@save')->name('kebudayaan.save');
                Route::post('kebudayaan/get-upb-filter-table', 'MasterData\Barang\KebudayaanController@getUPBFilterTable')->name('kebudayaan.upb.filter.table');
                Route::get('kebudayaan/edit/{id}', 'MasterData\Barang\KebudayaanController@edit')->name('kebudayaan.edit');
                Route::post('kebudayaan/update', 'MasterData\Barang\KebudayaanController@update')->name('kebudayaan.update');
                Route::get('kebudayaan/delete/{id}', 'MasterData\Barang\KebudayaanController@delete')->name('kebudayaan.delete');
                Route::get('kebudayaan/detail/{id}', 'MasterData\Barang\KebudayaanController@detail')->name('getDetailKIBF');
                Route::get('kebudayaan/dokumen/download/{id}', 'MasterData\Barang\KebudayaanController@download')->name('kebudayaan.dokumen.download');


                Route::get('buku', 'MasterData\Barang\BukuController@index')->name('getBuku');
                Route::get('buku/json', 'MasterData\Barang\BukuController@json')->name('getBukuJson');
                Route::get('buku/detail/{id}', 'MasterData\Barang\BukuController@detail')->name('getDetailBuku');

                Route::get('buku/add', 'MasterData\Barang\BukuController@add')->name('buku.add');
                Route::post('buku/save', 'MasterData\Barang\BukuController@save')->name('buku.save');

                Route::post('buku/get-upb-filter-table', 'MasterData\Barang\BukuController@getUPBFilterTable')->name('buku.upb.filter.table');
                Route::get('buku/getBukuById/{id}', 'MasterData\Barang\BukuController@getBukuById')->name('buku.getBukuById');
                Route::post('buku/update', 'MasterData\Barang\BukuController@update')->name('buku.update');
                Route::get('buku/delete/{id}', 'MasterData\Barang\BukuController@delete')->name('buku.delete');

                Route::post('buku/get-sub-unit', 'MasterData\Barang\BukuController@getSubUnit')->name('buku.sub-unit');
                Route::post('buku/getKodePemilik', 'MasterData\Barang\BukuController@getKodePemilik')->name('buku.kode-pemilik');
                Route::post('buku/get-sub-unit', 'MasterData\Barang\BukuController@getSubUnit')->name('buku.sub-unit');
                Route::post('buku/get-upb', 'MasterData\Barang\BukuController@getUPB')->name('buku.upb');
                Route::post('buku/get-upb-filter-table', 'MasterData\Barang\BukuController@getUPBFilterTable')->name('buku.upb.filter.table');
                Route::post('buku/get-sub-rincian-obyek', 'MasterData\Barang\BukuController@getSubRincianObyek')->name('buku.sub-rincian-obyek');
                Route::post('buku/get-sub-sub-rincian-obyek', 'MasterData\Barang\BukuController@getSubSubRincianObyek')->name('buku.sub-sub-rincian-obyek');
                Route::post('buku/getKecamatan', 'MasterData\Barang\BukuController@getKecamatan')->name('buku.get.kecamatan');
                Route::post('buku/getDesa', 'MasterData\Barang\BukuController@getDesa')->name('buku.get.desa');
                Route::post('buku/getNoRegister', 'MasterData\Barang\BukuController@getNoRegister')->name('buku.noregister');


                Route::get('buku', 'MasterData\Barang\BukuController@index')->name('getBuku');
                Route::get('buku/json', 'MasterData\Barang\BukuController@json')->name('getBukuJson');
                Route::get('buku/detail/{id}', 'MasterData\Barang\BukuController@detail')->name('getDetailBuku');

                Route::get('buku/add', 'MasterData\Barang\BukuController@add')->name('buku.add');
                Route::post('buku/save', 'MasterData\Barang\BukuController@save')->name('buku.save');

                Route::post('buku/get-upb-filter-table', 'MasterData\Barang\BukuController@getUPBFilterTable')->name('buku.upb.filter.table');
                Route::get('buku/getBukuById/{id}', 'MasterData\Barang\BukuController@getBukuById')->name('buku.getBukuById');
                Route::post('buku/update', 'MasterData\Barang\BukuController@update')->name('buku.update');
                Route::get('buku/delete/{id}', 'MasterData\Barang\BukuController@delete')->name('buku.delete');

                Route::post('buku/get-sub-unit', 'MasterData\Barang\BukuController@getSubUnit')->name('buku.sub-unit');
                Route::post('buku/getKodePemilik', 'MasterData\Barang\BukuController@getKodePemilik')->name('buku.kode-pemilik');
                Route::post('buku/get-sub-unit', 'MasterData\Barang\BukuController@getSubUnit')->name('buku.sub-unit');
                Route::post('buku/get-upb', 'MasterData\Barang\BukuController@getUPB')->name('buku.upb');
                Route::post('buku/get-upb-filter-table', 'MasterData\Barang\BukuController@getUPBFilterTable')->name('buku.upb.filter.table');
                Route::post('buku/get-sub-rincian-obyek', 'MasterData\Barang\BukuController@getSubRincianObyek')->name('buku.sub-rincian-obyek');
                Route::post('buku/get-sub-sub-rincian-obyek', 'MasterData\Barang\BukuController@getSubSubRincianObyek')->name('buku.sub-sub-rincian-obyek');
                Route::post('buku/getKecamatan', 'MasterData\Barang\BukuController@getKecamatan')->name('buku.get.kecamatan');
                Route::post('buku/getDesa', 'MasterData\Barang\BukuController@getDesa')->name('buku.get.desa');
                Route::post('buku/getNoRegister', 'MasterData\Barang\BukuController@getNoRegister')->name('buku.noregister');
                Route::get('buku/edit/{id}', 'MasterData\Barang\BukuController@edit')->name('buku.edit');
            });
        });

        Route::group(['prefix' => 'unit-organisasi'], function () {
            Route::get('bidang', 'MasterData\BidangController@index')->name('getBidang');
            Route::get('bidang/json', 'MasterData\BidangController@json')->name('getJsonBidang');
            Route::get('unit', 'MasterData\UnitController@index')->name('getUnit');
            Route::post('unit', 'MasterData\UnitController@index')->name('getUnitFilter');
            Route::get('unit/json', 'MasterData\UnitController@json')->name('getJsonUnit');
            Route::get('unit/getUnitById/{id}', 'MasterData\UnitController@getUnitById')->name('getUnitById');
            Route::get('unit/delete/{id}', 'MasterData\UnitController@delete')->name('deleteUnitById');
            Route::post('unit/save', 'MasterData\UnitController@save')->name('saveUnit');
            Route::post('unit/update', 'MasterData\UnitController@update')->name('updateUnit');
        });

        Route::group(['prefix' => 'kode-barang'], function () {
            Route::get('jenis', 'MasterData\KodeBarang\JenisController@index')->name('getJenis');
            Route::post('jenis', 'MasterData\KodeBarang\JenisController@index')->name('getJenisFilter');
            Route::get('jenis/json', 'MasterData\KodeBarang\JenisController@json')->name('getJsonJenis');
            Route::get('jenis/getJenisById/{id}', 'MasterData\KodeBarang\JenisController@getJenisById')->name('getJenisById');
            Route::get('jenis/delete/{id}', 'MasterData\KodeBarang\JenisController@delete')->name('deleteJenisById');
            Route::post('jenis/save', 'MasterData\KodeBarang\JenisController@save')->name('saveJenis');
            Route::post('jenis/update', 'MasterData\KodeBarang\JenisController@update')->name('updateJenis');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('permission', 'MasterData\UserController@getPermission')->name('getAkses')->middleware('role:User,View');
            Route::post('add-permission/store', 'MasterData\UserController@storePermission')->name('createPermis');
            Route::get('destroy-permission/{id}', 'MasterData\UserController@destroyPermission')->name('deletePermission');
            Route::get('edit-permission/{id}', 'MasterData\UserController@editPermission')->name('editPermission');
            Route::post('update-permission/update', 'MasterData\UserController@updatePermission')->name('updatePermis');

            Route::post('add-menu/store', 'MasterData\UserController@storeMenu')->name('createMenu');
            Route::get('edit-menu/{id}', 'MasterData\UserController@editMenu')->name('editMenu');
            Route::post('update-menu/update', 'MasterData\UserController@updateMenu')->name('updateMenu');
            Route::get('destroy-menu/{id}', 'MasterData\UserController@destroyMenu')->name('deleteMenu');

            Route::get('role-akses', 'MasterData\UserController@getDaftarRoleAkses')->name('getRoleAkses');
            Route::get('role-akses/create', 'MasterData\UserController@createRoleAccess')->name('createRoleAccess');
            Route::post('role-akses/store', 'MasterData\UserController@storeRoleAccess')->name('storeRoleAccess');
            Route::get('role-akses/edit/{id}', 'MasterData\UserController@editRoleAccess')->name('editRoleAccess');
            Route::post('role-akses/update/{id}', 'MasterData\UserController@updateRoleAccess')->name('updateRoleAccess');

            // Route::post('role-akses/create', 'MasterData\UserController@createRoleAkses')->name('createRoleAkses');

            Route::get('role-akses/detail/{id}', 'MasterData\UserController@detailRoleAkses')->name('detailRoleAkses');
            Route::get('role-akses/delete/{id}', 'MasterData\UserController@deleteRoleAkses')->name('deleteRoleAkses');
            Route::get('role-akses/getData/{id}', 'MasterData\UserController@getDataRoleAkses')->name('getDataRoleAkses');
            Route::post('role-akses/updateData', 'MasterData\UserController@updateDataRoleAkses')->name('updateDataRoleAkses');

            Route::get('user-role', 'MasterData\UserController@getDataUserRole')->name('getDataUserRole');
            Route::post('user-role/create', 'MasterData\UserController@createUserRole')->name('createUserRole');
            Route::get('user-role/detail/{id}', 'MasterData\UserController@detailUserRole')->name('detailUserRole');
            Route::get('user-role/getData/{id}', 'MasterData\UserController@getUserRoleData')->name('getUserRoleData');
            Route::get('user-role/getDataParent', 'MasterData\UserController@getAllforParent')->name('getAllforParent');
            Route::post('user-role/updateData', 'MasterData\UserController@updateUserRole')->name('updateUserRole');
            Route::get('user-role/delete/{id}', 'MasterData\UserController@deleteUserRole')->name('deleteUserRole');
            // Route::get('edit/{id}', 'LandingController@editUPTD')->name('editLandingUPTD');
            // Route::post('create', 'LandingController@createUPTD')->name('createLandingUPTD');
            // Route::post('update', 'LandingController@updateUPTD')->name('updateLandingUPTD');
            // Route::get('delete/{id}', 'LandingController@deleteUPTD')->name('deleteLandingUPTD');
            Route::get('/management', 'MasterData\UserController@getUser')->name('getMasterUser');
            Route::get('/manajemen/detail/{id}', 'DetailUserController@showall')->name('detailMasterUser');
            Route::get('/manajemen/edit/{id}', 'MasterData\UserController@edit')->name('editUser');
            Route::post('/manajemen/create', 'MasterData\UserController@store')->name('createUser');
            Route::post('/manajemen/update', 'MasterData\UserController@update')->name('updateUser');
            Route::get('/manajemen/delete/{id}', 'MasterData\UserController@delete')->name('deleteUser');
        });
    });
});

Route::view('debug/map-dashboard', 'debug.map-dashboard');
Route::view('debug/map-filter', 'debug.map-filter');
Route::view('coba-map', 'debug.coba-map');
Route::view('coba-roaddroid', 'debug.map-roaddroid');
Route::view('map-progress-mingguan', 'debug.map-progress-mingguan');
Route::view('map-ruas-jalan', 'debug.map-ruas-jalan');

Route::get('debug', 'Backup\DebugController@debug');

Route::middleware(['auth'])->group(function () {
    Route::prefix('v1')->group(function () {
        Route::prefix('bankeu')->group(function () {
            Route::get('pre', 'MockupController@bankeu_create_pre');
        });
    });
});

Route::get('/gedung', function () {
    return view('admin/master/barang/gedung_bangunan/gedung');
});
