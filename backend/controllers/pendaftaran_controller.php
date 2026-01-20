<?php
require_once __DIR__ . '/../models/Pendaftaran.php';

class PendaftaranController {
    public static function handleSubmit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: viewform.php');
            exit;
        }
        $nama_lengkap = trim($_POST['nama'] ?? '');
        $nisn = trim($_POST['nisn'] ?? '');
        $tempat_lahir = trim($_POST['tempat_lahir'] ?? '');
        $tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
        $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
        $alamat = trim($_POST['alamat'] ?? '');
        $asal_sekolah = trim($_POST['sekolah_asal'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $no_hp = trim($_POST['telepon'] ?? '');
        $ekstrakurikuler = isset($_POST['ekstrakurikuler']) ? $_POST['ekstrakurikuler'] : [];
        if (!is_array($ekstrakurikuler)) $ekstrakurikuler = [$ekstrakurikuler];

        $errors = [];
        if ($nama_lengkap === '') $errors[] = 'Nama lengkap wajib diisi.';
        if ($nisn === '') $errors[] = 'NISN wajib diisi.';
        if ($tempat_lahir === '') $errors[] = 'Tempat lahir wajib diisi.';
        if ($tanggal_lahir === '') $errors[] = 'Tanggal lahir wajib diisi.';
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Format email tidak valid.';
        if (!empty($no_hp) && !preg_match('/^[0-9+\-\s]{6,20}$/', $no_hp)) $errors[] = 'Format No HP tidak valid.';
        if (!empty($tanggal_lahir)) {
            $d = DateTime::createFromFormat('Y-m-d', $tanggal_lahir);
            if (!($d && $d->format('Y-m-d') === $tanggal_lahir)) {
                $errors[] = 'Format Tanggal Lahir tidak valid. Gunakan YYYY-MM-DD.';
            }
        }

        $hasUploaded = function($field) {
            if (empty($_FILES[$field])) return false;
            $file = $_FILES[$field];
            if (is_array($file['name'])) {
                foreach ($file['error'] as $err) {
                    if ($err === UPLOAD_ERR_OK) return true;
                }
                return false;
            }
            return isset($file['error']) && $file['error'] === UPLOAD_ERR_OK;
        };

        $requiredFileFields = ['akte_files','kk_files','ktp_ortu_files','ijazah_files','skhun_files','nisn_files','foto_formal','foto_ijazah'];
        foreach ($requiredFileFields as $rf) {
            if (!$hasUploaded($rf)) {
                $errors[] = 'Unggah file untuk ' . $rf . ' (minimal 1 file).';
            }
        }

        if (!empty($errors)) {
            header('Location: viewform.php?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        $uploadDir = __DIR__ . '/../uploads/pendaftaran/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // helper untuk upload multiple files (menghasilkan array path)
        $uploadMultiple = function($fieldName, $subdirPrefix) use ($uploadDir) {
            $result = [];
            if (empty($_FILES[$fieldName])) {
                return $result;
            }
            if (is_array($_FILES[$fieldName]['name'])) {
                $count = count($_FILES[$fieldName]['name']);
                for ($i = 0; $i < $count; $i++) {
                    if ($_FILES[$fieldName]['error'][$i] !== UPLOAD_ERR_OK) continue;
                    $orig = $_FILES[$fieldName]['name'][$i];
                    $tmp = $_FILES[$fieldName]['tmp_name'][$i];
                    $ext = pathinfo($orig, PATHINFO_EXTENSION);
                    $filename = uniqid($subdirPrefix . '_') . '.' . $ext;
                    $dest = $uploadDir . $filename;
                    if (move_uploaded_file($tmp, $dest)) {
                        $result[] = 'uploads/pendaftaran/' . $filename;
                    }
                }
            } else {
                if ($_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
                    $orig = $_FILES[$fieldName]['name'];
                    $tmp = $_FILES[$fieldName]['tmp_name'];
                    $ext = pathinfo($orig, PATHINFO_EXTENSION);
                    $filename = uniqid($subdirPrefix . '_') . '.' . $ext;
                    $dest = $uploadDir . $filename;
                    if (move_uploaded_file($tmp, $dest)) {
                        $result[] = 'uploads/pendaftaran/' . $filename;
                    }
                }
            }
            return $result;
        };

        
        $akte_files = $uploadMultiple('akte_files', 'akte');
        $kk_files = $uploadMultiple('kk_files', 'kk');
        $ktp_ortu_files = $uploadMultiple('ktp_ortu_files', 'ktp_ortu');
        $ijazah_files = $uploadMultiple('ijazah_files', 'ijazah');
        $skhun_files = $uploadMultiple('skhun_files', 'skhun');
        $nisn_files = $uploadMultiple('nisn_files', 'nisn');
        $kip_files = $uploadMultiple('kip_files', 'kip');

        $foto_formal_path = null;
        $formal = $uploadMultiple('foto_formal', 'formal');
        if (!empty($formal)) $foto_formal_path = $formal[0];

        $foto_ijazah_path = null;
        $ijazah_photo = $uploadMultiple('foto_ijazah', 'ijazah_photo');
        if (!empty($ijazah_photo)) $foto_ijazah_path = $ijazah_photo[0];

        $token = bin2hex(random_bytes(16));
        $token_expired = (new DateTime('+1 day'))->format('Y-m-d H:i:s');

        $data = [
            'nama_lengkap' => $nama_lengkap,
            'nisn' => $nisn,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'jenis_kelamin' => $jenis_kelamin,
            'alamat' => $alamat,
            'asal_sekolah' => $asal_sekolah,
            'no_hp' => $no_hp,
            'email' => $email,
            'token' => $token,
            'token_expired' => $token_expired,
            'ekstrakurikuler' => json_encode($ekstrakurikuler),
            'akte_files' => json_encode(array_slice($akte_files, 0, 3)),
            'kk_files' => json_encode(array_slice($kk_files, 0, 3)),
            'ktp_ortu_files' => json_encode(array_slice($ktp_ortu_files, 0, 3)),
            'ijazah_files' => json_encode(array_slice($ijazah_files, 0, 3)),
            'skhun_files' => json_encode(array_slice($skhun_files, 0, 3)),
            'nisn_files' => json_encode(array_slice($nisn_files, 0, 3)),
            'kip_files' => json_encode(array_slice($kip_files, 0, 3)),
            'proses_seleksi' => trim($_POST['proses_seleksi'] ?? ''),
            'foto_formal' => $foto_formal_path,
            'foto_ijazah' => $foto_ijazah_path
        ];

        try {
            $id = Pendaftaran::save($data);
            header('Location: viewform.php?success=1&id=' . $id);
            exit;
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $friendly = 'Terjadi kesalahan saat menyimpan pendaftaran.';
            if (stripos($msg, 'Incorrect date value') !== false || stripos($msg, "Data truncated for column 'tanggal_lahir'") !== false) {
                $friendly = 'Tanggal Lahir tidak valid. Gunakan format YYYY-MM-DD atau kosongkan.';
            } elseif (stripos($msg, 'Duplicate entry') !== false) {
                $friendly = 'Data sudah terdaftar (duplikat). Periksa NISN atau email.';
            } elseif (stripos($msg, 'Prepare failed') !== false || stripos($msg, 'Execute failed') !== false) {
                $friendly = 'Gagal menyimpan data. Silakan coba lagi.';
            }
            header('Location: viewform.php?error=' . urlencode($friendly));
            exit;
        }
    }
}
