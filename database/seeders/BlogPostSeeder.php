<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate table first to avoid duplication/unique constraint errors
        \Illuminate\Support\Facades\DB::table('blog_posts')->truncate();

        $posts = [
            // RENTER BLOG ARTICLES (is_own = false)
            [
                'title' => '10 Tempat Kuliner lokal terkenal di Bali',
                'slug' => '10-tempat-kuliner-lokal-terkenal-di-bali',
                'content' => "Bali bukan hanya surga bagi para pecinta pantai, melainkan juga pusat petualangan kuliner tradisional yang kaya akan bumbu dan rempah khas Nusantara. Berbagai olahan sate, nasi campur, dan sup kepala ikan menjadi menu wajib yang harus Anda cicipi.\n\nSalah satu tempat yang sangat direkomendasikan adalah Warung Mak Beng di Sanur. Warung legendaris yang berdiri sejak tahun 1941 ini menyajikan menu tunggal yang sangat khas, yaitu sup kepala ikan bumbu kuning dan ikan goreng renyah yang dipadukan dengan sambal terasi super pedas.\n\nBagi Anda pencinta olahan daging panggang, Sate Plecing Arjuna di Denpasar menawarkan kelembutan daging sate sapi atau babi yang disiram dengan sambal plecing cabai rawit merah segar khas Bali. Cita rasa pedas-gurih berpadu dengan asam jeruk limau yang menyegarkan.\n\nTidak kalah legendaris, Nasi Ayam Kedewatan Ibu Mangku di Ubud menyajikan satu piring nasi campur komplit dengan ayam sisit pedas, sate lilit ikan, sayur urap base genep, kacang goreng, dan sambal embe khas Bali. Pilihan kuliner lokal ini dijamin akan melengkapi kenangan liburan Anda di Pulau Dewata.",
                'author' => 'Rocky Gerung',
                'category' => 'Kuliner',
                'image' => 'https://images.unsplash.com/photo-1596797038530-2c107229654b?auto=format&fit=crop&q=80&w=800',
                'is_own' => false,
                'views' => 1500,
            ],
            [
                'title' => 'Waterpark yang menyegarkan di cuaca panas',
                'slug' => 'waterpark-yang-menyegarkan-di-cuaca-panas',
                'content' => "Tinggal di negara tropis dengan cuaca yang sering kali sangat panas menuntut kita mencari alternatif rekreasi yang menyegarkan. Mengunjungi wahana rekreasi air atau waterpark menjadi solusi paling seru untuk melepas penat bersama keluarga atau teman-teman.\n\nSalah satu destinasi terbaik di Indonesia adalah Waterbom Bali yang berlokasi di jantung area Kuta. Dikelilingi hutan tropis yang rimbun dan teduh, waterpark ini menawarkan sensasi seluncuran ekstrem seperti 'Climax' yang memiliki jalur terjun vertikal, hingga 'Lazy River' bagi yang ingin bersantai di atas ban mengalir.\n\nSelain menikmati wahana air yang memacu adrenalin, mengunjungi waterpark modern memberikan fasilitas kebersihan dan sistem sirkulasi air yang canggih sehingga aman untuk kesehatan kulit anak-anak. Pastikan Anda mengenakan tabir surya dan memilih tiket terusan untuk pengalaman bermain seharian penuh yang maksimal.",
                'author' => 'Tirta Pratama',
                'category' => 'Lainnya',
                'image' => 'https://images.unsplash.com/photo-1582650625119-3a31f8fa2699?auto=format&fit=crop&q=80&w=800',
                'is_own' => false,
                'views' => 1200,
            ],
            [
                'title' => 'Panduan kewajiban pajak pemilik properti',
                'slug' => 'panduan-kewajiban-pajak-pemilik-properti',
                'content' => "Sebagai pemilik properti, baik berupa tanah kosong, rumah tinggal, ruko, maupun unit apartemen, Anda memiliki serangkaian kewajiban perpajakan yang diatur oleh undang-undang nasional. Memahami regulasi ini sangat penting untuk menjamin legalitas aset Anda.\n\nKewajiban paling umum adalah Pajak Bumi dan Bangunan (PBB) sektor Pedesaan dan Perkotaan (PBB-P2). PBB wajib dibayarkan setiap tahun sebelum jatuh tempo yang biasanya ditetapkan pada tanggal 31 Agustus. Nilai pajak ditentukan berdasarkan NJOP (Nilai Jual Objek Pajak) tanah dan bangunan di wilayah Anda.\n\nSelain PBB, jika Anda memutuskan untuk menyewakan properti Anda kepada orang lain, terdapat Pajak Penghasilan (PPh) Final atas Persewaan Tanah dan/atau Bangunan. PPh Final ini bermuatan tarif flat sebesar 10% dari jumlah bruto nilai persewaan dan wajib disetorkan paling lambat tanggal 15 bulan berikutnya setelah transaksi dilakukan.",
                'author' => 'Gia Kurniawan',
                'category' => 'Hukum & Regulasi',
                'image' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?auto=format&fit=crop&q=80&w=500',
                'is_own' => false,
                'views' => 900,
            ],
            [
                'title' => '7 Ide dekorasi apartemen studio agar terlihat luas',
                'slug' => '7-ide-dekorasi-apartemen-studio-agar-terlihat-luas',
                'content' => "Memiliki apartemen tipe studio dengan ruang terbatas menantang kita untuk berpikir kreatif dalam menata interior. Kunci utama dalam mendekorasi ruang kecil adalah mengutamakan fungsionalitas tanpa mengorbankan estetika visual.\n\nLangkah pertama adalah memilih furnitur multifungsi (smart furniture), seperti tempat tidur yang memiliki laci penyimpanan di bagian bawahnya, atau meja makan lipat yang menempel di dinding. Ini akan menghemat area lantai yang berharga.\n\nGunakan teknik penempatan cermin besar secara strategis di dinding yang berhadapan langsung dengan jendela untuk memantulkan cahaya alami. Hal ini secara instan menciptakan ilusi kedalaman ruang. Padukan pula dengan pemilihan cat warna netral seperti putih, krem, atau abu-abu muda untuk kesan yang lapang dan segar.",
                'author' => 'Sarah Wijaya',
                'category' => 'Dekorasi & Renovasi',
                'image' => 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&q=80&w=500',
                'is_own' => false,
                'views' => 800,
            ],
            [
                'title' => 'Cara efektif merawat AC apartemen agar tetap dingin',
                'slug' => 'cara-efektif-merawat-ac-apartemen-agar-tetap-dingin',
                'content' => "Air Conditioner (AC) yang bekerja terus-menerus di apartemen memerlukan perawatan rutin agar performanya tetap optimal, hemat listrik, dan udara yang dihasilkan tetap bersih serta sejuk untuk kesehatan pernapasan Anda.\n\nPerawatan mandiri yang paling mendasar adalah membersihkan filter udara AC minimal dua minggu sekali. Filter yang tertutup debu tebal menghalangi sirkulasi udara dingin dan memaksa kompresor bekerja lebih keras sehingga tagihan listrik membengkak.\n\nSelain membersihkan filter, jadwalkan pencucian unit indoor dan outdoor AC oleh teknisi profesional setiap 3-4 bulan sekali untuk membersihkan evaporator dan kondensator, serta mengecek volume freon. Perawatan berkala ini akan memperpanjang umur pakai AC apartemen Anda.",
                'author' => 'Budi Santoso',
                'category' => 'Perawatan & Fasilitas',
                'image' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&q=80&w=800',
                'is_own' => false,
                'views' => 700,
            ],
            [
                'title' => 'Panduan Hukum: Poin penting surat perjanjian sewa',
                'slug' => 'panduan-hukum-poin-penting-surat-perjanjian-sewa',
                'content' => "Sebelum menyerahkan kunci properti kepada penyewa atau menempati properti sewaan, keberadaan Surat Perjanjian Sewa Menyewa tertulis di atas meterai adalah hal wajib untuk melindungi hak dan kewajiban masing-masing pihak.\n\nBeberapa poin krusial yang wajib tercantum dengan detail di antaranya adalah identitas lengkap para pihak, durasi masa sewa beserta tanggal mulai dan berakhir, besaran harga sewa beserta metode pembayaran, serta peruntukan properti (misalnya hanya untuk hunian, bukan tempat usaha).\n\nJangan lupa menyertakan klausul khusus mengenai uang deposit jaminan kerusakan, tanggung jawab pembayaran tagihan utilitas (listrik, air, internet), serta sanksi atau denda keterlambatan jika penyewa terlambat mengosongkan properti setelah masa kontrak habis.",
                'author' => 'Gia Kurniawan',
                'category' => 'Hukum & Regulasi',
                'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&q=80&w=500',
                'is_own' => false,
                'views' => 600,
            ],
            [
                'title' => 'Cara memilih warna cat sesuai psikologi ruang',
                'slug' => 'cara-memilih-warna-cat-sesuai-psikologi-ruang',
                'content' => "Warna dinding rumah bukan sekadar dekorasi, melainkan memiliki pengaruh psikologis yang kuat terhadap suasana hati, tingkat stres, produktivitas, dan energi penghuninya sehari-hari.\n\nWarna biru dan hijau sangat ideal diaplikasikan pada kamar tidur karena memiliki sifat menenangkan (*calming effect*) yang membantu menurunkan detak jantung dan merangsang tidur yang nyenyak. Sedangkan untuk ruang keluarga, warna-warna hangat seperti terakota atau krem menciptakan kesan akrab dan ramah.\n\nBagi Anda yang memiliki ruang kerja di rumah, warna kuning cerah atau jingga muda dapat meningkatkan stimulasi mental dan kreativitas. Hindari penggunaan warna merah terang secara dominan karena cenderung memicu ketegangan saraf jika dilihat terlalu lama.",
                'author' => 'Clara Shinta',
                'category' => 'Dekorasi & Renovasi',
                'image' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&q=80&w=500',
                'is_own' => false,
                'views' => 500,
            ],
            [
                'title' => 'Checklist sebelum menyewa properti pertama kali',
                'slug' => 'checklist-sebelum-menyewa-properti-pertama-kali',
                'content' => "Menyewa properti untuk pertama kalinya adalah langkah besar yang memerlukan ketelitian. Agar tidak menyesal setelah menandatangani kontrak, lakukan survei lokasi secara langsung dengan membawa checklist penting.\n\nPeriksa kualitas air bersih dan kekuatan aliran listrik apakah mencukupi kebutuhan alat elektronik Anda. Uji keran air, kelancaran saluran pembuangan kamar mandi, serta periksa apakah ada bekas kebocoran atau jamur pada plafon dan dinding.\n\nTanyakan juga secara mendetail kepada pemilik tentang biaya tersembunyi seperti iuran kebersihan lingkungan (IPL), biaya keamanan, tempat parkir kendaraan, serta pastikan Anda mencoba menempuh rute harian Anda dari properti tersebut menuju tempat kerja untuk mengukur waktu perjalanan.",
                'author' => 'Andi Wijaya',
                'category' => 'Panduan Penyewa',
                'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=500',
                'is_own' => false,
                'views' => 400,
            ],
            // Original Owner Blog Posts
            [
                'title' => '5 Tips Jitu Menarik Minat Penyewa Rumah',
                'slug' => '5-tips-jitu-menarik-minat-penyewa-rumah',
                'content' => "Menyewakan properti bisa menjadi investasi yang sangat menguntungkan jika dikelola dengan benar. Berikut adalah 5 tips jitu untuk menarik minat calon penyewa:\n\n1. Jaga Kebersihan dan Kerapian Properti: Pastikan dinding bercat bersih, pipa air tidak bocor, dan perabotan teratur sebelum melakukan showing.\n2. Foto Properti dengan Kualitas Premium: Ambil foto pada siang hari memanfaatkan cahaya matahari. Tampilkan keunikan interior Anda.\n3. Pasang Harga yang Kompetitif: Teliti pasaran di wilayah Anda. Harga yang terlalu tinggi akan membuat properti menganggur lama.\n4. Respon Cepat Calon Penyewa: Tunjukkan bahwa Anda pemilik yang kooperatif dengan membalas pesan secara cepat.\n5. Sediakan Fasilitas Tambahan: Wi-Fi cepat, water heater, atau AC yang menyala baik akan menaikkan nilai sewa Anda.",
                'author' => 'Budi Santoso (Admin)',
                'category' => 'Panduan Penyewa',
                'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=600',
                'is_own' => false,
                'views' => 300,
            ],
            [
                'title' => 'Cara Tepat Menentukan Harga Sewa Villa Anda',
                'slug' => 'cara-tepat-menentukan-harga-sewa-villa-anda',
                'content' => "Menentukan harga sewa villa tidak boleh sekadar tebak-tebak buah manggis. Ada beberapa faktor krusial yang menentukan:\n\n* Analisis Kompetitor: Cek villa-villa sejenis di radius 2 km dari properti Anda. Bandingkan fasilitas and harganya.\n* Musim Liburan (Seasonality): Bali atau destinasi wisata lain sangat bergantung pada high season (Juni-Agustus, Desember-Januari). Naikkan tarif 20-40% di waktu tersebut.\n* Highlight Fasilitas Unggulan: Private pool, infinity view, atau koki pribadi merupakan nilai plus yang membenarkan harga lebih tinggi.\n* Opsi Sewa Harian vs Bulanan: Tawarkan diskon untuk sewa jangka panjang agar aliran kas (cashflow) properti Anda lebih stabil.",
                'author' => 'Siti Rahma (Villa Expert)',
                'category' => 'Panduan Pemilik',
                'image' => 'https://images.unsplash.com/photo-1613977257363-707ba9348227?auto=format&fit=crop&q=80&w=600',
                'is_own' => false,
                'views' => 200,
            ],
            [
                'title' => 'Aspek Hukum Penting Dalam Kontrak Sewa Menyewa',
                'slug' => 'aspek-hukum-penting-dalam-kontrak-sewa-menyewa',
                'content' => "Untuk menghindari perselisihan di masa depan, pemilik properti dan penyewa harus memiliki perjanjian tertulis yang kuat. Beberapa hal wajib ada di dalam kontrak:\n\n1. Identitas Lengkap Para Pihak: Nama, nomor KTP, dan alamat domisili.\n2. Deskripsi Objek Sewa: Detail alamat rumah/apartemen beserta daftar inventaris barang.\n3. Hak dan Kewajiban: Siapa yang membayar iuran lingkungan/keamanan, tagihan air/listrik, dan biaya perbaikan jika terjadi kerusakan struktural.\n4. Uang Jaminan (Security Deposit): Uang jaminan untuk menutupi risiko kerusakan barang oleh penyewa yang akan dikembalikan di akhir masa sewa.\n5. Penyelesaian Sengketa: Cantumkan musyawarah mufakat sebagai opsi pertama sebelum menempuh jalur hukum.",
                'author' => 'Rian Hidayat (Legal Consultant)',
                'category' => 'Hukum & Regulasi',
                'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&q=80&w=600',
                'is_own' => false,
                'views' => 100,
            ],
            // Seeded articles written by Budi Tester
            [
                'title' => 'Tips Memilih Villa Murah di Seminyak untuk Pemula',
                'slug' => 'tips-memilih-villa-murah-di-seminyak-untuk-pemula',
                'content' => "Seminyak terkenal sebagai salah satu kawasan premium di Bali yang menawarkan berbagai akomodasi mewah dengan harga fantastis. Namun bagi penyewa pemula, menemukan villa dengan harga terjangkau di area strategis ini bukanlah hal yang mustahil.\n\nTips pertama adalah mencari lokasi yang sedikit masuk ke dalam gang (*gangway*) atau berjarak 10-15 menit berjalan kaki dari jalan utama Sunset Road atau area pantai. Villa di lokasi ini biasanya menawarkan ketenangan ekstra serta harga sewa yang jauh lebih bersahabat.\n\nTips kedua adalah selalu membandingkan fasilitas dasar seperti kelancaran air bersih, kecepatan jaringan Wi-Fi, dan ketersediaan area parkir motor yang memadai. Jangan ragu untuk bernegosiasi secara ramah dengan pemilik properti, terutama jika Anda berencana menyewa dalam jangka waktu bulanan guna mendapatkan potongan harga khusus.",
                'author' => 'Budi Tester',
                'category' => 'Panduan Penyewa',
                'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&q=80&w=800',
                'is_own' => false,
                'views' => 450,
            ],
            [
                'title' => 'Panduan Mengurus Izin Usaha Homestay di Bali',
                'slug' => 'panduan-mengurus-izin-usaha-homestay-di-bali',
                'content' => "Menjalankan bisnis penginapan tipe homestay atau pondok wisata di Bali merupakan peluang investasi yang sangat menjanjikan. Namun, sebelum menerima tamu pertama Anda, penting untuk mengurus seluruh perizinan hukum yang berlaku di wilayah Provinsi Bali.\n\nLangkah awal yang wajib diselesaikan adalah mengurus Kesesuaian Kegiatan Pemanfaatan Ruang (KKPR) dan Persetujuan Bangunan Gedung (PBG) yang dahulu dikenal sebagai IMB. PBG harus secara spesifik mencantumkan fungsi bangunan sebagai tempat usaha/pondok wisata, bukan rumah tinggal biasa.\n\nSelanjutnya, daftarkan usaha Anda melalui sistem OSS (Online Single Submission) untuk mendapatkan Nomor Induk Berusaha (NIB) sektor pariwisata. Pastikan juga Anda telah berkonsultasi dengan aparat banjar atau desa adat setempat guna menghormati kearifan lokal Bali serta menjaga keharmonisan lingkungan sekitar.",
                'author' => 'Budi Tester',
                'category' => 'Hukum & Regulasi',
                'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&q=80&w=600',
                'is_own' => false,
                'views' => 280,
            ],
            // Seeded articles written by the owner (Pak Hendra) with is_own = true
            [
                'title' => 'Pengalaman Saya Mengelola Villa di Bali: Suka dan Duka',
                'slug' => 'pengalaman-saya-mengelola-villa-di-bali-suka-dan-duka',
                'content' => "Mengelola villa di kawasan pariwisata seperti Bali memberikan banyak pengalaman berharga. Dari menyambut tamu internasional hingga menjaga standar kualitas fasilitas villa. Sebagai pemilik, saya selalu menekankan pentingnya keramahan lokal dan perawatan rutin untuk memastikan tamu merasa seperti di rumah sendiri. Salah satu tantangan terbesar adalah menjaga kebersihan kolam renang dan taman di tengah cuaca tropis yang dinamis, namun senyum kepuasan dari penyewa saat check-out selalu membayar lunas semua kerja keras tersebut.",
                'author' => 'Pak Hendra (Owner)',
                'category' => 'Panduan Pemilik',
                'image' => 'https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?auto=format&fit=crop&q=80&w=800',
                'is_own' => true,
                'views' => 350,
            ],
            [
                'title' => 'Pentingnya Menjaga Hubungan Baik dengan Penyewa Properti',
                'slug' => 'pentingnya-menjaga-hubungan-baik-dengan-penyewa-properti',
                'content' => "Hubungan antara pemilik properti dan penyewa bukan sekadar transaksi bisnis bulanan. Membangun komunikasi yang transparan dan bersikap responsif terhadap keluhan penyewa adalah kunci retensi jangka panjang. Selama bertahun-tahun mengelola properti, saya menyadari bahwa penyewa yang merasa dihargai cenderung menjaga unit dengan lebih baik. Selalu tanggapi laporan kerusakan dengan cepat, lakukan inspeksi berkala yang sopan, dan berikan sedikit perhatian ekstra seperti ucapan selamat hari raya untuk mempererat tali silaturahmi.",
                'author' => 'Pak Hendra (Owner)',
                'category' => 'Panduan Pemilik',
                'image' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&q=80&w=800',
                'is_own' => true,
                'views' => 240,
            ],
            [
                'title' => 'Checklist Perawatan Rutin Properti Sebelum Disewakan',
                'slug' => 'checklist-perawatan-rutin-properti-sebelum-disewakan',
                'content' => "Sebelum menyerahkan kunci kepada penyewa baru, ada serangkaian pemeriksaan wajib yang selalu saya lakukan secara pribadi. Pertama, pastikan seluruh sistem kelistrikan aman, lampu berfungsi, dan AC telah diservis. Kedua, periksa saluran air dan pastikan tidak ada kebocoran di kamar mandi maupun area dapur. Ketiga, bersihkan seluruh ruangan secara menyeluruh, termasuk tirai dan ventilasi udara. Properti yang bersih dan siap huni sejak hari pertama akan memberikan impresi awal yang sangat positif.",
                'author' => 'Pak Hendra (Owner)',
                'category' => 'Perawatan & Fasilitas',
                'image' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&q=80&w=800',
                'is_own' => true,
                'views' => 410,
            ]
        ];

        foreach ($posts as $post) {
            BlogPost::create($post);
        }
    }
}
