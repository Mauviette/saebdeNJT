<?php

require_once './app/core/Controller.php';
require_once './app/entities/Purchase.php';
require_once './app/trait/FormTrait.php';
require_once './app/services/AuthService.php';

class HomeController extends Controller
{
   use FormTrait;
   public function index()
   {
       $this->view('index.html.twig',  [
            'title' => 'Le site du BDE',
            'articles' => $articles,
            'purchases'=> array_map(static fn(string $purchase) => unserialize($purchase),$_SESSION['purchases']??[])
        ]);
   }
}
