<?php
require_once __DIR__ . '/../config/db_config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: pendaftaran.php'); exit;
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
    header('Location: pendaftaran.php'); exit;
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
            <label>Program Keahlian</label>
            <select class="form-control" name="program_keahlian">
                <option value="">- Pilih -</option>
                <option value="Rekayasa Perangkat Lunak (RPL)" <?php echo ($row['program_keahlian']=='Rekayasa Perangkat Lunak (RPL)'?'selected':''); ?>>Rekayasa Perangkat Lunak (RPL)</option>
                <option value="Teknik Komputer Jaringan (TKJ)" <?php echo ($row['program_keahlian']=='Teknik Komputer Jaringan (TKJ)'?'selected':''); ?>>Teknik Komputer Jaringan (TKJ)</option>
                <option value="Desain Komunikasi Visual (DKV)" <?php echo ($row['program_keahlian']=='Desain Komunikasi Visual (DKV)'?'selected':''); ?>>Desain Komunikasi Visual (DKV)</option>
            </select>
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
