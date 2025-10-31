
const modalVincularAluno = document.querySelector("#modal-cadastro-aluno");
const modalVincularProfessor = document.querySelector("#modal-cadastro-professor");
const closeButton = document.querySelector('.btn-close');
const inputPesquisa = document.querySelector('input[name="pesquisar-pessoa"]');
const sugestoes = document.querySelector("#sugestoes");
const selecionados = document.querySelector("#pessoas-selecionadas");
const adicionados = new Set();

function abrirModalCadastroProfessor() {
    modalVincularProfessor.style.display = "block";
}

function abrirModalCadastroAluno() {
    modalVincularAluno.style.display = "block";
}

closeButton.addEventListener('click', () => {
    if (modalVincularAluno) modalVincularAluno.style.display = "none";
    if (modalVincularProfessor) modalVincularProfessor.style.display = "none";
    sugestoes.innerHTML = "";
    selecionados.innerHTML = "";
    inputPesquisa.value = "";
    adicionados.clear();
});

inputPesquisa.addEventListener('input', (event) => {
    const busca = event.target.value;
    const endpoint = modalVincularAluno ? 'BuscaAlunoController.php' : 'BuscaDocenteController.php';
    const url = `/galeria-voucher/app/Controller/${endpoint}`;
    
    fetch(`${url}?busca=${encodeURIComponent(busca)}`)
        .then(res => res.json())
        .then(dados => {
            sugestoes.innerHTML = "";
            dados.forEach(item => {
                const div = document.createElement("div");
                div.className = 'sugestao-item';
                div.textContent = item.nome;

                div.dataset.id = item.pessoa_id;

                div.onclick = function () {
                    const id = this.dataset.id;
                    const nome = this.textContent;
                    adicionarPessoa(id, nome);
                };
                sugestoes.appendChild(div);
            }
            );
        })

})

function adicionarPessoa(id, nome) {
    if (adicionados.has(id)) {
        alert("Esta pessoa já foi adicionada.");
        return;
    }

    adicionados.add(id);

    inputPesquisa.value = "";
    sugestoes.innerHTML = "";

    const chip = document.createElement("div");
    chip.className = "chip";
    chip.innerHTML = `${nome} <span class='remove'>&times;</span>`;

    const hiddenInput = document.createElement("input");
    hiddenInput.type = "hidden";
    hiddenInput.name = "pessoas_ids[]";
    hiddenInput.value = id;

    chip.appendChild(hiddenInput);
    chip.querySelector(".remove").onclick = () => {
        selecionados.removeChild(chip);
        adicionados.delete(id);
    };

    selecionados.appendChild(chip);
}
