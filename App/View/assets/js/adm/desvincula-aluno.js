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
    modal.style.display = "none";
}