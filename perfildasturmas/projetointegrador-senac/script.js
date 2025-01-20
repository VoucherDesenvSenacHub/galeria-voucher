 // Função para puxarmos  a navbar a partir de navbar.html
 fetch('navbar.html')
 .then(response => response.text())
 .then(data => {
   document.getElementById('navbar-container').innerHTML = data; // aqui puxo a navbar de dentro da pasta navbar
 })
 .catch(error => {
   console.error('Erro ao carregar a navbar:', error);
 });

// icone ver mais e ver menos
 document.getElementById('vermais').addEventListener('click', function () {
  var cards = document.getElementById('cards-adicionais');
  var arrowIcon = document.getElementById('arrow-icon');

  // Alterna a visibilidade dos cards
  if (cards.style.display === "none" || cards.style.display === "") {
      cards.style.display = "flex"; // Mostra os cards com o layout flex
      arrowIcon.innerHTML = 'arrow_upward'; // Altera o ícone para cima
      document.querySelector('.vermais h3').innerText = 'VER MENOS'; // Altera o texto para "VER MENOS"
  } else {
      cards.style.display = "none"; // Oculta os cards
      arrowIcon.innerHTML = 'arrow_downward'; // Altera o ícone para baixo
      document.querySelector('.vermais h3').innerText = 'VER MAIS'; // Altera o texto para "VER MAIS"
  }
});


// rodape
function importarRodape() {
  fetch('rodape.html') // Pega o arquivo 'rodape.html'
      .then(response => response.text()) // Transforma a resposta em texto
      .then(data => {
          // Adiciona o conteúdo do arquivo ao final da página
          document.body.insertAdjacentHTML('beforeend', data);
      })
      .catch(error => console.error('Erro ao carregar o rodapé:', error));
}

// Chama a função para importar o rodapé
importarRodape();
