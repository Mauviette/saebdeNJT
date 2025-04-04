<?php

require_once './app/core/Controller.php';
require_once './app/entities/Purchase.php';
require_once './app/trait/FormTrait.php';
require_once './app/services/AuthService.php';
require_once './app/repositories/ArticleRepository.php';
require_once './app/entities/Article.php';
require_once './app/repositories/EventRepository.php';
require_once './app/entities/Event.php';
require_once './app/repositories/UserRepository.php';


class HomeController extends Controller
{
   use FormTrait;

   public function index()
   {
    $events = (new EventRepository())->findAll();
    $articles = (new ArticleRepository())->findAll();
    $userRepository = new UserRepository();

    $authService = new AuthService();
    $user = $authService->getUser();

    usort($events, function ($a, $b) {
        $now = new DateTime();
        $dateA = $a->getDate();
        $dateB = $b->getDate();

        if ($dateA >= $now && $dateB < $now) {
            return -1;
        } elseif ($dateA < $now && $dateB >= $now) {
            return 1;
        } else {
            return $dateA <=> $dateB;
        }
    });

    $articles = array_reverse($articles);

    $news_id = $_GET['news_id'] ?? null;
    $selected_article = null;

    if ($news_id !== null) {
        foreach ($articles as $article) {
            if ($article->getId() == $news_id) {
                $selected_article = $article;
                $dateAffichage = $selected_article->getDatePublication()->format('d/m/Y H:i');
                $userAffichage = $userRepository->getUserById($article->getUserId())->getNom();
                
                break;
            }
        }
    }

    $this->view('index.html.twig',  [
        'title' => 'Le site du BDE',
        'articles' => $articles,
        'events' => $events,
        'selected_article' => $selected_article,
        'dateAffichage' => $dateAffichage,
        'userAffichage' => $userAffichage,
        'user' => $user
    ]);
   }
}
