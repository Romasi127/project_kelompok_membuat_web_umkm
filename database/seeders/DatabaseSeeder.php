<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Admin User
        User::updateOrCreate(
            ['email' => 'admin@seafood2000.com'],
            [
                'name'     => 'Admin Seafood 2000',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        // 2. Seed Regular Customer
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name'     => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]
        );

        // 3. Seed Menu Items — SESUAI DAFTAR MENU SEAFOOD 2000
        $menus = [

            // ===== MAKANAN =====
            [
                'name'            => 'Pecel Lele',
                'category'        => 'Makanan',
                'description'     => 'Lele goreng garing disajikan dengan sambal terasi khas dan lalapan segar. Cocok sebagai menu andalan!',
                'price'           => 15000,
                'image'           => '/images/pecel_lele.png',
                'cooking_options' => null,
            ],
            [
                'name'            => 'Ayam Goreng',
                'category'        => 'Makanan',
                'description'     => 'Ayam goreng bumbu kuning rempah pilihan, gurih dan renyah disajikan dengan sambal dan lalapan.',
                'price'           => 18000,
                'image'           => '/images/pecel_lele.png',
                'cooking_options' => null,
            ],
            [
                'name'            => 'Burung Goreng',
                'category'        => 'Makanan',
                'description'     => 'Burung puyuh goreng bumbu rempah, renyah di luar dan empuk di dalam.',
                'price'           => 25000,
                'image'           => '/images/pecel_lele.png',
                'cooking_options' => null,
            ],
            [
                'name'            => 'Bebek Goreng',
                'category'        => 'Makanan',
                'description'     => 'Bebek goreng bumbu madura super empuk dengan kremesan gurih dan sambal pedas mantap.',
                'price'           => 30000,
                'image'           => '/images/pecel_lele.png',
                'cooking_options' => null,
            ],
            [
                'name'            => 'Tempe & Tahu Goreng',
                'category'        => 'Makanan',
                'description'     => 'Tahu dan tempe goreng gurih, cocok sebagai lauk pendamping hidangan utama.',
                'price'           => 6000,
                'image'           => '/images/pecel_lele.png',
                'cooking_options' => null,
            ],
            [
                'name'            => 'Tumis Kangkung',
                'category'        => 'Makanan',
                'description'     => 'Kangkung segar ditumis dengan bawang merah, bawang putih, dan bumbu tauco pedas.',
                'price'           => 10000,
                'image'           => '/images/pecel_lele.png',
                'cooking_options' => null,
            ],

            // ===== IKAN NILA =====
            [
                'name'            => 'Ikan Nila',
                'category'        => 'Ikan Nila',
                'description'     => 'Ikan nila segar ukuran sedang, bisa dipilih cara memasaknya sesuai selera Anda.',
                'price'           => 22000,
                'image'           => '/images/ikan_bakar.png',
                'cooking_options' => ['Goreng Kering', 'Asam Manis', 'Asam Pedas', 'Saos Tiram', 'Bakar'],
            ],

            // ===== IKAN GURAMI =====
            [
                'name'            => 'Ikan Gurami',
                'category'        => 'Ikan Gurami',
                'description'     => 'Ikan gurami segar berukuran besar, daging tebal dan lembut sesuai pilihan masakan.',
                'price'           => 40000,
                'image'           => '/images/ikan_bakar.png',
                'cooking_options' => ['Goreng Kering', 'Asam Manis', 'Asam Pedas', 'Saos Tiram', 'Bakar'],
            ],

            // ===== IKAN BAWAL =====
            [
                'name'            => 'Ikan Bawal',
                'category'        => 'Ikan Bawal',
                'description'     => 'Ikan bawal laut segar berkualitas tinggi, lezat dimasak dengan berbagai pilihan bumbu.',
                'price'           => 30000,
                'image'           => '/images/ikan_bakar.png',
                'cooking_options' => ['Goreng Kering', 'Asam Manis', 'Asam Pedas', 'Saos Tiram', 'Bakar'],
            ],

            // ===== IKAN KAKAP =====
            [
                'name'            => 'Ikan Kakap',
                'category'        => 'Ikan Kakap',
                'description'     => 'Ikan kakap merah segar dengan daging putih lembut, cocok dimasak berbagai cara.',
                'price'           => 35000,
                'image'           => '/images/ikan_bakar.png',
                'cooking_options' => ['Goreng Kering', 'Asam Manis', 'Asam Pedas', 'Saos Tiram', 'Bakar'],
            ],

            // ===== IKAN GEMBUNG =====
            [
                'name'            => 'Ikan Gembung',
                'category'        => 'Ikan Gembung',
                'description'     => 'Ikan gembung segar berlemak alami, sangat lezat terutama saat dibakar dengan bumbu kecap.',
                'price'           => 20000,
                'image'           => '/images/ikan_bakar.png',
                'cooking_options' => ['Goreng Kering', 'Asam Manis', 'Asam Pedas', 'Saos Tiram', 'Bakar'],
            ],

            // ===== UDANG =====
            [
                'name'            => 'Udang',
                'category'        => 'Udang',
                'description'     => 'Udang jerbung segar ukuran besar, dimasak dengan pilihan saus favorit Anda.',
                'price'           => 30000,
                'image'           => '/images/udang_asam_manis.png',
                'cooking_options' => ['Asam Manis', 'Asam Pedas', 'Saos Tiram', 'Goreng Tepung'],
            ],

            // ===== KEPITING =====
            [
                'name'            => 'Kepiting',
                'category'        => 'Kepiting',
                'description'     => 'Kepiting bakau segar berukuran mantap, dimasak dengan saus yang meresap hingga ke daging.',
                'price'           => 50000,
                'image'           => '/images/seafood_banner.png',
                'cooking_options' => ['Asam Manis', 'Asam Pedas', 'Saos Tiram'],
            ],

            // ===== CUMI =====
            [
                'name'            => 'Cumi',
                'category'        => 'Cumi',
                'description'     => 'Cumi-cumi segar empuk gurih dengan berbagai variasi masakan pilihan.',
                'price'           => 25000,
                'image'           => '/images/cumi_goreng_tepung.png',
                'cooking_options' => ['Asam Manis', 'Asam Pedas', 'Saos Tiram', 'Goreng Tepung'],
            ],

            // ===== HATI / AMPELA =====
            [
                'name'            => 'Hati / Ampela Goreng',
                'category'        => 'Lain-lain',
                'description'     => 'Hati dan ampela ayam goreng gurih dengan bumbu ketumbar khas, porsi hemat dan mengenyangkan.',
                'price'           => 8000,
                'image'           => '/images/pecel_lele.png',
                'cooking_options' => null,
            ],

            // ===== NASI =====
            [
                'name'            => 'Nasi Uduk',
                'category'        => 'Lain-lain',
                'description'     => 'Nasi uduk gurih wangi pandan yang disajikan hangat dengan bawang goreng renyah.',
                'price'           => 6000,
                'image'           => '/images/pecel_lele.png',
                'cooking_options' => null,
            ],
            [
                'name'            => 'Nasi Putih',
                'category'        => 'Lain-lain',
                'description'     => 'Nasi putih pulen hangat, porsi pas untuk menemani hidangan laut pilihan Anda.',
                'price'           => 5000,
                'image'           => '/images/pecel_lele.png',
                'cooking_options' => null,
            ],

            // ===== MINUMAN =====
            [
                'name'            => 'Jus Jeruk',
                'category'        => 'Minuman',
                'description'     => 'Perasan jeruk manis segar dengan es batu, menyegarkan di setiap tegukan.',
                'price'           => 8000,
                'image'           => '/images/es_teh_manis.png',
                'cooking_options' => null,
            ],
            [
                'name'            => 'Jus Terong Belanda',
                'category'        => 'Minuman',
                'description'     => 'Jus buah terong belanda segar kaya vitamin, unik dan menyegarkan.',
                'price'           => 10000,
                'image'           => '/images/es_teh_manis.png',
                'cooking_options' => null,
            ],
            [
                'name'            => 'Jus Kuini',
                'category'        => 'Minuman',
                'description'     => 'Jus mangga kuini harum manis segar kental, favorit pelanggan setia kami.',
                'price'           => 10000,
                'image'           => '/images/es_teh_manis.png',
                'cooking_options' => null,
            ],
            [
                'name'            => 'Jus Sikat',
                'category'        => 'Minuman',
                'description'     => 'Jus buah sikat segar penyejuk tenggorokan yang nikmat.',
                'price'           => 10000,
                'image'           => '/images/es_teh_manis.png',
                'cooking_options' => null,
            ],
            [
                'name'            => 'Jus Timun',
                'category'        => 'Minuman',
                'description'     => 'Jus timun segar berkhasiat, dipercaya dapat membantu menurunkan tekanan darah.',
                'price'           => 8000,
                'image'           => '/images/es_teh_manis.png',
                'cooking_options' => null,
            ],
            [
                'name'            => 'Jus Wortel',
                'category'        => 'Minuman',
                'description'     => 'Jus wortel segar kaya vitamin A, baik untuk kesehatan mata dan imunitas.',
                'price'           => 8000,
                'image'           => '/images/es_teh_manis.png',
                'cooking_options' => null,
            ],
            [
                'name'            => 'Lemon Tea',
                'category'        => 'Minuman',
                'description'     => 'Teh segar dengan perasan lemon asli yang dingin dan menyegarkan.',
                'price'           => 6000,
                'image'           => '/images/es_teh_manis.png',
                'cooking_options' => null,
            ],
            [
                'name'            => 'Teh Botol',
                'category'        => 'Minuman',
                'description'     => 'Teh Sosro botol dingin segar, minuman klasik pendamping makan seafood.',
                'price'           => 5000,
                'image'           => '/images/es_teh_manis.png',
                'cooking_options' => null,
            ],
            [
                'name'            => 'Teh Manis',
                'category'        => 'Minuman',
                'description'     => 'Teh manis hangat atau es, minuman sederhana yang selalu pas di segala suasana.',
                'price'           => 4000,
                'image'           => '/images/es_teh_manis.png',
                'cooking_options' => null,
            ],
        ];

        foreach ($menus as $item) {
            Menu::updateOrCreate(
                ['name' => $item['name'], 'category' => $item['category']],
                $item
            );
        }
    }
}
