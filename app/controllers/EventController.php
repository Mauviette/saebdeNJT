<?php

require_once './app/core/Controller.php';
require_once './app/entities/Event.php';
require_once './app/repositories/EventRepository.php';
require_once './app/entities/Comment.php';
require_once './app/entities/User.php';
require_once './app/repositories/CommentRepository.php';
require_once './app/repositories/UserRepository.php';

class EventController extends Controller {

    public function event() {
        $id = $_GET['view'] ?? null;

        if ($id === null || !is_numeric($id)) {
            throw new Exception('Id invalide');
        }

        $eventRepository = new EventRepository();
        $event = $eventRepository->findById((int)$id);

        $eventIsPassed = false;
        if ($event) {
            $eventDate = $event->getDate();
            $currentDate = new DateTime();
            if ($eventDate < $currentDate) {
                $eventIsPassed = true;
            }
        }

        $commentRepository = new CommentRepository();
        $commentaires = $commentRepository->findAllByEventId($event->getId());
        $userRepository = new UserRepository();
        foreach ($commentaires as $commentaire) {
            $user = $userRepository->getUserByID($commentaire->getIdUtilisateur());
            if ($user) {
                $commentaire->setUsername($user->getNom());
                error_log("Nom d'utilisateur : " . $commentaire->getUsername());
            }
        }

        $this->view('event.html.twig', [
            'event' => $event,
            'eventIsPassed' => $eventIsPassed,
            'commentaires' => $commentaires
            ]
        );
    }
}
