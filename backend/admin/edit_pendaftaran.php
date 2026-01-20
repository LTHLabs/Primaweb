<?php
require_once __DIR__ . '/../config/db_config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: tabelForm.php'); exit;
}

if (empty($_SESSION['admin_logged_in'])) {
    $_SESSION['contact_flash'] = ['status'=>'error','msg'=>'Silakan login terlebih dahulu.'];
    header('Location: login.php');
    exit;
}

try {
    $mysqli = db_connect();
    $stmt = $mysqli->prepare('SELECT * FROM pendaftaran_siswa WHERE id_pendaftaran = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();
    $mysqli->close();
} catch (Exception $e) {
    header('Location: tabelForm.php'); exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Pendaftaran</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h3>Edit Pendaftaran</h3>
    <form action="../controllers/pendaftaran_update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_pendaftaran" value="<?php echo (int)$row['id_pendaftaran']; ?>">
        <div class="mb-3">
            <label>NISN</label>
            <input class="form-control" name="nisn" value="<?php echo htmlspecialchars($row['nisn']); ?>">
        </div>
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input class="form-control" name="nama_lengkap" value="<?php echo htmlspecialchars($row['nama_lengkap']); ?>">
        </div>
        <div class="mb-3 row">
            <div class="col">
                <label>Tempat Lahir</label>
                <input class="form-control" name="tempat_lahir" value="<?php echo htmlspecialchars($row['tempat_lahir']); ?>">
            </div>
            <div class="col">
                <label>Tanggal Lahir</label>
                <input type="date" class="form-control" name="tanggal_lahir" value="<?php echo htmlspecialchars($row['tanggal_lahir']); ?>">
            </div>
        </div>
        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select class="form-control" name="jenis_kelamin">
                <option value="">- Pilih -</option>
                <option value="Laki-laki" <?php echo ($row['jenis_kelamin']=='Laki-laki'?'selected':''); ?>>Laki-laki</option>
                <option value="Perempuan" <?php echo ($row['jenis_kelamin']=='Perempuan'?'selected':''); ?>>Perempuan</option>
            </select>
        </div>

        <?php
            // decode dokumen JSON if available
            $akte = !empty($row['akte_files']) ? json_decode($row['akte_files'], true) : [];
            $kk = !empty($row['kk_files']) ? json_decode($row['kk_files'], true) : [];
            $ktp = !empty($row['ktp_ortu_files']) ? json_decode($row['ktp_ortu_files'], true) : [];
            $ijazah = !empty($row['ijazah_files']) ? json_decode($row['ijazah_files'], true) : [];
            $skhun = !empty($row['skhun_files']) ? json_decode($row['skhun_files'], true) : [];
            $nisn_files = !empty($row['nisn_files']) ? json_decode($row['nisn_files'], true) : [];
            $kip = !empty($row['kip_files']) ? json_decode($row['kip_files'], true) : [];
        ?>

        <hr>
        <h5>Dokumen Terlampir</h5>

        <?php function renderFilesSection($label, $fieldName, $files) { ?>
            <div class="mb-3">
                <label class="form-label"><?php echo $label; ?></label>
                <?php if (!empty($files) && is_array($files)): ?>
                    <ul>
                        <?php foreach ($files as $f): ?>
                            <li>
                                <a target="_blank" href="../<?php echo htmlspecialchars($f); ?>"><?php echo basename($f); ?></a>
                                &nbsp;<label><input type="checkbox" name="remove_<?php echo $fieldName; ?>[]" value="<?php echo htmlspecialchars($f); ?>"> Hapus</label>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Tidak ada file.</p>
                <?php endif; ?>
                <label class="form-label">Unggah file baru (maks 3 total untuk jenis ini)</label>
                <input type="file" name="<?php echo $fieldName; ?>[]" multiple accept="image/*,application/pdf" class="form-control">
            </div>
        <?php } ?>

        <?php renderFilesSection('FC. Akte Lahir', 'akte_files', $akte); ?>
        <?php renderFilesSection('FC. KK', 'kk_files', $kk); ?>
        <?php renderFilesSection('FC. KTP Orang Tua', 'ktp_ortu_files', $ktp); ?>
        <?php renderFilesSection('FC. Ijazah Legalisir', 'ijazah_files', $ijazah); ?>
        <?php renderFilesSection('FC. SKHUN Legalisir', 'skhun_files', $skhun); ?>
        <?php renderFilesSection('FC. NISN', 'nisn_files', $nisn_files); ?>
        <?php renderFilesSection('FC. KIP/PIP (jika ada)', 'kip_files', $kip); ?>

        <div class="mb-3">
            <label>Proses Seleksi</label>
            <select class="form-control" name="proses_seleksi">
                <option value="">- Pilih -</option>
                <option value="Seleksi Berkas" <?php echo ($row['proses_seleksi']=='Seleksi Berkas'?'selected':''); ?>>Seleksi Berkas</option>
                <option value="Wawancara" <?php echo ($row['proses_seleksi']=='Wawancara'?'selected':''); ?>>Wawancara</option>
                <option value="Tes" <?php echo ($row['proses_seleksi']=='Tes'?'selected':''); ?>>Tes</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea class="form-control" name="alamat"><?php echo htmlspecialchars($row['alamat']); ?></textarea>
        </div>
        <div class="mb-3">
            <label>Asal Sekolah</label>
            <input class="form-control" name="asal_sekolah" value="<?php echo htmlspecialchars($row['asal_sekolah']); ?>">
        </div>
        <div class="mb-3 row">
            <div class="col">
                <label>No HP</label>
                <input class="form-control" name="no_hp" value="<?php echo htmlspecialchars($row['no_hp']); ?>">
            </div>
            <div class="col">
                <label>Email</label>
                <input class="form-control" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
            </div>
        </div>
        <div class="mb-3">
            <label>Pilih Ekstrakurikuler (boleh lebih dari satu)</label>
            <?php
            $ekskul_list = [
                'Pramuka', 'Paskibra', 'UKS PMR', 'BTQ (Baca Tulis Al-Quran)',
                'Hadroh', 'Rebana', 'Marawis', 'Markaz Lughoh Arabic',
                'English Club', 'Matematika Club', 'Tenis Meja', 'Futsal',
                'Pengembangan Diri Komputer & Internet'
            ];
            $ekskul_selected = !empty($row['ekstrakurikuler']) ? json_decode($row['ekstrakurikuler'], true) : [];
            if (!is_array($ekskul_selected)) $ekskul_selected = [];
            ?>
            <div class="row">
                <div class="col-12">
                    <?php foreach ($ekskul_list as $eks): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ekstrakurikuler[]" value="<?php echo htmlspecialchars($eks); ?>" id="ekskul_<?php echo md5($eks); ?>" <?php echo in_array($eks, $ekskul_selected)?'checked':''; ?>>
                            <label class="form-check-label" for="ekskul_<?php echo md5($eks); ?>"><?php echo htmlspecialchars($eks); ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label>Foto Formal (kosongkan untuk tidak mengganti)</label>
            <input type="file" class="form-control" name="foto_formal">
            <?php if (!empty($row['foto_formal'])): ?>
                <p>Current: <a target="_blank" href="../<?php echo htmlspecialchars($row['foto_formal']); ?>">Lihat</a></p>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label>Foto Ijazah (kosongkan untuk tidak mengganti)</label>
            <input type="file" class="form-control" name="foto_ijazah">
            <?php if (!empty($row['foto_ijazah'])): ?>
                <p>Current: <a target="_blank" href="../<?php echo htmlspecialchars($row['foto_ijazah']); ?>">Lihat</a></p>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary">Simpan Perubahan</button>
            <a class="btn btn-secondary" href="pendaftaran.php">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
