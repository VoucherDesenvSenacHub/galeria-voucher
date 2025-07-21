// pessoas para autocomplete — pode receber via fetch, mas vamos hardcode por enquanto
const pessoas = ['Manoel Victor', 'Amanda Lima', 'José Pereira', 'Lucas Silva', 'Thauanny Souza'];

// Função para ativar autocomplete no form dentro do modal
function ativarAutocomplete() {
    const input = document.getElementById("pesquisar-pessoa");
    if (!input) return; // só executa se input existir (modal aberto)

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
