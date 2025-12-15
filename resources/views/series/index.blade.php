<x-layout>
    <x-slot:title>ALttPR Asyncs - Series</x-slot:title>
    <x-slot:heading>Series</x-slot:heading>
    <x-table>
        <x-slot:linkbar>{{ $series->links() }}</x-slot:linkbar>
        <x-slot:thead>
            <tr>
                <x-table-th>Name</x-table-th>
                <x-table-th>Description</x-table-th>
                <x-table-th>Races</x-table-th>
            </tr>
        </x-slot:thead>
        <x-slot:tbody>
@foreach ($series as $item)
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
                <x-table-td isBold=true><x-link href="/series/{{ $item->id }}">{{ $item->name }}</x-link></x-table-td>
                <x-table-td>{{ $item->description }}</x-table-td>
                <x-table-td>{{ $item->races_count }}</x-table-td>
            </tr>
@endforeach
        </x-slot:tbody>
    </x-table>
</x-layout>