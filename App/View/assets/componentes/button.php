<?php 
function buttonComponent($style, $content, $isSubmit = false) {
    if ($style === 'primary') {
        $class = 'primary-button';
    } elseif ($style === 'secondary') {
        $class = 'secondary-button';
    } else {
        $class = 'primary-button';
    }
    
    $type = $isSubmit ? 'submit' : 'button';
    
    echo "<button class='$class' type='$type'>$content</button>";
}
?>