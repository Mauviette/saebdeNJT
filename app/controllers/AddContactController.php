<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ContactRepository.php';
require_once './app/entities/Contact.php';


class AddContactController extends Controller {
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['subject'] ?? null;
            $content = $_POST['content'] ?? null;
    
            if ($title && $content) {
                $authService = new AuthService();
                $user = $authService->getUser();  

                $contactRepository = new ContactRepository();
                $contactRepository->createContact(
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
        $this->view('contact.html.twig', ['error' => $error ?? null]);
    }
    
 
}
