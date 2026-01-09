<?php
require_once __DIR__ . '/../config/db_config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

function redirect($msg = '') {
    $_SESSION['contact_flash'] = ['status' => 'success', 'msg' => $msg];
    header('Location: ../admin/tabelForm.php');
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    redirect('ID tidak valid.');
}

try {
    $mysqli = db_connect();
    // fetch file paths and dokumen JSON
    $sel = $mysqli->prepare('SELECT foto_formal, foto_ijazah, akte_files, kk_files, ktp_ortu_files, ijazah_files, skhun_files, nisn_files, kip_files FROM pendaftaran_siswa WHERE id_pendaftaran = ?');
    $sel->bind_param('i', $id);
    $sel->execute();
    $res = $sel->get_result();
    $row = $res->fetch_assoc();
    $sel->close();

    $stmt = $mysqli->prepare('DELETE FROM pendaftaran_siswa WHERE id_pendaftaran = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();

    // unlink foto files
    if (!empty($row['foto_formal'])) {
        @unlink(__DIR__ . '/../' . $row['foto_formal']);
    }
    if (!empty($row['foto_ijazah'])) {
        @unlink(__DIR__ . '/../' . $row['foto_ijazah']);
    }
    // unlink dokumen JSON lists
    $docCols = ['akte_files','kk_files','ktp_ortu_files','ijazah_files','skhun_files','nisn_files','kip_files'];
    foreach ($docCols as $c) {
        if (!empty($row[$c])) {
            $arr = json_decode($row[$c], true);
            if (is_array($arr)) {
                foreach ($arr as $f) {
                    @unlink(__DIR__ . '/../' . $f);
                }
            }
        }
    }

    redirect('Data pendaftaran berhasil dihapus.');
} catch (Exception $e) {
    redirect('Gagal menghapus data.');
}
