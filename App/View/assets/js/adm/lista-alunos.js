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