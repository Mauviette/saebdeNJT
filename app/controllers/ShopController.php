<?php

require_once './app/core/Controller.php';

class ShopController extends Controller {
    public function shop() {
        // Display update form
        $this->view('shop.html.twig');
    }
}
