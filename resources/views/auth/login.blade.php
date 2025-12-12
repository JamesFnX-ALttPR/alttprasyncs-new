<x-layout>
    <x-slot:title>Log In</x-slot:title>
    <x-slot:heading>Log In</x-slot:heading>
    <section class="flex flex-col items-center pt-6">
  <div
    class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
      <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">Log In</h1>
      <form class="space-y-4 md:space-y-6" method="POST" action="/login">
        @csrf
        <div>
          <x-form-label for="email">Email Address</x-form-label>
          <x-form-input type="email" name="email" id="email" placeholder="gamer@crosskeys.com" :value="old('email')" required />
          <x-form-error type="email" />
        </div>
        <div>
          <x-form-label for="password">Password</x-form-label>
          <x-form-input type="password" name="password" id="password" required />
          <x-form-error type="password" />
        </div>
        <x-form-button>Login</x-form-button>
        <p class="text-sm font-light text-gray-500 dark:text-gray-400">Don't have an account? <x-link href="/register">Register here</x-link>
        </p>
      </form>
    </div>
  </div>
</section>
</x-layout>