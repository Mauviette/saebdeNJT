<?php

require_once './app/core/Controller.php';

class ContactController extends Controller {

    public function about() {
        $this->view('contact.html.twig');
    }
}
