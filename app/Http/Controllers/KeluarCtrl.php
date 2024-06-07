<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use DB;
use Cookie;
use Hash;
use Crypt;

class KeluarCtrl extends Controller
{
    
	public function keluar(Request $request) {
  	Cookie::queue(Cookie::forget(env('APP_IDENTIFIER').'Uuid'));
    Cookie::queue(Cookie::forget(env('APP_IDENTIFIER').'Id'));
    Cookie::queue(Cookie::forget(env('APP_IDENTIFIER').'Nama'));
    Cookie::queue(Cookie::forget(env('APP_IDENTIFIER').'Posisi'));
    Cookie::queue(Cookie::forget(env('APP_IDENTIFIER').'Sebagai'));
    return redirect()->route('masuk-view-masuk');
  }

}
