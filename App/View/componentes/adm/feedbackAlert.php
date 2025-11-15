<?php
// Não precisa de session_start(), pois já foi iniciado no head.php

$feedback_message = '';
$feedback_type = ''; // 'success' ou 'error'

// Lista de chaves de sessão que queremos verificar
$session_keys = [
    'success' => [
        'sucesso_projeto',
        'sucesso_turma',
        'sucesso_exclusao',
        'sucesso_cadastro',
        'sucesso_edicao_alert',
        'sucesso' // Chave genérica
    ],
    'error' => [
        'erro_projeto',
        'erros_turma',
        'erro_turma',
        'erro' // Chave genérica
    ]
];

// Verifica chaves de SUCESSO
foreach ($session_keys['success'] as $key) {
    if (isset($_SESSION[$key])) {
        $feedback_message = $_SESSION[$key];
        $feedback_type = 'success';
        unset($_SESSION[$key]);
        break; // Para no primeiro que encontrar
    }
}

// Se não achou sucesso, verifica chaves de ERRO
if (empty($feedback_type)) {
    foreach ($session_keys['error'] as $key) {
        if (isset($_SESSION[$key])) {
            $feedback_message = $_SESSION[$key];
            $feedback_type = 'error';
            unset($_SESSION[$key]);
            break; // Para no primeiro que encontrar
        }
    }
}

// Se uma mensagem foi encontrada, renderiza o modal
if (!empty($feedback_message) && !empty($feedback_type)):

    // Trata mensagens que podem ser arrays (como 'erros_turma')
    if (is_array($feedback_message)) {
        $feedback_message = "Ocorreram os seguintes erros:\n\n- " . implode("\n- ", $feedback_message);
    }

    $title = ($feedback_type === 'success') ? 'Successo!' : 'Erro!';
    $button_text = ($feedback_type === 'success') ? 'Continuar' : 'Tentar Novamente';
?>

    <div class="feedback-overlay" id="feedbackOverlay">
        <div class="feedback-modal <?= htmlspecialchars($feedback_type) ?>" id="feedbackModal">
            <div class="feedback-header">
                <div class="feedback-icon"></div>
            </div>
            <div class="feedback-body">
                <h2 class="feedback-title"><?= $title ?></h2>
                <p class="feedback-text"><?= htmlspecialchars($feedback_message) ?></p>
            </div>
            <div class="feedback-footer">
                <button class="feedback-button" id="feedbackCloseButton"><?= $button_text ?></button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('feedbackOverlay');
            const modal = document.getElementById('feedbackModal');
            const closeButton = document.getElementById('feedbackCloseButton');

            function showModal() {
                if (overlay) overlay.classList.add('show');
            }

            function closeModal() {
                if (overlay) overlay.classList.remove('show');
            }

            // Exibe o modal assim que a página carregar
            showModal();

            // Fecha ao clicar no botão
            if (closeButton) {
                closeButton.addEventListener('click', closeModal);
            }

            // Fecha ao clicar fora do modal (no overlay)
            if (overlay) {
                overlay.addEventListener('click', function(e) {
                    if (e.target === overlay) {
                        closeModal();
                    }
                });
            }
        });
    </script>

<?php
endif;
?>