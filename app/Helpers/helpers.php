<?php

if (! function_exists("gatherDataUrls")) {
    function gatherDataUrls(string $category, int $page)
    {
        $url = "https://racetime.gg/" . $category . "/races/data?page=". $page;
        $data = Http::get($url);
        $json = $data->json();
        $url_array = [];
        foreach ($json["races"] as $key => $value) {
            array_unshift($url_array, "https://racetime.gg" . $value["data_url"]);
        }
        return $url_array;
    }
}

if (! function_exists("gatherRaceData")) {
    function gatherRaceData(string $url) {
        $data = Http::get($url);
        $json = $data->json();
        return $json;
    }
}

if (! function_exists("validateHash")) {
    function validateHash(string $hash) {
        // A list of the valid hashes across all formats
        $valid_hashes = ['Big Key', 'Bombos', 'Bombs', 'Book', 'Boomerang', 'Boots', 'Bow', 'Bugnet', 'Cape', 'Compass',
        'Empty Bottle', 'Ether', 'Flippers', 'Flute', 'Gloves', 'Green Potion','Hammer', 'Heart', 'Hookshot', 'Ice Rod', 'Lamp',
        'Magic Powder', 'Map', 'Mirror', 'Moon Pearl', 'Mushroom', 'Pendant', 'Quake', 'Shield', 'Shovel', 'Somaria', 'Tunic',
        'Key', 'Bomb', 'Bug Net', 'BugNet', 'Bottle', 'Ocarina', 'Potion', 'Rod', 'Powder', 'Pearl', 'Cane', 'HashBigKey',
        'HashBombos', 'HashBombs', 'HashBook', 'HashBoomerang', 'HashBoots', 'HashBow', 'HashBugnet', 'HashCape', 'HashCompass',
        'HashEmptyBottle', 'HashEther', 'HashFlippers', 'HashFlute', 'HashGloves', 'HashGreenPotion', 'HashHammer', 'HashHeart',
        'HashHookshot', 'HashIceRod', 'HashLamp', 'HashMagicPowder', 'HashMap', 'HashMirror', 'HashMoonPearl', 'HashMushroom',
        'HashPendant', 'HashQuake', 'HashShield', 'HashShovel', 'HashSomaria', 'HashTunic'];
        $sahabot_pattern = '/^\(([a-zA-Z\s]+)\/([a-zA-Z\s]+)\/([a-zA-Z\s]+)\/([a-zA-Z\s]+)\/([a-zA-Z\s]+)\)$/';
        $mudora_pattern = '/^(Hash[A-Za-z]+)\s(Hash[A-Za-z]+)\s(Hash[A-Za-z]+)\s(Hash[A-Za-z]+)\s(Hash[A-Za-z]+)$/';
        $normalize = array(
            "Key" => "Big_Key",
            "Big Key" => "Big_Key",
            "HashBigKey" => "Big_Key",
            "Bombos" => "Bombos",
            "HashBombos" => "Bombos",
            "Bomb" => "Bombs",
            "Bombs" => "Bombs",
            "HashBombs" => "Bombs",
            "Book" => "Book",
            "HashBook" => "Book",
            "Boomerang" => "Boomerang",
            "HashBoomerang" => "Boomerang",
            "Boots" => "Boots",
            "HashBoots" => "Boots",
            "Bow" => "Bow",
            "HashBow" => "Bow",
            "Bug Net" => "Bugnet",
            "BugNet" => "Bugnet",
            "Bugnet" => "Bugnet",
            "HashBugnet" => "Bugnet",
            "Cape" => "Cape",
            "HashCape" => "Cape",
            "Compass" => "Compass",
            "HashCompass" => "Compass",
            "Bottle" => "Empty_Bottle",
            "Empty Bottle" => "Empty_Bottle",
            "HashEmptyBottle" => "Empty_Bottle",
            "Ether" => "Ether",
            "HashEther" => "Ether",
            "Flippers" => "Flippers",
            "HashFlippers" => "Flippers",
            "Ocarina" => "Flute",
            "Flute" => "Flute",
            "HashFlute" => "Flute",
            "Gloves" => "Gloves",
            "HashGloves" => "Gloves",
            "Potion" => "Green_Potion",
            "Green Potion" => "Green_Potion",
            "HashGreenPotion" => "Green_Potion",
            "Hammer" => "Hammer",
            "HashHammer" => "Hammer",
            "Heart" => "Heart",
            "HashHeart" => "Heart",
            "Hookshot" => "Hookshot",
            "HashHookshot" => "Hookshot",
            "Rod" => "Ice_Rod",
            "Ice Rod" => "Ice_Rod",
            "HashIceRod" => "Ice_Rod",
            "Lamp" => "Lamp",
            "HashLamp" => "Lamp",
            "Powder" => "Magic_Powder",
            "Magic Powder" => "Magic_Powder",
            "HashMagicPowder" => "Magic_Powder",
            "Map" => "Map",
            "HashMap" => "Map",
            "Mirror" => "Mirror",
            "HashMirror" => "Mirror",
            "Pearl" => "Moon_Pearl",
            "Moon Pearl" => "Moon_Pearl",
            "HashMoonPearl" => "Moon_Pearl",
            "Mushroom" => "Mushroom",
            "HashMushroom" => "Mushroom",
            "Pendant" => "Pendant",
            "HashPendant" => "Pendant",
            "Quake" => "Quake",
            "HashQuake" => "Quake",
            "Shield" => "Shield",
            "HashShield" => "Shield",
            "Shovel" => "Shovel",
            "HashShovel" => "Shovel",
            "Cane" => "Somaria",
            "Somaria" => "Somaria",
            "HashSomaria" => "Somaria",
            "Tunic" => "Tunic",
            "HashTunic" => "Tunic",
        );

        if (preg_match($sahabot_pattern, $hash)) {
            preg_match($sahabot_pattern, $hash, $matches);
            for($i=1; $i<6; $i++) {
                if (!in_array($matches[$i], $valid_hashes)) {
                    return false;
                }
            }
            return $normalize[$matches[1]] . " " . $normalize[$matches[2]] . " " . $normalize[$matches[3]] . " " . $normalize[$matches[4]] . " " . $normalize[$matches[5]];
        } elseif (preg_match($mudora_pattern, $hash)) {
            preg_match($mudora_pattern, $hash, $matches);
            for($i= 1; $i< 6; $i++) {
                if (!in_array($matches[$i], $valid_hashes)) {
                    return false;
                }
            }
            return $normalize[$matches[1]] . " " . $normalize[$matches[2]] . " " . $normalize[$matches[3]] . " " . $normalize[$matches[4]] . " " . $normalize[$matches[5]];
        } else {
            return false;
        }
    }
}

