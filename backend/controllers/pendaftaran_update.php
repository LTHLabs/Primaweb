<?php
require_once __DIR__ . '/../config/db_config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

function redirect_with_flash($status, $msg = '') {
    $_SESSION['contact_flash'] = ['status' => $status, 'msg' => $msg];
    header('Location: ../admin/pendaftaran.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/pendaftaran.php');
    exit;
}

$id = isset($_POST['id_pendaftaran']) ? (int) $_POST['id_pendaftaran'] : 0;
if ($id <= 0) redirect_with_flash('error', 'ID tidak valid.');

$nisn = isset($_POST['nisn']) ? trim($_POST['nisn']) : '';
$nama_lengkap = isset($_POST['nama_lengkap']) ? trim($_POST['nama_lengkap']) : '';
$tempat_lahir = isset($_POST['tempat_lahir']) ? trim($_POST['tempat_lahir']) : '';
$tanggal_lahir = isset($_POST['tanggal_lahir']) ? trim($_POST['tanggal_lahir']) : null;
$jenis_kelamin = isset($_POST['jenis_kelamin']) ? trim($_POST['jenis_kelamin']) : null;
$alamat = isset($_POST['alamat']) ? trim($_POST['alamat']) : null;
$asal_sekolah = isset($_POST['asal_sekolah']) ? trim($_POST['asal_sekolah']) : null;
$no_hp = isset($_POST['no_hp']) ? trim($_POST['no_hp']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$program_keahlian = isset($_POST['program_keahlian']) ? trim($_POST['program_keahlian']) : null;

if ($nisn === '' || $nama_lengkap === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect_with_flash('error', 'Validasi gagal: NISN/Nama/Email wajib dan harus valid.');
}

$upload_dir = __DIR__ . '/../uploads/pendaftaran/';
$allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
$max_size = 2 * 1024 * 1024;

function handle_update_file($field, $upload_dir, $allowed_types, $max_size, $existing) {
    if (empty($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) return $existing;
    $f = $_FILES[$field];
    if ($f['error'] !== UPLOAD_ERR_OK) return $existing;
    if ($f['size'] > $max_size) return $existing;
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $f['tmp_name']);
    finfo_close($finfo);
    if (!in_array($mime, $allowed_types)) return $existing;
    $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
    $safe = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $dest = $upload_dir . $safe;
    if (move_uploaded_file($f['tmp_name'], $dest)) {
        if (!empty($existing)) @unlink(__DIR__ . '/../' . $existing);
        return 'uploads/pendaftaran/' . $safe;
    }
    return $existing;
}

// fetch existing to know file paths
try {
    $mysqli = db_connect();
    $sel = $mysqli->prepare('SELECT foto_formal, foto_ijazah FROM pendaftaran_siswa WHERE id_pendaftaran = ?');
    $sel->bind_param('i', $id);
    $sel->execute();
    $res = $sel->get_result();
    $row = $res->fetch_assoc();
    $sel->close();
} catch (Exception $e) {
    redirect_with_flash('error', 'Gagal mengambil data.');
}

$foto_formal_path = handle_update_file('foto_formal', $upload_dir, $allowed_types, $max_size, $row['foto_formal']);
$foto_ijazah_path = handle_update_file('foto_ijazah', $upload_dir, $allowed_types, $max_size, $row['foto_ijazah']);

try {
    $stmt = $mysqli->prepare('UPDATE pendaftaran_siswa SET nisn=?, nama_lengkap=?, tempat_lahir=?, tanggal_lahir=?, jenis_kelamin=?, alamat=?, asal_sekolah=?, no_hp=?, email=?, program_keahlian=?, foto_formal=?, foto_ijazah=? WHERE id_pendaftaran = ?');
    $stmt->bind_param('ssssssssssssi', $nisn, $nama_lengkap, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $alamat, $asal_sekolah, $no_hp, $email, $program_keahlian, $foto_formal_path, $foto_ijazah_path, $id);
    if (!$stmt->execute()) throw new Exception('Execute failed');
    $stmt->close();
    $mysqli->close();
    redirect_with_flash('success', 'Data berhasil diperbarui.');
} catch (Exception $e) {
    redirect_with_flash('error', 'Gagal memperbarui data.');
}
