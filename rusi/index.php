<?php
session_start();
include 'includes/auth.php';
include 'includes/db.php'; // $pdo initialized
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>HONDA MOTORCYCLES</title>
    <link rel="icon" type="image/x-icon" href="assets/motorcycle.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/navbar.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/index.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/products.css?v=<?= time(); ?>"> <!-- Your custom products CSS -->

</head>

<body class="d-flex flex-column h-100">

<!-- Session Alerts -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success text-center mb-0">
        <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger text-center mb-0">
        <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<main class="flex-shrink-0">
    <?php include 'includes/navbar.php'; ?>

    <!-- Static Banner -->
    <div class="banner">
        <img src="images/banner1.jpg" alt="Motorcycle Banner" class="banner-img">
    </div>

<!-- Four Banners Full Width with No Borders or Corners -->
<div class="w-100">
    <div class="row g-0">
        <div class="col-6 col-md-3">
            <div class="position-relative">
                <img src="images/beat.jpg" alt="Honda Beat V3" class="img-fluid w-100 h-100">
                <div class="banner-label">Honda Beat V3</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="position-relative">
                <img src="images/click.jpg" alt="Honda Click 160 V2" class="img-fluid w-100 h-100">
                <div class="banner-label">Honda Click 160 V2</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="position-relative">
                <img src="images/giorno.jpg" alt="Honda Giorno" class="img-fluid w-100 h-100">
                <div class="banner-label">Honda Giorno</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="position-relative">
                <img src="images/adv.jpg" alt="Honda ADV 160" class="img-fluid w-100 h-100">
                <div class="banner-label">Honda ADV 160</div>
            </div>
        </div>
    </div>
</div>

<!-- Four Additional Full-Width Banners Below with Full Image and Smoke Overlay -->
<div class="row g-0">
    <div class="col-6 col-md-3">
        <div class="banner-box banner-tall">
            <img src="images/banner2.jpg" alt="Honda PCX 160" class="img-fluid w-100 h-100 object-fit-contain">
            <div class="banner-overlay">LOTS</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="banner-box banner-tall">
            <img src="images/banner3.jpg" alt="Honda XRM 125" class="img-fluid w-100 h-100 object-fit-contain">
            <div class="banner-overlay">OF</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="banner-box banner-tall">
            <img src="images/banner4.jpg" alt="Honda CBR 150R" class="img-fluid w-100 h-100 object-fit-contain">
            <div class="banner-overlay">PROMOS</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="banner-box banner-tall">
            <img src="images/banner5.jpg" alt="Honda CRF 150L" class="img-fluid w-100 h-100 object-fit-contain">
            <div class="banner-overlay">HERE!</div>
        </div>
    </div>
</div>




    <?php include 'includes/footer.php'; ?>
    <?php if (file_exists('includes/user.php')) include 'includes/user.php'; ?>
</main>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Smooth scroll for Products nav link -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const productLinks = document.querySelectorAll('a[href="#all-products-section"]');
    productLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector('#all-products-section');
        if (target) {
          const yOffset = -70;
          const y = target.getBoundingClientRect().top + window.pageYOffset + yOffset;
          window.scrollTo({ top: y, behavior: 'smooth' });
        }
      });
    });
  });
</script>

</body>
</html>
