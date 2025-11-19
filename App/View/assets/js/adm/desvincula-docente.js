function confirmarDesvinculacao(pessoaId, turmaId,  nomeDocente ) {  
    const modalProfessorRemover = document.getElementById("modal-desvincular-docente")  
    if (!modalProfessorRemover) return;
    
    const inputDocenteId = modalProfessorRemover.querySelector("input[name='pessoa_id']")
    const inputTurmaId = modalProfessorRemover.querySelector("input[name='turma_id']")
    const nomeDocenteinsert = document.getElementById("docente-confirmacao")    

    if (nomeDocenteinsert) nomeDocenteinsert.innerHTML = nomeDocente
    if (inputTurmaId) inputTurmaId.value = turmaId
    if (inputDocenteId) inputDocenteId.value = pessoaId
    modalProfessorRemover.style.display = "flex";
}

function fecharModal() {
    const modalProfessorRemover = document.getElementById("modal-desvincular-docente");
    modalProfessorRemover.style.display="none";
    
}