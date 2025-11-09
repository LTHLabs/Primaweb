# SMK Prima Bangsa
SMK Prima Bangsa sebuah Sekolah Menengah Kejuruan yang fokus pada pengembangan kompetensi vokasi di bidang teknologi,
jaringan, dan desain. Situs ini menyajikan informasi profil sekolah, program keahlian, fasilitas, berita kegiatan,
testimoni siswa & alumni, serta kontak/pendaftaran.

Preview
-------
- Buka file `index.html` secara lokal di browser untuk melihat tampilan situs.

Cara menjalankan (lokal)
-----------------------
1. Pastikan struktur folder tetap utuh (file `index.html`, folder `assets/`, dan `style.css`).
2. Buka `d:\Project_Tecnologia\Apps_Prima\index.html` di browser (double-click atau Open With > browser).
3. Untuk pengembangan lebih lanjut, Anda dapat menggunakan server lokal (opsional):

	 - Dengan Python 3 (opsional):

		 ```powershell
		 cd d:\Project_Tecnologia\Apps_Prima
		 python -m http.server 8000
		 ```

	 - Lalu buka http://localhost:8000 di browser.

Penyesuaian cepat (apa yang biasanya perlu diganti)
--------------------------------------------------
- Logo: ganti `assets/images/logo.svg` dan `assets/images/white-logo.svg` dengan logo SMK Prima Bangsa.
- Gambar hero, berita, testimonial: ganti file di `assets/images/header/`, `assets/images/blog/`, dan `assets/images/testimonial/`.
- Video profil: perbarui tautan YouTube di anchor hero dan inisialisasi GLightbox di `index.html`.
- Informasi kontak: cek dan ubah di bagian `#contact` dan footer (saat ini terisi contoh alamat dan telepon sekolah).
- Warna utama: sudah diatur ke biru tua `#003366` di `style.css` melalui variabel `--primary`.

Struktur proyek (ringkas)
------------------------
assets/                - gambar, css vendor, js vendor
	css/                 - bootstrap, plugin css
	images/              - logo, header, blog, testimonial, client-logo
	js/                  - plugin js (bootstrap bundle, glightbox, tiny-slider, main)
index.html             - halaman utama (static)
style.css              - kustomisasi tema dan variabel warna
README.md              - dokumentasi ini

Lisensi
-------
Kode sumber template asli mengikuti lisensi MIT (cek file lisensi asli jika ada). Modifikasi ini disediakan untuk
keperluan sekolah. Jika ingin menggunakan kembali secara publik atau komersial, periksa lisensi asli dan
informasi hak cipta dari Ayro UI / ThemeWagon.

Catatan untuk pengelola
-----------------------
- Untuk fitur pendaftaran (PMB) lanjutan yang membutuhkan upload dokumen atau penyimpanan data, dibutuhkan
	backend (mis. server PHP/Node/Python dan database) atau integrasi ke Google Forms / layanan email. Saya dapat
	membantu menambahkan form front-end atau membuat rancangan backend apabila Anda menginginkannya.

