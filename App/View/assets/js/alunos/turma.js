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