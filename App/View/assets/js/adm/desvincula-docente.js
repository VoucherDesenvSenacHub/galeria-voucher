function confirmarDesvinculacao(pessoaId, turmaId, nomeDocente) {
    if (confirm(`Tem certeza que deseja desvincular o docente "${nomeDocente}" desta turma?`)) {
        // Cria um formulário temporário para enviar os dados
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/galeria-voucher/App/Controls/DocenteController.php?action=desvincular';
        
        // Adiciona os campos necessários
        const pessoaIdInput = document.createElement('input');
        pessoaIdInput.type = 'hidden';
        pessoaIdInput.name = 'pessoa_id';
        pessoaIdInput.value = pessoaId;
        
        const turmaIdInput = document.createElement('input');
        turmaIdInput.type = 'hidden';
        turmaIdInput.name = 'turma_id';
        turmaIdInput.value = turmaId;
        
        form.appendChild(pessoaIdInput);
        form.appendChild(turmaIdInput);
        
        // Adiciona o formulário ao DOM e submete
        document.body.appendChild(form);
        form.submit();
    }
}

