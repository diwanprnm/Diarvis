<?php

namespace App\Http\Controllers\MasterData\KodeBarang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\Master\KodeBarang\Jenis;

class JenisController extends Controller
{
    public function index(Request $request){
        $filter['aset_1'] = $request->aset_1;
        $filter['aset_2'] = $request->aset_2;
        $filter['aset_3'] = $request->aset_3;
        $filter['aset_4'] = $request->aset_4;
        $filter['aset_5'] = $request->aset_5;
        $filter['nama_aset_5'] = $request->nama_aset_5;
        $aset1 = DB::table('ref_rek_aset_1')->get();
        $aset2 = DB::table('ref_rek_aset_2')->get();
        $aset3 = DB::table('ref_rek_aset_3')->get();
        $aset4 = DB::table('ref_rek_aset_4')->get();
        $aset5 = DB::table('ref_rek_aset_5')->get();
        return view('admin.master.kode_barang.jenis', compact('filter','aset1','aset2','aset3','aset4','aset5'));
    }

    public function json(Request $request)
    {
        $jenis = DB::table('ref_rek_aset_5 as a')
        ->leftjoin('ref_rek_aset_1 as b', 'b.kode_aset', '=', 'a.kode_aset_1')
        ->leftjoin('ref_rek_aset_2 as c', 'c.kode_aset_2', '=', 'a.kode_aset_2')
        ->leftjoin('ref_rek_aset_3 as d', 'd.kode_aset_3', '=', 'a.kode_aset_3')
        ->leftjoin('ref_rek_aset_4 as e', 'e.kode_aset_4', '=', 'a.kode_aset_4')
        ->select('a.id','b.nama_aset','c.nama_aset_2','d.nama_aset_3','e.nama_aset_4','a.kode_aset_5','a.nama_aset_5');

        if(!empty($request->aset_1)) {
            $jenis->where('b.kode_aset', $request->aset_1);
        }
        if(!empty($request->aset_2)) {
            $jenis->where('c.kode_aset_2', $request->aset_2);
        }
        if(!empty($request->aset_3)) {
            $jenis->where('d.kode_aset_3', $request->aset_3);
        }
        if(!empty($request->aset_4)) {
            $jenis->where('e.kode_aset_4', $request->aset_4);
        }
        if(!empty($request->aset_5)) {
            $jenis->where('a.kode_aset_5', $request->aset_5);
        }
        if(!empty($request->nama_aset_5)) {
            $jenis->where('a.nama_aset_5', 'LIKE', "%{$request->nama_aset_5}%");
        }

        //$unit = Unit::with('ref_bidang');
         return DataTables::of($jenis)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div style="min-width:200px; class="btn-group" role="group" data-placement="top" title="" data-original-title=".btn-xlg">';

                if (hasAccess(Auth::user()->role_id, "Jenis", "Update")) {
                    $btn = $btn . '<a data-toggle="modal" href="#editModal" data-id="'.Crypt::encryptString($row->id).'"><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-mini  waves-effect waves-light"><i class="icofont icofont-pencil"></i></button></a>';
                }

                if (hasAccess(Auth::user()->role_id, "Jenis", "Delete")) {
                    $btn = $btn . '<a href="#delModal" data-id="' . Crypt::encryptString($row->id). '" data-toggle="modal"><button data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-mini waves-effect waves-light"><i class="icofont icofont-trash"></i></button></a>';
                }

                $btn = $btn . '</div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function save(Request $request)
    {
        $jenis['kode_aset_1'] = $request->input_kode_aset_1;
        $jenis['kode_aset_2'] = $request->input_kode_aset_2;
        $jenis['kode_aset_3'] = $request->input_kode_aset_3;
        $jenis['kode_aset_4'] = $request->input_kode_aset_4;
        $jenis['kode_aset_5'] = $request->input_kode_aset_5;
        $jenis['nama_aset_5'] = $request->input_nama_aset_5;
        $jenisModel = new Jenis();
        $result_jenis = $jenisModel->insert($jenis);
        if($result_jenis) {
            $color = "success";
            $msg = "Berhasil Menambah Data jenis";
            return redirect(route('getJenis'))->with(compact('color', 'msg'));
        }
    }

    public function getJenisById($id){
        $decryptId = Crypt::decryptString($id);
        $jenisDt = Jenis::find($decryptId);
        $jenis['kode_aset_1'] = $jenisDt->kode_aset_1;
        $jenis['kode_aset_2'] = $jenisDt->kode_aset_2;
        $jenis['kode_aset_3'] = $jenisDt->kode_aset_3;
        $jenis['kode_aset_4'] = $jenisDt->kode_aset_4;
        $jenis['kode_aset_5'] = $jenisDt->kode_aset_5;
        $jenis['nama_aset_5'] = $jenisDt->nama_aset_5;
        $jenis['id'] = Crypt::encryptString($jenisDt->id);
        return response()->json(["data" => $jenis], 200);
    }

    public function update(Request $request)
    {
        $jenis['kode_aset_1'] = $request->input_kode_aset_1;
        $jenis['kode_aset_2'] = $request->input_kode_aset_2;
        $jenis['kode_aset_3'] = $request->input_kode_aset_3;
        $jenis['kode_aset_4'] = $request->input_kode_aset_4;
        $jenis['kode_aset_5'] = $request->input_kode_aset_5;
        $jenis['nama_aset_5'] = $request->input_nama_aset_5;
        $id = Crypt::decryptString($request->jenis_id);

        $update_unit = DB::table('ref_rek_aset_5')->where('id', $id)->update($jenis);

        if($update_unit) {
            $color = "success";
            $msg = " Jenis ". $request->nama_jenis."  berhasil diperbaharui ";
            return redirect(route('getJenis'))->with(compact('color', 'msg'));
       }
    }

    public function delete($id)
    {
        $decryptid = Crypt::decryptString($id);
        $unit = DB::table('ref_rek_aset_5')->where('id', $decryptid)->delete();
        $color = "success";
        $msg = "Berhasil Menghapus Data Jenis";
        return redirect(route('getJenis'))->with(compact('color', 'msg'));
    }
}
