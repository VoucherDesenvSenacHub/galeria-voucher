<?php 
/**
 * Gera um botão HTML com estilo e tipo personalizados.
 *
 * @param string $style    Define o estilo do botão ('primary' ou 'secondary').
 * @param string $content  Conteúdo (texto ou HTML) que será exibido dentro do botão.
 * @param bool   $isSubmit (Opcional) Define se o botão será do tipo 'submit' (true) ou 'button' (false). Padrão: false.
 * @param string $link     (Opcional) URL para o link. Se fornecido, renderiza um elemento <a> ao invés de <button>.
 * @param string $action   (Opcional) URL para a action do formulário quando o botão for submit.
 *
 * Exemplo de uso:
 * buttonComponent('primary', 'Salvar');                      // botão verde padrão
 * buttonComponent('secondary', '<i>Cancelar</i>');           // botão secundário (branco) com HTML
 * buttonComponent('primary', 'Enviar', true);                // botão verde do tipo submit
 * buttonComponent('primary', 'Entrar', false, '/home');      // link estilizado como botão
 * buttonComponent('primary', 'Processar', true, null, '/processar'); // botão submit com action específica
 */
function buttonComponent($style, $content, $isSubmit = false, $link = null, $action = null) {
    // Define a classe CSS com base no estilo informado
    if ($style === 'primary') {
        $class = 'primary-button';
    } elseif ($style === 'secondary') {
        $class = 'secondary-button';
    } else {
        // Se o estilo for inválido, usa 'primary' como padrão
        $class = 'primary-button';
    }
    
    $type = $isSubmit ? 'submit' : 'button';
    
    // Se um link for fornecido, renderiza um elemento <a>
    if ($link !== null) {
        echo "<a href='$link' class='$class' style='text-decoration: none; display: inline-block; padding: 8px 16px; border-radius: 6px; cursor: pointer;'>$content</a>";
    } else {
        // Caso contrário, renderiza um <button>
        $formAction = $action !== null ? "formaction='$action'" : '';
        echo "<button class='$class' type='$type' $formAction>$content</button>";
    }
}
?>
