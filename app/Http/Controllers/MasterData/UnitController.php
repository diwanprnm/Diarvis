<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Model\Master\Unit;
use App\Model\Master\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\DataTables;
use Illuminate\Support\Facades\Crypt;
class UnitController extends Controller
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
    public function index(Request $request){
        $filter['bidang'] = $request->bidang;
        $filter['kode_unit'] = $request->kode_unit;
        $filter['nama_unit'] = $request->nama_unit;
        $bidang = DB::table('ref_organisasi_bidang')->get();   
        return view('admin.master.unit_organisasi.unit', compact('bidang','filter'));
    }
    

    public function json(Request $request)
    {
        $unit = DB::table('ref_organisasi_unit as a')
        ->leftjoin('ref_organisasi_bidang as b', 'b.kode_bidang', '=', 'a.kode_bidang')
        ->leftjoin('ref_organisasi_provinsi as c', 'c.kode_provinsi', '=', 'a.kode_provinsi') 
        ->leftjoin('ref_organisasi_kab_kota as d', 'd.kode_provinsi', '=', 'a.kode_provinsi')
         ->select('a.id','c.nama_provinsi','d.nama_kab_kota','b.nama_bidang','a.kode_unit','a.nama_unit');
         
             if(!empty($request->bidang)) { 
            $unit->where('a.kode_bidang',$request->bidang);
             } 
             if(!empty($request->kode_unit)) { 
            $unit->where('a.kode_unit',$request->kode_unit);
             }
             if(!empty($request->nama_unit)) { 
            $unit->where('a.nama_unit',$request->nama_unit);
             }
        
          
          
        //$unit = Unit::with('ref_bidang');
         return DataTables::of($unit) 
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div style="min-width:200px; class="btn-group  " role="group" data-placement="top" title="" data-original-title=".btn-xlg">';

                if (hasAccess(Auth::user()->role_id, "Unit", "Update")) {
                    $btn = $btn . '<a data-toggle="modal" href="#editModal" data-id="'.Crypt::encryptString($row->id).'"><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-mini  waves-effect waves-light"><i class="icofont icofont-pencil"></i></button></a>';
                }

                if (hasAccess(Auth::user()->role_id, "Unit", "Delete")) {
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

        $unit['kode_provinsi'] = 1;
        $unit['kode_kab_kota'] = 1;
        $unit['kode_bidang'] = $request->bidang;
        $unit['kode_unit'] = $request->kode_unit;
        $unit['nama_unit'] = $request->nama_unit; 
        $unitModel = new Unit();
        $result_unit = $unitModel->insert($unit);
      
         if($result_unit) { 

        $color = "success";
        $msg = "Berhasil Menambah Data Unit";
        return redirect(route('getUnit'))->with(compact('color', 'msg'));
         }
    }

    public function getUnitById($id){
        $decryptId = Crypt::decryptString($id);
        $unitDt = Unit::find($decryptId);
        $unit['kode_bidang'] =  $unitDt->kode_bidang;
        $unit['kode_unit'] = $unitDt->kode_unit;
        $unit['nama_unit'] = $unitDt->nama_unit;
        $unit['id'] = Crypt::encryptString($unitDt->id);
        return response()->json(["data" => $unit], 200); 
    }

    public function update(Request $request)
    { 
        $unit['kode_bidang'] = $request->bidang;
        $unit['kode_unit'] = $request->kode_unit;
        $unit['nama_unit'] = $request->nama_unit; 
        $id = Crypt::decryptString($request->unit_id);
       
        $update_unit = DB::table('ref_organisasi_unit')->where('id', $id)->update($unit);
 
        if($update_unit) { 
            $color = "success";
            $msg = " Unit ".$request->nama_unit."  berhasil diperbaharui ";
            return redirect(route('getUnit'))->with(compact('color', 'msg'));
       }
    }
         
    public function delete($id)
    {
        $decryptid = Crypt::decryptString($id); 
        $unit = DB::table('ref_organisasi_unit')->where('id', $decryptid)->delete(); 
        $color = "success";
        $msg = "Berhasil Menghapus Data Unit";
        return redirect(route('getUnit'))->with(compact('color', 'msg'));
    }



  

    
}
