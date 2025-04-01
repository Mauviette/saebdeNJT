<?php

require_once './app/core/Controller.php';

class AddArticleController extends Controller {
    public function add() {
        $this->view('add_article.html.twig'); // Affiche la vue login.php
    }
}
