let tipoUsuario = document.querySelector('#tipo-usuario');

tipoUsuario.addEventListener('change', (e) => {
    let inputSenhaContainer = document.querySelector('.input-senha');
    let senha = document.querySelector('#input_senha');
    let valorSelecionado = e.target.value;

    if (valorSelecionado === 'aluno') {
        // esconde o container
        inputSenhaContainer.classList.add('hide');

        // desativa e remove a obrigatoriedade
        senha.disabled = true;
        senha.removeAttribute('required');

    } else {
        // mostra o container de volta
        inputSenhaContainer.classList.remove('hide');

        // reativa e torna obrigatório
        senha.disabled = false;
        senha.setAttribute('required', true);
    }
});

// Preview de imagem
document.getElementById('fileInput').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        document.getElementById('preview').src = URL.createObjectURL(file);
    }
});
