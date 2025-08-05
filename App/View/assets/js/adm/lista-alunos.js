const pesquisa = document.getElementById('pesquisa');
const tabela = document.getElementById('tabela-alunos');
const linhas = tabela.getElementsByTagName('tr');

/**
 * Função para remover acentos de uma string.
 * Ex: "Pólo" se torna "Polo".
 * @param {string} texto O texto para normalizar.
 * @returns {string} O texto sem acentos.
 */
function removerAcentos(texto) {
    if (texto && typeof texto.normalize === 'function') {
        return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    }
    return texto;
}

if (pesquisa && tabela) {
    pesquisa.addEventListener('keyup', () => {
        // 1. Pega o valor da pesquisa, remove espaços extras no início/fim, e converte para minúsculas.
        const termoPesquisaInput = pesquisa.value.trim().toLowerCase();
        
        // 2. Remove os acentos do termo da pesquisa.
        const termoPesquisaNormalizado = removerAcentos(termoPesquisaInput);

        // Itera sobre as linhas da tabela, começando em 1 para ignorar o cabeçalho (thead).
        for (let i = 1; i < linhas.length; i++) {
            const linha = linhas[i];
            
            // Pega todo o conteúdo de texto da linha.
            const conteudoLinha = linha.textContent || linha.innerText || "";

            // 3. Converte o conteúdo da linha para minúsculas e remove os acentos.
            const conteudoLinhaNormalizado = removerAcentos(conteudoLinha.toLowerCase());

            // 4. Compara o texto da linha (normalizado) com o termo da pesquisa (normalizado).
            if (conteudoLinhaNormalizado.includes(termoPesquisaNormalizado)) {
                // Se corresponder, exibe a linha.
                linha.style.display = '';
            } else {
                // Se não, esconde a linha.
                linha.style.display = 'none';
            }
        }
    });
}
