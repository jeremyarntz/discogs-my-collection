<?php

namespace App\Models;

use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;

class Discogs {

  public static function getCollection($username, $token, $page){
    try {

      $client = new GuzzleHttp\Client(['headers' => [ 'Authorization' => 'Discogs token='.$token]]);
      $res = $client->request('GET', 'https://api.discogs.com/users/'.$username.'/collection/folders/0/releases?page='.$page.'&per_page=12');
      $data = json_decode($res->getBody(), true);

      return self::formatData($data);

    } catch (RequestException $e) {
      return false;
    }
  }

  private static function formatData($data){
    $fomattedData = array();

    // pagination
    $fomattedData['page'] = $data['pagination']['page'];
    $fomattedData['pages'] = $data['pagination']['pages'];

    // releases
    $fomattedData['releases'] = array();
    foreach($data['releases'] AS $release) {
      $formattedRelease = array();

      $formattedRelease['title'] = $release['basic_information']['title'];
      $formattedRelease['thumb'] = $release['basic_information']['thumb'];
      $formattedRelease['year'] = $release['basic_information']['year'];

      $artistString = '';
      foreach ($release['basic_information']['artists'] AS $artist) {
        $artistString = $artistString.$artist['name'].',';
      }

      $formattedRelease['artists'] = rtrim($artistString,',');
      $fomattedData['releases'][] = $formattedRelease;
    }

    return $fomattedData;
  }
}
?>
