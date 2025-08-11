<?php
require_once __DIR__ . '/../Service/GaleriaTurmaService.php';

class GaleriaTurmaController
{
    private GaleriaTurmaService $service;

    public function __construct()
    {
        $this->service = new GaleriaTurmaService();
    }

    public function mostrarTurma(int $turmaId)
    {
        $dados = $this->service->carregarDadosTurma($turmaId);

        if (!$dados) {
            header('Location: turma.php');
            exit;
        }

        return $dados;
    }
}