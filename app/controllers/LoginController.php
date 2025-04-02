<?php

require_once './app/core/Controller.php';
require_once './app/services/AuthService.php';

class LoginController extends Controller {
    public function login() {
        $authService = new AuthService();
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';


            if ($authService->login($email, $password)) {
                // Redirige vers la page d'accueil ou le tableau de bord après connexion
                header("Location: /index.php");
				error_log("Connexion réussie pour l'utilisateur : $email");
                exit();
            } else {
                $error = "Identifiants incorrects.";
            }
        }

        // Affichage du formulaire avec message d'erreur s'il y en a un
        $this->view("login.html.twig", ['error' => $error]);
    }
}