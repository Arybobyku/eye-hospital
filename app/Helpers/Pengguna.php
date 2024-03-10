<?php

namespace App\Helpers;

use Ramsey\Uuid\Uuid;
use App\Models\LogPengguna;
use App\Models\HakAkses;
use Crypt;
use Cookie;

class Pengguna
{

	public static function acl() {
		if (!Cookie::has(env('APP_IDENTIFIER').'Uuid')) { return '419'; }
		return 'next';
	}

	public static function log($message)
	{
		date_default_timezone_set("Asia/Jakarta");
        
    $uuid = ''; $loop = false;
    do {
      $uuid = Uuid::uuid4();
      $check = LogPengguna::where('uuid', '=', $uuid)->first();
      if (!$check) { $loop = true; }
    }while($loop == false);

    $item = new LogPengguna();
    $item->uuid = $uuid;
    $item->pengguna_uuid = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Uuid'));
    $item->nama = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Nama'));
  	$item->username = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Username'));
    $item->posisi = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Posisi'));
  	$item->sebagai = Crypt::decrypt(Cookie::get(env('APP_IDENTIFIER').'Sebagai'));
    $item->tindakan = $message;
    $item->created_at = date('Y-m-d H:i:s');
    $item->save();
	}

	public static function track($data) {
		
	}
}

// Cara memanggilnya : PenggunaHelp::get_username(1);