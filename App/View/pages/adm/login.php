<?php 
require_once(__DIR__ . '/../../componentes/head.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../../Config/Database.php';
require_once __DIR__ . '/../../../Model/UsuarioModel.php';

$erro = '';
$pdo = null;
$usuarioModel = null;

// Tenta conectar ao banco antes de processar login
try {
    $pdo = Database::conectar();
    $usuarioModel = new UsuarioModel($pdo);
} catch (Exception $e) {
    $erro = "Erro ao conectar ao banco de dados!";
}

// Redireciona se usuário já estiver logado e for adm ou professor
if (isset($_SESSION['usuario']) && in_array($_SESSION['usuario']['perfil'], ['adm', 'professor'])) {
    header("Location: home-adm.php");
    exit;
}

// Processa o login quando o formulário for enviado e conexão estiver ok
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $usuarioModel !== null) {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $erro = "Preencha todos os campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "E-mail inválido.";
    } else {
        $usuario = $usuarioModel->validarLogin($email, $senha);
        if ($usuario) {
            $_SESSION['usuario'] = $usuario;
            header("Location: home-adm.php");
            exit;
        } else {
            $erro = "E-mail ou senha inválidos!";
        }
    }
}

headerComponent("Voucher Desenvolvedor - Login");
?>

<body class="body-login">
    <?php
    $esconderPesquisa = true;
    $isAdmin = false;
    require_once __DIR__ . '/../../componentes/nav.php';
    require_once __DIR__ . '/../../componentes/users/mira.php';
    ?>

    <main class="main-login">
        <form class="form" method="POST" action="">
            <div class="form-header">
                <h1>Login</h1>
            </div>

            <div class="form-content">
                <div class="form-input required">
                    <input
                        type="email"
                        name="email"
                        placeholder="Email"
                        required
                        autocomplete="username"
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    <input
                        type="password"
                        name="senha"
                        placeholder="Senha"
                        required
                        autocomplete="current-password">
                </div>

                <div class="form-action">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>

            </div>

        </form>
        <?php if ($erro !== ''): ?>
            <div id="erro-msg" class="erro-geral">
                <?= htmlspecialchars($erro) ?>
            </div>
            <script>
                setTimeout(() => {
                    const msg = document.getElementById('erro-msg');
                    if (msg) msg.style.display = 'none';
                }, 5000);
            </script>
        <?php endif; ?>
    </main>

    <?php require_once __DIR__ . '/../../componentes/users/footer.php'; ?>
</body>

</html>