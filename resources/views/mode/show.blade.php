@use('Illuminate\Support\Str')
<x-layout>
    <x-slot:title>ALttPR Asyncs - {{ ucfirst($mode->name) }}</x-slot:title>
        <h1>{{ ucfirst($mode->name) }} Races</h1>
        {{ $races->links() }}
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
@foreach ($races as $race)
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
$hash_images = \App\Http\Controllers\RacetimeController::hashToImages($race->hash);
@endphp
                    <tr>
                        <td class="{{ $class }}">{{ $race->start_time }}</td>
                        <td class="{{ $class }}"><a class="text-blue-300 hover:underline" target="_blank" href="https://racetime.gg/{{ $race->name }}">{{ Str::after($race->name, '/') }}</a></td>
                        <td class="{{ $class }}">@if($race->team_race == 1)coop @endif
@if($race->spoiler_race == 1)spoiler @endif{{ $mode->name }}</td>
                        <td class="{{ $class }}">{!! $hash_images !!}</td>
                        <td class="{{ $class }}"><a class="text-blue-300 hover:underline" target="_blank" href="{{ $race->seed }}">Download Seed</a></td>
                        <td class="{{ $class }}">{{ Str::limit($race->description, 50, '...') }}@if($race->spoiler_race == 1 && $race->description != null) - <a target="_blank" class="text-blue-300 hover:underline" href="{{ $race->spoiler_log }}">Download Spoiler Log</a>@elseif($race->spoiler_race == 1 && $race->description == null)<a target="_blank" class="text-blue-300 hover:underline" href="{{ $race->spoiler_log }}">Download Spoiler Log</a>@endif</td>
                        <td class="{{ $class }}">{{ $race->result_count }}</td>
                        <td class="{{ $class }}"><a class="text-blue-300 hover:underline" href="/results/{{ $race->id }}">View Results</a></td>
                    </tr>
@endforeach
                </tbody>
            </table>
        </div>
</x-layout>