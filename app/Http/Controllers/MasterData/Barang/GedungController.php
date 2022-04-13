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
        $filter['bidang']=$request->bidang;
        $filter['kode_unit']=$request->kode_unit;
        $filter['nama_unit']=$request->nama_unit;
        $kd_aset['kd_aset'] = $request->kd_aset;
        $kd_aset['kd_aset0'] = $request->kd_aset;
        $kd_aset['kd_aset1'] = $request->kd_aset;
        $kd_aset['kd_aset2'] = $request->kd_aset;
        $kd_aset['kd_aset3'] = $request->kd_aset;
        $kd_aset['kd_aset4'] = $request->kd_aset;
        $kd_aset['kd_aset5'] = $request->kd_aset;
        $text = 'test';
        $nmAset5 = DB::table('ref_rek5_108')
                    ->select(DB::raw("CONCAT(ref_rek5_108.kd_aset,'',ref_rek5_108.kd_aset0,'',ref_rek5_108.kd_aset1,'',ref_rek5_108.kd_aset2,'',ref_rek5_108.kd_aset3,'',ref_rek5_108.kd_aset4,'',ref_rek5_108.kd_aset5) as kode_aset"),'nm_aset5')
                    ->get();
        
        
        // $kab_kota = DB::table(('ref_organisasi_kab_kota'))->get();
        // $provinsi = DB::table(('ref_organisasi_provinsi'))->get();

        return view('admin.master.kib_c.gedung', compact('nmAset5','kd_aset','text'));


    }

    public function json(){
        $gedung=DB::table('ta_fn_kib_c')
                    ->select('id', 'tahun',DB::raw("CONCAT(ta_fn_kib_c.kd_aset,'',ta_fn_kib_c.kd_aset0,'',ta_fn_kib_c.kd_aset1,'',ta_fn_kib_c.kd_aset2,'',ta_fn_kib_c.kd_aset3,'',ta_fn_kib_c.kd_aset4,'',ta_fn_kib_c.kd_aset5) as kode_aset"),
                            'no_register', 'harga','kd_pemilik',DB::raw(" to_char( tgl_perolehan, 'DD-MM-YYYY') as tgl_perolehan"), DB::raw(" to_char( tgl_pembukuan, 'DD-MM-YYYY') as tgl_pembukuan"),'bertingkat_tidak','beton_tidak','luas_lantai', 'lokasi',DB::raw(" to_char( dokumen_tanggal, 'DD-MM-YYYY') as dokumen_tanggal"),'dokumen_nomor','status_tanah',DB::raw("CONCAT(ta_fn_kib_c.kd_tanah1,'',ta_fn_kib_c.kd_tanah2,'',ta_fn_kib_c.kd_tanah3,'',ta_fn_kib_c.kd_tanah4,'',ta_fn_kib_c.kd_tanah5) as kode_tanah")
                            ,'asal_usul','kondisi', 'masa_manfaat', 'nilai_sisa', 'kd_ka',DB::raw(" to_char( tgl_d2, 'DD-MM-YYYY') as tgl_d2"),'tgl_proses')
                            ->where('kd_ka','1');
        return DataTables::of($gedung)
        ->addIndexColumn()
        ->addColumn('action',function($row){
            $btn= '<div style="min-width:200px; class="btn-group  " role="group" data-placement="top" title="" data-original-title=".btn-xlg">';
            //  if (hasAccess(Auth::user()->role_id, "Bidang", "View")) {
                $btn = $btn . '<a href="' . route("getDetailKIBC", $row->id) . '"><button data-toggle="tooltip" title="Lihat Foto" class="btn btn-success btn-mini waves-effect waves-light"><i class="icofont icofont-eye"></i></button></a>';
                if (hasAccess(Auth::user()->role_id, "Bidang", "Update")) {
                    $btn = $btn . '<a href=" "><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-mini  waves-effect waves-light"><i class="icofont icofont-pencil"></i></button></a>';
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
    
    public function detail($id){
        $gedung = DB::table('ta_fn_kib_c as a')->where('a.kd_ka','1')
        ->join('ref_rek5_108 as b' , function($join)
        {
            $join->on('b.kd_aset5', '=', 'a.kd_aset5');
            $join->on('b.kd_aset4','=','a.kd_aset4');
            $join->on('b.kd_aset3','=','a.kd_aset3');
            $join->on('b.kd_aset2','=','a.kd_aset2');
            $join->on('b.kd_aset1','=','a.kd_aset1');
            $join->on('b.kd_aset0','=','a.kd_aset0');
            $join->on('b.kd_aset','=','a.kd_aset');
        })
            ->select('a.id','a.tahun',DB::raw("CONCAT(a.kd_aset,'',a.kd_aset0,'',a.kd_aset1,'',a.kd_aset2,'',a.kd_aset3,'',a.kd_aset4,'',a.kd_aset5) as kode_aset"), 
            'a.no_register', 'a.harga','a.kd_pemilik',DB::raw(" to_char( a.tgl_perolehan, 'DD-MM-YYYY') as tgl_perolehan"), DB::raw(" to_char( a.tgl_pembukuan, 'DD-MM-YYYY') as tgl_pembukuan"),'a.bertingkat_tidak','a.beton_tidak','a.luas_lantai', 'a.lokasi',DB::raw(" to_char( a.dokumen_tanggal, 'DD-MM-YYYY') as dokumen_tanggal"),'a.dokumen_nomor','a.status_tanah',DB::raw("CONCAT(a.kd_tanah1,'',a.kd_tanah2,'',a.kd_tanah3,'',a.kd_tanah4,'',a.kd_tanah5) as kode_tanah")
            ,'a.asal_usul','a.kondisi', 'a.masa_manfaat', 'a.nilai_sisa', 'a.kd_ka',DB::raw(" to_char( a.tgl_d2, 'DD-MM-YYYY') as tgl_d2"),'a.tgl_proses','b.nm_aset5')
            ->where('id',$id)->first(); 
            return view('admin.master.kib_c.detail', compact('gedung'));

   
    }

    public function getSubUnit(Request $request){
        if($request->ajax()){
            $ex = explode('_',$request->kode_unit);
            $kode_unit = $ex[0];
            $kode_bidang = $ex[1];
    		$sub_unit = DB::table('ref_organisasi_sub_unit')->where('kode_unit', $kode_unit)->where('kode_bidang',$kode_bidang)->get();
    		$data = view('admin.master.kib_c.ajax_select_sub_unit',compact('sub_unit'))->render();
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

    public function getKodePemilik(Request $request) { 
        $kode_pemilik = DB::table('ref_pemilik')->where('kd_pemilik',$request->kode_pemilik)->first();
        return $kode_pemilik->nm_pemilik;
    }

    public function add()
    { 

        $kode_pemilik = DB::table('ref_pemilik')->get();

        $unit = DB::table('ref_organisasi_unit')->get(); 
        $rincian_object = DB::table('ref_rek3_108')
                            ->where('kd_aset1','3')
                            ->get(); 

        return view('admin.master.kib_c.add', compact('kode_pemilik','unit','rincian_object'));
    }
}

