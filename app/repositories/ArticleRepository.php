<?php
require_once './app/core/Repository.php';
require_once './app/entities/Article.php';

class ArticleRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findAll(): array {
        $query = "SELECT * FROM Articles";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $articles = [];
        foreach ($results as $row) {
            $articles[] = new Article(
                $row['id_article'],
                $row['id_utilisateur'],
                $row['titre'],
                $row['contenu'],
                new \DateTime($row['date_publication'])
            );
        }

        return $articles;
    }

    public function findById(int $id): ?Article {
        $query = "SELECT * FROM Articles WHERE id_article = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Article(
                $row['id_article'],
                $row['id_utilisateur'],
                $row['titre'],
                $row['contenu'],
                new \DateTime($row['date_publication'])
            );
            
        }

        return null;
    }

    public function createArticle(int $id_utilisateur, String $title, String $content, DateTime $publication_date): bool {
        $query = "INSERT INTO Articles (id_utilisateur, titre, contenu, date_publication) 
                  VALUES (:id_utilisateur, :title, :content, :publication_date)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_utilisateur', $id_utilisateur, PDO::PARAM_STR);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $stmt->bindValue(':publication_date', $publication_date->format('Y-m-d H:i:s'), PDO::PARAM_STR);

        error_log(print_r($stmt->errorInfo(), true));
        
        return $stmt->execute();
    }

    public function updateArticle(Article $article): bool {
        $query = "UPDATE Articles 
                  SET titre = :title, contenu = :content, date_publication = :publication_date 
                  WHERE id_article = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $article->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':title', $article->getTitle(), PDO::PARAM_STR);
        $stmt->bindValue(':content', $article->getContent(), PDO::PARAM_STR);
        $stmt->bindValue(':publication_date', $article->getDatePublication()->format('Y-m-d H:i:s'), PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function deleteArticle(int $id): bool {
        $query = "DELETE FROM Articles WHERE id_article = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

}
