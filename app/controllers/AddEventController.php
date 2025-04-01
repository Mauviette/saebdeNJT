<?php

require_once './app/core/Controller.php';

class AddEventController extends Controller {

    public function add() {
        $this->view('add_event.html.twig'); // Affiche la vue login.php
    }
}
