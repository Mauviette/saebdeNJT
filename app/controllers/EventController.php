<?php

require_once './app/core/Controller.php';

class EventController extends Controller {

    public function event() {
        $this->view('event.html.twig'); // Affiche la vue login.php
    }
}
