<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ItunesController extends Controller
{
    public function index(){
        $url = 'https://rss.applemarketingtools.com/api/v2/be/music/most-played/12/songs.json';
        $response = Http::get($url)->json();
        $tracks = $response['feed'];
        $tracks = json_decode(collect($tracks));
        $results = compact('tracks');
        return view('itunes', $results);
    }
}
