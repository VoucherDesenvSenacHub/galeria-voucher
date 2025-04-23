// Escondendo a barra de pesquisa na tela de login

document.addEventListener('DOMContentLoaded', function() {
    const searchContainer = document.getElementById('search');
    const navLinks = document.querySelectorAll('.nav-link');
    
    // Verifica a página atual (por exemplo, usando hash na URL)
    function checkCurrentPage() {
        const currentPage = window.location.hash.substring(1) || 'home';
        
        if (currentPage !== 'home') {
            searchContainer.classList.add('hidden');
        } else {
            searchContainer.classList.remove('hidden');
        }
    }
    
    // Adiciona evento de clique para os links de navegação
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            const page = this.getAttribute('data-page');
            
            if (page === 'login') {
                searchContainer.classList.add('hidden');
            } else if (page === 'home') {
                searchContainer.classList.remove('hidden');
            }
        });
    });
    
    // Verifica a página ao carregar
    checkCurrentPage();
    
    // Opcional: verifica também quando a hash muda (navegação sem recarregar)
    window.addEventListener('hashchange', checkCurrentPage);
});