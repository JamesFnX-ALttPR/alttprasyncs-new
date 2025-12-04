@php
$mode_info = \App\Models\Mode::where('id', $race->mode_id)->first();
$mode = $mode_info->name;
$mode_desc = $mode_info->description;
$hash_array = explode(' ', $race->hash);
@endphp
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <title>ALttPR Asyncs - Submit Result for {{ $race->name }}</title>
    </head>
    <body class="bg-gray-900 text-gray-50">
        <h1>Submit Result for {{ $race->name }}</h1>
        <div class="flex justify-center">
            <form method="POST" action="/async/{{ $race->id }}">
@csrf
                <table class="w-full mx-auto border-collapse border border-gray-400 rounded-md">
                    <tr>
                        <th class="text-right px-2"><label for="racer_name">Name:</label></th><td class="px-2"><input type="text" id="racer_name" name="racer_name" placeholder="Your Name" /></td>
                    </tr>
                    <tr>
                        <th class="text-right px-2"><label for="forfeit">Forfeit:</label></th><td class="px-2"><input type="checkbox" id="forfeit" name="forfeit" value="1" onclick="if (this.checked) { document.getElementsByClassName('hide-on-forfeit')[0].style.display = 'none'; document.getElementsByClassName('hide-on-forfeit')[1].style.display = 'none'; document.getElementsByClassName('hide-on-forfeit')[2].style.display = 'none'; } else { document.getElementsByClassName('hide-on-forfeit')[0].style.display = 'table-row'; document.getElementsByClassName('hide-on-forfeit')[1].style.display = 'table-row'; document.getElementsByClassName('hide-on-forfeit')[2].style.display = 'table-row'; }" /></td>
                    </tr>
                    <tr class="hide-on-forfeit">
                        <th class="text-right px-2"><label for="time">Time:</label></th><td class="px-2"><input type="text" id="time" name="time" placeholder="1:30:00" /></td>
                    </tr>
                    <tr class="hide-on-forfeit">
                        <th class="text-right px-2"><label for="cr">Collection Rate:</label></th><td class="px-2"><input type="number" id="cr" name="cr" min="1" /></td>
                    </tr>
                    <tr class="hide-on-forfeit">
                        <th class="text-right px-2"><label for="vod">VOD Link:</label></th><td class="px-2"><input type="text" id="vod" name="vod" /></td>
                    </tr>
                    <tr>
                        <th class="text-right px-2"><label for="comment">Comment:</label></th><td class="px-2"><input type="text" id="comment" name="comment" /></td>
                    </tr>
                    <tr>
                        <td class="text-center px-2" colspan="2"><input type="submit" value="Submit Time" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>