@use('Illuminate\Support\Str')
<x-layout>
    <x-slot:title>ALttPR Asyncs - {{ ucfirst($mode->name) }}</x-slot:title>
    <x-slot:heading>{{ ucfirst($mode->name) }}</x-slot:heading>
        <x-table>
            <x-slot:linkbar>{{ $races->links() }}</x-slot:linkbar>
            <x-slot:thead>
                <tr>
                    <x-table-th>Date</x-table-th>
                    <x-table-th>Race Name</x-table-th>
                    <x-table-th>Mode</x-table-th>
                    <x-table-th>Hash</x-table-th>
                    <x-table-th>Download Seed</x-table-th>
                    <x-table-th>Description</x-table-th>
                    <x-table-th>Participants</x-table-th>
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
                    <tr class="{{ $class }}">
                        <x-table-td>{{ $race->start_time }}</x-table-td>
                        <x-table-td isBold=true><x-link target="_blank" href="https://racetime.gg/{{ $race->name }}">{{ Str::after($race->name, '/') }}</x-link></x-table-td>
                        <x-table-td><x-link href="/mode/{{ $race->mode->id }}">@if($race->team_race == 1)coop @endif
@if($race->spoiler_race == 1)spoiler @endif{{ $race->mode->name }}</x-link></x-table-td>
                        <x-table-td><x-hash-images hash="{{ $race->hash }}" /></x-table-td>
                        <x-table-td><x-link target="_blank" href="{{ $race->seed }}">Download Seed</x-link></x-table-td>
                        <x-table-td>{{ Str::limit($race->description, 50, '...') }}@if($race->spoiler_race == 1 && $race->description != null) - <x-link target="_blank" href="{{ $race->spoiler_log }}">Download Spoiler Log</x-link>@elseif($race->spoiler_race == 1 && $race->description == null)<x-link target="_blank" href="{{ $race->spoiler_log }}">Download Spoiler Log</x-link>@endif</x-table-td>
                        <x-table-td>{{ count($race->result) }}</x-table-td>
                        <x-table-td><x-link href="/results/{{ $race->id }}">View Results</x-link></x-table-td>
                    </tr>
@endforeach
                </x-slot:tbody>
        </x-table>
</x-layout>