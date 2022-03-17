<?php

namespace App\Http\Controllers;

use App\Model\Push\UserPushNotification;
use App\Model\Transactional\Log;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Web Service
    public function login(Request $req)
    {
        $credentials = $req->only('email', 'password');
        //$internal = DB::table('user_pegawai')->where('nip', $req->email);
        // dd($internal->first());
        //if ($internal->count() > 0) {
          //  $user = DB::table('users')->where('id', $internal->first()->user_id)->first();
          //  if ($user->count() > 0) {
          //  $credentials['email'] = $user->email;
        //}
        
        $auth = Auth::attempt($credentials);
        //dd($auth);
        //dd($credentials);
        if (!$auth) {
            return back()->with(['msg' => 'Email/NIP atau Password Salah', 'color' => 'danger']);
        }
        

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
