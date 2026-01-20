<?php
require_once __DIR__ . '/../config/db_config.php';
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="rekap_pendaftar.csv"');
$out = fopen('php://output', 'w');
fputcsv($out, ['NISN','Nama','Email','No HP','Ekstrakurikuler','Tanggal Daftar','Status Verifikasi']);
$mysqli = db_connect();
$res = $mysqli->query('SELECT * FROM pendaftaran_siswa ORDER BY tanggal_daftar DESC');
while ($r = $res->fetch_assoc()) {
    $ekstrakurikuler = '';
    if (!empty($r['ekstrakurikuler'])) {
        $eks = json_decode($r['ekstrakurikuler'], true);
        if (is_array($eks)) $ekstrakurikuler = implode('; ', $eks);
        else $ekstrakurikuler = $r['ekstrakurikuler'];
    }
    fputcsv($out, [
        $r['nisn'],
        $r['nama_lengkap'],
        $r['email'],
        $r['no_hp'],
        $ekstrakurikuler,
        $r['tanggal_daftar'],
        $r['status_verifikasi'] ?? ''
    ]);
}
fclose($out);
$mysqli->close();
exit;
