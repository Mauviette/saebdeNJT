<?php
require_once './app/core/Repository.php';
require_once './app/entities/Event.php';

class EventRepository {
    private $pdo;

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM Events');
        $events = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $events[] = $this->createEventFromRow($row);
        }
        return $events;
    }

    public function findById(int $id): ?Event
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Events WHERE id_event = :id');
        $stmt->execute(['id' => $id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($event) {
            return $this->createEventFromRow($event);
        }
        return null;
    }

    public function create(Event $event): bool
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO Events (title, description, date)
            VALUES (:title, :description, :date)
        ');

        return $stmt->execute([
            'title' => $event->getTitle(),
            'description' => $event->getDescription(),
            'date' => $event->getEventDate()
        ]);
    }
}
