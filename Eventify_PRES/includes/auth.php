<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/app.php';

if (!is_logged_in()) {
    flash('error', 'Please log in as the organiser to access that page.');
    redirect('login.php');
}
