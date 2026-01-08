<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$flash = $_SESSION['contact_flash'] ?? null;
if (isset($_SESSION['contact_flash'])) unset($_SESSION['contact_flash']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>



<!-- Bootstrap Form -->
<section class="h-100 gradient-form">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center left-col-center">
                  <img src="../assets/images/logo.jpg"
                    class="login-logo w-25" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1 text-center"> MTs An-Nur Kota Cirebon</h4>
                </div>
                 <?php if (!empty($flash)): ?>
                    <div class="alert alert-<?php echo ($flash['status']==='success'?'success':'danger'); ?>"><?php echo htmlspecialchars($flash['msg']); ?></div>
                 <?php endif; ?>

                <form action="login_handler.php" method="post">
                  <label class="form-label" for="username">Admin</label>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="username" name="username" class="form-control"
                      placeholder="username" />
                  </div>

                  <label class="form-label" for="password">Password</label>
                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" placeholder="*******" />
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-success btn-block fa-lg gradient-custom-2 mb-3" type="submit">Log
                      in</button>
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2"><a href="../index.php#contact" class="text-decoration-none text-muted">Klik Forgot your password?</a></p>
                    <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-success" ><a class="text-decoration-none text-dark" href="../index.php">Kembali</a></button>
                  </div>
                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2 right-panel">
                <img class=" w-100" src="../assets/images/header/MTs_An-Nur_Kota_Cirebon_Login.jpg" alt="header image">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    
</body>
</html>

