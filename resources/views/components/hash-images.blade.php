@props(['size' => '25', 'hash'])
@php
    $hash_array = explode(' ', $hash);
@endphp
<div class="flex grid grid-rows-1 grid-cols-5 mx-auto justify-items-center max-w-{{ $size }}">
    <div>
        <img class="inline" height="{{ $size }}" width="{{ $size }}" src="/images/{{ Str::lower($hash_array[0]) }}.png" title="{{ Str::replace('_', ' ', $hash_array[0]) }}" alt="{{ Str::replace('_', ' ', $hash_array[0]) }}" />
    </div>
    <div>
        <img class="inline" height="{{ $size }}" width="{{ $size }}" src="/images/{{ Str::lower($hash_array[1]) }}.png" title="{{ Str::replace('_', ' ', $hash_array[1]) }}" alt="{{ Str::replace('_', ' ', $hash_array[1]) }}" />
    </div>
    <div>
        <img class="inline" height="{{ $size }}" width="{{ $size }}" src="/images/{{ Str::lower($hash_array[2]) }}.png" title="{{ Str::replace('_', ' ', $hash_array[2]) }}" alt="{{ Str::replace('_', ' ', $hash_array[2]) }}" />
    </div>
    <div>
        <img class="inline" height="{{ $size }}" width="{{ $size }}" src="/images/{{ Str::lower($hash_array[3]) }}.png" title="{{ Str::replace('_', ' ', $hash_array[3]) }}" alt="{{ Str::replace('_', ' ', $hash_array[3]) }}" />
    </div>
    <div>
        <img class="inline" height="{{ $size }}" width="{{ $size }}" src="/images/{{ Str::lower($hash_array[4]) }}.png" title="{{ Str::replace('_', ' ', $hash_array[4]) }}" alt="{{ Str::replace('_', ' ', $hash_array[4]) }}" />
    </div>
</div>