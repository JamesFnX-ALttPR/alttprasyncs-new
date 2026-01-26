@use('Baspa\Timezones\Facades\Timezones')
@php
  $timezones = Timezones::toArray(grouped: true);
@endphp
<x-layout>
    <x-slot:title>Register</x-slot:title>
    <x-slot:heading>Create New Account</x-slot:heading>
    <script type="text/javascript">
      $(document).ready(function() {
        $('.js-example-basic-single').select2();
      });
    </script>
    <section class="flex flex-col items-center pt-6">
  <div
    class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
      <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">Create an
        account
      </h1>
      <form class="space-y-4 md:space-y-6" method="POST" action="/register">
        @csrf
        <div>
          <x-form-label for="display_name">Display Name</x-form-label>
          <x-form-input type="text" name="display_name" id="display_name" placeholder="Tom Crosskeys" required />
          <x-form-error type="display_name" />
        </div>
        <div>
          <x-form-label for="email">Email Address</x-form-label>
          <x-form-input type="email" name="email" id="email" placeholder="gamer@crosskeys.com" required />
          <x-form-error type="email" />
        </div>
        <div>
          <x-form-label for="email_confirmation">Cornfirm Email Address</x-form-label>
          <x-form-input type="email" name="email_confirmation" id="email_confirmation" placeholder="gamer@crosskeys.com" required />
        </div>
        <div>
          <x-form-label for="password">Password</x-form-label>
          <x-form-input type="password" name="password" id="password" required />
          <x-form-error type="password" />
        </div>
        <div>
          <x-form-label for="password_confirmation">Confirm Password</x-form-label>
          <x-form-input type="password" name="password_confirmation" id="password_confirmation" required />
        </div>
        <div>
          <x-form-label for="timezone">Timezone</x-form-label>
          <select id="timezone" name="timezone" class="js-example-basic-single" value="">
            <option value="">Select your Timezone</option>
@foreach ($timezones as $continent => $countries)
            <optgroup label="{{ $continent }}">
@foreach ($countries as $timezone => $details)
              <option value="{{ $timezone }}">{!! $details !!}</option>
@endforeach
            </optgroup>
@endforeach
          </select>
        </div>
        <div>
          <x-form-label for="racer">Select Racetime Racer</x-form-label>
          <select class="js-example-basic-single" id="racer" name="racer">
            <option value=""></option>
            <option value="0">I don't have a racetime.gg account</option>
@foreach ($racers as $racer)
            <option value="{{ $racer->id }}">{{ $racer->name }}@if($racer->discriminator)#{{ $racer->discriminator }}@endif</option>
@endforeach
          </select>
          <x-form-error type="racer" />
        </div>
        <x-form-button>Create an account</x-form-button>
        <p class="text-sm font-light text-gray-500 dark:text-gray-400">Already have an account? <x-link href="/login">Sign in here</x-link>
        </p>
      </form>
    </div>
  </div>
</section>
</x-layout>