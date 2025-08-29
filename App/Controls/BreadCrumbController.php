<?php
    class BreadCrumbController {
        /**
         * Árvore de Urls para montar o BreadCrumb. Atualizar urls caso mudem
         * @var array
         */
        private static array $breadMap = [
            0 => ["pai" => null, "url" => "home-adm", "valor" => "Início" ],
            1 => ["pai" => 0, "url" => "listarUsuarios", "valor" => "Pessoas" ],
            2 => ["pai" => 1, "url" => "cadastrar-usuarios", "valor" => "Cadastrar Usuário" ],
            3 => ["pai" => 0, "url" => "listaTurmas", "valor" => "Turmas" ],
            4 => ["pai" => 3, "url" => "cadastroTurmas/cadastroTurmas", "valor" => "Cadastrar Turma" ],
            5 => ["pai" => 3, "url" => "cadastroTurmas/CadastroProjetos", "valor" => "Listar Projetos" ],
            6 => ["pai" => 5, "url" => "Projeto", "valor" => "Cadastrar Projetos" ],
            7 => ["pai" => 3, "url" => "cadastroTurmas/docentes", "valor" => "Listar Docentes" ],
            8 => ["pai" => 3, "url" => "cadastroTurmas/alunos", "valor" => "Listar Alunos" ],
        ];

        private static string $SEPARADOR = "adm/";
        private static function pegarIdentificadorUrl() : string | null {
            $url = explode(BreadCrumbController::$SEPARADOR, $_SERVER['REQUEST_URI']);

            if(count($url) == 0) return null;

            $url = $url[1];

            $url = explode('?', $url);

            if(count($url) == 0) return null;

            return $url[0] ?? null;
            
        }

        public static function pegarBreadCrumbs(): string | null {
            $identificador = BreadCrumbController::pegarIdentificadorUrl();

            if($identificador == null)return null;

            $bread = array_filter(BreadCrumbController::$breadMap , function($breadCrumb) use ($identificador) {
                [ 'url' => $url] = $breadCrumb;

                return $url === $identificador;
            });

            if(count($bread) == 0) return null;

            echo "<pre>$bread<pre>";
            

            $crumbs = "";
        }


    }

?>