
async function buscarAlunosSemTurma() {
    try {
        const response = await fetch('/galeria-voucher/app/Controls/AlunoController.php?acao=alunoSemTurma');

        if (!response.ok) {
            throw new Error('Falha na resposta da rede: ' + response.statusText);
        }

        const dados = await response.json();
        console.log('Alunos recebidos:', dados);
        return dados;

    } catch (error) {
        console.error('Erro ao buscar alunos:', error);
        return [];
    }
}


async function ativarAutocompleteSemTurma() {

    const pessoas = await buscarAlunosSemTurma();


    const input = document.querySelector('input[name="pesquisar-pessoa-aluno"]');
    const sugestoes = document.getElementById("sugestoes-aluno");
    const selecionados = document.getElementById("alunos-selecionadas");


    if (!input || !sugestoes || !selecionados) {
        console.error('Não foi possível encontrar um ou mais elementos necessários para o autocomplete.');
        return;
    }

    const adicionados = new Set();


    input.addEventListener("input", () => {
        const valor = input.value.toLowerCase().trim();
        sugestoes.innerHTML = "";

        if (valor.length === 0) {
            sugestoes.style.display = 'none';
            return;
        }

        const filtrados = pessoas.filter(pessoa =>

            pessoa.nome.toLowerCase().includes(valor) && !adicionados.has(pessoa.pessoa_id)
        );

        if (filtrados.length > 0) {
            sugestoes.style.display = 'block';
            filtrados.forEach(pessoa => {
                const div = document.createElement("div");
                div.textContent = pessoa.nome;
                div.onclick = () => {

                    adicionarPessoa(pessoa);
                };
                sugestoes.appendChild(div);
            });
        } else {
            sugestoes.style.display = 'none';
        }
    });


    function adicionarPessoa(pessoa) {

        if (adicionados.has(pessoa.pessoa_id)) return;

        adicionados.add(pessoa.pessoa_id);
        input.value = "";
        sugestoes.innerHTML = "";
        sugestoes.style.display = 'none';

        const chip = document.createElement("div");
        chip.className = "chip";
        chip.innerHTML = `${pessoa.nome} <span class='remove'>&times;</span>`;
        
        // Cria um input hidden apenas com o ID da pessoa
        const hiddenIdInput = document.createElement("input");
        hiddenIdInput.type = "hidden";
        // O name agora é simplesmente "pessoas[]", que criará um array simples de IDs
        hiddenIdInput.name = "pessoas[]";
        hiddenIdInput.value = pessoa.pessoa_id;

        // Adiciona apenas o input do ID ao chip
        chip.appendChild(hiddenIdInput);

        chip.querySelector(".remove").onclick = () => {
            selecionados.removeChild(chip);
            adicionados.delete(pessoa.pessoa_id);
        };

        selecionados.appendChild(chip);
    }
}
