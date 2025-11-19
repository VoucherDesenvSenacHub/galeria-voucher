function confirmarDesvinculacao(pessoaId, turmaId,  nomeAluno ) {  
    const modalAlunoRemover = document.getElementById("modal-desvincular-aluno")  
    if (!modalAlunoRemover) return;
    
    const inputAlunoId = modalAlunoRemover.querySelector("input[name='pessoa_id']")
    const inputTurmaId = modalAlunoRemover.querySelector("input[name='turma_id']")
    const nomeAlunoinsert = document.getElementById("aluno-confirmacao")    

    if (nomeAlunoinsert) nomeAlunoinsert.innerHTML = nomeAluno
    if (inputTurmaId) inputTurmaId.value = turmaId
    if (inputAlunoId) inputAlunoId.value = pessoaId
    modalAlunoRemover.style.display = "block";
}

function fecharModal() {
    const modalAlunoRemover = document.getElementById("modal-desvincular-aluno");
    modalAlunoRemover.style.display="none";
    
}