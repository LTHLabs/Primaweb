<?php
// Proses verifikasi dan kirim email ke pendaftar
require_once __DIR__ . '/../config/db_config.php';
require_once __DIR__ . '/../config/email_config.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    $_SESSION['contact_flash'] = ['status'=>'error','msg'=>'Silakan login dahulu.'];
    header('Location: login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_pendaftaran'] ?? '';
    $email = $_POST['email'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $status = '';
    $msg = '';
    if ($id && $email) {
        try {
            $mysqli = db_connect();
            $stmt = $mysqli->prepare('UPDATE pendaftaran_siswa SET status_verifikasi = ? WHERE id_pendaftaran = ?');
            $verif = 'Terverifikasi';
            $stmt->bind_param('si', $verif, $id);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();
            $config = require __DIR__ . '/../config/email_config.php';
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $config['smtp_host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['smtp_username'];
            $mail->Password = $config['smtp_password'];
            $mail->SMTPSecure = $config['smtp_secure'];
            $mail->Port = $config['smtp_port'];
            $mail->setFrom($config['from_email'], $config['from_name']);
            $mail->addAddress($email, $nama);
            $mail->isHTML(true);
            $mail->Subject = 'Informasi Verifikasi Pendaftaran MTs An-Nur';
            $mail->Body = '<p>Assalamu’alaikum, ' . htmlspecialchars($nama) . '.<br>Pendaftaran Anda di MTs An-Nur Kota Cirebon telah diverifikasi.<br>Silakan cek informasi selanjutnya di website atau hubungi admin jika ada pertanyaan.<br><br>Terima kasih.<br>MTs An-Nur Kota Cirebon</p>';
            $mail->send();
            $status = 'success';
            $msg = 'Verifikasi berhasil dan email telah dikirim.';
        } catch (Exception $e) {
            $status = 'error';
            $msg = 'Verifikasi berhasil, namun email gagal dikirim: ' . $e->getMessage();
        }
    } else {
        $status = 'error';
        $msg = 'Data pendaftar tidak valid.';
    }
    $_SESSION['contact_flash'] = ['status'=>$status,'msg'=>$msg];
    header('Location: tabelForm.php');
    exit;
}
header('Location: tabelForm.php');
exit;
