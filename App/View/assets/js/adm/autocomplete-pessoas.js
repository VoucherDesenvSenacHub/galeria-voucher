async function buscarAlunos() {
  console.log('buscarAlunos chamada');
  const response = await fetch('/galeria-voucher/app/Controls/AlunoController.php?acao=alunos');
  const dados = await response.json();
  console.log(await dados)
  return dados;
}
// Função para ativar autocomplete no form dentro do modal
async function ativarAutocomplete() {
    const pessoas = await buscarAlunos();
    
    const input = document.getElementById("pesquisar-pessoa");
    if (!input) return; // só executa se input existir (modal aberto)

    const sugestoes = document.getElementById("sugestoes");
    const selecionados = document.getElementById("pessoas-selecionadas");
    const adicionados = new Set();

    input.addEventListener("input", () => {
    
        const valor = input.value.toLowerCase();
        sugestoes.innerHTML = "";
        if (valor.length === 0) return;

        pessoas.forEach(pessoa => {
            const nome = pessoa.nome_pessoa.toLowerCase();  
            if (nome.startsWith(valor) && !adicionados.has(nome)) {
                const div = document.createElement("div");
                div.textContent = pessoa.nome_pessoa;        // mostrar nome_pessoa
                div.style.cursor = "pointer";
                div.onclick = () => adicionarPessoa(pessoa.nome_pessoa);
                sugestoes.appendChild(div);
            }
        });
    });


    async function adicionarPessoa(nome) {
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
