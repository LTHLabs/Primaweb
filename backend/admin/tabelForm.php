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
    $ekskul_counts = [];
    $total_siswa = 0;
    while ($r = $res->fetch_assoc()) {
        $rows[] = $r;
        $total_siswa++;
        if (!empty($r['ekstrakurikuler'])) {
            $eks = json_decode($r['ekstrakurikuler'], true);
            if (is_array($eks)) {
                foreach ($eks as $e) {
                    if (!isset($ekskul_counts[$e])) $ekskul_counts[$e] = 0;
                    $ekskul_counts[$e]++;
                }
            }
        }
    }
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
<link rel="shortcut icon" href="../assets/images/logo.jpg" type="image/x-icon" />
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
        <a class="btn btn-primary mb-3" href="logout.php">Keluar</a>

        <!-- Rekap Jumlah Siswa -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Rekap Jumlah Siswa</h5>
                <p>Total Pendaftar: <strong><?php echo $total_siswa; ?></strong></p>
                <ul>
                    <?php foreach ($ekskul_counts as $eks => $count): ?>
                        <li><?php echo htmlspecialchars($eks); ?>: <strong><?php echo $count; ?></strong></li>
                    <?php endforeach; ?>
                </ul>
                <form method="post" action="unduh_rekap.php" style="display:inline;">
                    <button type="submit" class="btn btn-success btn-sm">Unduh Rekap (CSV)</button>
                </form>
            </div>
        </div>

        <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Foto Formal</th>
                <th>Foto Ijazah</th>
                <th>Dokumen</th>
                <th>Ekstrakurikuler</th>
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
                <td style="width:90px; text-align:center;">
                    <?php if (!empty($r['foto_formal'])): ?>
                        <a href="../<?php echo htmlspecialchars($r['foto_formal']); ?>" target="_blank"><img src="../<?php echo htmlspecialchars($r['foto_formal']); ?>" style="max-width:70px; max-height:70px; object-fit:cover; border-radius:4px;"></a>
                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
                </td>
                <td style="width:90px; text-align:center;">
                    <?php if (!empty($r['foto_ijazah'])): ?>
                        <a href="../<?php echo htmlspecialchars($r['foto_ijazah']); ?>" target="_blank"><img src="../<?php echo htmlspecialchars($r['foto_ijazah']); ?>" style="max-width:70px; max-height:70px; object-fit:cover; border-radius:4px;"></a>
                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php
                        // dokumen preview: decode semua kolom JSON and show links + counts
                        $docCols = [
                            'akte_files' => 'Akte',
                            'kk_files' => 'KK',
                            'ktp_ortu_files' => 'KTP Ortu',
                            'ijazah_files' => 'Ijazah',
                            'skhun_files' => 'SKHUN',
                            'nisn_files' => 'NISN',
                            'kip_files' => 'KIP/PIP'
                        ];
                        $docParts = [];
                        foreach ($docCols as $col => $label) {
                            if (!empty($r[$col])) {
                                $arr = json_decode($r[$col], true);
                                if (is_array($arr) && count($arr) > 0) {
                                    $first = $arr[0];
                                    $count = count($arr);
                                    $docParts[] = '<a href="../'.htmlspecialchars($first).'" target="_blank">'.htmlspecialchars($label).' ('.intval($count).')</a>';
                                }
                            }
                        }
                        if (count($docParts) > 0) {
                            echo implode('<br>', $docParts);
                        } else {
                            echo '<span class="text-muted">Tidak ada dokumen</span>';
                        }
                    ?>
                </td>
                <td>
                    <?php
                    if (!empty($r['ekstrakurikuler'])) {
                        $eks = json_decode($r['ekstrakurikuler'], true);
                        if (is_array($eks)) {
                            echo implode('<br>', array_map('htmlspecialchars', $eks));
                        } else {
                            echo htmlspecialchars($r['ekstrakurikuler']);
                        }
                    } else {
                        echo '<span class="text-muted">-</span>';
                    }
                    ?>
                </td>
                <td><?php echo htmlspecialchars($r['no_hp']); ?></td>
                <td><?php echo htmlspecialchars($r['email']); ?></td>
                <td><?php echo htmlspecialchars($r['tanggal_daftar']); ?></td>
                <td>
                    <a class="btn btn-sm btn-info" href="edit_pendaftaran.php?id=<?php echo $r['id_pendaftaran']; ?>">Edit</a>
                    <a class="btn btn-sm btn-danger" href="../controllers/pendaftaran_delete.php?id=<?php echo $r['id_pendaftaran']; ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    <form method="post" action="verifikasi_email.php" style="display:inline;">
                        <input type="hidden" name="id_pendaftaran" value="<?php echo $r['id_pendaftaran']; ?>">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($r['email']); ?>">
                        <input type="hidden" name="nama" value="<?php echo htmlspecialchars($r['nama_lengkap']); ?>">
                        <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Verifikasi dan kirim email ke siswa ini?')">Verifikasi & Kirim Email</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
