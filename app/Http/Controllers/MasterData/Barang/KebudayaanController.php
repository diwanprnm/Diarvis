<?php

namespace App\Http\Controllers\MasterData\Barang;

use App\Http\Controllers\Controller;
use App\Model\Master\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use Yajra\Datatables\DataTables;
use Illuminate\Support\Facades\Crypt;

class KebudayaanController extends Controller
{
    public function __construct()
    {
        // $roles = setAccessBuilder('Jembatan', ['add', 'store'], ['index','viewPhoto','json'], ['edit', 'update','editPhoto','updatePhoto'], ['deletePhoto','delPhoto']);
        // foreach ($roles as $role => $permission) {
        //     $this->middleware($role)->only($permission);
        // }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $filter['id_pemda'] = $request->id_pemda;
        $filter['kd_aset'] = $request->kd_aset;
        $filter['kd_aset0'] = $request->kd_aset0;
        $filter['kd_aset1'] = $request->kd_aset1;
        $filter['kd_aset2'] = $request->kd_aset2;
        $filter['kd_aset3'] = $request->kd_aset3;
        $filter['kd_aset4'] = $request->kd_aset4;
        $filter['kd_aset5'] = $request->kd_aset5;
        $filter['no_register'] = $request->f_no_register;


        $bidang = DB::table('ref_organisasi_bidang')->get();
        $rincian_object = DB::table('ref_rek3_108')->where('kd_aset1', '1')->get();
        // echo $request->id_pemda; 
        DB::enableQueryLog();
        $tanah = DB::table('ta_kib_f as a')->where('a.kd_hapus', '0')
            ->select(
                'a.idpemda as id',
                DB::raw("CONCAT(a.kd_aset8,'.',a.kd_aset80,'.',a.kd_aset81,'.',ltrim(to_char(a.kd_aset82, '00')) ,'.',ltrim(to_char(a.kd_aset83, '000')),'.',ltrim(to_char(a.kd_aset84, '000')),'.',ltrim(to_char(a.kd_aset85, '000'))) as kode_aset"),
                'a.no_register',
                'a.harga',
                'a.luas_lantai',
                'b.nm_pemilik',
                DB::raw(" to_char( a.tgl_perolehan, 'DD-MM-YYYY') as tgl_perolehan"),
                DB::raw(" to_char( a.tgl_pembukuan, 'DD-MM-YYYY') as tgl_pembukuan"),
                'a.lokasi',
                'a.bertingkat_tidak',
                'a.beton_tidak',
                'a.harga',
                DB::raw(" to_char( a.dokumen_tanggal, 'DD-MM-YYYY') as dokumen_tanggal")
            )
            ->join('ref_pemilik as b', 'a.kd_pemilik', '=', 'b.kd_pemilik');
        $formatRP = DB::statement("set LC_MONETARY='en_ID'");
        if (!empty($request->id_pemda)) {
            $tanah->where('a.idpemda', 'like', '%' . $request->id_pemda . '%');
        }
        if (!empty($request->kd_aset)) {
            $tanah->where('a.kd_aset8', $request->kd_aset);
        }
        if (!empty($request->kd_aset0)) {
            $tanah->where('a.kd_aset80', $request->kd_aset0);
        }
        if (!empty($request->kd_aset1)) {
            $tanah->where('a.kd_aset81', $request->kd_aset1);
        }
        if (!empty($request->kd_aset2)) {
            $tanah->where('a.kd_aset82', $request->kd_aset2);
        }
        if (!empty($request->kd_aset3)) {
            $tanah->where('a.kd_aset83', $request->kd_aset3);
        }
        if (!empty($request->kd_aset4)) {
            $tanah->where('a.kd_aset84', $request->kd_aset3);
        }
        if (!empty($request->kd_aset5)) {
            $tanah->where('a.kd_aset85', $request->kd_aset5);
        }
        //dd($tanah);
        if ($request->ajax()) {
            return DataTables::of($tanah, $formatRP)
                ->addIndexColumn()
                ->addColumn(
                    'action',
                    function ($row) {
                        $btn = '<div style="min-width:200px; class="btn-group  " role="group" data-placement="top" title="" data-original-title=".btn-xlg">';
                        //  if (hasAccess(Auth::user()->role_id, "Bidang", "View")) {
                        $btn = $btn . '<a href="kebudayaan/detail/' . Crypt::encryptString($row->id) . '"><button data-toggle="tooltip" title="Lihat Foto" class="btn btn-success btn-mini waves-effect waves-light"><i class="icofont icofont-eye"></i></button></a>';
                        //   }
                        if (hasAccess(Auth::user()->role_id, "Bidang", "Update")) {
                            $btn = $btn . '<a href="kebudayaan/edit/' . Crypt::encryptString($row->id) . '"><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-mini  waves-effect waves-light"><i class="icofont icofont-pencil"></i></button></a>';
                        }

                        if (hasAccess(Auth::user()->role_id, "Bidang", "Delete")) {
                            $btn = $btn . '<a href="#delModal" data-id="' . Crypt::encryptString($row->id) . '" data-toggle="modal"><button data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-mini waves-effect waves-light"><i class="icofont icofont-trash"></i></button></a>';
                        }

                        $btn = $btn . '</div>';

                        return $btn;
                    }
                )
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.master.kib_f.kebudayaan.kebudayaan', compact('bidang', 'filter', 'rincian_object'));
    }

    public function add()
    {

        $kode_pemilik = DB::table('ref_pemilik')->get();

        $kode_pemilik = DB::table('ref_pemilik')->get();
        $kab_kota = DB::table('ref_organisasi_kab_kota')->get();

        $unit = DB::table('ref_organisasi_unit')->get();
        $rincian_object = DB::table('ref_rek3_108')
            ->where('kd_aset1', '1')
            ->get();

        return view('admin.master.kib_f.kebudayaan.add', compact('kode_pemilik', 'unit', 'rincian_object', 'kab_kota'));
    }
    public function edit($id)
    {
        $decryptId = Crypt::decryptString($id);
        $kebudayaan = DB::table('ta_kib_f as a')
            ->select(
                'a.idpemda as id',
                'd.nama_unit',
                'e.nama_sub_unit',
                'f.nama_upb',
                'a.kd_aset8',
                'a.kd_aset80',
                'a.kd_aset81',
                'a.kd_aset82',
                'a.kd_aset83',
                'a.kd_aset84',
                'a.kd_aset85',
                'a.no_register',
                'a.harga',
                'a.luas_lantai',
                'a.kd_pemilik',
                'c.nm_pemilik',
                DB::raw(" to_char( a.tgl_perolehan, 'YYYY-MM-DD') as tgl_perolehan"),
                DB::raw("to_char( a.tgl_pembukuan, 'YYYY-MM-DD') as tgl_pembukuan"),
                'a.lokasi',
                DB::raw("to_char( a.dokumen_tanggal, 'YYYY-MM-DD') as dokumen_tanggal"),
                'a.kd_kab_kota',
                'a.kd_kecamatan',
                'a.kd_desa',
                'a.keterangan',
                'a.asal_usul',
                'a.latitude',
                'a.longitude',
                'a.beton_tidak',
                'a.bertingkat_tidak'
            )
            ->join('ref_pemilik as c', 'a.kd_pemilik', '=', 'c.kd_pemilik')
            ->join('ref_organisasi_unit as d', 'd.kode_unit', '=', 'a.kd_unit')
            ->join('ref_organisasi_sub_unit as e', 'e.kode_sub_unit', '=', 'a.kd_sub')
            ->join('ref_organisasi_upb as f', 'f.kode_upb', '=', 'a.kd_upb')
            ->where('a.idpemda', $decryptId)->first();
        $dokumen = DB::table('ta_kib_f as a')
            ->select('b.filename', 'b.id_dokumen')
            ->join('ta_kib_f_dokumen as b', 'a.idpemda', '=', 'b.idpemda')
            ->where('a.idpemda', $decryptId)->get();
        $kode_pemilik = DB::table('ref_pemilik')->get();
        $kab_kota = DB::table('ref_organisasi_kab_kota')->get();

        $unit = DB::table('ref_organisasi_unit')->get();
        $rincian_object = DB::table('ref_rek3_108')
            ->where('kd_aset1', '1')
            ->get();

        //str_replace('',$tanah->harga)
        $harga0 =  str_replace('Rp', '', $kebudayaan->harga);
        $harga =  floatval(str_replace('.', '', $harga0));
        $kecamatan = DB::table('ref_organisasi_kecamatan')->where('kode_kab_kota', $kebudayaan->kd_kab_kota)->get();
        $desa = DB::table('ref_organisasi_desa')->where('kode_kab_kota', $kebudayaan->kd_kab_kota)->get();

        $sub_rincian_obyek = DB::table('ref_rek4_108')
            ->where('kd_aset1', $kebudayaan->kd_aset81)
            ->where('kd_aset3', $kebudayaan->kd_aset83)
            ->get();

        $sub_sub_rincian_obyek = DB::table('ref_rek5_108')
            ->where('kd_aset1', $kebudayaan->kd_aset81)
            ->where('kd_aset4', $kebudayaan->kd_aset84)
            ->get();


        return view('admin.master.kib_f.kebudayaan.edit', compact('kebudayaan', 'dokumen', 'unit', 'rincian_object', 'kode_pemilik', 'kab_kota', 'harga', 'kecamatan', 'desa', 'sub_rincian_obyek', 'sub_sub_rincian_obyek'));
    }
    public function download($id_dokumen)
    {
        $dokumen =  DB::table('ta_kib_f_dokumen')
            ->select('filename', 'path', 'extension')
            ->where('id_dokumen', $id_dokumen)
            ->first();

        $file = public_path() . "/" . $dokumen->path . "/" . $dokumen->filename;
        $header = "";
        if ($dokumen->extension == "jpg") {
            $header = "image/jpeg";
        } else if ($dokumen->extension == "pdf") {
            $header = "application/pdf";
        } else if ($dokumen->extension == "png") {
            $header = "image/jpeg";
        }
        $headers  = array(
            'Content-Type: ' . $header
        );

        return Response::download($file, $dokumen->filename, $headers);
    }
    public function detail($id)
    {
        $decryptId = Crypt::decryptString($id);
        $kebudayaan = DB::table('ta_kib_f as a')
            ->join('ref_rek5_108 as b', function ($join) {
                $join->on('b.kd_aset5', '=', 'a.kd_aset85');
                $join->on('b.kd_aset4', '=', 'a.kd_aset84');
                $join->on('b.kd_aset3', '=', 'a.kd_aset83');
                $join->on('b.kd_aset2', '=', 'a.kd_aset82');
                $join->on('b.kd_aset1', '=', 'a.kd_aset81');
                $join->on('b.kd_aset0', '=', 'a.kd_aset80');
            })
            ->select(
                'a.idpemda as id',
                'b.nm_aset5',
                DB::raw("CONCAT(a.kd_aset8,'.',a.kd_aset80,'.',a.kd_aset81,'.',ltrim(to_char(a.kd_aset82, '00')) ,'.',ltrim(to_char(a.kd_aset83, '000')),'.',ltrim(to_char(a.kd_aset84, '000')),'.',ltrim(to_char(a.kd_aset85, '000'))) as kode_aset"),
                'a.no_register',
                'a.kd_pemilik',
                'c.nm_pemilik',
                DB::raw(" to_char( a.tgl_perolehan, 'DD-MM-YYYY') as tgl_perolehan"),
                DB::raw(" to_char( a.tgl_pembukuan, 'DD-MM-YYYY') as tgl_pembukuan"),
                'a.lokasi',
                'a.bertingkat_tidak',
                'a.beton_tidak',
                'a.harga',
                DB::raw(" to_char( a.dokumen_tanggal, 'DD-MM-YYYY') as dokumen_tanggal"),
                'a.asal_usul',
                'a.latitude',
                'a.longitude',
                'a.keterangan',
                'a.luas_lantai'
            )
            ->join('ref_pemilik as c', 'a.kd_pemilik', '=', 'c.kd_pemilik')
            ->where('a.idpemda', $decryptId)->first();

        $dokumen = DB::table('ta_kib_f as a')
            ->select('b.filename', 'b.id_dokumen')
            ->join('ta_kib_f_dokumen as b', 'a.idpemda', '=', 'b.idpemda')
            ->where('a.idpemda', $decryptId)->get();

        $profile_picture =  DB::table('ta_kib_f_dokumen')
            ->select('filename', 'path')
            ->where('idpemda', $decryptId)->where('extension', 'jpg')->first();

        return view('admin.master.kib_f.kebudayaan.detail', compact('kebudayaan', 'dokumen', 'profile_picture'));
    }
    public function update(Request $request)
    {
        $kebudayaan['kd_pemilik'] = $request->kode_pemilik;
        $kebudayaan['kd_aset8'] = $request->kd_aset;
        $kebudayaan['kd_aset80'] = $request->kd_aset0;
        $kebudayaan['kd_aset81'] = $request->kd_aset1;
        $kebudayaan['kd_aset82'] = $request->kd_aset2;
        $kebudayaan['kd_aset83'] = $request->kd_aset3;
        $kebudayaan['kd_aset84'] = $request->kd_aset4;
        $kebudayaan['kd_aset85'] = $request->kd_aset5;
        $kebudayaan['no_reg8'] = $this->getNoRegister($request);
        $kebudayaan['no_register'] = $this->getNoRegister($request);
        $kebudayaan['tgl_perolehan'] = $request->tanggal_perolehan;
        $kebudayaan['tgl_pembukuan'] = $request->tanggal_pembukuan;
        $kebudayaan['beton_tidak'] = $request->beton_tidak;
        $kebudayaan['bertingkat_tidak'] = $request->bertingkat_tidak;
        $kebudayaan['asal_usul'] = $request->asal_usul;
        $kebudayaan['harga'] = $request->harga;
        $kebudayaan['kd_kab_kota'] = $request->kab_kota;
        $kebudayaan['kd_kecamatan'] = $request->kecamatan;
        $kebudayaan['kd_desa'] = $request->desa;
        $kebudayaan['lokasi'] = $request->lokasi;
        $kebudayaan['dokumen_tanggal'] = $request->dokumen_tanggal;
        $kebudayaan['updated_at'] = date('Y-m-d H:i:s');
        $kebudayaan['latitude'] = $request->lat;
        $kebudayaan['longitude'] = $request->lng;
        $kebudayaan['luas_lantai'] = $request->luas_lantai;
        $kebudayaan['keterangan'] = $request->keterangan;
        $id = $request->idpemda;
        DB::table('ta_kib_f')->where('idpemda', $id)->update($kebudayaan);

        if ($request->hasfile('uploadFile')) {

            $path_folder = "/document/kib_f/" . $id;
            $path = public_path() . $path_folder;
            if (!file_exists($path)) {
                // path does not exist
                mkdir($path, 0755, true);
            }

            //$request()->validate([ 
            //    'file' => 'required|mimes:pdf,jpg,png|max:2048',
            //]);

            foreach ($request->file('uploadFile') as $file) {


                $imageName =  $file->getClientOriginalName();
                $file->move($path, $imageName);
                $this->saveFileKibA($id, $imageName, $path_folder);
            }
        }

        $color = "success";
        $msg = " Data Id Pemda " . $id . " telah diperbaharui";
        return redirect(route('getKebudayaan'))->with(compact('color', 'msg'));
    }
    public function delete($id)
    {
        $decryptid = Crypt::decryptString($id);
        $kebudayaan['kd_hapus'] = '1';
        $kebudayaan = DB::table('ta_kib_f')->where('idpemda', $decryptid)->update($kebudayaan);
        $color = "success";
        $msg = "Data Id Pemda " . $decryptid . " telah dihapus";
        return redirect(route('getKebudayaan'))->with(compact('color', 'msg'));
    }
    public function getSubUnit(Request $request)
    {
        if ($request->ajax()) {
            $ex = explode('_', $request->kode_unit);
            $kode_unit = $ex[0];
            $kode_bidang = $ex[1];
            $sub_unit = DB::table('ref_organisasi_sub_unit')->where('kode_unit', $kode_unit)->where('kode_bidang', $kode_bidang)->get();
            $data = view('admin.master.kib_a.ajax_select_sub_unit', compact('sub_unit'))->render();
            return response()->json(['options' => $data]);
        }
    }
    public function getUPB(Request $request)
    {
        if ($request->ajax()) {
            $ex = explode('_', $request->kode_sub_unit);
            $bidang = $ex[0];
            $kode_unit = $ex[1];
            $kode_sub_unit = $ex[2];
            $upb = DB::table('ref_organisasi_upb')
                ->where('kode_bidang', $bidang)
                ->where('kode_unit', $kode_unit)
                ->where('kode_sub_unit', $kode_sub_unit)
                ->get();
            $data = view('admin.master.kib_a.ajax_select_upb', compact('upb'))->render();
            return response()->json(['options' => $data]);
        }
    }

    public function getSubRincianObyek(Request $request)
    {
        if ($request->ajax()) {
            $ex = explode('_', $request->rincian_obyek);
            $kd_aset1 = $ex[0];
            $kd_aset3 = $ex[1];

            $sub_rincian_obyek = DB::table('ref_rek4_108')
                ->where('kd_aset1', $kd_aset1)
                ->where('kd_aset3', $kd_aset3)
                ->get();
            $data = view('admin.master.kib_a.ajax_select_subrincianobyek', compact('sub_rincian_obyek'))->render();
            return response()->json(['options' => $data]);
        }
    }

    public function getSubSubRincianObyek(Request $request)
    {
        if ($request->ajax()) {
            $ex = explode('_', $request->rincian_obyek);
            $kd_aset1 = $ex[0];
            $kd_aset4 = $ex[1];

            $sub_sub_rincian_obyek = DB::table('ref_rek5_108')
                ->where('kd_aset1', $kd_aset1)
                ->where('kd_aset4', $kd_aset4)
                ->get();
            $data = view('admin.master.kib_a.ajax_select_subsubrincianobyek', compact('sub_sub_rincian_obyek'))->render();
            return response()->json(['options' => $data]);
        }
    }

    public function getKodePemilik(Request $request)
    {
        $kode_pemilik = DB::table('ref_pemilik')->where('kd_pemilik', $request->kode_pemilik)->first();
        return $kode_pemilik->nm_pemilik;
    }

    public function save(Request $request)
    {
        $ex = explode('_', $request->upb);
        $bidang = $ex[0];
        $unit = $ex[1];
        $sub_unit = $ex[2];
        $upb = $ex[3];
        $kd_pemda = str_pad($bidang, 2, "0", STR_PAD_LEFT) . "" . str_pad($unit, 2, "0", STR_PAD_LEFT) . "" . str_pad($sub_unit, 3, "0", STR_PAD_LEFT) . "" . str_pad($upb, 3, "0", STR_PAD_LEFT) . "" . $request->kab_kota;
        $new_kd_pemda = $this->generateKodePemda($kd_pemda);
        $kebudayaan['kd_unit'] = $unit;
        $kebudayaan['kd_sub'] = $sub_unit;
        $kebudayaan['kd_bidang'] = $bidang;
        $kebudayaan['kd_upb'] = $upb;
        $kebudayaan['kd_hapus'] = '0';
        $kebudayaan['idpemda'] = $new_kd_pemda;
        $kebudayaan['kd_pemilik'] = $request->kode_pemilik;
        $kebudayaan['kd_aset1'] = $request->kd_aset1;
        $kebudayaan['kd_aset2'] = $request->kd_aset2;
        $kebudayaan['kd_aset3'] = $request->kd_aset3;
        $kebudayaan['kd_aset4'] = $request->kd_aset4;
        $kebudayaan['kd_aset5'] = $request->kd_aset5;
        $kebudayaan['kd_aset8'] = $request->kd_aset;
        $kebudayaan['kd_aset80'] = $request->kd_aset0;
        $kebudayaan['kd_aset81'] = $request->kd_aset1;
        $kebudayaan['kd_aset82'] = $request->kd_aset2;
        $kebudayaan['kd_aset83'] = $request->kd_aset3;
        $kebudayaan['kd_aset84'] = $request->kd_aset4;
        $kebudayaan['kd_aset85'] = $request->kd_aset5;
        $kebudayaan['no_reg8'] = $this->getNoRegister($request);
        $kebudayaan['no_register'] = $this->getNoRegister($request);
        $kebudayaan['tgl_perolehan'] = $request->tgl_perolehan;
        $kebudayaan['tgl_pembukuan'] = $request->tgl_pembukuan;
        $kebudayaan['beton_tidak'] = $request->beton_tidak;
        $kebudayaan['bertingkat_tidak'] = $request->bertingkat_tidak;
        $kebudayaan['asal_usul'] = $request->asal_usul;
        $kebudayaan['harga'] = $request->harga;
        $kebudayaan['kd_hapus'] = '0';
        $kebudayaan['kondisi'] = '1';
        $kebudayaan['kd_prov'] = 10;
        $kebudayaan['kd_kab_kota'] = $request->kab_kota;
        $kebudayaan['kd_kecamatan'] = $request->kecamatan;
        $kebudayaan['kd_desa'] = $request->desa;
        $kebudayaan['lokasi'] = $request->lokasi;
        $kebudayaan['dokumen_tanggal'] = $request->dokumen_tgl;
        $kebudayaan['created_at'] = date('Y-m-d H:i:s');
        $kebudayaan['latitude'] = $request->lat;
        $kebudayaan['longitude'] = $request->lng;
        $kebudayaan['luas_lantai'] = $request->luas_lantai;
        $kebudayaan['keterangan'] = $request->keterangan;
        DB::table('ta_kib_f')->insert($kebudayaan);

        if ($request->hasfile('uploadFile')) {

            $path_folder = "/document/kib_f/" . $new_kd_pemda;
            $path = public_path() . $path_folder;
            if (!file_exists($path)) {
                // path does not exist
                mkdir($path, 0755, true);
            }

            //$request()->validate([ 
            //    'file' => 'required|mimes:pdf,jpg,png|max:2048',
            //]);

            foreach ($request->file('uploadFile') as $file) {


                $imageName =  $file->getClientOriginalName();
                $file->move($path, $imageName);
                $this->saveFileKibA($new_kd_pemda, $imageName, $path_folder);
            }
        }

        $color = "success";
        $msg = "Berhasil Menambah Data Kebudayaan (KIB F)";
        return redirect(route('getKebudayaan'))->with(compact('color', 'msg'));
    }

    public function saveFileKibA($idpemda, $filename, $path)
    {
        $dokumen['idpemda'] = $idpemda;
        $dokumen['filename'] =  $filename;
        $dokumen['path'] =  $path;
        DB::table('ta_kib_f_dokumen')->insert($dokumen);
    }

    public function imagesUploadPost(Request $request)
    {

        request()->validate([
            'uploadFile' => 'required',
        ]);

        foreach ($request->file('uploadFile') as $file) {
            $imageName =  $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
        }
        return true;
    }

    public function generateKodePemda($kd)
    {
        $kib_a = DB::table('ta_kib_f')
            ->select(DB::raw("MAX(idpemda) as id_pemda"))
            ->where('idpemda', 'LIKE', '%' . $kd . '%')->first();

        $last_code = ltrim(substr($kib_a->id_pemda, 12, 6), 0);
        $newcode = $kd . '' . str_pad(((int)$last_code + 1), 6, "0", STR_PAD_LEFT);
        return $newcode;
    }

    public function getNoRegister(Request $request)
    {

        $kd_aset = $request->kd_aset8;
        $kd_aset0 = $request->kd_aset80;
        $kd_aset1 = $request->kd_aset81;
        $kd_aset2 = $request->kd_aset82;
        $kd_aset3 = $request->kd_aset83;
        $kd_aset4 = $request->kd_aset84;
        $kd_aset5 = $request->kd_aset85;
        $no_reg = DB::table('ta_kib_f')
            ->select(DB::raw("MAX(no_register) as max_noreg"))
            ->where('kd_aset8', $kd_aset)
            ->where('kd_aset80', $kd_aset0)
            ->where('kd_aset81', $kd_aset1)
            ->where('kd_aset82', $kd_aset2)
            ->where('kd_aset83', $kd_aset3)
            ->where('kd_aset84', $kd_aset4)
            ->where('kd_aset85', $kd_aset5)->first();
        if (!empty($no_reg->max_noreg)) {
            $no_reg = ($no_reg->max_noreg + 1);
        } else {
            $no_reg = 1;
        }
        return $no_reg;
    }

    public function getUPBFilterTable(Request $request)
    {
        if ($request->ajax()) {
            $ex = explode('_', $request->kode_upb);
            $bidang = $ex[0];
            $kode_unit = $ex[1];
            $kode_sub_unit = $ex[2];
            $kode_upb = $ex[3];
            $kib_a = DB::table('ta_kib_f')
                ->select('kd_bidang', 'kd_unit', 'kd_sub', 'idpemda', 'kd_upb', 'no_register', 'tgl_perolehan', 'harga', 'keterangan', DB::raw("CONCAT(kd_aset8,'.',kd_aset80,'.',kd_aset81,'.',ltrim(to_char(kd_aset82, '00')) ,'.',ltrim(to_char(kd_aset83, '000')),'.',ltrim(to_char(kd_aset84, '000')),'.',ltrim(to_char(kd_aset85, '000'))) as kode_aset"))
                ->where('kd_bidang', $bidang)
                ->where('kd_unit', $kode_unit)
                ->where('kd_sub', $kode_sub_unit)
                ->where('kd_upb', $kode_upb)
                ->get();
            $data = view('admin.master.kib_f.ajax_select_table_kibf', compact('kib_a'))->render();
            return response()->json(['data' => $data]);
        }
    }
}
