const modalVincularAluno = document.querySelector("#modal-cadastro-aluno");
const modalVincularProfessor = document.querySelector("#modal-cadastro-professor");
const inputDocenteTurmaId = document.querySelector('#vincular-docente-turma-id');
const closeButton = document.querySelector('.btn-close');
const inputPesquisaPessoa = document.querySelector('input[name="pesquisar-pessoa"]');
const sugestoes = document.querySelector("#sugestoes");
const selecionados = document.querySelector("#pessoas-selecionadas");
const adicionados = new Set();
const formVincularDocente = document.getElementById('form-vincular-docente')
const formVincularAluno = document.getElementById('form-vincular-aluno')

let currentEndpoint = null;

function abrirModalCadastroProfessor() {
    modalVincularProfessor.style.display = "block";
    currentEndpoint = 'BuscaDocenteController.php';
    buscarPessoas('');
}

function abrirModalCadastroAluno() {
    modalVincularAluno.style.display = "block";
    currentEndpoint = 'BuscaAlunoController.php';
    buscarPessoas(''); 
}

closeButton.addEventListener('click', () => {
    if (modalVincularAluno) modalVincularAluno.style.display = "none";
    if (modalVincularProfessor) modalVincularProfessor.style.display = "none";
    sugestoes.innerHTML = "";
    selecionados.innerHTML = "";
    inputPesquisaPessoa.value = "";
    adicionados.clear();
    currentEndpoint = null;
});


    
function buscarPessoas(busca = '') {
    if (!currentEndpoint) return;
    const url = `/galeria-voucher/app/Controller/${currentEndpoint}`;
    const turmaId = inputDocenteTurmaId && inputDocenteTurmaId?.value ? `&turma_id=${inputDocenteTurmaId.value}` : ''

fetch(`${url}?busca=${encodeURIComponent(busca)}${turmaId}`)
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
        });
    })
    .catch(err => {
        console.error('Erro ao buscar pessoas:', err);
        sugestoes.innerHTML = "";
    });
}

inputPesquisaPessoa?.addEventListener('input', (event) => {
    const busca = event.target.value;
    buscarPessoas(busca);
});


function adicionarPessoa(id, nome) {
    if (adicionados.has(id)) {
        alert("Esta pessoa já foi adicionada.");
        return;
    }

    adicionados.add(id);

    inputPesquisaPessoa.value = "";
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


const ignoraVinculoVazio = (e) => {
    const chips = document.getElementsByClassName('chip')
    if(chips.length !== 0)return

    e.preventDefault()
    e.stopPropagation()
}
formVincularDocente?.addEventListener('submit', ignoraVinculoVazio)
formVincularAluno?.addEventListener('submit', ignoraVinculoVazio)
