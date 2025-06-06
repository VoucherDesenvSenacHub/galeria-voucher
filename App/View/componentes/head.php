<?php 
require_once __DIR__ . '/./../../Config/env.php';

function header($titulo){
    echo "
    <!DOCTYPE html>
    <html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap' rel='stylesheet'>

    

    <link rel='stylesheet' href='<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_CSS'] ?>globals.css'>

    <title>$titulo</title>
</head>
";
}
    ?>