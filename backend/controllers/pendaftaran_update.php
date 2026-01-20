<?php
require_once __DIR__ . '/../config/db_config.php';
if (session_status() === PHP_SESSION_NONE) session_start();

function redirect_with_flash($status, $msg = '') {
    $_SESSION['contact_flash'] = ['status' => $status, 'msg' => $msg];
    header('Location: ../admin/tabelForm.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin/tabelForm.php');
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
$ekstrakurikuler = isset($_POST['ekstrakurikuler']) ? $_POST['ekstrakurikuler'] : [];
if (!is_array($ekstrakurikuler)) $ekstrakurikuler = [$ekstrakurikuler];

if ($nisn === '' || $nama_lengkap === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect_with_flash('error', 'Validasi gagal: NISN/Nama/Email wajib dan harus valid.');
}

// Validasi tanggal lahir (jika diisi)
if (!empty($tanggal_lahir)) {
    $d = DateTime::createFromFormat('Y-m-d', $tanggal_lahir);
    $validDate = $d && $d->format('Y-m-d') === $tanggal_lahir;
    if (! $validDate) redirect_with_flash('error', 'Format Tanggal Lahir tidak valid. Gunakan YYYY-MM-DD.');
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

try {
    $mysqli = db_connect();
    $sel = $mysqli->prepare('SELECT foto_formal, foto_ijazah, akte_files, kk_files, ktp_ortu_files, ijazah_files, skhun_files, nisn_files, kip_files, proses_seleksi FROM pendaftaran_siswa WHERE id_pendaftaran = ?');
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

$existing_akte = !empty($row['akte_files']) ? json_decode($row['akte_files'], true) : [];
$existing_kk = !empty($row['kk_files']) ? json_decode($row['kk_files'], true) : [];
$existing_ktp = !empty($row['ktp_ortu_files']) ? json_decode($row['ktp_ortu_files'], true) : [];
$existing_ijazah = !empty($row['ijazah_files']) ? json_decode($row['ijazah_files'], true) : [];
$existing_skhun = !empty($row['skhun_files']) ? json_decode($row['skhun_files'], true) : [];
$existing_nisn = !empty($row['nisn_files']) ? json_decode($row['nisn_files'], true) : [];
$existing_kip = !empty($row['kip_files']) ? json_decode($row['kip_files'], true) : [];

$remove_akte = $_POST['remove_akte_files'] ?? $_POST['remove_akte'] ?? [];
$remove_kk = $_POST['remove_kk_files'] ?? $_POST['remove_kk'] ?? [];
$remove_ktp = $_POST['remove_ktp_ortu_files'] ?? $_POST['remove_ktp'] ?? [];
$remove_ijazah = $_POST['remove_ijazah_files'] ?? $_POST['remove_ijazah'] ?? [];
$remove_skhun = $_POST['remove_skhun_files'] ?? $_POST['remove_skhun'] ?? [];
$remove_nisn = $_POST['remove_nisn_files'] ?? $_POST['remove_nisn'] ?? [];
$remove_kip = $_POST['remove_kip_files'] ?? $_POST['remove_kip'] ?? [];

$existing_akte = array_values(array_filter($existing_akte, function($v) use ($remove_akte){ return !in_array($v, (array)$remove_akte); }));
$existing_kk = array_values(array_filter($existing_kk, function($v) use ($remove_kk){ return !in_array($v, (array)$remove_kk); }));
$existing_ktp = array_values(array_filter($existing_ktp, function($v) use ($remove_ktp){ return !in_array($v, (array)$remove_ktp); }));
$existing_ijazah = array_values(array_filter($existing_ijazah, function($v) use ($remove_ijazah){ return !in_array($v, (array)$remove_ijazah); }));
$existing_skhun = array_values(array_filter($existing_skhun, function($v) use ($remove_skhun){ return !in_array($v, (array)$remove_skhun); }));
$existing_nisn = array_values(array_filter($existing_nisn, function($v) use ($remove_nisn){ return !in_array($v, (array)$remove_nisn); }));
$existing_kip = array_values(array_filter($existing_kip, function($v) use ($remove_kip){ return !in_array($v, (array)$remove_kip); }));

$uploadMultiple = function($fieldName, $prefix) use ($upload_dir) {
    $ret = [];
    if (empty($_FILES[$fieldName])) return $ret;
    if (!is_array($_FILES[$fieldName]['name'])) {
        if ($_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION);
            $safe = time() . '_' . uniqid($prefix . '_') . '.' . $ext;
            $dest = $upload_dir . $safe;
            if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $dest)) $ret[] = 'uploads/pendaftaran/' . $safe;
        }
        return $ret;
    }
    $count = count($_FILES[$fieldName]['name']);
    for ($i=0;$i<$count;$i++){
        if ($_FILES[$fieldName]['error'][$i] !== UPLOAD_ERR_OK) continue;
        $ext = pathinfo($_FILES[$fieldName]['name'][$i], PATHINFO_EXTENSION);
        $safe = time() . '_' . uniqid($prefix . '_') . '.' . $ext;
        $dest = $upload_dir . $safe;
        if (move_uploaded_file($_FILES[$fieldName]['tmp_name'][$i], $dest)) $ret[] = 'uploads/pendaftaran/' . $safe;
    }
    return $ret;
};

