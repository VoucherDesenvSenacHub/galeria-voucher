<?php
spl_autoload_register(function ($className) {

    // Prefixo base para aplicação (example: namespace App\Model)
    $prefix = 'App\\';

    $base_dir = __DIR__ . '/../../';

    // Verifica se classe possui o prefixo
    if (strncmp($prefix, $className, strlen($prefix)) !== 0) {
        return;
    }

    $relative_class = substr($className, strlen($prefix));

    //Troca \ por / e constroi o caminho do arquivo
    $file = $base_dir . str_replace('\\', '/', $className) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});