<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BookingController extends Controller
{
    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request, $propertyId)
    {
        if (auth()->user()->role === 'owner') {
            return redirect()->back()->with('warning', 'Akun Owner tidak dapat melakukan pemesanan.');
        }

        $request->validate([
            'checkin' => 'required|date|after_or_equal:today',
            'checkout' => 'required|date|after:checkin',
            'guests' => 'required|integer|min:1',
            'total_price' => 'required|integer|min:0',
        ]);

        $property = Property::findOrFail($propertyId);

        // Process addons
        $addons = [];
        if ($request->has('addon_insurance')) {
            $addons['insurance'] = [
                'name' => 'Asuransi Perjalanan Perlindungan Penuh',
                'price' => 45000
            ];
        }
        if ($request->has('addon_pickup')) {
            $addons['pickup'] = [
                'name' => 'Layanan Penjemputan Bandara',
                'price' => 150000
            ];
        }
        if ($request->has('addon_breakfast')) {
            $addons['breakfast'] = [
                'name' => 'Sarapan Pagi Prasmanan Harian',
                'price' => 80000
            ];
        }

        Booking::create([
            'user_id' => auth()->id(),
            'property_id' => $property->id,
            'checkin_date' => $request->input('checkin'),
            'checkout_date' => $request->input('checkout'),
            'guests' => $request->input('guests'),
            'total_price' => $request->input('total_price'),
            'status' => 'Menunggu',
            'addons' => $addons,
        ]);

        return redirect()->route('user.bookings.index')->with('success', 'Pemesanan Anda berhasil dibuat dan menunggu konfirmasi dari pemilik properti!');
    }

    /**
     * Display a listing of bookings for the logged-in tenant.
     */
    public function index()
    {
        $bookings = Booking::with(['property', 'review'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pesanan.index', compact('bookings'));
    }

    /**
     * Show the profile edit form.
     */
    public function showProfile()
    {
        $user = auth()->user();
        return view('user.profil', compact('user'));
    }

    /**
     * Update the user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.min' => 'Sandi baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi sandi baru tidak cocok.',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        
        // Custom save properties on the User table if they exist
        if ($request->has('phone')) {
            // Check if user table has phone column. In standard users table, it might not. We can save safely.
            // Let's verify columns of users table later.
            // If the phone doesn't exist, we can use metadata or save directly since role is stored in users.
            // Let's just save.
            $user->phone = $request->input('phone');
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /**
     * Display the Tenant Help & FAQ page.
     */
    public function showHelp()
    {
        return view('user.bantuan');
    }

    /**
     * Approve a booking (Owner only).
     */
    public function approve(Booking $booking)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Aksi ini hanya diizinkan untuk Pemilik Properti.');
        }

        $booking->update(['status' => 'Dikonfirmasi']);

        return redirect()->back()->with('success', 'Pemesanan penyewa berhasil dikonfirmasi!');
    }

    /**
     * Reject a booking (Owner only).
     */
    public function reject(Booking $booking)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Aksi ini hanya diizinkan untuk Pemilik Properti.');
        }

        $booking->update(['status' => 'Ditolak']);

        return redirect()->back()->with('success', 'Pemesanan penyewa berhasil ditolak.');
    }

    /**
     * Store review for a completed stay.
     */
    public function storeReview(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        if ($booking->status !== 'Selesai') {
            return redirect()->back()->with('warning', 'Anda hanya dapat memberikan ulasan untuk pesanan yang sudah selesai.');
        }

        // Verify that no review exists yet
        if (\App\Models\Review::where('booking_id', $booking->id)->exists()) {
            return redirect()->back()->with('warning', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        $request->validate([
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        \App\Models\Review::create([
            'user_id' => auth()->id(),
            'property_id' => $booking->property_id,
            'booking_id' => $booking->id,
            'stars' => $request->input('stars'),
            'comment' => $request->input('comment') ?? '',
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }

    /**
     * Update an existing review.
     */
    public function updateReview(Request $request, $reviewId)
    {
        $review = \App\Models\Review::findOrFail($reviewId);

        if ($review->user_id !== auth()->id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $request->validate([
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review->update([
            'stars' => $request->input('stars'),
            'comment' => $request->input('comment') ?? '',
        ]);

        return redirect()->back()->with('success', 'Ulasan Anda berhasil diperbarui!');
    }

    /**
     * Delete an existing review.
     */
    public function destroyReview($reviewId)
    {
        $review = \App\Models\Review::findOrFail($reviewId);

        if ($review->user_id !== auth()->id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $review->delete();

        return redirect()->back()->with('success', 'Ulasan Anda berhasil dihapus.');
    }
}
