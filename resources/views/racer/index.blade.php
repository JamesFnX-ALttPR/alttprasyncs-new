<x-layout>
    <x-slot:title>ALttPR Asyncs - Racers</x-slot:title>
        <h1>Racers</h1>
        <div class="flex justify-center">
            <table class="w-full max-w-3/4 mx-auto border-collapse border border-gray-400 rounded-md">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Races</th>
                    </tr>
                </thead>
                <tbody>
@foreach ($racers as $racer)
@if($loop->iteration % 2 == 0)
@php
$class = "bg-gray-700 border border-gray-300 px-4 py-1";
@endphp
@else
@php
$class = "bg-gray-800 border border-gray-300 px-4 py-1";
@endphp
@endif
                    <tr>
                        <td class="{{ $class }}"><a class="text-blue-300 hover:underline" href="/racer/{{ $racer->id }}">{{ $racer->name }}</a></td>
                        <td class="{{ $class }}">{{ $racer->result_count }}</td>
                    </tr>
@endforeach
                </tbody>
            </table>
        </div>
        {{ $racers->links() }}
</x-layout>