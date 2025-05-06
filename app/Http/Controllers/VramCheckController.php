<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VramCheck;

class VramCheckController extends Controller
{
    public function showForm()
    {
        return view('vram-check');
    }

    public function check(Request $request)
    {
        $data = $request->validate([
            'vram_mb' => 'required|integer|min:1',
            'texture_pack_mb' => 'required|integer|min:1',
        ]);

        $status = $data['texture_pack_mb'] <= $data['vram_mb'] ? 'Fits' : 'Upgrade needed';

        $check = VramCheck::create([
            'vram_mb' => $data['vram_mb'],
            'texture_pack_mb' => $data['texture_pack_mb'],
            'status' => $status,
        ]);

        return view('vram-check', [
            'result' => $check
        ]);
    }
}
