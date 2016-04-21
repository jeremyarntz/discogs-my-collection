<?php

namespace App\Services;

use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;

class Discogs {

    private $token;
    private $username;

    function __construct($token, $username)
    {
        $this->token = $token;
        $this->username = $username;
    }

    public function getCollection($folder, $page)
    {
        $data = $this->getFolderCollection($folder, $page);
        $folderData = $this->getFolders();

        if (!$data || !$folderData) {
          return false;
        }

        return array(   'folders' => $this->formatFolderData($folderData),
                        'collection' => $this->formatCollectionData($data, $folder)
                    );
    }

    public function getFolderCollection($folder, $page){
        $url = 'https://api.discogs.com/users/'.$this->username.'/collection/folders/'.$folder.'/releases?page='.$page.'&per_page=25';
        $url = $url.'&sort=artist';
        return $this->makeCall($url);
    }

    public function getFolders(){
        $url = 'https://api.discogs.com/users/'.$this->username.'/collection/folders';
        return $this->makeCall($url);
    }

    private function makeCall($url) 
    {
        try {
            $client = new GuzzleHttp\Client(['headers' => [ 'Authorization' => 'Discogs token='.$this->token]]);
            $res = $client->request('GET', $url);
            $data = json_decode($res->getBody(), true);

            return $data;

        } catch (RequestException $e) {
            return false;
        }
    }

    private function formatCollectionData($data, $folder){

        if(!$data) {
            return array();
        }

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

            // year
            if ($release['basic_information']['year'] === 0) {
                $formattedRelease['year'] = '';
            } else {
                $formattedRelease['year'] = $release['basic_information']['year'];
             }

            // artists
            $artistString = '';
            foreach ($release['basic_information']['artists'] AS $artist) {
                $artistString = $artistString.$artist['name'].', ';
            }
            $formattedRelease['artists'] = rtrim($artistString,', ');

            // formats
            $formatString = '';
            foreach ($release['basic_information']['formats'] AS $formats) {
                foreach($formats['descriptions'] AS $description){
                    $formatString = $formatString.$description.' ';
                }
                $formatString = rtrim($formatString, ' ');
                $formatString = $formatString.', ';
            }
            $formattedRelease['format'] = rtrim($formatString,', ');

            $fomattedData['releases'][] = $formattedRelease;
        }

        return $fomattedData;
    }

    private function formatFolderData($folders){

        // removing the uncatagorized folder.
        foreach($folders['folders'] AS $key => $folder){
            if($folder['id'] === 1) {
                unset($folders['folders'][$key]);
            }
        }

        return $folders['folders'];
    }
}
?>
