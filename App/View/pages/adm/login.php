<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../../../config/Database.php');
require_once(__DIR__ . '/../../../model/UsuarioModel.php');
require_once(__DIR__ . '/../../componentes/head.php');

$pdo = Database::conectar();
$usuarioModel = new UsuarioModel($pdo);

$erro = '';

// Se já estiver logado, redireciona para home-adm.php
if (isset($_SESSION['usuario']) && in_array($_SESSION['usuario']['perfil'], ['adm', 'professor'])) {
    header("Location: home-adm.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!empty($email) && !empty($senha)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
    } else {
        $erro = "Preencha todos os campos.";
    }
}
?>

<body class="body-login">
    <?php
    $esconderPesquisa = true;
    $isAdmin = false;
    require_once(__DIR__ . '/../../componentes/nav.php');
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
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    >
                    <input
                        type="password"
                        name="senha"
                        placeholder="Senha"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <div class="form-action">
                    <button type="submit" class="btn btn-primary">Login</button>

                    <?php if (!empty($erro)): ?>
                        <div style="color: red; text-align: center; margin-top: 10px;">
                            <?= htmlspecialchars($erro) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </main>

    <?php require_once __DIR__ . '/../../componentes/users/footer.php'; ?>
</body>
</html>
