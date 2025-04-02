<?php
require_once 'vendor/autoload.php';
require_once './app/services/AuthService.php';

abstract class Controller {
    protected $viewPath = './app/views/'; // Chemin vers les vues


    protected function view(string $viewName, array $data = []) {

        $loader = new \Twig\Loader\FilesystemLoader('app/views'); // Dossier des templates
        $twig = new \Twig\Environment($loader, [
            'cache' => false, // Mettre un dossier ('cache/') en production pour améliorer les performances
        ]);
        $authService = new AuthService();
        $twig->addGlobal('isLoggedIn', $authService->isLoggedIn());
        $data['isLoggedIn'] = $authService->isLoggedIn();

        // Rendu du template accueil.twig avec des variables
        echo $twig->render($viewName,$data);
    }

    protected function json($data, $status = 200) {
       header('Content-Type: application/json');
       http_response_code($status);
       echo json_encode($data);
       exit();
   }

    protected function redirectTo($url) {
        header("Location: $url");
        exit();
    }
}
