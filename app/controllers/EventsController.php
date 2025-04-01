<?php

require_once './app/core/Controller.php';

class EventsController extends Controller {

    public function events() {
        $this->view('events.html.twig'); // Affiche la vue login.php
    }
}
