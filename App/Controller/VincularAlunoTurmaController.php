<?php 
session_start();

require_once __DIR__ . '/../Config/env.php';
require_once __DIR__ . '/../Model/TurmaModel.php';
require_once __DIR__ . '/../Model/PessoaModel.php';

class VincularAlunoTurmaController {
    
    public function vincular() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            $_SESSION['erro'] = "Método não permitido.";
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
            exit();
        }
        
        $turmaId = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
        $pessoaIds = $_POST['pessoas_ids'] ?? [];
        
        if (!$turmaId || !is_array($pessoaIds) || empty($pessoaIds)) {
            $_SESSION['erro'] = "Dados inválidos. Selecione ao menos um aluno e tente novamente.";
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/alunos.php?id=' . $turmaId);
            exit();
        }

        $turmaModel = new TurmaModel();
        $pessoaModel = new PessoaModel();
        $poloIdTurma = $turmaModel->buscarPoloIdPorTurmaId($turmaId);
        
        $sucessos = [];
        $erros = [];

        foreach ($pessoaIds as $pessoaId) {
            $pessoaId = (int)$pessoaId;
            $pessoaInfo = $pessoaModel->buscarPessoaParaVinculo($pessoaId);
            
            if (!$pessoaInfo || $pessoaInfo['perfil'] !== 'aluno') {
                 $erros[] = "Pessoa ID {$pessoaId} não é um aluno válido ou não existe.";
                 continue;
            }

            // --- REGRA 1: Aluno de outro polo ---
            if ($poloIdTurma && $pessoaInfo['polo_atual_id'] && $poloIdTurma != $pessoaInfo['polo_atual_id']) {
                 $erros[] = "O aluno {$pessoaInfo['nome']} pertence a outro polo (ID: {$pessoaInfo['polo_atual_id']}) e não pode ser vinculado à esta turma (Polo ID: {$poloIdTurma}).";
                 continue;
            }

            // --- REGRA 3: Aluno em mais de uma turma ---
            if ($pessoaInfo['turma_atual_id'] !== null) {
                // Se a turma atual for a mesma que está sendo vinculada, ignora o erro
                if ((int)$pessoaInfo['turma_atual_id'] === $turmaId) {
                     $sucessos[] = "Aluno {$pessoaInfo['nome']} já está vinculado à esta turma. (Ignorado)";
                     continue;
                }
                $erros[] = "O aluno {$pessoaInfo['nome']} já está vinculado à turma ID: {$pessoaInfo['turma_atual_id']} e não pode ser matriculado em mais de uma.";
                continue;
            }
            
            // --- Se passou nas validações, insere o vínculo ---
            try {
                $pdo = $turmaModel->pdo; // Reutiliza a conexão PDO
                $sql = 'INSERT INTO aluno_turma (pessoa_id, turma_id, data_matricula) VALUES (:id_pessoa, :id_turma, NOW())';
                $stmt = $pdo->prepare($sql);
                
                if ($stmt->execute([':id_pessoa' => $pessoaId, ':id_turma' => $turmaId])) {
                     $sucessos[] = "Aluno {$pessoaInfo['nome']} vinculado com sucesso!";
                } else {
                     $erros[] = "Erro ao inserir vínculo para {$pessoaInfo['nome']}.";
                }
            } catch (PDOException $e) {
                 $erros[] = "Erro de BD ao vincular {$pessoaInfo['nome']}: " . $e->getMessage();
            }
        }

        if (!empty($erros)) {
            $_SESSION['erro'] = "Não foi possível vincular todos os alunos: " . implode(" | ", $erros);
        } elseif (!empty($sucessos)) {
            $_SESSION['sucesso'] = implode(" | ", $sucessos);
        } else {
            $_SESSION['erro'] = "Nenhuma ação realizada.";
        }

        header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/alunos.php?id=' . $turmaId);
        exit();
    }
}

$controller = new VincularAlunoTurmaController();
$controller->vincular();