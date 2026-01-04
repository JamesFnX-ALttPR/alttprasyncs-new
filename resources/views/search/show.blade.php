@use('Illuminate\Support\Str')
@use('Carbon\Carbon')
<x-layout>
    <x-slot:title>Search: {{ $search }}</x-slot:title>
    <x-slot:heading>Search Results for {{ $search }}</x-slot:heading>
@if ($racers->count() > 0)
    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Racers</h2>
    <x-table>
        <x-slot:thead>
            <tr>
                <x-table-th>Name</x-table-th>
                <x-table-th>Races</x-table-th>
            </tr>
        </x-slot:thead>
        <x-slot:tbody>
@foreach ($racers as $racer)
@if($loop->iteration % 2 != 0)
@php
$class = "bg-gray-100 border-b";
@endphp
@else
@php
$class = "bg-white border-b";
@endphp
@endif
            <tr class="{{ $class }}">
                <x-table-td :isBold="true"><x-link href="/racer/{{ $racer->id }}">{{ $racer->name }}</x-link></x-table-td>
                <x-table-td>{{ $racer->result_count }}</x-table-td>
            </tr>
@endforeach
        </x-slot:tbody>
    </x-table>
@endif
@if ($modes->count() > 0)
    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Modes</h2>
    <x-table>
        <x-slot:thead>
            <tr>
                <x-table-th>Name</x-table-th>
                <x-table-th>Description</x-table-th>
                <x-table-th>Number of Races</x-table-th>
            </tr>
        </x-slot:thead>
        <x-slot:tbody>
@foreach ($modes as $mode)
@if($loop->iteration % 2 != 0)
@php
$class = "bg-gray-100 border-b";
@endphp
@else
@php
$class = "bg-white border-b";
@endphp
@endif
            <tr class="{{ $class }}">
                <x-table-td isBold=true><x-link href="/mode/{{ $mode->id }}">{{ $mode->name }}</x-link></x-table-td>
                <x-table-td>{{ Str::limit($mode->description, 75, '...') }}</x-table-td>
                <x-table-td>{{ $mode->race_count }}</x-table-td>                        
            </tr>
@endforeach
        </x-slot:tbody>
    </x-table>
@endif
@if ($races->count() > 0)
@if (! Auth::guest() && Auth::user()->timezone != null)
@php
$dtUtc = Carbon::create(2012, 1, 1, 0, 0, 0, 'UTC');
$dtUser = Carbon::create(2012, 1, 1, 0, 0, 0, Auth::user()->timezone);
$date_label = '(GMT' . $dtUser->diffInHours($dtUtc) . ')';
@endphp
@else
@php
$date_label = '(GMT)';
@endphp
@endif
    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Races</h2>
    <x-table>
        <x-slot:thead>
            <tr>
                <x-table-th>Date {{ $date_label }}</x-table-th>
                <x-table-th>Race Name</x-table-th>
                <x-table-th>Mode</x-table-th>
                <x-table-th>Hash</x-table-th>
                <x-table-th>Download Seed</x-table-th>
                <x-table-th>Description</x-table-th>
                <x-table-th>Participants</x-table-th>
                <x-table-th>Submit Async</x-table-th>
                <x-table-th>View Results</x-table-th>
            </tr>
        </x-slot:thead>
        <x-slot:tbody>            
@foreach ($races as $race)
@if($loop->iteration % 2 != 0)
@php
$class = "bg-gray-100 border-b";
@endphp
@else
@php
$class = "bg-white border-b";
@endphp
@endif
@if (! Auth::guest() && Auth::user()->timezone != null)
@php
$race_time = new Carbon(new DateTime($race->start_time));
$race_time_string = $race_time->setTimezone(Auth::user()->timezone);
@endphp
@else
@php
$race_time_string = $race->start_time;
@endphp
@endif
            <tr class="{{ $class }}">
                <x-table-td>{{ $race_time_string }}</x-table-td>
                <x-table-td :isBold="true">
@if ($race->from_racetime == 1)
<x-link target="_blank" href="https://racetime.gg/{{ $race->name }}">{{ Str::after($race->name, '/') }}</x-link>
@else
{{ $race->name }}
@endif
                </x-table-td>
                <x-table-td :isBold="true"><x-link href="/mode/{{ $race->mode->id }}">@if($race->team_race == 1)coop @endif
@if($race->spoiler_race == 1)spoiler @endif{{ $race->mode->name }}</x-link></x-table-td>
                <x-table-td><x-hash-images hash="{{ $race->hash }}" /></x-table-td>
                <x-table-td :isBold="true"><x-link target="_blank" href="{{ $race->seed }}">Download Seed</x-link></x-table-td>
                <x-table-td>{{ Str::limit($race->description, 50, '...') }}@if($race->spoiler_race == 1 && $race->description != null) - <x-link target="_blank" href="{{ $race->spoiler_log }}">Download Spoiler Log</x-link>@elseif($race->spoiler_race == 1 && $race->description == null)<x-link target="_blank" href="{{ $race->spoiler_log }}">Download Spoiler Log</x-link>@endif</x-table-td>
                <x-table-td>{{ $race->result_count }}</x-table-td>
                <x-table-td><x-link-button href="/result/{{ $race->id }}">Submit Async</x-link-button></x-table-td>
                <x-table-td><x-link-button href="/race/{{ $race->id }}">View Results</x-link-button></x-table-td>
            </tr>
@endforeach
        </x-slot:tbody>
    </x-table>
@endif
</x-layout>