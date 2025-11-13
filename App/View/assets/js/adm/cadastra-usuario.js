let tipoUsuario = document.querySelector('#tipo-usuario')


tipoUsuario.addEventListener('change', (e) => {
    let inputSenha = document.querySelector('.input-container-senha')
    let valorSelecionado = e.target.value;

    if (valorSelecionado == 'aluno') {
        inputSenha.classList.add('ativo');
    } else {
        inputSenha.classList.remove('ativo');
    }
})

document.getElementById('fileInput').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        console.log(file)
        document.getElementById('preview').src = URL.createObjectURL(file);
    }
});
document.querySelector('.back-button').addEventListener('click', function (e) {
    e.preventDefault();
    window.history.back();
});

