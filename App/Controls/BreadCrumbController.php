<?php
    class BreadCrumbController {
        /**
         * Árvore de Urls para montar o BreadCrumb. Atualizar urls caso mudem
         * @var array
         */
        private const BREAD_MAP = [
            0 => ["pai" => null, "url" => "home-adm", "valor" => "Início" ],
            1 => ["pai" => 0, "url" => "listarUsuarios", "valor" => "Pessoas" ],
            2 => ["pai" => 1, "url" => "cadastrar-usuarios", "valor" => "Cadastrar Usuário" ],
            3 => ["pai" => 0, "url" => "listaTurmas", "valor" => "Turmas" ],
            4 => ["pai" => 3, "url" => "cadastroTurmas/cadastroTurmas", "valor" => "Cadastrar Turma" ],
            5 => ["pai" => 3, "url" => "cadastroTurmas/CadastroProjetos", "valor" => "Listar Projetos" ],
            6 => ["pai" => 5, "url" => "cadastroTurmas/Projeto", "valor" => "Cadastrar Projetos" ],
            7 => ["pai" => 3, "url" => "cadastroTurmas/docentes", "valor" => "Listar Docentes" ],
            8 => ["pai" => 3, "url" => "cadastroTurmas/alunos", "valor" => "Listar Alunos" ],
        ];

        private const URL_SEPARADOR = "adm/";
        private const SEPARATOR = " - ";

        private static function pegarIdentificadorUrl() : string | null {
            $url = explode(BreadCrumbController::URL_SEPARADOR, $_SERVER['REQUEST_URI']);

            if(count($url) < 2) return null;

            $url = $url[1];
            $url = explode('.php', $url);

            if(count($url) == 0) return null;

            return $url[0] ?? null;
            
        }

        private static function pegarBreadCrumbAtual(): array | null {
            $identificador = BreadCrumbController::pegarIdentificadorUrl();
            
            if($identificador == null)return null;
            
            $bread = array_filter(BreadCrumbController::BREAD_MAP , function($breadCrumb) use ($identificador) {
                [ 'url' => $url] = $breadCrumb;
                
                return $url === $identificador;
            });

            if(count($bread) == 0) return null;

            return reset($bread);
        }

        /**
         * Gera a sequência de links do BreadCrumbs. Função recursiva que navega o array BREAD_MAP concatenando primeiro o link do elemento pai,
         * caso ele exista, com link do elemento atual.
         *
         * @param array{pai: int|null, url: string, valor: string} $breadcrumbItem A single breadcrumb item from BREAD_MAP.
         * @return string As tags a
         */
        protected static function gerarLink($breadcrumbItem) : string | null 
        {
            $breadcrumbCompleto = '';
            ["pai" => $pai,"url" => $url,"valor" => $valor] = $breadcrumbItem;
            
            if (isset($pai)) {
                $breadcrumbCompleto .= self::gerarLink(self::BREAD_MAP[$breadcrumbItem['pai']]) . BreadCrumbController::SEPARATOR;
            }

            $url_base = VARIAVEIS['APP_URL'] . "App/View/pages/adm";

            $breadcrumbCompleto .= "<a href=\"{$url_base}/{$url}.php\">{$valor}</a>";
            return $breadcrumbCompleto;
        }

        /**
         * Gera o BreadCrumbs completo, caso a página não seja do admin, retorna nada
         *
         * @param array{pai: int|null, url: string, valor: string} $breadcrumbItem A single breadcrumb item from BREAD_MAP.
         * @return string The HTML representation of the breadcrumb link.
         */
        public static function gerarBreadCrumbs(): string
        {
            $atual =  self::pegarBreadCrumbAtual();

            if(!isset($atual))return "";

            $html = '<div class="nav-breadccrumb">';
            $html .= self::gerarLink($atual);
            $html .= '</div>';
            return $html;
        }
    }

?>