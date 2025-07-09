<?php
header('Content-Type: text/html; charset=UTF-8');

$classificacao = $_GET['classificacao'] ?? '';

// Você pode montar o HTML dinamicamente com base na classificação, se quiser
if ($classificacao === 'aluno') {
    echo '
    <form action="">
        <label for="pesquisa-aluno">Pesquisar aluno</label>
        <input type="text" name="pesquisa-aluno">

        <select name="aluno">
            <option value="1">Thiago</option>
            <option value="2">Fernanda</option>
            <option value="3">Carlos</option>
            <option value="4">Juliana</option>
            <option value="5">Lucas</option>
        </select>

        <button type="submit">Cadastrar</button>
    </form>';
} elseif ($classificacao === 'professor') {
    echo '
    <form action="">
        <label for="pesquisa-prof">Pesquisar professor</label>
        <input type="text" name="pesquisa-prof">

        <select name="professor">
            <option value="1">Prof. Ana</option>
            <option value="2">Prof. Bruno</option>
        </select>

        <button type="submit">Cadastrar</button>
    </form>';
} else {
    echo '<p>Nenhum formulário disponível para esta classificação.</p>';
}
