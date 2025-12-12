<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PracticeController extends Controller
{
    public static function gatherAlttprURLs(int $page)
    {
        $url = "https://racetime.gg/alttpr/races/data?page=". $page;
        $data = Http::get($url);
        $json = json_decode($data, true);
        $url_array = [];
        foreach ($json["races"] as $key => $value) {
            array_unshift($url_array, "https://racetime.gg" . $value["data_url"]);
        }
        return $url_array;
    }
}