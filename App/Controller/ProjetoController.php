<?php
session_start();

require_once __DIR__ . '/../Config/App.php';
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
        ValidarLoginController::validarAdminRedirect(Config::get('DIR_ADM') . 'login.php');

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
        foreach ($dias as $tipoDia => $diaData) {
            $imagemId = null;
            if ($diaData['imagem'] && $diaData['imagem']['error'] === UPLOAD_ERR_OK) {
                $resultadoUpload = $this->uploadService->salvar($diaData['imagem'], 'projeto-' . $tipoDia);
                if ($resultadoUpload['success']) {
                    $novoImagemId = $this->imagemModel->criarImagem($resultadoUpload['caminho'], null, "Imagem do Projeto {$nomeProjeto} - Dia {$tipoDia}");
                    if ($novoImagemId) {
                        $imagemId = $novoImagemId;
                    } else {
                        $erros[] = "Erro ao salvar informações da imagem do Dia {$tipoDia} no banco de dados.";
                    }
                } else {
                    $erros[] = "Erro no upload da imagem do Dia {$tipoDia}: " . $resultadoUpload['erro'];
                }
            }

            if (!empty($diaData['descricao']) || $imagemId !== null) {
                $dadosProjeto['dias'][$tipoDia] = [
                    'descricao' => $diaData['descricao'],
                    'imagem_id' => $imagemId
                ];
            }
        }

        if (empty($erros)) {

            $resultado = $this->projetoModel->criarProjetoCompleto($dadosProjeto);

            // AQUI ESTÁ A MUDANÇA PRINCIPAL:
            // Verificamos se o resultado é um número (ID do projeto) ou uma string (mensagem de erro)
            if (is_int($resultado)) {
                $_SESSION['sucesso_projeto'] = "Projeto '{$nomeProjeto}' cadastrado com sucesso!";
                Redirect::toAdm('cadastroTurmas/CadastroProjetos.php', ['id' => $turmaId]);
            } else {
                // Se for uma string, é a mensagem de erro detalhada do Model
                $erros[] = "Erro ao salvar o projeto no banco de dados: " . $resultado;

                // Habilita a exibição de erros na tela
                ini_set('display_errors', '1');

                // Habilita a exibição de erros de inicialização (startup errors)
                ini_set('display_startup_errors', '1');

                // Define o nível de erros que serão reportados (E_ALL reporta todos os erros e avisos)
                error_reporting(E_ALL);
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
            Redirect::toAdm('cadastroTurmas/Projeto.php', ['id' => $turmaId]);
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
        Redirect::toAdm('cadastroTurmas/CadastroProjetos.php', ['id' => $turmaIdFallback]);
    } else {
        Redirect::toAdm('listaTurmas.php');
    }
}