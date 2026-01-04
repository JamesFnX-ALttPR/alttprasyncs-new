<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Racer;
use App\Models\Mode;
use App\Models\Race;


class SearchController extends Controller
{
    public function search(Request $request)
    {
        $attrs = $request->validate([
            "search"=> "required"
        ]);
        $search = $attrs["search"];
        $searchLike = '%'.strval($search).'%';
        $racers = Racer::where('name', 'like', $searchLike)->withCount('result')->orderBy('name')->get();
        if($racers->count() ==1) {
            $racer = $racers->first();
            return redirect('/racer/' . $racer->id);
        } elseif($racers->count() > 1) {
            $modes = collect([]);
            $races = collect([]);
        } else {
            $modes = Mode::where('name','like', $searchLike)->withCount('race')->orderBy('name')->get();
            if($modes->count() == 1) {
                $mode = $modes->first();
                return redirect('/mode/'. $mode->id);
            } elseif($modes->count() > 0) {
                $races = collect([]);
            } else {
                $races = Race::where('description', 'like', $searchLike)->orWhere('name', 'like', $searchLike)->with('mode')->withCount('result')->orderBy('start_time', 'DESC')->get();
            }
        }
        return view('search.show', compact('search','racers','modes','races'));
    }
}