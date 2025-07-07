# Componente de Navegação Unificado

O arquivo `nav.php` agora é unificado e pode ser usado tanto para páginas de usuários quanto de administradores.

## Como usar:

### Para páginas de usuários (com barra de pesquisa):
```php
<?php 
    $isAdmin = false; // ou simplesmente não definir
    require_once __DIR__ . "/../../componentes/nav.php";
?>
```

### Para páginas de administradores (sem barra de pesquisa):
```php
<?php 
    $isAdmin = true;
    require_once __DIR__ . "/../../componentes/nav.php";
?>
```

### Para páginas que precisam esconder a barra de pesquisa:
```php
<?php 
    $isAdmin = false;
    $esconderPesquisa = true;
    require_once __DIR__ . "/../../componentes/nav.php";
?>
```

## Parâmetros disponíveis:

- **`$isAdmin`** (boolean): 
  - `true` = Aplica classe `nav-adm` e remove barra de pesquisa
  - `false` = Estilo normal de usuário com barra de pesquisa (padrão)

- **`$esconderPesquisa`** (boolean):
  - `true` = Esconde a barra de pesquisa mesmo em páginas de usuário
  - `false` = Mostra a barra de pesquisa (padrão)

- **`$useHeader`** (boolean):
  - `true` = Envolve o nav em uma tag `<header>` (padrão para users)
  - `false` = Não usa tag header (padrão para admin)

## Vantagens:

✅ **Um único arquivo** para manter
✅ **Flexibilidade** com parâmetros
✅ **Compatibilidade** com código existente
✅ **Fácil manutenção**

## Arquivos antigos que foram removidos:

- `App/View/componentes/users/nav.php` (substituído)
- `App/View/componentes/adm/nav.php` (substituído) 