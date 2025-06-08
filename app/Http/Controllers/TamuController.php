<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TamuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tamu::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('instansi', 'like', "%{$search}%")
                    ->orWhere('tujuan', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'like', "%{$search}%");
            });
        }

        // Order by created_at descending (newest first)
        $query->orderBy('created_at', 'desc');

        // Paginate the results
        $tamu = $query->paginate(10);

        return view('tamu.index', compact('tamu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tamu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'keperluan' => 'required|string',
            'photo_data' => 'nullable|string',
        ]);

        // Handle image if provided
        if (!empty($validated['photo_data'])) {
            $imageUrl = $this->storeImage($validated['photo_data']);
            $validated['image_url'] = $imageUrl;
        }

        // Remove photo_data from validated data before storing
        unset($validated['photo_data']);

        Tamu::create($validated);

        return redirect()->route('tamu.index')
            ->with('success', 'Data tamu berhasil ditambahkan!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Tamu $tamu)
    {
        return view('admin.tamu.show', compact('tamu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tamu $tamu)
    {
        return view('admin.tamu.edit', compact('tamu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tamu $tamu)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'keperluan' => 'required|string',
            'photo_data' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validasi file gambar
        ]);

        // Handle image if provided
        if (!empty($validated['photo_data'])) {
            // Delete old image if exists
            if ($tamu->image_url) {
                Storage::disk('public')->delete($tamu->image_url);
            }

            $imageUrl = $request->file('photo_data')->store('visitor_photos', 'public');
            $validated['image_url'] = $imageUrl;
        }

        $tamu->update($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Data tamu berhasil diperbarui!');
    }

    public function storeFromMain(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'keperluan' => 'required|string',
            'photo_data' => 'required|string',
        ]);

        // Store the image
        $imageUrl = $this->storeImage($validated['photo_data']);
        $validated['image_url'] = $imageUrl;

        // Remove photo_data from validated data before storing
        unset($validated['photo_data']);

        Tamu::create($validated);

        return back()->with('success', 'Data tamu berhasil ditambahkan!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tamu $tamu)
    {
        // Delete image from storage if it exists
        if ($tamu->image_url) {
            Storage::disk('public')->delete($tamu->image_url);
        }

        $tamu->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Data tamu berhasil dihapus!');
    }

    /**
     * Store an image from base64 data and return the path
     */
    private function storeImage($base64Image)
    {
        // Extract the actual base64 string from the data URL
        $imageData = substr($base64Image, strpos($base64Image, ',') + 1);
        $decodedImage = base64_decode($imageData);

        // Create a unique filename
        $filename = 'visitor_photos/' . Str::uuid() . '.jpg';

        // Store the image in the public disk
        Storage::disk('public')->put($filename, $decodedImage);

        return $filename;
    }

    public function getDetails(Tamu $id)
    {
        $visitor = $id;
        // Format the image URL
        if ($visitor->image_url) {
            $visitor->image_url = Storage::url($visitor->image_url);
        }

        // Format the date with WIB timezone
        $visitor->created_at = $visitor->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') . ' WIB';

        return response()->json($visitor);
    }

    /**
     * Show detailed visitor information
     */
}
