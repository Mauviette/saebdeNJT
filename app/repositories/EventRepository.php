<?php
require_once './app/core/Repository.php';
require_once './app/entities/Event.php';

class EventRepository extends Repository {

    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM Evenements');
        $events = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $events[] = $this->createEventFromRow($row);
        }
        return $events;
    }

    public function findById(int $id): ?Event
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Evenements WHERE id_evenement = :id');
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
            INSERT INTO Evenements (titre, description, lieu, prix, date_evenement)
            VALUES (:titre, :description, :lieu, :prix, :date_evenement)
        ');

        return $stmt->execute([
            'titre' => $event->getTitle(),
            'description' => $event->getDescription(),
            'lieu' => $event->getLocation(),
            'prix' => $event->getPrice(),
            'date_evenement' => $event->getEventDate()
        ]);
    }

}
