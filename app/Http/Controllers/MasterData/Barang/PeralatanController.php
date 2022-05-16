<?php

namespace App\Http\Controllers\MasterData\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\DataTables;

class PeralatanController extends Controller {
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
        $filter['nomor_pabrik'] = $request->nomor_pabrik;
        $filter['nomor_rangka'] = $request->nomor_rangka;
        $filter['kondisi'] = $request->kondisi;
        $filter['merk'] = $request->merk;
        $filter['tipe'] = $request->tipe;
        $filter['cc'] = $request->cc;
        $filter['bahan'] = $request->bahan;
        $filter['asal_usul'] = $request->asal_usul;
        $filter['nomor_mesin'] = $request->nomor_mesin;
        $filter['nomor_polisi'] = $request->nomor_polisi;
        $filter['nomor_bpkb'] = $request->nomor_bpkb;
        $filter['f_operasi'] = $request->f_operasi;
        $filter['harga'] = $request->harga;

        $bidang = DB::table('ref_organisasi_bidang')->get();
        $rincian_object = DB::table('ref_rek3_108')->where('kd_aset1','2')->get();

        DB::enableQueryLog();
        $peralatan = DB::table('ta_kib_b as a')
            ->select('a.idpemda as id','b.nm_pemilik as pemilik', DB::raw("CONCAT(a.kd_aset8,'.',a.kd_aset80,'.',a.kd_aset81,'.',ltrim(to_char(a.kd_aset82, '00')) ,'.',ltrim(to_char(a.kd_aset83, '000')),'.',ltrim(to_char(a.kd_aset84, '000')),'.',ltrim(to_char(a.kd_aset85, '000'))) as kode_aset"), 'a.no_register',
                'a.tgl_pembukuan', 'a.tgl_perolehan', 'a.merk', DB::raw("COALESCE(NULLIF(a.type, NULL), '-') AS type"), DB::raw("COALESCE(NULLIF(a.cc, NULL), '-') AS cc"), 'a.bahan', DB::raw("COALESCE(NULLIF(a.nomor_pabrik, NULL), '-') AS nomor_pabrik"), DB::raw("COALESCE(NULLIF(a.nomor_rangka, NULL), '-') AS nomor_rangka"),
                DB::raw("COALESCE(NULLIF(a.nomor_mesin, NULL), '-') AS nomor_mesin"), DB::raw("COALESCE(NULLIF(a.nomor_polisi, NULL), '-') AS nomor_polisi"), DB::raw("COALESCE(NULLIF(a.nomor_bpkb, NULL), '-') AS nomor_bpkb"),'a.asal_usul', DB::raw("CASE WHEN (a.kondisi = '1') THEN 'Baik' WHEN (a.kondisi = '0') THEN 'Rusak' END AS kondisi"),
                DB::raw("CONCAT('Rp. ', a.harga) as harga"), DB::raw("CONCAT(a.masa_manfaat,' Bulan') as masa_manfaat"), DB::raw("COALESCE(NULLIF(a.nilai_sisa, NULL), 0) AS nilai_sisa"), DB::raw("COALESCE(NULLIF(a.keterangan, NULL), '-') AS keterangan") )
            ->join('ref_pemilik as b','a.kd_pemilik','=','b.kd_pemilik')
            ->where('a.kd_ka','1')
            ->where('a.kd_hapus','0');

