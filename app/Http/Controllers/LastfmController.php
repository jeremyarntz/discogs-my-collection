<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Config;

use \App\Services\Lastfm;

class LastfmController extends Controller
{

  private $lastfm;

  function __construct()
  {
    $username = Config::get('lastfm.username');
    $key = Config::get('lastfm.key');

    $this->lastfm = new Lastfm($username, $key);
  }

  public function recent($page=1)
  {
    $this->lastfm->getRecent($page);
    $data = $this->lastfm->getFormattedData();
    // dd($data);
    if (!$data) {
      return view('error');
    }

    return view('recent', ['data' => $data]);
  }

  public function albums($page=1)
  {
    $this->lastfm->getTopAlbums($page);
    $data = $this->lastfm->getFormattedData();
    // dd($data);

    if (!$data) {
      return view('error');
    }

    return view('albums', ['data' => $data]);
  }

  public function artists($page=1)
  {
    $this->lastfm->getTopArtists($page);
    $data = $this->lastfm->getFormattedData();
    // dd($data);


    if (!$data) {
      return view('error');
    }

    return view('artists', ['data' => $data]);
  }

  public function tracks($page=1)
  {
    $this->lastfm->getTopTracks($page);
    $data = $this->lastfm->getFormattedData();
    // dd($data);

    if (!$data) {
      return view('error');
    }

    return view('tracks', ['data' => $data]);
  }
}
