let pessoas = [];  // variável global para armazenar os nomes

async function buscarPessoa(){
    const response = await fetch("/galeria-voucher/app/Controls/ControllerPessoa.php?acao=listarJson");
    const dados = await response.json();

    // Supondo que dados seja um array de objetos com campo nome, por exemplo:
    // [{ nome: "João" }, { nome: "Maria" }, ...]
    pessoas = dados.map(p => p.nome);

    ativarAutocomplete();  // chama a função depois de carregar os dados
}

buscarPessoa();

function ativarAutocomplete() {
    const input = document.getElementById("pesquisar-pessoa");
    if (!input) return;

    const sugestoes = document.getElementById("sugestoes");
    const selecionados = document.getElementById("pessoas-selecionadas");
    const adicionados = new Set();

    input.addEventListener("input", () => {
        const valor = input.value.toLowerCase();
        sugestoes.innerHTML = "";
        if (valor.length === 0) return;

        pessoas.forEach(nome => {
            if (nome.toLowerCase().startsWith(valor) && !adicionados.has(nome)) {
                const div = document.createElement("div");
                div.textContent = nome;
                div.style.cursor = "pointer";
                div.onclick = () => adicionarPessoa(nome);
                sugestoes.appendChild(div);
            }
        });
    });

    function adicionarPessoa(nome) {
        adicionados.add(nome);
        input.value = "";
        sugestoes.innerHTML = "";

        const chip = document.createElement("div");
        chip.className = "chip";
        chip.innerHTML = nome + "<span class='remove'>&times;</span>";

        const hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.name = "pessoas[]";
        hidden.value = nome;

        chip.appendChild(hidden);
        chip.querySelector(".remove").onclick = () => {
            selecionados.removeChild(chip);
            adicionados.delete(nome);
        };

        selecionados.appendChild(chip);
    }
}
