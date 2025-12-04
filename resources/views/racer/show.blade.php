@use('Illuminate\Support\Str')
<x-layout>
    <x-slot:title>ALttPR Asyncs - {{ $racer->name }}</x-slot:title>
        <h1>Races for {{ $racer->name }}</h1>
        <div class="flex justify-center">
            <table class="w-full mx-auto border-collapse border border-gray-400 rounded-md">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Date</th>
                        <th class="border border-gray-300 px-4 py-2">Race Name</th>
                        <th class="border border-gray-300 px-4 py-2">Mode</th>
                        <th class="border border-gray-300 px-4 py-2">Hash</th>
                        <th class="border border-gray-300 px-4 py-2">Download Seed</th>
                        <th class="border border-gray-300 px-4 py-2">Description</th>
                        <th class="border border-gray-300 px-4 py-2">Participants</th>
                        <th class="border border-gray-300 px-4 py-2">View Results</th>
                    </tr>
                </thead>
                <tbody>
@foreach ($results as $result)
@if($loop->iteration % 2 == 0)
@php
$class = "bg-gray-700 border border-gray-300 px-4 py-1";
@endphp
@else
@php
$class = "bg-gray-800 border border-gray-300 px-4 py-1";
@endphp
@endif
@php
$hash_images = \App\Http\Controllers\RacetimeController::hashToImages($result->race->hash);
@endphp
                    <tr>
                        <td class="{{ $class }}">{{ $result->race->start_time }}</td>
                        <td class="{{ $class }}"><a class="text-blue-300 hover:underline" target="_blank" href="https://racetime.gg/{{ $result->race->name }}">{{ Str::after($result->race->name, '/') }}</a></td>
                        <td class="{{ $class }}"><a class="text-blue-300 hover:underline" href="/mode/{{ $result->race->mode->id }}">@if($result->race->team_race == 1)coop @endif
@if($result->race->spoiler_race == 1)spoiler @endif{{ $result->race->mode->name }}</a></td>
                        <td class="{{ $class }}">{!! $hash_images !!}</td>
                        <td class="{{ $class }}"><a class="text-blue-300 hover:underline" target="_blank" href="{{ $result->race->seed }}">Download Seed</a></td>
                        <td class="{{ $class }}">{{ $result->race->description }}@if($result->race->spoiler_race == 1 && $result->race->description != null) - <a target="_blank" class="text-blue-300 hover:underline" href="{{ $result->race->spoiler_log }}">Download Spoiler Log</a>@elseif($result->race->spoiler_race == 1 && $result->race->description == null)<a target="_blank" class="text-blue-300 hover:underline" href="{{ $result->race->spoiler_log }}">Download Spoiler Log</a>@endif</td>
                        <td class="{{ $class }}">{{ count($result->race->result) }}</td>
                        <td class="{{ $class }}"><a class="text-blue-300 hover:underline" href="/results/{{ $result->race->id }}">View Results</a></td>
                    </tr>
@endforeach
                </tbody>
            </table>
        </div>
        {{ $results->links() }}
</x-layout>