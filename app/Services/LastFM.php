<?php

namespace App\Services;

use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;

class Lastfm {

	private $username;
	private $key;
	private $data;
	private $type;

	function __construct($username, $key) {
		$this->username = $username;
		$this->key = $key;
	}

	public function getRecent($page)
	{
      $this->data = $this->makeCall('getRecentTracks', $page);
      $this->type = 'recenttracks';

      //return $this->formatData($data, 'recenttracks');;
	}

	public function getTopAlbums($page)
	{
      $this->data = $this->makeCall('getTopAlbums', $page);
      $this->type = 'topalbums';

      //return $this->formatData($data, 'topalbums');
	}

	public function getTopArtists($page)
	{
      $this->data = $this->makeCall('gettopartists', $page);
      $this->type = 'topartists';
      
      // return $this->formatData($data, 'topartists');
	}

	public function getTopTracks($page)
	{
      $this->data = $this->makeCall('getTopTracks', $page);
      $this->type = 'toptracks';

      //return $this->formatData($data, 'toptracks');
	}

	public function getFormattedData()
	{
		return $this->formatData();
	}

	private function makeCall($type, $page)
	{
		try {
			$client = new GuzzleHttp\Client();
		  	$res = $client->request('GET', 'http://ws.audioscrobbler.com/2.0/?method=user.'.$type.'&user='.$this->username.'&api_key='.$this->key.'&period=7day&page='.$page.'&limit=15&format=json');
		  	return json_decode($res->getBody(), true);
      	} catch (RequestException $e) {
      		return false;
    	}
	}

	private function formatData()
	{
		switch ($this->type) {
			case 'recenttracks':

				$returnData = [];
				foreach($this->data['recenttracks']['track'] AS $tracks) {
					$returnData['data'][] = array(	'name' => $tracks['name'],
													'url' => $tracks['url'],
													'album'	=> $tracks['album']['#text'],
													'image' => $tracks['image'][1]['#text'],
													'artist' => array('name' => $tracks['artist']['#text'])
												);					
				}

				$returnData['pagination'] = array(	'page' => $this->data['recenttracks']['@attr']['page'],
													'perPage' => $this->data['recenttracks']['@attr']['perPage'],
													'totalPages' => $this->data['recenttracks']['@attr']['totalPages']
												);
						

				return $returnData;

			case 'topalbums':

				$returnData = [];

				foreach($this->data['topalbums']['album'] AS $albums) {
					$returnData['data'][] = array(	'name' => $albums['name'],
													'playcount' => $albums['playcount'],
													'url'	=> $albums['url'],
													'image' => $albums['image'][1]['#text'],
													'artist' => array(	'name' => $albums['artist']['name'],
																			'url' => $albums['artist']['url']
																	)
												);
				}


				$returnData['pagination'] = array(	'page' => $this->data['topalbums']['@attr']['page'],
													'perPage' => $this->data['topalbums']['@attr']['perPage'],
													'totalPages' =>$this->data['topalbums']['@attr']['totalPages']
												);

				return $returnData;

			case 'topartists':

				$returnData = [];

				foreach($this->data['topartists']['artist'] AS $artist) {
					$returnData['data'][] = array(	'name' => $artist['name'],
													'playcount' => $artist['playcount'],
													'url'	=> $artist['url'],
													'image' => $artist['image'][1]['#text']
												);
				}


				$returnData['pagination'] = array(	'page' => $this->data['topartists']['@attr']['page'],
													'perPage' => $this->data['topartists']['@attr']['perPage'],
													'totalPages' => $this->data['topartists']['@attr']['totalPages']
												);

				return $returnData;

			case 'toptracks':

				$returnData = [];
				
				foreach($this->data['toptracks']['track'] AS $tracks) {
					$returnData['data'][] = array(	'name' => $tracks['name'],
													'url' => $tracks['url'],
				 									'image' => $tracks['image'][1]['#text'],
				 									'playcount' => $tracks['playcount'],
				 									'artist' => array('name' => $tracks['artist']['name'])
												);					
				}

				$returnData['pagination'] = array(	'page' => $this->data['toptracks']['@attr']['page'],
				 									'perPage' => $this->data['toptracks']['@attr']['perPage'],
				 									'totalPages' =>$this->data['toptracks']['@attr']['totalPages']
				 								);
						

				return $returnData;
		}
	}
}