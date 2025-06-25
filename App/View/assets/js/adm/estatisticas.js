document.addEventListener('DOMContentLoaded', function() {
    //números de campos de estatística pra sincronizar
    const totalCampos= 4;

    function formatarNumero(num) {
        const numeroLimpo = isNaN(num) ? 0 : num;
        return new Intl.NumberFormat('de-DE').format(numeroLimpo);
    }

    //mapeamento dos id's dos inputs para os id's dos seus espelhos
    const mapeamento = {
        'input-alunos' : 'espelho-alunos',
        'input-projetos' : 'espelho-projetos',
        'input-polos' : 'espelho-polos',
        'input-horas' : 'espelho-horas'
    };

    Object.keys(mapeamento).forEach(inputId => {
        const inputElement = document.getElementById(inputId);
        const espelhoElement = document.getElementById(mapeamento[inputId]);

        if (inputElement && espelhoElement) {
            //evento input dispara a cada tecla digitada
            inputElement.addEventListener('input', function() {
                const novoValor = this.value;
                
                //se o usuário digitou algo..
                if (novoValor !== '') {
                    //..atualiza o espelho com o novo valor formatado
                    espelhoElement.textContent = '+ ' + formatarNumero(parseInt(novoValor, 10));
                }
                //se o usuário apagar tudo e deixar campo vazio..
                else {
                    //..busca valor original guardado do atributo data-original-value
                    const valorOriginal = this.dataset.originalValue;
                    //e reverte o espelho pro valor original
                    espelhoElement.textContent = '+ ' + formatarNumero(parseInt(valorOriginal, 10));
                }
            });
        }
    });
});