@use('Illuminate\Support\Str')
@use('Illuminate\Support\Facades\DB')
@use('App\Models\User')
@php
$mode_info = \App\Models\Mode::where('id', $race->mode_id)->first();
$mode = $mode_info->name;
$mode_desc = $mode_info->description;
$hash_array = explode(' ', $race->hash);
$racer_list = DB::table('racers')->join('results', 'racers.id', '=', 'results.racer_id')->select('racers.name', 'results.from_racetime')->where('results.race_id', $race->id)->orderBy(DB::raw('LOWER(racers.name)'))->get();
if ($race->team_race == 1) {
    $racer_team_list = DB::table('racers')->join('results', 'racers.id', '=', 'results.racer_id')->select('racers.name', 'results.team')->where('results.race_id', $race->id)->orderBy('results.team')->orderBy(DB::raw('LOWER(racers.name)'))->get();
}
@endphp
<x-layout>
    <x-slot:title>Submit Result for {{ Str::after( $race->name, '/') }}</x-slot:title>
    <x-slot:heading>Submit Result for <x-link target="_blank" href="https://racetime.gg/{{ $race->name }}">{{ $race->name }}</x-link></x-slot:heading>
    <div class="mx-auto w-xl justify-center">
        {{ $race->description }}<br />
        <x-link target="_blank" href="{{ $race->seed }}">Download Seed</x-link><br />
        @if ($race->spoiler_race)spoiler - @endif<x-link href="/mode/{{ $race->mode_id }}">{{ $race->mode->name }}</x-link>@if ($race->mode->description != null) - {{ $race->mode->description }}@endif<br />
        @if ($race->spoiler_race)<x-link target="_blank" href="{{ $race->spoiler_log }}">Download Spoiler Log</x-link><br />@endif
        <span class="text-center"><x-hash-images size="40" hash="{{ $race->hash }}" /></span>
@if($race->team_race == 1)
@include('results.create_team')
@else
        <span class="font-semibold">Participants:</span> @foreach($racer_list as $racer){{ $racer->name }}@if(! $loop->last), @endif
@endforeach
    </div><hr />
    <div class="flex justify-center">
        <form class="max-w-sm mx-auto" method="POST" action="/result">
            @csrf
            <input type="hidden" id="race_id" name="race_id" value="{{ $race->id }}" \>
            <div class="mb-5">
                <x-form-label for="name">Name - <span class="font-bold">{{ Auth::user()->racer->name }}@if(Auth::user()->racer->discriminator)#{{ Auth::user()->racer->discriminator }}@endif</span></x-form-label>
                <div class="hide-on-forfeit">
                    <x-form-label for="time">Time (H:mm:ss)</x-form-label>
                    <x-form-input id="time" name="time" value="{{ old('time') }}" placeholder="1:30:00" />
                    <x-form-error type="time" />
                    <x-form-label for="cr">Collection Rate</x-form-label>
                    <x-form-input type="number" id="cr" name="cr" value="{{ old('cr') }}" />
                    <x-form-error type="cr" />
                    <x-form-label for="vod">Link to VOD</x-form-label>
                    <x-form-input id="vod" name="vod" value="{{ old('vod') }}" placeholder="https://youtube.com/watch?v=your_vod" />
                    <x-form-error type="vod" />
                </div>
                <x-form-label for="comment">Comments</x-form-label>
                <x-form-input id="comment" name="comment" value="{{ old('comment') }}" />
                <x-form-error type="comment" />
                <div class="flex items-center mb-4">
                    <x-form-checkbox class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft" type="checkbox" id="forfeit" name="forfeit" value="1" onclick="if (this.checked) { document.getElementsByClassName('hide-on-forfeit')[0].style.display = 'none'; } else { document.getElementsByClassName('hide-on-forfeit')[0].style.display = 'block'; }" />
                    <x-form-label class="ms-2 text-sm font-bold text-heading select-none" for="forfeit">Check for Forfeit</x-form-label>
                </div>
                <div class="mx-auto w-32">
                    <x-form-button>Submit Result</x-form-button>
                </div>
            </div>
        </form>
    </div>
@endif
</x-layout>