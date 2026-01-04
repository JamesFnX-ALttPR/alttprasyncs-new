@php
$mode_info = \App\Models\Mode::where('id', $race->mode_id)->first();
$mode = $mode_info->name;
$mode_desc = $mode_info->description;
$hash_array = explode(' ', $race->hash);
@endphp
<x-layout>
    <x-slot:title>
        {{ $race->name }}
    </x-slot:title>
    <x-slot:heading>
        Results for @if ($race->from_racetime == 1)
            <x-link href="https://racetime.gg/{{ $race->name }}">{{ Str::after($race->name, '/') }}</x-link>
        @else
            {{ $race->name }}
        @endif
        @can('edit', $race)
            <x-link-button href="/race/{{ $race->id }}/edit">Edit Race</x-link-button>
        @endcan
    </x-slot:heading>
        @auth
            @if (Auth::user()->series()->count() > 0)
                <div class="flex text-center max-w-1/2">
                    <form method="POST" action="/series/add">
                        @csrf
                        
                        <input type="hidden" name="race" value="{{ $race->id }}" />
                        <select name="series">
                            <option value="">Choose Series</option>
                            @foreach(Auth::user()->series as $series)
                            <option value="{{ $series->id }}">{{ $series->description }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full max-w-1/3 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Race to Series</button>
                    </form>
                </div>
            @endif
        @endauth 
    <p class="text-center">
       
@if ($race->team_race == 1)
@include('races.team')
@else
@include('races.solo')
@endif
</x-layout>