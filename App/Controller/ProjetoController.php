<?php
session_start();

require_once __DIR__ . '/../Config/Config.php';
require_once __DIR__ . '/../Helpers/Redirect.php';
require_once __DIR__ . '/../Helpers/Request.php';
require_once __DIR__ . '/../Model/ProjetoModel.php';
require_once __DIR__ . '/../Model/ImagemModel.php';
require_once __DIR__ . '/../Model/ImagemProjetoDiaModel.php';
require_once __DIR__ . '/../Service/ImagensUploadService.php';
require_once __DIR__ . '/ValidarLoginController.php';

class ProjetoController
{

    private ImagensUploadService $uploadService;
    private ProjetoModel $projetoModel;
    private ImagemModel $imagemModel;

    public function __construct()
    {
        $this->uploadService = new ImagensUploadService();
        $this->projetoModel = new ProjetoModel();
        $this->imagemModel = new ImagemModel();
    }

    public function salvar()
    {
        // Inicio Validações
        ValidarLoginController::validarAdminRedirect(Config::getDirAdm() . 'login.php');

        $turmaId = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
        $nomeProjeto = trim(Request::post('nome_projeto', ''));
        $descricaoProjeto = trim(Request::post('descricao_projeto', ''));
        $linkProjeto = trim(Request::post('link_projeto', ''));

        $dias = [
            'I' => ['descricao' => trim(Request::post('descricao_dia_i', '')), 'imagem' => Request::file('imagem_dia_i')],
            'P' => ['descricao' => trim(Request::post('descricao_dia_p', '')), 'imagem' => Request::file('imagem_dia_p')],
            'E' => ['descricao' => trim(Request::post('descricao_dia_e', '')), 'imagem' => Request::file('imagem_dia_e')]
        ];

        $erros = [];
        if (!$turmaId)
            $erros[] = "ID da turma inválido.";
        if (empty($nomeProjeto))
            $erros[] = "O nome do projeto é obrigatório.";
        if (!empty($linkProjeto) && !filter_var($linkProjeto, FILTER_VALIDATE_URL))
            $erros[] = "O link do projeto parece ser inválido.";

        $peloMenosUmDiaPreenchido = false;
        foreach ($dias as $dia) {
            if (!empty($dia['descricao']) || ($dia['imagem'] && $dia['imagem']['error'] === UPLOAD_ERR_OK)) {
                $peloMenosUmDiaPreenchido = true;
                break;
            }
        }
        if (!$peloMenosUmDiaPreenchido)
            $erros[] = "É necessário preencher a descrição ou enviar uma imagem para pelo menos uma das fases (Dia I, P ou E).";

        $dadosProjeto = [
            'nome' => $nomeProjeto,
            'descricao' => $descricaoProjeto,
            'link' => $linkProjeto,
            'turma_id' => $turmaId,
            'dias' => []
        ];
        // Fim validações

        // Inicio Salvamentos
        try {

            $this->projetoModel->getPDO()->beginTransaction();
            foreach ($dias as $tipoDia => $diaData) {
                $imagemId = null;
                if ($diaData['imagem'] && $diaData['imagem']['error'] === UPLOAD_ERR_OK) {
                    $resultadoUpload = $this->uploadService->salvar($diaData['imagem'], 'projeto-' . $tipoDia);
                    if ($resultadoUpload['success']) {
                        $novoImagemId = $this->imagemModel->criarImagem($resultadoUpload['caminho'], null, "Imagem do Projeto {$nomeProjeto} - Dia {$tipoDia}");
                    } else {
                        $erros[] = "Erro no upload da imagem do Dia {$tipoDia}: " . $resultadoUpload['erro'];
                    }
                }

                if (!empty($diaData['descricao']) || $novoImagemId !== null) {
                    $dadosProjeto['dias'][$tipoDia] = [
                        'descricao' => $diaData['descricao'],
                        'imagem_id' => $novoImagemId
                    ];
                }
            }

            if (!empty($erros)) {
                $_SESSION['erro_projeto'] = $erros;
                // Limpa arquivos que possam ter sido enviados se o processo falhou
                foreach ($dadosProjeto['dias'] as $dia) {
                    if (isset($dia['imagem_id']) && $dia['imagem_id']) {
                        $imgInfo = $this->imagemModel->buscarImagemPorId($dia['imagem_id']);
                        if ($imgInfo && file_exists(__DIR__ . '/../../' . $imgInfo['url'])) {
                            unlink(__DIR__ . '/../../' . $imgInfo['url']);
                        }
                        $this->imagemModel->deletarImagem($dia['imagem_id']);
                    }
                }
                Redirect::toAdm('cadastroProjetos.php', ['turma_id' => $turmaId]);
                exit;
            }

            $resultado = $this->projetoModel->criarProjetoCompleto($dadosProjeto);

            $this->projetoModel->getPDO()->commit();

            $_SESSION['sucesso_projeto'] = "Projeto $nomeProjeto cadastrado com sucesso!";
            Redirect::toAdm('projetos.php', ['turma_id' => $turmaId]);

        } catch (\Exception $e) {
            $this->projetoModel->getPDO()->rollBack();
            return;
        }
        // Fim salvamentos
    }

