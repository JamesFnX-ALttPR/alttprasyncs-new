@if($raceresult->description != null)
{{ $raceresult->description }}<br />
@endif
@foreach($hash_array as $hash)
<img class="inline" height="30" width="30" src="/images/{{ strtolower($hash) }}.png" title="{{ str_replace('_', ' ', $hash) }}" alt="{{ str_replace('_', ' ', $hash) }}" />
@endforeach<br />
<a class="text-blue-300 hover:underline" target="_blank" href="{{ $raceresult->seed }}">Download Seed</a><br />
<a class="text-blue-300 hover:underline" href="/mode/{{ $raceresult->mode_id }}">{{ $mode }}</a>@if($mode_desc != null) - {{ $mode_desc }}@endif<br />
@if($raceresult->spoiler_race == 1)
<br /><a target="_blank" href="{{ $raceresult->spoiler_log }}">Link to Spoiler</a><br />
@endif
        Average Time - {{ date("G:i:s", $raceresult->result_avg_time) }}</p><hr />

        <div class="flex justify-center">
            <table class="w-full max-w-3/4 mx-auto border-collapse border border-gray-400 rounded-md">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-2 py-2">Place</th>
                        <th class="border border-gray-300 px-2 py-2">Name</th>
                        <th class="border border-gray-300 px-2 py-2">Time</th>
                        <th class="border border-gray-300 px-2 py-2">Comments</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($raceresult->result as $result)
                    @if($loop->iteration % 2 == 0)
                    @php
                    $class = "bg-gray-700 border border-gray-300 px-2 py-1";
                    @endphp
                    @else
                    @php
                    $class = "bg-gray-800 border border-gray-300 px-2 py-1";
                    @endphp
                    @endif
                    <tr>
                        <td class="{{ $class }}">{{ $loop->iteration }}</td>
                        <td class="{{ $class }}"><a class="text-blue-300 hover:underline" href="/racer/{{ $result->racer->id }}">{{ $result->racer->name }}</a></td>
                        <td class="{{ $class }}">@if ($result->forfeit == 1)Forfeit @else{{ date("G:i:s", $result->time) }}@endif</td>
                        <td class="{{ $class }}">{{ $result->comment }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>