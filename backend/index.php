<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$contact_flash = $_SESSION['contact_flash'] ?? null;
if (isset($_SESSION['contact_flash'])) {
  unset($_SESSION['contact_flash']);
}
require_once __DIR__ . '/config/db_config.php';
$pendaftar_rows = [];
$db_error = null;
try {
  $mysqli = db_connect();
  $res = $mysqli->query('SELECT * FROM pendaftaran_siswa ORDER BY tanggal_daftar DESC');
  while ($r = $res->fetch_assoc()) {
    $pendaftar_rows[] = $r;
  }
  $mysqli->close();
} catch (Exception $e) {
  $db_error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge"/>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=" />

  <!--====== Title ======-->
  <title>MTs An-Nur Kota Cirebon</title>

  <!--====== Favicon Icon ======-->
  <link rel="shortcut icon" href="../assets/images/logo.jpg" type="image/x-icon" />

  <!--====== Bootstrap css ======-->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <!--====== Line Icons css ======-->
  <link rel="stylesheet" href="assets/css/lineicons.css" />
  <!--====== gLightBox css ======-->
  <link rel="stylesheet" href="assets/css/glightbox.min.css" />
  <!--====== Style css ======-->
  <link rel="stylesheet" href="assets/css/style.css" />

</head>

<body>

  <!--====== NAVBAR AWAL ======-->

  <section class="navbar-area navbar-nine bg-success">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <nav class="navbar navbar-expand-lg bg-success">
            <a class="navbar-brand" href="#hero-area">
              <img src="assets/images/logo.jpg" alt="Logo" />

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNine"
            aria-controls="navbarNine" aria-expanded="false" aria-label="Toggle navigation">
            <span class="toggler-icon"></span>
            <span class="toggler-icon"></span>
            <span class="toggler-icon"></span>
            </button>

            <div id="navbarNine" class="collapse navbar-collapse sub-menu-bar ">
              <ul class="navbar-nav" id="navmenu" style="flex-wrap: wrap;">
                <li class="nav-item ">
                  <a class="page-scroll active" href="#hero-area">Beranda</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="#services">Program Keahlian</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="#about">Tentang Kami</a>
                </li>            
                <li class="nav-item">
                  <a class="page-scroll" href="#facilities">Fasilitas</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="#news">Berita</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="#contact">Kontak</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="#call-action">PMB</a>
                </li>
                <li class="nav-item">
                  <?php if (!empty($_SESSION['admin_logged_in'])): ?>
                    <a class="page-scroll" href="admin/pendaftaran.php">Admin</a>
                  <?php else: ?>
                    <a class="btn btn-outline-warning text-white" href="admin/login.php">Admin</a>
                  <?php endif; ?>
                </li>
              </ul>
            </div>

            <div class="navbar-btn d-none d-lg-inline-block">
              <a class="menu-bar" href="#side-menu-left"><i class="lni lni-menu"></i></a>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </section>

  <!--====== NAVBAR AKHIR ======-->

  <!--====== SIDEBAR AWAL ======-->

  <div class="sidebar-left">
    <div class="sidebar-close">
      <a class="close" href="#close"><i class="lni lni-close"></i></a>
    </div>
      <div class="sidebar-content">
      <div class="sidebar-logo">
        <a href="index.html"><img src="assets/images/logo.jpg" alt="Logo MTs An-Nur Kota Cirebon" /></a>
      </div>
      <p class="text">MTs An-Nur Kota Cirebon — merupakan lembaga pendidikan Islam yang berkomitmen mencetak generasi beriman, berilmu, dan berakhlakul karimah.</p>
      <div class="sidebar-menu">
        <h5 class="menu-title">Tautan Cepat</h5>
        <ul>
          <li><a href="#about">Tentang Kami</a></li>
          <li><a href="#testimonials">Siswa & Alumni</a></li>
          <li><a href="#news">Berita & Kegiatan</a></li>
          <li><a href="#contact">Kontak</a></li>
        </ul>
      </div>
      <div class="sidebar-social align-items-center justify-content-center">
        <h5 class="social-title">Ikuti Kami</h5>
        <ul>
          <li>
            <a href="https://facebook.com/smkprimabangsa" target="_blank"><i class="lni lni-facebook-filled"></i></a>
          </li>
          <li>
            <a href="https://instagram.com/smkprimabangsa" target="_blank"><i class="lni lni-instagram-original"></i></a>
          </li>
          <li>
            <a href="https://youtu.be/-rRAuQzVq4s?si=NHIvEorYlw0Q6pQV" target="_blank"><i class="lni lni-youtube"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="overlay-left"></div>

  <!--====== SIDEBAR AKHIR ======-->

  <!-- Awal header Area -->
  <section id="hero-area" class="header-area header-eight">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-12 col-12">
          <div class="header-content">
            <h1>Selamat Datang di MTs An-Nur Kota Cirebon</h1>
            <p>
              Sekolah Menengah Kejuruan yang membentuk generasi unggul, kreatif, dan siap kerja 
              di bidang teknologi dan industri.
            </p>
            <div class="button">
              <a href="viewform.php" class="btn btn-outline-warning">Daftar Sekarang</a>
              <a href="https://www.youtube.com/watch?v=-rRAuQzVq4s"
                class="glightbox video-button">
                <span class="btn btn-light rounded-full btn-outline-warning">
                  <i class="lni lni-play text-dark"></i>
                </span>
                <span class="text">Profil Sekolah MTs</span>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 col-12">
            <div class="header-image py-1 px-3">
            <img src="assets/images/header/MTs_An-Nur_Kota_Cirebon.jpg" alt="Foto Utama MTs An-Nur Kota Cirebon" />
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Akhir header Area -->

  <!--====== ABOUT/TENTANG AWAL AREA  ======-->

  <section id="about" class="about-area about-five">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 col-12">
          <div class="about-image-five">
            <svg class="shape" width="106" height="134" viewBox="0 0 106 134" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <circle cx="1.66654" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="1.66654" cy="132" r="1.66667" fill="#DADADA" />
              <circle cx="16.3333" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="16.3333" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="16.3333" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="16.3333" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="16.333" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="16.333" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="16.333" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="16.333" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="16.333" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="16.333" cy="132" r="1.66667" fill="#DADADA" />
              <circle cx="30.9998" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="74.6665" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="30.9998" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="74.6665" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="30.9998" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="74.6665" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="30.9998" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="74.6665" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="31" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="74.6668" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="31" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="74.6668" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="31" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="74.6668" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="31" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="74.6668" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="31" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="74.6668" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="31" cy="132" r="1.66667" fill="#DADADA" />
              <circle cx="74.6668" cy="132" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="45.6665" cy="132" r="1.66667" fill="#DADADA" />
              <circle cx="89.3333" cy="132" r="1.66667" fill="#DADADA" />
              <circle cx="60.3333" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="1.66679" r="1.66667" fill="#DADADA" />
              <circle cx="60.3333" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="16.3335" r="1.66667" fill="#DADADA" />
              <circle cx="60.3333" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="31.0001" r="1.66667" fill="#DADADA" />
              <circle cx="60.3333" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="45.6668" r="1.66667" fill="#DADADA" />
              <circle cx="60.333" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="60.3335" r="1.66667" fill="#DADADA" />
              <circle cx="60.333" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="88.6668" r="1.66667" fill="#DADADA" />
              <circle cx="60.333" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="117.667" r="1.66667" fill="#DADADA" />
              <circle cx="60.333" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="74.6668" r="1.66667" fill="#DADADA" />
              <circle cx="60.333" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="103" r="1.66667" fill="#DADADA" />
              <circle cx="60.333" cy="132" r="1.66667" fill="#DADADA" />
              <circle cx="104" cy="132" r="1.66667" fill="#DADADA" />
            </svg>
            <img src="assets/images/about/MTs_An-Nur_Kota_Cirebon-about.jpg" alt="Tentang Kami" />
          </div>
        </div>
        <div class="col-lg-6 col-12">
          <div class="about-five-content">
            <h6 class="small-title text-lg">TENTANG KAMI</h6>
            <h2 class="main-title fw-bold">MTs An-Nur Kota Cirebon — Visi, Misi, dan Komitmen Pendidikan</h2>
            <div class="about-five-tab">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <button class="nav-link active btn btn-warning bg-success text-white" id="nav-who-tab" data-bs-toggle="tab" data-bs-target="#nav-who"
                    type="button" role="tab" aria-controls="nav-who" aria-selected="true">Siapa Kami</button>
                  <button class="nav-link btn btn-warning bg-success text-white" id="nav-vision-tab" data-bs-toggle="tab" data-bs-target="#nav-vision"
                    type="button" role="tab" aria-controls="nav-vision" aria-selected="false">Visi Kami</button>
                  <button class="nav-link btn btn-warning bg-success text-white" id="nav-history-tab" data-bs-toggle="tab" data-bs-target="#nav-history"
                    type="button" role="tab" aria-controls="nav-history" aria-selected="false">Sejarah Singkat</button>
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-who" role="tabpanel" aria-labelledby="nav-who-tab">
                  <p>Madrasah Tsanawiyah (MTs) An-Nur Cirebon merupakan lembaga pendidikan Islam yang berkomitmen mencetak generasi beriman, berilmu, dan berakhlakul karimah.
                    Kami didukung oleh tenaga pengajar berpengalaman, fasilitas modern, serta kurikulum yang adaptif</p>
                </div>
                <div class="tab-pane fade" id="nav-vision" role="tabpanel" aria-labelledby="nav-vision-tab">
                 <p>Visi MTs An-Nur Sebagai wahana pembinaan manusia yang bertaqwa dan beriman, berbias pada keshalehan sosial.</p>
 <p>Misi kami meliputi: Mendorong terciptanya suasana madrasah yang Islami, memotivasi terciptanya iklim kompetisi yang sehat, membangun terciptanya suasana keterbukaan yang profesional dalam suasana kekeluargaan, membentuk siswa terampil, kehandalan bersaing dan berdayaguna yang Berakhlaq Karimah, dan MTs An-Nur sebagai madrasah yang menjadi milik dan dambaan masyarakat.</p>
                </div>
                <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab">
                 <p>MTs An-Nur ini berada di bawah naungan Yayasan Pendidikan dan Dakwah Islam Jagasatru (YPDIJ) didirikan pada tanggal 06 Agustus 1983 oleh 33 orang pemarkasa, yang terdiri dari tokoh masyarakat dan aparat pemerintah, dan didukung oleh masyarakat setempat. Pada Awalnya yakni tahun pelajaran 1993/1994 siswa MTs An-Nur hanya terdiri 1 kelas dan berjumlah 49 siswa. kemudian dari tahun ketahun terus bertambah hingga 6 kelas sampai sekarang.</p>
 <p>MTs Annur Cirebon terus berupaya mengikuti perkembangan zaman dengan mengintegrasikan teknologi dalam proses pembelajaran tanpa meninggalkan nilai-nilai Islam yang menjadi landasan utama pendidikan.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--====== ABOUT AKHIR ======-->

  <!-- Awal Ekstrakurikuler -->

  <section id="services" class="services-area services-eight">
    <div class="section-title-five">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="content">
              <h6 class="text-lg btn-success text-white">Ekstrakurikuler di MTs An-Nur</h6>

              <p>
                MTs An-Nur menyediakan beragam kegiatan ekstrakurikuler yang bersifat edukatif, kreatif, dan religius, seperti bidang keagamaan, olahraga, seni, dan keterampilan. Setiap kegiatan dibimbing oleh pembina yang kompeten sehingga mampu menjadi wadah pembentukan karakter, pengembangan prestasi, serta penyaluran bakat peserta didik secara positif
              </p>
              
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="single-services">
            <div class="service-icon">
              <i class="lni lni-basketball"></i>
            </div>
            <div class="service-content">
              <h4>Futsal</h4>
              <p>
                Ekstrakurikuler olahraga yang bertujuan meningkatkan kebugaran jasmani, sportivitas, kerja sama tim, serta prestasi peserta didik di bidang olahraga
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="single-services">
            <div class="service-icon">
              <i class="lni lni-flag"></i>
            </div>
            <div class="service-content">
              <h4>Pramuka</h4>
              <p>
                Kegiatan yang bertujuan membentuk karakter disiplin, mandiri, bertanggung jawab, serta menanamkan jiwa kepemimpinan dan kebersamaan pada peserta didik.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="single-services">
            <div class="service-icon">
              <i class="lni lni-world"></i>
            </div>
            <div class="service-content">
              <h4>Club Bahasa Inggris</h4>
              <p>
                Kegiatan yang berfokus pada pengembangan kemampuan berbahasa Inggris, baik lisan maupun tulisan, melalui pembelajaran interaktif, diskusi, dan praktik komunikasi sehari-hari.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="single-services">
            <div class="service-icon">
              <i class="lni lni-book"></i>
            </div>
            <div class="service-content">
              <h4>Baca Tulis Al-Qur`an</h4>
              <p>
                Ekstrakurikuler yang difokuskan pada peningkatan kemampuan membaca dan menulis Al-Qur’an sesuai kaidah tajwid serta pembinaan akhlak Islami.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="single-services">
            <div class="service-icon">
              <i class="lni lni-microscope"></i>
            </div>
            <div class="service-content">
              <h4>Club IPA</h4>
              <p>
                Wadah bagi peserta didik yang memiliki minat dalam bidang sains untuk mengembangkan kemampuan berpikir kritis, eksperimen, dan persiapan mengikuti kompetisi akademik.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="single-services">
            <div class="service-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 2C9.79 2 8 3.79 8 6c0 2.21 4 5 4 5s4-2.79 4-5c0-2.21-1.79-4-4-4zm-7 8c-1.1 0-2 .9-2 2v5h18v-5c0-1.1-.9-2-2-2H5zM7 18v2h10v-2H7z"/>
              </svg>
            </div>
            <div class="service-content">
              <h4>Hadroh</h4>
              <p>
                Kegiatan seni islami yang mengembangkan bakat peserta didik dalam bidang musik religi, sekaligus menumbuhkan kecintaan terhadap shalawat dan budaya Islam.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Akhir Ekstrakurikuler -->


  <!-- Awal Fasilitas Area -->
  <section id="facilities" class="pricing-area pricing-fourteen">
    <div class="section-title-five">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="content">
              <h6>Fasilitas</h6>
              <h2 class="fw-bold">Fasilitas Madrasah</h2>
              <p>
                MTs An-Nur dilengkapi dengan berbagai fasilitas modern untuk mendukung proses belajar mengajar yang optimal dan kenyamanan siswa, antara lain:
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 col-12">
          <div class="pricing-style-fourteen">
            <div class="table-head">
              <h6 class="title">Laboratorium</h4>
                <p>Fasilitas praktikum lengkap dengan peralatan modern</p>
                <div class="facility-icon">
                  <i class="lni lni-computer-alt"></i>
                </div>
            </div>

            <div class="table-content">
              <ul class="table-list">
                <li> <i class="lni lni-checkmark-circle"></i> Lab Komputer (40 Unit/Lab)</li>
                <li> <i class="lni lni-checkmark-circle"></i> Lab Jaringan</li>
                <li> <i class="lni lni-checkmark-circle"></i> Lab Multimedia</li>
                <li> <i class="lni lni-checkmark-circle"></i> Studio DKV</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
          <div class="pricing-style-fourteen middle">
            <div class="table-head">
              <h6 class="title">Perpustakaan Digital</h4>
                <p>Pusat sumber belajar modern dengan koleksi digital dan fisik</p>
                <div class="facility-icon">
                  <i class="lni lni-library"></i>
                </div>
            </div>

            <div class="table-content">
              <ul class="table-list">
                <li> <i class="lni lni-checkmark-circle"></i> E-Library</li>
                <li> <i class="lni lni-checkmark-circle"></i> Ruang Baca Nyaman</li>
                <li> <i class="lni lni-checkmark-circle"></i> Koneksi Internet Cepat</li>
                <li> <i class="lni lni-checkmark-circle"></i> Area Diskusi</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
          <div class="pricing-style-fourteen">
            <div class="table-head">
              <h6 class="title">Ruang Multimedia</h4>
                <p>Ruang dengan perangkat editing dan produksi konten digital untuk siswa DKV dan multimedia.</p>
            </div>

            <div class="light-rounded-buttons">
              <!-- <a href="#facilities" class="btn primary-btn-outline">
                Lihat Fasilitas
              </a> -->
            </div>

            <div class="table-content">
              <ul class="table-list">
                <li> <i class="lni lni-checkmark-circle"></i> Studio Editing & Grafis</li>
                <li> <i class="lni lni-checkmark-circle"></i> Perangkat Kamera & Audio</li>
                <li> <i class="lni lni-checkmark-circle"></i> Software Profesional</li>
                <li> <i class="lni lni-checkmark-circle"></i> Area Presentasi</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Akhir Fasilitas Area -->


  <!-- Awal Cta Area -->
  <section id="call-action" class="call-action">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-9">
          <div class="inner-content text-center">
            <h2>MTs AN-NUR Siap Mendampingi Sukses Karir Anda</h2>
            <p>
              Bergabunglah bersama kami untuk mendapatkan pendidikan vokasi berkualitas, praktik industri,
              dan pembinaan karir yang terarah untuk masa depan siswa.
            </p>
            <div class="light-rounded-buttons">
              <a href="viewform.php" class="btn primary-btn-outline">Daftar Sekarang</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Akhir Cta Area -->

  <!-- Awal Indikator Jumlah Pendaftar -->
  <?php
  $total_pendaftar = is_array($pendaftar_rows) ? count($pendaftar_rows) : 0;
  $program_counts = [];
  if (!empty($pendaftar_rows) && is_array($pendaftar_rows)) {
    $program_counts = array_count_values(array_map(function($r){ return $r['program_keahlian'] ?? ''; }, $pendaftar_rows));
  }
  $rpl_count = $program_counts['Rekayasa Perangkat Lunak (RPL)'] ?? 0;
  $tkj_count = $program_counts['Teknik Komputer Jaringan (TKJ)'] ?? 0;
  $dkv_count = $program_counts['Desain Komunikasi Visual (DKV)'] ?? 0;
  $p_rpl = $total_pendaftar ? round($rpl_count * 100 / $total_pendaftar) : 0;
  $p_tkj = $total_pendaftar ? round($tkj_count * 100 / $total_pendaftar) : 0;
  $p_dkv = $total_pendaftar ? round($dkv_count * 100 / $total_pendaftar) : 0;
  $last_update = '';
  if ($total_pendaftar > 0) {
    $dates = array_filter(array_column($pendaftar_rows, 'tanggal_daftar'));
    if (!empty($dates)) {
      $last_update = date('d M Y, H:i', strtotime(max($dates)));
    }
  }
  ?>
  <section id="indikator-pendaftar" class="statistics-area py-5">
    <div class="container">
      <div class="row g-4 align-items-center">
        <div class="col-lg-4">
          <div class="card shadow-sm h-100">
            <div class="card-body text-center">
              <div class="mb-3">
                <i class="lni lni-users" style="font-size:36px;color:#198754;"></i>
              </div>
              <h5 class="card-title">Total Pendaftar</h5>
              <h2 class="fw-bold display-5 text-success"><?= $total_pendaftar; ?></h2>
              <?php if ($last_update): ?>
                <p class="text-muted mb-0">Terakhir diperbarui: <?= htmlspecialchars($last_update); ?></p>
              <?php else: ?>
                <p class="text-muted mb-0">Belum ada pendaftar</p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="col-lg-8">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <h5 class="card-title mb-3">Distribusi Program Keahlian</h5>

              <div class="mb-3">
                <div class="d-flex justify-content-between">
                  <div><strong>Rekayasa Perangkat Lunak (RPL)</strong></div>
                  <div class="text-muted"><?= $rpl_count; ?> siswa <small class="text-muted"> (<?= $p_rpl; ?>%)</small></div>
                </div>
                <div class="progress" style="height:10px;">
                  <div class="progress-bar bg-success" role="progressbar" style="width: <?= $p_rpl; ?>%;" aria-valuenow="<?= $p_rpl; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="mb-3">
                <div class="d-flex justify-content-between">
                  <div><strong>Teknik Komputer Jaringan (TKJ)</strong></div>
                  <div class="text-muted"><?= $tkj_count; ?> siswa <small class="text-muted"> (<?= $p_tkj; ?>%)</small></div>
                </div>
                <div class="progress" style="height:10px;">
                  <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $p_tkj; ?>%;" aria-valuenow="<?= $p_tkj; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="mb-2">
                <div class="d-flex justify-content-between">
                  <div><strong>Desain Komunikasi Visual (DKV)</strong></div>
                  <div class="text-muted"><?= $dkv_count; ?> siswa <small class="text-muted"> (<?= $p_dkv; ?>%)</small></div>
                </div>
                <div class="progress" style="height:10px;">
                  <div class="progress-bar bg-info" role="progressbar" style="width: <?= $p_dkv; ?>%;" aria-valuenow="<?= $p_dkv; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>

              <div class="mt-4 text-end">
                <a href="#daftar-pendaftar" class="btn btn-outline-success">Lihat Rincian</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Akhir Indikator Jumlah Pendaftar -->


  <!-- Start Berita & Kegiatan -->
  <div id="news" class="latest-news-area section">
    <div class="section-title-five">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="content">
              <h6>Berita & Kegiatan</h6>
              <h2 class="fw-bold">Berita Terbaru SMK Prima Bangsa</h2>
              <p>
                Ikuti perkembangan kegiatan, prestasi, dan pengumuman penting dari SMK Prima Bangsa.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 col-12">
          <div class="single-news">
            <div class="image">
              <a href="javascript:void(0)"><img class="thumb" src="assets/images/blog/images-not-found.png" alt="Kegiatan Praktik" /></a>
              <div class="meta-details">
                <img class="thumb" src="assets/images/blog/images-not-found.png" alt="Humas" />
                <span>Oleh Humas Mts</span>
              </div>
            </div>
            <div class="content-body">
              <h4 class="title">
                <a href="javascript:void(0)">Pelatihan Pemrograman untuk Siswa RPL</a>
              </h4>
              <p>
                Siswa Rekayasa Perangkat Lunak mengikuti pelatihan intensif pengembangan aplikasi
                guna meningkatkan kompetensi praktis menjelang ujian kompetensi.
              </p>
            </div>
          </div>

        </div>
        <div class="col-lg-4 col-md-6 col-12">
          <div class="single-news">
            <div class="image">
              <a href="javascript:void(0)"><img class="thumb" src="assets/images/blog/images-not-found.png" alt="Kegiatan TKJ" /></a>
              <div class="meta-details">
                <img class="thumb" src="assets/images/blog/images-not-found.png" alt="Humas" />
                <span>Oleh Humas Mts</span>
              </div>
            </div>
            <div class="content-body">
              <h4 class="title">
                <a href="javascript:void(0)">Workshop Infrastruktur Jaringan untuk Siswa TKJ</a>
              </h4>
              <p>
                Kegiatan workshop oleh mitra industri untuk meningkatkan kemampuan instalasi dan
                konfigurasi jaringan siswa Teknik Komputer dan Jaringan.
              </p>
            </div>
          </div>

        </div>
        <div class="col-lg-4 col-md-6 col-12">
          <div class="single-news">
            <div class="image">
              <a href="javascript:void(0)"><img class="thumb" src="assets/images/blog/images-not-found.png" alt="Kegiatan DKV" /></a>
              <div class="meta-details">
                <img class="thumb" src="assets/images/blog/images-not-found.png" alt="Humas" />
                <span>Oleh Humas Mts</span>
              </div>
            </div>
            <div class="content-body">
              <h4 class="title">
                <a href="javascript:void(0)">Pameran Karya Siswa DKV: Kreativitas Digital</a>
              </h4>
              <p>
                Siswa Desain Komunikasi Visual memamerkan portofolio terbaik hasil kolaborasi antar siswa
                dan instruktur dalam proyek multimedia.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Akhir Berita & Kegiatan Area -->

    <!-- Awal Daftar Pendaftar -->
  <section id="daftar-pendaftar" class="section">
    <div class="container">
      <div class="section-title-five">
        <div class="row">
          <div class="col-12">
            <div class="content">
              <h6>Daftar Pendaftar</h6>
              <h2 class="fw-bold">Siswa yang Telah Mendaftar</h2>
              <p>Di bawah ini daftar pendaftar yang masuk melalui formulir pendaftaran.</p>
            </div>
          </div>
        </div>
      </div>
      <!-- Pendaftaran Form -->
      <!-- <div id="pendaftaran-form" class="row mb-4">
        <div class="col-12">
          <div class="card p-3">
            <h5>Form Pendaftaran Siswa Baru</h5>
            <form action="controllers/pendaftaran_create.php" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-4 mb-2"><input class="form-control" name="nisn" placeholder="NISN" required></div>
                <div class="col-md-8 mb-2"><input class="form-control" name="nama_lengkap" placeholder="Nama Lengkap" required></div>
              </div>
              <div class="row">
                <div class="col-md-4 mb-2"><input class="form-control" name="tempat_lahir" placeholder="Tempat Lahir"></div>
                <div class="col-md-4 mb-2"><input type="date" class="form-control" name="tanggal_lahir" placeholder="Tanggal Lahir"></div>
                <div class="col-md-4 mb-2">
                  <select class="form-control" name="jenis_kelamin">
                    <option value="">- Jenis Kelamin -</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-12 mb-2"><textarea class="form-control" name="alamat" placeholder="Alamat"></textarea></div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-2"><input class="form-control" name="asal_sekolah" placeholder="Asal Sekolah"></div>
                <div class="col-md-6 mb-2"><input class="form-control" name="no_hp" placeholder="No. HP" required></div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-2"><input type="email" class="form-control" name="email" placeholder="Email" required></div>
                <div class="col-md-6 mb-2">
                  <select class="form-control" name="program_keahlian">
                    <option value="">- Pilih Program Keahlian -</option>
                    <option value="Rekayasa Perangkat Lunak (RPL)">Rekayasa Perangkat Lunak (RPL)</option>
                    <option value="Teknik Komputer Jaringan (TKJ)">Teknik Komputer Jaringan (TKJ)</option>
                    <option value="Desain Komunikasi Visual (DKV)">Desain Komunikasi Visual (DKV)</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-2">
                  <label class="form-label">Foto Formal (jpg/png, max 2MB)</label>
                  <input type="file" class="form-control" name="foto_formal" accept="image/*" required>
                </div>
                <div class="col-md-6 mb-2">
                  <label class="form-label">Foto Ijazah (jpg/png, max 2MB)</label>
                  <input type="file" class="form-control" name="foto_ijazah" accept="image/*" required>
                </div>
              </div>
              <div class="row">
                <div class="col-12 text-end mt-2">
                  <button class="btn primary-btn" type="submit">Daftar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div> -->
      <div class="row">
        <div class="col-12">
          <div class="table-responsive">
            <?php if (!empty($db_error)) : ?>
              <div class="alert alert-danger">Gagal mengambil data dari database: <?= htmlspecialchars($db_error); ?></div>
            <?php elseif (empty($pendaftar_rows)) : ?>
              <div class="alert alert-info">Belum ada data pendaftar.</div>
            <?php else : ?>
              <table class="table table-striped table-bordered">
                <thead class="table-dark">
                  <tr>
                    <th>NO</th>
                    <th>NISN</th>
                    <th>Nama Lengkap</th>
                    <th>TTL</th>
                    <th>JK</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; foreach ($pendaftar_rows as $row) : ?>
                    <tr>
                      <td><?= $i++; ?></td>
                      <td><?= htmlspecialchars($row['nisn'] ?? ''); ?></td>
                      <td><?= htmlspecialchars($row['nama_lengkap'] ?? ''); ?></td>
                      <td>
                        <?= htmlspecialchars(($row['tempat_lahir'] ?? '') . ' / ' . ($row['tanggal_lahir'] ?? '')); ?>
                      </td>
                      <td><?= htmlspecialchars($row['jenis_kelamin'] ?? ''); ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Akhir Daftar Pendaftar -->

  <!-- Awal Client Area -->
  <div id="clients" class="brand-area section">
    <div class="section-title-five">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="content">
              <h6>Mitra Industri</h6>
              <h2 class="fw-bold">Kerjasama & Mitra</h2>
              <p>
                SMK Prima Bangsa bekerja sama dengan berbagai perusahaan dan lembaga untuk
                mendukung pembelajaran vokasi dan penempatan kerja lulusan.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
<div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2 col-12">
          <div class="clients-logos">
            <div class="single-image">
              <img src="assets/images/client-logo/jagantaragroup.svg" alt="Brand Logo Images" />
            </div>
            <div class="single-image">
              <img src="assets/images/client-logo/kelasIoT.svg" alt="Brand Logo Images" />
            </div>
            <div class="single-image">
              <img src="assets/images/client-logo/mandatera-tech.svg" alt="Brand Logo Images" />
            </div>
            <div class="single-image">
              <img src="assets/images/client-logo/Nusabot.svg" alt="Brand Logo Images" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Akhir Client Area -->
   
  <!-- Awal Testimonial Area -->
  <section id="testimonials" class="testimonial-area section">
    <div class="section-title-five">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="content">
              <h6>Testimonial</h6>
              <h2 class="fw-bold">Testimoni Siswa & Alumni</h2>
              <p>
                Dengarkan langsung pengalaman dari siswa dan alumni SMK Prima Bangsa
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 col-12">
          <div class="single-testimonial">
            <div class="image" style="width: 100px; height: 100px; overflow: hidden; border-radius: 50%;">
              <img src="assets/images/testimonial/rakabuming.jpeg" alt="Siswa" style="width: 100%; height: auto;">
            </div>
            <div class="content">
              <p>"SMK Prima Bangsa memberikan fondasi yang kuat untuk karir saya di bidang IT. 
                 Pembelajaran praktis dan fasilitas lengkap sangat membantu pengembangan skill."</p>
              <h4>Rakabuming</h4>
              <span>Alumni RPL 2024 - Software Engineer di Tech Corp</span>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 col-12">
          <div class="single-testimonial">
            <div class="image"style="width: 100px; height: 100px; overflow: hidden; border-radius: 50%;">
              <img src="assets/images/testimonial/bahlil.jpg" alt="Siswa" style="width: 100%; height: auto;">
            </div>
            <div class="content">
              <p>"Program TKJ di sini sangat komprehensif. Saya mendapatkan sertifikasi industri 
                 dan langsung diterima kerja setelah lulus."</p>
              <h4>Lahlil Ethanol</h4>
              <span>Alumni TKJ 2024 - Network Engineer</span>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 col-12">
          <div class="single-testimonial">
            <div class="image" style="width: 100px; height: 100px; overflow: hidden; border-radius: 50%;">
              <img src="assets/images/testimonial/mulyono.jpeg" alt="Siswa" style="width: 100%; height: auto;">
            </div>
            <div class="content">
              <p>"Fasilitas studio DKV yang lengkap dan guru-guru profesional membantu saya 
                 mengembangkan portofolio yang berkualitas."</p>
              <h4>Mulyono</h4>
              <span>Siswa DKV Kelas XII</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Akhir Testimonial Area -->

  <!-- ========================= contact-section Awal ========================= -->
  <section id="contact" class="contact-section">
    <div class="container">
      <div class="row">
        <div class="col-xl-4">
          <div class="contact-item-wrapper">
            <div class="row">
              <div class="col-12 col-md-6 col-xl-12">
                <div class="contact-item">
                  <div class="contact-icon">
                    <i class="lni lni-phone"></i>
                  </div>
                  <div class="contact-content">
                    <h4>Kontak</h4>
                    <p>Telp: (021) 1234-5678</p>
                    <p>Email: info@mtsan-nurcirebon.sch.id</p>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-xl-12">
                <div class="contact-item">
                  <div class="contact-icon">
                    <i class="lni lni-map-marker"></i>
                  </div>
                  <div class="contact-content">
                    <h4>Alamat</h4>
                    <p>Jl.Brigjend Dharsono Bypass No.20,</p>
                    <p>Kabupaten Cirebon</p>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-xl-12">
                <div class="contact-item">
                  <div class="contact-icon">
                    <i class="lni lni-alarm-clock"></i>
                  </div>
                  <div class="contact-content">
                    <h4>Jam Pelayanan</h4>
                    <p>Senin - Jumat: 07.30 - 15.30</p>
                    <p>Sabtu: 08.00 - 12.00</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-8">
          <div class="contact-form-wrapper">
            <div class="row">
              <div class="col-xl-10 col-lg-8 mx-auto">
                <div class="section-title text-center">
                  <span> Hubungi Kami </span>
                  <h2>
                    Siap untuk Bergabung atau Bertanya?
                  </h2>
                  <p>
                    Silakan kirim pesan atau pertanyaan melalui formulir berikut. Kami akan merespons secepatnya.
                  </p>
                </div>
              </div>
            </div>
      <?php
      if (!empty($contact_flash)) {
        $c = $contact_flash['status'] ?? '';
        $msg = isset($contact_flash['msg']) ? htmlspecialchars($contact_flash['msg']) : '';
        if ($c === 'success') {
          echo '<div class="alert alert-success" role="alert">' . ($msg ?: 'Pesan berhasil dikirim. Terima kasih.') . '</div>';
        } elseif ($c === 'success_mailfail') {
          echo '<div class="alert alert-warning" role="alert">' . ($msg ?: 'Pesan tersimpan, namun pengiriman email gagal. Silakan konfigurasi SMTP atau periksa pengaturan server email.') . '</div>';
        } else {
          echo '<div class="alert alert-danger" role="alert">❌ Terjadi kesalahan: ' . $msg . '</div>';
        }
      }
      ?>

      <form action="controllers/contact.php" method="post" class="contact-form">
              <div class="row">
                <div class="col-md-6">
                  <input type="text" name="name" id="name" placeholder="Nama"  />
                </div>
                <div class="col-md-6">
                  <input type="email" name="email" id="email" placeholder="Email"  />
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <input type="text" name="phone" id="phone" placeholder="Telepon"  />
                </div>
                <div class="col-md-6">
                  <input type="text" name="subject" id="subject" placeholder="Perihal"  />
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <textarea name="message" id="message" placeholder="Pesan" rows="5"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="button text-center rounded-buttons">
                    <button type="submit" class="btn primary-btn rounded-full">
                      Kirim Pesan
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ========================= contact-section Akhir ========================= -->

  <!-- ========================= map-section ========================= -->
  <section class="map-section map-style-9">
      <div class="map-container">
      <object title="Peta SMK Prima Bangsa - Cirebon" style="border:0; height: 500px; width: 100%;"
        data="https://www.google.com/maps?q=Cirebon%2C%20Indonesia&output=embed"></object>
    </div>
    </div>
  </section>
  <!-- ========================= map-section ========================= -->

  <!--====== FOOTER AREA AWAL ======-->
  <footer class="footer-area footer-eleven">
    <div class="footer-top">
      <div class="container">
        <div class="inner-content">
          <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
              <div class="footer-widget f-about">
                <div class="logo">
                  <a href="index.html">
                    <img src="assets/images/logo.jpg" alt="#" class="img-fluid" />
                  </a>
                </div>
                <p>
                  Membentuk generasi unggul yang berkarakter, kompeten, dan siap menghadapi
                  tantangan global.
                </p>
                <p class="copyright-text">
                  <span>© 2026 MTs An-Nur Kota Cirebon</span>
                  <br>Cideng, Jl. Brigjend Dharsono Bypass No.20, Kertawinangun, Kec. Kedawung, Kabupaten Cirebon<br>
                  Telp: (021) 1234-5678<br>
                  Email: info@mtsan-nurcirebon.sch.id
                </p>
              </div>
            </div>
            <div class="col-lg-2 col-md-6 col-12">
              <div class="footer-widget f-link">
                <h5>Program Kami</h5>
                <ul>
                  <li><a href="#services">Rekayasa Perangkat Lunak</a></li>
                  <li><a href="#services">Teknik Komputer dan Jaringan</a></li>
                  <li><a href="#services">Desain Komunikasi Visual</a></li>
                  <li><a href="#facilities">Fasilitas</a></li>
                </ul>
              </div>
            </div>
            <div class="col-lg-2 col-md-6 col-12">
              <div class="footer-widget f-link">
                <h5>Tautan Penting</h5>
                <ul>
                  <li><a href="https://pmb.ipbcirebon.ac.id/#informasi-pmb">Info PMB</a></li>
                  <li><a href="#about">Tentang Kami</a></li>
                  <li><a href="#news">Berita</a></li>
                  <li><a href="#contact">Hubungi Kami</a></li>
                </ul>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
              <div class="footer-widget social-links">
                <h5>Media Sosial</h5>
                <p>Ikuti kami di media sosial untuk informasi terbaru</p>
                <div class="social-icons text-dark py-3">
                  <a href="https://facebook.com/smkprimabangsa" target="_blank" class="text-dark lni lni-facebook-filled"> Facebook</a> |
                  <a href="https://instagram.com/smkprimabangsa" target="_blank" class="text-dark lni lni-instagram-original"> Instagram</a> |
                  <a href="https://youtube.com/smkprimabangsa" target="_blank" class="text-dark lni lni-youtube"> YouTube</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!--====== FOOTER AREA AKHIR ======-->
	

  <a href="#" class="scroll-top btn-hover">
    <i class="lni lni-chevron-up"></i>
  </a>

  <!--====== js ======-->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/glightbox.min.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/tiny-slider.js"></script>

  <script>
    let navbarTogglerNine = document.querySelector(
      ".navbar-nine .navbar-toggler"
    );
    navbarTogglerNine.addEventListener("click", function () {
      navbarTogglerNine.classList.toggle("active");
    });

    // ==== left sidebar toggle
    let sidebarLeft = document.querySelector(".sidebar-left");
    let overlayLeft = document.querySelector(".overlay-left");
    let sidebarClose = document.querySelector(".sidebar-close .close");

    overlayLeft.addEventListener("click", function () {
      sidebarLeft.classList.toggle("open");
      overlayLeft.classList.toggle("open");
    });
    sidebarClose.addEventListener("click", function () {
      sidebarLeft.classList.remove("open");
      overlayLeft.classList.remove("open");
    });

    // ===== navbar sideMenu
    let sideMenuLeftNine = document.querySelector(".navbar-nine .menu-bar");

    sideMenuLeftNine.addEventListener("click", function () {
      sidebarLeft.classList.add("open");
      overlayLeft.classList.add("open");
    });

    //========= glightbox
    GLightbox({
      'href': 'https://www.youtube.com/watch?v=-rRAuQzVq4s',
      'type': 'video',
      'source': 'youtube', 
      'width': 900,
      'autoplayVideos': true,
    });

  </script>
</body>

</html>
