<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegValidationController extends Controller
{
    public function validateEmail(Request $request) {
        $validated = $request->validate([
            'email' => 'unique:users,email'
        ]);

        return response()->json($validated);
    }
}