$new_akte = $uploadMultiple('akte_files', 'akte');
$existing_akte = array_slice(array_merge($existing_akte, $new_akte), 0, 3);
$new_kk = $uploadMultiple('kk_files', 'kk');
$existing_kk = array_slice(array_merge($existing_kk, $new_kk), 0, 3);
$new_ktp = $uploadMultiple('ktp_ortu_files', 'ktp_ortu');
$existing_ktp = array_slice(array_merge($existing_ktp, $new_ktp), 0, 3);
$new_ijazah = $uploadMultiple('ijazah_files', 'ijazah');
$existing_ijazah = array_slice(array_merge($existing_ijazah, $new_ijazah), 0, 3);
$new_skhun = $uploadMultiple('skhun_files', 'skhun');
$existing_skhun = array_slice(array_merge($existing_skhun, $new_skhun), 0, 3);
$new_nisn = $uploadMultiple('nisn_files', 'nisn');
$existing_nisn = array_slice(array_merge($existing_nisn, $new_nisn), 0, 3);
$new_kip = $uploadMultiple('kip_files', 'kip');
$existing_kip = array_slice(array_merge($existing_kip, $new_kip), 0, 3);

try {
    $stmt = $mysqli->prepare('UPDATE pendaftaran_siswa SET nisn=?, nama_lengkap=?, tempat_lahir=?, tanggal_lahir=NULLIF(?, \'\'), jenis_kelamin=?, alamat=?, asal_sekolah=?, no_hp=?, email=?, ekstrakurikuler=?, foto_formal=?, foto_ijazah=?, akte_files=?, kk_files=?, ktp_ortu_files=?, ijazah_files=?, skhun_files=?, nisn_files=?, kip_files=?, proses_seleksi=? WHERE id_pendaftaran = ?');
    $json_akte = json_encode($existing_akte);
    $json_kk = json_encode($existing_kk);
    $json_ktp = json_encode($existing_ktp);
    $json_ijazah = json_encode($existing_ijazah);
    $json_skhun = json_encode($existing_skhun);
    $json_nisn = json_encode($existing_nisn);
    $json_kip = json_encode($existing_kip);
    $proses_sel = trim($_POST['proses_seleksi'] ?? '');
    $ekstrakurikuler_json = json_encode($ekstrakurikuler);

    $types = str_repeat('s', 20) . 'i';
    $stmt->bind_param($types,
        $nisn,
        $nama_lengkap,
        $tempat_lahir,
        $tanggal_lahir,
        $jenis_kelamin,
        $alamat,
        $asal_sekolah,
        $no_hp,
        $email,
        $ekstrakurikuler_json,
        $foto_formal_path,
        $foto_ijazah_path,
        $json_akte,
        $json_kk,
        $json_ktp,
        $json_ijazah,
        $json_skhun,
        $json_nisn,
        $json_kip,
        $proses_sel,
        $id
    );
    if (!$stmt->execute()) throw new Exception('Execute failed');
    $stmt->close();
    $mysqli->close();
    redirect_with_flash('success', 'Data berhasil diperbarui.');
} catch (Exception $e) {
    redirect_with_flash('error', 'Gagal memperbarui data.');
}
