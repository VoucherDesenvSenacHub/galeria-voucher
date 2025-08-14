document.addEventListener('DOMContentLoaded', () => {
    // --- MENU HAMBÚRGUER RESPONSIVO ---
    const ham = document.getElementById('hamburger');
    const links = document.getElementById('nav-links');
    if (ham && links) {
        links.classList.remove('open'); // Começa fechado

        ham.addEventListener('click', () => {
            links.classList.toggle('open');
        });

        // Fechar menu ao clicar em um link
        const menuLinks = links.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                links.classList.remove('open');
            });
        });
    }

    // --- NAVEGAÇÃO ENTRE PROJETOS E ABAS (GALERIA) ---
    const mainTabs = document.querySelectorAll('.galeria-turma-main-tab-btn');
    const mainContents = document.querySelectorAll('.galeria-turma-main-tab-content');
    const subTabState = {};

    mainTabs.forEach(btn => {
        btn.addEventListener('click', function () {
            const projetoId = this.dataset.projeto;
            mainTabs.forEach(b => b.classList.remove('active'));
            mainContents.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('main-tab-' + projetoId).classList.add('active');
        });
    });

    const allSubTabs = document.querySelectorAll('.galeria-turma-sub-tab-btn');
    allSubTabs.forEach(btn => {
        if (btn.tagName === 'BUTTON' && btn.type === 'button') return;

        const subtabId = btn.dataset.subtab;
        const projetoId = btn.dataset.projeto;
        const parent = document.getElementById('main-tab-' + projetoId);
        const subTabBtns = parent.querySelectorAll('.galeria-turma-sub-tab-btn');
        const subContents = parent.querySelectorAll('.galeria-turma-sub-tab-content');

        btn.addEventListener('mouseenter', () => {
            subTabBtns.forEach(b => b.classList.remove('active'));
            subContents.forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('sub-tab-' + subtabId).classList.add('active');
        });

        btn.addEventListener('mouseleave', () => {
            const activeId = subTabState[projetoId];
            if (activeId) {
                subTabBtns.forEach(b => {
                    b.classList.toggle('active', b.dataset.subtab === activeId);
                });
                subContents.forEach(c => {
                    c.classList.toggle('active', c.id === 'sub-tab-' + activeId);
                });
            } else {
                if (subTabBtns.length > 0 && subContents.length > 0) {
                    subTabBtns.forEach((b, idx) => b.classList.toggle('active', idx === 0));
                    subContents.forEach((c, idx) => c.classList.toggle('active', idx === 0));
                }
            }
        });

        btn.addEventListener('click', () => {
            subTabState[projetoId] = subtabId;
        });
    });

    // Seleciona automaticamente a primeira aba do primeiro projeto
    document.querySelectorAll('.galeria-turma-main-tab-content').forEach(mainTab => {
        const projetoId = mainTab.id.replace('main-tab-', '');
        const subTabBtns = mainTab.querySelectorAll('.galeria-turma-sub-tab-btn');
        const subContents = mainTab.querySelectorAll('.galeria-turma-sub-tab-content');

        if (!subTabState[projetoId] && subTabBtns.length > 0 && subContents.length > 0) {
            subTabBtns.forEach((b, idx) => {
                if (idx === 0 && !(b.tagName === 'BUTTON' && b.type === 'button')) {
                    b.classList.add('active');
                    subTabState[projetoId] = b.dataset.subtab;
                } else {
                    b.classList.remove('active');
                }
            });
            subContents.forEach((c, idx) => {
                c.classList.toggle('active', idx === 0);
            });
        }
    });
});
