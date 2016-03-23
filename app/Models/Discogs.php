<?php

namespace App\Models;

use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;

class Discogs {

  public static function getMyData($username, $token, $page){
    try {

      $client = new GuzzleHttp\Client(['headers' => [ 'Authorization' => 'Discogs token='.$token]]);

      $res = $client->request('GET', 'https://api.discogs.com/users/'.$username.'/collection/folders/0/releases?page='.$page);

      return json_decode($res->getBody(), true);;

    } catch (RequestException $e) {
      return false;
    }
  }
}

?>
