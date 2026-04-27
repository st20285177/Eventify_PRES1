<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    (new EventController(Database::connection()))->destroy($_POST);
}

redirect('view-events.php');
