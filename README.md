# CMS Web School

Aplikasi Content Management System untuk website sekolah berbasis Laravel.

## Fitur

- **Manajemen halaman** — buat & edit halaman statis (profil, visi-misi, kontak)
- **Manajemen berita** — publish artikel, pengumuman, galeri foto
- **Manajemen guru & staf** — data pengajar, jabatan, mapel
- **Manajemen siswa** — data induk siswa aktif
- **Multi user** — admin sekolah, guru, operator

## Tech Stack

- **Backend:** Laravel 12
- **Frontend:** Blade + Livewire 4
- **Database:** MySQL
- **UI:** Tailwind CSS

## Setup

```bash
composer install
cp .env.example .env
# isi konfigurasi database
php artisan key:generate
php artisan migrate --seed
php artisan serve
```
