<?php 
function PrimaryButton($type = 'button', $content = '') {
    // Escapa o conteúdo para evitar XSS
    $safe_content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
    // Valida o tipo de botão
    $valid_types = ['button', 'submit', 'reset'];
    $button_type = in_array($type, $valid_types) ? $type : 'button';
    
    echo "<button class='primary-button' type='$button_type'>$safe_content</button>";
}
?>