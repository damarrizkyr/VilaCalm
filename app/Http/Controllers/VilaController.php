<?php

namespace App\Http\Controllers;

use App\Models\Vila;
use App\Models\VilaImage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravolt\Indonesia\Models\Province;

class VilaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $vilas = Vila::with(['images', 'reviews']);
        $provinces = Province::all();

        // Filter nama
        if ($request->filled('search')) {
            $vilas->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Filter provinsi
        if ($request->filled('province_id')) {
            $vilas->where('province_id', $request->province_id);
        }

        // Filter kabupaten/kota
        if ($request->filled('regency_id')) {
            $vilas->where('regency_id', $request->regency_id);
        }

        $vilas = $vilas->paginate(10)->withQueryString();

        return view('home.home', compact('vilas', 'provinces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate(
            [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'facilities' => 'nullable|string',
                'address' => 'required|string|max:255',
                'province_id' => 'nullable|string',
                'regency_id' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'image' => 'nullable|array|max:5',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'name.required' => 'Nama vila wajib diisi.',
                'address.required' => 'Alamat wajib diisi.',
                'price.required' => 'Harga wajib diisi.',
                'price.numeric' => 'Harga harus berupa angka.',
                'price.min' => 'Harga tidak boleh kurang dari 0.',
                'image.array' => 'Gambar harus berupa array.',
                'image.max' => 'Maksimal 5 gambar yang diizinkan.',
                'image.*.image' => 'Setiap file harus berupa gambar.',
                'image.*.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif, svg.',
                'image.*.max' => 'Ukuran maksimal setiap gambar adalah 2MB.',
            ]
        );

        try {
            $data['user_id'] = Auth::id();
            $data['slug'] = Str::slug($data['name']) . '-' . uniqid();

            $images = $request->file('image');
            unset($data['image']);

            $vila = Vila::create($data);

            if ($images) {
                foreach ($images as $index => $imageFile) {
                    $path = $imageFile->store('image/vila', 'public');
                    $vila->images()->create([
                        'image_path' => $path,
                        'is_primary' => $index === 0,
                    ]);
                }
            }

            return redirect()->route('vilas.index')->with('success', 'Vila berhasil ditambahkan.');
            
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['msg' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vila $vila)
    {
        //
        $vila->load(['images', 'user', 'reviews.user' => function ($query) {
            $query->select('id', 'name');
        }]);

        $vila->total_reviews = $vila->reviews->count();
        $vila->rating = round($vila->reviews->avg('rating'), 1);

        // 3. Kirim data ke view
        return view('home.vila.detail', compact('vila'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vila $vila)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vila $vila)
    {
        //
        $data = $request->validate(
            [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'facilities' => 'nullable|string',
                'address' => 'required|string|max:255',
                'province_id' => 'nullable|string',
                'regency_id' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'image' => 'nullable|array|max:5',
                'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ],
            [
                'name.required' => 'Nama vila wajib diisi.',
                'address.required' => 'Alamat wajib diisi.',
                'price.required' => 'Harga wajib diisi.',
                'price.numeric' => 'Harga harus berupa angka.',
                'price.min' => 'Harga tidak boleh kurang dari 0.',
            ]
        );

        if ($vila->user_id !== Auth::id()) {
            abort(403);
        }

        unset($data['image']);

        if ($data['name'] !== $vila->name) {
            $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $imageFile) {
                // Simpan fisik file
                $path = $imageFile->store('image/vila', 'public');

                // Simpan ke database (VilaImage)
                $vila->images()->create([
                    'image_path' => $path,
                    'is_primary' => false, // Gambar tambahan defaultnya bukan primary
                ]);
            }
        }

        $vila->update($data);
        return redirect()->route('vilas.index')->with('success', 'Vila berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vila $vila)
    {
        //
        if ($vila->user_id !== Auth::id()) {
            abort(403);
        }

        // Keamanan: Cek apakah user yang menghapus adalah pemilik vila
        foreach ($vila->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        // 2. Hapus record Vila (Otomatis hapus record images di DB karena cascade)
        $vila->delete();

        return redirect()->route('vilas.index')->with('success', 'Vila berhasil dihapus.');
    }

    public function destroyImage($id) // Perhatikan parameternya $id, bukan $vila
    {
        $image = VilaImage::findOrFail($id);

        // Keamanan: Cek apakah user yang menghapus adalah pemilik vila
        $vila = $image->vila;
        if ($vila->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Hapus file fisik dari storage
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Hapus record dari database
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Gambar berhasil dihapus']);
    }

    // Menampilkan daftar vila milik admin yang sedang login
    public function adminIndex()
    {
        $vilas = Vila::where('user_id', Auth::id())->with('images')->latest()->paginate(10);
        return view('home.data-vila', compact('vilas'));
    }

    // Menampilkan detail keuangan dan list pembooking untuk satu vila
    public function adminShow(Vila $vila)
    {
        // Keamanan: Pastikan admin hanya melihat vila miliknya
        if ($vila->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        // Ambil data booking terkait vila ini
        $bookings = $vila->bookings()->latest()->get();

        // Hitung Statistik Keuangan
        $totalPaid = $bookings->where('payment_status', 'paid')->sum('total_price');
        $totalUnpaid = $bookings->where('payment_status', 'unpaid')->sum('total_price');

        // PERUBAHAN DISINI:
        // Menghitung jumlah booking yang statusnya 'paid' (Bukan jumlah tamu)
        $totalBookings = $bookings->where('payment_status', 'paid')->count();

        return view('home.pembooking.detail-pembooking', compact(
            'vila',
            'bookings',
            'totalPaid',
            'totalUnpaid',
            'totalBookings' // Ganti totalGuests jadi totalBookings
        ));
    }
}
