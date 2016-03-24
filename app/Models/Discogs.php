<?php

namespace App\Models;

use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;

class Discogs {

  public static function getCollection($username, $token, $folder, $page){

    $data = self::getFolderCollection($username, $token, $folder, $page);
    $folderData = self::getFolders($username, $token);

    if (!$data || !$folderData) {
      return false;
    }

    return array( 'folders' => self::formatFolderData($folderData),
                  'collection' => self::formatCollectionData($data, $folder)
                );
  }

  public static function getFolderCollection($username, $token, $folder, $page){
    $url = 'https://api.discogs.com/users/'.$username.'/collection/folders/'.$folder.'/releases?page='.$page.'&per_page=25';
    return self::makeApiCall($token, $url);
  }

  public static function getFolders($username, $token){
    $url = 'https://api.discogs.com/users/'.$username.'/collection/folders';
    return self::makeApiCall($token, $url);
  }

  private static function formatCollectionData($data, $folder){
    $fomattedData = array();

    // pagination
    $fomattedData['page'] = $data['pagination']['page'];
    $fomattedData['pages'] = $data['pagination']['pages'];
    $fomattedData['folder'] = $folder;

    // releases
    $fomattedData['releases'] = array();
    foreach($data['releases'] AS $release) {
      $formattedRelease = array();

      $formattedRelease['title'] = $release['basic_information']['title'];
      $formattedRelease['thumb'] = $release['basic_information']['thumb'];

      if ($release['basic_information']['year'] === 0) {
        $formattedRelease['year'] = '';
      } else {
        $formattedRelease['year'] = $release['basic_information']['year'];
      }

      $artistString = '';
      foreach ($release['basic_information']['artists'] AS $artist) {
        $artistString = $artistString.$artist['name'].', ';
      }

      $formattedRelease['artists'] = rtrim($artistString,', ');
      $fomattedData['releases'][] = $formattedRelease;
    }

    return $fomattedData;
  }

  private static function formatFolderData($folders){

    // removing the uncatagorized folder.
    foreach($folders['folders'] AS $key => $folder){
      if($folder['id'] === 1) {
        unset($folders['folders'][$key]);
      }
    }

    return $folders['folders'];
  }

  public static function makeApiCall($token, $url){
    try {

      $client = new GuzzleHttp\Client(['headers' => [ 'Authorization' => 'Discogs token='.$token]]);
      $res = $client->request('GET', $url);
      $data = json_decode($res->getBody(), true);

      return $data;

    } catch (RequestException $e) {
      return false;
    }
  }
}
?>
