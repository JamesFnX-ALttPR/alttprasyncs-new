@use('Illuminate\Support\Facades\DB')
@use('Carbon\Carbon')
@php
$race_time = new Carbon(new DateTime($race->start_time));
@endphp
@if (! Auth::guest() && Auth::user()->timezone != null)
@php
$race_time_string = $race_time->setTimezone(Auth::user()->timezone)->format('F j, Y g:i:s A');
@endphp
@else
@php
$race_time_string = $race_time->format('F j, Y g:i:s A');
@endphp
@endif
@php
$teamresults = $race->result()->select('team', DB::raw('AVG(time) AS avg_time'))->groupBy('team')->orderBy('avg_time', 'ASC')->get();
$colspan = 2;
@endphp
<div class="mx-auto w-full text-center">
    <span class="font-bold">{{ $race_time_string }}</span><br />
@if($race->description != null)
    <span class="font-semibold">{{ $race->description }}</span><br />
@endif
    <x-hash-images size="30" hash="{{ $race->hash }}" />
    <x-link target="_blank" href="{{ $race->seed }}">Download Seed</x-link><br />
    <x-link href="/mode/{{ $race->mode_id }}">coop {{ $mode }}</x-link>@if($mode_desc != null) - {{ $mode_desc }}@endif<br />
@if($race->spoiler_race == 1)
    <a target="_blank" href="{{ $race->spoiler_log }}">Link to Spoiler</a><br />
@endif
@if($race->result_avg_time != null)
    Average Time - <span class="font-semibold">{{ date("G:i:s", $race->result_avg_time) }}</span>
@endif
</div><hr />
@if (DB::table('results')->where('race_id', $race->id)->whereNotNull('cr')->count() > 0)
@php
$crActive = 1;
@endphp
@else
@php
$crActive = 0;
@endphp
@endif
@if (DB::table('results')->where('race_id', $race->id)->whereNotNull('vod')->count() > 0)
@php
$vodActive = 1;
@endphp
@else
@php
$vodActive = 0;
@endphp
@endif
        <x-table>
            <x-slot:thead>
                <tr>
                    <x-table-th>Place</x-table-th>
                    <x-table-th>Name</x-table-th>
                    <x-table-th>Time</x-table-th>
                    @if ($crActive == 1)
                        <x-table-th>Collection Rate</x-table-th>
                        @php
                        $colspan++;
                        @endphp
                    @endif
                    @if ($vodActive == 1)
                        <x-table-th>Link to VOD</x-table-th>
                        @php
                        $colspan++;
                        @endphp
                    @endif
                    <x-table-th>Comments</x-table-th>
                </tr>
            </x-slot:thead>
            <x-slot:tbody>
@foreach ($teamresults as $team)
@php
    $racetimeCheck = $race->result()->where('team', $team->team)->first();
@endphp
{{-- First Place - bg-amber-100
     Second Place - bg-slate-200
     Third Place - bg-orange-100
     Asynced Results - bg-sky-100/200
     Racetime Results - bg-gray-100 and bg-white --}}
@if ($loop->iteration == 1)
    @php
        $class = "bg-amber-100 border-b";
    @endphp
@elseif ($loop->iteration == 2)
    @php
        $class = "bg-slate-200 border-b";
    @endphp
@elseif ($loop->iteration == 3)
    @php
        $class = "bg-orange-100 border-b";
    @endphp
@endif
@if ($loop->iteration % 2 != 0 && $loop->iteration > 3)
    @php
        $class = "bg-gray-100 border-b";
    @endphp
@elseif ($loop->iteration % 2 == 0 && $loop->iteration > 3)
    @php
        $class = "bg-white border-b";
    @endphp
@endif
@if($loop->iteration % 2 != 0 && $racetimeCheck->from_racetime == 0)
    @php
        $class = "bg-sky-200 border-b";
    @endphp
@elseif ($loop->iteration % 2 == 0 && $racetimeCheck->from_racetime == 0)
    @php
        $class = "bg-sky-100 border-b";
    @endphp
@endif
                    <tr class="{{ $class }}">
                        <x-table-td :isBold="true">{{ $loop->iteration }}</x-table-td>
                        <x-table-td :isBold="true">{{ $team->team }}</x-table-td>
@if (DB::table('results')->where('race_id', $race->id)->where('team', $team->team)->max('forfeit') == 1)
                        <x-table-td colspan="{{ $colspan }}" :isBold="true">Forfeit</x-table-td>
@else
                        <x-table-td colspan="{{ $colspan }}" :isBold="true">{{ date("G:i:s", round($team->avg_time)) }}</x-table-td>
@endif
                    </tr>
                    @foreach ($race->result()->where('team', $team->team)->get() as $result)
                    <tr class="{{ Str::replace(' border-b', '', $class) }}">
                        <x-table-td></x-table-td>
                        <x-table-td><x-link href="/racer/{{ $result->racer->id }}">{{ $result->racer->name }}</x-link></x-table-td>
                        <x-table-td>
@if ($result->forfeit == 1)
Forfeit
@else
{{ date("G:i:s", $result->time) }}
@endif
                        </x-table-td>
                        @if ($crActive == 1)
                        <x-table-td>
                            @if ($result->cr == null)
                                N/A
                            @else
                                {{ $result->cr }}
                            @endif
                        </x-table-td>
                    @endif
                    @if ($vodActive == 1)
                        @if ($result->vod == null)
                            <x-table-td>N/A</x-table-td>
                        @else
                            <x-table-td :isBold="true"><x-link href="{{ $result->vod }}">Watch VOD</x-link></x-table-td>
                        @endif
                    @endif
                        <x-table-td>{{ $result->comment }}</x-table-td>
                    </tr>                    
                    @endforeach
                    @endforeach
                </x-slot:tbody>
            </x-table>