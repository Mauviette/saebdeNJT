<?php
require_once './app/core/Repository.php';
require_once './app/entities/Item.php';

class ItemRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findAll(): array {
        $query = "SELECT * FROM Produits";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $items = [];
        foreach ($results as $row) {
            $items[] = new Item(
                $row['id_produit'],
                $row['nom_prod'],
                $row['description'],
                $row['prix'],
                $row['stock'],
                $row['category']
            );
        }

        return $items;
    }

    public function findById(int $id): ?Event {
        $query = "SELECT * FROM Produits WHERE id_produit = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Item(
                $row['id_produit'],
                $row['nom_prod'],
                $row['description'],
                $row['prix'],
                $row['stock'],
                $row['category']
            );
        }

        return null;
    }

    public function findAllCategory(): array {
        $query = "SELECT DISTINCT category FROM Produits";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categories = [];
        foreach ($results as $row) {
            $categories[] = $row['category'];
        }

        return $categories;
    }

    public function createItem (string $name, string $description, float $price, int $stock, string $category): bool {
        $query = "INSERT INTO Produits (nom_prod, description, prix, stock, category) 
                  VALUES (:name, :description, :price, :stock, :category)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_STR);
        $stmt->bindValue(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
