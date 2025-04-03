<?php

require_once './app/core/Controller.php';
require_once './app/services/AuthService.php';
require_once './app/repositories/UserRepository.php';
require_once './app/entities/User.php';

class ProfileController extends Controller {
 
    public function profile() {
        $authService = new AuthService();
        $user = $authService->getUser();  

        if (!$user) {
            header("Location: /login.php"); 
            exit();
        }

        $userRepository = new UserRepository();
        $currentNotification = $userRepository->getNotificationPreference($user->getId());

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notificationSelect'])) {
            $allowedValues = ['tous', 'articles', 'evenements', 'none'];
            $newNotification = $_POST['notificationSelect'];

            if (in_array($newNotification, $allowedValues)) {
                $userRepository->updateNotificationPreference($user->getId(), $newNotification);
                http_response_code(200);
                exit;
            } else {
                http_response_code(400);
                exit;
            }
        }
        
        // Gestion du changement de nom d'utilisateur via AJAX
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newUsername'])) {
            $newUsername = trim($_POST['newUsername']);

            // Vérification de la validité du pseudo
            if (!empty($newUsername) && strlen($newUsername) <= 30) {
                $userRepository->updateUsername($user->getId(), $newUsername);
                http_response_code(200); // Succès
                exit;
            } else {
                http_response_code(400); // Mauvaise requête
                exit;
            }
        }

        $email = $user->getEmail();

        $this->view('profile.html.twig', [
            'user' => $user,
            'currentNotification' => $currentNotification,
            'email' => $email,
        ]);
    }
}