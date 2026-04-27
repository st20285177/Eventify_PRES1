<?php

declare(strict_types=1);

function app_url(string $path = ''): string
{
    return $path;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function flash(string $type, string $message): void
{
    $_SESSION['_flash'][$type][] = $message;
}

function get_flash_messages(): array
{
    $messages = $_SESSION['_flash'] ?? [];
    unset($_SESSION['_flash']);
    return $messages;
}

function old(string $key, mixed $default = ''): mixed
{
    return $_SESSION['_old'][$key] ?? $default;
}

function set_old(array $input): void
{
    $_SESSION['_old'] = $input;
}

function clear_old(): void
{
    unset($_SESSION['_old']);
}

function validation_errors(): array
{
    return $_SESSION['_errors'] ?? [];
}

function set_validation_errors(array $errors): void
{
    $_SESSION['_errors'] = $errors;
}

function clear_validation_errors(): void
{
    unset($_SESSION['_errors']);
}

function csrf_token(): string
{
    if (!isset($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['_csrf'];
}

function verify_csrf(?string $token): bool
{
    return isset($_SESSION['_csrf']) && is_string($token) && hash_equals($_SESSION['_csrf'], $token);
}

function is_logged_in(): bool
{
    return isset($_SESSION['user']) && is_array($_SESSION['user']);
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function format_date(string $date): string
{
    $time = strtotime($date);
    return $time ? date('j M Y', $time) : $date;
}

function format_time(string $time): string
{
    $stamp = strtotime($time);
    return $stamp ? date('H:i', $stamp) : $time;
}

function selected(string $current, string $expected): string
{
    return $current === $expected ? 'selected' : '';
}

function event_status_class(string $status): string
{
    return match ($status) {
        'Published' => 'status-pill status-pill--published',
        'Closed' => 'status-pill status-pill--closed',
        default => 'status-pill status-pill--draft',
    };
}

function format_datetime(string $date, string $time = ''): string
{
    $value = trim($date . ' ' . $time);
    $stamp = strtotime($value);

    return $stamp ? date('j M Y, H:i', $stamp) : $value;
}