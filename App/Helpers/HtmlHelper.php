<?php
namespace App\Helpers;

/**
 * Renderiza um botão de subtabs (dias/projeto).
 * 
 * @param array $dia Dados do dia.
 * @param int $index Índice do dia para controle de ativo.
 * @param int $projetoId ID do projeto relacionado.
 * @param string|null $linkProjeto Link opcional para o projeto do dia.
 */
function renderSubTabBtn(array $dia, int $index, int $projetoId, ?string $linkProjeto = null): void {
    $btnClass = $index === 0 ? 'active' : '';
    $btnLabel = 'DIA ' . htmlspecialchars($dia['tipo_dia']);
    $dataSubtab = $dia['projeto_dia_id'];
    ?>
    <div class="galeria-turma-sub-tab-wrapper" style="display: inline-flex; align-items: center; gap: 8px; margin-right: 10px;">
        <button class="galeria-turma-sub-tab-btn <?= $btnClass ?>"
                data-subtab="<?= $dataSubtab ?>"
                data-projeto="<?= $projetoId ?>">
            <?= $btnLabel ?>
        </button>
        <?php if (!empty($linkProjeto)): ?>
            <button class="galeria-turma-btn ver-projeto-btn"
                    type="button"
                    onclick="window.open('<?= htmlspecialchars($linkProjeto) ?>', '_blank')">
                Ver Projeto
            </button>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Renderiza o botão do repositório da aba final.
 * 
 * @param array $projeto Dados do projeto.
 * @param array $dias Lista de dias do projeto.
 */
function renderRepoBtn(array $projeto, array $dias): void {
    $hasLinkProjeto = !empty($projeto['linkProjeto']);
    $activeClass = empty($dias) ? 'active' : '';
    ?>
    <div class="galeria-turma-sub-tab-wrapper" style="display: inline-flex; align-items: center; gap: 8px; margin-right: 10px;">
        <?php if ($hasLinkProjeto): ?>
            <button class="galeria-turma-sub-tab-btn"
                    type="button"
                    onclick="window.open('<?= htmlspecialchars($projeto['linkProjeto']) ?>', '_blank')">
                REPOSITÓRIO
            </button>
        <?php else: ?>
            <button class="galeria-turma-sub-tab-btn <?= $activeClass ?>"
                    data-subtab="projeto-<?= $projeto['projeto_id'] ?>"
                    data-projeto="<?= $projeto['projeto_id'] ?>">
                REPOSITÓRIO
            </button>
        <?php endif; ?>
    </div>
    <?php
}
