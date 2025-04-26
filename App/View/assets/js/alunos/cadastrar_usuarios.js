const fileInput = document.getElementById('fileInput');
const previewImg = document.getElementById('preview');

fileInput.addEventListener('change', function () {
  const file = this.files[0];

  if (file) {
    const reader = new FileReader();

    reader.onload = function (e) {
      previewImg.src = e.target.result;
    };

    reader.readAsDataURL(file);
  }
});

  const btnDocente = document.getElementById('btn-docente');
  const btnAluno = document.getElementById('btn-aluno');
  const campoTurma = document.getElementById('campo-turma');
  const campoStatus = document.getElementById('campo-status');
  const textareaSobre = document.getElementById('informacoes-adicionais');
  const labelSobre = document.getElementById('label-sobre');

  function toggleActive(btnAtivo, btnInativo) {
    btnAtivo.classList.add('active');
    btnInativo.classList.remove('active');
  }

  window.addEventListener('load', () => {
    toggleActive(btnDocente, btnAluno);
    campoTurma.style.display = 'none'; 
    campoStatus.style.display = 'block'; 
   
    document.getElementById("informacoes-adicionais").placeholder = "Digite algo sobre o docente...";
  });

  btnDocente.addEventListener('click', () => {
    toggleActive(btnDocente, btnAluno);
    campoTurma.style.display = 'none';
    campoStatus.style.display = 'block';
    // labelSobre.textContent = '';
    // textareaSobre.value = 'Sobre o docente:';
    
    document.getElementById("informacoes-adicionais").placeholder = "Digite algo sobre o docente...";

  });

  btnAluno.addEventListener('click', () => {
    toggleActive(btnAluno, btnDocente);
    campoTurma.style.display = 'block';
    campoStatus.style.display = 'none';
    // labelSobre.textContent = '';
    // textareaSobre.value = ' Sobre o aluno:';

    document.getElementById("informacoes-adicionais").placeholder = "Digite algo sobre o aluno...";
  });