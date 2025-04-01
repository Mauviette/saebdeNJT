<?php

require_once './app/core/Controller.php';
require_once './app/services/AuthService.php';

class RegisterController extends Controller {
    public function register(){
		$this->view("register.html.twig");
	}
}
