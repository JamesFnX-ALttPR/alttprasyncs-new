<x-layout>
    <x-slot:title>Edit {{ $race->name }}</x-slot:title>
    <x-slot:heading>Edit {{ $race->name }}</x-slot:heading>
    <div class="justify-center">
        <form class="max-w-2/5 mx-auto" method="POST" action="/races/{{ $race->id }}/edit">
            @csrf
            
            <div class="mb-5">
                <x-form-label for="mode">Mode</x-form-label>
                <select id="mode" name="mode" value="{{ $race->mode_id }}" class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer">
                    <option value=""></option>
                    <option value="0">My mode isn't in this list</option>
@foreach ($modes as $mode)
                    <option value="{{ $mode->id }}" @selected($race->mode_id == $mode->id)>{{ $mode->name }}</option>    
@endforeach
                </select>
                <x-form-input id="new_mode" name="new_mode" value="{{ old('new_mode') }}" placeholder="Enter your mode if it isn't in the list" />
                <x-form-error type="mode" />
                <x-form-error type="new_mode" />
                <x-form-label for="seed">Seed URL</x-form-label>
                <x-form-input id="seed" name="seed" value="{{ $race->seed }}" />
                <x-form-error type="seed" />
                <x-form-label for="description">Description</x-form-label>
                <x-form-input id="description" name="description" value="{{ $race->description }}" />
                <x-form-error type="description" />
@php
    $hash_array = explode(' ', $race->hash);
@endphp
                <x-form-label for="hash_1">Hash</x-form-label>
                <div class="grid grid-cols-5 content-start justify-items-center">
                    <div>
                        <x-form-hash-select value="{{ $hash_array[0] }}">hash_1</x-form-hash-select>
                    </div>
                    <div>
                        <x-form-hash-select value="{{ $hash_array[1] }}">hash_2</x-form-hash-select>
                    </div>
                    <div>
                        <x-form-hash-select value="{{ $hash_array[2] }}">hash_3</x-form-hash-select>
                    </div>
                    <div>
                        <x-form-hash-select value="{{ $hash_array[3] }}">hash_4</x-form-hash-select>
                    </div>
                    <div>
                        <x-form-hash-select value="{{ $hash_array[4] }}">hash_5</x-form-hash-select>
                    </div>
                </div>
                <x-form-error type="hash_1" />
                <x-form-error type="hash_2" />
                <x-form-error type="hash_3" />
                <x-form-error type="hash_4" />
                <x-form-error type="hash_5" />
                <div class="inline-flex items-center flex-col">
                    <label class="flex items-center cursor-pointer relative" for="team_race">
                        <input type="checkbox"
                        class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-slate-800 checked:border-slate-800"
                        id="team_race" name="team_race" value="1" />
                        <span class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"
                                stroke="currentColor" stroke-width="1">
                                <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </label>
                    <label class="cursor-pointer ml-2 text-slate-600 text-sm" for="team_race">
                        Co-op Race
                    </label>
                    <label class="flex items-center cursor-pointer relative" for="spoiler_race">
                        <input type="checkbox"
                        class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-slate-800 checked:border-slate-800"
                        id="spoiler_race" name="spoiler_race" value="1"
                        onclick="if (this.checked) { document.getElementsByClassName('show-on-spoiler')[0].style.display = 'block'; } else { document.getElementsByClassName('show-on-spoiler')[0].style.display = 'none'; }" />
                        <span class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"
                                stroke="currentColor" stroke-width="1">
                                <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </label>
                    <label class="cursor-pointer ml-2 text-slate-600 text-sm" for="spoiler_race">
                        Spoiler Race
                    </label>
                </div>
                <x-form-error type="team_race" />
                <x-form-error type="spoiler_race" />
                <div class="show-on-spoiler hidden">
                    <x-form-label for="spoiler_log">Spoiler Log URL</x-form-label>
                    <x-form-input id="spoiler_log" name="spoiler_log" value="{{ old('spoiler_log') }}" />
                    <x-form-error type="spoiler_log" />
                </div>
                <x-form-button>Submit Changes</x-form-button>      
            </div>
                
        </form>
    </div>
</x-layout>