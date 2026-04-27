<?php

declare(strict_types=1);

require_once __DIR__ . '/config/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    (new AuthController(Database::connection()))->login($_POST);
}

$pageTitle = 'Eventify | Organiser Login';
$errors = validation_errors();
clear_validation_errors();
require_once __DIR__ . '/views/partials/header.php';
?>
<section class="auth-wrapper mx-auto">
    <div class="content-panel auth-panel">
        <span class="eyebrow">Secure organiser access</span>
        <h1 class="h2 mt-2">Login</h1>
        <p class="text-secondary">Use the organiser account to add, update and remove event listings.</p>

        <form method="post" action="login.php" novalidate>
            <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= e((string) old('username')) ?>" autocomplete="username" required>
                <?php if (isset($errors['username'])): ?>
                    <div class="invalid-feedback"><?= e($errors['username']) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" id="password" name="password" autocomplete="current-password" required>
                <?php if (isset($errors['password'])): ?>
                    <div class="invalid-feedback"><?= e($errors['password']) ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="demo-credentials mt-4">
            <h2 class="h6 text-uppercase">Demo credentials</h2>
            <p class="mb-1"><strong>Username:</strong> organiser</p>
            <p class="mb-0"><strong>Password:</strong> Eventify2026!</p>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/views/partials/footer.php'; ?>
