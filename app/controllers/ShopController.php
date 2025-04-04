<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ItemRepository.php';
require_once './app/services/AuthService.php';

class ShopController extends Controller {
    public function shop() {
        
        $authService = new AuthService();
        $user = $authService->getUser();

        if (isset($_GET['delete_item'])) {
            if (!$user || !$user->isAdmin()) {
                $itemId = intval($_GET['delete_item']);
                $itemRepository = new ItemRepository();
                $itemRepository->deleteItem($itemId);
            }
            header('Location: /shop.php');
            exit;
        }

        $items = (new ItemRepository())->findAll();


        
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
            'userRole' => $user->getRole(),
            'isAdmin' => $user->isAdmin()
        ]);
    }
}