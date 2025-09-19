function confirmarDesvinculacao(pessoaId, turmaId,  nomeDocente ) {  
    const modal = document.getElementById("modal-desvincular-docente")  
    const inputDocenteId = document.querySelector("input[name='pessoa_id']")
    const inputTurmaId = document.querySelector("input[name='turma_id']")
    const nomeDocenteinsert = document.getElementById("docente-confirmacao")    


    nomeDocenteinsert.innerHTML = nomeDocente
    inputTurmaId.value =  turmaId
    inputDocenteId.value = pessoaId
    modal.style.display = "flex";
}

function fecharModal() {
    const modal = document.querySelector('.modal-confirmacao');
    modal.style.display = "none";
}