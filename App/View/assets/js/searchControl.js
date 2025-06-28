/**
 * Controle da Barra de Pesquisa
 * Funções para esconder e mostrar a barra de pesquisa dinamicamente
 */

class SearchBarController {
    constructor() {
        this.searchBar = document.getElementById('searchBar');
        this.searchInput = document.getElementById('searchInput');
        this.isVisible = true;
        
        // Inicializa o controlador
        this.init();
    }

    init() {
        // Verifica se os elementos existem
        if (!this.searchBar) {
            console.warn('Elemento searchBar não encontrado');
            return;
        }

        // Adiciona listeners para eventos de teclado (opcional)
        this.addKeyboardListeners();
    }

    /**
     * Esconde a barra de pesquisa
     */
    esconder() {
        if (this.searchBar && this.isVisible) {
            this.searchBar.classList.add('desapareca');
            this.isVisible = false;
            
            // Limpa o valor do input quando esconder
            if (this.searchInput) {
                this.searchInput.value = '';
            }
            
            console.log('Barra de pesquisa escondida');
        }
    }

    /**
     * Mostra a barra de pesquisa
     */
    mostrar() {
        if (this.searchBar && !this.isVisible) {
            this.searchBar.classList.remove('desapareca');
            this.isVisible = true;
            
            // Foca no input quando mostrar
            if (this.searchInput) {
                setTimeout(() => {
                    this.searchInput.focus();
                }, 300);
            }
            
            console.log('Barra de pesquisa mostrada');
        }
    }

    /**
     * Alterna a visibilidade da barra de pesquisa
     */
    alternar() {
        if (this.isVisible) {
            this.esconder();
        } else {
            this.mostrar();
        }
    }

    /**
     * Verifica se a barra está visível
     */
    estaVisivel() {
        return this.isVisible;
    }

    /**
     * Adiciona listeners para teclas de atalho (opcional)
     */
    addKeyboardListeners() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + K para alternar a barra de pesquisa
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                this.alternar();
            }
            
            // ESC para esconder a barra de pesquisa
            if (e.key === 'Escape' && this.isVisible) {
                this.esconder();
            }
        });
    }

    /**
     * Esconde a barra de pesquisa baseado em uma condição
     * @param {boolean} condicao - Se true, esconde a barra
     */
    esconderSe(condicao) {
        if (condicao) {
            this.esconder();
        } else {
            this.mostrar();
        }
    }

    /**
     * Mostra a barra de pesquisa baseado em uma condição
     * @param {boolean} condicao - Se true, mostra a barra
     */
    mostrarSe(condicao) {
        if (condicao) {
            this.mostrar();
        } else {
            this.esconder();
        }
    }
}

// Cria uma instância global do controlador
let searchController;

// Inicializa quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', () => {
    searchController = new SearchBarController();
});

// Funções globais para uso direto no HTML ou outros scripts
function esconderBarraPesquisa() {
    if (searchController) {
        searchController.esconder();
    }
}

function mostrarBarraPesquisa() {
    if (searchController) {
        searchController.mostrar();
    }
}

function alternarBarraPesquisa() {
    if (searchController) {
        searchController.alternar();
    }
}

// Exemplo de uso com variável PHP
function controlarBarraPesquisa(esconder) {
    if (searchController) {
        searchController.esconderSe(esconder);
    }
} 