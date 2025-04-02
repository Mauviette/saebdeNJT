<?php

require_once './app/core/Controller.php';
require_once './app/services/AuthService.php';

class ProfileController extends Controller {
 
    public function profile() {
        $authService = new AuthService();
        $user = $authService->getUser(); // Récupère l'utilisateur connecté

        if (!$user) {
            header("Location: /login.php"); // Redirige si non connecté
            exit();
        }

        $this->view('profile.html.twig', ['user' => $user]); // Passe l'utilisateur à la vue
    }
}

