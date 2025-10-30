function confirmarDesvinculacao(pessoaId, turmaId,  nomeAluno ) {  
    const modal = document.getElementById("modal-desvincular-aluno")  
    const inputAlunoId = document.querySelector("input[name='pessoa_id']")
    const inputTurmaId = document.querySelector("input[name='turma_id']")
    const nomeAlunoinsert = document.getElementById("aluno-confirmacao")    


    nomeAlunoinsert.innerHTML = nomeAluno
    inputTurmaId.value =  turmaId
    inputAlunoId.value = pessoaId
    modal.style.display = "flex";
}

function fecharModal() {
    const modal = document.querySelector('.modal-confirmacao');
}
    if (modal) {
        modal.remove();
    }

function confirmarDesvinculacaoComSenha(pessoaId, turmaId) {
    const senha = document.getElementById('senha-confirmacao').value;
    
    // Cria um formulário temporário para enviar os dados
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/galeria-voucher/App/Controller/DesvincularAlunoController.php?action=desvincular';
    
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

