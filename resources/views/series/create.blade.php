<x-layout>
    <x-slot:title>Create New Series</x-slot:title>
    <x-slot:heading>Create New Series</x-slot:heading>
    <section class="flex flex-col items-center pt-6">
  <div
    class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
      <form class="space-y-4 md:space-y-6" method="POST" action="/series">
        @csrf
        <div>
          <x-form-label for="name">Series Name</x-form-label>
          <x-form-input type="text" name="name" id="name" required />
          <x-form-error type="name" />
        </div>
        <div>
          <x-form-label for="description">Series Description</x-form-label>
          <x-form-input type="text" name="description" id="description" placeholder="Tell us about your series of races!" required />
          <x-form-error type="description" />
        </div>
        <div>
            <x-form-label for="races">Add Your Races</x-form-label>
            <x-table>
                <x-slot:thead>
                    <tr>
                        <x-table-th>Name</x-table-th>
                        <x-table-th>Mode</x-table-th>
                        <x-table-th>Hash</x-table-th>
                        <x-table-th>Description</x-table-th>
                        <x-table-th>Add to Series</x-table-th>
                    </tr>
                </x-slot:thead>
                <x-slot:tbody>
@foreach ($races as $race)
@if($loop->iteration % 2 != 0)
@php
$class = "bg-gray-100 border-b";
@endphp
@else
@php
$class = "bg-white border-b";
@endphp
@endif
                    <tr>
                        <x-table-td :isBold="true">{{ $race->name }}</x-table-td>
                        <x-table-td>{{ $race->mode->name }}</x-table-td>
                        <x-table-td><x-hash-images hash="{{ $race->hash }}" /></x-table-td>
                        <x-table-td>{{ $race->description }}</x-table-td>
                        <x-table-td><input type="checkbox" name="races[{{ $race->id }}]" value="1" /></x-table-td>
                    </tr>
@endforeach
                </x-slot:tbody>
            </x-table>
        </div>
        <x-form-button>Create a Series</x-form-button>
      </form>
    </div>
  </div>
</section>
</x-layout>