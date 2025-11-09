<?php
// Konfigurasi email SMTP untuk Gmail
return [
    'smtp_host'     => 'smtp.gmail.com',
    'smtp_port'     => 587,
    'smtp_secure'   => 'tls',
    'smtp_username' => 'poeradiredja12@gmail.com',
    'smtp_password' => 'ayek rguc xcbr zbvt',
    'from_email'    => 'poeradiredja12@gmail.com', 
    'from_name'     => 'SMK Prima Bangsa - Website', 
];

/* 
PANDUAN MENGATUR APP PASSWORD GMAIL:

1. Login ke akun Gmail Anda
2. Buka https://myaccount.google.com/security
3. Aktifkan "2-Step Verification" jika belum
4. Buka https://myaccount.google.com/apppasswords
5. Pilih "App passwords"
6. Di dropdown "Select app", pilih "Other (Custom name)"
7. Masukkan nama "SMK Prima Bangsa Website"
8. Klik "Generate"
9. Copy 16-digit password yang muncul
10. Paste password tersebut ke 'smtp_password' di atas
*/