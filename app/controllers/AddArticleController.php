<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ArticleRepository.php';
require_once './app/entities/Article.php';


class AddArticleController extends Controller {
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? null;
            $content = $_POST['content'] ?? null;
    
            if ($title && $content) {
                $articleRepository = new ArticleRepository();
                $articleRepository->createArticle(
                    $title,
                    $content,
                    new DateTime()
                );
    
                header('Location: /index.php');
                exit;
            } else {
                $error = 'Title and content are required.';
            }
        }
    
        // Afficher la vue après le traitement
        $this->view('add_article.html.twig', ['error' => $error ?? null]);
    }
    
 
}
