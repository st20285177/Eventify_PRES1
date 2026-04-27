<?php

declare(strict_types=1);

final class AuthController
{
    public function __construct(private readonly PDO $db)
    {
    }

    public function login(array $input): void
    {
        if (!verify_csrf($input['_csrf'] ?? null)) {
            flash('error', 'Your session token is invalid. Please try again.');
            redirect('login.php');
        }

        $username = trim((string) ($input['username'] ?? ''));
        $password = (string) ($input['password'] ?? '');

        $errors = [];
        if ($username === '') {
            $errors['username'] = 'Please enter your username.';
        }
        if ($password === '') {
            $errors['password'] = 'Please enter your password.';
        }

        if ($errors !== []) {
            set_old(['username' => $username]);
            set_validation_errors($errors);
            redirect('login.php');
        }

        $user = (new User($this->db))->authenticate($username, $password);

        if (!$user) {
            set_old(['username' => $username]);
            flash('error', 'The username or password is incorrect.');
            redirect('login.php');
        }

        session_regenerate_id(true);
        $_SESSION['user'] = [
            'user_id' => (int) $user['user_id'],
            'full_name' => $user['full_name'],
            'username' => $user['username'],
        ];

        clear_old();
        flash('success', 'Welcome back. You are now logged in as the organiser.');
        redirect('view-events.php');
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        flash('success', 'You have been logged out successfully.');
        redirect('index.php');
    }
}
