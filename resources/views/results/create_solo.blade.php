            Participants: @foreach($racer_list as $racer) {{ $racer->name }}@if(! $loop->last),@endif
@endforeach
        </p>
        </div><hr />
        <div class="flex justify-center">
            <form class="max-w-sm mx-auto" method="POST" action="/result">
                @csrf

                <input type="hidden" id="race_id" name="race_id" value="{{ $race->id }}" \>
                <div class="mb-5">
                    <x-form-label for="name">Name - {{ Auth::user()->racer->name }}@if(Auth::user()->racer->discriminator)#{{ Auth::user()->racer->discriminator }}@endif</x-form-label>
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
                    <x-form-button>Submit Result</x-form-button>
                    
                </div>
                {{-- <table class="w-full mx-auto border-collapse border border-gray-400 rounded-md">
                    <tr class="py-4">
                        <th class="text-right px-2"><x-form-label for="name">Name:</x-form-label></th><td class="px-2"><x-form-input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Your Name" /></td>
                    </tr>
                    <tr class="py-4">
                        <th class="text-right px-2"><x-form-label for="forfeit">Forfeit:</x-form-label></th><td class="px-2"><x-form-input type="checkbox" id="forfeit" name="forfeit" value="1" onclick="if (this.checked) { document.getElementsByClassName('hide-on-forfeit')[0].style.display = 'none'; document.getElementsByClassName('hide-on-forfeit')[1].style.display = 'none'; document.getElementsByClassName('hide-on-forfeit')[2].style.display = 'none'; } else { document.getElementsByClassName('hide-on-forfeit')[0].style.display = 'table-row'; document.getElementsByClassName('hide-on-forfeit')[1].style.display = 'table-row'; document.getElementsByClassName('hide-on-forfeit')[2].style.display = 'table-row'; }" /></td>
                    </tr>
                    <tr class="py-4 hide-on-forfeit">
                        <th class="text-right px-2"><x-form-label for="time">Time:</x-form-label></th><td class="px-2"><x-form-input type="text" class="@error('time') is-invalid @enderror" id="time" name="time" value="{{ old('time') }}" placeholder="1:30:00" /></td>
                    </tr>
                    <tr class="py-4 hide-on-forfeit">
                        <th class="text-right px-2"><x-form-label for="cr">Collection Rate:</x-form-label></th><td class="px-2"><x-form-input type="number" id="cr" name="cr" value="{{ old('cr') }}" min="1" /></td>
                    </tr>
                    <tr class="py-4 hide-on-forfeit">
                        <th class="text-right px-2"><x-form-label for="vod">VOD Link:</x-form-label></th><td class="px-2"><x-form-input type="text" value="{{ old('vod') }}" id="vod" name="vod" /></td>
                    </tr>
                    <tr class="py-4">
                        <th class="text-right px-2"><x-form-label for="comment">Comment:</x-form-label></th><td class="px-2"><x-form-input type="text" value="{{ old('comment') }}" id="comment" name="comment" /></td>
                    </tr>
                    <tr class="py-4">
                        <td class="text-center px-2" colspan="2"><x-form-input type="submit" value="Submit Time" /></td>
                    </tr>
                </table> --}}
            </form>
