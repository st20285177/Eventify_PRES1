<?php $flashMessages = get_flash_messages(); ?>
<!doctype html>
<html lang="en-GB">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle ?? 'Eventify') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="site-shell">
    <div class="bg-orb bg-orb--one"></div>
    <div class="bg-orb bg-orb--two"></div>
    <div class="bg-grid"></div>
    <header class="site-header container py-4">
        <nav class="navbar navbar-expand-lg nav-frame">
            <div class="container-fluid px-0">
                <a class="navbar-brand brand-mark" href="index.php">
                    <span class="brand-mark__icon">E</span>
                    <span>
                        <strong>Eventify</strong>
                        <small>Personal organizer studio</small>
                    </span>
                </a>
                <button class="navbar-toggler border-0 shadow-none text-white" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <?php if (is_logged_in()): ?>
                            <li class="nav-item"><a class="nav-link" href="add-event.php">Add Event</a></li>
                            <li class="nav-item"><a class="nav-link" href="view-events.php">View Events</a></li>
                            <li class="nav-item ms-lg-2"><a class="btn btn-brand-secondary" href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li class="nav-item ms-lg-2"><a class="btn btn-brand" href="login.php">Organiser Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?php if (is_logged_in()): ?>
            <div class="welcome-strip mt-3">
                <span class="welcome-strip__label">Signed in as</span>
                <strong><?= e(current_user()['full_name']) ?></strong>
                <span class="welcome-strip__meta">@<?= e(current_user()['username']) ?></span>
            </div>
        <?php endif; ?>
    </header>
    <main class="container pb-5">
        <?php foreach ($flashMessages as $type => $messages): ?>
            <?php foreach ($messages as $message): ?>
                <div class="alert alert-<?= $type === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show shadow-sm" role="alert">
                    <?= e($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
