@props(['isBold' => false])
<td {{ $attributes->class(['font-bold' => $isBold, 'font-light' => !$isBold])->merge(['class' => "text-sm text-gray-900 px-6 py-4 whitespace-nowrap"]) }}>{{ $slot }}</td>
