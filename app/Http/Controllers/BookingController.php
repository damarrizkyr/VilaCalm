<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Vila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Vila $vila)
    {
        //
        $bookedRanges = Booking::where('vila_id', $vila->id)
        ->whereIn('payment_status', ['paid', 'pending'])
        ->where('status', '!=', 'cancelled')
        ->get(['check_in', 'check_out']);

    return view('home.vila.bookings.booking', compact('vila', 'bookedRanges'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate(
            [
                'vila_id' => 'required|exists:vilas,id',
                'check_in' => 'required|date',
                'check_out' => 'required|date|after_or_equal:check_in',
                'guest_count' => 'required|integer|min:1',

            ],
            [
                'vila_id.required' => 'Vila tidak boleh kosong.',
                'vila_id.exists' => 'Vila tidak ditemukan.',
                'check_in.required' => 'Tanggal check-in tidak boleh kosong.',
                'check_in.date' => 'Tanggal check-in harus berupa tanggal yang valid.',
                'check_out.required' => 'Tanggal check-out tidak boleh kosong.',
                'check_out.date' => 'Tanggal check-out harus berupa tanggal yang valid.',
                'check_out.after_or_equal' => 'Tanggal check-out harus setelah atau sama dengan tanggal check-in.',
                'guest_count.required' => 'Jumlah tamu tidak boleh kosong.',
                'guest_count.integer' => 'Jumlah tamu harus berupa angka bulat.',
                'guest_count.min' => 'Jumlah tamu minimal adalah 1.',

            ]
        );

        // 2. AMBIL DATA VILA & HITUNG HARGA (Server Side Calculation)
        $vila = Vila::findOrFail($request->vila_id);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);

        // Hitung selisih hari
        $totalDays = $checkIn->diffInDays($checkOut);
        if ($totalDays < 1) $totalDays = 1;

        // Hitung Total Harga
        $totalPrice = $totalDays * $vila->price;

        // 3. SIMPAN KE DATABASE
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'vila_id' => $vila->id,
            'booking_code' => Booking::generateBookingCode(),
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_days' => $totalDays,
            'guest_count' => $request->guest_count,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'expired_at' => now()->addDay(),
        ]);

        // 4. REDIRECT KE HALAMAN PEMBAYARAN (PENTING!)
        $booking->load('vila', 'user');

        // 4. RETURN JSON (Untuk Pop-Up)
        return response()->json([
            'success' => true,
            'booking' => $booking,
            'redirect_url' => route('vilas.index')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }

    public function payment(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->load('vila');

        return view('home.vila.bookings.pay', compact('booking'));
    }

    public function confirmPayment(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Cek expired
        if (now()->greaterThan(Carbon::parse($booking->expired_at))) {
            $booking->update([
                'status' => 'cancelled',
                'payment_status' => 'expired'
            ]);
            return response()->json(['success' => false, 'message' => 'Waktu pembayaran habis. Booking dibatalkan.']);
        }

        $booking->update([
            'payment_status' => 'paid',
            'status' => 'confirmed'
        ]);

        return response()->json(['success' => true, 'message' => 'Pembayaran berhasil!']);
    }

    public function history( )
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['vila', 'vila.reviews'])
            ->latest()
            ->paginate(5);

        return view('home.riwayat', compact('bookings'));
    }

    public function adminUpdate(Request $request, Booking $booking)
    {
        // 1. Validasi Input
        $request->validate([
            'check_in' => 'required|date',
            'status' => 'nullable|in:confirmed,completed'
        ]);

        // 2. Logika Perubahan Tanggal
        if ($request->check_in != $booking->check_in) {
            $today = Carbon::now();
            $originalCheckIn = Carbon::parse($booking->check_in);

            $daysUntilCheckIn = $today->diffInDays($originalCheckIn, false);

            if ($daysUntilCheckIn <= 1) {
                return back()->with('error', 'Tanggal Check-in tidak bisa diubah karena sudah mendekati hari H (Maksimal H-2).');
            }

            // Hitung Tanggal Check-out Baru (Durasi Tetap)
            $newCheckIn = Carbon::parse($request->check_in);
            $newCheckOut = $newCheckIn->copy()->addDays($booking->total_days);

            $booking->check_in = $newCheckIn->format('Y-m-d');
            $booking->check_out = $newCheckOut->format('Y-m-d');
        }

        // 3. Logika Perubahan Status
        if ($request->has('status') && $booking->status === 'confirmed' && $request->status === 'completed') {
            $booking->status = 'completed';
        }

        $booking->save();

        return back()->with('success', 'Data pembooking berhasil diperbarui.');
    }

    public function adminCancel(Booking $booking)
    {
        if ($booking->status === 'completed') {
            return back()->with('error', 'Booking yang sudah selesai tidak bisa dibatalkan.');
        }

        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking berhasil dibatalkan.');
    }

    public function adminDestroy(Booking $booking)
    {
        if ($booking->status !== 'cancelled') {
            return back()->with('error', 'Hanya data booking yang dibatalkan yang boleh dihapus.');
        }

        $booking->delete();
        return back()->with('success', 'Data booking berhasil dihapus permanen.');
    }

    public function receipt(Booking $booking)
    {
        if ($booking->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }
        if ($booking->payment_status !== 'paid') {
            return redirect()->route('home')->with('error', 'Pembayaran belum lunas.');
        }

        return view('home.vila.bookings.struk', compact('booking'));
    }
}
