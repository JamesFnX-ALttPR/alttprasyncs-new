@use('Illuminate\Support\Str')
<x-layout>
    <x-slot:title>ALttPR Asyncs - Results for {{ Auth::user()->display_name }}</x-slot:title>
    <x-slot:heading>Results for {{ Auth::user()->display_name }}</x-slot:heading>
        <x-table>
            <x-slot:linkbar>{{ $results->links() }}</x-slot:linkbar>
                <x-slot:thead>
                    <tr>
                        <x-table-th>Race Name</x-table-th>
                        <x-table-th>Your Time</x-table-th>
                        <x-table-th>Collection Rate</x-table-th>
                        <x-table-th>Link to VOD</x-table-th>
                        <x-table-th colspan="3">Comment</x-table-th>
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
                    <tr class="{{ $class }}">
                        <x-table-td :isBold="true"><x-link href="/race/{{ $result->race->id }}">{{ $result->race->name }}</x-link></x-table-td>
                        <x-table-td :isBold="true">@if ($result->forfeit == 1)Forfeit @else{{ date("G:i:s", $result->time) }}@endif</x-table-td>
                        <x-table-td>@if ($result->forfeit == 1)N/A @else{{ $result->cr }}@endif</x-table-td>
                        <x-table-td :isBold="true">@if ($result->forfeit == 1)N/A @else<x-link href="{{ $result->vod }}">{{ $result->vod }}</x-link>@endif</x-table-td>
                        <x-table-td>{{ $result->comment }}</x-table-td>
                        <x-table-td><x-link-button href="/result/{{ $result->id }}/edit">Edit</x-link-button></x-table-td>
                        <x-table-td>
                            <form method="POST" action="/result/{{ $result->id }}">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="w-auto text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete</button>
                            </form>
                        </x-table-td>
                    </tr>
@endforeach
                </x-slot:tbody>
        </x-table>
</x-layout>