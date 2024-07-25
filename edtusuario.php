  <?php

  $id = intval($_GET['id']);
  include('connection.php');

  $erro = false;
  if (count($_POST) > 0) {
    $nm_usuario = $_POST['nm_usuario'];
    $email_usuario = $_POST['email_usuario'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];
  }

  if (empty($nm_usuario)) {
    $erro = "<p></p>";
  }

  if ($erro) {
    echo "<p><b>$erro</b></p>";
  } else {
    $sql_code = "UPDATE tb_usuario
      SET nm_usuario = '$nm_usuario',
      email_usuario = '$email_usuario',
      tipo = '$tipo'
      WHERE id_usuario = '$id'";
    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
    if ($deu_certo) {
  ?>
      <script>
        alert("Usuario editado com sucesso!");
        window.location.href = "consusuario.php";
      </script>
  <?php
      unset($_POST);
    }
  }

  $sql_usuario = "SELECT * FROM tb_usuario WHERE id_usuario = '$id'";
  $query_usuario = $mysqli->query($sql_usuario) or die($mysqli->error);
  $usuario = $query_usuario->fetch_assoc();


  if (!isset($_SESSION))
    session_start();

  if (!isset($_SESSION['usuario'])) {
    echo '<script>alert("Você precisa estar logado."); window.location.href = "index.php";</script>';
    exit(); // Certifique-se de parar a execução após o redirecionamento
  }
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>CodePen - Products Dashboard UI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="jquery-3.7.1.js"></script>
    <script src="https://kit.fontawesome.com/316b028534.js" crossorigin="anonymous"></script>
  </head>



  <body>
  <div class="app-container">
    <div class="sidebar">
      <div class="sidebar-header">
        <img src="wizard.png" alt="" class="wizardimg">
        <div class="app-icon">
        </div>
      </div>
      <ul class="sidebar-list">
        
        <li class="sidebar-list-item">
          <a href="conslivro.php">
            <i class="fa-solid fa-book"></i>
            <span>Livros</span>
          </a>
          <ul class="submenu">
            <li>
              <a href="conslivro.php">
                <i class="fa-solid fa-list-ul"></i>
                Consultar livros
              </a>
            </li>
            <li>
              <a href="cadlivro.php">
                <i class="fa-solid fa-circle-plus" style="color: #ffffff;"></i>
                Cadastrar livros
              </a>
              <ul class="submenu">
                <li>
                  <a href="cadautor.php">
                    <i class="fa-solid fa-feather-pointed"></i>
                    Cadastrar Autor
                  </a>
                </li>
                <li>
                  <a href="cadeditora.php">
                    <i class="fa-solid fa-tags"></i>
                    Cadastrar Editora
                  </a>
                </li>
                <li>
                  <a href="cadgenero.php">
                    <i class="fa-solid fa-comment-dots"></i>
                    Cadastrar Gênero
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>



        <li class="sidebar-list-item">
          <a href="consemprestimo.php">
            <i class="fa-solid fa-handshake-angle"></i>
            <span>Emprestimos</span>
          </a>
          <ul class="submenu">
            <li><a href="consemprestimo.php">

                <i class="fa-solid fa-list-ul"></i>
                Consultar emprestimos</a></li>
            <li><a href="cademprestimo.php">
                <i class="fa-solid fa-circle-plus"></i>
                Cadastrar emprestimo</a></li>
            <li><a href="conshistoricoemprestimo.php">
                <i class="fa-solid fa-clock-rotate-left"></i>
                Histórico de Emprestimo</a></li>


          </ul>
        </li>


        <li class="sidebar-list-item">
          <a href="emitirrelatorio.php">
            <i class="fa-solid fa-chart-simple"></i>
            <span>Relatórios</span>
          </a>
        </li>



        <li class="sidebar-list-item">
          <a href="conscliente.php">
            <i class="fa-solid fa-user-tag"></i>
            <span>Clientes</span>
          </a>
          <ul class="submenu">
            <li><a href="conscliente.php">
                <i class="fa-solid fa-list-ul"></i>
                Consultar clientes</a></li>
            <li><a href="cadcliente.php">
                <i class="fa-solid fa-circle-plus" style="color: #ffffff;"></i>
                Cadastrar cliente</a></li>
          </ul>
        </li>



        <li class="sidebar-list-item">
          <a href="consusuario.php">
            <i class="fa-solid fa-user"></i>
            <span>Usuarios</span>
          </a>
          <ul class="submenu">
            <li><a href="consusuario.php">
                <i class="fa-solid fa-list-ul"></i>
                Consultar Usuarios</a></li>
            <li><a href="cadusuario.php">
                <i class="fa-solid fa-circle-plus" style="color: #ffffff;"></i>
                Cadastrar Usuarios</a></li>

          </ul>
        </li>

      </ul>

      <div class="account-info">
        <div class="account-info-picture">
          <svg xmlns="http://www.w3.org/2000/svg" height="20" width="28" viewBox="0 0 448 512">
            <path fill="#ffffff" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
          </svg>
        </div>
        <div class="account-info-name"><?php echo $_SESSION['nm_usuario']; ?></div>
        <button name="logout" id="logout" class="account-info-more">
          <a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
        </button>
      </div>
    </div>
      <div class="app-content">
        <div class="app-content-header">
          <h1 class="app-content-headerText">Edição de usuario</h1>
        </div>

        <div class="form-container">
          <form id="inputform" action="" method="post">

            <label for="nm_usuario">Usuário:</label>
            <input value="<?php echo $usuario['nm_usuario']; ?>" type="text" id="nm_usuario" name="nm_usuario">

            <label for="email_usuario">E-mail :</label>
            <input value="<?php echo $usuario['email_usuario']; ?>" type="text" id="email_usuario" name="email_usuario">

            <label for="senha">Senha:</label>
            <input value="<?php echo $usuario['senha']; ?>" type="text" id="senha" name="senha" step="0.01">


            <label for="">Tipo de usuario:</label>
            <select name="tipo" id="tipo">
              <option value="0">Comum</option>
              <option value="1">Administrador</option>

            </select>

            <?php
            if ($erro) {
              echo "<p><b>$erro</b></p>";
            } else { ?>
              <br><br>
              <p>Edição feita com sucesso!</p>
            <?php }
            ?>
            <br>
            <button type="submit">Confirmar edição</button>
            <button class="buttonBack" id="naoButton">Voltar</button>
        </div>
        <script>
          document.getElementById('naoButton').addEventListener('click', function(event) {
            event.preventDefault(); // Evita o comportamento padrão de envio do formulário
            window.location = 'consusuario.php'; // Redireciona para onde desejar
          });
        </script>

        </div>
      </div>
    </div>
  </div>

    <script src="./script.js"></script>

  </body>

  </html>