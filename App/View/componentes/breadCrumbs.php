<?php
    class BreadCrumbs {
        /**
         * Árvore de Urls para montar o BreadCrumb. Atualizar urls caso mudem
         * @var array
         */
        private const BREAD_MAP = [
            0 => ["pai" => null, "url" => "home-adm", "valor" => "Início" ],
            1 => ["pai" => 0, "url" => "listarUsuarios", "valor" => "Pessoas" ],
            2 => ["pai" => 1, "url" => "cadastrar-usuarios", "valor" => "Cadastrar Usuário" ],
            3 => ["pai" => 0, "url" => "listaTurmas", "valor" => "Turmas" ],
            4 => ["pai" => 3, "url" => "cadastro-turmas/cadastro-turmas", "valor" => "Cadastrar Turma" ],
            5 => ["pai" => 3, "url" => "cadastro-turmas/cadastro-projetos", "valor" => "Listar Projetos" ],
            6 => ["pai" => 5, "url" => "cadastro-turmas/Projeto", "valor" => "Cadastrar Projetos" ],
            7 => ["pai" => 3, "url" => "cadastro-turmas/docentes", "valor" => "Listar Docentes" ],
            8 => ["pai" => 3, "url" => "cadastro-turmas/alunos", "valor" => "Listar Alunos" ],
        ];

        /**
         * Valor utilizado para separar a url, resultando nos valores de BREAD_MAP["url"] após remover URL_SEPARADOR_SUFFIX
         * @var string
         */
        private const URL_SEPARADOR_PREFIX = "adm/";

        /**
         * Valor utilizado para separar a url, resultando nos valores de BREAD_MAP["url"] após separar a url utilizando URL_SEPARADOR_PREFIX 
         * @var string
         */
        private const URL_SEPARADOR_SUFFIX = ".php";

        /**
         * Valor visível entre os links dos BreadCrumbs
         * @var string
         */
        private const SEPARATOR = " ⇒ ";

        /**
         * Gera o BreadCrumbs completo, caso a página não seja do admin, não gera o componente
         *
         * @param array{pai: int|null, url: string, valor: string} $breadcrumbItem A single breadcrumb item from BREAD_MAP.
         * @return string The HTML representation of the breadcrumb link.
         */
        public static function gerarBreadCrumbs(): void
        {
            $atual =  self::pegarBreadCrumbAtual();

            if(!isset($atual))return;

            $html = '<div class="nav-breadcrumbs">';
            $html .= self::gerarLink($atual);
            $html .= '</div>';
            echo $html;
        }

        /**
         * Busca o valor na URL que corresponde a um possivel valor de BREAD_MAP["url"]
         * @return string|null
         */
        private static function pegarIdentificadorUrl() : string | null {
            $url = explode(BreadCrumbs::URL_SEPARADOR_PREFIX, $_SERVER['REQUEST_URI']);

            if(count($url) < 2) return null;

            $url = $url[1];
            $url = explode(BreadCrumbs::URL_SEPARADOR_SUFFIX, $url);

            if(count($url) == 0) return null;

            return $url[0] ?? null;
            
        }

        /**
         * Retorna o elemento de BREAD_MAP correspondendo ao URL atual
         * @return array|null
         */
        private static function pegarBreadCrumbAtual(): array | null {
            $identificador = BreadCrumbs::pegarIdentificadorUrl();
            
            if($identificador == null)return null;
            
            $bread = array_filter(BreadCrumbs::BREAD_MAP , function($breadCrumb) use ($identificador) {
                [ 'url' => $url] = $breadCrumb;
                
                return $url === $identificador;
            });

            if(count($bread) == 0) return null;

            return reset($bread);
        }

        private static function gerarLink($breadcrumbItem) : string | null 
        {
            $breadcrumbCompleto = '';
            ["pai" => $pai,"url" => $url,"valor" => $valor] = $breadcrumbItem;
            
            if (isset($pai)) {
                $breadcrumbCompleto .= self::gerarLink(self::BREAD_MAP[$breadcrumbItem['pai']]) . self::SEPARATOR;
            }

            $url_base = Config::get('APP_URL') . "App/View/pages/adm"; // Usa Config::get()

            $breadcrumbCompleto .= "<a href=\"{$url_base}/{$url}.php\">{$valor}</a>";
            return $breadcrumbCompleto;
        }
    }
?>