<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'properties_count' => Property::count(),
            'bookings_count' => \App\Models\Booking::whereIn('status', ['Menunggu', 'Dikonfirmasi'])->count(),
            'articles_count' => BlogPost::count(),
            'views_count' => Property::sum('views'),
        ];

        $recentBookings = \App\Models\Booking::with(['user', 'property'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('owner.dashboard', compact('stats', 'recentBookings'));
    }

    /* -------------------------------------------------------------
     * PROPERTIES CRUD
     * ------------------------------------------------------------- */
    public function propertyIndex()
    {
        $properties = Property::orderBy('created_at', 'desc')->paginate(10);
        return view('owner.properti.index', compact('properties'));
    }

    public function propertyCreate()
    {
        return view('owner.properti.create');
    }

    public function propertyStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:apartemen,villa,rumah',
            'price' => 'required|integer|min:0',
            'address' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'required|integer|min:1',
            'floors' => 'nullable|integer|min:0',
            'garage' => 'nullable|string|max:255',
            'year_built' => 'nullable|integer|min:1000|max:3000',
            'certificate' => 'nullable|string|max:255',
            'electricity' => 'nullable|integer|min:0',
            'water_source' => 'nullable|string|max:255',
            'facilities' => 'nullable|array',
            'images_urls' => 'nullable|array',
            'images_files' => 'nullable|array',
            'images_files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $facilities = $request->input('facilities') ?: [];
        $images = $request->input('images_urls') ?: [];

        if ($request->hasFile('images_files')) {
            $uploadPath = public_path('uploads/properties');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            foreach ($request->file('images_files') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadPath, $filename);
                    $images[] = '/uploads/properties/' . $filename;
                }
            }
        }
        
        // Use first image as main thumbnail, or fallback
        $mainImage = count($images) > 0 ? $images[0] : 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80&w=600';

        Property::create([
            'title' => $request->input('title'),
            'type' => $request->input('type'),
            'price' => $request->input('price'),
            'stars' => 5, // Default rating (not input by owner)
            'address' => $request->input('address'),
            'location' => $request->input('location'),
            'image' => $mainImage,
            'description' => $request->input('description'),
            'bedrooms' => $request->input('bedrooms'),
            'bathrooms' => $request->input('bathrooms'),
            'area' => $request->input('area'),
            'floors' => $request->input('floors'),
            'garage' => $request->input('garage'),
            'year_built' => $request->input('year_built'),
            'certificate' => $request->input('certificate'),
            'electricity' => $request->input('electricity'),
            'water_source' => $request->input('water_source'),
            'facilities' => $facilities,
            'images' => $images,
        ]);

        return redirect()->route('owner.properties.index')->with('success', 'Properti baru berhasil ditambahkan!');
    }

    public function propertyShow(Property $property)
    {
        $reviews = \App\Models\Review::with('user')
            ->where('property_id', $property->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('owner.properti.show', compact('property', 'reviews'));
    }



    public function propertyEdit(Property $property)
    {
        return view('owner.properti.edit', compact('property'));
    }

    public function propertyUpdate(Request $request, Property $property)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:apartemen,villa,rumah',
            'price' => 'required|integer|min:0',
            'address' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'area' => 'required|integer|min:1',
            'floors' => 'nullable|integer|min:0',
            'garage' => 'nullable|string|max:255',
            'year_built' => 'nullable|integer|min:1000|max:3000',
            'certificate' => 'nullable|string|max:255',
            'electricity' => 'nullable|integer|min:0',
            'water_source' => 'nullable|string|max:255',
            'facilities' => 'nullable|array',
            'images_urls' => 'nullable|array',
            'images_files' => 'nullable|array',
            'images_files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $facilities = $request->input('facilities') ?: [];
        $images = $request->input('images_urls') ?: [];

        if ($request->hasFile('images_files')) {
            $uploadPath = public_path('uploads/properties');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            foreach ($request->file('images_files') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadPath, $filename);
                    $images[] = '/uploads/properties/' . $filename;
                }
            }
        }
        
        $mainImage = count($images) > 0 ? $images[0] : $property->image;

        $property->update([
            'title' => $request->input('title'),
            'type' => $request->input('type'),
            'price' => $request->input('price'),
            'address' => $request->input('address'),
            'location' => $request->input('location'),
            'image' => $mainImage,
            'description' => $request->input('description'),
            'bedrooms' => $request->input('bedrooms'),
            'bathrooms' => $request->input('bathrooms'),
            'area' => $request->input('area'),
            'floors' => $request->input('floors'),
            'garage' => $request->input('garage'),
            'year_built' => $request->input('year_built'),
            'certificate' => $request->input('certificate'),
            'electricity' => $request->input('electricity'),
            'water_source' => $request->input('water_source'),
            'facilities' => $facilities,
            'images' => $images,
        ]);

        return redirect()->route('owner.properties.index')->with('success', 'Properti berhasil diperbarui!');
    }

    public function propertyDestroy(Property $property)
    {
        $property->delete();
        return redirect()->route('owner.properties.index')->with('success', 'Properti berhasil dihapus!');
    }

    /* -------------------------------------------------------------
     * BLOG CRUD
     * ------------------------------------------------------------- */
    public function blogIndex()
    {
        // Articles written by others
        $othersPosts = BlogPost::where('is_own', false)->orderBy('created_at', 'desc')->get();

        // Articles written by this owner
        $myPosts = BlogPost::where('is_own', true)->orderBy('created_at', 'desc')->get();

        return view('owner.blog.index', compact('othersPosts', 'myPosts'));
    }

    public function blogCreate()
    {
        return view('owner.blog.create');
    }

    public function blogStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|url',
        ]);

        $image = $request->input('image') ?: 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=600';
        $title = $request->input('title');
        
        BlogPost::create([
            'title' => $title,
            'slug' => Str::slug($title) . '-' . uniqid(),
            'category' => $request->input('category'),
            'content' => $request->input('content'),
            'author' => 'Anda (Pemilik Properti)',
            'image' => $image,
            'is_own' => true,
        ]);

        return redirect()->route('owner.blog.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function blogShow($slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        return view('owner.blog.show', compact('post'));
    }

    public function blogEdit($slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        
        // Safety guard: only allow editing own posts
        if (!$post->is_own) {
            abort(403, 'Anda tidak diizinkan mengubah artikel ini.');
        }

        return view('owner.blog.edit', compact('post'));
    }

    public function blogUpdate(Request $request, $slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        
        if (!$post->is_own) {
            abort(403, 'Anda tidak diizinkan mengubah artikel ini.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|url',
        ]);

        $image = $request->input('image') ?: $post->image;

        $post->update([
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'content' => $request->input('content'),
            'image' => $image,
        ]);

        return redirect()->route('owner.blog.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function blogDestroy($slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        
        if (!$post->is_own) {
            abort(403, 'Anda tidak diizinkan menghapus artikel ini.');
        }

        $post->delete();

        return redirect()->route('owner.blog.index')->with('success', 'Artikel berhasil dihapus!');
    }

    /* -------------------------------------------------------------
     * REPORTS & EXPORT
     * ------------------------------------------------------------- */
    public function laporanIndex()
    {
        $properties = Property::orderBy('title', 'asc')->get();

        // Mock dynamic details for reports
        $reports = [
            ['month' => 'Januari', 'revenue' => 45000000, 'bookings' => 3, 'occupancy' => 80],
            ['month' => 'Februari', 'revenue' => 50000000, 'bookings' => 4, 'occupancy' => 85],
            ['month' => 'Maret', 'revenue' => 38000000, 'bookings' => 3, 'occupancy' => 75],
            ['month' => 'April', 'revenue' => 62000000, 'bookings' => 5, 'occupancy' => 90],
            ['month' => 'Mei', 'revenue' => 75000000, 'bookings' => 6, 'occupancy' => 95],
        ];

        $totals = [
            'revenue' => array_sum(array_column($reports, 'revenue')),
            'bookings' => array_sum(array_column($reports, 'bookings')),
            'avg_occupancy' => round(array_sum(array_column($reports, 'occupancy')) / count($reports)),
        ];

        return view('owner.laporan', compact('reports', 'totals', 'properties'));
    }

    public function laporanExport()
    {
        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=laporan_bulanan_managee.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $reports = [
            ['month' => 'Januari', 'revenue' => 45000000, 'bookings' => 3, 'occupancy' => 80],
            ['month' => 'Februari', 'revenue' => 50000000, 'bookings' => 4, 'occupancy' => 85],
            ['month' => 'Maret', 'revenue' => 38000000, 'bookings' => 3, 'occupancy' => 75],
            ['month' => 'April', 'revenue' => 62000000, 'bookings' => 5, 'occupancy' => 90],
            ['month' => 'Mei', 'revenue' => 75000000, 'bookings' => 6, 'occupancy' => 95],
        ];

        $callback = function() use ($reports) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for proper excel encoding
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Columns Header
            fputcsv($file, ['Bulan', 'Pendapatan (IDR)', 'Jumlah Pemesanan', 'Tingkat Okupansi (%)']);
            
            foreach ($reports as $row) {
                fputcsv($file, [
                    $row['month'],
                    number_format($row['revenue'], 0, '', ''),
                    $row['bookings'],
                    $row['occupancy']
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function bookingIndex()
    {
        $properties = Property::orderBy('title', 'asc')->get();
        
        // Fetch all bookings from database with user and property relationships
        $bookings = \App\Models\Booking::with(['user', 'property'])->orderBy('created_at', 'desc')->get();

        return view('owner.pemesanan.index', compact('bookings', 'properties'));
    }

    public function keuanganIndex()
    {
        $properties = Property::orderBy('title', 'asc')->get();

        $keuangan = [
            'saldo_aktif' => 42500000,
            'saldo_tertahan' => 12000000,
            'total_pendapatan' => 74500000,
            'bank_info' => [
                'nama_bank' => 'Bank Central Asia (BCA)',
                'nomor_rekening' => '8012998811',
                'nama_pemilik' => auth()->user()->name
            ],
            'riwayat_penarikan' => [
                [
                    'id' => 'WD003',
                    'tanggal' => '02 Jun 2026',
                    'jumlah' => 15000000,
                    'status' => 'Sukses',
                    'bank' => 'BCA - 8012****11'
                ],
                [
                    'id' => 'WD002',
                    'tanggal' => '15 Mei 2026',
                    'jumlah' => 20000000,
                    'status' => 'Sukses',
                    'bank' => 'BCA - 8012****11'
                ]
            ],
            'riwayat_transaksi' => [
                [
                    'tanggal' => '08 Jun 2026',
                    'tipe' => 'Pemasukan',
                    'deskripsi' => 'Pemasanan #b1 - Rudi Hermawan (Apartemen Chilitown)',
                    'jumlah' => 12500000,
                    'status' => 'Selesai'
                ],
                [
                    'tanggal' => '02 Jun 2026',
                    'tipe' => 'Penarikan Dana',
                    'deskripsi' => 'Penarikan Dana ke BCA (' . auth()->user()->name . ')',
                    'jumlah' => -15000000,
                    'status' => 'Sukses'
                ],
                [
                    'tanggal' => '25 Mei 2026',
                    'tipe' => 'Pemasukan',
                    'deskripsi' => 'Pemasanan #b4 - Andi Wijaya (Villa Canggu)',
                    'jumlah' => 12000000,
                    'status' => 'Selesai'
                ],
                [
                    'tanggal' => '15 Mei 2026',
                    'tipe' => 'Penarikan Dana',
                    'deskripsi' => 'Penarikan Dana ke BCA (' . auth()->user()->name . ')',
                    'jumlah' => -20000000,
                    'status' => 'Sukses'
                ]
            ]
        ];

        // Consolidated Reports Data
        $reports = [
            ['month' => 'Januari', 'revenue' => 45000000, 'bookings' => 3, 'occupancy' => 80],
            ['month' => 'Februari', 'revenue' => 50000000, 'bookings' => 4, 'occupancy' => 85],
            ['month' => 'Maret', 'revenue' => 38000000, 'bookings' => 3, 'occupancy' => 75],
            ['month' => 'April', 'revenue' => 62000000, 'bookings' => 5, 'occupancy' => 90],
            ['month' => 'Mei', 'revenue' => 75000000, 'bookings' => 6, 'occupancy' => 95],
        ];

        $totals = [
            'revenue' => array_sum(array_column($reports, 'revenue')),
            'bookings' => array_sum(array_column($reports, 'bookings')),
            'avg_occupancy' => round(array_sum(array_column($reports, 'occupancy')) / count($reports)),
        ];

        return view('owner.keuangan', compact('keuangan', 'properties', 'reports', 'totals'));
    }

    public function promoIndex()
    {
        $properties = Property::orderBy('title', 'asc')->get();

        $promos = [
            [
                'id' => 1,
                'code' => 'WEEKENDSERU',
                'discount_percent' => 10,
                'target_property' => 'Villa Canggu',
                'start_date' => '01 Jun 2026',
                'end_date' => '30 Jun 2026',
                'status' => 'Aktif',
                'used_count' => 8
            ],
            [
                'id' => 2,
                'code' => 'EARLYBIRD20',
                'discount_percent' => 20,
                'target_property' => 'Semua Properti',
                'start_date' => '05 Jun 2026',
                'end_date' => '15 Jul 2026',
                'status' => 'Aktif',
                'used_count' => 3
            ],
            [
                'id' => 3,
                'code' => 'PROMOHEMAT',
                'discount_percent' => 15,
                'target_property' => 'Rumah Modern Ubud',
                'start_date' => '01 Jan 2026',
                'end_date' => '31 Jan 2026',
                'status' => 'Berakhir',
                'used_count' => 12
            ]
        ];

        return view('owner.promo', compact('promos', 'properties'));
    }

    public function profilIndex()
    {
        $user = auth()->user();
        $profil = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => '081234567890',
            'avatar' => strtoupper(substr($user->name, 0, 1)),
            'bio' => 'Pemilik beberapa properti penginapan premium di wilayah Canggu, Ubud, dan sekitarnya. Fokus memberikan kenyamanan sewa maksimal bagi para wisatawan.',
            'address' => 'Jl. Canggu Raya No. 45, Badung, Bali',
            'member_since' => 'Maret 2025'
        ];

        return view('owner.profil', compact('profil'));
    }

    public function ulasanIndex()
    {
        $reviews = \App\Models\Review::with(['user', 'property'])->orderBy('created_at', 'desc')->get();
        return view('owner.ulasan', compact('reviews'));
    }

    public function ulasanReply(Request $request, \App\Models\Review $review)
    {
        $request->validate([
            'reply' => 'required|string',
        ], [
            'reply.required' => 'Tanggapan wajib diisi.',
        ]);

        $review->update([
            'reply' => $request->input('reply')
        ]);

        return redirect()->back()->with('success', 'Tanggapan ulasan berhasil disimpan!');
    }

    public function ulasanDeleteReply(\App\Models\Review $review)
    {
        $review->update([
            'reply' => null
        ]);

        return redirect()->back()->with('success', 'Tanggapan ulasan berhasil dihapus!');
    }





    public function bantuanIndex()
    {
        $faqs = [
            [
                'question' => 'Bagaimana cara mendaftarkan properti baru?',
                'answer' => 'Masuk ke menu "Properti Saya", lalu klik tombol "Tambah Properti" di kanan atas. Isi semua informasi spesifikasi, fasilitas, serta tempelkan URL foto properti Anda.'
            ],
            [
                'question' => 'Bagaimana mekanisme persetujuan sewa/booking?',
                'answer' => 'Semua permintaan sewa masuk dapat dipantau di halaman "Pemesanan". Klik "Terima" jika jadwal tersedia atau "Tolak" jika berhalangan. Status sewa akan ter-update otomatis.'
            ],
            [
                'question' => 'Kapan saldo pendapatan sewa saya bisa ditarik?',
                'answer' => 'Dana dari transaksi penyewaan akan tertahan di sistem hingga H+2 dari hari check-out penyewa untuk memastikan perlindungan kenyamanan bersama. Setelah H+2, dana akan masuk ke Saldo Aktif dan dapat ditarik mandiri.'
            ],
            [
                'question' => 'Bagaimana cara membuat promo diskon untuk villa?',
                'answer' => 'Buka halaman "Properti Saya", klik tombol "Kelola Promo" di panel atas, lalu buat kode voucher promosi sesuai kebutuhan (diskon persen, periode, dan properti sasaran).'
            ],
            [
                'question' => 'Apakah ulasan negatif dari tamu bisa dihapus?',
                'answer' => 'Demi menjaga transparansi dan kredibilitas platform (sesuai sistem ulasan standar), ulasan negatif tidak dapat dihapus. Namun, Anda dapat menulis klarifikasi balasan secara sopan pada kolom ulasan.'
            ]
        ];

        return view('owner.bantuan', compact('faqs'));
    }
}
