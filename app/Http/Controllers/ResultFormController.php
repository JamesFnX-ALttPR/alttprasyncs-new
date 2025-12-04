<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Result;

class ResultFormController extends Controller
{
    public function store($request) {
        $validatedData = $request->validate([
            'name' => 'required',
            
        ]);
    }
}