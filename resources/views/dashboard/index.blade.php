<x-layout>
    <x-slot:title>Dashboard</x-slot:title>
    <x-slot:heading>Dashboard</x-slot:heading>

<section class="container p-6 mx-auto space-y-3 dark:bg-gray-800 dark:text-white">

    <div class="flex items-center justify-center">
        <div class="grid gap-8 my-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <!-- cards -->
            <div class="w-full max-w-xs text-center">

                <a href="/">
                    <div
                        class="object-cover object-center w-full h-48 mx-auto rounded-lg bg-blue-100 border-4 border-blue-200 dark:bg-gray-900 dark:border-gray-600">
                        <div class="py-16 px-4">
                            <h5 class="text-lg font-bold t dark:text-white"><x-link href="/series/create">Create New Series</x-link></h5>
                            <span class="mt-1 font-medium dark:text-gray-400">Series organize similar races together (like practice asyncs for a tournament)</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="w-full max-w-xs text-center">
                <a href="">
                    <div
                        class="object-cover object-center w-full h-48 mx-auto rounded-lg bg-blue-100 border-4 border-blue-200 dark:bg-gray-900 dark:border-gray-600">
                        <div class="py-16 px-4">
                            <h5 class="text-lg font-bold dark:text-white"><x-link href="/dashboard/races">Your Asyncs</x-link></h5>
                            <span class="mt-1 font-medium dark:text-gray-400">View the async races you've created</span>

                        </div>
                    </div>
                </a>
            </div>

            <div class="w-full max-w-xs text-center">
                <a href="">
                    <div
                        class="object-cover object-center w-full h-48 mx-auto rounded-lg bg-blue-100 border-4 border-blue-200 dark:bg-gray-900 dark:border-gray-600">
                        <div class="py-16 px-4">
                            <h5 class="text-lg font-bold dark:text-white"><x-link href="/dashboard/results">Your Results</x-link></h5>
                            <span class="mt-1 font-medium dark:text-gray-400">View the results you've submitted to races</span>
                        </div>
                    </div>
                </a>
            </div>


            <div class="w-full max-w-xs text-center">
                <a href="">
                    <div
                        class="object-cover object-center w-full h-48 mx-auto rounded-lg bg-blue-100 border-4 border-blue-200 dark:bg-gray-900 dark:border-gray-600">
                        <div class="py-16 px-4">
                            <h5 class="text-lg font-bold dark:text-white"><x-link href="/user/edit">Account Settings</x-link></h5>
                            <span class="mt-1 font-medium dark:text-gray-400">Edit account settings</span>
                        </div>
                    </div>
                </a>
            </div>


        </div>
    </div>
</section>
</x-layout>