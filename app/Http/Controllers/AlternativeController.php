<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use Illuminate\Http\Request;

class AlternativeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:alternatives,code',
            'name' => 'required|string|max:255',
        ]);

        Alternative::create([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Alternatif berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Alternative::destroy($id);
        return redirect()->back()->with('success', 'Alternatif berhasil dihapus!');
    }
}