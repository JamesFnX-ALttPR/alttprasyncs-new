<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class IntakeController extends Controller
{
    public function alttpr($id) {
        $urls = gatherDataUrls('alttpr', $id);
        return view('intake.alttpr', [
            'urls' => $urls
        ]);
    }
    public function ladder($id) {
        $urls = gatherDataUrls('alttpr-ladder', $id);
        return view('intake.ladder', [
            'urls' => $urls
        ]);
    }
    public function candidate($id) {
        $urls = gatherDataUrls('alttpr', $id);
        return view('intake.candidate', [
            'urls' => $urls
        ]);
    }
}