<?php
$pessoas = ['Manoel Victor', 'Amanda Lima', 'José Pereira', 'Lucas Silva', 'Thauanny Souza'];

header('Content-Type: text/html; charset=UTF-8');

$classificacao = $_GET['classificacao'] ?? '';

require_once __DIR__ . '/../input.php';

if ($classificacao === 'aluno') {
?>
    <form id="form-cadastro-pessoa" action="">
        <span>
            <label for="pesquisar-pessoa">Pesquisar aluno:</label>
            <?php inputComponent('text', 'pesquisar-pessoa', 'Digite um nome'); ?>
            <div id="sugestoes"></div>
        </span>
        <div id="pessoas-selecionadas"></div>
        <button class="primary-button" type="submit">Cadastrar</button>
    </form>
<?php
} elseif ($classificacao === 'professor') {
?>
    <form id="form-cadastro-pessoa" action="">
        <span>
            <label for="pesquisar-pessoa">Pesquisar professor:</label>
            <?php inputComponent('text', 'pesquisar-pessoa', 'Digite um nome'); ?>
            <div id="sugestoes"></div>
        </span>
        <div id="pessoas-selecionadas"></div>
        <button class="primary-button" type="submit">Cadastrar</button>
    </form>
<?php
} else {
    echo '<p>Nenhum formulário disponível para esta classificação.</p>';
}
?>

<script>
  const inputGerado = document.querySelector('input[name="pesquisar-pessoa"]');
  if (inputGerado) inputGerado.id = 'pesquisar-pessoa';
</script>
