const button = document.querySelector("#btn-cadastrar-pessoa");
const section_modal = document.querySelector('.section_modal');

function abrirModalCadastro() {
    // Evita múltiplos modais
    if (document.querySelector('dialog#modal-cadastro')) return;

    const modal = document.createElement('dialog');
    modal.id = 'modal-cadastro';

    const closeButton = document.createElement('button');
    closeButton.textContent = 'X';
    closeButton.classList.add('btn-close');
    closeButton.style.float = 'left';
    closeButton.style.margin = '10px';

    closeButton.addEventListener('click', () => {
        modal.close();
        modal.remove();
    });

    const url = '/galeria-voucher/app/View/componentes/adm/form-cadastro-pessoas.php?t=' + new Date().getTime();

    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error('Arquivo não encontrado!');
            return response.text();
        })
        .then(html => {
            console.log('Modal carregado')
            modal.innerHTML = html;
            modal.prepend(closeButton);
            section_modal.appendChild(modal);
            modal.showModal(); // <- aqui é onde o modal aparece
        })
        .catch(error => {
            console.error('Erro ao carregar o modal:', error);
        });
}
