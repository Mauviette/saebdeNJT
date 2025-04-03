<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ItemRepository.php';
require_once './app/entities/Item.php';

class AddProduitController extends Controller {
    public function add() {
        error_log("WOH CA RENTRE DANS LA FONCTION");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("WOH CA RENTRE DANS LA FONCTION POST");
            $name = $_POST['name'] ?? null;
            $price = $_POST['price'] ?? null;
            $stock = $_POST['stock'] ?? null;
            $category = $_POST['category'] ?? null;
            $productImage = $_FILES['ItemImage'] ?? null;
            $error = null;

            if ($name && $price && $category) {
                $ItemRepository = new ItemRepository();
                
                $ItemRepository->createItem($name, '', $price, $stock, $category);

                $Item = $ItemRepository->findByName($name);
                if ($Item) {
                    $ItemId = $Item->getId();

                    if (!empty($_FILES['ItemImage']['name'])) {
                        $uploadDir = './assets/images/items/';
                        $imagePath = $uploadDir . $ItemId . '.jpg';

                        // Vérifier si l'extension est valide
                        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                        $fileExtension = strtolower(pathinfo($_FILES['ItemImage']['name'], PATHINFO_EXTENSION));

                        if (in_array($fileExtension, $allowedExtensions)) {
                            move_uploaded_file($_FILES['ItemImage']['tmp_name'], $imagePath);
                        } else {
                            $error = "Format de fichier non autorisé.";
                        }
                    }
                }

                // Si une erreur est détectée, on ne redirige pas
                if ($error) {
                    error_log("WOH CA RENTRE DANS LA FONCTION POST ERREUR" + $error);
                    return $this->view('add_produit.html.twig', ['error' => $error]);
                }

                header('Location: /shop.php');
                exit;
            }
        }

        $this->view('add_produit.html.twig', ['error' => $error ?? null]);
    }
}
