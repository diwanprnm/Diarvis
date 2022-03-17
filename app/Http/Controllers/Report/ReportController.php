<?php

namespace App\Http\Controllers\Report;

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

class ReportController extends Controller
{
    public function __construct()
    {
      
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
    
    public function generateReportRKB(Request $request){
        $filter['jenis_laporan'] = $request->jenis_laporan;
        $filter['footer'] = $request->footer;
        $filter['bidang'] = $request->bidang;
        $filter['unit'] = $request->unit;
        $filter['sub_unit'] =  $request->sub_unit;
        if(!empty($request->unit)) {
            $prov_kota = DB::table('ref_organisasi_unit as a')
            ->leftjoin('ref_organisasi_bidang as b', 'b.kode_bidang', '=', 'a.kode_bidang')
            ->leftjoin('ref_organisasi_provinsi as c', 'c.kode_provinsi', '=', 'a.kode_provinsi') 
            ->leftjoin('ref_organisasi_kab_kota as d', 'd.kode_provinsi', '=', 'a.kode_provinsi')
             ->select('c.nama_provinsi','d.nama_kab_kota','b.nama_bidang','a.kode_unit','a.nama_unit')->get()->first();  
        } else {
            $prov_kota ="";
        }
        $filter['provinsi'] = !empty($prov_kota->nama_provinsi) ?$prov_kota->nama_provinsi : "" ;
       
        $filter['nama_kab_kota'] = !empty($prov_kota->nama_kab_kota) ? $prov_kota->nama_kab_kota: "" ;
        $param =(!empty($request->jenis_laporan)) ?  Crypt::encryptString(json_encode($filter)) : "";
        $laporan = DB::table('ref_laporan')->get()->where('kategori','Perencanaan');
        
        
        

        $bidang = DB::table('ref_organisasi_bidang')->get();  
        $unit = (!empty($request->bidang)) ? DB::table('ref_organisasi_unit')->get()->where('kode_bidang',$request->bidang) : "";
        $sub_unit = (!empty($request->unit)) ? DB::table('ref_organisasi_sub_unit')->where('kode_unit',$request->unit)->get() : "";  
       
       
        
        return view('admin.report.perencanaan.rencana_kebutuhan', compact('laporan','prov_kota','bidang','unit','sub_unit','param','filter'));
    }

    public function previewLaporanRKB($param){
         
        $filter  = json_decode(Crypt::decryptString($param)); 
        if(!empty($filter->jenis_laporan)){
            $reportdata['provinsi'] = $filter->provinsi;
            $reportdata['nama_kab_kota'] = $filter->nama_kab_kota;
            
            $reportdata['img'] = public_path('assets/images/logo_pdf.png');     
            if(!empty($filter->bidang)){ 
            $bidang= DB::table('ref_organisasi_bidang')->where('kode_bidang',$filter->bidang)->get()->first();     
            $reportdata['bidang'] = $bidang->nama_bidang;
            }else{
                $reportdata['bidang'] = "-";
            }

            if(!empty($filter->unit)){ 
                $unit= DB::table('ref_organisasi_unit')->where('kode_unit',$filter->unit)->get()->first();     
                $reportdata['nama_unit'] = $unit->nama_unit;
            }else{
                $reportdata['nama_unit'] = "-";
            }
             
            if(!empty($filter->sub_unit)){ 
                $sub_unit= DB::table('ref_organisasi_sub_unit')->where('kode_sub_unit',$filter->sub_unit)->get()->first();     
                $reportdata['nama_sub_unit'] = $sub_unit->nama_sub_unit;
               // DB::enableQueryLog();
                $trkb =   DB::table('tr_rkbu as a')
                            ->select('a.*','b.*')
                            ->join('ref_aset_5 as b', 'b.kode_aset_5', '=', 'a.kd_aset5')
                            ->where('a.kode_sub_unit', $filter->sub_unit) 
                            ->limit(30)
                            ->get();  

              //  $quries = DB::getQueryLog();
              //  dd($quries);
                             
            }else{
                $reportdata['nama_sub_unit'] = "-";
                $trkb = "";
            }

            $reportdata['tanggal_laporan'] = (!empty($filter->footer)) ? $filter->footer : "";
            
            
         

            $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); 
            $stylesheet = file_get_contents( public_path('assets/css/style_report.css'));
    

            $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
            $html ="";
            if($filter->jenis_laporan == "1") { 
            
                $html .=  view('admin.report.perencanaan.generate_pdf_rkb' ,compact('reportdata','trkb'));

            //$html .="tes";
            }
            $mpdf->WriteHTML($html);
            $mpdf->Output("DaftarRencanaKebutuhanBarang.pdf","I"); 
        }  

    }

    public function getReportPerencanaanFilter(Request $filter) { 
        if($filter->ajax()){
    		
             
            if(!empty($filter->jenis_laporan)){
    
                $reportdata['img'] = public_path('assets/images/logo_pdf.png');     
                if(!empty($filter->bidang)){ 
                $bidang= DB::table('ref_organisasi_bidang')->where('kode_bidang',$filter->bidang)->get()->first();     
                $reportdata['bidang'] = $bidang->nama_bidang;
                }else{
                    $reportdata['bidang'] = "-";
                }
    
                if(!empty($filter->unit)){ 
                    $unit= DB::table('ref_organisasi_unit')->where('kode_bidang',$filter->bidang)->get()->first();     
                    $reportdata['nama_unit'] = $unit->nama_unit;
                }else{
                    $reportdata['nama_unit'] = "-";
                }
                 
                $reportdata['tanggal_laporan'] = (!empty($filter->footer)) ? $filter->footer : "";
    
                $response = $next($request);
                $this->response->setHeader('Cache-Control', 'max-age=0');
                $this->response->setHeader('Content-Type', 'application/pdf');
                $this->response->setHeader('Content-Disposition', 'attachment; filename="file_' . date('Y-m-d') . '.pdf"');
                 $mpdf = new \Mpdf\Mpdf([ 'mode' => 'utf-8','orientation' => 'L']); 
                $stylesheet = file_get_contents( public_path('assets/css/style_report.css'));
        
                
                $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
                $html ="";
                if($filter->jenis_laporan == "1") { 
                
                    $html .=  view('admin.report.perencanaan.generate_pdf_rkb' ,compact('reportdata'));
    
                //$html .="tes";
                }
                $mpdf->WriteHTML($html);
                
                $mpdf->Output(); 
               die;
                
            }  
    	}
    }


    public function getUnitFilter(Request $request) { 
        if($request->ajax()){
    		$unit = DB::table('ref_organisasi_unit')->where('kode_bidang',$request->kode_bidang)->get();
    		$data = view('admin.report.perencanaan.ajax_select_unit',compact('unit'))->render();
    		return response()->json(['options'=>$data]);
    	}
    }
    
    public function getSubUnitFiter(Request $request) { 
        if($request->ajax()){
    		$sub_unit = DB::table('ref_organisasi_sub_unit')->where('kode_unit',$request->kode_unit)->get();
    		$data = view('admin.report.perencanaan.ajax_select_sub_unit',compact('sub_unit'))->render();
    		return response()->json(['options'=>$data]);
    	}
    }

    public function generatePDFRKB($filter){
        echo "tes tes ";   
        //echo 
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
