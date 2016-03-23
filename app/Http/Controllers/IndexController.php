<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Config;
//use Cache;
use \App\Models\Discogs;

class IndexController extends Controller
{
  public function index($page=1)
  {
    $username = Config::get('discogs.username');
    $token = Config::get('discogs.token');
    $data = Discogs::getCollection($username, $token, $page);

    if ($data) {
      return view('index', ['releases' => $data]);
    }else{
      return view('error');
    }
  }
}