if (! function_exists("parseAlttprRaceData")) {
    function parseAlttprRaceData(array $data) {
        $start_time = date("Y-m-d H:i:s", strtotime($data["started_at"]));
        $description = $data['info_user'];
        $info_bot = $data['info_bot'];
        $team_race = $data['team_race'];
        $sahabot_pattern = "/^([A-Za-z0-9\-\_\/\s]+[A-Za-z0-9])\s?\-?\s?(https\:\/\/[A-Za-z0-9\/\.]+[A-Za-z0-9])\s?\-?\s?(\([A-Za-z\s]+\/[A-Za-z\s]+\/[A-Za-z\s]+\/[A-Za-z\s]+\/[A-Za-z\s]+\))$/";
        $mudora_pattern = "/^([A-Za-z0-9\/\_\-\s]+[A-Za-z0-9])?\s?\-?\s?(Hash[A-Za-z]+\sHash[A-Za-z]+\sHash[A-Za-z]+\sHash[A-Za-z]+\sHash[A-Za-z]+)\n(https\:\/\/.+)\n?\[?([A-Za-z0-9\s\n\.\:\-\/\_]*)?\]?$/";
        if (preg_match($sahabot_pattern, $info_bot)) {
            preg_match($sahabot_pattern, $info_bot, $matches);
            $mode = $matches[1];
            $seed = $matches[2];
            $hash = $matches[3];
        } elseif (preg_match($mudora_pattern, $info_bot)) {
            preg_match($mudora_pattern, $info_bot, $matches);
            if ($matches[1] != null) {
                $mode = $matches[1];
            } else {
                $mode = "mode_not_found";
            }
            $seed = $matches[3];
            $hash = $matches[2];
            if ($matches[4] != null && $description != null) {
                $description .= ' - ' . $matches[4];
            } elseif ($matches[4] != null && $description == null) {
                $description = $matches[4];
            }
        } else {
            return ['accepted' => false, 'name' => $data['name'], 'reason' => 'Didn\'t match an existing pattern'];
        }
        $parsed_hash = validateHash($hash);
        if ($parsed_hash != false) {
            if (Str::isUrl($seed)) {
                return ['accepted' => true, 'name' => $data['name'], 'start_time' => $start_time, 'mode' => $mode, 'seed' => $seed, 'hash' => $parsed_hash, 'description' => $description, 'team_race' => $team_race];
            } else {
                return ['accepted' => false, 'name' => $data['name'], 'reason'=> "Seed not a valid URL"];
            }
        } else {
            return ['accepted' => false, 'name' => $data['name'], 'reason' => 'Hash failed to validate'];
        }
    }
}

if (! function_exists('getResultData')) {
    function getResultData(array $data, int $ordinal){
        $racer_id = $data['entrants'][$ordinal]['user']['id'];
        $racer_name = $data['entrants'][$ordinal]['user']['name'];
        $racer_discriminator = $data['entrants'][$ordinal]['user']['discriminator'];
        if ($data['entrants'][$ordinal]['finish_time'] == null) {
            $racer_forfeit = 1;
            $racer_time = 99999;
        } else {
            $racer_forfeit = 0;
            $finish = $data['entrants'][$ordinal]['finish_time'];
            $finish = preg_replace('/\.[0-9]{6}/', '', $finish);
            $interval = new DateInterval($finish);
            $total = ($interval->h * 60 * 60) + ($interval->i * 60) + $interval->s;
            $racer_time = $total;
        }
        $racer_team = $data['entrants'][$ordinal]['team'];
        $racer_comment = $data['entrants'][$ordinal]['comment'];
        return ['id' => $racer_id, 'name' => $racer_name, 'discriminator' => $racer_discriminator, 'time' => $racer_time, 'forfeit' => $racer_forfeit, 'team' => $racer_team,'comment'=> $racer_comment];
    }
}