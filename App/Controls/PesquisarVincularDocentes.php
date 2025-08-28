<?php 
require_once  __DIR__ .  "/../Model/TurmaModel.php";


if (isset($_GET['busca'])) {
    $turmaModel = new DocenteModel();
    $turmaModel->PesquisarDocente($nomePessoa);

}




?>