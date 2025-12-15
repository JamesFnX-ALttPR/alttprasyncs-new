@use('Illuminate\Support\Str')
@use('Carbon\Carbon')
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
<x-layout>
    <x-slot:title>ALttPR Asyncs - {{ $racer->name }}</x-slot:title>
    <x-slot:heading>Races for {{ $racer->name }}</x-slot:heading>
        <x-table>
            <x-slot:linkbar>{{ $results->links() }}</x-slot:linkbar>
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
@foreach ($results as $result)
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
$race_time = new Carbon(new DateTime($result->race->start_time));
$race_time_string = $race_time->setTimezone(Auth::user()->timezone);
@endphp
@else
@php
$race_time_string = $result->race->start_time;
@endphp
@endif
                    <tr class="{{ $class }}">
                        <x-table-td>{{ $race_time_string }}</x-table-td>
                        <x-table-td :isBold="true">
@if ($result->race->from_racetime == 1)
<x-link target="_blank" href="https://racetime.gg/{{ $result->race->name }}">{{ Str::after($result->race->name, '/') }}</x-link>
@else
{{ $result->race->name }}
@endif
                                    </x-table-td>
                        <x-table-td :isBold="true"><x-link href="/mode/{{ $result->race->mode->id }}">@if($result->race->team_race == 1)coop @endif
@if($result->race->spoiler_race == 1)spoiler @endif{{ $result->race->mode->name }}</x-link></x-table-td>
                        <x-table-td><x-hash-images hash="{{ $result->race->hash }}" /></x-table-td>
                        <x-table-td :isBold="true"><x-link target="_blank" href="{{ $result->race->seed }}">Download Seed</x-link></x-table-td>
                        <x-table-td>{{ Str::limit($result->race->description, 50, '...') }}@if($result->race->spoiler_race == 1 && $result->race->description != null) - <x-link target="_blank" href="{{ $result->race->spoiler_log }}">Download Spoiler Log</x-link>@elseif($result->race->spoiler_race == 1 && $result->race->description == null)<x-link target="_blank" href="{{ $result->race->spoiler_log }}">Download Spoiler Log</x-link>@endif</x-table-td>
                        <x-table-td>{{ count($result->race->result) }}</x-table-td>
                        <x-table-td :isBold="true"><x-link href="/result/{{ $result->race->id }}">Submit Async</x-link></x-table-td>
                        <x-table-td :isBold="true"><x-link href="/race/{{ $result->race->id }}">View Results</x-link></x-table-td>
                    </tr>
@endforeach
                </x-slot:tbody>
        </x-table>
</x-layout>