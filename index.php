<?php
require_once __DIR__ . '/App/Config/env.php';
require_once __DIR__ . '/App/Config/App.php'; // Garante que a classe Config esteja disponível

header('Location: ' . Config::get('APP_URL') . Config::get('DIR_USER') . 'home.php');
?>