<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengurusKoperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengurusKoperasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengurus = PengurusKoperasi::orderBy('urutan', 'asc')->get();
        return view('administrator.pengurus-koperasi.index', compact('pengurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('administrator.pengurus-koperasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'urutan' => 'required|integer|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aktif' => 'boolean'
        ]);

        $data = $request->all();

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/pengurus', $filename);
            $data['foto'] = 'pengurus/' . $filename;
        }

        $data['aktif'] = $request->has('aktif');

        PengurusKoperasi::create($data);

        return redirect()->route('administrator.pengurus-koperasi.index')
            ->with('success', 'Data pengurus koperasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengurus = PengurusKoperasi::findOrFail($id);
        return view('administrator.pengurus-koperasi.show', compact('pengurus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengurus = PengurusKoperasi::findOrFail($id);
        return view('administrator.pengurus-koperasi.edit', compact('pengurus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pengurus = PengurusKoperasi::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'urutan' => 'required|integer|min:1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aktif' => 'boolean'
        ]);

        $data = $request->all();

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto
            if ($pengurus->foto) {
                Storage::delete('public/' . $pengurus->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/pengurus', $filename);
            $data['foto'] = 'pengurus/' . $filename;
        }

        $data['aktif'] = $request->has('aktif');

        $pengurus->update($data);

        return redirect()->route('administrator.pengurus-koperasi.index')
            ->with('success', 'Data pengurus koperasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengurus = PengurusKoperasi::findOrFail($id);

        // Delete foto if exists
        if ($pengurus->foto) {
            Storage::delete('public/' . $pengurus->foto);
        }

        $pengurus->delete();

        return redirect()->route('administrator.pengurus-koperasi.index')
            ->with('success', 'Data pengurus koperasi berhasil dihapus.');
    }
}
