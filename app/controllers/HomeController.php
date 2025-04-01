<?php

require_once './app/core/Controller.php';
require_once './app/entities/Purchase.php';
require_once './app/trait/FormTrait.php';
require_once './app/services/AuthService.php';
require_once './app/repositories/ArticleRepository.php';
require_once './app/entities/Article.php';
require_once './app/repositories/EventRepository.php';
require_once './app/entities/Event.php';


class HomeController extends Controller
{
   use FormTrait;

   public function index()
   {
    $articles = [
        new Article(1, 'Article 1', 'La nouvelle réforme vise à améliorer la qualité et l\'accessibilité des transports publics dans toute la région. Elle met l\'accent sur l\'augmentation de la fréquence des trains, la modernisation des infrastructures et l\'intégration de nouvelles technologies pour rendre les trajets plus efficaces et plus écologiques.', new \DateTime('2023-01-01 00:00:00')),
       new Article(2, 'Article 2', 'Contenu de l\'article 2', new \DateTime('2023-02-01 00:00:00')),
        new Article(3, 'Article 3', 'Contenu de l\'article 3', new \DateTime('2023-03-01 00:00:00')),
    ];

    $events = [
        new Event(
            1,
            'Event 1',
            'Description of Event 1',
            'Place 1',
            new \DateTime('2023-04-01 00:00:00')
        ),
        new Event(
            2,
            'Event 2',
            'Description of Event 2',
            'Place 2',
            new \DateTime('2023-05-01 00:00:00')
        ),
        new Event(
            3,
            'Event 3',
            'Description of Event 3',
            'Place 3',
            new \DateTime('2023-06-01 00:00:00')
        )
        ];

    $news_id = $_GET['news_id'] ?? null;
    $selected_article = null;

    if ($news_id !== null) {
        foreach ($articles as $article) {
            if ($article->getId() == $news_id) {
                $selected_article = $article;
                break;
            }
        }
    }

    $this->view('index.html.twig',  [
        'title' => 'Le site du BDE',
        'articles' => $articles,
        'events' => $events,
        'selected_article' => $selected_article
    ]);
   }
}
