<?php
require_once __DIR__ . '/../config/db_config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load email config
$email_config = require __DIR__ . '/../config/email_config.php';
$DESTINATION_EMAIL = $email_config['smtp_username'];

function redirect_with_flash($status, $msg = '') {
    $_SESSION['contact_flash'] = ['status' => $status, 'msg' => $msg];
    // redirect to contact area where flash is displayed
    header('Location: ../index.php#contact');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

// Basic input
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

$errors = [];
if ($nisn === '') $errors[] = 'NISN wajib diisi.';
if ($nama_lengkap === '') $errors[] = 'Nama lengkap wajib diisi.';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email tidak valid.';
if ($no_hp === '' || !preg_match('/^[0-9+\-\s]{6,15}$/', $no_hp)) $errors[] = 'Nomor HP tidak valid.';

// Handle uploads
$upload_dir = __DIR__ . '/../uploads/pendaftaran/';
@mkdir($upload_dir, 0755, true);
$foto_formal_path = null;
$foto_ijazah_path = null;
$allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
$max_size = 2 * 1024 * 1024; // 2MB

function handle_file($field, $upload_dir, $allowed_types, $max_size) {
    if (empty($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) return null;
    $f = $_FILES[$field];
    if ($f['error'] !== UPLOAD_ERR_OK) return null;
    if ($f['size'] > $max_size) return null;
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $f['tmp_name']);
    finfo_close($finfo);
    if (!in_array($mime, $allowed_types)) return null;
    $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
    $safe = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $dest = $upload_dir . $safe;
    if (move_uploaded_file($f['tmp_name'], $dest)) {
        // return relative path from backend root
        return 'uploads/pendaftaran/' . $safe;
    }
    return null;
}

$foto_formal_path = handle_file('foto_formal', $upload_dir, $allowed_types, $max_size);
$foto_ijazah_path = handle_file('foto_ijazah', $upload_dir, $allowed_types, $max_size);

if (!empty($errors)) {
    redirect_with_flash('error', implode(' ', $errors));
}

// Token generation
$token = bin2hex(random_bytes(16));
$token_expired = (new DateTime('+7 days'))->format('Y-m-d H:i:s');

try {
    $mysqli = db_connect();
    $stmt = $mysqli->prepare("INSERT INTO pendaftaran_siswa 
        (nisn, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, asal_sekolah, no_hp, email, token, token_expired, program_keahlian, foto_formal, foto_ijazah)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) throw new Exception('Prepare failed: ' . $mysqli->error);
    $stmt->bind_param('ssssssssssssss', $nisn, $nama_lengkap, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $alamat, $asal_sekolah, $no_hp, $email, $token, $token_expired, $program_keahlian, $foto_formal_path, $foto_ijazah_path);
    if (!$stmt->execute()) throw new Exception('Execute failed: ' . $stmt->error);
    $inserted_id = $stmt->insert_id;
    $stmt->close();
    $mysqli->close();
} catch (Exception $e) {
    redirect_with_flash('error', 'Database error saat menyimpan pendaftaran.');
}

// Send notification email to admin
$mail_subject = "[PSB] Pendaftaran Baru: " . $nama_lengkap;
$mail_body = "Pendaftaran baru masuk:\n\n";
$mail_body .= "NISN: $nisn\nNama: $nama_lengkap\nEmail: $email\nHP: $no_hp\nProgram: $program_keahlian\nID: $inserted_id\nToken: $token\n";

$mail = new PHPMailer(true);
$mail_sent = false;
try {
    $mail->isSMTP();
    $mail->Host       = $email_config['smtp_host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $email_config['smtp_username'];
    $mail->Password   = $email_config['smtp_password'];
    $mail->SMTPSecure = $email_config['smtp_secure'];
    $mail->Port       = $email_config['smtp_port'];
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom($email_config['from_email'], $email_config['from_name']);
    $mail->addAddress($DESTINATION_EMAIL);
    $mail->addReplyTo($email, $nama_lengkap);

    $mail->isHTML(false);
    $mail->Subject = $mail_subject;
    $mail->Body    = $mail_body;

    $mail_sent = $mail->send();
} catch (Exception $e) {
    error_log('Mail error: ' . $e->getMessage());
    $mail_sent = false;
}

if ($mail_sent) {
    redirect_with_flash('success', 'Pendaftaran berhasil dikirim dan tersimpan.');
} else {
    redirect_with_flash('success_mailfail', 'Pendaftaran tersimpan, namun pengiriman email pemberitahuan gagal.');
}
