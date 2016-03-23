<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;
use Config;
use Cache;

class IndexController extends Controller
{
  public function index($page=1)
  {
    try {
      //echo $page;
      // TODO: Not sure I really need caching
      // will have to check for changes in pagination
      // to make it work

      // if (Cache::has('data')) {
      //   echo 'cached<br />';
      //   $data = Cache::get('data');

      // } else {
        // echo 'api<br />';
        $username = Config::get('discogs.username');
        $token = Config::get('discogs.token');

        $client = new GuzzleHttp\Client(['headers' => [ 'Authorization' => 'Discogs token='.$token]]);

        $res = $client->request('GET', 'https://api.discogs.com/users/'.$username.'/collection/folders/0/releases?page='.$page);

      //   Cache::put('data', $data, 30);
      // }
        // echo '<pre>';
        // var_dump($data['releases']);
        // echo '</pre>';
    } catch (RequestException $e) {
      return view('error', ['error' => $e->getMessage()]);
    }

    $data = json_decode($res->getBody(), true);
    return view('index', ['releases' => $data['releases']]);
  }
}
