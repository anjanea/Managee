<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Truncate dependent tables first to avoid foreign key issues or duplicates
        \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = OFF');
        \App\Models\Review::truncate();
        \App\Models\Booking::truncate();
        \Illuminate\Support\Facades\DB::statement('PRAGMA foreign_keys = ON');

        // Seed regular users (Penyewas)
        $usersData = [
            [
                'name' => 'Budi Santoso',
                'email' => 'penyewa@managee.com',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Ani Wijaya',
                'email' => 'ani@managee.com',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Dedi Kurniawan',
                'email' => 'dedi@managee.com',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Citra Lestari',
                'email' => 'citra@managee.com',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko@managee.com',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ],
            [
                'name' => 'Farhan Ramadhan',
                'email' => 'farhan@managee.com',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ]
        ];

        $users = [];
        foreach ($usersData as $uData) {
            $users[] = User::updateOrCreate(['email' => $uData['email']], $uData);
        }
        $primaryUser = $users[0]; // Budi Santoso

        // Seed tester user for fresh testing
        $tester = User::updateOrCreate(
            ['email' => 'tester@managee.com'],
            [
                'name' => 'Budi Tester',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ]
        );

        // Seed property Owner
        User::updateOrCreate(
            ['email' => 'owner@managee.com'],
            [
                'name' => 'Pak Hendra (Owner)',
                'password' => bcrypt('password123'),
                'role' => 'owner',
            ]
        );

        $this->call([
            PropertySeeder::class,
            BlogPostSeeder::class,
        ]);

        $properties = \App\Models\Property::all();

        // Seed a completed booking and review for EVERY property to ensure reviews show up
        $commentsPool = [
            'Kondisi properti sangat bersih, rapi, dan fasilitas lengkap sesuai deskripsi. Pelayanan pemilik sangat ramah dan responsif!',
            'Tempatnya sangat nyaman, tenang, dan strategis dekat dengan area kuliner dan jalan raya. Sangat cocok untuk menginap bersama keluarga.',
            'Pemandangan di sekitar sangat indah, udara bersih, dan suasana menenangkan. Kamar mandi bersih dan air panas lancar.',
            'Fasilitas lengkap, AC dingin, kasur empuk, dan wifi sangat kencang. Rekomendasi sekali untuk staycation maupun work from Bali.',
            'Desain interior sangat estetis, modern, dan bernuansa premium. Kebersihan kolam renang dan area luar terjaga dengan baik.'
        ];

        foreach ($properties as $index => $prop) {
            for ($r = 0; $r < 3; $r++) {
                // Pick a different reviewer from the pool
                $reviewer = $users[($index + $r) % count($users)];

                $checkin = now()->subDays(30 + $index * 5 + $r * 3);
                $checkout = now()->subDays(25 + $index * 5 + $r * 3);

                $baseStars = $prop->stars ?: 4;
                if ($r == 0) {
                    $stars = $baseStars;
                } elseif ($r == 1) {
                    $stars = min(5, max(3, $baseStars + 1));
                } else {
                    $stars = min(5, max(3, $baseStars - 1));
                }

                // Create completed booking
                $booking = \App\Models\Booking::create([
                    'user_id' => $reviewer->id,
                    'property_id' => $prop->id,
                    'checkin_date' => $checkin,
                    'checkout_date' => $checkout,
                    'guests' => 2,
                    'total_price' => $prop->price,
                    'status' => 'Selesai',
                ]);

                // Create review
                \App\Models\Review::create([
                    'user_id' => $reviewer->id,
                    'property_id' => $prop->id,
                    'booking_id' => $booking->id,
                    'stars' => $stars,
                    'comment' => $commentsPool[($index + $r) % count($commentsPool)],
                ]);
            }
        }

        // Seed some additional pending/confirmed bookings for test variety
        if ($properties->count() >= 3) {
            \App\Models\Booking::create([
                'user_id' => $primaryUser->id,
                'property_id' => $properties[1]->id,
                'checkin_date' => now()->addDays(2),
                'checkout_date' => now()->addDays(5),
                'guests' => 1,
                'total_price' => $properties[1]->price,
                'status' => 'Menunggu',
            ]);

            \App\Models\Booking::create([
                'user_id' => $primaryUser->id,
                'property_id' => $properties[2]->id,
                'checkin_date' => now()->addDays(10),
                'checkout_date' => now()->addDays(13),
                'guests' => 3,
                'total_price' => $properties[2]->price,
                'status' => 'Dikonfirmasi',
            ]);
        }

        // Seed bookings for Budi Tester (tester@managee.com)
        if ($properties->count() >= 4) {
            // 1. Menunggu
            \App\Models\Booking::create([
                'user_id' => $tester->id,
                'property_id' => $properties[0]->id,
                'checkin_date' => now()->addDays(5),
                'checkout_date' => now()->addDays(8),
                'guests' => 2,
                'total_price' => $properties[0]->price * 3,
                'status' => 'Menunggu',
                'addons' => [
                    'breakfast' => [
                        'name' => 'Sarapan Pagi Prasmanan Harian',
                        'price' => 80000
                    ]
                ]
            ]);

            // 2. Dikonfirmasi
            \App\Models\Booking::create([
                'user_id' => $tester->id,
                'property_id' => $properties[1]->id,
                'checkin_date' => now()->addDays(15),
                'checkout_date' => now()->addDays(20),
                'guests' => 1,
                'total_price' => $properties[1]->price * 5,
                'status' => 'Dikonfirmasi',
                'addons' => [
                    'insurance' => [
                        'name' => 'Asuransi Perjalanan Perlindungan Penuh',
                        'price' => 45000
                    ]
                ]
            ]);

            // 3. Selesai
            $selesaiBooking = \App\Models\Booking::create([
                'user_id' => $tester->id,
                'property_id' => $properties[2]->id,
                'checkin_date' => now()->subDays(10),
                'checkout_date' => now()->subDays(6),
                'guests' => 4,
                'total_price' => $properties[2]->price * 4,
                'status' => 'Selesai',
            ]);

            // Also seed a review for the completed booking
            \App\Models\Review::create([
                'user_id' => $tester->id,
                'property_id' => $properties[2]->id,
                'booking_id' => $selesaiBooking->id,
                'stars' => 5,
                'comment' => 'Penginapan yang luar biasa bersih, kolam renangnya luas, dan pemandangannya sangat indah. Sangat direkomendasikan!',
            ]);

            // 4. Ditolak
            \App\Models\Booking::create([
                'user_id' => $tester->id,
                'property_id' => $properties[3]->id,
                'checkin_date' => now()->subDays(20),
                'checkout_date' => now()->subDays(18),
                'guests' => 2,
                'total_price' => $properties[3]->price * 2,
                'status' => 'Ditolak',
            ]);
        }
    }
}
