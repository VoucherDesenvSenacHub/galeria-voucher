<?php
require_once __DIR__ . '/App/config/env.php';

header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] . 'home.php');