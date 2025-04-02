<?php
require_once './app/core/Repository.php';
require_once './app/entities/Event.php';

class EventRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findAll(): array {
        $query = "SELECT * FROM Evenements";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $events = [];
        foreach ($results as $row) {
            $events[] = new Event(
                $row['id_evenement'],
                null, //Ajouter les utilisateurs
                $row['titre'],
                $row['description'],
                $row['lieu'],
                new \DateTime($row['date_evenement']),
                (float)$row['prix']
            );
        }

        return $events;
    }

    public function findById(int $id): ?Event {
        $query = "SELECT * FROM Evenements WHERE id_evenement = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Event(
                $row['id_evenement'],
                null,
                $row['titre'],
                $row['description'],
                $row['lieu'],
                new \DateTime($row['date_evenement']),
                (float)$row['prix']
            );
        }

        return null;
    }

 

    public function updateEvent(Event $event): bool {
        $query = "UPDATE Evenements 
                  SET titre = :title, description = :content, lieu = :place, prix = :price, date_evenement = :event_date 
                  WHERE id_evenement = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $event->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':title', $event->getTitle(), PDO::PARAM_STR);
        $stmt->bindValue(':content', $event->getContent(), PDO::PARAM_STR);
        $stmt->bindValue(':place', $event->getPlace(), PDO::PARAM_STR);
        $stmt->bindValue(':price', $event->getPrice(), PDO::PARAM_STR);
        $stmt->bindValue(':event_date', $event->getDate()->format('Y-m-d'), PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function deleteEvent(int $id): bool {
        $query = "DELETE FROM Evenements WHERE id_evenement = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function createEvent(Event $event): bool {
        $query = "INSERT INTO Evenements (titre, description, lieu, date_evenement, prix) 
                  VALUES (:title, :content, :place, :event_date, :price)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':title', $event->getTitle(), PDO::PARAM_STR);
        $stmt->bindValue(':content', $event->getContent(), PDO::PARAM_STR);
        $stmt->bindValue(':place', $event->getPlace(), PDO::PARAM_STR);
        $stmt->bindValue(':event_date', $event->getDate()->format('Y-m-d'), PDO::PARAM_STR);
        $stmt->bindValue(':price', $event->getPrice(), PDO::PARAM_STR);

        return $stmt->execute();
    }

}
