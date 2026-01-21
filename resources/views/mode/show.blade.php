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
    <x-slot:title>{{ ucfirst($mode->name) }}</x-slot:title>
    <x-slot:heading>{{ ucfirst($mode->name) }}</x-slot:heading>
        <form method="GET" action="/mode/{{ $mode->id }}">
            <div class="grid grid-cols-2 justify-center w-100 mx-auto gap-4 place-items-center">
                <div class="shrink">
                    <select id="excludeRacer" name="excludeRacer">
                        <option value=""></option>
@foreach($racers as $racer)
                        <option value="{{ $racer->id }}">{{ $racer->name }}</option>
@endforeach
                    </select>
                </div>
                <div class="shrink">
                    <x-form-button>Exclude Racer</x-form-button>
                </div>
            </div>
        </form>
        <x-table>
            <x-slot:linkbar>{{ $races->links() }}</x-slot:linkbar>
            <x-slot:thead>
                <tr>
                    <x-table-th>
                        <span class="text-blue-700 font-semibold hover:underline">@sortablelink('start_time', 'Date')</span> {{ $date_label }}
                    </x-table-th>
                    <x-table-th>Name</x-table-th>
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
                        <x-table-td :isBold="true">
@if ($race->from_racetime == 1)
<x-link target="_blank" href="https://racetime.gg/{{ $race->name }}">{{ Str::after($race->name, '/') }}</x-link>
@else
{{ $race->name }}
@endif
                        </x-table-td>
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