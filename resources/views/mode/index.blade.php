@use('Illuminate\Support\Str')
<x-layout>
    <x-slot:title>Modes</x-slot:title>
    <x-slot:heading>Modes</x-slot:heading>
        <x-table>
            <x-slot:linkbar>{{ $modes->links() }}</x-slot:linkbar>
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
</x-layout>