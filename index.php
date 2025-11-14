<?php
require_once __DIR__ . '/App/Config/Config.php'; // Garante que a classe Config esteja disponível

header('Location: ' . Config::getDirUser() . 'home.php');
?>
