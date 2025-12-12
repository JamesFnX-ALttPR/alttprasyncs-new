<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HashController extends Controller
{
    public static function hashToImages($hash) {
        $hash_array = explode(' ', $hash);
        return '<img class="inline" height="25" width="25" src="/images/' . strtolower($hash_array[0]). '.png" title="' . str_replace('_', ' ', $hash_array[0]) . '" alt="' . str_replace('_', ' ', $hash_array[0]) .'" /><img class="inline" height="25" width="25" src="/images/' . strtolower($hash_array[1]). '.png" title="' . str_replace('_', ' ', $hash_array[1]) . '" alt="' . str_replace('_', ' ', $hash_array[1]) . '" /><img class="inline" height="25" width="25" src="/images/' . strtolower($hash_array[2]). '.png" title="' . str_replace('_', ' ', $hash_array[2]) . '" alt="' . str_replace('_', ' ', $hash_array[2]) . '" /><img class="inline" height="25" width="25" src="/images/' . strtolower($hash_array[3]). '.png" title="' . str_replace('_', ' ', $hash_array[3]) . '" alt="' . str_replace('_', ' ', $hash_array[3]) . '" /><img class="inline" height="25" width="25" src="/images/' . strtolower($hash_array[4]). '.png" title="' . str_replace('_', ' ', $hash_array[4]) . '" alt="' . str_replace('_', ' ', $hash_array[4]) . '" />';
    }
}
