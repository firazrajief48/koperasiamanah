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
            'urutan' => 'required|integer|min:1|max:10',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aktif' => 'nullable|boolean'
        ]);

        $data = $request->only(['nama', 'jabatan', 'deskripsi', 'email', 'telepon', 'urutan']);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nama) . '.jpg'; // Always save as JPG for consistency
            $file->storeAs('pengurus', $filename, 'public');
            $data['foto'] = 'pengurus/' . $filename;

            // Sync storage to public
            $this->syncStorageToPublic();
        }

        // Handle aktif status - default to true if not provided
        $data['aktif'] = $request->has('aktif') ? (bool) $request->aktif : true;

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
            'urutan' => 'required|integer|min:1|max:10',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aktif' => 'nullable|boolean'
        ]);

        $data = $request->only(['nama', 'jabatan', 'deskripsi', 'email', 'telepon', 'urutan']);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto
            if ($pengurus->foto) {
                Storage::disk('public')->delete($pengurus->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nama) . '.jpg'; // Always save as JPG for consistency
            $file->storeAs('pengurus', $filename, 'public');
            $data['foto'] = 'pengurus/' . $filename;

            // Sync storage to public
            $this->syncStorageToPublic();
        }

        // Handle aktif status - default to true if not provided
        $data['aktif'] = $request->has('aktif') ? (bool) $request->aktif : true;

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

    /**
     * Sync storage to public directory
     */
    private function syncStorageToPublic()
    {
        $source = storage_path('app/public');
        $destination = public_path('storage');

        if (is_dir($source)) {
            // Remove existing public/storage directory
            if (is_dir($destination)) {
                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($destination, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::CHILD_FIRST
                );

                foreach ($files as $fileinfo) {
                    $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                    $todo($fileinfo->getRealPath());
                }
                rmdir($destination);
            }

            // Copy files from storage to public
            shell_exec("xcopy /E /I /Y \"$source\" \"$destination\"");
        }
    }
}
