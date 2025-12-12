@props(['linkbar' => null])
<div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        @if($linkbar){{ $linkbar }}@endif
                        <table class="min-w-full">
                            <thead class="bg-white border-b">
                                {{ $thead }}
                            </thead>
                            <tbody>
                                {{ $tbody }}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>