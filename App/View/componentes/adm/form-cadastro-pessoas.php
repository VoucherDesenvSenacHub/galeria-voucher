<?php
$pessoas = ['Manoel Victor', 'Amanda Lima', 'José Pereira', 'Lucas Silva', 'Thauanny Souza'];

header('Content-Type: text/html; charset=UTF-8');

$classificacao = $_GET['classificacao'] ?? '';
$turmaId = isset($_GET['turma_id']) ? (int)$_GET['turma_id'] : null;

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
    <form id="form-cadastro-pessoa" method="POST" action="/galeria-voucher/App/Controls/VincularDocenteTurmaController.php">
        <span>
            <label for="pesquisar-pessoa">Pesquisar professor:</label>
            <?php inputComponent('text', 'pesquisar-pessoa', 'Digite um nome'); ?>
            <div id="sugestoes"></div>
        </span>
        <div id="pessoas-selecionadas"></div>

        <input type="hidden" name="turma_id" value="<?php echo htmlspecialchars($turmaId); ?>">

        <button class="primary-button" type="submit">Vincular Docentes</button>
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
