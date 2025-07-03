// Função que ajusta a altura maxima da tabela com base na altura da janela //
function ajustarAlturaMaximaTabela() {
    const container = document.querySelector('.container-lista-alunos');
    if (!container) return;
  
    const alturaJanela = window.innerHeight;
    const alturaMaxima = alturaJanela * 0.7;
  
    container.style.maxHeight = `${alturaMaxima}px`;
  }
  
// Ajusta a altura ao carregar a página e ao redimensionar a janela
window.addEventListener('load', ajustarAlturaMaximaTabela);
window.addEventListener('resize', ajustarAlturaMaximaTabela);



function filtrarPorTipo() {
    const selectTipo = document.getElementById('pessoa');
    const tabela = document.getElementById('tabela-alunos');
    const linhas = tabela.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    const tipoSelecionado = selectTipo.value;
    
    for (let i = 0; i < linhas.length; i++) {
        const linha = linhas[i];
        const celulaTipo = linha.cells[1];
        const tipoUsuario = celulaTipo.textContent.trim();
        
        if (tipoSelecionado === 'todos' || 
            (tipoSelecionado === 'aluno' && tipoUsuario === 'Aluno') ||
            (tipoSelecionado === 'professor' && tipoUsuario === 'Professor')) {
            linha.style.display = '';
        } else {
            linha.style.display = 'none';
        }
    }
}

function pesquisarPorNome() {
    const inputPesquisa = document.getElementById('pesquisa');
    const tabela = document.getElementById('tabela-alunos');
    const linhas = tabela.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    const termoPesquisa = inputPesquisa.value.toLowerCase();
    
    for (let i = 0; i < linhas.length; i++) {
        const linha = linhas[i];
        const celulaNome = linha.cells[0]; // Primeira coluna (NOME)
        const nomeUsuario = celulaNome.textContent.toLowerCase();
        
        if (nomeUsuario.includes(termoPesquisa)) {
            linha.style.display = '';
        } else {
            linha.style.display = 'none';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const selectTipo = document.getElementById('pessoa');
    const inputPesquisa = document.getElementById('pesquisa');
    
    if (selectTipo) {
        selectTipo.addEventListener('change', filtrarPorTipo);
    }
    
    if (inputPesquisa) {
        inputPesquisa.addEventListener('input', pesquisarPorNome);
    }
});
