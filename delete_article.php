<?php

require_once './app/repositories/ArticleRepository.php';
require_once './app/services/AuthService.php';

$authService = new AuthService();
$user = $authService->getUser();

// Vérifie que l'utilisateur est connecté et admin
if (!$user || !$user->isAdmin()) {
    http_response_code(403);
    exit("Accès interdit.");
}

// Vérifie si un article ID est fourni
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['article_id'])) {
    $articleId = intval($_POST['article_id']);

    $articleRepository = new ArticleRepository();
    $articleRepository->deleteArticle($articleId);

    // Redirige vers l'accueil après suppression
    header("Location: /index.php");
    exit();
} else {
    http_response_code(400);
    exit("Requête invalide.");
}
