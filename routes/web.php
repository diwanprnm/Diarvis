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
                Route::get('tanah/json', 'MasterData\Barang\TanahController@json')->name('getJsonTanah');
                Route::get('tanah/detail/{id}', 'MasterData\Barang\TanahController@detail')->name('getDetailKIBA');

                // Peralatan dan Mesin

                Route::get('peralatandanmesin', 'MasterData\Barang\PeralatanController@index')->name('getPeralatan');
                Route::get('peralatandanmesin/add', 'MasterData\Barang\PeralatanController@add')->name('peralatan.add');
                Route::get('peralatan/json', 'MasterData\Barang\PeralatanController@json')->name('getJsonPeralatan');

                // Gedung

                Route::get('gedung', 'MasterData\Barang\GedungController@index')->name('getGedung');
                Route::post('gedung', 'MasterData\Barang\GedungController@index')->name('getGedung');
                Route::get('gedung/add', 'MasterData\Barang\GedungController@add')->name('gedung.add');
                Route::post('gedung/getKodePemilik', 'MasterData\Barang\GedungController@getKodePemilik')->name('gedung.kode-pemilik');
                Route::post('gedung/get-sub-unit', 'MasterData\Barang\GedungController@getSubUnit')->name('gedung.sub-unit');

                Route::post('gedung/get-upb', 'MasterData\Barang\GedungController@getUPB')->name('gedung.upb');
                Route::post('gedung/get-upb-filter-table', 'MasterData\Barang\GedungController@getUPBFilterTable')->name('gedung.upb.filter.table');
                Route::post('gedung/get-sub-rincian-obyek', 'MasterData\Barang\GedungController@getSubRincianObyek')->name('gedung.sub-rincian-obyek');
                Route::post('gedung/get-sub-sub-rincian-obyek', 'MasterData\Barang\GedungController@getSubSubRincianObyek')->name('gedung.sub-sub-rincian-obyek');
                Route::get('gedung/save', 'MasterData\Barang\GedungController@save')->name('gedung.save');
                Route::get('gedung/json', 'MasterData\Barang\GedungController@json')->name('getJsonGedung');
                Route::get('gedung/detail/{id}', 'MasterData\Barang\GedungController@detail')->name('getDetailKIBC');


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

Route::get('/gedung',function(){
    return view('admin/master/barang/gedung_bangunan/gedung');
});
