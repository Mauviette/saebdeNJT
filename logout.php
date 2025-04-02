<?php
require_once './app/services/AuthService.php';

$authService = new AuthService();
$authService->logout();
