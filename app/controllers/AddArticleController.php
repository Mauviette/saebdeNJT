<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ArticleRepository.php';
require_once './app/entities/Article.php';
require_once './app/services/AuthService.php';


class AddArticleController extends Controller {
    public function add() {
        $authService = new AuthService();
        $user = $authService->getUser();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? null;
            $content = $_POST['content'] ?? null;
    
            if ($title && $content) {
                $articleRepository = new ArticleRepository();
                $articleRepository->createArticle(
                    $user->getId(),
                    $title,
                    $content,
                    new DateTime('now', new DateTimeZone('+2'))
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
