<?php
$pessoas = ['Manoel Victor', 'Amanda Lima', 'José Pereira', 'Lucas Silva', 'Thauanny Souza'];

header('Content-Type: text/html; charset=UTF-8');

$classificacao = $_GET['classificacao'] ?? '';

if ($classificacao === 'aluno') {
    echo '
    <form id="form-cadastro-pessoa" action="">
        <span> 
            <label for="pesquisar-pessoa">Pesquisar aluno:</label>
            <input type="text" id="pesquisar-pessoa" placeholder="Digite um nome" autocomplete="off">
            <div id="sugestoes"></div>
        </span>
        <div id="pessoas-selecionadas"></div>
        <button class="primary-button" type="submit">Cadastrar</button>
    </form>
    ';
} elseif ($classificacao === 'professor') {
    echo '
    <form id="form-cadastro-pessoa" action="">
        <span> 
            <label for="pesquisar-pessoa">Pesquisar professor:</label>
            <input type="text" id="pesquisar-pessoa" placeholder="Digite um nome" autocomplete="off">
            <div id="sugestoes"></div>
        </span>
        <div id="pessoas-selecionadas"></div>
        <button class="primary-button" type="submit">Cadastrar</button>
    </form>
    ';
} else {
    echo '<p>Nenhum formulário disponível para esta classificação.</p>';
}
