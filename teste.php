<?php 

header("Content-Type: application/json");

$dados = [
    ["nome" => "joao"],
    ["nome" => "henrique"],
    ["nome" => "gustavo"]
];

// termo buscado vindo do input
$termo = isset($_GET['busca']) ? strtolower($_GET['busca']) : "";

// se não retorna nada, volta lista vazia
if ($termo === "") {
    echo json_encode([], JSON_UNESCAPED_UNICODE);
    exit;
}

// exibe apenas quem tem o termo
$resultado = array_filter($dados, function($item) use ($termo) {
    return strpos(strtolower($item["nome"]), $termo) !== false;
});

// mostra o array e envia 
echo json_encode(array_values($resultado), JSON_UNESCAPED_UNICODE);
