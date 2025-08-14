async function buscarAlunos() {
    const response = await fetch('/galeria-voucher/app/Controls/AlunoController.php?acao=alunos');
    const dados = await response.json();
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
                div.onclick = () => {
                    const url = `/galeria-voucher/App/View/pages/users/galeria-turma.php?acao=${encodeURIComponent(pessoa.nome_turma)}`;
                    window.location.href = url;
                };
                sugestoes.appendChild(div);
            }
        });
    });

}

ativarAutocomplete()
