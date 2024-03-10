<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Cookie;
use DB;
use URL;
use Crypt;
use Redirect;

class Acl
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
		if (!Cookie::has(env('APP_IDENTIFIER').'Uuid')) { return redirect()->route('masuk-view-masuk'); }

		$currenturl = URL::full();
		$url = explode("/",$currenturl);
		$temp = '/'.$url[3].'/'.$url[4];

		$exist = DB::table('hak_akses')->where('pengguna_uuid', '=', Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid')))
			->where('label_link', '=', $temp)->where('delete_soft', '=', '1')->first();
		
		if ($exist) { return $next($request); }

		if ($url[4] == 'error' || $url[4] == 'forbidden' || $url[4] == 'notfound' || $url[4] == 'profile') { return $next($request); }

		$exist = DB::table('label')->where('link', '=', $temp)->first();

		if ($exist) { return Redirect::to('/dashboard/forbidden'); }
      
		return Redirect::to('/dashboard/notfound');
  }
}
