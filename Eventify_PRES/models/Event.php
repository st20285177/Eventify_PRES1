<?php

declare(strict_types=1);

final class Event
{
    public function __construct(private readonly PDO $db)
    {
    }

    public function all(string $keyword = '', ?int $createdBy = null): array
    {
        $sql = 'SELECT * FROM events';
        $conditions = [];
        $params = [];

        if ($keyword !== '') {
            $conditions[] = '(title LIKE :keyword OR category LIKE :keyword OR venue LIKE :keyword)';
            $params['keyword'] = '%' . $keyword . '%';
        }

        if ($createdBy !== null) {
            $conditions[] = 'created_by = :created_by';
            $params['created_by'] = $createdBy;
        }

        if ($conditions !== []) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $sql .= ' ORDER BY event_date ASC, start_time ASC';

        $statement = $this->db->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll() ?: [];
    }

    public function find(int $id): ?array
    {
        $statement = $this->db->prepare('SELECT * FROM events WHERE event_id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        $event = $statement->fetch();

        return $event ?: null;
    }

    public function create(array $data): int
    {
        $statement = $this->db->prepare(
            'INSERT INTO events (title, category, venue, event_date, start_time, end_time, ticket_price, capacity, image_url, description, status, created_by)
             VALUES (:title, :category, :venue, :event_date, :start_time, :end_time, :ticket_price, :capacity, :image_url, :description, :status, :created_by)'
        );
        $statement->execute($data);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $data['event_id'] = $id;
        $statement = $this->db->prepare(
            'UPDATE events SET title = :title, category = :category, venue = :venue, event_date = :event_date, start_time = :start_time, end_time = :end_time,
             ticket_price = :ticket_price, capacity = :capacity, image_url = :image_url, description = :description, status = :status
             WHERE event_id = :event_id'
        );
        $statement->execute($data);
    }

    public function delete(int $id): void
    {
        $statement = $this->db->prepare('DELETE FROM events WHERE event_id = :id');
        $statement->execute(['id' => $id]);
    }

    public function countByStatus(?int $createdBy = null): array
    {
        $sql = 'SELECT status, COUNT(*) AS total FROM events';
        $params = [];
        if ($createdBy !== null) {
            $sql .= ' WHERE created_by = :created_by';
            $params['created_by'] = $createdBy;
        }
        $sql .= ' GROUP BY status';
        $statement = $this->db->prepare($sql);
        $statement->execute($params);
        $rows = $statement->fetchAll() ?: [];

        $totals = ['Draft' => 0, 'Published' => 0, 'Closed' => 0];
        foreach ($rows as $row) {
            $totals[$row['status']] = (int) $row['total'];
        }

        return $totals;
    }
}
