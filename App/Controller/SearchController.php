<?php

require_once __DIR__ . '/../Model/SearchModel.php';

class SearchController
{
    public function search()
    {
        header('Content-Type: application/json; charset=utf-8');

        $q = isset($_GET['q']) ? trim($_GET['q']) : '';

        if ($q === '' || mb_strlen($q) < 2) {
            echo json_encode(['results' => []]);
            exit;
        }

        try {
            $searchModel = new SearchModel();
            
            // Busca turmas e pessoas
            $turmas = $searchModel->searchTurmas($q);
            $pessoas = $searchModel->searchPessoas($q);

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
                    'descricao' => null
                ];
            }

            echo json_encode(['results' => $results]);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao buscar', 'details' => $e->getMessage()]);
        }
    }
}
