let tipoUsuario = document.querySelector('#tipo-usuario');

tipoUsuario.addEventListener('change', (e) => {
    let inputSenhaContainer = document.querySelector('.input-container-senha');
    let senha = document.querySelector('#input_senha'); // <<< ADICIONADO
    let valorSelecionado = e.target.value;

    if (valorSelecionado === 'aluno') {
        // esconde o container
        inputSenhaContainer.classList.add('ativo');

        // desativa e remove a obrigatoriedade
        senha.disabled = true;
        senha.removeAttribute('required');

    } else {
        // mostra o container de volta
        inputSenhaContainer.classList.remove('ativo');

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

// Botão voltar
document.querySelector('.back-button').addEventListener('click', function (e) {
    e.preventDefault();
    window.history.back();
});
