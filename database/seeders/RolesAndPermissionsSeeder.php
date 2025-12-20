<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Seeder for roles and permissions.
 */
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Posts
            'posts.view',
            'posts.create',
            'posts.edit',
            'posts.delete',
            'posts.publish',

            // Categories
            'categories.view',
            'categories.create',
            'categories.edit',
            'categories.delete',

            // Events
            'events.view',
            'events.create',
            'events.edit',
            'events.delete',

            // Teachers
            'teachers.view',
            'teachers.create',
            'teachers.edit',
            'teachers.delete',

            // Achievements
            'achievements.view',
            'achievements.create',
            'achievements.edit',
            'achievements.delete',

            // Galleries
            'galleries.view',
            'galleries.create',
            'galleries.edit',
            'galleries.delete',

            // Downloads
            'downloads.view',
            'downloads.create',
            'downloads.edit',
            'downloads.delete',

            // PPDB
            'ppdb.view',
            'ppdb.manage',

            // Pages
            'pages.view',
            'pages.create',
            'pages.edit',
            'pages.delete',

            // Menus
            'menus.view',
            'menus.manage',

            // Settings
            'settings.view',
            'settings.manage',

            // Users
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',

            // Contact Messages
            'contacts.view',
            'contacts.delete',

            // Schools (Super Admin only)
            'schools.view',
            'schools.create',
            'schools.edit',
            'schools.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Super Admin - Platform owner with full access
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->syncPermissions(Permission::all());

        // Admin - School admin with full access to school content
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions([
            'posts.view', 'posts.create', 'posts.edit', 'posts.delete', 'posts.publish',
            'categories.view', 'categories.create', 'categories.edit', 'categories.delete',
            'events.view', 'events.create', 'events.edit', 'events.delete',
            'teachers.view', 'teachers.create', 'teachers.edit', 'teachers.delete',
            'achievements.view', 'achievements.create', 'achievements.edit', 'achievements.delete',
            'galleries.view', 'galleries.create', 'galleries.edit', 'galleries.delete',
            'downloads.view', 'downloads.create', 'downloads.edit', 'downloads.delete',
            'ppdb.view', 'ppdb.manage',
            'pages.view', 'pages.create', 'pages.edit', 'pages.delete',
            'menus.view', 'menus.manage',
            'settings.view', 'settings.manage',
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'contacts.view', 'contacts.delete',
        ]);

        // Editor Berita - News/announcements editor
        $editorBerita = Role::firstOrCreate(['name' => 'editor-berita']);
        $editorBerita->syncPermissions([
            'posts.view', 'posts.create', 'posts.edit', 'posts.delete', 'posts.publish',
            'categories.view',
            'galleries.view', 'galleries.create', 'galleries.edit', 'galleries.delete',
            'events.view', 'events.create', 'events.edit', 'events.delete',
        ]);

        // Editor Akademik - Academic content editor
        $editorAkademik = Role::firstOrCreate(['name' => 'editor-akademik']);
        $editorAkademik->syncPermissions([
            'teachers.view', 'teachers.create', 'teachers.edit', 'teachers.delete',
            'achievements.view', 'achievements.create', 'achievements.edit', 'achievements.delete',
            'events.view', 'events.create', 'events.edit', 'events.delete',
        ]);

        // Editor Konten - Static content editor
        $editorKonten = Role::firstOrCreate(['name' => 'editor-konten']);
        $editorKonten->syncPermissions([
            'pages.view', 'pages.create', 'pages.edit', 'pages.delete',
            'downloads.view', 'downloads.create', 'downloads.edit', 'downloads.delete',
            'contacts.view',
        ]);

        // Kontributor - Can only create drafts
        $kontributor = Role::firstOrCreate(['name' => 'kontributor']);
        $kontributor->syncPermissions([
            'posts.view', 'posts.create',
            'achievements.view', 'achievements.create',
        ]);
    }
}
