
# Documentação da Task: Login e Controle de Acesso

## 1. Conexão com o Banco de Dados

- Classe `Database` criada com método estático `conectar()` que retorna uma conexão PDO.
- Tratamento de erros na conexão com resposta HTTP 400 e mensagem em JSON ou saída customizada.

```php
try {
    $pdo = new PDO(...);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
} catch (PDOException $e) {
    http_response_code(400);
    echo json_encode(["erro" => "Não foi possível conectar ao banco de dados."]);
    exit;
}
```

## 2. Implementação do Login

- Recebe email e senha via `POST`.
- Valida usuário com método `validarLogin` da model `UsuarioModel`.
- Se sucesso:
  - Armazena dados do usuário em `$_SESSION['usuario']`.
  - Redireciona conforme perfil:
    - `'adm'` e `'professor'` → `home.php`
    - Outros → `pages/home.php`
- Se falha:
  - Armazena mensagem de erro em `$_SESSION['erro_login']`.
  - Redireciona para `login.php`.

## 3. Controle de Acesso nas Páginas Protegidas

- Criado arquivo `auth.php` com:

```php
<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "<script>
        alert('Você precisa fazer login para acessar esta página.');
        window.location.href = '../adm/login.php';
    </script>";
    exit;
}

if (!in_array($_SESSION['usuario']['perfil'], ['adm', 'professor'])) {
    echo "<script>
        alert('Você não tem permissão para acessar esta página.');
        window.location.href = '../adm/login.php';
    </script>";
    exit;
}
```

- Inclusão do `auth.php` no início de todas as páginas que requerem autenticação.

## 4. `session_start()`

- Chamado apenas dentro de `auth.php`.
- Evitar múltiplas chamadas em páginas que incluem `auth.php`.

## 5. Página de erro alternativa

- Inicialmente sugerida página `sem-permissao.php`.
- Optado por usar alertas em JavaScript para avisar e redirecionar.

## 6. Melhorias adicionais

- Uso de variável `$currentTab` para controle das abas ativas.
- Implementação de filtro simples de pesquisa via JavaScript na lista de usuários.
- Organização do código para evitar repetição e facilitar manutenção.

---

## Como usar

- Incluir `require_once 'auth.php'` no topo das páginas protegidas.
- Realizar login pela página que executa a lógica de autenticação.
- Garantir que o perfil do usuário esteja salvo em `$_SESSION['usuario']['perfil']`.

---

Se precisar de ajuda para expandir ou ajustar, é só avisar!  
