<?php

 $id = intval($_GET['id']);
 include('connection.php');

      $erro = false;
      if(count($_POST) > 0){
        $nm_livro = $_POST['nm_livro'];
        $qtd= $_POST['qtd'];
        $nro_pg = $_POST['nro_pg'];
        $ano = $_POST['ano'];
        $isbn = $_POST['isbn'];
        $localizacao = $_POST['localizacao'];
        $fk_id_grupo = $_POST['grupo'];
        $fk_id_editora = $_POST['editora'];
        $fk_id_genero = $_POST['genero'];
        $fk_id_autor = $_POST['autor'];
      

      }

      if (empty($nm_livro)) {
        $erro = "<p></p>";
    }

    if ($erro) {
      echo "<p><b>$erro</b></p>";
  } else {
      $sql_code = "UPDATE tb_livro
      SET nm_livro = '$nm_livro',
      qtd = '$qtd',
      nro_pg = '$nro_pg',
      ano = '$ano',
      isbn = '$isbn',
      localizacao = '$localizacao',
      fk_id_grupo = '$fk_id_grupo',
      fk_id_editora = '$fk_id_editora',
      fk_id_genero = '$fk_id_genero',
      fk_id_autor = '$fk_id_autor'
      WHERE id_livro = '$id'";
      $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
      if ($deu_certo) {
          ?>
          <script>
          alert("Livro editado com sucesso");
          window.location.href = "conslivro.php";
          </script>
          <?php
          unset($_POST);
      }
  }

  $sql_livro = "SELECT * FROM tb_livro WHERE id_livro = '$id'";
  $query_livro = $mysqli->query($sql_livro) or die($mysqli->error);
  $livro = $query_livro->fetch_assoc();
  
  $sql_code_genero = "SELECT * FROM tb_genero";
  $sql_query_genero = $mysqli->query($sql_code_genero) or die($mysqli->error);
  
  $sql_code_grupo = "SELECT * FROM tb_grupo ORDER BY grupo ASC";
  $sql_query_grupo = $mysqli->query($sql_code_grupo) or die($mysqli->error);
  
  $sql_code_editora = "SELECT * FROM tb_editora ORDER BY editora ASC";
  $sql_query_editora = $mysqli->query($sql_code_editora) or die($mysqli->error);
  
  $sql_code_autor = "SELECT * FROM tb_autor ORDER BY autor ASC";
  $sql_query_autor = $mysqli->query($sql_code_autor) or die($mysqli->error);
  

  $sql_code_estado = "SELECT * FROM tb_estado ORDER BY nm_estado ASC";
  $sql_query_estado= $mysqli->query($sql_code_estado) or die($mysqli->error);

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
  <script type="text/javascript" src="jquery-3.7.1.js" ></script>
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
        <h1 class="app-content-headerText">Edição de cliente</h1>
        </div>

      <div class="form-container">
        <form id="inputform" action="" method="post">
         
        <label for="nm_livro">Livro:</label>
            <input  value="<?php echo $livro['nm_livro'];?>" type="text" id="nm_livro" name="nm_livro" required>

            <label for="qtd">Quantidade:</label>
            <input value="<?php echo $livro['qtd'];?>" type="text" id="qtd" name="qtd" required>

            <label for="nro_pg">Numero de páginas:</label>
            <input  value="<?php echo $livro['nro_pg'];?>" type="number" id="nro_pg" name="nro_pg" required></input>

            <label for="ano">Ano de lançamento:</label>
            <input  value="<?php echo $livro['ano'];?>" type="number" id="ano" name="ano" required>

            <label for="isbn">ISBN:</label>
            <input  value="<?php echo $livro['isbn'];?>" type="number" id="isbn" name="isbn" required>
            
            <label for="editora">Editora: </label>
          <select name="editora" id="editora">
            <option value="">Selecione a editora</option>
            <?php while ($editora = $sql_query_editora->fetch_assoc()) { ?>
              <option value="<?php echo $editora['id_editora']; ?>" <?php echo $editora['id_editora'] == $livro['fk_id_editora'] ? 'selected' : ''; ?>>
                <?php echo $editora['editora']; ?>
              </option>
            <?php } ?>
          </select>

          <label for="grupo">Grupo: </label>
          <select name="grupo" id="grupo">
            <option value="">Selecione o grupo</option>
            <?php while ($grupo = $sql_query_grupo->fetch_assoc()) { ?>
              <option value="<?php echo $grupo['id_grupo']; ?>" <?php echo $grupo['id_grupo'] == $livro['fk_id_grupo'] ? 'selected' : ''; ?>>
                <?php echo $grupo['grupo']; ?>
              </option>
            <?php } ?>
          </select>

          <label for="genero">Gênero: </label>
          <select name="genero" id="genero">
            <option value="">Selecione o gênero</option>
            <?php while ($genero = $sql_query_genero->fetch_assoc()) { ?>
              <option value="<?php echo $genero['id_genero']; ?>" <?php echo $genero['id_genero'] == $livro['fk_id_genero'] ? 'selected' : ''; ?>>
                <?php echo $genero['genero']; ?>
              </option>
            <?php } ?>
          </select>

          <label for="autor">Autor principal: </label>
          <select name="autor" id="autor">
            <option value="">Selecione o autor</option>
            <?php while ($autor = $sql_query_autor->fetch_assoc()) { ?>
              <option value="<?php echo $autor['id_autor']; ?>" <?php echo $autor['id_autor'] == $livro['fk_id_autor'] ? 'selected' : ''; ?>>
                <?php echo $autor['autor']; ?>
              </option>
            <?php } ?>
          </select>
            <label for="localizacao">Localização:</label>
            <input value="<?php echo $livro['localizacao'];?>" type="text" id="localizacao" name="localizacao" required>

           <br>
            <button type="submit" id="confirmButton" >Confirmar edição</button>   
            <button class="buttonBack" id="naoButton">Voltar</button>
    </div>
    <script>
    document.getElementById('naoButton').addEventListener('click', function(event) {
      event.preventDefault(); // Evita o comportamento padrão de envio do formulário
      window.location = 'conslivro.php'; // Redireciona para onde desejar

    });



  </script>
    </div>
  </div>
  </div>
  </div>
  
  <script src="./script.js"></script>

</body>

</html>
