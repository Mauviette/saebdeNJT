<?php

require_once './app/core/Controller.php';
require_once './app/repositories/EventRepository.php';
require_once './app/entities/Event.php';

class AddEventController extends Controller {
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject = $_POST['subject'] ?? null;
            $content = $_POST['content'] ?? null;
            $address = $_POST['address'] ?? null;
            $date = $_POST['date'] ?? null;
            $price = $_POST['price'] ?? null;

            if ($subject && $content && $address && $date && $price) {
                $eventRepository = new EventRepository();
                
                // 1. Création de l'événement (sans image)
                $eventRepository->createEvent(
                    $subject,
                    $content,
                    $address,
                    new DateTime($date),
                    $price
                );

                // 2. Récupérer l'ID de l'événement créé
                $event = $eventRepository->findByTitle($subject);
                if ($event) {
                    $eventId = $event->getId();

                    // 3. Vérification et sauvegarde de l'image
                    if (!empty($_FILES['eventImage']['name'])) {
                        $uploadDir = './assets/images/events/'; // Assure-toi que ce dossier existe
                        $imagePath = $uploadDir . $eventId . '.jpg'; // Forcer l'extension .jpg

                        // Vérifier si l'extension est valide
                        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                        $fileExtension = strtolower(pathinfo($_FILES['eventImage']['name'], PATHINFO_EXTENSION));

                        if (in_array($fileExtension, $allowedExtensions)) {
                            move_uploaded_file($_FILES['eventImage']['tmp_name'], $imagePath);
                        } else {
                            $error = "Format de fichier non autorisé.";
                        }
                    }
                }

                header('Location: /index.php');
                exit;
            }
        }

        $this->view('add_event.html.twig', ['error' => $error ?? null]);
    }
}
