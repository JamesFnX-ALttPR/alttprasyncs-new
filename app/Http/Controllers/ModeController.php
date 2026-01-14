<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mode;
use App\Models\Race;

class ModeController extends Controller
{
    // Index
    public function index()
    {
        $modes = Mode::withCount('race')->orderBy('race_count', 'DESC')->paginate(20);
        return view('mode.index', [
            'modes' => $modes,
        ]);
    }
    
    // Show
    public function show(int $id) 
    {
        return view('mode.show', [
            'mode' => Mode::where('id', $id)->first(),
            'races' => Race::where('mode_id', $id)->withCount('result')->sortable(['start_time' => 'desc', 'result_count'])->paginate(20),
        ]);
    }
}
