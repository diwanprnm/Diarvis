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
use SebastianBergmann\Environment\Console;
use Yajra\Datatables\DataTables;
use Session;

class AsetTetapLainnyaController extends Controller
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
        // dd("hello");
        $filter['judul'] = $request->judul;

        
        if (!empty($request->judul)) {
        //   dd($filter['judul']);
        }
        // $filter['kode_unit'] = $request->kode_unit;
        // $filter['nama_unit'] = $request->nama_unit;
        $bidang = DB::table('ref_organisasi_bidang')->get();

        return view('admin.master.kib_e.aset_tetap_lainnya', compact('bidang', 'filter'));
    }

    public function json(Request $request)
    {
        // dd("helo");
        $aset = DB::table('ta_kib_e as a')
            ->select(
                'a.idpemda as id',
                'tahun',
                DB::raw("CONCAT(a.kd_aset8,'.',a.kd_aset80,'.',a.kd_aset81,'.',ltrim(to_char(a.kd_aset82, '00')) ,'.',ltrim(to_char(a.kd_aset83, '000')),'.',ltrim(to_char(a.kd_aset84, '000')),'.',ltrim(to_char(a.kd_aset85, '000'))) as kode_aset"),
                'a.no_register',
                'a.harga',
                'a.judul',
                'b.nm_pemilik',
                DB::raw(" to_char( a.tgl_perolehan, 'DD-MM-YYYY') as tgl_perolehan"),
                'a.tgl_pembukuan',
                'a.bahan',
                'a.masa_manfaat',
                'a.ukuran',
                'a.nilai_sisa',
                'a.pencipta',
                'a.asal_usul',
                'a.kd_ka'
            )
            ->join('ref_pemilik as b', 'a.kd_pemilik', '=', 'b.kd_pemilik')
            ->where('a.kd_hapus', '0')
            ->where('a.kd_ka', '1');

        if (!empty($request->judul)) {
            $aset->where('a.judul','like','%'. $request->judul . '%');
        }

        return DataTables::of($aset)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div style="min-width:200px; class="btn-group  " role="group" data-placement="top" title="" data-original-title=".btn-xlg">';
                //  if (hasAccess(Auth::user()->role_id, "Bidang", "View")) {
                $btn = $btn . '<a href="' . route("getDetailKIBE", $row->id) . '"><button data-toggle="tooltip" title="Lihat Foto" class="btn btn-success btn-mini waves-effect waves-light"><i class="icofont icofont-eye"></i></button></a>';
                //   }
                if (hasAccess(Auth::user()->role_id, "Bidang", "Update")) {
                    $btn = $btn . '<a href="' . route('aset-tetap-lainnya.edit', $row->id) . ' "><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-mini  waves-effect waves-light"><i class="icofont icofont-pencil"></i></button></a>';
                }

                if (hasAccess(Auth::user()->role_id, "Bidang", "Delete")) {
                    $btn = $btn . '<a href="#delModal" data-id="' . $row->id . '" data-toggle="modal"><button data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-mini waves-effect waves-light"><i class="icofont icofont-trash"></i></button></a>';
                }
                $btn = $btn . '</div>';

                return $btn;
            })
            ->rawColumns(['action'])

            ->make(true);
    }

    public function detail($id)
    {
        $aset = DB::table('ta_kib_e as a')->where('a.kd_ka', '1')
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
                'a.tahun',
                'b.nm_aset5',
                'tahun',
                DB::raw("CONCAT(a.kd_aset8,'.',a.kd_aset80,'.',a.kd_aset81,'.',ltrim(to_char(a.kd_aset82, '00')) ,'.',ltrim(to_char(a.kd_aset83, '000')),'.',ltrim(to_char(a.kd_aset84, '000')),'.',ltrim(to_char(a.kd_aset85, '000'))) as kode_aset"),
                'a.no_register',
                'a.harga',
                'a.judul',
                'c.nm_pemilik',
                DB::raw(" to_char( a.tgl_perolehan, 'DD-MM-YYYY') as tgl_perolehan"),
                'a.tgl_pembukuan',
                'a.bahan',
                'a.masa_manfaat',
                'a.ukuran',
                'a.nilai_sisa',
                'a.pencipta',
                'a.asal_usul',
                'a.kd_ka',
                'a.kd_pemilik',
                'a.keterangan'
            )
            ->join('ref_pemilik as c', 'a.kd_pemilik', '=', 'c.kd_pemilik')
            ->where('a.idpemda', $id)->first();

        // $dokumen = DB::table('ta_kib_a as a')
        //         ->select('b.filename','b.id_dokumen')
        //            ->join('ta_kib_a_dokumen as b','a.idpemda','=','b.idpemda')
        //            ->where('a.idpemda',$id)->get();

        $profile_picture =  DB::table('ta_kib_a_dokumen')
            ->select('filename', 'path')
            ->where('idpemda', $id)->where('extension', 'jpg')->first();
        return view('admin.master.kib_e.detail', compact('aset'));
    }

    public function getSubUnit(Request $request)
    {
        if ($request->ajax()) {
            $ex = explode('_', $request->kode_unit);
            $kode_unit = $ex[0];
            $kode_bidang = $ex[1];
            $sub_unit = DB::table('ref_organisasi_sub_unit')->where('kode_unit', $kode_unit)->where('kode_bidang', $kode_bidang)->get();
            $data = view('admin.master.kib_e.ajax_select_sub_unit', compact('sub_unit'))->render();
            return response()->json(['options' => $data]);
        }
    }

    public function download($id_dokumen)
    {
        $dokumen =  DB::table('ta_kib_a_dokumen')
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
            $data = view('admin.master.kib_e.ajax_select_upb', compact('upb'))->render();
            return response()->json(['options' => $data]);
        }
    }

    public function getUPBFilterTable(Request $request)
    {
        if ($request->ajax()) {
            $ex = explode('_', $request->kode_upb);
            $bidang = $ex[0];
            $kode_unit = $ex[1];
            $kode_sub_unit = $ex[2];
            $kode_upb = $ex[3];
            $kib_e = DB::table('ta_kib_e')
                ->select('kd_bidang', 'kd_unit', 'kd_sub', 'idpemda', 'kd_upb', 'no_register', 'tgl_perolehan', 'harga', 'keterangan', DB::raw("CONCAT(kd_aset8,'.',kd_aset80,'.',kd_aset81,'.',ltrim(to_char(kd_aset82, '00')) ,'.',ltrim(to_char(kd_aset83, '000')),'.',ltrim(to_char(kd_aset84, '000')),'.',ltrim(to_char(kd_aset85, '000'))) as kode_aset"))
                ->where('kd_bidang', $bidang)
                ->where('kd_unit', $kode_unit)
                ->where('kd_sub', $kode_sub_unit)
                ->where('kd_upb', $kode_upb)
                ->get();
            $data = view('admin.master.kib_e.ajax_select_table_kibe', compact('kib_e'))->render();
            return response()->json(['data' => $data]);
        }
    }

    public function generateKodePemda($kd)
    {
        $kib_e = DB::table('ta_kib_e')
            ->select(DB::raw("MAX(idpemda) as id_pemda"))
            ->where('idpemda', 'LIKE', '%' . $kd . '%')->first();

        $last_code = ltrim(substr($kib_e->id_pemda, 12, 6), 0);
        $newcode = $kd . '' . str_pad(((int)$last_code + 1), 6, "0", STR_PAD_LEFT);
        return $newcode;
    }
    public function saveFileKibA($idpemda, $filename, $path)
    {
        $dokumen['idpemda'] = $idpemda;
        $dokumen['filename'] =  $filename;
        $dokumen['path'] =  $path;
        DB::table('ta_kib_a_dokumen')->insert($dokumen);
    }
    public function save(Request $request)
    {
        // dd("hello", $request);
        $ex = explode('_', $request->upb);
        $bidang = $ex[0];
        $unit = $ex[1];
        $sub_unit = $ex[2];
        $upb = $ex[3];
        $kd_pemda = str_pad($bidang, 2, "0", STR_PAD_LEFT) . "" . str_pad($unit, 2, "0", STR_PAD_LEFT) . "" . str_pad($sub_unit, 3, "0", STR_PAD_LEFT) . "" . str_pad($upb, 3, "0", STR_PAD_LEFT) . "" . $request->kab_kota;
        $new_kd_pemda = $this->generateKodePemda($kd_pemda);
        $kib_e['kd_prov'] = "10";
        $kib_e['kd_kab_kota'] = $request->kab_kota;
        $kib_e['idpemda'] = $new_kd_pemda;
        $kib_e['kd_bidang'] = $bidang;
        $kib_e['kd_unit'] = $unit;
        $kib_e['kd_sub'] = $sub_unit;
        $kib_e['kd_upb'] = $upb;
        $kib_e['kd_ka'] = '1';
        $kib_e['kd_hapus'] = '0';
        $kib_e['kd_pemilik'] = $request->kode_pemilik;
        $kib_e['kd_aset8'] = $request->kd_aset;
        $kib_e['kd_aset80'] = $request->kd_aset0;
        $kib_e['kd_aset81'] = $request->kd_aset1;
        $kib_e['kd_aset82'] = $request->kd_aset2;
        $kib_e['kd_aset83'] = $request->kd_aset3;
        $kib_e['kd_aset84'] = $request->kd_aset4;
        $kib_e['kd_aset85'] = $request->kd_aset5;
        $kib_e['no_register'] = $this->getNoRegister($request);
        $kib_e['tgl_perolehan'] = $request->tanggal_pembelian;
        $kib_e['tgl_pembukuan'] = $request->tanggal_pembukuan;
        $kib_e['asal_usul'] = $request->asal_usul;
        $kib_e['judul'] = $request->judul;
        $kib_e['bahan'] = $request->bahan;
        $kib_e['pencipta'] = $request->pencipta;
        $kib_e['ukuran'] = $request->ukuran;
        $kib_e['masa_manfaat'] = $request->masa_manfaat;
        $kib_e['nilai_sisa'] = $request->nilai_sisa;
        $kib_e['harga'] = $request->harga;
        $kib_e['keterangan'] = $request->keterangan;
        $kib_e['kd_kecamatan'] = $request->kecamatan;
        $kib_e['kd_desa'] = $request->desa;
        $kib_e['kondisi'] = 1;
        $kib_e['kd_data'] = 1;
        DB::table('ta_kib_e')->insert($kib_e);

        if ($request->hasfile('uploadFile')) {

            $path_folder = "/document/kib_a/" . $new_kd_pemda;
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
        $msg = "data Kib-E telah ditambahkan";
        return redirect(route('getAsetTetapLainnya'))->with(compact('color', 'msg'));
    }



    public function update(Request $request)
    {

        // dd('hello');

        $kib_e['kd_pemilik'] = $request->kode_pemilik;
        $kib_e['kd_aset8'] = $request->kd_aset;
        $kib_e['kd_aset80'] = $request->kd_aset0;
        $kib_e['kd_aset81'] = $request->kd_aset1;
        $kib_e['kd_aset82'] = $request->kd_aset2;
        $kib_e['kd_aset83'] = $request->kd_aset3;
        $kib_e['kd_aset84'] = $request->kd_aset4;
        $kib_e['kd_aset85'] = $request->kd_aset5;
        // $kib_e['no_register'] = $this->getNoRegister($request);
        $kib_e['tgl_perolehan'] = $request->tanggal_pembelian;
        $kib_e['tgl_pembukuan'] = $request->tanggal_pembukuan;
        $kib_e['judul'] = $request->judul;
        $kib_e['bahan'] = $request->bahan;
        $kib_e['pencipta'] = $request->pencipta;
        $kib_e['ukuran'] = $request->ukuran;
        $kib_e['masa_manfaat'] = $request->masa_manfaat;
        $kib_e['nilai_sisa'] = $request->nilai_sisa;
        $kib_e['asal_usul'] = $request->asal_usul;
        $kib_e['harga'] = $request->harga;
        $kib_e['keterangan'] = $request->keterangan;
        $kib_e['kd_kecamatan'] = $request->kecamatan;
        $kib_e['kd_desa'] = $request->desa;
        $id = $request->idpemda;
        DB::table('ta_kib_e')->where('idpemda', $id)->update($kib_e);

        if ($request->hasfile('uploadFile')) {

            $path_folder = "/document/kib_a/" . $new_kd_pemda;
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
        $msg = " Data Id Pemda " . $id . " telah diperbaharui";
        return redirect(route('getAsetTetapLainnya'))->with(compact('color', 'msg'));
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

    public function getNoRegister(Request $request)
    {

        $kd_aset = $request->kd_aset;
        $kd_aset0 = $request->kd_aset0;
        $kd_aset1 = $request->kd_aset1;
        $kd_aset2 = $request->kd_aset2;
        $kd_aset3 = $request->kd_aset3;
        $kd_aset4 = $request->kd_aset4;
        $kd_aset5 = $request->kd_aset5;
        $no_reg = DB::table('ta_kib_e')
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
            $data = view('admin.master.kib_e.ajax_select_subrincianobyek', compact('sub_rincian_obyek'))->render();
            return response()->json(['options' => $data]);
        }
    }

    public function getKecamatan(Request $request)
    {
        if ($request->ajax()) {
            $kecamatan = DB::table('ref_organisasi_kecamatan')
                ->where('kode_kab_kota', $request->kode_kab_kota)

                ->get();
            $data = view('admin.master.kib_e.ajax_select_kecamatan', compact('kecamatan'))->render();
            return response()->json(['options' => $data]);
        }
    }

    public function getDesa(Request $request)
    {
        if ($request->ajax()) {
            $desa = DB::table('ref_organisasi_desa')
                ->where('kode_kecamatan', $request->kode_kecamatan)

                ->get();
            $data = view('admin.master.kib_e.ajax_select_desa', compact('desa'))->render();
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
            $data = view('admin.master.kib_e.ajax_select_subsubrincianobyek', compact('sub_sub_rincian_obyek'))->render();
            return response()->json(['options' => $data]);
        }
    }
    public function getKodePemilik(Request $request)
    {
        $kode_pemilik = DB::table('ref_pemilik')->where('kd_pemilik', $request->kode_pemilik)->first();
        return $kode_pemilik->nm_pemilik;
    }
    public function add()
    {

        $kode_pemilik = DB::table('ref_pemilik')->get();
        $kab_kota = DB::table('ref_organisasi_kab_kota')->get();

        $unit = DB::table('ref_organisasi_unit')->get();
        $rincian_object = DB::table('ref_rek3_108')
            ->where('kd_aset1', '5')
            ->get();

        return view('admin.master.kib_e.add', compact('kode_pemilik', 'unit', 'rincian_object', 'kab_kota'));
    }



    public function edit($id)
    {

        $aset = DB::table('ta_kib_e as a')->where('a.kd_ka', '1')


            ->select(
                'a.idpemda as id',
                'a.tahun',
                DB::raw("CONCAT(a.kd_aset8,'.',a.kd_aset80,'.',a.kd_aset81,'.',ltrim(to_char(a.kd_aset82, '00')) ,'.',ltrim(to_char(a.kd_aset83, '000')),'.',ltrim(to_char(a.kd_aset84, '000')),'.',ltrim(to_char(a.kd_aset85, '000'))) as kode_aset"),
                'a.no_register',
                'a.harga',
                'a.judul',
                'c.nm_pemilik',
                DB::raw(" to_char( a.tgl_perolehan, 'YYYY-MM-DD') as tgl_perolehan"),
                DB::raw("to_char( a.tgl_pembukuan, 'YYYY-MM-DD') as tgl_pembukuan"),
                'a.bahan',
                'a.masa_manfaat',
                'a.ukuran',
                'a.nilai_sisa',
                'a.pencipta',
                'a.asal_usul',
                'a.kd_ka',
                'a.kd_pemilik',
                'a.keterangan',

                'd.nama_unit',
                'e.nama_sub_unit',
                'f.nama_upb',

                'c.nm_pemilik',
                'a.kd_kab_kota',
                'a.kd_kecamatan',
                'a.kd_desa',
                'a.keterangan',
                'a.asal_usul',
                'a.kd_ka',
                'a.kd_aset8',
                'a.kd_aset80',
                'a.kd_aset81',
                'a.kd_aset82',
                'a.kd_aset83',
                'a.kd_aset84',
                'a.kd_aset85',

            )
            ->join('ref_pemilik as c', 'a.kd_pemilik', '=', 'c.kd_pemilik')
            ->join('ref_organisasi_unit as d', 'd.kode_unit', '=', 'a.kd_unit')
            ->join('ref_organisasi_sub_unit as e', 'e.kode_sub_unit', '=', 'a.kd_sub')
            ->join('ref_organisasi_upb as f', 'f.kode_upb', '=', 'a.kd_upb')
            ->where('a.idpemda', $id)->first();
        // dd($aset);
        $dokumen = DB::table('ta_kib_a as a')
            ->select('b.filename', 'b.id_dokumen')
            ->join('ta_kib_a_dokumen as b', 'a.idpemda', '=', 'b.idpemda')
            ->where('a.idpemda', $id)->get();
        $kode_pemilik = DB::table('ref_pemilik')->get();
        $kab_kota = DB::table('ref_organisasi_kab_kota')->get();

        $unit = DB::table('ref_organisasi_unit')->get();
        $rincian_object = DB::table('ref_rek3_108')
            ->where('kd_aset1', '5')
            ->get();

        //str_replace('',$aset->harga)
        $harga0 =  str_replace('Rp', '', $aset->harga);
        $harga =  floatval(str_replace('.', '', $harga0));
        $kecamatan = DB::table('ref_organisasi_kecamatan')->where('kode_kab_kota', $aset->kd_kab_kota)->get();
        $desa = DB::table('ref_organisasi_desa')->where('kode_kab_kota', $aset->kd_kab_kota)->get();

        $sub_rincian_obyek = DB::table('ref_rek4_108')
            ->where('kd_aset1', $aset->kd_aset81)
            ->where('kd_aset3', $aset->kd_aset83)
            ->get();

        $sub_sub_rincian_obyek = DB::table('ref_rek5_108')
            ->where('kd_aset1', $aset->kd_aset81)
            ->where('kd_aset4', $aset->kd_aset84)
            ->get();

        // dd('hello');
        return view('admin.master.kib_e.edit', compact('aset', 'dokumen', 'unit', 'rincian_object', 'kode_pemilik', 'kab_kota', 'harga', 'kecamatan', 'desa', 'sub_rincian_obyek', 'sub_sub_rincian_obyek'));
    }

    public function deletePhoto($id)
    {
        $id = (int) $id;
        $foto = DB::table('master_jembatan_foto')->where('id_jembatan', $id)->get();

        return view('admin.master.jembatan.deletePhoto', compact('foto'));
    }

    public function editPhoto($id)
    {
        $jembatan = Jembatan::find($id);
        $foto = DB::table('master_jembatan_foto')->where('id_jembatan', $jembatan->id)->get();

        return view('admin.master.jembatan.editPhoto', compact('jembatan', 'foto'));
    }



    public function updatePhoto(Request $request)
    {
        $oldfoto = DB::table('master_jembatan_foto')->where('id_jembatan', $request->id)->get();

        $old = array();
        foreach ($oldfoto as $i => $val) {
            array_push($old, $val->id);
        }

        foreach ($request->id_j as $k => $val) {
            if ($val != '') {

                if (in_array($val, $old)) {
                    $foto['nama'] = $request->nama[$k];
                    if ($request->foto != null) {
                        if (array_key_exists($k, $request->foto)) {
                            $path = 'jembatan/' . Str::snake(date("YmdHis") . ' ' . $request->foto[$k]->getClientOriginalName());
                            $request->foto[$k]->storeAs('public/', $path);
                            $foto['foto'] = $path;
                        } else {
                            unset($foto['foto']);
                        }
                    }

                    $foto['id_jembatan'] = $request->id;
                    DB::table('master_jembatan_foto')->where('id', $val)->update($foto);
                }
            } else {

                if (array_key_exists($k, $request->foto)) {
                    $path = 'jembatan/' . Str::snake(date("YmdHis") . ' ' . $request->foto[$k]->getClientOriginalName());
                    $request->foto[$k]->storeAs('public/', $path);
                    $file['nama'] = $request->nama[$k];
                    $file['id_jembatan'] = $request->id;
                    $file['foto'] = $path;
                    DB::table('master_jembatan_foto')->insert($file);
                }
            }
        }


        $color = "success";
        $msg = "Berhasil Memperbaharui Foto Jembatan";

        return redirect(route('editPhotoJembatan', $request->id))->with(compact('color', 'msg'));
    }

    public function delete($id)
    {
        // dd("hello");
        // $jembatan = DB::table('master_jembatan');
        // $old = $jembatan->where('id', $id);
        // $old->first()->foto ?? Storage::delete('public/' . $old->first()->foto);
        // $old->delete();

        // $foto = DB::table('master_jembatan_foto')->where('id_jembatan', $id)->delete();
        $kib_e['kd_hapus'] = 1;
        DB::table('ta_kib_e')->where('idpemda', $id)->update($kib_e);

        $color = "success";
        $msg = "Berhasil Menghapus Data Aset Tetap Lainnya";
        return redirect(route('getAsetTetapLainnya'))->with(compact('color', 'msg'));
    }

    public function delPhoto($id)
    {
        $foto = DB::table('master_jembatan_foto')->where('id', $id)->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Foto Jembatan";
        return redirect(route('editPhotoJembatan', $id))->with(compact('color', 'msg'));
    }

    public function getTipeBangunan()
    {
        $tipe = DB::table('utils_tipe_bangunan_atas');
        $tipe = $tipe->get();

        return response()->json($tipe);
    }

    public function viewPhoto($id)
    {
        $foto = DB::table('master_jembatan_foto')->where('id_jembatan', $id)->get();

        return view('admin.master.jembatan.viewPhoto', compact('foto'));
    }
}
