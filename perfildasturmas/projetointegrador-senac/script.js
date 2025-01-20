 // Função para puxarmos  a navbar a partir de navbar.html
 fetch('navbar.html')
 .then(response => response.text())
 .then(data => {
   document.getElementById('navbar-container').innerHTML = data; // aqui puxo a navbar de dentro da pasta navbar
 })
 .catch(error => {
   console.error('Erro ao carregar a navbar:', error);
 });