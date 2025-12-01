<?php
// Konfigurasi Database
$db_host    = '127.0.0.1';
$db_user    = 'root';
$db_pass    = '';
$db_name    = 'Primadb';
$db_port    = 3306;
$db_charset = 'utf8mb4';

/**
 * @return mysqli
 * @throws Exception
 */
function db_connect() {
    global $db_host, $db_user, $db_pass, $db_name, $db_port, $db_charset;

    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

    if ($mysqli->connect_errno) {
        throw new Exception('Gagal koneksi database: ' . $mysqli->connect_error);
    }

    if (! $mysqli->set_charset($db_charset)) {
        throw new Exception('Gagal set charset: ' . $mysqli->error);
    }

    return $mysqli;
}

if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Cek Koneksi Database</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f7f9fc;
            font-family: Arial, sans-serif;
        }
        .container-box {
            max-width: 500px;
            margin-top: 100px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.08);
            text-align: center;
        }
    </style>
    </head>

    <body>
    <div class="container d-flex justify-content-center">
        <div class="container-box">
            <h4 class="mb-3">🔌 Cek Koneksi Database</h4>
            <hr>

            <?php
            try {
                $conn = db_connect();
                echo '
                <div class="alert alert-success" role="alert">
                     <strong>Koneksi Berhasil!</strong> Database berhasil terhubung.
                </div>
                ';
            } catch (Exception $e) {
                echo '
                <div class="alert alert-danger" role="alert">
                    ❌ <strong>Koneksi Gagal!</strong><br>
                    ' . $e->getMessage() . '
                </div>
                ';
            }
            ?>
        </div>
    </div>
    </body>
    </html>
<?php
}


