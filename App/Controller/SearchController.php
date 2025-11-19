<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Model/SearchModel.php';

class SearchController extends BaseController
{
    protected array $metodosPermitidos = ['GET'];
    private SearchModel $searchModel;

    public function __construct()
    {
        $this->searchModel = new SearchModel();
    }

    public function gerenciarRequisicao(): void
    {
        switch($_SERVER['REQUEST_METHOD']){
            case 'GET':
                $this->gerenciarGet();
                break;
            default:
                $this->gerenciarMetodosNaoPermitidos();
                break;
        }
    }

    private function gerenciarGet(): void
    {
        try {
            $q = $this->getParam('q', '');
            
            if (empty($q)) {
                $this->toJson(['results' => []]);
            }
            
            // Busca turmas e pessoas
            $turmas = $this->searchModel->searchTurmas($q);
            $pessoas = $this->searchModel->searchPessoas($q);

            // Normaliza saída
            $results = [];
            foreach ($turmas as $t) {
                $results[] = [
                    'tipo' => 'turma',
                    'titulo' => $t['titulo'],
                    'turma_id' => (int)$t['turma_id'],
                    'descricao' => $t['descricao'] ?? null
                ];
            }
            foreach ($pessoas as $p) {
                $results[] = [
                    'tipo' => 'pessoa',
                    'titulo' => $p['titulo'],
                    'turma_id' => (int)$p['turma_id'],
                    'descricao' => $p['perfil']
                ];
            }

            $this->toJson(['results' => $results]);
        } catch (Throwable $e) {
            $this->toJson([
                'error' => 'Erro ao buscar',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    private function getParam(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }
}

$searchController = new SearchController();
$searchController->gerenciarRequisicao();