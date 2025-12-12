            Participants: 
@php
$team_name = '';
foreach($racer_team_list as $racer) {
    if ($team_name == '') {
        $team_name = $racer->team;
        echo '<span class="font-bold">' . $racer->team . '</span>(' . $racer->name;
    } elseif ($team_name == $racer->team) {
        echo '/' . $racer->name;
    } else {
        $team_name = $racer->team;
        echo '), <span class="font-bold">' . $racer->team . '</span>(' . $racer->name;
    }
}
echo ')';
@endphp
        </p>
        </div><hr />
        <div class="flex justify-center">
            <form method="POST" action="/submitasync">
                @csrf

                <input type="hidden" id="race_id" name="race_id" value="{{ $race->id }}" \>
                <input type="hidden" id="team_race" name="team_race" value="y" \>
                <table class="w-full mx-auto border-collapse border border-gray-400 rounded-md">
                    <thead>
                        <tr>
                            <th></th>
                            <th class="text-center px-2">Player 1</th>
                            <th class="text-center px-2">Player 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-right px-2"><label for="team">Team:</label></th>
                            <td class="px-2" colspan="2"><input type="text" id="team" name="team" /></td>
                        </tr>
                        <tr>
                            <th class="text-right px-2"><label for="name1">Name:</label></th>
                            <td class="px-2"><input type="text" id="name1" name="name1" placeholder="Your Name" /></td>
                            <td class="px-2"><input type="text" id="name2" name="name2" placeholder="Their Name" /></td>
                        </tr>
                        <tr>
                            <th class="text-right px-2"><label for="forfeit">Forfeit:</label></th>
                            <td class="px-2" colspan="2"><input type="checkbox" id="forfeit" name="forfeit" value="1" onclick="if (this.checked) { document.getElementsByClassName('hide-on-forfeit')[0].style.display = 'none'; document.getElementsByClassName('hide-on-forfeit')[1].style.display = 'none'; document.getElementsByClassName('hide-on-forfeit')[2].style.display = 'none'; } else { document.getElementsByClassName('hide-on-forfeit')[0].style.display = 'table-row'; document.getElementsByClassName('hide-on-forfeit')[1].style.display = 'table-row'; document.getElementsByClassName('hide-on-forfeit')[2].style.display = 'table-row'; }" /></td>
                        </tr>
                        <tr class="hide-on-forfeit">
                            <th class="text-right px-2"><label for="time1">Time:</label></th>
                            <td class="px-2"><input type="text" id="time1" name="time1" placeholder="1:30:00" /></td>
                            <td class="px-2"><input type="text" id="time2" name="time2" placeholder="1:40:00" /></td>
                        </tr>
                        <tr class="hide-on-forfeit">
                            <th class="text-right px-2"><label for="cr1">Collection Rate:</label></th>
                            <td class="px-2"><input type="number" id="cr1" name="cr1" min="1" /></td>
                            <td class="px-2"><input type="number" id="cr2" name="cr2" min="1" /></td>
                        </tr>
                        <tr class="hide-on-forfeit">
                            <th class="text-right px-2"><label for="vod1">VOD Link:</label></th>
                            <td class="px-2"><input type="text" id="vod1" name="vod1" /></td>
                            <td class="px-2"><input type="text" id="vod2" name="vod2" /></td>
                        </tr>
                        <tr>
                            <th class="text-right px-2"><label for="comment1">Comment:</label></th>
                            <td class="px-2"><input type="text" id="comment1" name="comment1" /></td>
                            <td class="px-2"><input type="text" id="comment2" name="comment2" /></td>
                        </tr>
                        <tr>
                            <td class="text-center px-2" colspan="3"><input type="submit" value="Submit Time" /></td>
                        </tr>
                    </tbody>
                </table>
            </form>
