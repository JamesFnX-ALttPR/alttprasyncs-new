    <el-option value="{{ Str::replace(' ', '_', $slot) }}" class="group/option relative block cursor-default py-2 pr-9 pl-3 text-gray-900 select-none focus:bg-indigo-600 focus:text-white focus:outline-hidden">
      <div class="flex items-center">
        <img src="/images/{{ Str::lower(Str::replace(' ', '_', $slot)) }}.png" alt="" class="size-5 shrink-0 rounded-full" />
        <span class="ml-3 block truncate font-normal group-aria-selected/option:font-semibold">{{ $slot }}</span>
      </div>
      <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600 group-not-aria-selected/option:hidden group-focus/option:text-white in-[el-selectedcontent]:hidden">
        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5">
          <path d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" fill-rule="evenodd" />
        </svg>
      </span>
    </el-option>
