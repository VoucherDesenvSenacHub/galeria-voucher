
const section_modal = document.querySelector('.section_modal');

function abrirModalCadastro(classificacao, turmaId = '') {
    if (document.querySelector('dialog#modal-cadastro')) return;

    const modal = document.createElement('dialog');
    modal.id = 'modal-cadastro';

    const closeButton = document.createElement('button');
    closeButton.innerHTML = '<span class="material-symbols-outlined">close</span>';
    closeButton.classList.add('btn-close');
    closeButton.type = 'button';
    closeButton.setAttribute('aria-label', 'Fechar');

    closeButton.addEventListener('click', () => {
        modal.close();
        modal.remove();
    });

    let url = `/galeria-voucher/app/View/componentes/adm/form-cadastro-pessoas.php?classificacao=${encodeURIComponent(classificacao)}&t=${new Date().getTime()}`;

    if (turmaId) {
        url += `&turma_id=${encodeURIComponent(turmaId)}`;
    }

    fetch(url)
        .then(res => res.text())
        .then(html => {
            // Só insere o HTML puro, sem scripts
            modal.innerHTML = html;
            modal.prepend(closeButton);

            // Se o input não vier com id, atribui aqui para compatibilidade
            const inputPesq = modal.querySelector('input[name="pesquisar-pessoa"]');
            if (inputPesq && !inputPesq.id) {
                inputPesq.id = 'pesquisar-pessoa';
            }

            section_modal.appendChild(modal);
            modal.showModal();

            // Chama a função para ativar autocomplete no conteúdo do modal
            if (typeof ativarAutocomplete === 'function') {
                ativarAutocomplete(classificacao);
            } else {
                console.warn('Função ativarAutocomplete não está definida.');
            }
        })
        .catch(console.error);
}
