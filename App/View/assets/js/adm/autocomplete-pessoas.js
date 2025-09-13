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
                const resposta = await fetch(`/galeria-voucher/App/Controller/BuscaDocenteController.php?busca=${encodeURIComponent(termo)}`);
                const dados = await resposta.json();
    
                // limpa resultados anteriores
                sugestoes.innerHTML = "";
    
                // percorre e mostra cada resultado
                dados.forEach(item => {
                    const div = document.createElement("div");
                    div.className = 'sugestao-item';
                    div.textContent = item.nome;

                    div.dataset.id = item.pessoa_id;

                    div.onclick = function() {
                        const id = this.dataset.id;
                        const nome = this.textContent;
                        adicionarPessoa(id, nome);
                    };
                    sugestoes.appendChild(div);
                });
    
                // se não encontrou nada
                if (dados.length === 0) {
                    const div = document.createElement("div");
                    div.className = 'sugestao-empty';
                    div.textContent = "Nenhum resultado encontrado";
                    sugestoes.appendChild(div);
                }
    
            } catch (erro) {
                console.error("Erro ao buscar dados:", erro);
            }
        }
    });
    
    
// alterar para o banco de dados, mudar a pesquisa fixa para busca nas tabelas
    function adicionarPessoa(id, nome) {

        if (adicionados.has(id)){
            alert("Esta pessoa já foi adicionada.");
            return;
        }

        adicionados.add(id);

        input.value = "";
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
}