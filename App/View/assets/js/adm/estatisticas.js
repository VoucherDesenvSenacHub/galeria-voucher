document.addEventListener('DOMContentLoaded', function() {
    //números de campos de estatística pra sincronizar
    const totalCampos= 4;

    function formatarNumero(numero) {
        //garantia de que seja um número inteiro positivo
        const num = Number.isNaN(numero) ? 0 : numero;
        //formatação
        return num.toLocaleString('pt-BR');
    }

    // função para filtrar apenas dígitos de uma string
    function filtrarDigitos(texto) {
        //remove qualquer caractere que não seja 0-9
        return texto.replace(/\D/g, '');
    }

    // inicializa a sincronização para cada par de input/espelho
    for (let i = 1; i <=totalCampos; i++) {
        const inputTopo = document.getElementById('input' + i);
        const espelho = document.getElementById('espelho' + i);

        //se elemento não existir, pula pro próximo
        if (!inputTopo || !espelho) continue;

        //função que atualiza o espelho com base no valor do input
        function atualizarEspelho() {
            
            //filtra valor do input para manter apenas dígitos
            let valorRaw = inputTopo.value;
            let somenteDigitos = filtrarDigitos(valorRaw);

            // se filtração removeu caracteres, atualiza o campo de entrada
            if (somenteDigitos !==valorRaw) {
                inputTopo.value = somenteDigitos;
            }

            //converte pra inteiro e se estiver vazio, configura como 0
            let numero = somenteDigitos === '' ? 0 : parseInt(somenteDigitos, 10);

            //formata pra nossa língua com separador de milhar
            let valorFormatado = formatarNumeroPTBR(numero);

            //define o texto no espelho e prefixa o '+' antes do valor
            espelho.textContent = '+ ' + valorFormatado;
        }

        //no carregamento inicial da página, atualiza o espelho com o valor escrito no input na página de estatísticas
        //(carregado do servidor)
        atualizarEspelho();

        //listener para evento 'input' no campo: dispara sempre que tem alguma modificação
        inputTopo.addEventListener('input', function() {
            atualizarEspelho();
        });

        //listerner para keypress para bloquear caracteres que não sejam dígitos
        inputTopo.addEventListener('keypress', function(e) {
            const char = String.fromCharCode(e.which || e.keycode);
            //se não for algum dígito entre 0-9, previne a inserção
            if(!/[0-9]/.test(char)) {
                e.preventDefault();
            }
        });

        //
    }
}