@use('Illuminate\Support\Str')
@php
$mode_info = \App\Models\Mode::where('id', $result->race->mode_id)->first();
$mode = $mode_info->name;
$mode_desc = $mode_info->description;
$time = date("G:i:s", $result->time);
@endphp
<x-layout>
    <x-slot:title>Edit Result for {{ Str::after($result->race->name, '/') }}</x-slot:title>
    <x-slot:heading>Edit Result for <x-link href="/race/{{ $result->race->id }}">{{ $result->race->name }}</x-link></x-slot:heading>
    <div class="flex justify-center grid-cols-1">
        <div>{{ $result->race->description }}<div>
        <div>@if ($result->race->spoiler_race)spoiler - @endif{{ $mode }}@if ($mode_desc != null) - {{ $mode_desc }}@endif</div>
        <div><x-hash-images size="30" hash="{{ $result->race->hash }}" /></div>
    </div>
    <form class="max-w-md mx-auto" method="POST" action="/result/{{ $result->id }}">
        @csrf
        @method('PATCH')

        <div class="mb-5">
            <div @if($result->forfeit == 1)
class="hidden hide-on-forfeit"
@else
class="hide-on-forfeit"
@endif>
                <x-form-label for="time">Time (H:mm:ss)</x-form-label>
                <x-form-input value="{{ $time }}" type="text" id="time" name="time" />
                <x-form-error type="time" />
                <x-form-label for="cr">Collection Rate</x-form-label>
                <x-form-input type="number" id="cr" name="cr" value="{{ $result->cr }}" />
                <x-form-error type="cr" />
                <x-form-label for="vod">Link to VOD</x-form-label>
                <x-form-input id="vod" name="vod" value="{{ $result->vod }}" />
                <x-form-error type="vod" />
            </div>
            <x-form-label for="comment">Comments</x-form-label>
            <x-form-input id="comment" name="comment" value="{{ $result->comment }}" />
            <x-form-error type="comment" />
            <div class="flex items-center mb-4">
                <input @if($result->forfeit == 1)checked @endif class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft" type="checkbox" id="forfeit" name="forfeit" value="1" onclick="if (this.checked) { document.getElementsByClassName('hide-on-forfeit')[0].style.display = 'none'; } else { document.getElementsByClassName('hide-on-forfeit')[0].style.display = 'block'; }" />
                <x-form-label class="ms-2 text-sm font-medium text-heading select-none" for="forfeit">Check for Forfeit</x-form-label>
            </div>
            <x-form-button>Edit Result</x-form-button>
            
        </div>
</x-layout>