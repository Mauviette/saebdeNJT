<?php

require_once './app/core/Controller.php';
require_once './app/entities/Purchase.php';
require_once './app/trait/FormTrait.php';
require_once './app/services/AuthService.php';
require_once './app/repositories/EventRepository.php';
require_once './app/entities/Event.php';

class ShopController extends Controller {

    public function items() 
    {
        $items = (new ItemRepository())->findAll();
    
        $this->view('shop.html.twig',[
            'title' => 'Le site du BDE',
            'events_upcoming' => array_filter($events, function ($event) {
                return $event->getDate() >= new DateTime();
            }),
            'events_passed' => array_filter($events, function ($event) {
                return $event->getDate() < new DateTime();
            })
        ]);
       }
}
