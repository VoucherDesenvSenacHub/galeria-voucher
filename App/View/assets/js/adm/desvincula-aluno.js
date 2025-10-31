function confirmarDesvinculacao(pessoaId, turmaId,  nomeAluno ) {  
    const modalAlunoRemover = document.getElementById("modal-desvincular-aluno")  
    const inputAlunoId = document.querySelector("input[name='pessoa_id']")
    const inputTurmaId = document.querySelector("input[name='turma_id']")
    const nomeAlunoinsert = document.getElementById("aluno-confirmacao")    


    nomeAlunoinsert.innerHTML = nomeAluno
    inputTurmaId.value =  turmaId
    inputAlunoId.value = pessoaId
    modalAlunoRemover.style.display = "flex";
}

function fecharModal() {
    const modalAlunoRemover = document.querySelector('.modal-confirmacao');
    modalAlunoRemover.style.display="none";
    
}