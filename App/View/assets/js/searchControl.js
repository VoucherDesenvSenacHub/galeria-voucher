/**
 * Controle da barra de pesquisa
 * Gerencia a funcionalidade de busca e filtros
 */

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('pesquisar-pessoa');
    const sugestoes = document.getElementById('sugestoes');
    const pessoasSelecionadas = document.getElementById('pessoas-selecionadas');
    
    if (!searchInput) return;
    
    let timeoutId;
    let pessoas = [];
    let pessoasFiltradas = [];
    
    // Função para buscar pessoas
    function buscarPessoas(termo) {
        if (termo.length < 2) {
            sugestoes.innerHTML = '';
            return;
        }
        
        // Simula busca (substitua pela sua lógica de busca real)
        fetch(`/galeria-voucher/App/Controller/PessoaController.php?acao=buscar&termo=${encodeURIComponent(termo)}`)
            .then(response => response.json())
            .then(data => {
                pessoasFiltradas = data;
                exibirSugestoes(data);
            })
            .catch(error => {
                console.error('Erro na busca:', error);
                sugestoes.innerHTML = '';
            });
    }
    
    // Função para exibir sugestões
    function exibirSugestoes(pessoas) {
        if (pessoas.length === 0) {
            sugestoes.innerHTML = '<div class="sugestao-item">Nenhuma pessoa encontrada</div>';
            return;
        }
        
        sugestoes.innerHTML = pessoas.map(pessoa => `
            <div class="sugestao-item" data-id="${pessoa.id}" data-nome="${pessoa.nome}">
                <img src="${pessoa.foto || '/galeria-voucher/App/View/assets/img/utilitarios/avatar.png'}" alt="${pessoa.nome}">
                <span>${pessoa.nome}</span>
            </div>
        `).join('');
        
        // Adiciona event listeners às sugestões
        sugestoes.querySelectorAll('.sugestao-item').forEach(item => {
            item.addEventListener('click', function() {
                adicionarPessoaSelecionada(this.dataset.id, this.dataset.nome);
                searchInput.value = '';
                sugestoes.innerHTML = '';
            });
        });
    }
    
    // Função para adicionar pessoa selecionada
    function adicionarPessoaSelecionada(id, nome) {
        if (pessoas.find(p => p.id === id)) return; // Evita duplicatas
        
        const pessoa = { id, nome };
        pessoas.push(pessoa);
        
        const pessoaElement = document.createElement('div');
        pessoaElement.className = 'pessoa-selecionada';
        pessoaElement.innerHTML = `
            <span>${nome}</span>
            <button type="button" onclick="removerPessoaSelecionada(${id})">×</button>
            <input type="hidden" name="pessoas_selecionadas[]" value="${id}">
        `;
        
        pessoasSelecionadas.appendChild(pessoaElement);
    }
    
    // Função para remover pessoa selecionada
    window.removerPessoaSelecionada = function(id) {
        pessoas = pessoas.filter(p => p.id !== id);
        const elemento = pessoasSelecionadas.querySelector(`[data-id="${id}"]`);
        if (elemento) {
            elemento.remove();
        }
    };
    
    // Event listener para o input de pesquisa
    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            buscarPessoas(this.value);
        }, 300);
    });
    
    // Esconde sugestões ao clicar fora
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !sugestoes.contains(e.target)) {
            sugestoes.innerHTML = '';
        }
    });
    
    // Limpa sugestões ao focar no input
    searchInput.addEventListener('focus', function() {
        if (this.value.length >= 2) {
            buscarPessoas(this.value);
        }
    });
});
