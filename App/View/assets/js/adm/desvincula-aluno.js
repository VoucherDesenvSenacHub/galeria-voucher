function confirmarDesvinculacao(pessoaId, turmaId, nomeAluno) {
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
                <p>Tem certeza que deseja desvincular o aluno <strong>"${nomeAluno}"</strong> desta turma?</p>
                <p class="warning-text">Esta ação requer confirmação da sua senha.</p>
                <div class="form-group">
                    <label for="senha-confirmacao">Digite sua senha:</label>
                    <input type="password" id="senha-confirmacao" name="senha" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="primary-button" onclick="fecharModal()">Cancelar</button>
                <button type="button" class="secondary-button" onclick="confirmarDesvinculacaoComSenha(${pessoaId}, ${turmaId})">Desvincular</button>
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

function confirmarDesvinculacaoComSenha(pessoaId, turmaId) {
    const senha = document.getElementById('senha-confirmacao').value;
    
    if (!senha) {
        alert('Por favor, digite sua senha para confirmar a desvinculação.');
        return;
    }
    
    // Cria um formulário temporário para enviar os dados
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/galeria-voucher/App/Controls/DesvincularAlunoController.php?action=desvincular';
    
    // Adiciona os campos necessários
    const pessoaIdInput = document.createElement('input');
    pessoaIdInput.type = 'hidden';
    pessoaIdInput.name = 'pessoa_id';
    pessoaIdInput.value = pessoaId;
    
    const turmaIdInput = document.createElement('input');
    turmaIdInput.type = 'hidden';
    turmaIdInput.name = 'turma_id';
    turmaIdInput.value = turmaId;
    
    const senhaInput = document.createElement('input');
    senhaInput.type = 'hidden';
    senhaInput.name = 'senha';
    senhaInput.value = senha;
    
    form.appendChild(pessoaIdInput);
    form.appendChild(turmaIdInput);
    form.appendChild(senhaInput);
    
    // Adiciona o formulário ao DOM e submete
    document.body.appendChild(form);
    form.submit();
}

