<?php
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
headerComponent("Voucher Desenvolvedor - Turma");
require_once __DIR__ . "/../../../componentes/adm/auth.php";
require_once __DIR__ . "/../../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../../../Model/PoloModel.php";

// --- LÓGICA PARA MODO EDIÇÃO VS CRIAÇÃO ---
$modoEdicao = false;
$turma = null;
$tituloPagina = "Cadastro de Turma";
$actionUrl = VARIAVEIS['APP_URL'] . "App/Controls/TurmaController.php?action=salvar";

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $modoEdicao = true;
    $turmaModel = new TurmaModel();
    $turma = $turmaModel->buscarPorId($_GET['id']);
    $tituloPagina = "Editar Turma";
    $actionUrl = VARIAVEIS['APP_URL'] . "App/Controls/TurmaController.php?action=atualizar";
}

// Busca os polos para o dropdown
$poloModel = new PoloModel();
$polos = $poloModel->buscarTodos();

headerComponent($tituloPagina);
?>

<body class="body-adm">
  <div class="container-adm">
    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>
    <?php
    $isAdmin = true; 
    require_once __DIR__ . "/../../../componentes/nav.php";
    ?>
    <main class="main-turmas-turmas">
        <form id="form-turma" method="POST" action="<?= $actionUrl ?>" enctype="multipart/form-data">
            
            <?php if ($modoEdicao): ?>
                <input type="hidden" name="turma_id" value="<?= htmlspecialchars($turma['turma_id']) ?>">
                <input type="hidden" name="imagem_id_atual" value="<?= htmlspecialchars($turma['imagem_id']) ?>">
            <?php endif; ?>

            <h1><?= $modoEdicao ? 'EDITAR TURMA' : 'CADASTRO DE TURMA' ?></h1>
            
            <input type="text" name="nome" placeholder="Nome da Turma" value="<?= htmlspecialchars($turma['nome'] ?? '') ?>" required>
            <textarea name="descricao" placeholder="Descrição"><?= htmlspecialchars($turma['descricao'] ?? '') ?></textarea>
            <input type="date" name="data_inicio" value="<?= htmlspecialchars($turma['data_inicio'] ?? '') ?>" required>
            <input type="date" name="data_fim" value="<?= htmlspecialchars($turma['data_fim'] ?? '') ?>">
            
            <select name="polo_id" required>
                <option value="">Selecione um Polo</option>
                <?php foreach ($polos as $polo): ?>
                    <option value="<?= $polo['polo_id'] ?>" <?= (isset($turma) && $polo['polo_id'] == $turma['polo_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($polo['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <input type="file" name="imagem_turma">
            
            <button type="submit"><?= $modoEdicao ? 'Atualizar' : 'Cadastrar' ?></button>
        </form>
    </main>
  </div>
</body>
</html>