<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ItemRepository.php';

class ShopController extends Controller {
    public function shop() {

        $items = (new ItemRepository())->findAll();

        error_log($items[0]->getName());

        $this->view('shop.html.twig', [
            'items' => $items,
            'categories' => (new ItemRepository())->findAllCategory()
        ]);
    }
}