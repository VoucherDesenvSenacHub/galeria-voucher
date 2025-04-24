<?php 
require_once __DIR__ . "/../../componentes/head.php";
?>

<body>
  <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
  <?php require_once __DIR__ . "/../../componentes/adm/nav.php"; ?>

  <main class="conteudo-cadastro">
  <div class="user-profile">
      <div class="user-icon"></div>
      <div><button>DOCENTE</button</div>
      <div><button>ALUNOS</button</div>
    </div>
   

    <div class="container">
      <div class="form-container">
        <h2>Cadastro</h2>
        <form>
          <div class="form-group">
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome">
          </div>

          <div class="form-group">
            <label for="data-nascimento">Data de Nascimento:</label>
            <input type="date" id="data-nascimento" name="data-nascimento">
          </div>

          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
          </div>

          <div class="form-group">
            <label for="polo">Polo:</label>
            <select id="polo" name="polo">
              <option value="polo1">Polo 1</option>
              <option value="polo2">Polo 2</option>
            </select>
          </div>

          <div class="form-group">
            <label for="linkedin">Link do LinkedIn:</label>
            <input type="url" id="linkedin" name="linkedin">
          </div>

          <div class="form-group">
            <label for="github">Link para o GitHub:</label>
            <input type="url" id="github" name="github">
          </div>

          <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone">
          </div>

          <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status">
              <option value="ativo">Ativo</option>
              <option value="inativo">Inativo</option>
            </select>
          </div>

          <div class="form-group">
            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto">
          </div>

          <div class="form-group">
            <label for="informacoes-adicionais">Informações Adicionais:</label>
            <textarea id="informacoes-adicionais" name="informacoes-adicionais"></textarea>
          </div>

          <div class="form-group">
            <button type="button" >Cancelar</button>
            <button type="submit"style="color:green">Cadastrar</button>
          </div>
        </form>
      </div>
    </div>
  </main>
</body>
</html>
