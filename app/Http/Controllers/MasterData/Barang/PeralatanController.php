<?php

namespace App\Http\Controllers\MasterData\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\DataTables;

class PeralatanController extends Controller {
    public function index(Request $request){
        $filter['id_pemda_filter'] = $request->id_pemda_filter;
        $filter['no_register_filter'] = $request->no_register_filter;
        return view('admin.master.kib_b.peralatan', compact('filter'));
    }

    public function json(Request $request){
        $peralatan = DB::table('ta_fn_kib_b as a')
            ->select('a.idpemda as id','b.nm_pemilik as pemilik','a.no_register','a.tgl_perolehan','a.merk','a.type','a.cc','a.bahan','a.nomor_rangka','a.nomor_mesin','a.nomor_polisi','a.nomor_bpkb','a.asal_usul','a.kondisi','a.harga')
            ->join('ref_pemilik as b','a.kd_pemilik','=','b.kd_pemilik')
            ->where('a.kd_ka','1')
            ->where('a.kd_hapus','0');

            if(!empty($request->id_pemda_filter)) {
                $peralatan->where('a.idpemda', 'like', '%' . $request->id_pemda_filter. '%');
            }
            if(!empty($request->no_register_filter)) {
                $peralatan->where('a.no_register', $request->no_register_filter);
            }

        return DataTables::of($peralatan)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div style="min-width:200px; class="btn-group  " role="group" data-placement="top" title="" data-original-title=".btn-xlg">';
                   //  if (hasAccess(Auth::user()->role_id, "Bidang", "View")) {
                    $btn = $btn . '<a href="' . route("getDetailPeralatan", $row->id) . '"><button data-toggle="tooltip" title="Lihat Foto" class="btn btn-success btn-mini waves-effect waves-light"><i class="icofont icofont-eye"></i></button></a>';
             //   }
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

}
