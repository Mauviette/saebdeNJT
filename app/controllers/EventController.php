<?php

require_once './app/core/Controller.php';
require_once './app/entities/Event.php';
require_once './app/repositories/EventRepository.php';

class EventController extends Controller {

    public function event() {
        $id = $_GET['view'] ?? null;

        if ($id === null || !is_numeric($id)) {
            throw new Exception('Id invalide');
        }

        $eventRepository = new EventRepository();
        $event = $eventRepository->findById((int)$id);

        $this->view('event.html.twig', [
            'event' => $event]
        );
    }
}
