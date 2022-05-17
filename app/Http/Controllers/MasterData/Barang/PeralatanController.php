<?php

namespace App\Http\Controllers\MasterData\Barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
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

    public function add() {
        $kode_pemilik = DB::table('ref_pemilik')->get();
        $kab_kota = DB::table('ref_organisasi_kab_kota')->get();

        $unit = DB::table('ref_organisasi_unit')->get();
        $rincian_object = DB::table('ref_rek3_108')
            ->where('kd_aset1','2')
            ->get();
        return view('admin.master.kib_b.add', compact('kode_pemilik','unit','rincian_object','kab_kota'));
    }

    public function getSubUnit(Request $request){
        if($request->ajax()){
            $ex = explode('_',$request->kode_unit);
            $kode_unit = $ex[0];
            $kode_bidang = $ex[1];
    		$sub_unit = DB::table('ref_organisasi_sub_unit')->where('kode_unit', $kode_unit)->where('kode_bidang',$kode_bidang)->get();
    		$data = view('admin.master.kib_b.ajax_select_sub_unit', compact('sub_unit'))->render();
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
            $kib_b = DB::table('ta_kib_b')
                ->select('kd_bidang','kd_unit','kd_sub','idpemda','kd_upb','no_register','tgl_perolehan','harga','keterangan',DB::raw("CONCAT(kd_aset8,'.',kd_aset80,'.',kd_aset81,'.',ltrim(to_char(kd_aset82, '00')) ,'.',ltrim(to_char(kd_aset83, '000')),'.',ltrim(to_char(kd_aset84, '000')),'.',ltrim(to_char(kd_aset85, '000'))) as kode_aset"))
                ->where('kd_bidang', $bidang)
                ->where('kd_unit', $kode_unit)
                ->where('kd_sub', $kode_sub_unit)
                ->where('kd_upb', $kode_upb)
                ->get();
    		$data = view('admin.master.kib_b.ajax_select_table_kib_b',compact('kib_b'))->render();
    		return response()->json(['data'=>$data]);
    	}
    }

    public function save(Request $request){
        // $request()->validate([
        //     'file' => 'required|mimes:pdf,jpg,png|max:2048',
        // ]);

        $ex = explode('_',$request->upb);

        $bidang = $ex[0];
        $unit = $ex[1];
        $sub_unit = $ex[2];
        $upb = $ex[3];

        $kd_pemda = str_pad($bidang, 2, "0", STR_PAD_LEFT)."".str_pad($unit, 2, "0", STR_PAD_LEFT)."".str_pad($sub_unit, 3, "0", STR_PAD_LEFT)."".str_pad($upb,3, "0", STR_PAD_LEFT)."".$request->kab_kota;
        $new_kd_pemda = $this->generateKodePemda($kd_pemda);

        $kib_b['kd_prov'] = "10";
        $kib_b['kd_kab_kota'] = $request->kab_kota;
        $kib_b['idpemda'] = $new_kd_pemda;
        $kib_b['kd_bidang'] = $bidang;
        $kib_b['kd_unit'] = $unit;
        $kib_b['kd_sub'] = $sub_unit;
        $kib_b['kd_upb'] = $upb;
        $kib_b['kd_ka'] ='1';
        $kib_b['kd_hapus'] ='0';
        $kib_b['kd_pemilik'] = $request->kode_pemilik;
        $kib_b['kd_aset8'] = $request->kd_aset;
        $kib_b['kd_aset80'] = $request->kd_aset0;
        $kib_b['kd_aset81'] = $request->kd_aset1;
        $kib_b['kd_aset82'] = $request->kd_aset2;
        $kib_b['kd_aset83'] = $request->kd_aset3;
        $kib_b['kd_aset84'] = $request->kd_aset4;
        $kib_b['kd_aset85'] = $request->kd_aset5;
        $kib_b['kd_data'] = 2;
        $kib_b['no_register'] = $this->getNoRegister($request);
        $kib_b['tgl_perolehan'] = $request->tanggal_pembelian;
        $kib_b['tgl_pembukuan'] = $request->tanggal_pembukuan;
        $kib_b['merk'] = $request->merk;
        $kib_b['type'] = $request->type;
        $kib_b['cc'] = $request->cc;
        $kib_b['bahan'] = $request->bahan;
        $kib_b['nomor_pabrik'] = $request->no_pabrik;
        $kib_b['nomor_rangka'] = $request->no_rangka;
        $kib_b['nomor_mesin'] = $request->no_mesin;
        $kib_b['nomor_bpkb'] = $request->no_bpkb;
        $kib_b['nomor_polisi'] = $request->no_polisi;
        $kib_b['asal_usul'] = $request->asal_usul;
        $kib_b['kondisi'] = $request->kondisi;
        $kib_b['harga'] = $request->harga;
        $kib_b['masa_manfaat'] = $request->masa_manfaat;
        $kib_b['nilai_sisa'] = $request->nilai_sisa;
        $kib_b['keterangan'] = $request->keterangan;
        $kib_b['kd_kecamatan'] = $request->kecamatan;
        $kib_b['kd_desa'] = $request->desa;

        DB::table('ta_kib_b')->insert($kib_b);

        if ($request->hasfile('uploadFile')) {
            $path_folder = "/document/kib_b/".$new_kd_pemda;
            $path = public_path().$path_folder;
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            foreach($request->file('uploadFile') as $file) {
                $imageName =  $file->getClientOriginalName();
                $extension = $file->extension();
                $file->move($path, $imageName);
                $this->saveFileKibB($new_kd_pemda, $imageName, $path_folder, $extension);
            }
        }
        $color = "success";
        $msg = "Data Kib-B telah ditambahkan";
        return redirect( route('getPeralatan') )->with(compact('color', 'msg'));
    }

    public function saveFileKibB($idpemda, $filename, $path, $extension){
        $dokumen['idpemda'] = $idpemda;
        $dokumen['filename'] =  $filename;
        $dokumen['path'] =  $path;
        $dokumen['extension'] = $extension;
        DB::table('ta_kib_b_dokumen')->insert($dokumen);
    }

    public function generateKodePemda($kd){
        $kib_b = DB::table('ta_kib_b')
            ->select(DB::raw("MAX(idpemda) as id_pemda"))
            ->where('idpemda','LIKE','%'.$kd.'%')->first();

        $last_code = ltrim(substr($kib_b->id_pemda,12,6),0);
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
        $no_reg = DB::table('ta_kib_b')
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
        $kib_b['kd_hapus'] = 1;
        DB::table('ta_kib_b')->where('idpemda', $id)->update($kib_b);
        $color = "success";
        $msg = "Berhasil Menghapus Data Peralatan Dan Mesin";
        return redirect( route('getPeralatan') )->with(compact('color', 'msg'));
    }

    public function deletePhoto($id) {
        $id = (int) $id;
        $foto = DB::table('master_jembatan_foto')->where('id_jembatan', $id)->get();
        return view('admin.master.jembatan.deletePhoto', compact('foto'));
    }

    public function detail($id) {

        $peralatan = DB::table('ta_kib_b as a')
            ->join('ref_rek5_108 as c' , function($join){
                $join->on('c.kd_aset5','=','a.kd_aset85');
                $join->on('c.kd_aset4','=','a.kd_aset84');
                $join->on('c.kd_aset3','=','a.kd_aset83');
                $join->on('c.kd_aset2','=','a.kd_aset82');
                $join->on('c.kd_aset1','=','a.kd_aset81');
                $join->on('c.kd_aset0','=','a.kd_aset80');
            })
            ->join('ref_pemilik as b','a.kd_pemilik','=','b.kd_pemilik')
            ->select('a.idpemda as id','c.nm_aset5','a.kd_pemilik','b.nm_pemilik as pemilik','a.no_register','a.tgl_perolehan','a.tgl_pembukuan','a.merk','a.type','a.cc','a.bahan','a.nomor_pabrik','a.nomor_rangka','a.kondisi','a.keterangan','a.masa_manfaat','a.nilai_sisa',
                DB::raw("CONCAT(a.kd_aset8,'.',a.kd_aset80,'.',a.kd_aset81,'.',ltrim(to_char(a.kd_aset82, '00')) ,'.',ltrim(to_char(a.kd_aset83, '000')),'.',ltrim(to_char(a.kd_aset84, '000')),'.',ltrim(to_char(a.kd_aset85, '000'))) as kode_aset"),
                'a.nomor_mesin','a.nomor_polisi','a.nomor_bpkb','a.asal_usul','a.kondisi','a.harga','a.tahun')
            ->where('a.idpemda', $id)
            ->where('a.kd_ka','1')->first();

        $dokumen = DB::table('ta_kib_b_dokumen')->where('idpemda', $id)->get();

        // $profile_picture =  DB::table('ta_kib_b_dokumen')
        //     ->select('filename','path')
        //     ->where('idpemda',$id)->where('extension','jpg')->first();

        return view('admin.master.kib_b.detail', compact('peralatan', 'dokumen'));
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

    public function download($id_dokumen){
        $dokumen =  DB::table('ta_kib_b_dokumen')
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
    		$data = view('admin.master.kib_b.ajax_select_subsubrincianobyek',compact('sub_sub_rincian_obyek'))->render();
    		return response()->json(['options'=>$data]);
    	}
    }

}
