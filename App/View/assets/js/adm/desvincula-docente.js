function confirmarDesvinculacao(pessoaId, turmaId, nomeDocente) {
    // Cria o modal de confirmação
    const modal = document.createElement('div');
    modal.className = 'modal-confirmacao';
    modal.innerHTML = `
        <div class="modal-content">
            <div class="modal-header">
                <h3>Confirmar Desvinculação</h3>
                <span class="close-modal" onclick="fecharModal()">&times;</span>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja desvincular o docente <strong>"${nomeDocente}"</strong> desta turma?</p>
                <p class="warning-text">Esta ação requer confirmação da sua senha.</p>
                <div class="form-group">
                    <label for="senha-confirmacao">Digite sua senha:</label>
                    <input type="password" id="senha-confirmacao" name="senha" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="secondary-button" onclick="fecharModal()">Cancelar</button>
                <button type="button" class="primary-button" onclick="confirmarDesvinculacaoComSenha(${pessoaId}, ${turmaId})">Desvincular</button>
            </div>
        </div>
    `;
    
    // Adiciona o modal ao body
    document.body.appendChild(modal);
    
    // Foca no campo de senha
    setTimeout(() => {
        document.getElementById('senha-confirmacao').focus();
    }, 100);
}

function fecharModal() {
    const modal = document.querySelector('.modal-confirmacao');
    if (modal) {
        modal.remove();
    }
}

async function confirmarDesvinculacaoComSenha(pessoaId, turmaId) {
    const senha = document.getElementById('senha-confirmacao').value;
    
    if (!senha) {
        mostrarMensagem('Por favor, digite sua senha para confirmar a desvinculação.', 'error');
        return;
    }
    
    try {
        // Desabilita o botão para evitar múltiplos cliques
        const botaoDesvincular = document.querySelector('.primary-button');
        botaoDesvincular.disabled = true;
        botaoDesvincular.textContent = 'Desvinculando...';
        
        // Cria FormData para enviar os dados
        const formData = new FormData();
        formData.append('pessoa_id', pessoaId);
        formData.append('turma_id', turmaId);
        formData.append('senha', senha);
        
        // Faz a requisição AJAX
        const response = await fetch('/galeria-voucher/App/Controller/DocenteController.php?action=desvincular', {
            method: 'POST',
            body: formData
        });
        
        const resultado = await response.json();
        
        if (resultado.status === 'success') {
            mostrarMensagem(resultado.mensagem, 'success');
            // Remove a linha da tabela
            removerLinhaTabela(pessoaId);
            // Fecha o modal
            fecharModal();
        } else {
            mostrarMensagem(resultado.mensagem, 'error');
        }
        
    } catch (error) {
        console.error('Erro na requisição:', error);
        mostrarMensagem('Erro de conexão. Tente novamente.', 'error');
    } finally {
        // Reabilita o botão
        const botaoDesvincular = document.querySelector('.primary-button');
        if (botaoDesvincular) {
            botaoDesvincular.disabled = false;
            botaoDesvincular.textContent = 'Desvincular';
        }
    }
}

function removerLinhaTabela(pessoaId) {
    // Encontra a linha da tabela que contém o docente desvinculado usando data attributes
    const linha = document.querySelector(`tr[data-pessoa-id="${pessoaId}"]`);
    if (linha) {
        linha.remove();
    }
    
    // Verifica se não há mais docentes na tabela (excluindo a linha de estado vazio)
    const tbody = document.querySelector('#tabela-alunos tbody');
    const linhasDocentes = tbody.querySelectorAll('tr[data-pessoa-id]');
    
    if (linhasDocentes.length === 0) {
        // Mostra a linha de estado vazio que já está no HTML
        const emptyStateRow = document.getElementById('empty-state-row');
        if (emptyStateRow) {
            emptyStateRow.style.display = '';
        }
    }
}

function mostrarMensagem(mensagem, tipo) {
    // Remove mensagens anteriores
    const mensagensExistentes = document.querySelectorAll('.mensagem-temporaria');
    mensagensExistentes.forEach(msg => msg.remove());
    
    // Cria nova mensagem
    const divMensagem = document.createElement('div');
    divMensagem.className = `mensagem-temporaria ${tipo === 'success' ? 'success-message' : 'error-message'}`;
    divMensagem.textContent = mensagem;
    
    // Adiciona a mensagem no topo da página
    const main = document.querySelector('.main-turmas-turmas');
    if (main) {
        main.insertBefore(divMensagem, main.firstChild);
        
        // Remove a mensagem após 5 segundos
        setTimeout(() => {
            divMensagem.remove();
        }, 5000);
    }
}

