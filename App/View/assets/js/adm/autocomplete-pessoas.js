// pessoas para autocomplete — pode receber via fetch, mas vamos hardcode por enquanto
const pessoas = ['Manoel Victor', 'Amanda Lima', 'José Pereira', 'Lucas Silva', 'Thauanny Souza'];

// Função para ativar autocomplete no form dentro do modal
function ativarAutocomplete() {
    const input = document.getElementById("pesquisar-pessoa");
    if (!input) return; // só executa se input existir (modal aberto)

    const sugestoes = document.getElementById("sugestoes");
    const selecionados = document.getElementById("pessoas-selecionadas");
    const adicionados = new Set();

    input.addEventListener("keydown", async function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // impede form de recarregar
    
            const termo = input.value.trim(); // texto digitado
    
            if (termo.length === 0) {
                sugestoes.innerHTML = "";
                return;
            }
    
            try {
                // manda o termo para o backend
                const resposta = await fetch(`/galeria-voucher/teste.php?busca=${encodeURIComponent(termo)}`);
                const dados = await resposta.json();
    
                // limpa resultados anteriores
                sugestoes.innerHTML = "";
    
                // percorre e mostra cada resultado
                dados.forEach(item => {
                    const div = document.createElement("div");
                    div.textContent = item.nome;
                    sugestoes.appendChild(div);
                });
    
                // se não encontrou nada
                if (dados.length === 0) {
                    const div = document.createElement("div");
                    div.textContent = "Nenhum resultado encontrado";
                    sugestoes.appendChild(div);
                }
    
            } catch (erro) {
                console.error("Erro ao buscar dados:", erro);
            }
        }
    });
    
    
// alterar para o banco de dados, mudar a pesquisa fixa para busca nas tabelas
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

// input.addEventListener("input", () => {
//     const valor = input.value.toLowerCase();
//     sugestoes.innerHTML = "";
//     if (valor.length === 0) return;

//     pessoas.forEach(nome => {
//         if (nome.toLowerCase().startsWith(valor) && !adicionados.has(nome)) {
//             const div = document.createElement("div");
//             div.textContent = nome;
//             div.style.cursor = "pointer";
//             div.onclick = () => adicionarPessoa(nome);
//             sugestoes.appendChild(div);
//         }
//     });
// });




// input.addEventListener("input", () => {
//     const valor = input.value.toLowerCase();
//     sugestoes.innerHTML = "";
//     if (valor.length === 0) return;

//     echo 
//             const div = document.createElement("div");
//             div.do arquivo = nome;
//             div.style.cursor = "pointer";
//             div.onclick = () => adicionarPessoa(nome);
//             sugestoes.appendChild(div);
//         }
//     });
// });

