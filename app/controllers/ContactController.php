<?php

require_once './app/core/Controller.php';
require_once './app/trait/FormTrait.php';
require_once './app/trait/AuthTrait.php';

class ContactController extends Controller {
    use FormTrait;
    use AuthTrait;

    public function about() {
        $this->view('contact.html.twig'); // Affiche la vue login.php
    }
}
