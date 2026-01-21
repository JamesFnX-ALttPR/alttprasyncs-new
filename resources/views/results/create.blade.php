@use('Illuminate\Support\Str')
@use('Illuminate\Support\Facades\DB')
@use('App\Models\User')
@php
$mode_info = \App\Models\Mode::where('id', $race->mode_id)->first();
$mode = $mode_info->name;
$mode_desc = $mode_info->description;
$hash_array = explode(' ', $race->hash);
$racer_list = DB::table('racers')->join('results', 'racers.id', '=', 'results.racer_id')->select('racers.name', 'results.from_racetime')->where('results.race_id', $race->id)->orderBy(DB::raw('LOWER(racers.name)'))->get();
if ($race->team_race == 1) {
    $racer_team_list = DB::table('racers')->join('results', 'racers.id', '=', 'results.racer_id')->select('racers.name', 'results.team')->where('results.race_id', $race->id)->orderBy('results.team')->orderBy(DB::raw('LOWER(racers.name)'))->get();
}
@endphp
<x-layout>
    <x-slot:title>Submit Result for {{ Str::after( $race->name, '/') }}</x-slot:title>
    <x-slot:heading>Submit Result for {{ $race->name }}</x-slot:heading>
    <p>{{ $race->description }}</p>
    <p><x-link target="_blank" href="{{ $race->seed }}">Download Seed</x-link></p>
    <p>@if ($race->spoiler_race)spoiler - @endif{{ $race->mode->name }}@if ($race->mode->description != null) - {{ $race->mode->description }}@endif</p>
    @if ($race->spoiler_race)<p><x-link target="_blank" href="{{ $race->spoiler_log }}">Download Spoiler Log</x-link></p>@endif
    <p><x-hash-images size="30" hash="{{ $race->hash }}" /></p>
@if($race->team_race == 1)
@include('results.create_team')
@else
@include('results.create_solo')
@endif
</x-layout>