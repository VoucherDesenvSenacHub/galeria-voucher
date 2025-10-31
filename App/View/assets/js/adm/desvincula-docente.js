function confirmarDesvinculacao(pessoaId, turmaId,  nomeDocente ) {  
    const modalProfessorRemover = document.getElementById("modal-desvincular-docente")  
    const inputDocenteId = document.querySelector("input[name='pessoa_id']")
    const inputTurmaId = document.querySelector("input[name='turma_id']")
    const nomeDocenteinsert = document.getElementById("docente-confirmacao")    


    nomeDocenteinsert.innerHTML = nomeDocente
    inputTurmaId.value =  turmaId
    inputDocenteId.value = pessoaId
    modalProfessorRemover.style.display = "flex";
}

function fecharModal() {
    const modalProfessorRemover = document.querySelector('.modal-confirmacao');
    modalProfessorRemover.style.display="none";
    
}