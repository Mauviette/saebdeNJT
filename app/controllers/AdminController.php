<?php

require_once './app/core/Controller.php';

class AdminController extends Controller {

    public function menu() {
        $this->view('admin.html.twig'); // Affiche la vue login.php
    }
}
