<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder for demo school and super admin.
 */
class DemoSchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo school
        $school = School::create([
            'name' => 'SD Negeri 1 Demo',
            'slug' => 'sd-negeri-1-demo',
            'domain' => 'localhost',
            'school_level' => 'SD',
            'npsn' => '12345678',
            'address' => 'Jl. Pendidikan No. 1, Kota Demo, Indonesia',
            'phone' => '021-1234567',
            'email' => 'info@sd-demo.sch.id',
            'website' => 'https://sd-demo.sch.id',
            'theme_primary_color' => '#3B82F6',
            'theme_secondary_color' => '#1E40AF',
            'theme_accent_color' => '#F59E0B',
            'social_media' => [
                'facebook' => 'https://facebook.com/sdnegeri1demo',
                'instagram' => 'https://instagram.com/sdnegeri1demo',
                'youtube' => null,
            ],
            'is_active' => true,
        ]);

        // Create super admin (platform level)
        $superAdmin = User::create([
            'school_id' => null, // Super admin is not tied to a school
            'name' => 'Super Admin',
            'email' => 'superadmin@cms-sekolah.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $superAdmin->assignRole('super-admin');

        // Create school admin
        $schoolAdmin = User::create([
            'school_id' => $school->id,
            'name' => 'Admin SD Demo',
            'email' => 'admin@sd-demo.sch.id',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $schoolAdmin->assignRole('admin');

        // Create editor berita
        $editorBerita = User::create([
            'school_id' => $school->id,
            'name' => 'Editor Berita',
            'email' => 'berita@sd-demo.sch.id',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $editorBerita->assignRole('editor-berita');

        // Create kontributor
        $kontributor = User::create([
            'school_id' => $school->id,
            'name' => 'Guru Kontributor',
            'email' => 'guru@sd-demo.sch.id',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $kontributor->assignRole('kontributor');

        $this->command->info('Demo school and users created successfully!');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Super Admin', 'superadmin@cms-sekolah.com', 'password'],
                ['Admin Sekolah', 'admin@sd-demo.sch.id', 'password'],
                ['Editor Berita', 'berita@sd-demo.sch.id', 'password'],
                ['Kontributor', 'guru@sd-demo.sch.id', 'password'],
            ]
        );
    }
}
