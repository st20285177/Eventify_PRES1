<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

$controller = new EventController(Database::connection());
$keyword = trim((string) ($_GET['q'] ?? ''));
$events = $controller->index($keyword);

$pageTitle = 'Eventify | View Events';
require_once __DIR__ . '/views/partials/header.php';
?>
<section class="content-panel mb-4">
    <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-end">
        <div>
            <span class="eyebrow">Organiser dashboard</span>
            <h1 class="h2 mt-2 mb-0">View List of Events</h1>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="add-event.php" class="btn btn-primary">Add New Event</a>
            <a href="view-events.php" class="btn btn-outline-secondary">Reset</a>
        </div>
    </div>

    <form method="get" action="view-events.php" class="row g-3 mt-3 align-items-end">
        <div class="col-lg-9">
            <label for="q" class="form-label">Search events</label>
            <input type="search" id="q" name="q" class="form-control" value="<?= e($keyword) ?>" placeholder="Search by title, category or venue">
        </div>
        <div class="col-lg-3">
            <button type="submit" class="btn btn-dark w-100">Search</button>
        </div>
    </form>
</section>

<?php if ($events === []): ?>
    <section class="content-panel text-center py-5">
        <h2 class="h4">No events found</h2>
        <p class="text-secondary mb-4">Create your first listing or adjust your search filter.</p>
        <a href="add-event.php" class="btn btn-primary">Create Event</a>
    </section>
<?php else: ?>
    <section class="row g-4">
        <?php foreach ($events as $event): ?>
            <div class="col-xl-6">
                <article class="event-card h-100">
                    <div class="event-card__media">
                        <img src="<?= e($event['image_url'] ?: 'assets/images/hero-events.svg') ?>" alt="Promotional image for <?= e($event['title']) ?>" loading="lazy">
                    </div>
                    <div class="event-card__content">
                        <div class="d-flex justify-content-between gap-3 flex-wrap">
                            <div>
                                <span class="badge text-bg-light border"><?= e($event['category']) ?></span>
                                <span class="badge <?= $event['status'] === 'Published' ? 'text-bg-success' : ($event['status'] === 'Draft' ? 'text-bg-warning' : 'text-bg-secondary') ?> ms-1"><?= e($event['status']) ?></span>
                                <h2 class="h4 mt-3 mb-2"><?= e($event['title']) ?></h2>
                            </div>
                            <div class="price-tag">£<?= e(number_format((float) $event['ticket_price'], 2)) ?></div>
                        </div>
                        <p class="text-secondary mb-2"><strong>Venue:</strong> <?= e($event['venue']) ?></p>
                        <p class="text-secondary mb-2"><strong>Date:</strong> <?= format_datetime($event['event_date']) ?></p>
                        <p class="text-secondary mb-2"><strong>Time:</strong> <?= e(substr($event['start_time'], 0, 5)) ?> - <?= e(substr($event['end_time'], 0, 5)) ?></p>
                        <p class="text-secondary mb-3"><strong>Capacity:</strong> <?= e((string) $event['capacity']) ?> attendees</p>
                        <p class="mb-4"><?= e($event['description']) ?></p>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="edit-event.php?id=<?= (int) $event['event_id'] ?>" class="btn btn-outline-primary">Edit</a>
                            <form action="delete-event.php" method="post" class="d-inline delete-form">
                                <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
                                <input type="hidden" name="event_id" value="<?= (int) $event['event_id'] ?>">
                                <button type="submit" class="btn btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
<?php require_once __DIR__ . '/views/partials/footer.php'; ?>
