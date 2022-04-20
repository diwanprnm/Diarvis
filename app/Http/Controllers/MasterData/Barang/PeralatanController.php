<?php

namespace App\Http\Controllers\MasterData\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\DataTables;

class PeralatanController extends Controller
{

    public function index(Request $request){
        $filter['bidang'] = $request->bidang;
        $filter['kode_unit'] = $request->kode_unit;
        $filter['nama_unit'] = $request->nama_unit;
        $bidang = DB::table('ref_organisasi_bidang')->get();
        return view('admin.master.kib_b.peralatan', compact('bidang','filter'));
    }

    public function json(){
        $peralatan = DB::table('ta_fn_kib_b as a')
            ->join('ref_organisasi_provinsi as b','a.kd_prov','=','b.kode_provinsi')
            ->select('a.idpemda as id','a.tahun','b.nama_provinsi')
            ->where('a.kd_ka','1');
        return DataTables::of($peralatan)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div style="min-width:200px; class="btn-group  " role="group" data-placement="top" title="" data-original-title=".btn-xlg">';
                   //  if (hasAccess(Auth::user()->role_id, "Bidang", "View")) {
                    $btn = $btn . '<a href="' . route("getDetailKIBA", $row->id) . '"><button data-toggle="tooltip" title="Lihat Foto" class="btn btn-success btn-mini waves-effect waves-light"><i class="icofont icofont-eye"></i></button></a>';
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

}
