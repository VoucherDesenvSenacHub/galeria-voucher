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

            $_SESSION['sucesso_projeto'] = "Projeto '{$nomeProjeto}' cadastrado com sucesso!";
            Redirect::toAdm('projetos.php', ['turma_id' => $turmaId]);

        } catch (\Exception $e) {
            $this->projetoModel->getPDO()->rollBack();
            return;
        }
        // Fim salvamentos
    }
}

$action = Request::post('action');

if (isset($action) && $action === 'salvar') {
    $controller = new ProjetoController();
    $controller->salvar();
} else {
    $_SESSION['erro_projeto'] = "Ação desconhecida.";
    $turmaIdFallback = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT) ?: filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($turmaIdFallback) {
        Redirect::toAdm('projetos.php', ['turma_id' => $turmaIdFallback]);
    } else {
        Redirect::toAdm('turmas.php');
    }
}
