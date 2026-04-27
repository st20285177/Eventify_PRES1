<?php

declare(strict_types=1);

final class EventController
{
    public function __construct(private readonly PDO $db)
    {
    }

    public function index(string $keyword = ''): array
    {
        $user = current_user();
        return (new Event($this->db))->all($keyword, $user['user_id'] ?? null);
    }

    public function show(int $id): ?array
    {
        return (new Event($this->db))->find($id);
    }

    public function statusSummary(): array
    {
        $user = current_user();
        return (new Event($this->db))->countByStatus($user['user_id'] ?? null);
    }

    public function store(array $input): void
    {
        $this->persist($input, null);
    }

    public function update(int $id, array $input): void
    {
        $this->persist($input, $id);
    }

    public function destroy(array $input): void
    {
        if (!verify_csrf($input['_csrf'] ?? null)) {
            flash('error', 'The delete request could not be verified.');
            redirect('view-events.php');
        }

        $id = (int) ($input['event_id'] ?? 0);
        if ($id < 1) {
            flash('error', 'A valid event was not supplied.');
            redirect('view-events.php');
        }

        (new Event($this->db))->delete($id);
        flash('success', 'The event was deleted successfully.');
        redirect('view-events.php');
    }

    private function persist(array $input, ?int $id): void
    {
        $redirectTarget = $id ? 'edit-event.php?id=' . $id : 'add-event.php';

        if (!verify_csrf($input['_csrf'] ?? null)) {
            flash('error', 'The form token is invalid. Please try again.');
            redirect($redirectTarget);
        }

        $title = trim((string) ($input['title'] ?? ''));
        $category = trim((string) ($input['category'] ?? ''));
        $venue = trim((string) ($input['venue'] ?? ''));
        $eventDate = trim((string) ($input['event_date'] ?? ''));
        $startTime = trim((string) ($input['start_time'] ?? ''));
        $endTime = trim((string) ($input['end_time'] ?? ''));
        $ticketPrice = trim((string) ($input['ticket_price'] ?? '0'));
        $capacity = trim((string) ($input['capacity'] ?? '0'));
        $imageUrl = trim((string) ($input['image_url'] ?? ''));
        $description = trim((string) ($input['description'] ?? ''));
        $status = trim((string) ($input['status'] ?? 'Draft'));

        $data = [
            'title' => $title,
            'category' => $category,
            'venue' => $venue,
            'event_date' => $eventDate,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'ticket_price' => $ticketPrice,
            'capacity' => $capacity,
            'image_url' => $imageUrl,
            'description' => $description,
            'status' => $status,
        ];

        $errors = [];
        if ($title === '' || strlen($title) < 4) {
            $errors['title'] = 'Please provide an event title with at least 4 characters.';
        }
        if ($category === '') {
            $errors['category'] = 'Please choose an event category.';
        }
        if ($venue === '' || strlen($venue) < 3) {
            $errors['venue'] = 'Please provide a valid venue.';
        }
        if ($eventDate === '') {
            $errors['event_date'] = 'Please select the event date.';
        }
        if ($startTime === '') {
            $errors['start_time'] = 'Please enter a start time.';
        }
        if ($endTime === '') {
            $errors['end_time'] = 'Please enter an end time.';
        }
        if ($startTime !== '' && $endTime !== '' && strtotime($endTime) <= strtotime($startTime)) {
            $errors['end_time'] = 'End time must be later than start time.';
        }
        if (!is_numeric($ticketPrice) || (float) $ticketPrice < 0) {
            $errors['ticket_price'] = 'Please enter a valid ticket price.';
        }
        if (!ctype_digit($capacity) || (int) $capacity < 1) {
            $errors['capacity'] = 'Capacity must be at least 1.';
        }
        if ($imageUrl !== '' && filter_var($imageUrl, FILTER_VALIDATE_URL) === false) {
            $errors['image_url'] = 'Please enter a valid image URL.';
        }
        if ($description === '' || strlen($description) < 25) {
            $errors['description'] = 'Please enter at least 25 characters for the description.';
        }
        if (!in_array($status, ['Draft', 'Published', 'Closed'], true)) {
            $errors['status'] = 'Please choose a valid status.';
        }

        if ($errors !== []) {
            set_old($data);
            set_validation_errors($errors);
            flash('error', 'Please correct the highlighted fields and submit the form again.');
            redirect($redirectTarget);
        }

        $payload = [
            'title' => $title,
            'category' => $category,
            'venue' => $venue,
            'event_date' => $eventDate,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'ticket_price' => number_format((float) $ticketPrice, 2, '.', ''),
            'capacity' => (int) $capacity,
            'image_url' => $imageUrl !== '' ? $imageUrl : null,
            'description' => $description,
            'status' => $status,
            'created_by' => current_user()['user_id'] ?? 1,
        ];

        $eventModel = new Event($this->db);
        if ($id === null) {
            $eventModel->create($payload);
            flash('success', 'The event was created successfully.');
        } else {
            unset($payload['created_by']);
            $eventModel->update($id, $payload);
            flash('success', 'The event was updated successfully.');
        }

        clear_old();
        clear_validation_errors();
        redirect('view-events.php');
    }
}
