<?php
// Inicia a sessão para usar variáveis de sessão (mensagens de erro/sucesso)
session_start();

// Includes necessários
require_once __DIR__ . '/../Config/App.php'; // Configurações da aplicação (URLs, diretórios)
require_once __DIR__ . '/../Helpers/Request.php'; // Helper para pegar dados da requisição (POST, GET, FILES)
require_once __DIR__ . '/../Helpers/Redirect.php'; // Helper para redirecionamentos
require_once __DIR__ . '/../Model/ProjetoModel.php'; // Modelo para interagir com a tabela 'projeto' e relacionadas
require_once __DIR__ . '/../Model/ImagemModel.php'; // Modelo para interagir com a tabela 'imagem'
require_once __DIR__ . '/../Service/ImagensUploadService.php'; // Serviço para lidar com upload de arquivos
require_once __DIR__ . '/ValidarLoginController.php'; // Controller para validar se o usuário está logado e tem permissão

class ProjetoController {

    private $projetoModel;
    private $imagemModel;
    private $uploadService;

    // Construtor: inicializa os modelos e o serviço, e valida o acesso do usuário
    public function __construct() {
        $this->projetoModel = new ProjetoModel();
        $this->imagemModel = new ImagemModel();
        $this->uploadService = new ImagensUploadService();
        // Garante que apenas usuários logados (admin ou professor) acessem este controller
        ValidarLoginController::validarAdminRedirect(Config::get('DIR_ADM') . 'login.php');
    }

    /**
     * Processa a requisição para salvar um novo projeto.
     */
    public function salvar() {
        // Verifica se a requisição é do tipo POST
        if (Request::getMethod() !== 'POST') {
            $_SESSION['erro_projeto'] = "Método inválido.";
            Redirect::toAdm('listaTurmas.php'); // Redireciona para um local seguro
            return;
        }

        // --- Coleta e validação inicial dos dados do formulário ---
        $turmaId = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT); // Pega e valida o ID da turma
        $nomeProjeto = trim(Request::post('nome_projeto', '')); // Pega o nome do projeto, remove espaços extras
        $descricaoProjeto = trim(Request::post('descricao_projeto', '')); // Pega a descrição do projeto
        $linkProjeto = trim(Request::post('link_projeto', '')); // Pega o link do repositório

        // Pega as descrições dos dias (I, P, E)
        $descricoesDias = [
            'I' => trim(Request::post('descricao_dia_i', '')),
            'P' => trim(Request::post('descricao_dia_p', '')),
            'E' => trim(Request::post('descricao_dia_e', '')),
        ];

        // Pega os arquivos de imagem dos dias (I, P, E)
        $imagensDias = [
            'I' => Request::file('imagem_dia_i'),
            'P' => Request::file('imagem_dia_p'),
            'E' => Request::file('imagem_dia_e'),
        ];
        // Pega o arquivo de imagem principal (capa) do projeto
        $imagemProjetoFile = Request::file('imagem_projeto');

        // Array para armazenar mensagens de erro de validação
        $erros = [];
        if (!$turmaId) {
            $erros[] = "ID da turma inválido ou não fornecido.";
        }
        if (empty($nomeProjeto)) {
            $erros[] = "O nome do projeto é obrigatório.";
        }
        if (empty($descricaoProjeto)) {
            $erros[] = "A descrição do projeto é obrigatória.";
        }
        // Valida se as descrições dos dias foram preenchidas
        foreach ($descricoesDias as $tipo => $desc) {
            if (empty($desc)) {
                $erros[] = "A descrição do Dia {$tipo} é obrigatória.";
            }
        }
        // Valida se o link do projeto, caso fornecido, é uma URL válida
        if (!empty($linkProjeto) && !filter_var($linkProjeto, FILTER_VALIDATE_URL)) {
             $erros[] = "O link do repositório fornecido não é uma URL válida.";
        }

        // Se houver erros de validação, armazena na sessão e redireciona de volta ao formulário
        if (!empty($erros)) {
            $_SESSION['erro_projeto'] = implode("<br>", $erros); // Junta os erros com quebra de linha
            Redirect::toAdm('cadastroTurmas/Projeto.php', ['id' => $turmaId]); // Redireciona de volta, passando o ID da turma
            return; // Interrompe a execução
        }

