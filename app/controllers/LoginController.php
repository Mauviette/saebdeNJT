<?php

require_once './app/core/Controller.php';
require_once './app/services/AuthService.php';

class LoginController extends Controller {
    public function login(){
		$this->view("login.html.twig");
	}
}
