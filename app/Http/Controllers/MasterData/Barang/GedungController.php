<?php

namespace App\Http\Controllers\MasterData\Barang;

use App\Http\Controllers\Controller;
use App\Model\Master\Barang\Gedung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class GedungController extends Controller {
    public function __construct()
    {
       // $roles = setAccessBuilder('Jembatan', ['add', 'store'], ['index','viewPhoto','json'], ['edit', 'update','editPhoto','updatePhoto'], ['deletePhoto','delPhoto']);
       // foreach ($roles as $role => $permission) {
       //     $this->middleware($role)->only($permission);
       // }
    }
    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request){
        $filter['id_pemda'] = $request->id_pemda;
        $filter['kd_aset'] = $request->kd_aset;
        $filter['kd_aset0'] = $request->kd_aset0;
        $filter['kd_aset1'] = $request->kd_aset1;
        $filter['kd_aset2'] = $request->kd_aset2;
        $filter['kd_aset3'] = $request->kd_aset3;
        $filter['kd_aset4'] = $request->kd_aset4;
        $filter['kd_aset5'] = $request->kd_aset5;
        $filter['no_register'] = $request->no_register;
        $filter['f_from_tgl_pembelian'] = $request->f_from_tgl_pembelian;
        $filter['f_to_tgl_pembelian'] = $request->f_to_tgl_pembelian;
        $filter['f_from_tgl_pembukuan'] = $request->f_from_tgl_pembukuan;
        $filter['f_to_tgl_pembukuan'] = $request->f_to_tgl_pembukuan;
        $filter['bertingkat_tidak'] = $request->bertingkat_tidak;
        $filter['beton_tidak'] = $request->beton_tidak;
        $filter['f_luas_lantai'] = $request->f_luas_lantai;
        $filter['f_status_tanah'] = $request->f_status_tanah;
        $filter['f_lokasi']= $request->f_lokasi;
        $filter['f_no_dokumen'] = $request->f_no_dokumen;
        $filter['asal_usul'] = $request->asal_usul;
        $filter['f_operasi'] = $request->f_operasi;
        $filter['harga'] = $request->harga;

        $bidang = DB::table('ref_organisasi_bidang')->get();
        $rincian_object = DB::table('ref_rek3_108')->where('kd_aset1','3')->get();

        DB::enableQueryLog();
        $gedung = DB::table('ta_kib_c as a')
            ->select('a.idpemda as id','b.nm_pemilik as pemilik', DB::raw("CONCAT(a.kd_aset8,'.',a.kd_aset80,'.',a.kd_aset81,'.',ltrim(to_char(a.kd_aset82, '00')) ,'.',ltrim(to_char(a.kd_aset83, '000')),'.',ltrim(to_char(a.kd_aset84, '000')),'.',ltrim(to_char(a.kd_aset85, '000'))) as kode_aset"), 'a.no_register',
                'a.tgl_pembukuan', 'a.tgl_perolehan', 'a.bertingkat_tidak', 'a.beton_tidak', 'a.luas_lantai',
                'a.lokasi', DB::raw(" to_char( a.dokumen_tanggal, 'DD-MM-YYYY') as dokumen_tanggal"), 'a.dokumen_nomor','a.status_tanah',DB::raw("CONCAT(a.kd_tanah81,'',a.kd_tanah82,'',a.kd_tanah83,'',a.kd_tanah84,'',a.kd_tanah85) as kode_tanah"), DB::raw("CASE WHEN (a.kondisi = '1') THEN 'Baik' WHEN (a.kondisi = '0') THEN 'Rusak' END AS kondisi"),
                'a.harga', 'a.asal_usul', 'a.masa_manfaat', 'a.nilai_sisa', 'a.kd_ka', 
                DB::raw("COALESCE(NULLIF(a.keterangan, NULL), '-') AS keterangan") )
            ->leftjoin('ref_pemilik as b','a.kd_pemilik','=','b.kd_pemilik')
            ->where('a.kd_ka','1')
            ->where('a.kd_hapus','0');

        if(!empty($filter['id_pemda'])){
            $gedung->where('a.idpemda','like', '%'. $filter['id_pemda'] .'%');
        }
        if(!empty($filter['kd_aset']) && !empty($filter['kd_aset0']) && !empty($filter['kd_aset1']) && !empty($filter['kd_aset2']) && !empty($filter['kd_aset3']) && !empty($filter['kd_aset4']) && !empty($filter['kd_aset5'])){
            $gedung->where('a.kd_aset8', $filter['kd_aset']);
            $gedung->where('a.kd_aset80', $filter['kd_aset0']);
            $gedung->where('a.kd_aset81', $filter['kd_aset1']);
            $gedung->where('a.kd_aset82',$filter['kd_aset2']);
            $gedung->where('a.kd_aset83',$filter['kd_aset3']);
            $gedung->where('a.kd_aset84',$filter['kd_aset3']);
            $gedung->where('a.kd_aset85',$filter['kd_aset5']);
        }
        if(!empty($filter['no_register'])) {
            $gedung->where('a.no_register', $filter['no_register']);
        }
        if(!empty($filter['f_from_tgl_pembelian']) && empty($filter['f_to_tgl_pembelian'])) {
            $gedung->whereDate('a.tgl_perolehan', '=', $filter['f_from_tgl_pembelian']);
        } else if (!empty($filter['f_from_tgl_pembelian']) && !empty($filter['f_to_tgl_pembelian'])) {
            $gedung->whereBetween('a.tgl_perolehan', [$filter['f_from_tgl_pembelian'], $filter['f_to_tgl_pembelian']]);
        }
        if(!empty($filter['f_from_tgl_pembukuan']) && empty($filter['f_to_tgl_pembukuan'])) {
            $gedung->whereDate('a.tgl_pembukuan', '=', $filter['f_from_tgl_pembukuan']);
        } else if (!empty($filter['f_from_tgl_pembukuan']) && !empty($filter['f_to_tgl_pembukuan'])) {
            $gedung->whereBetween('a.tgl_pembukuan', [$filter['f_from_tgl_pembukuan'], $filter['f_to_tgl_pembukuan']]);
        }
        if(!empty($filter['bertingkat_tidakk'])) {
            $gedung->where('a.bertingkat_tidak', $filter['bertingkat_tidak']);
        }
        if(!empty($filter['beton_tidak'])) {
            $gedung->where('a.=beton_tidak', $filter['beton_tidak']);
        }
        if(!empty($filter['f_luas_lantai'])) {
            $gedung->where('a.luas_lantai', $filter['f_luas_lantai']);
        }
        if(!empty($filter['f_no_dokumen'])) {
            $gedung->where('a.dokumen_nomor', $filter['f_no_dokumen']);
        }
        if(!empty($filter['f_status_tanah'])) {
            $gedung->where('a.status_tanah', $filter['f_status_tanah']);
        }
        if(!empty($filter['f_lokasi'])) {
            $gedung->where('a.lokasi', $filter['f_lokasi']);
        }
        if(!empty($filter['asal_usul'])) {
            $gedung->where('a.asal_usul', $filter['asal_usul']);
        }
        
        if(!empty($filter['harga']) && !empty($filter['f_operasi'])) {
            switch($filter['f_operasi']){
                case '=':
                    $gedung->where('a.harga', '=', $filter['harga']);
                    break;
                case '>=':
                    $gedung->where('a.harga', '>=', $filter['harga']);
                    break;
                case '<=':
                    $gedung->where('a.harga', '<=', $filter['harga']);
                    break;
            }
        }

        if ($request->ajax()) {
            return DataTables::of($gedung)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div style="min-width:200px; class="btn-group  " role="group" data-placement="top" title="" data-original-title=".btn-xlg">';
                    //  if (hasAccess(Auth::user()->role_id, "Bidang", "View")) {
                        $btn = $btn . '<a href="' . route("getDetailGedung", $row->id) . '"><button data-toggle="tooltip" title="Lihat Foto" class="btn btn-success btn-mini waves-effect waves-light"><i class="icofont icofont-eye"></i></button></a>';
                    //  }
                if (hasAccess(Auth::user()->role_id, "Bidang", "Update")) {
                    $btn = $btn . '<a href="'. route('gedung.edit', $row->id) .' "><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-mini  waves-effect waves-light"><i class="icofont icofont-pencil"></i></button></a>';
                }
                if (hasAccess(Auth::user()->role_id, "Bidang", "Delete")) {
                    $btn = $btn . '<a href="#delModal" data-id="' . $row->id. '" data-toggle="modal"><button data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-mini waves-effect waves-light"><i class="icofont icofont-trash"></i></button></a>';
                }
                $btn = $btn . '</div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.master.kib_c.gedung', compact('filter','bidang','rincian_object'));
    }

    public function add() {
        $kode_pemilik = DB::table('ref_pemilik')->get();
        $kab_kota = DB::table('ref_organisasi_kab_kota')->get();

        $unit = DB::table('ref_organisasi_unit')->get();
        $rincian_object = DB::table('ref_rek3_108')
            ->where('kd_aset1','3')
            ->get();
        return view('admin.master.kib_c.add', compact('kode_pemilik','unit','rincian_object','kab_kota'));
    }

    public function getSubUnit(Request $request){
        if($request->ajax()){
            $ex = explode('_',$request->kode_unit);
            $kode_unit = $ex[0];
            $kode_bidang = $ex[1];
    		$sub_unit = DB::table('ref_organisasi_sub_unit')->where('kode_unit', $kode_unit)->where('kode_bidang',$kode_bidang)->get();
    		$data = view('admin.master.kib_c.ajax_select_sub_unit', compact('sub_unit'))->render();
    		return response()->json(['options'=>$data]);
    	}
    }

    public function getUPB(Request $request){
        if($request->ajax()){
            $ex = explode('_',$request->kode_sub_unit);
                $bidang = $ex[0];
                $kode_unit = $ex[1];
                $kode_sub_unit = $ex[2];
            $upb = DB::table('ref_organisasi_upb')
            ->where('kode_bidang', $bidang)
            ->where('kode_unit',$kode_unit)
            ->where('kode_sub_unit',$kode_sub_unit)
            ->get();
    		$data = view('admin.master.kib_c.ajax_select_upb',compact('upb'))->render();
    		return response()->json(['options'=>$data]);
    	}
    }

    public function getUPBFilterTable(Request $request){
        if($request->ajax()){
            $ex = explode('_', $request->kode_upb);
            $bidang = $ex[0];
            $kode_unit = $ex[1];
            $kode_sub_unit = $ex[2];
            $kode_upb = $ex[3];
            $kib_c = DB::table('ta_kib_c')
                ->select('kd_bidang','kd_unit','kd_sub','idpemda','kd_upb','no_register','tgl_perolehan','harga','keterangan',DB::raw("CONCAT(kd_aset8,'.',kd_aset80,'.',kd_aset81,'.',ltrim(to_char(kd_aset82, '00')) ,'.',ltrim(to_char(kd_aset83, '000')),'.',ltrim(to_char(kd_aset84, '000')),'.',ltrim(to_char(kd_aset85, '000'))) as kode_aset"))
                ->where('kd_bidang', $bidang)
                ->where('kd_unit', $kode_unit)
                ->where('kd_sub', $kode_sub_unit)
                ->where('kd_upb', $kode_upb)
                ->get();
    		$data = view('admin.master.kib_c.ajax_select_table_kib_c',compact('kib_c'))->render();
    		return response()->json(['data'=>$data]);
    	}
    }

    public function getKodePemilik(Request $request) {
        $kode_pemilik = DB::table('ref_pemilik')->where('kd_pemilik',$request->kode_pemilik)->first();
        return $kode_pemilik->nm_pemilik;
    }

    public function save(Request $request){
        // $request()->validate([
        //     'file' => 'required|mimes:pdf,jpg,png|max:2048',
        // ]);

        $ex = explode('_', $request->upb);

        $bidang = $ex[0];
        $unit = $ex[1];
        $sub_unit = $ex[2];
        $upb = $ex[3];

        $kd_pemda = str_pad($bidang, 2, "0", STR_PAD_LEFT)."".str_pad($unit, 2, "0", STR_PAD_LEFT)."".str_pad($sub_unit, 3, "0", STR_PAD_LEFT)."".str_pad($upb,3, "0", STR_PAD_LEFT)."".$request->kab_kota;
        $new_kd_pemda = $this->generateKodePemda($kd_pemda);

        $kib_c['kd_prov'] = "10";
        $kib_c['kd_kab_kota'] = $request->kab_kota;
        $kib_c['idpemda'] = $new_kd_pemda;
        $kib_c['kd_bidang'] = $bidang;
        $kib_c['kd_unit'] = $unit;
        $kib_c['kd_sub'] = $sub_unit;
        $kib_c['kd_upb'] = $upb;
        $kib_c['kd_ka'] ='1';
        $kib_c['kd_hapus'] ='0';
        $kib_c['kd_pemilik'] = $request->kode_pemilik;
        $kib_c['kd_aset8'] = $request->kd_aset;
        $kib_c['kd_aset80'] = $request->kd_aset0;
        $kib_c['kd_aset81'] = $request->kd_aset1;
        $kib_c['kd_aset82'] = $request->kd_aset2;
        $kib_c['kd_aset83'] = $request->kd_aset3;
        $kib_c['kd_aset84'] = $request->kd_aset4;
        $kib_c['kd_aset85'] = $request->kd_aset5;
        $kib_c['kd_data'] = 2;
        $kib_c['no_register'] = $this->getNoRegister($request);
        $kib_c['tgl_perolehan'] = $request->tanggal_pembelian;
        $kib_c['tgl_pembukuan'] = $request->tanggal_pembukuan;
        $kib_c['bertingkat_tidak'] = $request->bertingkat_tidak;
        $kib_c['beton_tidak'] = $request->beton_tidak;
        $kib_c['luas_lantai'] = $request->luas_lantai;
        $kib_c['lokasi'] = $request->lokasi;
        $kib_c['dokumen_tanggal'] = $request->dokumen_tanggal;
        $kib_c['dokumen_nomor'] = $request->dokumen_nomor;
        $kib_c['kode_tanah'] = $request->kode_tanah;
        $kib_c['status_tanah'] = $request->status_tanah;
        $kib_c['kondisi'] = $request->kondisi;
        $kib_c['harga'] = $request->harga;
        $kib_c['asal_usul'] = $request->asal_usul;
        $kib_c['masa_manfaat'] = $request->masa_manfaat;
        $kib_c['nilai_sisa'] = $request->nilai_sisa;
        $kib_c['keterangan'] = $request->keterangan;
        $kib_c['kd_kecamatan'] = $request->kecamatan;
        $kib_c['kd_desa'] = $request->desa;

        DB::table('ta_kib_c')->insert($kib_c);

        if ($request->hasfile('uploadFile')) {
            $path_folder = "/document/kib_c/".$new_kd_pemda;
            $path = public_path().$path_folder;
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            foreach($request->file('uploadFile') as $file) {
                $imageName =  $file->getClientOriginalName();
                $extension = $file->extension();
                $file->move($path, $imageName);
                $this->saveFileKibC($new_kd_pemda, $imageName, $path_folder, $extension);
            }
        }
        $color = "success";
        $msg = "Data Kib-C telah ditambahkan";
        return redirect( route('getGedung') )->with(compact('color', 'msg'));
    }

    public function saveFileKibB($idpemda, $filename, $path, $extension){
        $dokumen['idpemda'] = $idpemda;
        $dokumen['filename'] =  $filename;
        $dokumen['path'] =  $path;
        $dokumen['extension'] = $extension;
        DB::table('ta_kib_c_dokumen')->insert($dokumen);
    }

    public function generateKodePemda($kd){
        $kib_c = DB::table('ta_kib_c')
            ->select(DB::raw("MAX(idpemda) as id_pemda"))
            ->where('idpemda','LIKE','%'.$kd.'%')->first();

        $last_code = ltrim(substr($kib_c->id_pemda,12,6),0);
        $newcode = $kd.''.str_pad(((int)$last_code+1),6, "0", STR_PAD_LEFT);
        return $newcode;
    }

    public function getNoRegister(Request $request) {
        $kd_aset = $request->kd_aset;
        $kd_aset0 = $request->kd_aset0;
        $kd_aset1 = $request->kd_aset1;
        $kd_aset2 = $request->kd_aset2;
        $kd_aset3 = $request->kd_aset3;
        $kd_aset4 = $request->kd_aset4;
        $kd_aset5 = $request->kd_aset5;
        $no_reg = DB::table('ta_kib_c')
        ->select(DB::raw("MAX(no_register) as max_noreg"))
        ->where('kd_aset8', $kd_aset)
        ->where('kd_aset80', $kd_aset0)
        ->where('kd_aset81', $kd_aset1)
        ->where('kd_aset82', $kd_aset2)
        ->where('kd_aset83', $kd_aset3)
        ->where('kd_aset84', $kd_aset4)
        ->where('kd_aset85', $kd_aset5)->first();
        if(!empty($no_reg->max_noreg)){
            $no_reg = ($no_reg->max_noreg+1);
        } else{
            $no_reg = 1;
        }
        return $no_reg;
    }

    public function delete($id) {
        $kib_c['kd_hapus'] = 1;
        DB::table('ta_kib_c')->where('idpemda', $id)->update($kib_c);
        $color = "success";
        $msg = "Berhasil Menghapus Data Gedung dan Bangunan";
        return redirect( route('getGedung') )->with(compact('color', 'msg'));
    }

    public function deletePhoto($id) {
        $id = (int) $id;
        $foto = DB::table('master_jembatan_foto')->where('id_jembatan', $id)->get();
        return view('admin.master.jembatan.deletePhoto', compact('foto'));
    }

    public function detail($id) {
        $gedung = DB::table('ta_kib_c as a')
            ->join('ref_rek5_108 as c' , function($join){
                $join->on('c.kd_aset5','=','a.kd_aset85');
                $join->on('c.kd_aset4','=','a.kd_aset84');
                $join->on('c.kd_aset3','=','a.kd_aset83');
                $join->on('c.kd_aset2','=','a.kd_aset82');
                $join->on('c.kd_aset1','=','a.kd_aset81');
                $join->on('c.kd_aset0','=','a.kd_aset80');
            })
            ->join('ref_pemilik as b','a.kd_pemilik','=','b.kd_pemilik')
            ->select('a.idpemda as id','c.nm_aset5','a.kd_pemilik','b.nm_pemilik as pemilik','a.no_register','a.tgl_perolehan','a.tgl_pembukuan','a.bertingkat_tidak','a.beton_tidak','a.luas_lantai','a.lokasi','a.dokumen_tanggal','a.dokumen_nomor','a.status_tanah','a.keterangan','a.masa_manfaat','a.nilai_sisa',
                DB::raw("CONCAT(a.kd_aset8,'.',a.kd_aset80,'.',a.kd_aset81,'.',ltrim(to_char(a.kd_aset82, '00')) ,'.',ltrim(to_char(a.kd_aset83, '000')),'.',ltrim(to_char(a.kd_aset84, '000')),'.',ltrim(to_char(a.kd_aset85, '000'))) as kode_aset"),
                'a.asal_usul','a.kondisi','a.harga','a.tahun')
            ->where('a.idpemda', $id)
            ->where('a.kd_ka','1')->first();

        $dokumen = DB::table('ta_kib_c_dokumen')->where('idpemda', $id)->get();

        // $profile_picture =  DB::table('ta_kib_c_dokumen')
        //     ->select('filename','path')
        //     ->where('idpemda',$id)->where('extension','jpg')->first();

        return view('admin.master.kib_c.detail', compact('gedung', 'dokumen'));
    }

    public function getSubRincianObyek(Request $request) {
        if($request->ajax()){
            $ex = explode('_',$request->rincian_obyek);
            $kd_aset1 = $ex[0];
            $kd_aset3 = $ex[1];
            $sub_rincian_obyek = DB::table('ref_rek4_108')
                ->where('kd_aset1',$kd_aset1)
                ->where('kd_aset3', $kd_aset3)
                ->get();
    		$data = view('admin.master.kib_c.ajax_select_subrincianobyek',compact('sub_rincian_obyek'))->render();
    		return response()->json(['options'=>$data]);
    	}
    }

    public function download($id_dokumen){
        $dokumen =  DB::table('ta_kib_c_dokumen')
                ->select('filename','path','extension')
                ->where('id_dokumen',$id_dokumen)
                ->first();
        $file = public_path()."/".$dokumen->path."/".$dokumen->filename;
        $header ="";
        if($dokumen->extension == "jpg") {
            $header = "image/jpeg";
        }else if($dokumen->extension == "pdf") {
            $header = "application/pdf";
        }else if($dokumen->extension == "png") {
            $header = "image/jpeg";
        }
        $headers  = array(
            'Content-Type: '.$header
        );
        return Response::download($file, $dokumen->filename, $headers);
    }

    public function getSubSubRincianObyek(Request $request) {
        if($request->ajax()){
            $ex = explode('_',$request->rincian_obyek);
            $kd_aset1 = $ex[0];
            $kd_aset4 = $ex[1];
            $sub_sub_rincian_obyek = DB::table('ref_rek5_108')
               ->where('kd_aset1',$kd_aset1)
               ->where('kd_aset4', $kd_aset4)
                ->get();
    		$data = view('admin.master.kib_c.ajax_select_subsubrincianobyek',compact('sub_sub_rincian_obyek'))->render();
    		return response()->json(['options'=>$data]);
    	}
    }

    public function edit($id){
        $gedung = DB::table('ta_kib_c as a')->where('a.kd_ka','1')
            ->select('a.idpemda as id', 'a.*','c.nm_pemilik as pemilik', 'd.nama_unit', 'e.nama_sub_unit', 'f.nama_upb', DB::raw("CONCAT(a.kd_aset8,'.',a.kd_aset80,'.',a.kd_aset81,'.',ltrim(to_char(a.kd_aset82, '00')) ,'.',ltrim(to_char(a.kd_aset83, '000')),'.',ltrim(to_char(a.kd_aset84, '000')),'.',ltrim(to_char(a.kd_aset85, '000'))) as kode_aset"),
                DB::raw("COALESCE(NULLIF(a.bertingkat_tidak, NULL), '-') AS bertingkat_tidak"), DB::raw("COALESCE(NULLIF(a.beton_tidak, NULL), '-') AS beton_tidak"), DB::raw("COALESCE(NULLIF(a.luas_lantai, NULL), '-') AS luas_lantai"), DB::raw("COALESCE(NULLIF(a.lokasi, NULL), '-') AS lokasi"),
                DB::raw("COALESCE(NULLIF(a.dokumen_tanggal, NULL), '-') AS dokumen_tanggal"), DB::raw("COALESCE(NULLIF(a.dokumen_nomor, NULL), '-') AS dokumen_nomor"), DB::raw("COALESCE(NULLIF(a.status_tanah, NULL), '-') AS status_tanah"),'a.asal_usul', DB::raw("CASE WHEN (a.kondisi = '1') THEN 'Baik' WHEN (a.kondisi = '0') THEN 'Rusak' END AS kondisi"),
                DB::raw("CONCAT('Rp. ', a.harga) as harga"), DB::raw("CONCAT(a.masa_manfaat,' Bulan') as masa_manfaat"), DB::raw("COALESCE(NULLIF(a.nilai_sisa, NULL), 0) AS nilai_sisa"), DB::raw("COALESCE(NULLIF(a.keterangan, NULL), '-') AS keterangan") )
            ->join('ref_pemilik as c','a.kd_pemilik','=','c.kd_pemilik')
            ->join('ref_organisasi_unit as d','d.kode_unit','=','a.kd_unit')
            ->join('ref_organisasi_sub_unit as e','e.kode_sub_unit','=','a.kd_sub')
            ->join('ref_organisasi_upb as f','f.kode_upb','=','a.kd_upb')
            ->where('a.idpemda',$id)->first();

        $dokumen = DB::table('ta_kib_c as a')
            ->select('b.filename','b.id_dokumen')
            ->join('ta_kib_c_dokumen as b','a.idpemda','=','b.idpemda')
            ->where('a.idpemda',$id)->get();

        $kode_pemilik = DB::table('ref_pemilik')->get();
        $kab_kota = DB::table('ref_organisasi_kab_kota')->get();

        $unit = DB::table('ref_organisasi_unit')->get();
        $rincian_object = DB::table('ref_rek3_108')
            ->where('kd_aset1','1')
            ->get();

        $harga0 =  str_replace('Rp', '', $gedung->harga);
        $harga =  floatval(str_replace('.', '', $harga0));
        $kecamatan = DB::table('ref_organisasi_kecamatan')->where('kode_kab_kota',$gedung->kd_kab_kota)->get();
        $desa = DB::table('ref_organisasi_desa')->where('kode_kab_kota',$gedung->kd_kab_kota)->get();

        $sub_rincian_obyek = DB::table('ref_rek4_108')
            ->where('kd_aset1',$gedung->kd_aset81)
            ->where('kd_aset3', $gedung->kd_aset83)
            ->get();

        $sub_sub_rincian_obyek = DB::table('ref_rek5_108')
            ->where('kd_aset1',$gedung->kd_aset81)
            ->where('kd_aset4', $gedung->kd_aset84)
            ->get();

        return view('admin.master.kib_c.edit', compact('gedung','dokumen','unit','rincian_object','kode_pemilik','kab_kota','harga','kecamatan','desa','sub_rincian_obyek','sub_sub_rincian_obyek'));
    }

    public function update(Request $request){

        $id = $request->idpemda;
        $kib_c['kd_pemilik'] = $request->kode_pemilik;
        $kib_c['kd_aset8'] = $request->kd_aset;
        $kib_c['kd_aset80'] = $request->kd_aset0;
        $kib_c['kd_aset81'] = $request->kd_aset1;
        $kib_c['kd_aset82'] = $request->kd_aset2;
        $kib_c['kd_aset83'] = $request->kd_aset3;
        $kib_c['kd_aset84'] = $request->kd_aset4;
        $kib_c['kd_aset85'] = $request->kd_aset5;
        $kib_c['kd_data'] = 2;
        $kib_c['no_register'] = $this->getNoRegister($request);
        $kib_c['tgl_perolehan'] = $request->tanggal_pembelian;
        $kib_c['tgl_pembukuan'] = $request->tanggal_pembukuan;
        $kib_c['bertingkat_tidak'] = $request->bertingkat_tidak;
        $kib_c['beton_tidak'] = $request->beton_tidak;
        $kib_c['luas_lantai'] = $request->luas_lantai;
        $kib_c['lokasi'] = $request->lokasi;
        $kib_c['dokumen_tanggal'] = $request->dokumen_tanggal;
        $kib_c['dokumen_nomor'] = $request->dokumen_nomor;
        $kib_c['kode_tanah'] = $request->kode_tanah;
        $kib_c['status_tanah'] = $request->status_tanah;
        $kib_c['kondisi'] = $request->kondisi;
        $kib_c['harga'] = $request->harga;
        $kib_c['asal_usul'] = $request->asal_usul;
        $kib_c['masa_manfaat'] = $request->masa_manfaat;
        $kib_c['nilai_sisa'] = $request->nilai_sisa;
        $kib_c['keterangan'] = $request->keterangan;
        $kib_c['kd_kab_kota'] = $request->kab_kota;
        $kib_c['kd_kecamatan'] = $request->kecamatan;
        $kib_c['kd_desa'] = $request->desa;

        DB::table('ta_kib_c')->where('idpemda', $id)->update($kib_c);

        if ($request->hasfile('uploadFile')) {
            $path_folder = "/document/kib_c/". $id;
            $path = public_path().$path_folder;
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            foreach($request->file('uploadFile') as $file) {
                $imageName =  $file->getClientOriginalName();
                $file->move($path, $imageName);
                $this->saveFileKibA($id, $imageName, $path_folder);
            }
        }
        $color = "success";
        $msg = " Data Id Pemda " . $id . " telah diperbaharui";
        return redirect(route('getGedung'))->with(compact('color', 'msg'));
    }

    public function getKecamatan(Request $request) {
        if($request->ajax()){
            $kecamatan = DB::table('ref_organisasi_kecamatan')
            ->where('kode_kab_kota',$request->kode_kab_kota)
            ->get();
    		$data = view('admin.master.kib_c.ajax_select_kecamatan',compact('kecamatan'))->render();
    		return response()->json(['options'=>$data]);
        }
    }

    public function getDesa(Request $request) {
        if($request->ajax()){
            $desa = DB::table('ref_organisasi_desa')
            ->where('kode_kecamatan',$request->kode_kecamatan)

            ->get();
    		$data = view('admin.master.kib_c.ajax_select_desa',compact('desa'))->render();
    		return response()->json(['options'=>$data]);
        }
    }
    
}

