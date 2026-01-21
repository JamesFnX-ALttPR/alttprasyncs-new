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
    <x-slot:title>{{ $racer->name }}</x-slot:title>
    <x-slot:heading>Races for {{ $racer->name }}</x-slot:heading>
        <x-table>
            <x-slot:linkbar>{{ $races->links() }}</x-slot:linkbar>
            <x-slot:thead>
                <tr>
                    <x-table-th>
                        <div class="text-blue-700 font-semibold hover:underline">
                            @sortablelink('start_time', 'Date') {{ $date_label }}
                        </div>
                    </x-table-th>   
                    <x-table-th>Mode</x-table-th>
                    <x-table-th>Hash</x-table-th>
                    <x-table-th>Download Seed</x-table-th>
                    <x-table-th>Description</x-table-th>
                    <x-table-th>
                        <div class="text-blue-700 font-semibold hover:underline">
                            @sortablelink('result_count', 'Participants')
                        </div>
                    </x-table-th>
                    <x-table-th></x-table-th>
                    <x-table-th></x-table-th>
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
                        <x-table-td :isBold="true"><x-link href="/mode/{{ $race->mode->id }}">@if($race->team_race == 1)coop @endif
@if($race->spoiler_race == 1)spoiler @endif{{ $race->mode->name }}</x-link></x-table-td>
                        <x-table-td><x-hash-images hash="{{ $race->hash }}" /></x-table-td>
                        <x-table-td :isBold="true"><x-link target="_blank" href="{{ $race->seed }}">Download Seed</x-link></x-table-td>
                        <x-table-td>{{ Str::limit($race->description, 50, '...') }}@if($race->spoiler_race == 1 && $race->description != null) - <x-link target="_blank" href="{{ $race->spoiler_log }}">Download Spoiler Log</x-link>@elseif($race->spoiler_race == 1 && $race->description == null)<x-link target="_blank" href="{{ $race->spoiler_log }}">Download Spoiler Log</x-link>@endif</x-table-td>
                        <x-table-td>{{ count($race->result) }}</x-table-td>
                        <x-table-td :isBold="true"><x-link-button href="/result/{{ $race->id }}">Submit Async</x-link-button></x-table-td>
                        <x-table-td :isBold="true"><x-link-button href="/race/{{ $race->id }}">View Results</x-link-button></x-table-td>
                    </tr>
@endforeach
                </x-slot:tbody>
        </x-table>
</x-layout>