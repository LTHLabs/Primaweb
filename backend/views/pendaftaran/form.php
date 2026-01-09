
<!doctype html>
<html lang="id">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pendaftaran Siswa</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/pendaftaran.css">
        <style>
        /* disable browser native :valid green styling inside our form so JS controls UX */
        #pendaftaranForm input:valid,
        #pendaftaranForm select:valid,
        #pendaftaranForm textarea:valid {
            box-shadow: none !important;
        }
        </style>
</head>
<body>

<!-- Bootstrap Form -->
<section class="h-100 gradient-form">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">

                                <div class="text-center left-col-center">
                                    <img src="assets/images/logo.jpg" class="login-logo w-25" alt="logo">
                                    <h4 class="mt-1 mb-4 pb-1 text-center">Pendaftaran Siswa</h4>
                                </div>

                                <?php if (!empty($_GET['success'])): ?>
                                        <div class="alert alert-success">Pendaftaran berhasil. ID: <?php echo htmlspecialchars($_GET['id'] ?? ''); ?></div>
                                <?php endif; ?>

                                <?php if (!empty($_GET['error'])): ?>
                                        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
                                <?php endif; ?>

                                <form id="pendaftaranForm" action="pendaftaran_submit.php" method="post" enctype="multipart/form-data" novalidate>
                                    <div class="mb-3">
                                        <label class="form-label" for="nama">Nama Lengkap</label>
                                        <input type="text" id="nama" name="nama" class="form-control" required>
                                        <div class="invalid-feedback">Masukkan nama lengkap (minimal 3 karakter).</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="nisn">NISN</label>
                                        <input type="text" id="nisn" name="nisn" class="form-control" required>
                                        <div class="invalid-feedback">NISN harus berupa angka (8–12 digit) jika diisi.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" required>
                                        <div class="invalid-feedback">Masukkan tempat lahir yang valid jika diisi.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" required>
                                        <div class="invalid-feedback">Tanggal lahir tidak boleh di masa depan.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select">
                                            <option value="">Pilih...</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                        <div class="invalid-feedback">Pilih jenis kelamin.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="alamat">Alamat</label>
                                        <textarea id="alamat" name="alamat" class="form-control" rows="3"></textarea>
                                        <div class="invalid-feedback">Masukkan alamat (minimal 10 karakter).</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="sekolah_asal">Asal Sekolah</label>
                                        <input type="text" id="sekolah_asal" name="sekolah_asal" class="form-control">
                                        <div class="invalid-feedback">Isi asal sekolah.</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="email" id="email" name="email" class="form-control">
                                            <div class="invalid-feedback">Masukkan email yang valid.</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="telepon">No HP</label>
                                            <input type="text" id="telepon" name="telepon" class="form-control">
                                            <div class="invalid-feedback">Masukkan nomor telepon yang valid (min 7 digit).</div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="program_keahlian">Program Keahlian</label>
                                        <select id="program_keahlian" name="program_keahlian" class="form-select">
                                            <option value="">Pilih Program...</option>
                                            <option value="Rekayasa Perangkat Lunak (RPL)">Rekayasa Perangkat Lunak (RPL)</option>
                                            <option value="Teknik Komputer Jaringan (TKJ)">Teknik Komputer Jaringan (TKJ)</option>
                                            <option value="Desain Komunikasi Visual (DKV)">Desain Komunikasi Visual (DKV)</option>
                                        </select>
                                        <div class="invalid-feedback">Pilih program keahlian.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="foto_formal">Foto Formal (opsional)</label>
                                        <input type="file" id="foto_formal" name="foto_formal" accept="image/*" class="form-control" required>
                                        <div class="invalid-feedback">Ukuran file terlalu besar atau format tidak didukung.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="foto_ijazah">Foto Ijazah (opsional)</label>
                                        <input type="file" id="foto_ijazah" name="foto_ijazah" accept="image/*" class="form-control" required>
                                        <div class="invalid-feedback">Ukuran file terlalu besar atau format tidak didukung.</div>
                                    </div>

                                    <hr>
                                    <h5>Upload Berkas (lampirkan masing-masing hingga 3 file)</h5>

                                    <div class="mb-3">
                                        <label class="form-label">FC. Akte Lahir, KK dan KTP Orang Tua (3 Lembar)</label>
                                        <input type="file" name="akte_files[]" multiple accept="image/*,application/pdf" class="form-control mb-2" required>
                                        <div class="invalid-feedback">Unggah maksimal 3 file untuk tiap jenis dokumen.</div>
                                        <input type="file" name="kk_files[]" multiple accept="image/*,application/pdf" class="form-control mb-2" required>
                                        <div class="invalid-feedback">Unggah maksimal 3 file untuk tiap jenis dokumen.</div>
                                        <input type="file" name="ktp_ortu_files[]" multiple accept="image/*,application/pdf" class="form-control" required>
                                        <div class="invalid-feedback">Unggah maksimal 3 file untuk tiap jenis dokumen.</div>
                                        <small class="text-muted">Untuk setiap jenis dokumen, unggah hingga 3 file (foto/pdf).</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">FC. Ijazah Legalisir (3 Lembar)</label>
                                        <input type="file" name="ijazah_files[]" multiple accept="image/*,application/pdf" class="form-control" required>
                                        <div class="invalid-feedback">Unggah maksimal 3 file untuk tiap jenis dokumen.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">FC. SKHUN Legalisir (3 Lembar)</label>
                                        <input type="file" name="skhun_files[]" multiple accept="image/*,application/pdf" class="form-control" required>
                                        <div class="invalid-feedback">Unggah maksimal 3 file untuk tiap jenis dokumen.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">FC. NISN (3 Lembar)</label>
                                        <input type="file" name="nisn_files[]" multiple accept="image/*,application/pdf" class="form-control" required>
                                        <div class="invalid-feedback">Unggah maksimal 3 file untuk tiap jenis dokumen.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">FC. KIP/PIP (3 Lembar) — Jika Ada</label>
                                        <input type="file" name="kip_files[]" multiple accept="image/*,application/pdf" class="form-control">
                                        <div class="invalid-feedback">Unggah maksimal 3 file untuk tiap jenis dokumen.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="proses_seleksi">Proses Seleksi saat Mendaftar</label>
                                        <select id="proses_seleksi" name="proses_seleksi" class="form-select">
                                            <option value="">Pilih Proses...</option>
                                            <option value="Seleksi Berkas">Seleksi Berkas</option>
                                            <option value="Wawancara">Wawancara</option>
                                            <option value="Tes">Tes</option>
                                        </select>
                                        <div class="invalid-feedback">Pilih proses seleksi.</div>
                                        <small class="text-muted d-block">Pilih metode seleksi yang akan dijalani saat mendaftar.</small>
                                    </div>

                                    <div class="text-center pt-1 mb-4 pb-1">
                                        <button class="btn btn-outline-primary btn-block" type="submit">Daftar</button>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center pb-4">
                                        <a href="index.php" class="btn btn-outline-secondary">Kembali ke Beranda</a>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center right-panel">
                                <img class="w-100" src="assets/images/header/MTs_An-Nur_Kota_Cirebon.jpg" alt="header image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/pendaftaran.js"></script>
</body>
</html>
