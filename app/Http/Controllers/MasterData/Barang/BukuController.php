<?php

namespace App\Http\Controllers\MasterData\Barang;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\Datatables\DataTables;
use App\Model\Master\Barang\Buku;
use Illuminate\Support\Facades\Crypt;



class BukuController extends Controller
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

    public function index(Request $request)
    {

        $filter['bidang'] = $request->bidang;
        $filter['kode_unit'] = $request->kode_unit;
        $filter['nama_unit'] = $request->nama_unit;
        $bidang = DB::table('ref_organisasi_bidang')->get();

        return view('admin.master.kib_f.buku.buku', compact('bidang', 'filter'));
    }


    public function json()
    {
        $buku = DB::table('ta_kib_f as a')
                    ->select('a.idpemda as id',DB::raw("CONCAT(a.kd_aset8,'.',a.kd_aset80,'.',a.kd_aset81,'.',ltrim(to_char(a.kd_aset82, '00')) ,'.',ltrim(to_char(a.kd_aset83, '000')),'.',ltrim(to_char(a.kd_aset84, '000')),'.',ltrim(to_char(a.kd_aset85, '000'))) as kode_aset"), 
                    'a.kd_pemilik',  
                    'a.no_register', 
                       'a.harga',
                        'b.nm_pemilik',
                        'a.kondisi',
                         DB::raw(" to_char( a.tgl_perolehan, 'DD-MM-YYYY') as tgl_perolehan"),
                         'a.tgl_pembukuan', 
                         DB::raw(" to_char( a.dokumen_tanggal, 'DD-MM-YYYY') as dokumen_tanggal"),
                         'a.dokumen_nomor',
                           'a.latitude', 
                           'a.longitude',
                          'a.asal_usul')
                        ->join('ref_pemilik as b','a.kd_pemilik','=','b.kd_pemilik')

                        ->where('a.kd_hapus','0');
                        
         return DataTables::of($buku)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div style="min-width:200px; class="btn-group  " role="group" data-placement="top" title="" data-original-title=".btn-xlg">';
                   //  if (hasAccess(Auth::user()->role_id, "Bidang", "View")) {
                    $btn = $btn . '<a href="' . route("getDetailBuku", $row->id) . '"><button data-toggle="tooltip" title="Lihat Foto" class="btn btn-success btn-mini waves-effect waves-light"><i class="icofont icofont-eye"></i></button></a>';
             //   }
                if (hasAccess(Auth::user()->role_id, "Bidang", "Update")) {
                    $btn = $btn . '<a href="'. route('buku.edit', $row->id) .' "><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-mini  waves-effect waves-light"><i class="icofont icofont-pencil"></i></button></a>';
                }

                if (hasAccess(Auth::user()->role_id, "Bidang", "Delete")) {
                    $btn = $btn . '<a href="'. route('buku.delete', $row->id) .' " data-id="' . $row->id. '" data-toggle="modal"><button data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-mini waves-effect waves-light"><i class="icofont icofont-trash"></i></button></a>';
                }

           


                $btn = $btn . '</div>';

                return $btn;
            })
            ->rawColumns(['action'])

            ->make(true);
    }
    // public function json()xx
    // {
    //     $buku = DB::table('ta_kib_f')
    //         ->select(
    //             'idpemda as id',
    //             DB::raw("CONCAT(ta_kib_f.kd_aset8,'',ta_kib_f.kd_aset80,'',ta_kib_f.kd_aset81,'',ta_kib_f.kd_aset82,'',ta_kib_f.kd_aset83,'',ta_kib_f.kd_aset84,'',ta_kib_f.kd_aset85) as kode_aset"),
    //             'kd_pemilik',
    //             'no_register',
    //             DB::raw("to_char(tgl_perolehan, 'DD-MM-YY') as tgl_perolehan"),
    //             DB::raw("to_char(tgl_pembukuan, 'DD-MM-YY') as tgl_pembukuan"),
    //             'kondisi',
    //             'lokasi',
    //             'asal_usul',
    //             'dokumen_tanggal',
    //             'dokumen_nomor',
    //             'harga',
    //         )
    //         ->where('ta_kib_f.kd_hapus', '0');
    //         //->join('ref_pemilik as b', 'ta_kib_f.kd_pemilik', '=', 'b.kd_pemilik')
    //     //$formatRP = DB::statement("set LC_MONETARY='en_ID'");
    //     return DataTables::of($buku)
    //         ->addIndexColumn()
    //         ->addColumn('action', function ($row) {
    //             $btn = '<div style="min-width:200px; class="btn-group  " role="group" data-placement="top" title="" data-original-title=".btn-xlg">';
    //             //  if (hasAccess(Auth::user()->role_id, "Bidang", "View")) {
    //             $btn = $btn . '<a href="buku/detail/'.$row->id.'"><button data-toggle="tooltip" title="Lihat Foto" class="btn btn-success btn-mini waves-effect waves-light"><i class="icofont icofont-eye"></i></button></a>';
    //             //   }
    //             if (hasAccess(Auth::user()->role_id, "Bidang", "Update")) {
    //                 $btn = $btn . '<a href="buku/getBukuById/'.$row->id.'"><button data-toggle="tooltip" title="Edit" class="btn btn-primary btn-mini  waves-effect waves-light"><i class="icofont icofont-pencil"></i></button></a>';
    //             }

    //             if (hasAccess(Auth::user()->role_id, "Bidang", "Delete")) {
    //                 $btn = $btn . '<a href="buku/delete/'.$row->id.'"><button data-toggle="tooltip" title="Hapus" class="btn btn-danger btn-mini waves-effect waves-light"><i class="icofont icofont-trash"></i></button></a>';
    //             }

    //             $btn = $btn . '</div>';

    //             return $btn;
    //         })
    //         ->rawColumns(['action'])

    //         ->make(true);
    // }

    public function detail($id)
    {
       
        $buku = DB::table('ta_kib_f as a')->where('a.kd_hapus','0')
        ->join('ref_rek5_108 as b' , function($join)
                         {
                             $join->on('b.kd_aset5', '=', 'a.kd_aset85');
                            //  $join->on('b.kd_aset4','=','a.kd_aset84');
                            //  $join->on('b.kd_aset3','=','a.kd_aset83');
                            //  $join->on('b.kd_aset2','=','a.kd_aset82');
                            //  $join->on('b.kd_aset1','=','a.kd_aset81');
                            //  $join->on('b.kd_aset0','=','a.kd_aset80');
                          })

        ->select('a.idpemda as id',
        'b.nm_aset5',DB::raw("CONCAT(a.kd_aset8,'.',a.kd_aset80,'.',a.kd_aset81,'.',ltrim(to_char(a.kd_aset82, '00')) ,'.',ltrim(to_char(a.kd_aset83, '000')),'.',ltrim(to_char(a.kd_aset84, '000')),'.',ltrim(to_char(a.kd_aset85, '000'))) as kode_aset"), 
           'a.no_register',
            'a.harga',
            'a.lokasi',
            'a.dokumen_tanggal',
            'a.dokumen_nomor',
            'a.kondisi',
             'c.kd_pemilik',
             'c.nm_pemilik',
             DB::raw(" to_char( a.tgl_perolehan, 'DD-MM-YYYY') as tgl_perolehan"), 'a.tgl_pembukuan',
            'a.asal_usul','a.latitude','a.longitude' )
            ->join('ref_pemilik as c','a.kd_pemilik','=','c.kd_pemilik')
            ->where('a.idpemda',$id)->first(); 
            
        $dokumen = DB::table('ta_kib_f as a')
        ->select('b.filename','b.id_dokumen')
           ->join('ta_kib_f_dokumen as b','a.idpemda','=','b.idpemda')
           ->where('a.idpemda',$id)->get();

        $profile_picture =  DB::table('ta_kib_f_dokumen')
        ->select('filename','path')
        ->where('idpemda',$id)->where('extension','jpg')->first();    

      
            


            return view('admin.master.kib_f.buku.detail', compact('buku','dokumen','profile_picture'));
    }


    public function add()
    {

        $kode_pemilik = DB::table('ref_pemilik')->get();
        $kab_kota = DB::table('ref_organisasi_kab_kota')->get();
        $unit = DB::table('ref_organisasi_unit')->get();
        $rincian_object = DB::table('ref_rek3_108')
            ->where('kd_aset1','5')
            ->where('kd_aset2','1')
            ->get();

        return view('admin.master.kib_f.buku.add', compact('kode_pemilik', 'unit', 'rincian_object','kab_kota'));
    }

    public function getSubRincianObyek(Request $request)
    {
        if ($request->ajax()) {
            $ex = explode('_', $request->rincian_obyek);
            $kd_aset0 = $ex[0];
            $kd_aset1 = $ex[1];

            $sub_rincian_obyek = DB::table('ref_rek4_108')
                ->where('kd_aset0', $kd_aset0)
                ->where('kd_aset1', $kd_aset1)
                // ->where('kd_aset3',1)
                ->get();
            $data = view('admin.master.kib_f.buku.ajax_select_subrincianobyek', compact('sub_rincian_obyek'))->render();
            return response()->json(['options' => $data]);
        }
    }

    public function getSubSubRincianObyek(Request $request)
    {
        if ($request->ajax()) {
            $ex = explode('_', $request->rincian_obyek);
            $kd_aset1 = $ex[0];
            $kd_aset2 = $ex[1];

            $sub_sub_rincian_obyek = DB::table('ref_rek5_108')
                ->where('kd_aset1', $kd_aset1)
                ->where('kd_aset4', $kd_aset2)
                ->get();
            $data = view('admin.master.kib_f.buku.ajax_select_subsubrincianobyek', compact('sub_sub_rincian_obyek'))->render();
            return response()->json(['options' => $data]);
        }
    }


    public function getBukuById($id)
    {
        $kode_pemilik = DB::table('ref_pemilik')->get();

        $unit = DB::table('ref_organisasi_unit')->get();
        $rincian_object = DB::table('ref_rek3_108')
            ->where('kd_aset1', '1')
            ->get();
        $decryptId = Crypt::decryptString($id);
        $buku = DB::table('ta_kib_f')->where('id',$decryptId)->get();
        return view('admin.master.kib_f.buku.edit',[
            'page' => 'Edit Buku (KIB-F)',
            'buku' => $buku,
            'unit' => $unit,
            'kode_pemilik' => $kode_pemilik,
            'rincian_object' => $rincian_object
        ]);
    }



    public function update(Request $request){ 


         
       $kib_f_buku['kd_pemilik'] = $request->kode_pemilik;
       $kib_f_buku['kd_aset8'] = $request->kd_aset;
       $kib_f_buku['kd_aset80'] = $request->kd_aset0; 
       $kib_f_buku['kd_aset81'] = $request->kd_aset1;
       $kib_f_buku['kd_aset82'] = $request->kd_aset2;
       $kib_f_buku['kd_aset83'] = $request->kd_aset3;
       $kib_f_buku['kd_aset84'] = $request->kd_aset4;
       $kib_f_buku['kd_aset85'] = $request->kd_aset5;
       //$kib_f_buku['no_register'] = $this->getNoRegister($request);
       $kib_f_buku['tgl_perolehan'] = $request->tanggal_pembelian;
       $kib_f_buku['tgl_pembukuan'] = $request->tanggal_pembukuan;
       $kib_f_buku['dokumen_tanggal'] = $request->tanggal_dokumen;
       $kib_f_buku['dokumen_nomor'] = $request->no_dokumen;
       $kib_f_buku['asal_usul'] = $request->asal_usul;
       $kib_f_buku['penggunaan'] = $request->penggunaan;
       $kib_f_buku['harga'] = $request->harga;
       $kib_f_buku['keterangan'] = $request->keterangan;
       $kib_f_buku['kd_kecamatan'] = $request->kecamatan;
       $kib_f_buku['kd_desa'] = $request->desa;
       $kib_f_buku['latitude'] = $request->lat;
       $kib_f_buku['longitude'] = $request->lng;
        $id = $request->idpemda;
        DB::table('ta_kib_f')->where('idpemda', $id)->update($kib_f_buku);

        if ($request->hasfile('uploadFile')) {
          
            $path_folder = "/document/kib_f_buku/". $new_kd_pemda;
            $path = public_path().$path_folder;
            if (!file_exists($path)) {
                // path does not exist
                mkdir($path, 0755, true);
            }

            //$request()->validate([ 
            //    'file' => 'required|mimes:pdf,jpg,png|max:2048',
            //]);

            foreach($request->file('uploadFile') as $file) { 
              

                $imageName =  $file->getClientOriginalName(); 
                $file->move($path, $imageName); 
                $this->saveFileKibF($new_kd_pemda,$imageName,$path_folder);
               
            }
        }

        $color = "success";
        $msg = " Data Id Pemda ".$id." telah diperbaharui";
        return redirect(route('getTanah'))->with(compact('color', 'msg'));

    }


    public function getSubUnit(Request $request)
    {
        if ($request->ajax()) {
            $ex = explode('_', $request->kode_unit);
            $kode_unit = $ex[0];
            $kode_bidang = $ex[1];
            $sub_unit = DB::table('ref_organisasi_sub_unit')->where('kode_unit', $kode_unit)->where('kode_bidang', $kode_bidang)->get();
            $data = view('admin.master.kib_f.buku.ajax_select_sub_unit', compact('sub_unit'))->render();
            return response()->json(['options' => $data]);
        }
    }

    public function getUPB(Request $request)
    {
        if ($request->ajax()) {
            $ex = explode('_', $request->kode_sub_unit);
            $bidang = $ex[0];
            $kode_unit = $ex[1];
            $kode_sub_unit = $ex[2];
            $upb = DB::table('ref_organisasi_upb')
                ->where('kode_bidang', $bidang)
                ->where('kode_unit', $kode_unit)
                ->where('kode_sub_unit', $kode_sub_unit)
                ->get();
            $data = view('admin.master.kib_f.buku.ajax_select_upb', compact('upb'))->render();
            return response()->json(['options' => $data]);
        }
    }


    public function getKodePemilik(Request $request)
    {
        $kode_pemilik = DB::table('ref_pemilik')->where('kd_pemilik', $request->kode_pemilik)->first();
        return $kode_pemilik->nm_pemilik;
    }

    public function generateKodePemda($kd){
        $kib_f = DB::table('ta_kib_f')
                    ->select(DB::raw("MAX(idpemda) as id_pemda"))
                    ->where('idpemda','LIKE','%'.$kd.'%')->first();

                    $last_code = ltrim(substr($kib_f->id_pemda,12,6),0);
                    $newcode = $kd.''.str_pad(((int)$last_code+1),6, "0", STR_PAD_LEFT);
        return $newcode;
        
    }
    
    public function save(Request $request)
    {

        $ex = explode('_',$request->upb);
        $bidang = $ex[0];
        $unit = $ex[1];
        $sub_unit = $ex[2];
        $upb = $ex[3]; 
        $kd_pemda = str_pad($bidang,2, "0", STR_PAD_LEFT)."".str_pad($unit,2, "0", STR_PAD_LEFT)."".str_pad($sub_unit,3, "0", STR_PAD_LEFT)."".str_pad($upb,3, "0", STR_PAD_LEFT)."".$request->kab_kota;
        $new_kd_pemda = $this->generateKodePemda($kd_pemda);
        $buku['kd_prov'] = "10";
        $buku['kd_kab_kota'] = $request->kab_kota; 
        $buku['idpemda'] = $new_kd_pemda; 
        $buku['kd_bidang'] = $bidang;
        $buku['kd_unit'] = $unit;
        $buku['kd_sub'] = $sub_unit;
        $buku['kd_upb'] = $upb;
        // $buku['tahun'] = $request->session()->get('tahun');
        $buku['kd_hapus'] ='0'; 
        $buku['kd_pemilik'] = $request->kode_pemilik;
        $buku['kd_aset8'] = $request->kd_aset;
        $buku['kd_aset80'] = $request->kd_aset0; 
        $buku['kd_aset81'] = $request->kd_aset1;
        $buku['kd_aset82'] = $request->kd_aset2;
        $buku['kd_aset83'] = $request->kd_aset3;
        $buku['kd_aset84'] = $request->kd_aset4;
        $buku['kd_aset85'] = $request->kd_aset5;
        $buku['no_register'] = $this->getNoRegister($request);
        $buku['tgl_perolehan'] = $request->tanggal_pembelian;
        $buku['tgl_pembukuan'] = $request->tanggal_pembukuan;
        $buku['dokumen_tanggal'] = $request->dokumen_tanggal;
        $buku['dokumen_nomor'] = $request->dokumen_nomor;
        $buku['lokasi'] = $request->lokasi;
        $buku['asal_usul'] = $request->asal_usul;
        $buku['keterangan'] = $request->keterangan;
        $buku['harga'] = $request->harga;
        $buku['kondisi'] = $request->kondisi;
        $buku['kd_kecamatan'] = $request->kecamatan;
        $buku['kd_desa'] = $request->desa;


        $buku['latitude'] = $request->lat;
        $buku['longitude'] = $request->lng;
        DB::table('ta_kib_f')->insert($buku);

        if ($request->hasfile('uploadFile')) {
          
            $path_folder = "/document/kib_f_buku/".$new_kd_pemda;
            $path = public_path().$path_folder;
            if (!file_exists($path)) {
                // path does not exist
                mkdir($path, 0755, true);
            }

            //$request()->validate([ 
            //    'file' => 'required|mimes:pdf,jpg,png|max:2048',
            //]);

            foreach($request->file('uploadFile') as $file) { 
              

                $imageName =  $file->getClientOriginalName(); 
                $file->move($path, $imageName); 
                $this->saveFileKibFBuku($new_kd_pemda,$imageName,$path_folder);
               
            }
        }

        $color = "success";
        $msg = "data Kib-F Buku telah ditambahkan";
        return redirect(route('getBuku'))->with(compact('color', 'msg'));
    }

    // public function save(Request $request)
    // {

    //     // if ($request->hasfile('uploadFile')) {
    //     //     $request()->validate([ 
    //     //         'uploadFile' => 'required'
    //     //     ]);
             
    //     //     foreach($request->file('uploadFile') as $file) { 
    //     //         $imageName =  $file->getClientOriginalExtension(); 
    //     //         $file->move(public_path('images'), $imageName); 
    //     //     }
    //     // }

    //     $ex = explode('_', $request->upb);
    //     $bidang = $ex[0];
    //     $kode_unit = $ex[1];
    //     $kode_sub_unit = $ex[2];
    //     $upb = $ex[3];
    //     $buku['kd_unit'] = $kode_unit;
    //     $buku['kd_sub'] = $kode_sub_unit;
    //     $buku['kd_bidang'] = $bidang;
    //     $buku['kd_upb'] = $upb;
    //     $buku['kd_pemilik'] = $request->kode_pemilik;
    //     $buku['kd_aset'] = $request->kd_aset;
    //     $buku['kd_aset0'] = $request->kd_aset0;
    //     $buku['kd_aset1'] = $request->kd_aset1;
    //     $buku['kd_aset2'] = $request->kd_aset2;
    //     $buku['kd_aset3'] = $request->kd_aset3;
    //     $buku['kd_aset4'] = $request->kd_aset4;
    //     $buku['kd_aset5'] = $request->kd_aset5;
    //     $buku['no_register'] = $request->no_register;
    //     $buku['tgl_perolehan'] = '02-02-02';
    //     $buku['tgl_pembukuan'] = '02-02-02';
    //     $buku['kd_tanah1'] = 0;
    //     $buku['kd_tanah2'] = 0;
    //     $buku['kd_tanah3'] = 0;
    //     $buku['kd_tanah4'] = 0;
    //     $buku['kd_tanah5'] = 0;
    //     $buku['beton_tidak'] ='-';
    //     $buku['bertingkat_tidak'] = '-';
    //     $buku['luas_lantai'] = 0;
    //     $buku['status_tanah'] = '-';
    //     $buku['kode_tanah'] =0 ;
    //     $buku['asal_usul'] = $request->asal_usul;
    //     $buku['kondisi'] = 3;
    //     $buku['harga'] = $request->harga;
    //     $buku['tahun'] = '2022';
    //     $buku['idpemda'] = '05010010011000288';
    //     $buku['kd_prov'] = 10;
    //     $buku['kd_kab_kota'] = 1;
    //     $buku['kd_ka'] = 1;
    //     $buku['tgl_d2'] = '02-02-02';
    //     $buku['tgl_proses'] = '02-02-02';
    //     $buku['lokasi'] = '02-02-02';
    //     $buku['dokumen_tanggal'] ='02-02-02';
    //     $buku['dokumen_nomor'] = 'tydak';

    //     DB::table('ta_fn_kib_f')->insert($buku);
    //     $color = "success";
    //     $msg = "data Kib-F BUKU telah ditambahkan";
    //     return redirect(route('getBuku'))->with(compact('color', 'msg'));
    // }

    public function getUPBFilterTable(Request $request){
        if($request->ajax()){
            $ex = explode('_',$request->kode_upb);
            $bidang = $ex[0];
            $kode_unit = $ex[1]; 
            $kode_sub_unit = $ex[2];
            $kode_upb = $ex[3];
            $kib_f = DB::table('ta_kib_a')
            ->where('kd_bidang', $bidang)
            ->where('kd_unit',$kode_unit)
            ->where('kd_sub',$kode_sub_unit)
            ->where('kd_upb',$kode_upb)
            ->get();
    		$data = view('admin.master.kib_f.buku.ajax_select_table_kibf',compact('kib_f'))->render();
    		return response()->json(['data'=>$data]);
    	}
    }

    public function getKecamatan(Request $request) {
        if($request->ajax()){
            $kecamatan = DB::table('ref_organisasi_kecamatan')
            ->where('kode_kab_kota',$request->kode_kab_kota)
             
            ->get();
    		$data = view('admin.master.kib_f.buku.ajax_select_kecamatan',compact('kecamatan'))->render();
    		return response()->json(['options'=>$data]);
        }
    }

    public function getDesa(Request $request) {
        if($request->ajax()){
            $desa = DB::table('ref_organisasi_desa')
            ->where('kode_kecamatan',$request->kode_kecamatan)
             
            ->get();
    		$data = view('admin.master.kib_f.buku.ajax_select_desa',compact('desa'))->render();
    		return response()->json(['options'=>$data]);
        }
    }
    public function getNoRegister(Request $request) {
       
        $kd_aset = $request->kd_aset;
        $kd_aset0 = $request->kd_aset0;
        $kd_aset1 = $request->kd_aset1;
        $kd_aset2 = $request->kd_aset2;
        $kd_aset3 = $request->kd_aset3;
        $kd_aset4 = $request->kd_aset4;
        $kd_aset5 = $request->kd_aset5;
        $no_reg = DB::table('ta_kib_a')
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
            }else{
                $no_reg = 1;
            }
        return $no_reg;
    } 

    public function delete($id)
    {
        $buku['kd_hapus'] = 1;
        $jembatan = DB::table('ta_kib_f')->where('idpemda', $id)->update($buku);
        $foto = DB::table('master_jembatan_foto')->where('id_jembatan', $id)->delete();

        $color = "success";
        $msg = "Berhasil Menghapus Data Jembatan";
        return redirect(route('getMasterJembatan'))->with(compact('color', 'msg'));

        
        // // $old = $jembatan->where('id', $id);
        // // $old->delete();

        // $color = "success";
        // $msg = "Berhasil Menghapus Data Buku";
        // return redirect(route('getBuku'))->with(compact('color', 'msg'));
    }

    public function imagesUploadPost(Request $request)  {
 
        request()->validate([ 
            'uploadFile' => 'required', 
        ]);
         
        foreach($request->file('uploadFile') as $file) { 
            $imageName =  $file->getClientOriginalExtension(); 
            $file->move(public_path('images'), $imageName); 
        }
        return true;
      
    }

    
    public function viewPhoto($id)
    {
        $foto = DB::table('master_jembatan_foto')->where('id_jembatan', $id)->get();

        return view('admin.master.jembatan.viewPhoto', compact('foto'));
    }

    public function saveFileKibFBuku($idpemda, $filename,$path){
        $dokumen['idpemda'] = $idpemda;
        $dokumen['filename'] =  $filename;
        $dokumen['path'] =  $path;
        DB::table('ta_kib_f_dokumen')->insert($dokumen);
    }

    

    public function edit($id)
    { 

        $buku = DB::table('ta_kib_f as a')
         

        ->select('a.idpemda as id','d.nama_unit','e.nama_sub_unit','f.nama_upb','a.kd_aset8','a.kd_aset80','a.kd_aset81','a.kd_aset82', 'a.kd_aset83', 'a.kd_aset84', 'a.kd_aset85' , 
           'a.no_register', 'a.harga',   'a.kd_pemilik','c.nm_pemilik',
           DB::raw(" to_char( a.tgl_perolehan, 'YYYY-MM-DD') as tgl_perolehan"), 
           DB::raw("to_char( a.tgl_pembukuan, 'YYYY-MM-DD') as tgl_pembukuan") , DB::raw("to_char( a.dokumen_tanggal, 'YYYY-MM-DD') as dokumen_tanggal")  , 
            'a.kd_kab_kota',
            'a.kd_kecamatan',
            'a.kd_desa',
            'a.keterangan',
            'a.dokumen_tanggal',
            'a.dokumen_nomor', 
              'a.asal_usul', 
              'a.latitude',
              'a.longitude' )
            ->join('ref_pemilik as c','a.kd_pemilik','=','c.kd_pemilik')
            ->join('ref_organisasi_unit as d','d.kode_unit','=','a.kd_unit')
            ->join('ref_organisasi_sub_unit as e','e.kode_sub_unit','=','a.kd_sub')
            ->join('ref_organisasi_upb as f','f.kode_upb','=','a.kd_upb')
            ->where('a.idpemda',$id)->first(); 

        $dokumen = DB::table('ta_kib_f as a')
                ->select('b.filename','b.id_dokumen')
                   ->join('ta_kib_f_dokumen as b','a.idpemda','=','b.idpemda')
                   ->where('a.idpemda',$id)->get();
                   $kode_pemilik = DB::table('ref_pemilik')->get();
                   $kab_kota = DB::table('ref_organisasi_kab_kota')->get();
                   
        $unit = DB::table('ref_organisasi_unit')->get(); 
        $rincian_object = DB::table('ref_rek3_108')
                            ->where('kd_aset1','1')
                            ->get(); 

        //str_replace('',$buku->harga)
       $harga0 =  str_replace('Rp', '', $buku->harga   );
       $harga =  floatval(str_replace('.', '', $harga0   ));
       $kecamatan = DB::table('ref_organisasi_kecamatan')->where('kode_kab_kota',$buku->kd_kab_kota)->get();
       $desa = DB::table('ref_organisasi_desa')->where('kode_kab_kota',$buku->kd_kab_kota)->get(); 
      
       $sub_rincian_obyek = DB::table('ref_rek4_108')
       ->where('kd_aset1',$buku->kd_aset81)
        ->where('kd_aset3', $buku->kd_aset83)
       ->get();

       $sub_sub_rincian_obyek = DB::table('ref_rek5_108')
       ->where('kd_aset1',$buku->kd_aset81)
        ->where('kd_aset4', $buku->kd_aset84)
       ->get();
       
       
       return view('admin.master.kib_f.buku.edit', compact('buku','dokumen','unit','rincian_object','kode_pemilik','kab_kota','harga','kecamatan','desa','sub_rincian_obyek','sub_sub_rincian_obyek'));

    }

    public function download($id_dokumen){
        $dokumen =  DB::table('ta_kib_f_dokumen') 
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




}
