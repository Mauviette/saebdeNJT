<?php
require_once './app/core/Repository.php';
require_once './app/entities/User.php';

class UserRepository {
    public function findById(int $id): ?User {
        $query = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new User(
                $data['id'],
                $data['nom'],
                $data['fonds'],
                $data['date_publication'],
                $data['role'],
                $data['date_adhesion']
            );
        }
        return null;
    }
    public function findAll(): array {
        $query = $this->db->query("SELECT * FROM users");
        $users = [];
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User(
                $data['id'],
                $data['nom'],
                $data['fonds'],
                $data['date_publication'],
                $data['role'],
                $data['date_adhesion']
            );
        }
        return $users;
    }
    public function save(User $user): void {
        if ($user->getId() === null) {
            $query = $this->db->prepare("
                INSERT INTO users (nom, fonds, date_publication, role, date_adhesion)
                VALUES (:nom, :fonds, :date_publication, :role, :date_adhesion)
            ");
        } else {
            $query = $this->db->prepare("
                UPDATE users
                SET nom = :nom, fonds = :fonds, date_publication = :date_publication, role = :role, date_adhesion = :date_adhesion
                WHERE id = :id
            ");
            $query->bindParam(':id', $user->getId(), PDO::PARAM_INT);
        }
        $query->bindParam(':nom', $user->getNom(), PDO::PARAM_STR);
        $query->bindParam(':fonds', $user->getFonds(), PDO::PARAM_STR);
        $query->bindParam(':date_publication', $user->getDatePublication(), PDO::PARAM_STR);
        $query->bindParam(':role', $user->getRole(), PDO::PARAM_STR);
        $query->bindParam(':date_adhesion', $user->getDateAdhesion(), PDO::PARAM_STR);
        $query->execute();
    }
    public function delete(int $id): void {
        $query = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
    }
}
