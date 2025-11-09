# SMK Prima Bangsa

SMK Prima Bangsa adalah Sekolah Menengah Kejuruan yang fokus pada kompetensi vokasi di bidang teknologi, jaringan, dan desain. Situs ini menyajikan profil sekolah, program keahlian, fasilitas, berita kegiatan, testimoni siswa & alumni, serta kontak/pendaftaran.

Preview
-------
- Buka file `index.php` di folder proyek untuk melihat tampilan situs secara lokal.

Persiapan awal
-------------
1. Install software yang diperlukan:
   - [Composer](https://getcomposer.org/download/) (untuk menginstall dependency PHP)
   - PHP 7.4 atau lebih baru (sudah termasuk dalam Laragon)
   - [Laragon](https://laragon.org/download/) (opsional, recommended)

2. Setup project:
   ```powershell
   # Di folder backend/, install dependency PHP (PHPMailer dll)
   cd D:\Laragon\laragon\www\Primaweb\backend
   composer install
   
   # Salin file contoh konfigurasi
   copy config\db_config.example.php config\db_config.php
   copy config\email_config.example.php config\email_config.php
   ```

3. Edit file konfigurasi di `backend/config/`:
   - `db_config.php`: sesuaikan DB_HOST, DB_NAME, DB_USER, DB_PASS
   - `email_config.php`: atur SMTP_HOST, SMTP_USER, SMTP_PASS (untuk Gmail, gunakan App Password jika 2FA aktif)

Cara menjalankan (lokal)
-----------------------
1. Jangan ubah struktur folder (pastikan `index.php`, `assets/` dan `style.css` ada).

2. Pilih salah satu cara menjalankan:

   A. Menggunakan Laragon (recommended untuk development):
      - Jalankan Laragon
      - Buka http://localhost/Primaweb/ 
      - Atau gunakan virtual host: http://primaweb.test (jika dikonfigurasi)

   B. Menggunakan PHP built-in server:
      ```powershell
      # Untuk frontend statis saja
      cd D:\Laragon\laragon\www\Primaweb\frontend
      php -S localhost:8000

      # Untuk versi dengan backend (form kontak dll)
      cd D:\Laragon\laragon\www\Primaweb\backend
      php -S localhost:8000
      ```
      Lalu buka http://localhost:8000

   C. Opsi server sederhana (hanya untuk frontend statis):
      ```powershell
      cd D:\Laragon\laragon\www\Primaweb\frontend
      python -m http.server 8000 atau gunakan live server di VSCode
      ```
      Lalu buka http://localhost:8000

PENTING: 
- Jangan buka file PHP langsung dari browser jika menggunakan fitur backend (form kontak/database).
- Gunakan opsi A atau B untuk menjalankan fitur yang memerlukan PHP (form kontak, database).

Penyesuaian cepat (umumnya yang perlu diganti)
--------------------------------------------------
- Logo: ganti `assets/images/logo.svg` dan `assets/images/white-logo.svg`.
- Gambar hero/berita/testimonial: ganti di `assets/images/header/`, `assets/images/blog/`, `assets/images/testimonial/`.
- Video profil: perbarui tautan YouTube pada anchor hero dan inisialisasi GLightbox di `index.html`.
- Informasi kontak: ubah di bagian `#contact` dan footer.
- Warna utama: ubah variabel `--primary` di `style.css` jika perlu.

Struktur proyek (ringkas)
------------------------
- assets/                - gambar, css/vendor, js/vendor  
  - css/                 - bootstrap, plugin css  
  - images/              - logo, header, blog, testimonial, client-logo  
  - js/                  - plugin js (bootstrap bundle, glightbox, tiny-slider, main)  
- index.php             - halaman utama (static)  
- style.css              - kustomisasi tema dan variabel warna  
- README.md              - dokumentasi ini
- config/                - konfigurasi (database, email)  
  - db_config.php        - konfigurasi koneksi database (jika pakai backend)  
  - email_config.php     - konfigurasi SMTP email (jika pakai backend)  
- controllers/           - logika backend (jika pakai backend)  
  - contact.php          - penanganan form kontak/pendaftaran (simpan ke database + kirim email)  
- vendor/                - library pihak ketiga (PHPMailer via Composer)
  - autoload.php         - autoloader Composer  
  - phpmailer/           - library PHPMailer

Pengaturan email (SMTP) dan database
--------------------------------
1. Konfigurasi email (`config/email_config.php`):
   ```php
   // Contoh pengaturan untuk Gmail
   define('SMTP_HOST', 'smtp.gmail.com');
   define('SMTP_PORT', 587);
   define('SMTP_USER', 'your-email@gmail.com');
   define('SMTP_PASS', 'your-app-password'); 
   define('SMTP_FROM', 'noreply@smkprimabangsa.sch.id');
   define('SMTP_NAME', 'SMK Prima Bangsa');
   ```
   
   Alternatif SMTP lain:
   - SendGrid: smtp.sendgrid.net (rekomendasi untuk production)
   - Mailgun: smtp.mailgun.org
   - Mailtrap: smtp.mailtrap.io (untuk testing)

2. Konfigurasi database (`config/db_config.php`):
   ```php
   define('DB_HOST', 'localhost');     
   define('DB_NAME', 'primaweb_db');   
   define('DB_USER', 'root');          
   define('DB_PASS', '');             
   ```

3. Setup database:
   - Buat database baru di MySQL/MariaDB
   - Import struktur tabel dari `backend/database/schema.sql` (jika ada)
   - Sesuaikan konfigurasi di `config/db_config.php`


Referensi kredit
- Ayro UI — https://ayroui.com/  
- ThemeWagon — https://themewagon.com/

Lisensi
-------
Template asli mengikuti lisensi MIT (cek lisensi asli jika ada). Modifikasi ini untuk keperluan sekolah; periksa lisensi asli sebelum penggunaan publik/komersial.


Catatan untuk pengelola
-----------------------
Checklist deployment:
1. Fitur backend (jika digunakan):
   - [ ] Install dependency dengan `composer install`
   - [ ] Setup database dan import schema
   - [ ] Konfigurasi SMTP email sudah benar
   - [ ] Test kirim email berhasil
   - [ ] Folder upload (jika ada) memiliki permission yang benar

2. Konten dan tampilan:
   - [ ] Logo dan gambar sudah diganti sesuai sekolah
   - [ ] Informasi kontak sudah diperbarui
   - [ ] Test responsif di mobile/tablet
   - [ ] Formulir kontak berfungsi

3. Security:
   - [ ] File konfigurasi (db_config.php, email_config.php) tidak ter-expose
   - [ ] Validasi form berjalan dengan baik
   - [ ] Rate limiting untuk form kontak (jika ada)

Pengembangan lanjutan:
- Untuk pendaftaran dengan upload dokumen, bisa menggunakan:
  1. Backend PHP (sudah ada struktur dasar)
  2. Google Forms (solusi cepat tanpa setup server)
  3. Layanan form builder (Typeform, JotForm dll)
Hubungi pengembang jika butuh bantuan implementasi backend atau integrasi layanan.

Terima kasih — semoga README ini membantu pengelolaan dan pengembangan situs SMK Prima Bangsa.
