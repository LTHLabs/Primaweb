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
            <a href=" " target="_blank"><i class="lni lni-facebook-filled"></i></a>
          </li>
          <li>
            <a href=" " target="_blank"><i class="lni lni-instagram-original"></i></a>
          </li>
          <li>
            <a href=" " target="_blank"><i class="lni lni-youtube"></i></a>
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
              <a href="https://www.youtube.com/watch?v=LzdsUZcw8L4"
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
              <i class="lni lni-calculator"></i>
            </div>
            <div class="service-content">
              <h4>Matematika Club</h4>
              <p>
                Ekstrakurikuler yang mendorong siswa untuk mengasah logika, kemampuan berhitung, dan berkompetisi dalam olimpiade matematika.
              </p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="single-services">
            <div class="service-icon">
              <i class="lni lni-display"></i>
            </div>
            <div class="service-content">
              <h4>Pengembangan Diri Komputer & Internet</h4>
              <p>
                Kegiatan yang membekali siswa keterampilan komputer, internet, dan teknologi digital untuk mendukung pembelajaran dan kreativitas.
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
                MTs An-Nur menyediakan fasilitas utama yang mendukung kegiatan belajar, organisasi, dan literasi siswa secara optimal.
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
              <h6 class="title">Ruang OSIS</h6>
              <p>Ruang khusus untuk pengurus OSIS sebagai pusat kegiatan organisasi siswa, rapat, dan pengembangan kepemimpinan.</p>
              <div class="facility-icon">
                <i class="lni lni-users"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
          <div class="pricing-style-fourteen">
            <div class="table-head">
              <h6 class="title">Ruang Lab Komputer</h6>
              <p>Laboratorium komputer dengan perangkat memadai untuk pembelajaran teknologi informasi, praktik komputer, dan pelatihan digital.</p>
              <div class="facility-icon">
                <i class="lni lni-computer"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
          <div class="pricing-style-fourteen">
            <div class="table-head">
              <h6 class="title">Ruang Perpustakaan</h6>
              <p>Perpustakaan dengan koleksi buku pelajaran, literatur Islami, dan ruang baca nyaman untuk mendukung budaya literasi siswa.</p>
              <div class="facility-icon">
                <i class="lni lni-library"></i>
              </div>
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


  <!-- Start Berita & Kegiatan -->
  <div id="news" class="latest-news-area section">
    <div class="section-title-five">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="content">
              <h6>Berita & Kegiatan</h6>
              <h2 class="fw-bold">Berita & Kegiatan MTs An-Nur</h2>
              <p>
                Ikuti perkembangan kegiatan Islami, prestasi, dan pengumuman penting dari MTs An-Nur Kota Cirebon.
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
              <a href="javascript:void(0)"><img class="thumb" src="assets/images/blog/images-not-found.png" alt="Kegiatan Keagamaan" /></a>
              <div class="meta-details">
                <img class="thumb" src="assets/images/blog/images-not-found.png" alt="Humas" />
                <span>Oleh Humas MTs</span>
              </div>
            </div>
            <div class="content-body">
              <h4 class="title">
                <a href="javascript:void(0)">Pesantren Kilat Ramadhan</a>
              </h4>
              <p>
                Kegiatan pesantren kilat untuk memperdalam ilmu agama, pembinaan akhlak, dan pembiasaan ibadah selama bulan Ramadhan.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
          <div class="single-news">
            <div class="image">
              <a href="javascript:void(0)"><img class="thumb" src="assets/images/blog/images-not-found.png" alt="Lomba Islami" /></a>
              <div class="meta-details">
                <img class="thumb" src="assets/images/blog/images-not-found.png" alt="Humas" />
                <span>Oleh Humas MTs</span>
              </div>
            </div>
            <div class="content-body">
              <h4 class="title">
                <a href="javascript:void(0)">Lomba Musabaqah Tilawatil Qur'an</a>
              </h4>
              <p>
                Siswa MTs An-Nur meraih prestasi dalam lomba MTQ tingkat kota, membanggakan madrasah dan keluarga besar.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
          <div class="single-news">
            <div class="image">
              <a href="javascript:void(0)"><img class="thumb" src="assets/images/blog/images-not-found.png" alt="Kegiatan Sosial" /></a>
              <div class="meta-details">
                <img class="thumb" src="assets/images/blog/images-not-found.png" alt="Humas" />
                <span>Oleh Humas MTs</span>
              </div>
            </div>
            <div class="content-body">
              <h4 class="title">
                <a href="javascript:void(0)">Bakti Sosial & Santunan Anak Yatim</a>
              </h4>
              <p>
                Kegiatan bakti sosial dan santunan anak yatim sebagai wujud kepedulian sosial dan penanaman nilai-nilai kemanusiaan.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Akhir Berita & Kegiatan Area -->

  <!-- Awal Indikator Jumlah Pendaftar -->
  <?php
  $total_pendaftar = is_array($pendaftar_rows) ? count($pendaftar_rows) : 0;
  $ekskul_list = [
    'Pramuka', 'Paskibra', 'UKS PMR', 'BTQ (Baca Tulis Al-Quran)',
    'Hadroh', 'Rebana', 'Marawis', 'Markaz Lughoh Arabic',
    'English Club', 'Matematika Club', 'Tenis Meja', 'Futsal',
    'Pengembangan Diri Komputer & Internet'
  ];
  $ekskul_counts = array_fill_keys($ekskul_list, 0);
  foreach ($pendaftar_rows as $row) {
    if (!empty($row['ekstrakurikuler'])) {
      $eks = json_decode($row['ekstrakurikuler'], true);
      if (is_array($eks)) {
        foreach ($eks as $e) {
          if (isset($ekskul_counts[$e])) $ekskul_counts[$e]++;
        }
      }
    }
  }
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
              <h5 class="card-title mb-3">Distribusi Ekstrakurikuler</h5>
              <?php foreach ($ekskul_list as $eks): 
                $count = $ekskul_counts[$eks] ?? 0;
                $percent = $total_pendaftar ? round($count * 100 / $total_pendaftar) : 0;
              ?>
                <div class="mb-2">
                  <div class="d-flex justify-content-between">
                    <div><strong><?= htmlspecialchars($eks); ?></strong></div>
                    <div class="text-muted"><?= $count; ?> siswa <small class="text-muted"> (<?= $percent; ?>%)</small></div>
                  </div>
                  <div class="progress" style="height:10px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $percent; ?>%;" aria-valuenow="<?= $percent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              <?php endforeach; ?>
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

  <!-- Awal Client Area -->
  <div id="clients" class="brand-area section">

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
                Simak pengalaman inspiratif dari siswa dan alumni MTs An-Nur Kota Cirebon.
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
              <img src="assets/images/testimonial/" alt="Siswa" style="width: 100%; height: auto;">
            </div>
            <div class="content">
              <p>"MTs An-Nur membentuk karakter saya menjadi lebih disiplin dan religius. Kegiatan ekstrakurikuler sangat bermanfaat untuk pengembangan diri."</p>
              <h4>Ahmad Fauzi</h4>
              <span>Alumni 2025 - Mahasiswa UIN Sunan Gunung Djati</span>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 col-12">
          <div class="single-testimonial">
            <div class="image"style="width: 100px; height: 100px; overflow: hidden; border-radius: 50%;">
              <img src="assets/images/testimonia/" alt="Siswa" style="width: 100%; height: auto;">
            </div>
            <div class="content">
              <p>"Lingkungan madrasah yang Islami dan guru-guru yang peduli membuat saya betah belajar di MTs An-Nur. Saya juga aktif di Pramuka dan Hadroh."</p>
              <h4>Siti Nurhaliza</h4>
              <span>Siswa Kelas IX - Ketua Pramuka</span>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6 col-12">
          <div class="single-testimonial">
            <div class="image" style="width: 100px; height: 100px; overflow: hidden; border-radius: 50%;">
              <img src="assets/images/testimonial/" alt="Siswa" style="width: 100%; height: auto;">
            </div>
            <div class="content">
              <p>"Saya bangga menjadi bagian dari MTs An-Nur. Banyak pengalaman berharga, terutama saat mengikuti lomba MTQ dan kegiatan sosial madrasah."</p>
              <h4>Mulyono</h4>
              <span>Siswa Kelas VIII - Juara MTQ Kota Cirebon</span>
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
                    <p>JL.Pangeran Drajat Karanganyar Jagasatru Selatan</p>
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
      <object title="Peta Mts An-Nur Kota Cirebon" style="border:0; height: 500px; width: 100%;"
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
                  <br>JL.Pangeran Drajat Karanganyar Jagasatru Selatan<br>
                  Telp: (021) 1234-5678<br>
                  Email: info@mtsan-nurcirebon.sch.id
                </p>
              </div>
            </div>
            <div class="col-lg-2 col-md-6 col-12">
              <div class="footer-widget f-link">
                <h5>Ekstrakulikuler Kami</h5>
                <ul>
                  <li><a href="#services">Pramuka</a></li>
                  <li><a href="#services">Futsal</a></li>
                  <li><a href="#services">English Club</a></li>
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
                  <a href=" " target="_blank" class="text-dark lni lni-facebook-filled"> Facebook</a> |
                  <a href=" " target="_blank" class="text-dark lni lni-instagram-original"> Instagram</a> |
                  <a href=" " target="_blank" class="text-dark lni lni-youtube"> YouTube</a>
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
      'href': 'https://www.youtube.com/watch?v=LzdsUZcw8L4',
      'type': 'video',
      'source': 'youtube', 
      'width': 900,
      'autoplayVideos': true,
    });

  </script>
</body>

</html>
