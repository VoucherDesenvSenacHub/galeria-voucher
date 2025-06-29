// icone ver mais e ver menos
 document.getElementById('vermais').addEventListener('click', function () {
  var extras = document.querySelectorAll('#cards-container .card-turma.extra');
  var arrowIcon = document.getElementById('arrow-icon');

  var hidden = extras[0] && !extras[0].classList.contains('show');
  if (hidden) {
      extras.forEach(card => card.classList.add('show'));
      arrowIcon.innerHTML = 'arrow_upward'; // Altera o ícone para cima
      document.querySelector('.vermais h3').innerText = 'VER MENOS'; // Altera o texto para "VER MENOS"
  } else {
      extras.forEach(card => card.classList.remove('show'));
      arrowIcon.innerHTML = 'arrow_downward'; // Altera o ícone para baixo
      document.querySelector('.vermais h3').innerText = 'VER MAIS'; // Altera o texto para "VER MAIS"
  }
});