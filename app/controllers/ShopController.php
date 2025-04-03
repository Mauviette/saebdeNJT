<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ItemRepository.php';
require_once './app/services/AuthService.php';

class ShopController extends Controller {
    public function shop() {

        $items = (new ItemRepository())->findAll();

        $authService = new AuthService();
        $user = $authService->getUser();

        
        error_log($items[0]->getName());

        if(!$user) {
            $this->view('shop.html.twig', [
                'items' => $items,
                'categories' => (new ItemRepository())->findAllCategory()
            ]);
        }

        $this->view('shop.html.twig', [
            'items' => $items,
            'categories' => (new ItemRepository())->findAllCategory(),
            'userRole' => $user->getRole()
        ]);
    }
}