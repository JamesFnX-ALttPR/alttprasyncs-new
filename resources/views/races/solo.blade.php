@if($race->description != null)
{{ $race->description }}<br />
@endif
<x-hash-images size="30" hash="{{ $race->hash }}" /><br />
<x-link target="_blank" href="{{ $race->seed }}">Download Seed</x-link><br />
<x-link href="/mode/{{ $race->mode_id }}">{{ $mode }}</x-link>@if($mode_desc != null) - {{ $mode_desc }}@endif<br />
@if($race->spoiler_race == 1)
<br /><a target="_blank" href="{{ $race->spoiler_log }}">Link to Spoiler</a><br />
@endif
@if($race->result_avg_time != null)
Average Time - {{ date("G:i:s", $race->result_avg_time) }}</p><hr />
@endif

        <x-table>
            <x-slot:thead>
                <tr>
                    <x-table-th>Place</x-table-th>
                    <x-table-th>Name</x-table-th>
                    <x-table-th>Time</x-table-th>
                    <x-table-th>Comments</x-table-th>
                </tr>
            </x-slot:thead>
            <x-slot:tbody>
@foreach ($race->result as $result)
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
                    <x-table-td>{{ $loop->iteration }}</x-table-td>
                    <x-table-td><x-link href="/racer/{{ $result->racer->id }}">{{ $result->racer->name }}</x-link></x-table-td>
                    <x-table-td>@if ($result->forfeit == 1)Forfeit @else{{ date("G:i:s", $result->time) }}@endif</x-table-td>
                    <x-table-td>{{ $result->comment }}</x-table-td>
                </tr>
                @endforeach
            </x-slot:tbody>
        </x-table>