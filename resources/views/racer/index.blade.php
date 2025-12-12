<x-layout>
    <x-slot:title>ALttPR Asyncs - Racers</x-slot:title>
    <x-slot:heading>Racers</x-slot:heading>
    <x-table>
        <x-slot:linkbar>{{ $racers->links() }}</x-slot:linkbar>
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
                <x-table-td isBold=true><x-link href="/racer/{{ $racer->id }}">{{ $racer->name }}</x-link></x-table-td>
                <x-table-td>{{ $racer->result_count }}</x-table-td>
            </tr>
@endforeach
        </x-slot:tbody>
    </x-table>
</x-layout>