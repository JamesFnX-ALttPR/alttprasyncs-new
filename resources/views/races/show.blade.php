@php
$mode_info = \App\Models\Mode::where('id', $race->mode_id)->first();
$mode = $mode_info->name;
$mode_desc = $mode_info->description;
$hash_array = explode(' ', $race->hash);
@endphp
<x-layout>
    <x-slot:title>
        ALttPR Asyncs - {{ $race->name }}
    </x-slot:title>
    <x-slot:heading>
        Results for @if ($race->from_racetime == 1)
            <x-link href="https://racetime.gg/{{ $race->name }}">{{ Str::after($race->name, '/') }}</x-link>
        @else
            {{ $race->name }}
        @endif
    </x-slot:heading>
        
        <p class="text-center">
@if ($race->team_race == 1)
@include('races.team')
@else
@include('races.solo')
@endif
</x-layout>