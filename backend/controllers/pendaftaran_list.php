<?php
require_once __DIR__ . '/../config/db_config.php';
header('Content-Type: application/json; charset=utf-8');
try {
    $mysqli = db_connect();
    $res = $mysqli->query('SELECT * FROM pendaftaran_siswa ORDER BY tanggal_daftar DESC');
    $rows = [];
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    $mysqli->close();
    echo json_encode(['success' => true, 'data' => $rows]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
