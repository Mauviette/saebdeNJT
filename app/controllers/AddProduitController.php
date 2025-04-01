<?php

require_once './app/core/Controller.php';

class AddProduitController extends Controller {

    public function add() {
        $this->view('add_produit.html.twig'); // Affiche la vue login.php
    }
}
