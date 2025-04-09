<?php 
function buttonComponent($style, $content) {
    if ($style === 'primary') {
        $class = 'primary-button';
        $type = 'submit';
    } elseif ($style === 'secondary') {
        $class = 'secondary-button';
        $type = 'button';
    } else {
        $class = 'primary-button';
        $type = 'button';
    }
    
    echo "<button class='$class' type='$type'>$content</button>";
}
?>