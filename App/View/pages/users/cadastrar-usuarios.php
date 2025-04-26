<?php 
require_once __DIR__ . "/../../componentes/head.php";

?>

<body>
  <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
  <?php require_once __DIR__ . "/../../componentes/adm/nav.php"; ?>

  <main class="conteudo-cadastro">
    <div class="user-profile">
      <div class="user-icon"></div>
      <div><button id="btn-docente">DOCENTE</button></div>
      <div><button id="btn-aluno" >ALUNOS</button></div>
    </div>
   
   

    <div class="container-users">
      <div class="form-container-users">
        <h1>Cadastro</h1>
        <form class="form-dados">
          <div class="form-group">
            
            <input type="text" placeholder=" Nome Completo" id="nome" name="nome">

            <input type="email" placeholder=" Email" id="email" name="email">

            <input type="url" id="linkedin" name="linkedin" placeholder=" Link do linkedin:">
            
            <input type="url" id="github" name="github" placeholder=" Link para o GitHub:">
           
            <input type="tel" id="telefone" name="telefone" placeholder=" Telefone:">
          </div>


          <div class="form-group-polo">
            <input type="date" placeholder="Data de Nascimento" id="data-nascimento" name="data-nascimento">

            <select id="polo" name="polo">
              <option value="">Polo:</option>
              <option value="polo1">Campo Grande</option>
              <option value="polo2">Tres Lagoas</option>
              <option value="polo2">Dourados</option>
              <option value="polo2">Corumba</option>
              <option value="polo2">Ponta Pora</option>
            </select>

            <select id="campo-turma" name="turma">
              <option value="">Turma:</option>
              <option value="turma1">Turma 144</option>
              <option value="turma2">Turma 145</option>
              <option value="turma3">Turma 146</option>
              <option value="turma4">Turma 147</option>
              <option value="turma5">Turma 148 </option>
            </select>

          </div>

          <div class="form-group-imagem">
            <div class="input-file-cadastro">
              <label class="input-file-wrapper">
                <img id="preview" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>utilitarios/avatar.png" alt="Upload" />
                <input type="file" id="fileInput" accept="image/*" />
              </label>
            </div>

            <label for="status">Status:</label>
            <select id="campo-status" name="status">
              <option value="ativo">Ativo</option>
              <option value="inativo">Inativo</option>
            </select>
          </div>
        </form>
        <div class="form-group-about">
          <textarea id="informacoes-adicionais" name="informacoes-adicionais" rows="15" cols="140" placeholder="Digite algo sobre o docente..." ></textarea>
        </div>

        <div class="form-group-buton">
          <button type="button" >Cancelar</button>
          <button type="submit"style="color:green">Cadastrar</button>
        </div>
      </div>
    </div>
  </main>

  <script src="../../assets/js/alunos/cadastrar_usuarios.js"></script>
</body>
</html>
