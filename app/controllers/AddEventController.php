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
            $image = $_POST['eventImage'] ?? null;

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

            if ($image) {
                $uploadDir = './assets/images/events/';
                $uploadFile = $uploadDir . basename($_FILES['eventImage']['name']);

                if (move_uploaded_file($_POST['eventImage'], $uploadFile)) {
                    // Optionally, save the image path to the database or perform other actions
                } else {
                    error_log('Failed to upload the image.');
                }
            }

                header('Location: /index.php');
                exit;
            } else {
                error_log('Subject, content, address,date and price are required.');
            }
        }

        $this->view('add_event.html.twig', ['error' => $error ?? null]);
    }
}