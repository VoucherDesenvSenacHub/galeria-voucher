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
