<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Models\Pengguna;
use Cookie;
use Hash;
use Crypt;
use Redirect;
use DB;

class MasukCtrl extends Controller
{
  public function view(Request $request)
  {
    if (Cookie::has(env('APP_IDENTIFIER').'Uuid')) {
			return Redirect::to('/dashboard/profile');
    }
    return view('login');
  }

  public function periksa(Request $request)
  {
    $periksa = Pengguna::where('username', '=', $request->username)->first();

    if ($periksa) {
      if (Hash::check($request->password, $periksa->password)) {
        if ($periksa->status == 'block') {
          return back()->withInput()->withErrors(['wrong' => 'Akun ada diblokir sementara oleh administrator']);
        }

				$biodata = DB::table('biodata')->where('pengguna_uuid', '=', $periksa->uuid)->first();

        $minutes = time() + 60 * 60 * 10; // 10 jam
        Cookie::queue(Cookie::make(env('APP_IDENTIFIER').'Uuid', Crypt::encrypt($periksa->uuid), $minutes));
        Cookie::queue(Cookie::make(env('APP_IDENTIFIER').'BioUuid', Crypt::encrypt($biodata->uuid), $minutes));
        Cookie::queue(Cookie::make(env('APP_IDENTIFIER').'ttd', Crypt::encrypt($biodata->ttd), $minutes));
        Cookie::queue(Cookie::make(env('APP_IDENTIFIER').'Id', Crypt::encrypt($periksa->id), $minutes));
        Cookie::queue(Cookie::make(env('APP_IDENTIFIER').'Nama', Crypt::encrypt($periksa->nama), $minutes));
        Cookie::queue(Cookie::make(env('APP_IDENTIFIER').'Username', Crypt::encrypt($periksa->username), $minutes));
        Cookie::queue(Cookie::make(env('APP_IDENTIFIER').'Posisi', Crypt::encrypt($periksa->posisi), $minutes));
        Cookie::queue(Cookie::make(env('APP_IDENTIFIER').'Sebagai', Crypt::encrypt($periksa->sebagai), $minutes));
        return Redirect::to('/dashboard/profile');
      }
    }

    return back()->withInput()->withErrors(['wrong' => 'Username dan password yang diinput tidak valid']);
  }
}
