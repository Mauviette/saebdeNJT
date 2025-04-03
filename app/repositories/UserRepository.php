<?php
require_once './app/core/Repository.php';
require_once './app/entities/User.php';

class UserRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function createUser(User $user, string $password): bool {
        $sql = "INSERT INTO Utilisateur (nom, email, mot_de_passe, fond, role, date_adhesion) 
                VALUES (:nom, :email, :mot_de_passe, :fond, :role, :date_adhesion)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nom' => $user->getNom(),
            ':email' => $user->getEmail(),
            ':mot_de_passe' => password_hash($password, PASSWORD_BCRYPT),
            ':fond' => $user->getFonds(),
            ':role' => $user->getRole(),
            ':date_adhesion' => $user->getDateAdhesion()->format('Y-m-d')
        ]);
    }

    public function getUserById(int $id): ?User {
        $sql = "SELECT * FROM Utilisateur WHERE id_utilisateur = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        if ($row) {
            return new User(
                $row['id_utilisateur'],
                $row['nom'],
                $row['fond'],
                $row['role'],
                new \DateTime($row['date_adhesion']),
                $row['email']
            );
        }

        return null;
    }

    public function getUserByEmail(string $email): ?User {
        $sql = "SELECT * FROM Utilisateur WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();

        if ($row) {
            return new User(
                $row['id_utilisateur'],
                $row['nom'],
                $row['fond'],
                $row['role'],
                new \DateTime($row['date_adhesion']),
                $row['email']
            );
        }

        return null;
    }

    public function updateUser(User $user): bool {
        $sql = "UPDATE Utilisateur 
                SET nom = :nom, email = :email, fond = :fond, role = :role, date_adhesion = :date_adhesion 
                WHERE id_utilisateur = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $user->getId(),
            ':nom' => $user->getNom(),
            ':email' => $user->getEmail(),
            ':fond' => $user->getFonds(),
            ':role' => $user->getRole(),
            ':date_adhesion' => $user->getDateAdhesion()->format('Y-m-d')
        ]);
    }

    public function deleteUser(int $id): bool {
        $sql = "DELETE FROM Utilisateur WHERE id_utilisateur = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }

    public function getPasswordFromEmail(string $email): ?string {
        $sql = "SELECT mot_de_passe FROM Utilisateur WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();

        return $row ? $row['mot_de_passe'] : null;
    }

    public function getNotificationPreference($userId) {
        $stmt = $this->pdo->prepare("SELECT parametre_notification FROM Utilisateur WHERE id_utilisateur = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }

    public function updateNotificationPreference($userId, $preference) {
        $stmt = $this->pdo->prepare("UPDATE Utilisateur SET parametre_notification = ? WHERE id_utilisateur = ?");
        $stmt->execute([$preference, $userId]);
    }

    public function updateUsername($userId, $newUsername) {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->execute([$newUsername, $userId]);
    }
    
}
