DROP DATABASE IF EXISTS eventify_pres;
CREATE DATABASE eventify_pres CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE eventify_pres;

CREATE TABLE users (
    user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE events (
    event_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    category VARCHAR(50) NOT NULL,
    venue VARCHAR(150) NOT NULL,
    event_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    ticket_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    capacity INT UNSIGNED NOT NULL,
    image_url VARCHAR(255) DEFAULT NULL,
    description TEXT NOT NULL,
    status ENUM('Draft', 'Published', 'Closed') NOT NULL DEFAULT 'Draft',
    created_by INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_events_users FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE CASCADE
);

INSERT INTO users (full_name, username, password_hash)
VALUES (
    'Demo Organiser',
    'organiser',
    '$2y$12$TMa6CvVL.XCdWb8OQk1foO0oPUD823okSZ52ibRkjRC6WGj2W/yMO'
);

INSERT INTO events (title, category, venue, event_date, start_time, end_time, ticket_price, capacity, image_url, description, status, created_by)
VALUES
(
    'Cardiff Innovation Expo 2026',
    'Conference',
    'Cardiff City Hall',
    '2026-06-18',
    '09:30:00',
    '16:30:00',
    35.00,
    300,
    'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80',
    'A one-day public event showcasing innovation, entrepreneurship, digital transformation and creative collaboration across Cardiff and South Wales.',
    'Published',
    1
),
(
    'Riverside Summer Music Night',
    'Concert',
    'Bute Park Open Stage',
    '2026-07-12',
    '18:00:00',
    '22:00:00',
    12.50,
    450,
    'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?auto=format&fit=crop&w=1200&q=80',
    'An outdoor evening concert with local artists, food stalls, family-friendly zones and a relaxed riverside atmosphere for the wider public.',
    'Draft',
    1
);
