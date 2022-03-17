<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;
use App\Announcement;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        View::composer('*', function ($view) {
       //     $uptd_lists = DB::table('landing_uptd')
         //   ->get();
          
           // $input_uptd_lists = DB::table('landing_uptd');
            //if (Auth::user() && Auth::user()->internalRole->uptd) {
              //  $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                //$input_uptd_lists = $input_uptd_lists->where('id',$uptd_id);
            //}
            //$input_uptd_lists = $input_uptd_lists->get();
             //$view->with(['uptd_lists'=> $uptd_lists, 'input_uptd_lists'=>$input_uptd_lists]);
        });
        View::composer('*', function ($view) {
//            $user_lists = DB::table('users')->get();
  //          $view->with('user_lists', $user_lists);
        });
        View::composer('*', function ($view) {
    //        $user_lists_uptd = User::get();
      //      $temp=[];
            //foreach($user_lists_uptd as $no => $data){
          //      $cek =$data->internalRole->uptd ?? '';
        //        if(Auth::user() && $cek == Auth::user()->internalRole->uptd)
              //      $temp[]=$data;
            //}
            //$user_lists_uptd = $temp;
            //$view->with('user_lists_uptd', $user_lists_uptd);
        });
        
        
                
        View::composer('*', function ($view) {
            if(Auth::user()){
               
                $profile_users = DB::table('user_employee')->where('user_id',Auth::user()->id)->first();
                $view->with('profile_users', $profile_users);
            }
        });
        View::composer('*', function ($view) {
            $pengumuman_internal = "";
            if(Auth::user()){
               
               // $pengumuman_internal = Announcement::where('sent_to','internal')
               // ->leftJoin('users','announcements.created_by','=','users.id')->select('announcements.*', 'users.name as nama_user')
               // ->latest('announcements.created_at')->paginate(3);
                
            }
         //   $pengumuman_masyarakat = Announcement::where('sent_to','masyarakat')
         //   ->leftJoin('users','announcements.created_by','=','users.id')->select('announcements.*', 'users.name as nama_user')
            
         //   ->latest('announcements.created_at')->paginate(6);
         //   $view->with(['pengumuman_internal'=> $pengumuman_internal, 'pengumuman_masyarakat'=>$pengumuman_masyarakat]);
        });
        View::composer('*', function ($view) {
            //$utils_notif = DB::table('utils_notifikasi')->where('utils_notifikasi.title','pengumuman')->where('utils_notifikasi.role','internal')
            //->leftJoin('announcements','announcements.id','=','utils_notifikasi.pointer_id')->select('announcements.*','utils_notifikasi.title as nama_notif','utils_notifikasi.id as utils_notifikasi_id')
           // ->latest('created_at')->get();
            //// dd($utils_notif);
            //$jumlah_notif_internal = count($utils_notif);
            //$read_notif_internal = "";
            //if(Auth::user()){
                
              //  $read_notif_internal = DB::table('utils_notifikasi')->where('utils_notifikasi.title','pengumuman')->where('utils_notifikasi.role','internal')
                //->rightJoin('read_notifikasi','read_notifikasi.utils_notifikasi_id','=','utils_notifikasi.id')->where('read_notifikasi.user_id',Auth::user()->id)
                //->get();
                //// dd($read_notif_internal);
                //$jumlah_notif_internal = $jumlah_notif_internal - count($read_notif_internal);
                
            //}
            //$view->with(['utils_notif'=> $utils_notif, 'jumlah_notif_internal'=>$jumlah_notif_internal, 'read_notif_internal'=>$read_notif_internal]);
        });

         
        

    }
}
