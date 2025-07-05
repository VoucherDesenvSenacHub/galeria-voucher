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

// Fix para o menu hamburger - garantir que sempre comece fechado
document.addEventListener('DOMContentLoaded', function() {
  const menuLinks = document.querySelector('.menu-links');
  if (menuLinks) {
    menuLinks.classList.remove('open');
  }
});



// Feito para ordenar a pesquisar por nome, aluno-docente,cidade
document.addEventListener("DOMContentLoaded", function () {
  const inputPesquisa = document.getElementById("pesquisa");
  const tabela = document.getElementById("tabela-alunos");
  const linhas = tabela.getElementsByTagName("tr");

  inputPesquisa.addEventListener("keyup", function () {
    const termo = inputPesquisa.value.toLowerCase();

    // Percorre todas as linhas da tabela (ignorando o cabeçalho)
    for (let i = 1; i < linhas.length; i++) {
      const colunas = linhas[i].getElementsByTagName("td");
      let corresponde = false;

      // Verifica as 3 primeiras colunas: nome, tipo e polo
      for (let j = 0; j < 3; j++) {
        const texto = colunas[j].textContent.toLowerCase();
        if (texto.includes(termo)) {
          corresponde = true;
          break;
        }
      }

      linhas[i].style.display = corresponde ? "" : "none";
    }
  });
});
