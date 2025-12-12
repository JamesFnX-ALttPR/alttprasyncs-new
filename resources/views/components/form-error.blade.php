@props(['type'])

@error($type)
    <div class="alert alert-danger flex justify-center text-red-500">{{ $message }}</div>
@enderror