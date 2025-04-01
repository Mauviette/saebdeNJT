<?php

require_once './app/core/Controller.php';

class ProfileController extends Controller {
 
    public function profile() {
        $this->view('profile.html.twig'); // Affiche la vue login.php
    }
}