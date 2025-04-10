<?php 
/**
 * Gera um botão HTML com estilo e tipo personalizados.
 *
 * @param string $style    Define o estilo do botão ('primary' ou 'secondary').
 * @param string $content  Conteúdo (texto ou HTML) que será exibido dentro do botão.
 * @param bool   $isSubmit (Opcional) Define se o botão será do tipo 'submit' (true) ou 'button' (false). Padrão: false.
 *
 * Exemplo de uso:
 * buttonComponent('primary', 'Salvar');                      // botão verde padrão
 * buttonComponent('secondary', '<i>Cancelar</i>');           // botão secundário (branco) com HTML
 * buttonComponent('primary', 'Enviar', true);                // botão verde do tipo submit
 */
function buttonComponent($style, $content, $isSubmit = false) {
    // Define a classe CSS com base no estilo informado
    if ($style === 'primary') {
        $class = 'primary-button';
    } elseif ($style === 'secondary') {
        $class = 'secondary-button';
    } else {
        // Se o estilo for inválido, usa 'primary' como padrão
        $class = 'primary-button';
    }
    
    // Define o tipo do botão: 'submit' ou 'button'
    $type = $isSubmit ? 'submit' : 'button';
    
    // Exibe o botão HTML com a classe e o conteúdo definidos
    echo "<button class='$class' type='$type'>$content</button>";
}
?>
