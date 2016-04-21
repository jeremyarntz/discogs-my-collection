<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Config;
//use Cache;
use \App\Services\Discogs;

class IndexController extends Controller
{

  private $discogs;

  function __construct()
  {
    $username = Config::get('discogs.username');
    $token = Config::get('discogs.token');

    $this->discogs = new Discogs($token, $username);
  }

  public function index($page=1)
  {

    $data = $this->discogs->getCollection($page);

    if ($data) {
      return view('index', ['releases' => $data]);
    }else{
      return view('error');
    }
  }
}
