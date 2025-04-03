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
            $error = null;

            if ($subject && $content && $address && $date && $price) {
                $eventRepository = new EventRepository();
                
                $eventRepository->createEvent(
                    $subject,
                    $content,
                    $address,
                    new DateTime($date),
                    $price
                );

                $event = $eventRepository->findByTitle($subject);
                if ($event) {
                    $eventId = $event->getId();

                    if (!empty($_FILES['eventImage']['name'])) {
                        $uploadDir = './assets/images/events/';
                        $imagePath = $uploadDir . $eventId . '.jpg';

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

                // Si une erreur est détectée, on ne redirige pas
                if ($error) {
                    return $this->view('add_event.html.twig', ['error' => $error]);
                }

                header('Location: /index.php');
                exit;
            }
        }

        $this->view('add_event.html.twig', ['error' => $error ?? null]);
    }
}