        // --- Processamento e Salvamento no Banco de Dados ---
        try {
            // Inicia uma transação: ou tudo funciona, ou nada é salvo no banco
            $this->projetoModel->getPdo()->beginTransaction();

             // 1. Salvar imagem principal do projeto (se enviada)
             $imagemProjetoId = null; // ID da imagem principal no banco
             if ($imagemProjetoFile && $imagemProjetoFile['error'] === UPLOAD_ERR_OK) {
                 // Tenta salvar o arquivo no servidor usando o UploadService
                 $uploadResult = $this->uploadService->salvar($imagemProjetoFile, 'projeto-capa'); // 'projeto-capa' é um prefixo para o nome do arquivo
                 if ($uploadResult['success']) {
                     // Se o upload funcionou, cria o registro da imagem no banco de dados
                     $imagemProjetoId = $this->imagemModel->criarImagem(
                         $uploadResult['caminho'], // Caminho relativo onde a imagem foi salva
                         'Capa do projeto: ' . $nomeProjeto, // Texto alternativo (opcional)
                         'Imagem de capa para o projeto ' . $nomeProjeto // Descrição (opcional)
                     );
                     if (!$imagemProjetoId) { // Verifica se a criação no banco falhou
                          throw new Exception("Falha ao registrar a imagem principal no banco de dados.");
                     }
                 } else {
                     // Se o upload falhou, lança um erro para interromper a transação
                     throw new Exception("Erro ao salvar imagem principal do projeto: " . $uploadResult['erro']);
                 }
             }

            // 2. Criar o registro principal do projeto no banco
            $projetoId = $this->projetoModel->criarProjeto($nomeProjeto, $descricaoProjeto, $linkProjeto, $turmaId);
            if (!$projetoId) { // Verifica se a criação do projeto falhou
                throw new Exception("Falha ao criar o registro do projeto principal.");
            }

             // 3. Associar a imagem principal ao projeto (se uma imagem foi salva)
             if ($imagemProjetoId) {
                 $associado = $this->projetoModel->associarImagemCapaProjeto($projetoId, $imagemProjetoId);
                 if (!$associado) { // Verifica se a associação falhou
                      throw new Exception("Falha ao associar imagem de capa ao projeto.");
                 }
             }

            // 4. Criar os registros dos dias do projeto (I, P, E) e associar suas imagens
            foreach ($descricoesDias as $tipoDia => $descricaoDia) {
                // Cria o registro para o dia específico (I, P ou E)
                $projetoDiaId = $this->projetoModel->criarProjetoDia($tipoDia, $descricaoDia, $projetoId);
                if (!$projetoDiaId) { // Verifica se a criação do dia falhou
                    throw new Exception("Falha ao criar o dia {$tipoDia} do projeto.");
                }

                // Verifica se uma imagem foi enviada para este dia
                $imagemFileDia = $imagensDias[$tipoDia];
                if ($imagemFileDia && $imagemFileDia['error'] === UPLOAD_ERR_OK) {
                    // Tenta salvar o arquivo da imagem do dia
                    $uploadResult = $this->uploadService->salvar($imagemFileDia, 'projeto-dia-' . strtolower($tipoDia)); // Prefixo dinâmico
                    if ($uploadResult['success']) {
                        // Se o upload funcionou, cria o registro da imagem no banco
                        $imagemId = $this->imagemModel->criarImagem(
                            $uploadResult['caminho'],
                            'Imagem Dia ' . $tipoDia . ' - Projeto ' . $nomeProjeto,
                            'Imagem para o dia ' . $tipoDia . ' do projeto ' . $nomeProjeto
                        );

                        if ($imagemId) {
                            // Se a imagem foi registrada no banco, associa ela ao dia do projeto
                            $associado = $this->projetoModel->associarImagemProjetoDia($imagemId, $projetoDiaId);
                            if (!$associado) { // Verifica se a associação falhou
                                throw new Exception("Falha ao associar imagem ao dia {$tipoDia}.");
                            }
                        } else {
                             throw new Exception("Falha ao registrar a imagem do dia {$tipoDia} no banco.");
                        }
                    } else {
                        // Se o upload do arquivo falhou
                        throw new Exception("Erro ao salvar imagem do dia {$tipoDia}: " . $uploadResult['erro']);
                    }
                }
                // Nota: Não estamos lançando erro se a imagem do dia não for enviada.
                // Se a imagem for obrigatória, adicione um 'else' aqui para lançar uma Exception.
            }

            // Se todas as operações foram bem-sucedidas, confirma a transação
            $this->projetoModel->getPdo()->commit();
            // Armazena mensagem de sucesso na sessão
            $_SESSION['sucesso_projeto'] = "Projeto '{$nomeProjeto}' cadastrado com sucesso!";
            // Redireciona para a página que lista os projetos da turma
            Redirect::toAdm('cadastroTurmas/CadastroProjetos.php', ['id' => $turmaId]);

        } catch (Exception $e) { // Captura qualquer erro que ocorreu durante a transação
            // Desfaz todas as alterações feitas no banco desde o beginTransaction()
            $this->projetoModel->getPdo()->rollBack();
            // Armazena a mensagem de erro na sessão
            $_SESSION['erro_projeto'] = "Erro ao salvar projeto: " . $e->getMessage();
            // Registra o erro detalhado no log do servidor (importante para debug)
            error_log("[ERRO] ProjetoController::salvar - " . $e->getMessage());
            // Redireciona de volta para o formulário de cadastro de projeto
            Redirect::toAdm('cadastroTurmas/Projeto.php', ['id' => $turmaId]);
        }
    }

    // Futuramente, adicionar métodos aqui para editar e excluir projetos...
    // public function editar() { ... }
    // public function excluir() { ... }
}

// --- Roteamento da Ação ---
// Pega o parâmetro 'action' da URL (?action=salvar)
$action = Request::get('action');

// Verifica se uma ação foi definida
if ($action) {
    $controller = new ProjetoController(); // Cria uma instância do controlador
    // Executa o método correspondente à ação
    switch ($action) {
        case 'salvar':
            $controller->salvar();
            break;
        // Adicionar 'cases' para outras ações (editar, excluir) quando forem implementadas
        // case 'editar':
        //     $controller->editar();
        //     break;
        // case 'excluir':
        //     $controller->excluir();
        //     break;
        default:
             // Se a ação não for reconhecida
             $_SESSION['erro_projeto'] = "Ação inválida solicitada.";
             Redirect::toAdm('listaTurmas.php'); // Redireciona para um local seguro
    }
} else {
    // Se nenhuma ação foi especificada na URL
     $_SESSION['erro_projeto'] = "Nenhuma ação especificada.";
     // Tenta obter o ID da turma do POST ou GET para um redirecionamento mais contextualizado
     $turmaIdRedirect = Request::post('turma_id', Request::get('id'));
     if($turmaIdRedirect) {
        Redirect::toAdm('cadastroTurmas/CadastroProjetos.php', ['id' => $turmaIdRedirect]);
     } else {
        Redirect::toAdm('listaTurmas.php'); // Fallback para a lista geral de turmas
     }
}