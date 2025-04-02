<?php

require_once './app/core/Controller.php';
require_once './app/entities/Purchase.php';
require_once './app/trait/FormTrait.php';
require_once './app/services/AuthService.php';
require_once './app/repositories/EventRepository.php';
require_once './app/entities/Event.php';

class EventsController extends Controller {

    public function events() 
    {
        $events = (new EventRepository())->findAll();
    
        usort($events, function ($a, $b) {
            $now = new DateTime();
            $dateA = $a->getDate();
            $dateB = $b->getDate();
    
            if ($dateA >= $now && $dateB < $now) {
                return -1;
            } elseif ($dateA < $now && $dateB >= $now) {
                return 1;
            } else {
                return $dateA <=> $dateB;
            }
        });
    
        $this->view('events.html.twig',[
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
