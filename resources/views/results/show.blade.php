@php
$mode_info = \App\Models\Mode::where('id', $raceresult->mode_id)->first();
$mode = $mode_info->name;
$mode_desc = $mode_info->description;
$hash_array = explode(' ', $raceresult->hash);
@endphp
<x-layout>
    <x-slot:title>
        {{ $raceresult->name }}
    </x-slot:title>
        <h1>Race Results</h1>
        <p class="text-center"><strong>Results for <a class="text-blue-300 hover:underline" target="_blank" href="https://racetime.gg/{{ $raceresult->name }}">{{ $raceresult->name }}</a></strong><br />
@if ($raceresult->team_race == 1)
@include('results.team')
@else
@include('results.solo')
@endif
</x-layout>