<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include 'includes/auth.php';
include 'includes/header.php';
include 'includes/db.php';
include 'includes/user.php';

$editFeedback = null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : trim($_POST['email'] ?? '');
    $rating = isset($_POST['rating']) && $_POST['rating'] !== '' ? (int)$_POST['rating'] : null;
    $message = trim($_POST['message'] ?? '');

    if ($name === '') {
        $_SESSION['error'] = 'Name is required.';
    } elseif ($rating !== null && ($rating < 1 || $rating > 5)) {
        $_SESSION['error'] = 'Invalid rating value.';
    } elseif ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format.';
    } else {
        try {
            if (isset($_POST['id']) && is_numeric($_POST['id'])) {
                $id = (int)$_POST['id'];
                $stmt = $pdo->prepare("UPDATE feedback SET name = ?, email = ?, rating = ?, message = ? WHERE id = ?");
                $stmt->execute([$name, $email, $rating, $message, $id]);
                $_SESSION['success'] = 'Feedback updated successfully!';
            } else {
                $stmt = $pdo->prepare("INSERT INTO feedback (name, email, rating, message) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $email, $rating, $message]);
                $_SESSION['success'] = 'Thank you for your feedback!';
            }
            header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Database error: ' . $e->getMessage();
        }
    }
}

// Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM feedback WHERE id = ?");
        $stmt->execute([$deleteId]);
        $_SESSION['success'] = 'Feedback deleted successfully.';
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Failed to delete feedback: ' . $e->getMessage();
    }
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// Handle edit
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM feedback WHERE id = ?");
    $stmt->execute([$editId]);
    $editFeedback = $stmt->fetch(PDO::FETCH_ASSOC);
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<link rel="stylesheet" href="css/feedback.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container my-5">
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success text-center"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Feedback Form and Contact -->
        <div class="col-md-5">
            <h4 class="mb-3"><?= $editFeedback ? 'Edit Your Feedback' : 'Leave Your Feedback' ?></h4>
            <form method="POST" novalidate>
                <?php if ($editFeedback): ?>
                    <input type="hidden" name="id" value="<?= (int)$editFeedback['id'] ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($editFeedback['name'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email (optional)</label>
                    <input type="email" name="email" class="form-control"
                        <?= isset($_SESSION['user_email']) ? 'readonly' : '' ?>
                        value="<?= htmlspecialchars($_SESSION['user_email'] ?? $editFeedback['email'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Rating</label>
                    <div class="rating d-flex">
                        <?php for ($i = 1; $i <= 5; $i++):
                            $checked = (isset($editFeedback['rating']) && (int)$editFeedback['rating'] === $i) ? 'checked' : '';
                        ?>
                            <input type="radio" name="rating" id="star<?= $i ?>" value="<?= $i ?>" hidden <?= $checked ?>>
                            <label for="star<?= $i ?>" class="me-1" style="cursor:pointer;">
                                <i class="bi bi-star-fill fs-4 text-secondary" data-index="<?= $i ?>"></i>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Comment (optional)</label>
                    <textarea name="message" rows="4" class="form-control"><?= htmlspecialchars($editFeedback['message'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100"><?= $editFeedback ? 'Update Feedback' : 'Submit Feedback' ?></button>
            </form>

            <!-- Contact Section -->
            <div class="mt-5 pt-4 border-top">
                <h3 class="text-center mb-3">Contact Us</h3>
                <p class="text-center">Have any questions or suggestions? Reach out to us!</p>
                <div class="text-center">
                    <p><i class="bi bi-envelope"></i> support@hondaph.com</p>
                    <p><i class="bi bi-telephone"></i> +63 912 345 6789</p>
                    <p><i class="bi bi-geo-alt"></i> Makati City, Philippines</p>
                </div>
            </div>
        </div>

        <!-- Feedback Display -->
        <div class="col-md-7">
            <div class="row">
                <?php
                $stmt = $pdo->query("SELECT * FROM feedback ORDER BY submitted_at DESC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                <div class="col-12 mb-4">
                     <div class="feedback-card h-100">
                        <div>
                            <h5><?= htmlspecialchars($row['name']); ?></h5>
                            <p class="text-muted small mb-1"><?= htmlspecialchars($row['email']); ?></p>
                            <?php if (!empty($row['rating'])): ?>
                                <div class="mb-2">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi <?= ($i <= (int)$row['rating']) ? 'bi-star-fill text-warning' : 'bi-star'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>
                            <p><?= nl2br(htmlspecialchars($row['message'])); ?></p>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted"><?= htmlspecialchars($row['submitted_at']); ?></small><br>
                            <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning mt-2 me-2">Edit</a>
                            <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger mt-2" onclick="return confirm('Delete this feedback?')">Delete</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const stars = document.querySelectorAll('.rating i');
        let selectedRating = document.querySelector('input[name=rating]:checked')?.value || 0;

        function highlightStars(rating) {
            stars.forEach((star, i) => {
                star.classList.toggle('text-warning', i < rating);
                star.classList.toggle('text-secondary', i >= rating);
            });
        }

        stars.forEach((star, index) => {
            star.addEventListener('mouseover', () => highlightStars(index + 1));
            star.addEventListener('mouseout', () => highlightStars(selectedRating));
            star.addEventListener('click', () => {
                selectedRating = index + 1;
                document.getElementById('star' + selectedRating).checked = true;
                highlightStars(selectedRating);
            });
        });

        highlightStars(selectedRating);
    });
</script>

<?php include 'includes/footer.php'; ?>
