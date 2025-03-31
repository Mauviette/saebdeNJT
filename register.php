<?php
require_once './app/controllers/RegisterController.php';

// Créez une instance de AuthController et appelez la méthode login()
(new RegisterController())->register();