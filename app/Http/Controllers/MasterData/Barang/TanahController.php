<?php

namespace App\Http\Controllers\MasterData\Barang;

use App\Http\Controllers\Controller;
use App\Model\Master\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\DataTables;

class TanahController extends Controller
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
    public function index()
    {
        //$tanah = DB::table('ta_fn_kib_a')->where('kd_ka','1');
        //$bidang = $bidang->get();
        return view('admin.master.barang.tanah');
    }

    public function json()
    {
        $tanah = DB::table('ta_fn_kib_a')->where('kd_ka','1')
                    ->select('id','tahun',DB::raw("CONCAT(ta_fn_kib_a.kd_aset,'',ta_fn_kib_a.kd_aset0,'',ta_fn_kib_a.kd_aset1,'',ta_fn_kib_a.kd_aset2,'',ta_fn_kib_a.kd_aset3,'',ta_fn_kib_a.kd_aset4,'',ta_fn_kib_a.kd_aset5) as kode_aset"), 
                       'no_register', 'harga', 'luas_m2', 'tgl_dok', 'no_dok', 'kd_pemilik',DB::raw(" to_char( tgl_perolehan, 'DD-MM-YYYY') as tgl_perolehan"), 'tgl_pembukuan', 'alamat', 'hak_tanah', 'sertifikat_tanggal', 
                        'sertifikat_nomor', 'penggunaan', 'asal_usul', 'kd_ka', 'tgl_d2', 'tgl_proses');
         return DataTables::of($tanah)
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

    public function detail($id) {
        $tanah = DB::table('ta_fn_kib_a as a')->where('a.kd_ka','1')
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
           'a.no_register', 'a.harga', 'a.luas_m2', 'a.tgl_dok', 'a.no_dok', 'a.kd_pemilik',DB::raw(" to_char( a.tgl_perolehan, 'DD-MM-YYYY') as tgl_perolehan"), 'a.tgl_pembukuan', 'a.alamat', 'a.hak_tanah', 'a.sertifikat_tanggal', 
            'a.sertifikat_nomor', 'a.penggunaan',  'a.asal_usul', 'a.kd_ka', 'a.tgl_d2', 'a.tgl_proses')
            ->where('id',$id)->first(); 
            return view('admin.master.barang.detail', compact('tanah'));
    }

    public function add()
    {
        $sup = DB::table('utils_sup');
        $ruasJalan = DB::table('master_ruas_jalan');
        $uptd = DB::table('landing_uptd');
        //$jenis = DB::table('utils_jenis_jembatan');

        if (Auth::user()->internalRole->uptd) {
            if (Auth::user()->internalRole->uptd) {
                $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                $sup = $sup->where('uptd_id', $uptd_id);
                $ruasJalan = $ruasJalan->where('uptd_id', $uptd_id);
            }
        }
        $sup = $sup->get();
        $ruasJalan = $ruasJalan->get();
        $uptd = $uptd->get();
        //$jenis = $jenis->get();

        return view('admin.master.jembatan.add', compact('sup', 'ruasJalan', 'uptd'));
    }

    public function store(Request $request)
    {
        // $jembatan = $request->except('_token', 'foto');

        $jembatan['id_jembatan'] = $request->id_jembatan;
        $jembatan['nama_jembatan'] = $request->nama_jembatan;
        $jembatan['uptd'] = $request->uptd;
        $jembatan['ruas_jalan'] = $request->ruas_jalan;
        $jembatan['sup'] = $request->sup;
        $jembatan['lokasi'] = $request->lokasi;
        // $jembatan['status'] = $request->status;
        $jembatan['kondisi'] = $request->kondisi;
        //$jembatan['debit_air'] = $request->debit_air;
        //$jembatan['tinggi_jagaan'] = $request->tinggi_jagaan;
        //$jembatan['id_jenis_jembatan'] = $request->id_jenis_jembatan;
        $jembatan['tinggi_muka_air_banjir'] = $request->tinggi_muka_air_banjir;
        $jembatan['panjang'] = $request->panjang;
        $jembatan['lebar'] = $request->lebar;
        $jembatan['jumlah_bentang'] = $request->jumlah_bentang;
        $jembatan['lat'] = $request->lat;
        $jembatan['lng'] = $request->lng;
        $jembatan['ket'] = $request->ket;
        $jembatan['kategori'] = "";
        $jembatan['created_by'] = Auth::user()->id;
        $jembatan['tipe'] = $request->tipe;

        $jembatanModel = new Jembatan();
        $result_jembatan = $jembatanModel->insert($jembatan);
        $last3 = DB::table('master_jembatan')->latest('id')->first();

        if ($result_jembatan) {
            if ($request->foto != null) {
                foreach ($request->foto as $i => $val) {
                    $path = 'jembatan/' . Str::snake(date("YmdHis").'_'.$val->getClientOriginalName());
                    $val->storeAs('public/', $path);
                    $file['foto'] = $path;
                    $file['nama'] = $request->nama[$i];
                    $file['id_jembatan'] = $last3->id;
                    DB::table('master_jembatan_foto')->insert($file);
                }
            }
        }


        for ($i = 0; $i < $jembatan['jumlah_bentang']; $i++) {
            $textPanjang = 'panjangBentang' . $i;
            $textTipe = 'tipe' . $i;

            $dataBentang['master_jembatan_id'] = $last3->id;
            $dataBentang['bentang'] = $i + 1;
            $dataBentang['panjang'] = $request->$textPanjang;
            $dataBentang['tipe_bangunan_atas_id'] = $request->$textTipe;

            DB::table('master_jembatan_bentang')->insert($dataBentang);
        }

        $color = "success";
        $msg = "Berhasil Menambah Data Jembatan";
        return redirect(route('getMasterJembatan'))->with(compact('color', 'msg'));
    }

    public function edit($id)
    {
        $jembatan = Jembatan::find($id);

        $id = substr($jembatan->uptd, strlen($jembatan->uptd) - 1);
        $id = (int) $id;

        $ruasJalan = DB::table('master_ruas_jalan');
        $ruasJalan = $ruasJalan->where('uptd_id', $id);
        $ruasJalan = $ruasJalan->get();


        $sup = DB::table('utils_sup');
        $sup = $sup->where('uptd_id', $id);
        $sup = $sup->get();
        $uptd = DB::table('landing_uptd')->get();
        //$jenis = DB::table('utils_jenis_jembatan')->get();
        $foto = DB::table('master_jembatan_foto')->where('id_jembatan', $jembatan->id)->get();

        $dataBentang = DB::table('master_jembatan_bentang');
        $dataBentang = $dataBentang->where('master_jembatan_id', $jembatan->id);
        $dataBentang = $dataBentang->get();

        $tipe = DB::table('utils_tipe_bangunan_atas');
        $tipe = $tipe->get();

        return view('admin.master.jembatan.edit', compact('jembatan', 'ruasJalan', 'sup', 'uptd', 'tipe', 'dataBentang', 'foto'));
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


    public function update(Request $request)
    {
        // $jembatan = $request->except('_token', 'foto', 'id');
        $jembatan['id_jembatan'] = $request->id_jembatan;
        $jembatan['nama_jembatan'] = $request->nama_jembatan;
        $jembatan['uptd'] = $request->uptd;
        $jembatan['ruas_jalan'] = $request->ruas_jalan;
        $jembatan['sup'] = $request->sup;
        $jembatan['lokasi'] = $request->lokasi;
        // $jembatan['status'] = $request->status;
        $jembatan['kondisi'] = $request->kondisi;
        //$jembatan['debit_air'] = $request->debit_air;
        //$jembatan['tinggi_jagaan'] = $request->tinggi_jagaan;
        //$jembatan['id_jenis_jembatan'] = $request->id_jenis_jembatan;
        $jembatan['tinggi_muka_air_banjir'] = $request->tinggi_muka_air_banjir;
        $jembatan['panjang'] = $request->panjang;
        $jembatan['lebar'] = $request->lebar;
        $jembatan['jumlah_bentang'] = $request->jumlah_bentang;
        $jembatan['lat'] = $request->lat;
        $jembatan['lng'] = $request->lng;
        $jembatan['ket'] = $request->ket;
        $jembatan['tipe'] = $request->tipe;

        $oldfoto = DB::table('master_jembatan_foto')->where('id_jembatan', $request->id)->get();

        if ($request->foto != null) {
            foreach ($oldfoto as $j => $row) {
                $row->foto ?? Storage::delete('public/' . $row->foto);
                DB::table('master_jembatan_foto')->where('foto', $row->foto)->delete();
            }

            foreach ($request->foto as $i => $val) {
                $path = 'jembatan/' . Str::snake(date("YmdHis") . ' ' . $val->getClientOriginalName());
                $val->storeAs('public/', $path);
                $file['foto'] = $path;
                $file['nama'] = $request->nama[$i];
                $file['id_jembatan'] = $request->id;
                DB::table('master_jembatan_foto')->insert($file);
            }
        }
        $jembatan['updated_by'] = Auth::user()->id;
        DB::table('master_jembatan')->where('id', $request->id)->update($jembatan);

        for ($i = 0; $i < $jembatan['jumlah_bentang']; $i++) {
            $textPanjang = 'panjangBentang' . $i;
            $textTipe = 'tipe' . $i;
            $textIdBentang = 'idBentang' . $i;

            $dataBentang['master_jembatan_id'] = $request->id;
            $dataBentang['bentang'] = $i + 1;
            $dataBentang['panjang'] = $request->$textPanjang;
            $dataBentang['tipe_bangunan_atas_id'] = $request->$textTipe;

            $oldBentang = DB::table('master_jembatan_bentang')->where('id', $request->$textIdBentang);
            if ($oldBentang->exists()) {
                DB::table('master_jembatan_bentang')->where('id', $request->$textIdBentang)->update($dataBentang);
            } else {
                DB::table('master_jembatan_bentang')->insert($dataBentang);
            }
        }

        $color = "success";
        $msg = "Berhasil Memperbaharui Data Jembatan";

        return redirect(route('getMasterJembatan'))->with(compact('color', 'msg'));
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
