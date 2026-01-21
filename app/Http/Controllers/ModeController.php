<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mode;
use App\Models\Race;
use App\Models\Racer;
use Illuminate\Support\Facades\DB;

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
        
        $races = DB::table('races')->where('mode_id', $id)->select('id');
        if (isset ($_GET['excludeRacer'])) {
            $excludeRacer = intval($_GET['excludeRacer']);
            $resultsExclude = DB::table('results')->where('racer_id', $excludeRacer)->whereIn('race_id', $races)->select('race_id');
            $racesToDisplay = Race::where('mode_id', $id)->whereNotIn('id', $resultsExclude)->withCount('result')->sortable(['start_time' => 'desc', 'result_count'])->paginate(20);
        } else {
            $racesToDisplay = Race::where('mode_id', $id)->withCount('result')->sortable(['start_time' => 'desc', 'result_count'])->paginate(20);
        }
        $results = DB::table('results')->whereIn('race_id', $races)->select('racer_id');
        $racers = Racer::wherein('id', $results)->orderBy(DB::raw('LOWER("name")'))->get();
        return view('mode.show', [
            'mode' => Mode::where('id', $id)->first(),
            'races' => $racesToDisplay,
            'racers' => $racers,
        ]);
    }
}
