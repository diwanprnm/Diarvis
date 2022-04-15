<?php

namespace App\Http\Controllers\MasterData\Barang;

use App\Http\Controllers\Controller;
use App\Model\Master\Barang\Jalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\DataTables;

class JalanController extends Controller
{
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function index(Request $request)
    {
        $filter['bidang'] = $request->bidang;
        $filter['kode_unit'] = $request->kode_unit;
        $filter['nama_unit'] = $request->nama_unit;
        $bidang = DB::table('ref_organisasi_bidang')->get();   

        return view('admin.master.kib_d.jalan', compact('bidang','filter'));
    
    }

    public function json()
    {
        $jalan = DB::table('ta_fn_kib_d')
                    ->select('id','tahun',DB::raw("CONCAT(ta_fn_kib_d.kd_aset,'',ta_fn_kib_d.kd_aset0,'',ta_fn_kib_d.kd_aset1,'',ta_fn_kib_d.kd_aset2,'',ta_fn_kib_d.kd_aset3,'',ta_fn_kib_d.kd_aset4,'',ta_fn_kib_d.kd_aset5) as kode_aset"), 
                       'no_register', 'harga', 'luas', 'kd_pemilik',DB::raw(" to_char( tgl_perolehan, 'DD-MM-YYYY') as tgl_perolehan"), 'tgl_pembukuan', 'lokasi', 'asal_usul', 'masa_manfaat', 'nilai_sisa')
                        ->where('kd_ka','1');
         return DataTables::of($jalan)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div style="min-width:200px; class="btn-group  " role="group" data-placement="top" title="" data-original-title=".btn-xlg">';
                   //  if (hasAccess(Auth::user()->role_id, "Bidang", "View")) {
                    $btn = $btn . '<a href="' . route("getDetailKIBD", $row->id) . '"><button data-toggle="tooltip" title="Lihat Foto" class="btn btn-success btn-mini waves-effect waves-light"><i class="icofont icofont-eye"></i></button></a>';
             //   }
                if (hasAccess(Auth::user()->role_id, "Bidang", "Update")) {
                    $btn = $btn . '<a href="'.route("jalan.edit", $row->id).'"><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-mini  waves-effect waves-light"><i class="icofont icofont-pencil"></i></button></a>';
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

    public function detail($id) {
        $jalan = DB::table('ta_fn_kib_d as a')->where('a.kd_ka','1')
        ->join('ref_rek5_108 as b' , function($join)
                         {
                             $join->on('b.kd_aset5', '=', 'a.kd_aset5');
                             $join->on('b.kd_aset4','=','a.kd_aset4');
                             $join->on('b.kd_aset3','=','a.kd_aset3');
                             $join->on('b.kd_aset2','=','a.kd_aset2');
                             $join->on('b.kd_aset1','=','a.kd_aset1');
                             $join->on('b.kd_aset0','=','a.kd_aset0');
                          })
        // ->join('ta_fn_kib_a as c' , function($join)
        //                  {
        //                      $join->on('c.kd_tanah5', '=', 'a.kd_aset5');
        //                      $join->on('c.kd_tanah4','=','a.kd_aset4');
        //                      $join->on('c.kd_tanah3','=','a.kd_aset3');
        //                      $join->on('c.kd_tanah2','=','a.kd_aset2');
        //                      $join->on('c.kd_tanah1','=','a.kd_aset1');
        //                      $join->on('c.kd_tanah','=','a.kd_aset0');
        //                   })
        ->select('a.id','b.nm_aset5','a.tahun',DB::raw("CONCAT(a.kd_aset,'',a.kd_aset0,'',a.kd_aset1,'',a.kd_aset2,'',a.kd_aset3,'',a.kd_aset4,'',a.kd_aset5) as kode_aset"), 
           'a.no_register', 'a.harga', 'a.luas', 'a.kd_pemilik',DB::raw(" to_char( a.tgl_perolehan, 'DD-MM-YYYY') as tgl_perolehan"), 'a.tgl_pembukuan', 'a.lokasi',  'a.asal_usul', 'a.kd_ka', 'a.tgl_d2', 'a.tgl_proses', 'a.status_tanah', 'a.masa_manfaat', 'a.nilai_sisa'
            // DB::raw("CONCAT(c.kd_tanah,'',c.kd_tanah1,'',c.kd_tanah2,'',c.kd_tanah3,'',c.kd_tanah4,'',c.kd_tanah5) as kode_tanah"), 'c.status_tanah'
            )
            ->where('id',$id)->first(); 
            return view('admin.master.kib_d.detail', compact('jalan'));
    }

    public function save(Request $request)
    {
        $jalan['tahun'] = $request->tahun;
        $jalan['idpemda'] = '05010010014000691';
        $jalan['kd_unit'] = $request->kode_unit;
        $jalan['kd_sub'] = $request->kode_sub_unit;
        $jalan['kd_upb'] = $request->kode_upb;
        $jalan['kd_bidang'] = 5;
        $jalan['kd_ka'] = 1;
        $jalan['tgl_d2'] = $request->tgl_perolehan;
        $jalan['kd_aset'] = $request->kd_aset;
        $jalan['kd_aset0'] = $request->kd_aset0;
        $jalan['kd_aset1'] = $request->kd_aset1;
        $jalan['kd_aset2'] = $request->kd_aset2;
        $jalan['kd_aset3'] = $request->kd_aset3;
        $jalan['kd_aset4'] = $request->kd_aset4;
        $jalan['kd_aset5'] = $request->kd_aset5;
        $jalan['no_register'] = $request->no_register;
        $jalan['kd_pemilik'] = $request->kode_pemilik;
        $jalan['tgl_perolehan'] = $request->tanggal_pembelian;
        $jalan['tgl_pembukuan'] = $request->tanggal_pembukuan;
        $jalan['luas'] = $request->luas;
        $jalan['lokasi'] = $request->alamat;
        $jalan['dokumen_tanggal'] = $request->tanggal_dokumen;
        $jalan['dokumen_nomor'] = $request->no_dokumen;
        $jalan['asal_usul'] = $request->asal_usul;
        $jalan['kondisi'] = $request->kondisi;
        $jalan['harga'] = $request->harga;
        $jalan['status_tanah'] = $request->status_tanah;
        $jalan['kode_tanah'] = $request->kd_tanah;
        $jalan['kd_tanah1'] = $request->kd_tanah1;
        $jalan['kd_tanah2'] = $request->kd_tanah2;
        $jalan['kd_tanah3'] = $request->kd_tanah3;
        $jalan['kd_tanah4'] = $request->kd_tanah4;
        $jalan['kd_tanah5'] = $request->kd_tanah5;
        $jalan['masa_manfaat'] = $request->masa_manfaat;
        $jalan['nilai_sisa'] = $request->nilai_sisa;
        $jalan['kd_kab_kota'] = 1;
        $jalan['kd_prov'] = 10;
        
        $jalanModel = new Jalan();
        $result_jalan = $jalanModel->insert($jalan);
        if($result_jalan) {
            $color = "success";
            $msg = "Berhasil Menambah Data Jalan Irigasi dan Lainnya";
            return redirect(route('getJalan'))->with(compact('color', 'msg'));
        }
    }


    public function edit($id)
    {
        $jalan = DB::table('ta_fn_kib_d as a')->where('a.kd_ka','1')
        ->join('ref_rek5_108 as b' , function($join)
                         {
                             $join->on('b.kd_aset5', '=', 'a.kd_aset5');
                             $join->on('b.kd_aset4','=','a.kd_aset4');
                             $join->on('b.kd_aset3','=','a.kd_aset3');
                             $join->on('b.kd_aset2','=','a.kd_aset2');
                             $join->on('b.kd_aset1','=','a.kd_aset1');
                             $join->on('b.kd_aset0','=','a.kd_aset0');
                          })
        ->select('a.id','b.nm_aset5','a.tahun',DB::raw("CONCAT(a.kd_aset,'',a.kd_aset0,'',a.kd_aset1,'',a.kd_aset2,'',a.kd_aset3,'',a.kd_aset4,'',a.kd_aset5) as kode_aset"), 
           'a.no_register', 'a.harga', 'a.luas', 'a.kd_pemilik',DB::raw(" to_char( a.tgl_perolehan, 'DD-MM-YYYY') as tgl_perolehan"), 'a.tgl_pembukuan', 'a.lokasi',  'a.asal_usul', 'a.kd_ka', 'a.tgl_d2', 'a.tgl_proses', 'a.status_tanah', 'a.masa_manfaat', 'a.nilai_sisa'
            )
            ->where('id',$id)->first(); 
            return view('admin.master.kib_d.edit', compact('jalan'));
        
    }


    public function getSubUnit(Request $request){
        if($request->ajax()){
            $ex = explode('_',$request->kode_unit);
            $kode_unit = $ex[0];
            $kode_bidang = $ex[1];
    		$sub_unit = DB::table('ref_organisasi_sub_unit')->where('kode_unit', $kode_unit)->where('kode_bidang',$kode_bidang)->get();
    		$data = view('admin.master.kib_a.ajax_select_sub_unit',compact('sub_unit'))->render();
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
    		$data = view('admin.master.kib_a.ajax_select_upb',compact('upb'))->render();
    		return response()->json(['options'=>$data]);
    	}
    }

    public function getUPBFilterTable(Request $request){
        if($request->ajax()){
            $ex = explode('_',$request->kode_upb);
            $bidang = $ex[0];
            $kode_unit = $ex[1]; 
            $kode_sub_unit = $ex[2];
            $kode_upb = $ex[3];
            $kib_a = DB::table('ta_kib_a')
            ->where('kd_bidang', $bidang)
            ->where('kd_unit',$kode_unit)
            ->where('kd_sub',$kode_sub_unit)
            ->where('kd_upb',$kode_upb)
            ->get();
    		$data = view('admin.master.kib_a.ajax_select_table_kiba',compact('kib_a'))->render();
    		return response()->json(['data'=>$data]);
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
    		$data = view('admin.master.kib_a.ajax_select_subrincianobyek',compact('sub_rincian_obyek'))->render();
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
    		$data = view('admin.master.kib_a.ajax_select_subsubrincianobyek',compact('sub_sub_rincian_obyek'))->render();
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
                            ->where('kd_aset1','1')
                            ->get(); 

        return view('admin.master.kib_d.add', compact('kode_pemilik','unit','rincian_object'));
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

        return redirect(route('editPhotoJembatan',$request->id))->with(compact('color', 'msg'));
    }

    public function delete($id)
    {
        $jembatan = DB::table('master_jembatan');
        $old = $jembatan->where('id', $id);
        $old->first()->foto ?? Storage::delete('public/' . $old->first()->foto);
        $old->delete();

        $foto = DB::table('master_jembatan_foto')->where('id_jembatan', $id)->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data Jembatan";
        return redirect(route('getMasterJembatan'))->with(compact('color', 'msg'));
    }

    public function delPhoto($id)
    {
        $foto = DB::table('master_jembatan_foto')->where('id', $id)->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Foto Jembatan";
        return redirect(route('editPhotoJembatan',$id))->with(compact('color', 'msg'));
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
