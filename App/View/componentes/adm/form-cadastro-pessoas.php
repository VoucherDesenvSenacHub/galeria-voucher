<?php
header('Content-Type: text/html; charset=UTF-8');

$classificacao = $_GET['classificacao'] ?? '';

require_once __DIR__ . '/../input.php';
require_once __DIR__ . '/../../../Model/TurmaModel.php';
$modelTurma = new TurmaModel();
$turmas = $modelTurma->buscarTodasTurmasComPolo();

if ($classificacao === 'aluno') {
?>
    <form id="form-cadastro-pessoa" action="/galeria-voucher/app/Controls/AlunoController.php?acao=teste" method="post">
        <span>
            <label for="pesquisar-pessoa-aluno">Pesquisar aluno:</label>
            <?php inputComponent('text', 'pesquisar-pessoa-aluno', 'Digite um nome'); ?>
            <div id="sugestoes-aluno"></div>
        </span>
        <div id="alunos-selecionadas"></div>
        <select name="Turmas">
            <option value="">SELECIONE UMA TURMA</option>
            <?php foreach($turmas as $turma): ?>
                <option value="<?= $turma['turma_id'];?>"><?= $turma['NOME_TURMA'];?></option>
            <?php endforeach; ?>
        </select>
        <button class="primary-button" type="submit">Vincular</button>
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
        <button class="primary-button" type="submit">Vincular</button>
    </form>
<?php
} else {
    echo '<p>Nenhum formulário disponível para esta classificação.</p>';
}
?>
