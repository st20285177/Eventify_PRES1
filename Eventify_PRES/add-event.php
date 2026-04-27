<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

$controller = new EventController(Database::connection());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->store($_POST);
}

$pageTitle = 'Eventify | Add Event';
$errors = validation_errors();
clear_validation_errors();
require_once __DIR__ . '/views/partials/header.php';
?>
<section class="content-panel form-panel">
    <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4">
        <div>
            <span class="eyebrow">Create a new listing</span>
            <h1 class="h2 mt-2 mb-0">Add Event</h1>
        </div>
        <div class="text-secondary small align-self-lg-end">All fields marked with * are required.</div>
    </div>

    <form method="post" action="add-event.php" id="eventForm" novalidate>
        <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">

        <div class="row g-3">
            <div class="col-md-8">
                <label for="title" class="form-label">Event title *</label>
                <input type="text" class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>" id="title" name="title" value="<?= e((string) old('title')) ?>" required>
                <?php if (isset($errors['title'])): ?><div class="invalid-feedback"><?= e($errors['title']) ?></div><?php endif; ?>
            </div>
            <div class="col-md-4">
                <label for="category" class="form-label">Category *</label>
                <select class="form-select <?= isset($errors['category']) ? 'is-invalid' : '' ?>" id="category" name="category" required>
                    <option value="">Choose...</option>
                    <?php foreach (['Conference', 'Concert', 'Workshop', 'Networking', 'Festival', 'Community'] as $category): ?>
                        <option value="<?= e($category) ?>" <?= old('category') === $category ? 'selected' : '' ?>><?= e($category) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['category'])): ?><div class="invalid-feedback"><?= e($errors['category']) ?></div><?php endif; ?>
            </div>

            <div class="col-md-6">
                <label for="venue" class="form-label">Venue *</label>
                <input type="text" class="form-control <?= isset($errors['venue']) ? 'is-invalid' : '' ?>" id="venue" name="venue" value="<?= e((string) old('venue')) ?>" required>
                <?php if (isset($errors['venue'])): ?><div class="invalid-feedback"><?= e($errors['venue']) ?></div><?php endif; ?>
            </div>
            <div class="col-md-3">
                <label for="event_date" class="form-label">Event date *</label>
                <input type="date" class="form-control <?= isset($errors['event_date']) ? 'is-invalid' : '' ?>" id="event_date" name="event_date" value="<?= e((string) old('event_date')) ?>" required>
                <?php if (isset($errors['event_date'])): ?><div class="invalid-feedback"><?= e($errors['event_date']) ?></div><?php endif; ?>
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Status *</label>
                <select class="form-select <?= isset($errors['status']) ? 'is-invalid' : '' ?>" id="status" name="status" required>
                    <?php foreach (['Draft', 'Published', 'Closed'] as $status): ?>
                        <option value="<?= e($status) ?>" <?= old('status', 'Draft') === $status ? 'selected' : '' ?>><?= e($status) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['status'])): ?><div class="invalid-feedback"><?= e($errors['status']) ?></div><?php endif; ?>
            </div>

            <div class="col-md-3">
                <label for="start_time" class="form-label">Start time *</label>
                <input type="time" class="form-control <?= isset($errors['start_time']) ? 'is-invalid' : '' ?>" id="start_time" name="start_time" value="<?= e((string) old('start_time')) ?>" required>
                <?php if (isset($errors['start_time'])): ?><div class="invalid-feedback"><?= e($errors['start_time']) ?></div><?php endif; ?>
            </div>
            <div class="col-md-3">
                <label for="end_time" class="form-label">End time *</label>
                <input type="time" class="form-control <?= isset($errors['end_time']) ? 'is-invalid' : '' ?>" id="end_time" name="end_time" value="<?= e((string) old('end_time')) ?>" required>
                <?php if (isset($errors['end_time'])): ?><div class="invalid-feedback"><?= e($errors['end_time']) ?></div><?php endif; ?>
            </div>
            <div class="col-md-3">
                <label for="ticket_price" class="form-label">Ticket price (£) *</label>
                <input type="number" class="form-control <?= isset($errors['ticket_price']) ? 'is-invalid' : '' ?>" id="ticket_price" name="ticket_price" min="0" step="0.01" value="<?= e((string) old('ticket_price', '0.00')) ?>" required>
                <?php if (isset($errors['ticket_price'])): ?><div class="invalid-feedback"><?= e($errors['ticket_price']) ?></div><?php endif; ?>
            </div>
            <div class="col-md-3">
                <label for="capacity" class="form-label">Capacity *</label>
                <input type="number" class="form-control <?= isset($errors['capacity']) ? 'is-invalid' : '' ?>" id="capacity" name="capacity" min="1" step="1" value="<?= e((string) old('capacity', '50')) ?>" required>
                <?php if (isset($errors['capacity'])): ?><div class="invalid-feedback"><?= e($errors['capacity']) ?></div><?php endif; ?>
            </div>

            <div class="col-12">
                <label for="image_url" class="form-label">Image URL</label>
                <input type="url" class="form-control <?= isset($errors['image_url']) ? 'is-invalid' : '' ?>" id="image_url" name="image_url" placeholder="https://example.com/event-image.jpg" value="<?= e((string) old('image_url')) ?>">
                <?php if (isset($errors['image_url'])): ?><div class="invalid-feedback"><?= e($errors['image_url']) ?></div><?php endif; ?>
            </div>

            <div class="col-12">
                <label for="description" class="form-label">Description *</label>
                <textarea class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>" id="description" name="description" rows="6" minlength="25" required><?= e((string) old('description')) ?></textarea>
                <?php if (isset($errors['description'])): ?><div class="invalid-feedback"><?= e($errors['description']) ?></div><?php endif; ?>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-3 mt-4">
            <button type="submit" class="btn btn-primary btn-lg">Save Event</button>
            <a href="view-events.php" class="btn btn-outline-secondary btn-lg">Back to Event List</a>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/views/partials/footer.php'; ?>
