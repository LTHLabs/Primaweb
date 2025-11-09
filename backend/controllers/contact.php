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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

function redirect_with_flash($status, $msg = '') {
	$_SESSION['contact_flash'] = ['status' => $status, 'msg' => $msg];
	header('Location: ../index.php#contact');
	exit;
}

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

$errors = [];

if ($name === '') $errors[] = 'Nama harus diisi.';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email tidak valid.';
if ($phone === '') $errors[] = 'Telepon harus diisi.';

if ($subject === '') $errors[] = 'Perihal harus diisi.';
if ($message === '') $errors[] = 'Pesan tidak boleh kosong.';

if (!empty($errors)) {
	redirect_with_flash('error', implode(' ', $errors));
}

try {
	$mysqli = db_connect();

	$stmt = $mysqli->prepare("INSERT INTO contacts
		(name, email, phone, subject, message, created_at, status)
		VALUES (?, ?, ?, ?, ?, NOW(), 'new')");

	if (! $stmt) {
		throw new Exception('Prepare failed: ' . $mysqli->error);
	}

	$stmt->bind_param('sssss', $name, $email, $phone, $subject, $message);
	if (! $stmt->execute()) {
		throw new Exception('Execute failed: ' . $stmt->error);
	}

	$inserted_id = $stmt->insert_id;
	$stmt->close();
	$mysqli->close();
} catch (Exception $e) {
	// redirect_with_flash('error', 'Database error: ' . $e->getMessage());
	redirect_with_flash('error', 'Database error 🚫 ');
}

$mail_subject = "SMK Prima Bangsa - Pesan Kontak: " . ($subject ?: '(no subject)');
$mail_body = "Anda menerima pesan baru dari formulir kontak:\n\n";

$mail_body .= "Nama: " . $name . "\n";
$mail_body .= "Email: " . $email . "\n";
$mail_body .= "Telepon: " . $phone . "\n";

$mail_body .= "Perihal: " . $subject . "\n\n";
$mail_body .= "Pesan:\n" . $message . "\n\n";
$mail_body .= "Record ID: " . $inserted_id . "\n";

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
    $mail->addReplyTo($email, $name);

    $mail->isHTML(true);
    $mail->Subject = $mail_subject;
    
    $html_body = nl2br(htmlspecialchars($mail_body));
    $mail->Body    = $html_body;
    $mail->AltBody = $mail_body; 

    $mail_sent = $mail->send();
} catch (Exception $e) {
    $mail_sent = false;
    error_log("Email error: " . $e->getMessage());
}

if ($mail_sent) {
    redirect_with_flash('success', 'Pesan berhasil dikirim.');
} else {
    redirect_with_flash('success_mailfail', 'Pesan tersimpan, namun pengiriman email gagal. Silakan periksa konfigurasi SMTP.');
}

