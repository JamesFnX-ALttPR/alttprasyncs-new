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
@php
$mode_info = \App\Models\Mode::where('id', $race->mode_id)->first();
$mode = $mode_info->name;
$mode_desc = $mode_info->description;
$hash_array = explode(' ', $race->hash);
@endphp
<x-layout>
    <x-slot:title>
        {{ $race->name }}
    </x-slot:title>
    <x-slot:heading>
        Results for @if ($race->from_racetime == 1)
            <x-link target="_blank" href="https://racetime.gg/{{ $race->name }}">{{ Str::after($race->name, '/') }}</x-link>
        @else
            {{ $race->name }}
        @endif
        @can('edit', $race)
            <x-link-button href="/race/{{ $race->id }}/edit">Edit Race</x-link-button>
        @endcan
    </x-slot:heading>
        @auth
            @if (Auth::user()->series()->count() > 0)
                <form method="POST" action="/series/add">
                    @csrf
                    <input type="hidden" name="race" value="{{ $race->id }}" />
                    <div class="flex justify-center">
                        <div>
                            <select class="py-1 js-example-basic-single" name="series">
                                <option value="">Choose Series</option>
        @foreach(Auth::user()->series as $series)
                                <option value="{{ $series->id }}">{{ $series->description }}</option>
        @endforeach
                            </select>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('.js-example-basic-single').select2();
                                });
                            </script>
                        </div>
                        <div>
                            <button type="submit" class="w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Race to Series</button>
                        </div>
                    </div>
                </form>
            @endif
        @endauth 
    <p class="text-center">
       
@if ($race->team_race == 1)
@include('races.team')
@else
@include('races.solo')
@endif
</x-layout>