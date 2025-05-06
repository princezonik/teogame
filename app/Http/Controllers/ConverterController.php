<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConverterController extends Controller
{
    public function showForm()
    {
        return view('converter');
    }

    public function convert(Request $request)
    {
        $rate = 0.0035;

        if ($request->has('robux')) {
            $robux = floatval($request->input('robux'));
            $usd = $robux * $rate;
            return view('converter', compact('robux', 'usd'));
        }

        if ($request->has('usd')) {
            $usd = floatval($request->input('usd'));
            $robux = $usd / $rate;
            return view('converter', compact('robux', 'usd'));
        }

        return view('converter');
    }
}
