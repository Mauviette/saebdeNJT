<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ContactRepository.php';
require_once './app/entities/Contact.php';

class AdminController extends Controller {

    public function menu() {
        $contactRepository = new ContactRepository();
        $contacts = $contactRepository->getAllContacts();

        $contact_id = $_GET['contact_id'] ?? null;
        $selected_contact = null;

        if ($contact_id !== null) {
            foreach ($contacts as $contact) {
            if ($contact->getId() == $contact_id) {
                $selected_contact = $contact;
                break;
            }
            }
        }
        
        $this->view('admin.html.twig', ['contacts' => $contacts]);
    }
}
