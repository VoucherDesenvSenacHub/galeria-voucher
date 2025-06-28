const btnDocente = document.getElementById('btn-docente');
const btnAluno = document.getElementById('btn-aluno');


function toggleActive(btnAtivo, btnInativo) {
btnAtivo.classList.add('active');
btnInativo.classList.remove('active');
}

window.addEventListener('load', () => {
toggleActive(btnDocente, btnAluno);
campoTurma.style.display = 'none'; 
campoStatus.style.display = 'block'; 
})

btnDocente.addEventListener('click', () => {
toggleActive(btnDocente, btnAluno);
campoTurma.style.display = 'none';
campoStatus.style.display = 'block';

document.getElementById("informacoes-adicionais").placeholder = "Digite algo sobre o docente...";

});

btnAluno.addEventListener('click', () => {
toggleActive(btnAluno, btnDocente);
campoTurma.style.display = 'block';
campoStatus.style.display = 'none';
})
