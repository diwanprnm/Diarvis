<?php

namespace App\Http\Controllers;

use App\Model\Push\UserPushNotification;
use App\Model\Transactional\Log;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;
class AuthController extends Controller
{
    // Web Service
    public function login(Request $req)
    {
        $credentials = $req->only('email', 'password');
      //  $internal = DB::table('user_pegawai')->where('nip', $req->email);
        // dd($internal->first());
        //if ($internal->count() > 0) {
          //  $user = DB::table('users')->where('id', $internal->first()->user_id)->first();
          //  if ($user->count() > 0) {
           
        //}
 
      
        $auth = Auth::attempt($credentials);
        //dd($auth);
        //dd($credentials);
        if (!$auth) {
            return back()->with(['msg' => 'Email/NIP atau Password Salah', 'color' => 'danger']);
        }
        
       Session::put('tahun',  $req->tahun);
     $org =  DB::table('users as a')
        ->select('b.nama_bidang','c.nama_unit','d.nama_sub_unit','e.nama_upb')
       ->join('ref_organisasi_bidang as b','a.bidang','=','b.kode_bidang')
       ->join('ref_organisasi_unit as c','a.unit','=','c.kode_unit')
       ->join('ref_organisasi_sub_unit as d','a.sub_unit','=','d.kode_sub_unit')
       ->join('ref_organisasi_upb as e','a.upb','=','e.kode_upb')
       ->where('a.bidang', Auth::user()->bidang)
       ->where('a.unit', Auth::user()->unit)
       ->where('a.sub_unit', Auth::user()->sub_unit)
       ->where('a.upb', Auth::user()->upb)->first();
       // dd($internal->first());
       Session::put('bidang',   $org->nama_bidang);
       Session::put('unit',   $org->nama_unit); 
       Session::put('sub_unit',   $org->nama_sub_unit);
       Session::put('upb',   $org->nama_upb);

        Log::create(['activity' => 'Login', 'description' => 'User ' . Auth::user()->name . ' Logged In To Web e-BMD Explorer']);
        return redirect('admin');
    }
    public function logout()
    {
        if (Auth::check()) {
            Log::create(['activity' => 'Logout', 'description' => 'User ' . Auth::user()->name . ' Logged Out From Web']);
        }
        Auth::logout();

        return redirect('/login');
    }
    public function verifyEmail($token)
    {
        try {
            $decrypted = Crypt::decrypt($token);
            $user = User::find($decrypted);
            $user->email_verified_at = now();
            $user->save();
            return redirect('login')->with(['msg' => 'Email Berhasil Diverifikasi', 'color' => 'success']);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return $e->getMessage();
        }
    }

    public function loginUsingId($encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $auth = Auth::loginUsingId($id);
        pushNotification([Auth::user()->id], "Logged In", "You have Logged IN");
        return redirect('admin');
    }
}
