<?php
require_once './app/core/Repository.php';
require_once './app/entities/Article.php';

class ArticleRepository {
    private $pdo;

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM Articles');
        $articles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $articles[] = $this->createArticleFromRow($row);
        }
        return $articles;
    }

    public function findById(int $id): ?Article
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Articles WHERE id_article = :id');
        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($article) {
            return $this->createArticleFromRow($article);
        }
        return null;
    }

    public function create(Article $article): bool
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO Articles (titre, contenu, date_publication)
            VALUES (:titre, :contenu, :date_publication)
        ');

        return $stmt->execute([
            'titre' => $article->getTitre(),
            'contenu' => $article->getContenu(),
            'date_publication' => $article->getDatePublication()
        ]);
    }
}
