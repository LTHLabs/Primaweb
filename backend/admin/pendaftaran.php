<?php
require_once __DIR__ . '/../config/db_config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Protect admin page
if (empty($_SESSION['admin_logged_in'])) {
    $_SESSION['contact_flash'] = ['status'=>'error','msg'=>'Silakan login terlebih dahulu.'];
    header('Location: login.php');
    exit;
}
$flash = $_SESSION['contact_flash'] ?? null;
if (isset($_SESSION['contact_flash'])) unset($_SESSION['contact_flash']);

try {
    $mysqli = db_connect();
    $res = $mysqli->query('SELECT * FROM pendaftaran_siswa ORDER BY tanggal_daftar DESC');
    $rows = [];
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    $mysqli->close();
} catch (Exception $e) {
    $rows = [];
    $error = $e->getMessage();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin - Pendaftaran Siswa</title>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h3>Admin - Daftar Pendaftar</h3>
    <?php if (!empty($flash)): ?>
        <div class="alert alert-<?php echo ($flash['status']==='success'?'success':'warning'); ?>"><?php echo htmlspecialchars($flash['msg']); ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <a class="btn btn-primary mb-3" href="../index.php#daftar-pendaftar">Kembali ke Landing Page</a>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Program</th>
                <th>No HP</th>
                <th>Email</th>
                <th>Tanggal Daftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach ($rows as $r): ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo htmlspecialchars($r['nisn']); ?></td>
                <td><?php echo htmlspecialchars($r['nama_lengkap']); ?></td>
                <td><?php echo htmlspecialchars($r['program_keahlian']); ?></td>
                <td><?php echo htmlspecialchars($r['no_hp']); ?></td>
                <td><?php echo htmlspecialchars($r['email']); ?></td>
                <td><?php echo htmlspecialchars($r['tanggal_daftar']); ?></td>
                <td>
                    <a class="btn btn-sm btn-info" href="edit_pendaftaran.php?id=<?php echo $r['id_pendaftaran']; ?>">Edit</a>
                    <a class="btn btn-sm btn-danger" href="../controllers/pendaftaran_delete.php?id=<?php echo $r['id_pendaftaran']; ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
