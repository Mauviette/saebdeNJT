<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ContactRepository.php';
require_once './app/entities/Contact.php';
require_once './app/repositories/UserRepository.php';
require_once './app/entities/User.php';
require_once './app/services/AuthService.php';

class AdminController extends Controller {

    public function menu() {
        $contactRepository = new ContactRepository();
        $contacts = $contactRepository->findAll();

        $contact_id = $_GET['contact_id'] ?? null;
        $selected_contact = null;

        $userRepository = new UserRepository();
        $users = $userRepository->findAll();

        $authService = new AuthService();
        $user = $authService->getUser();

        if ($contact_id !== null) {
            foreach ($contacts as $contact) {
            if ($contact->getIdContact() == $contact_id) {
                $selected_contact = $contact;
                $userAffichage = $userRepository->getUserById($contact->getIdUtilisateur())->getNom();
                $dateAffichage = $contact->getDateCreation()->format('d/m/Y H:i:s');
                break;
            }
            }
        }

        $this->view('admin.html.twig', ['contacts' => $contacts,
            'selected_contact' => $selected_contact,
            'userAffichage' => $userAffichage,
            'dateAffichage' => $dateAffichage,
            'users' => $users,
            'user' => $user,
            ]
        );
    }
}