        if(!empty($filter['id_pemda'])){
            $peralatan->where('a.idpemda','like', '%'. $filter['id_pemda'] .'%');
        }
        if(!empty($filter['kd_aset']) && !empty($filter['kd_aset0']) && !empty($filter['kd_aset1']) && !empty($filter['kd_aset2']) && !empty($filter['kd_aset3']) && !empty($filter['kd_aset4']) && !empty($filter['kd_aset5'])){
            $peralatan->where('a.kd_aset8', $filter['kd_aset']);
            $peralatan->where('a.kd_aset80', $filter['kd_aset0']);
            $peralatan->where('a.kd_aset81', $filter['kd_aset1']);
            $peralatan->where('a.kd_aset82',$filter['kd_aset2']);
            $peralatan->where('a.kd_aset83',$filter['kd_aset3']);
            $peralatan->where('a.kd_aset84',$filter['kd_aset3']);
            $peralatan->where('a.kd_aset85',$filter['kd_aset5']);
        }
        if(!empty($filter['no_register'])) {
            $peralatan->where('a.no_register', $filter['no_register']);
        }
        if(!empty($filter['f_from_tgl_pembelian']) && empty($filter['f_to_tgl_pembelian'])) {
            $peralatan->whereDate('a.tgl_perolehan', '=', $filter['f_from_tgl_pembelian']);
        } else if (!empty($filter['f_from_tgl_pembelian']) && !empty($filter['f_to_tgl_pembelian'])) {
            $peralatan->whereBetween('a.tgl_perolehan', [$filter['f_from_tgl_pembelian'], $filter['f_to_tgl_pembelian']]);
        }
        if(!empty($filter['f_from_tgl_pembukuan']) && empty($filter['f_to_tgl_pembukuan'])) {
            $peralatan->whereDate('a.tgl_pembukuan', '=', $filter['f_from_tgl_pembukuan']);
        } else if (!empty($filter['f_from_tgl_pembukuan']) && !empty($filter['f_to_tgl_pembukuan'])) {
            $peralatan->whereBetween('a.tgl_pembukuan', [$filter['f_from_tgl_pembukuan'], $filter['f_to_tgl_pembukuan']]);
        }
        if(!empty($filter['nomor_pabrik'])) {
            $peralatan->where('a.nomor_pabrik', $filter['nomor_pabrik']);
        }
        if(!empty($filter['nomor_rangka'])) {
            $peralatan->where('a.nomor_rangka', $filter['nomor_rangka']);
        }
        if(!empty($filter['kondisi'])) {
            $peralatan->where('a.kondisi', $filter['kondisi']);
        }
        if(!empty($filter['merk'])) {
            $peralatan->where('a.merk', $filter['merk']);
        }
        if(!empty($filter['tipe'])) {
            $peralatan->where('a.type', $filter['tipe']);
        }
        if(!empty($filter['cc'])) {
            $peralatan->where('a.cc', $filter['cc']);
        }
        if(!empty($filter['bahan'])) {
            $peralatan->where('a.bahan', $filter['bahan']);
        }
        if(!empty($filter['nomor_mesin'])) {
            $peralatan->where('a.nomor_mesin', $filter['nomor_mesin']);
        }
        if(!empty($filter['asal_usul'])) {
            $peralatan->where('a.asal_usul', $filter['asal_usul']);
        }
        if(!empty($filter['nomor_polisi'])) {
            $peralatan->where('a.nomor_polisi', $filter['nomor_polisi']);
        }
        if(!empty($filter['nomor_bpkb'])) {
            $peralatan->where('a.nomor_bpkb', $filter['nomor_bpkb']);
        }
        if(!empty($filter['harga']) && !empty($filter['f_operasi'])) {
            switch($filter['f_operasi']){
                case '=':
                    $peralatan->where('a.harga', '=', $filter['harga']);
                    break;
                case '>=':
                    $peralatan->where('a.harga', '>=', $filter['harga']);
                    break;
                case '<=':
                    $peralatan->where('a.harga', '<=', $filter['harga']);
                    break;
            }
        }

        if ($request->ajax()) {
            return DataTables::of($peralatan)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div style="min-width:200px; class="btn-group  " role="group" data-placement="top" title="" data-original-title=".btn-xlg">';
                    //  if (hasAccess(Auth::user()->role_id, "Bidang", "View")) {
                        $btn = $btn . '<a href="' . route("getDetailPeralatan", $row->id) . '"><button data-toggle="tooltip" title="Lihat Foto" class="btn btn-success btn-mini waves-effect waves-light"><i class="icofont icofont-eye"></i></button></a>';
                    //  }
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

        return view('admin.master.kib_b.peralatan', compact('filter','bidang','rincian_object'));
    }

    public function add()
    {
        $kode_pemilik = DB::table('ref_pemilik')->get();
        $kab_kota = DB::table('ref_organisasi_kab_kota')->get();

        $unit = DB::table('ref_organisasi_unit')->get();
        $rincian_object = DB::table('ref_rek3_108')
            ->where('kd_aset1','1')
            ->get();
        return view('admin.master.kib_b.add', compact('kode_pemilik','unit','rincian_object','kab_kota'));
    }

    public function delete($id)
    {
        $kib_b['kd_hapus'] = 1;
        DB::table('ta_fn_kib_b')->where('idpemda', $id)->update($kib_b);
        $color = "success";
        $msg = "Berhasil Menghapus Data Peralatan Dan Mesin";
        return redirect( route('getPeralatan') )->with(compact('color', 'msg'));
    }

    public function detail($id) {
        $peralatan = DB::table('ta_fn_kib_b as a')->where('a.kd_ka','1')
        ->select('a.idpemda as id','a.kd_pemilik','b.nm_pemilik as pemilik','a.no_register','a.tgl_perolehan','a.tgl_pembukuan','a.merk','a.type','a.cc','a.bahan','a.nomor_rangka','a.nomor_mesin','a.nomor_polisi','a.nomor_bpkb','a.asal_usul','a.kondisi','a.harga','a.tahun')
        ->join('ref_pemilik as b','a.kd_pemilik','=','b.kd_pemilik')
        ->where('a.idpemda', $id)->first();

        $dokumen = DB::table('ta_fn_kib_b as a')
                ->select('b.filename','b.id_dokumen')
                ->join('ta_kib_b_dokumen as b','a.idpemda','=','b.idpemda')
                ->where('a.idpemda',$id)->get();

        $profile_picture =  DB::table('ta_kib_b_dokumen')
        ->select('filename','path')
        ->where('idpemda',$id)->where('extension','jpg')->first();
        return view('admin.master.kib_b.detail', compact('peralatan','dokumen','profile_picture'));
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
    		$data = view('admin.master.kib_b.ajax_select_subrincianobyek',compact('sub_rincian_obyek'))->render();
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
    		$data = view('admin.master.kib_b.ajax_select_subsubrincianobyek',compact('sub_sub_rincian_obyek'))->render();
    		return response()->json(['options'=>$data]);
    	}
    }

}
