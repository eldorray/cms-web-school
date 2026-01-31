<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Event;
use App\Models\Teacher;
use App\Models\Achievement;
use App\Models\Gallery;
use App\Models\GalleryItem;
use App\Models\Download;
use App\Models\Page;
use App\Models\PpdbPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        
        // Create super admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@cmssekolah.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $superAdmin->assignRole('super-admin');
        
        // Create demo school
        $school = School::updateOrCreate(
            ['npsn' => '12345678'],
            [
                'name' => 'SDN 1 Demo',
                'slug' => 'sdn-1-demo',
                'domain' => 'localhost',
                'school_level' => 'SD',
                'address' => 'Jl. Pendidikan No. 1, Kota Demo',
                'phone' => '021-12345678',
                'email' => 'info@sdn1demo.test',
                'website' => 'https://sdn1demo.test',
                'tagline' => 'Membangun Generasi Cerdas dan Berkarakter',
                'theme_primary_color' => '#3B82F6',
                'theme_secondary_color' => '#6366F1',
                'theme_accent_color' => '#F59E0B',
                'is_active' => true,
                'social_media' => [
                    'facebook' => 'https://facebook.com/sdn1demo',
                    'instagram' => 'https://instagram.com/sdn1demo',
                    'youtube' => 'https://youtube.com/@sdn1demo',
                ],
            ]
        );
        
        // Create school admin
        $schoolAdmin = User::firstOrCreate(
            ['email' => 'admin@sdn1demo.test'],
            [
                'name' => 'Admin SDN 1 Demo',
                'password' => Hash::make('password'),
                'school_id' => $school->id,
                'is_active' => true,
            ]
        );
        $schoolAdmin->assignRole('admin');
        
        // Create categories
        $categories = [
            ['name' => 'Berita Sekolah', 'slug' => 'berita-sekolah', 'color' => '#3B82F6'],
            ['name' => 'Kegiatan', 'slug' => 'kegiatan', 'color' => '#10B981'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'color' => '#EF4444'],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'color' => '#F59E0B'],
        ];
        
        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['school_id' => $school->id, 'slug' => $cat['slug']],
                array_merge($cat, ['school_id' => $school->id])
            );
        }
        
        // Create posts
        $posts = [
            [
                'title' => 'Selamat Datang di Website SDN 1 Demo',
                'content' => '<p>Website resmi SDN 1 Demo telah hadir untuk memberikan informasi terkini seputar kegiatan dan perkembangan sekolah.</p><p>Melalui website ini, kami berharap dapat menjalin komunikasi yang lebih baik dengan orang tua/wali murid serta masyarakat.</p>',
                'is_pinned' => true,
            ],
            [
                'title' => 'Penerimaan Peserta Didik Baru Dibuka',
                'content' => '<p>Pendaftaran siswa baru tahun ajaran baru telah dibuka. Silakan daftarkan putra-putri Anda melalui menu PPDB.</p>',
                'is_pinned' => false,
            ],
            [
                'title' => 'Juara 1 Olimpiade Matematika Tingkat Kota',
                'content' => '<p>Selamat kepada Ananda Ahmad yang berhasil meraih Juara 1 dalam Olimpiade Matematika tingkat Kota.</p>',
                'is_pinned' => false,
            ],
        ];
        
        $category = Category::where('school_id', $school->id)->first();
        foreach ($posts as $post) {
            Post::firstOrCreate(
                ['school_id' => $school->id, 'slug' => Str::slug($post['title'])],
                array_merge($post, [
                    'school_id' => $school->id,
                    'user_id' => $schoolAdmin->id,
                    'category_id' => $category->id,
                    'slug' => Str::slug($post['title']),
                    'is_published' => true,
                    'published_at' => now(),
                ])
            );
        }
        
        // Create teachers
        $teachers = [
            ['name' => 'Drs. Ahmad Sudirman, M.Pd', 'position' => 'kepala_sekolah', 'subject' => null, 'position_detail' => 'Kepala Sekolah'],
            ['name' => 'Siti Rahmawati, S.Pd', 'position' => 'guru', 'subject' => 'Guru Kelas 1'],
            ['name' => 'Budi Santoso, S.Pd', 'position' => 'guru', 'subject' => 'Guru Kelas 2'],
            ['name' => 'Dewi Lestari, S.Pd', 'position' => 'guru', 'subject' => 'Guru Kelas 3'],
            ['name' => 'Arif Hidayat, S.Pd', 'position' => 'guru', 'subject' => 'Guru Olahraga'],
            ['name' => 'Nurul Aini, S.Pd', 'position' => 'guru', 'subject' => 'Guru Agama Islam'],
        ];
        
        foreach ($teachers as $i => $teacher) {
            Teacher::firstOrCreate(
                ['school_id' => $school->id, 'name' => $teacher['name']],
                array_merge($teacher, [
                    'school_id' => $school->id,
                    'is_active' => true,
                    'order' => $i + 1,
                ])
            );
        }
        
        // Create events
        $events = [
            ['title' => 'Upacara Hari Kemerdekaan', 'start_date' => now()->addDays(30), 'location' => 'Lapangan Sekolah'],
            ['title' => 'Ujian Tengah Semester', 'start_date' => now()->addDays(45), 'location' => 'Ruang Kelas'],
            ['title' => 'Penyerahan Rapor', 'start_date' => now()->addDays(90), 'location' => 'Aula Sekolah'],
        ];
        
        foreach ($events as $event) {
            Event::firstOrCreate(
                ['school_id' => $school->id, 'title' => $event['title']],
                array_merge($event, [
                    'school_id' => $school->id,
                    'user_id' => $schoolAdmin->id,
                    'end_date' => $event['start_date'],
                    'color' => '#3B82F6',
                ])
            );
        }
        
        // Create achievements
        $achievements = [
            ['title' => 'Juara 1 Olimpiade Matematika', 'level' => 'kota', 'rank' => 'Juara 1', 'participant_name' => 'Ahmad Fauzan'],
            ['title' => 'Juara 2 Lomba Cerdas Cermat', 'level' => 'provinsi', 'rank' => 'Juara 2', 'participant_name' => 'Tim CCC SDN 1'],
            ['title' => 'Juara 3 Lomba Pidato', 'level' => 'kota', 'rank' => 'Juara 3', 'participant_name' => 'Siti Aisyah'],
        ];
        
        foreach ($achievements as $achievement) {
            Achievement::firstOrCreate(
                ['school_id' => $school->id, 'title' => $achievement['title']],
                array_merge($achievement, [
                    'school_id' => $school->id,
                    'user_id' => $schoolAdmin->id,
                    'type' => 'akademik',
                    'year' => date('Y'),
                    'is_published' => true,
                ])
            );
        }
        
        // Create gallery
        Gallery::firstOrCreate(
            ['school_id' => $school->id, 'slug' => 'kegiatan-belajar'],
            [
                'school_id' => $school->id,
                'user_id' => $schoolAdmin->id,
                'title' => 'Kegiatan Belajar Mengajar',
                'slug' => 'kegiatan-belajar',
                'description' => 'Dokumentasi kegiatan belajar mengajar di SDN 1 Demo',
                'event_date' => now(),
                'is_published' => true,
            ]
        );
        
        // Create pages
        $pages = [
            ['title' => 'Visi & Misi', 'slug' => 'visi-misi', 'order' => 1, 'content' => '<h2>Visi</h2><p>Menjadi sekolah unggulan yang menghasilkan lulusan cerdas, berkarakter, dan berakhlak mulia.</p><h2>Misi</h2><ul><li>Menyelenggarakan pembelajaran yang berkualitas</li><li>Mengembangkan potensi siswa secara optimal</li><li>Menanamkan nilai-nilai karakter dan akhlak mulia</li></ul>'],
            ['title' => 'Sejarah Sekolah', 'slug' => 'sejarah', 'order' => 2, 'content' => '<p>SDN 1 Demo didirikan pada tahun 1980 dengan awal mula hanya memiliki 3 ruang kelas...</p>'],
            ['title' => 'Fasilitas', 'slug' => 'fasilitas', 'order' => 3, 'content' => '<p>Fasilitas yang tersedia di SDN 1 Demo:</p><ul><li>Ruang Kelas ber-AC</li><li>Perpustakaan</li><li>Lab Komputer</li><li>Lapangan Olahraga</li><li>Musholla</li></ul>'],
        ];
        
        foreach ($pages as $page) {
            Page::firstOrCreate(
                ['school_id' => $school->id, 'slug' => $page['slug']],
                array_merge($page, [
                    'school_id' => $school->id,
                    'user_id' => $schoolAdmin->id,
                    'is_published' => true,
                    'show_in_menu' => true,
                ])
            );
        }
        
        // Create PPDB Period
        PpdbPeriod::firstOrCreate(
            ['school_id' => $school->id, 'academic_year' => date('Y') . '/' . (date('Y') + 1)],
            [
                'school_id' => $school->id,
                'name' => 'PPDB Tahun Ajaran ' . date('Y') . '/' . (date('Y') + 1),
                'academic_year' => date('Y') . '/' . (date('Y') + 1),
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(60),
                'quota' => 120,
                'requirements' => "Persyaratan Pendaftaran:\n\n1. Fotokopi Ijazah/SKL (2 lembar)\n2. Fotokopi Kartu Keluarga (2 lembar)\n3. Fotokopi Akta Kelahiran (2 lembar)\n4. Pas foto 3x4 (4 lembar)\n5. Fotokopi KTP Orang Tua (2 lembar)",
                'is_active' => true,
            ]
        );
        
        $this->command->info('Demo data seeded successfully!');
        $this->command->info('Super Admin: superadmin@cmssekolah.test / password');
        $this->command->info('School Admin: admin@sdn1demo.test / password');
    }
}
