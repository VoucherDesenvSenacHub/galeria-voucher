<?php 

header("Content-Type: application/json");
echo json_encode([
    [
        "nome" => "joao"
    ],
    [
        "nome" => "henrique"
    ],
    [
        "nome" => "gustavo"
    ]
], JSON_UNESCAPED_UNICODE);