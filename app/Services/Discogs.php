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

    public function getCollection($page)
    {
        return $this->formatData($this->makeCall($page));
    }

    private function makeCall($page) 
    {
        try {
            $client = new GuzzleHttp\Client(['headers' => [ 'Authorization' => 'Discogs token='.$this->token]]);
            $res = $client->request('GET', 'https://api.discogs.com/users/'.$this->username.'/collection/folders/0/releases?page='.$page.'&per_page=15');
            $data = json_decode($res->getBody(), true);

            return $data;
        } catch (RequestException $e) {
            return false;
        }
    }

    private function formatData($data){

        if(!$data) {
            return array();
        }

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
}
?>
