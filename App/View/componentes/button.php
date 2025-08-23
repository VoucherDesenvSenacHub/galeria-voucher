<?php 
/**
 * Gera um botão HTML com estilo e tipo personalizados.
 *
 * @param string $style    Define o estilo do botão ('primary' ou 'secondary').
 * @param string $content  Conteúdo (texto ou HTML) que será exibido dentro do botão.
 * @param bool|string $isSubmit (Opcional) Define se o botão será do tipo 'submit' (true), 'reset' (string 'reset') ou 'button' (false). Padrão: false.
 * @param string $link     (Opcional) URL para o link. Se fornecido, renderiza um elemento <a> ao invés de <button>.
 * @param string $action   (Opcional) URL para a action do formulário quando o botão for submit.
 * @param string $extraAttributes (Opcional) Atributos adicionais para injetar no elemento renderizado (id, onclick, data-*, etc.).
 *
 * Exemplo de uso:
 * buttonComponent('primary', 'Salvar');                      // botão verde padrão
 * buttonComponent('secondary', '<i>Cancelar</i>');           // botão secundário (branco) com HTML
 * buttonComponent('primary', 'Enviar', true);                // botão verde do tipo submit
 * buttonComponent('secondary', 'Cancelar', 'reset');         // botão para resetar o formulário
 * buttonComponent('primary', 'Entrar', false, '/home');      // link estilizado como botão
 */
function buttonComponent($style, $content, $isSubmit = false, $link = null, $action = null, $extraAttributes = '', $extraClass = '') {
    // Define a classe CSS com base no estilo informado
    if ($style === 'primary') {
        $class = 'primary-button';
    } elseif ($style === 'secondary') {
        $class = 'secondary-button';
    } else {
        $class = 'primary-button';
    }

    // Concatena a classe extra se existir
    if (!empty($extraClass)) {
        $class .= ' ' . $extraClass;
    }

    $type = $isSubmit ? 'submit' : 'button';

    
    // Define o type do botão
    if ($isSubmit === true) {
        $type = 'submit';
    } elseif ($isSubmit === 'reset') {
        $type = 'reset';
    } else {
        $type = 'button';
    }

    // Se um link for fornecido, renderiza um elemento <a>
    if ($link !== null) {
        echo "<a href='$link' class='$class' $extraAttributes>$content</a>";
    } else {
        $actionAttr = $action ? "formaction='$action'" : '';
        echo "<button class='$class' type='$type' $actionAttr $extraAttributes>$content</button>";
    }
}

?>
