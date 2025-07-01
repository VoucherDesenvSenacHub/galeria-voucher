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

    //alertas da página
    const alertaElemento = document.querySelector('.alerta');

    if (alertaElemento) {
        let timerId; //variável para guardar o id do timer

        //função pra fecha o alerta
        const fecharAlerta = () => {
            alertaElemento.style.display = 'none';
            clearTimeout(timerId); //limpa o timer se ainda estiver ativo
        };

        //função para iniciar ou reiniciar o timer de 8 segundos
        const iniciarTimer = () => {
            //limpa qualquer timer antigo pra evitar duplicação
            clearTimeout(timerId);
            //define um timer novo pra fecha o alerta
            timerId = setTimeout(fecharAlerta, 8000);
        };

        //encontra o botão de fechar
        const botaoFechar = alertaElemento.querySelector('.alerta-fechar');
        if (botaoFechar) {
            botaoFechar.addEventListener('click', fecharAlerta);
        }

        //evento pra pausa o timer quando o mouse passa em cima do alerta
        alertaElemento.addEventListener('mouseenter', () => {
            clearTimeout(timerId);
        });
        //evento pra reiniciar o timer quando o mouse sai de cima do alerta
        alertaElemento.addEventListener('mouseleave', iniciarTimer);

        //inicia o timer pela primeria vez quando a página carrega
        iniciarTimer();
    }
});