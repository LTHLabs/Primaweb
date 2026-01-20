<?php
require_once __DIR__ . '/../config/db_config.php';

class Pendaftaran {
    public static function save(array $data) {
        $conn = db_connect();

       
        $sql = "INSERT INTO pendaftaran_siswa (
            nisn, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin,
            alamat, asal_sekolah, no_hp, email, token, token_expired,
            ekstrakurikuler,
            akte_files, kk_files, ktp_ortu_files, ijazah_files, skhun_files, nisn_files, kip_files,
            proses_seleksi,
            foto_formal, foto_ijazah
        ) VALUES (?, ?, ?, NULLIF(?, ''), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if (! $stmt) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param(
            str_repeat('s', 21),
            $data['nisn'],
            $data['nama_lengkap'],
            $data['tempat_lahir'],
            $data['tanggal_lahir'],
            $data['jenis_kelamin'],
            $data['alamat'],
            $data['asal_sekolah'],
            $data['no_hp'],
            $data['email'],
            $data['token'],
            $data['token_expired'],
            $data['ekstrakurikuler'],
            $data['akte_files'],
            $data['kk_files'],
            $data['ktp_ortu_files'],
            $data['ijazah_files'],
            $data['skhun_files'],
            $data['nisn_files'],
            $data['kip_files'],
            $data['proses_seleksi'],
            $data['foto_formal'],
            $data['foto_ijazah']
        );

        if (! $stmt->execute()) {
            $err = $stmt->error;
            $stmt->close();
            $conn->close();
            throw new Exception('Execute failed: ' . $err);
        }

        $insertId = $stmt->insert_id;
        $stmt->close();
        $conn->close();

        return $insertId;
    }
}
