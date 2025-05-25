<?php
session_start();
include 'includes/auth.php';
include 'includes/db.php';
include 'includes/header.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Motorcycles | HONDA PH</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/navbar.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/footer.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="css/products.css?v=<?= time(); ?>">
</head>
<body class="d-flex flex-column h-100">

<main class="flex-shrink-0">
    <?php include 'includes/navbar.php'; ?>

    <div class="container my-5">
        <?php
        try {
            $stmt = $pdo->prepare("SELECT * FROM products ORDER BY created_at DESC");
            $stmt->execute();
            $allProducts = $stmt->fetchAll();

            $grouped = [];

            foreach ($allProducts as $product) {
                $rawCategory = trim($product['category'] ?? 'Uncategorized');
                $key = strtolower($rawCategory);
                switch ($key) {
                    case 'scooters':
                        $category = 'Scooters';
                        break;
                    case 'underbones':
                        $category = 'Underbones';
                        break;
                    case 'bigbikes':
                    case 'big bikes':
                        $category = 'Big Bikes';
                        break;
                    default:
                        $category = ucfirst($rawCategory);
                }

                if (!isset($grouped[$category])) {
                    $grouped[$category] = [];
                }
                $grouped[$category][] = $product;
            }

            foreach ($grouped as $category => $products):
                if (!empty($products)):
        ?>
        <section class="menu-section my-5">
            <div class="title-wrapper">
                <h4 class="section-title"><?= htmlspecialchars($category) ?></h4>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 g-4">
                <?php foreach ($products as $product): 
                    $image = !empty($product['main_image']) ? htmlspecialchars($product['main_image']) : 'images/default.jpg';
                    $name = !empty($product['name']) ? htmlspecialchars($product['name']) : 'Unnamed';
                ?>
                <div class="col">
                    <div class="card product-card h-100">
                        <div class="card-img-wrapper">
                            <img src="<?= $image ?>" alt="<?= $name ?>" class="img-fluid" />
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= $name ?></h5>
                            <p class="card-text"><?= htmlspecialchars($product['description']); ?></p>
                            <p class="card-text text-white bg-danger text-center mt-auto py-2 rounded">
                                ₱<?= number_format($product['price'], 2); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php 
                endif;
            endforeach;
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
        ?>
    </div>

    <?php include 'includes/footer.php'; ?>
    <?php if (file_exists('includes/user.php')) include 'includes/user.php'; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