   public function editar()
    {
        // -----------------------------
        // CAMPOS BÁSICOS
        // -----------------------------
        $turmaId   = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
        $projetoId = filter_input(INPUT_POST, 'projeto_id', FILTER_VALIDATE_INT);

        $nomeProjeto      = trim(Request::post('nome_projeto', ''));
        $descricaoProjeto = trim(Request::post('descricao_projeto', ''));
        $linkProjeto      = trim(Request::post('link_projeto', ''));

        // -----------------------------
        // FUNÇÃO AUXILIAR
        // -----------------------------
        $getInt = function ($name) {
            $raw = filter_input(INPUT_POST, $name, FILTER_DEFAULT);

            return ($raw === '' || $raw === null)
                ? null
                : filter_var($raw, FILTER_VALIDATE_INT);
        };

        // -----------------------------
        // IDS DE DIA E IMAGENS EXISTENTES
        // -----------------------------
        $id_dia_projeto_i = $getInt('id_dia_projeto_i');
        $img_id_i         = $getInt('img_id_i');

        $id_dia_projeto_p = $getInt('id_dia_projeto_p');
        $img_id_p         = $getInt('img_id_p');

        $id_dia_projeto_e = $getInt('id_dia_projeto_e');
        $img_id_e         = $getInt('img_id_e');

        // -----------------------------
        // DESCRIÇÃO DOS DIAS (IGUAL SALVAR)
        // -----------------------------
        $descricao_dia_i = trim(Request::post('descricao_dia_i', ''));
        $descricao_dia_p = trim(Request::post('descricao_dia_p', ''));
        $descricao_dia_e = trim(Request::post('descricao_dia_e', ''));

        // -----------------------------
        // ARQUIVOS DE IMAGENS ALTERADOS (SE O USUÁRIO TROCAR)
        // -----------------------------
        $imagem_dia_i = Request::file('imagem_dia_i');
        $imagem_dia_p = Request::file('imagem_dia_p');
        $imagem_dia_e = Request::file('imagem_dia_e');

        // -----------------------------
        // VAR_DUMP COMPLETO
        // -----------------------------
        var_dump([
            'turmaId' => $turmaId,
            'projetoId' => $projetoId,

            'nomeProjeto' => $nomeProjeto,
            'descricaoProjeto' => $descricaoProjeto,
            'linkProjeto' => $linkProjeto,

            'dias' => [
                'I' => [
                    'id_dia_projeto' => $id_dia_projeto_i,
                    'img_id' => $img_id_i,
                    'descricao' => $descricao_dia_i,
                    'arquivo_enviado' => $imagem_dia_i
                ],
                'P' => [
                    'id_dia_projeto' => $id_dia_projeto_p,
                    'img_id' => $img_id_p,
                    'descricao' => $descricao_dia_p,
                    'arquivo_enviado' => $imagem_dia_p
                ],
                'E' => [
                    'id_dia_projeto' => $id_dia_projeto_e,
                    'img_id' => $img_id_e,
                    'descricao' => $descricao_dia_e,
                    'arquivo_enviado' => $imagem_dia_e
                ],
            ]
        ]);
        exit;
    }


    public function excluir()
    {
        // Validação de login (pode ajustar conforme necessário)
        ValidarLoginController::validarAdminRedirect(Config::getDirAdm() . 'login.php');

        $projetoId = filter_input(INPUT_POST, 'projeto_id', FILTER_VALIDATE_INT);
        $turmaId = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT); // Para redirecionar de volta

        // Define os parâmetros de redirecionamento
        $redirectParams = $turmaId ? ['turma_id' => $turmaId] : [];

        if (!$projetoId) {
            $_SESSION['erro_projeto'] = "ID do projeto inválido.";
            Redirect::toAdm('projetos.php', $redirectParams);
            return;
        }

        // Chama o novo método do model
        $resultado = $this->projetoModel->excluirProjeto($projetoId);

        if ($resultado) {
            $_SESSION['sucesso_projeto'] = "Projeto excluído com sucesso!";
        } else {
            $_SESSION['erro_projeto'] = "Erro ao excluir o projeto.";
        }

        // Redireciona de volta para a lista de projetos da turma
        Redirect::toAdm('projetos.php', $redirectParams);
    }

}

$action = Request::post('action'); // Ações de salvar e excluir vêm via POST

if (isset($action)) {
    $controller = new ProjetoController();

    if ($action === 'salvar') {
        $controller->salvar();
    } elseif ($action === 'excluir') {
        $controller->excluir(); // Adiciona a rota para a exclusão
    } elseif ($action === 'editar'){
        $controller->editar();
    }
    else {
        // Ação POST desconhecida
        $_SESSION['erro_projeto'] = "Ação POST desconhecida.";
        $turmaIdFallback = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT) ?: filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($turmaIdFallback) {
            Redirect::toAdm('projetos.php', ['turma_id' => $turmaIdFallback]);
        } else {
            Redirect::toAdm('turmas.php');
        }
    }
} else {
    // Nenhuma ação POST (provavelmente um GET indevido na raiz do controller)
    $_SESSION['erro_projeto'] = "Ação desconhecida.";
    $turmaIdFallback = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Tenta pegar de GET
    if ($turmaIdFallback) {
        Redirect::toAdm('projetos.php', ['turma_id' => $turmaIdFallback]);
    } else {
        Redirect::toAdm('turmas.php');
    }
}