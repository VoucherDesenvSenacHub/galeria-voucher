<?php
$arquivo = fopen("desenvolvedores.csv", "r");

$desenvolvedores = [];
$orientadores = [];

fgetcsv($arquivo); 


while (($linha = fgetcsv($arquivo)) !== false) {
    $pessoa = [
        'nome'     => $linha[1],  
        'funcao'   => $linha[2],
        'github'   => $linha[3],
        'linkedin' => $linha[4],
        'foto'     => $linha[5]
    ];

    
    if (strtolower(trim($pessoa['funcao'])) === 'orientador') {
        $orientadores[] = $pessoa;
    } else {
        $desenvolvedores[] = $pessoa;
    }
}

fclose($arquivo);


usort($desenvolvedores, fn($a, $b) => strcasecmp($a['nome'], $b['nome']));
usort($orientadores, fn($a, $b) => strcasecmp($a['nome'], $b['nome']));

// Ai so irem no navegaodr e pegar o array gerado, pra acessar --> http://localhost/galeria-voucher/App/View/componentes/users/import/import.php
echo "<pre>\n\$desenvolvedores = " . var_export($desenvolvedores, true) . ";\n</pre>";
echo "<pre>\n\$orientadores = " . var_export($orientadores, true) . ";\n</pre>";
?>
