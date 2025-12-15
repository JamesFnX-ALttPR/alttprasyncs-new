<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Series;
use App\Models\User;

class SeriesController extends Controller
{
    public function index() {
        $series = Series::withCount('races')->orderBy('races_count')->paginate(20);
        return view('series.index',[
            'series' => $series
        ]);
    }
    public function show(Series $series) {
        $series->load('races');
        return view('series.show',[
            'series' => $series,
            'races' => $series->races()->orderBy('start_time', 'DESC')->paginate(20)
        ]);

    }
    public function create()
    {
        $races = \App\Models\Race::where('user_id', Auth::user()->id)->with('mode')->get();
        return view('series.create', [
            'races' => $races
        ]);
    }

    public function store(Request $request) {
        $attrs = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'races.*' => ['nullable']
        ]);
        
        $series = Series::create([
            'name'=> $attrs['name'],
            'description'=> $attrs['description'],
            'user_id' => Auth::user()->id
        ]);
        
        $series->users()->attach($series->user_id);
        foreach($attrs['races'] as $key => $value) {
            $series->races()->attach($key);
        }

        return redirect('/races/');
    }
    public function append(Request $request) {
        $attrs = $request->validate([
            'race' => ['required', 'numeric'],
            'series' => ['required', 'numeric']
        ]);
        $series = Series::find($attrs['series']);
        if ($series->users()->find(Auth::user()->id)) {
            $series->races()->attach($attrs['race']);
            return redirect('/series/' . $attrs['series']);
        } else {
            abort(403);
        }
    }
    public function edit(Series $series) {
        $races = $series->races()->orderBy('start_time', 'DESC')->get();
        $users = User::whereNot('id', $series->user_id)->get();
        return view('series.edit', [
            'series' => $series,
            'races' => $races,
            'users' => $users
        ]);
    }
    public function update(Request $request, Series $series) {
        $attrs = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'editors.*' => ['nullable'],
            'races.*' => ['nullable']
        ]);
        
        $series->update([
            'name' => $attrs['name'],
            'description'=> $attrs['description']
        ]);
        if (array_key_exists('races', $attrs)) {
            foreach($attrs['races'] as $key => $value) {
                $series->races()->detach($key);
            }
        }
        $series->users()->detach();
        $series->users()->attach($series->user_id);
        if(array_key_exists('editors', $attrs)) {
            foreach($attrs['editors'] as $key => $value) {
                $series->users()->attach($value);
            }
        }
        return redirect('/series/' . $series->id);
    }
    public function destroy($series) {
        // authorize
        
        $series = Series::findOrFail($series);
        $series->delete();
        return redirect('/series');
    }
}
