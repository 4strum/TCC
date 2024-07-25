  <?php

 $id = intval($_GET['id']);
 include('connection.php');

      $erro = false;
      if(count($_POST) > 0){
        $nm_cliente = $_POST['nm_cliente'];
        $cpf= $_POST['cpf'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $cep = $_POST['cep'];
        $end_rua = $_POST['end_rua'];
        $end_nro = $_POST['end_nro'];
        $end_bairro = $_POST['end_bairro'];
        $fk_id_cidade = $_POST['cidade'];

      

      }

      if (empty($nm_cliente)) {
        $erro = "<p></p>";
    }

    if ($erro) {
      echo "<p><b>$erro</b></p>";
  } else {
      $sql_code = "UPDATE tb_cliente 
      SET nm_cliente = '$nm_cliente',
      cpf = '$cpf',
      email = '$email',
      telefone = '$telefone',
      cep = '$cep',
      end_rua = '$end_rua',
      end_nro = '$end_nro',
      end_bairro = '$end_bairro',
      fk_id_cidade = '$fk_id_cidade'
      WHERE id_cliente = '$id'";
      $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
      if ($deu_certo) {
          ?>
          <script>
              alert("Cliente editado com sucesso!");
              window.location.href = "conscliente.php";
          </script>
          <?php
          unset($_POST);
      }
  }

  $sql_cliente = "SELECT * FROM tb_cliente WHERE id_cliente = '$id'";
  $query_clientes = $mysqli->query($sql_cliente) or die($mysqli->error);
  $cliente = $query_clientes->fetch_assoc();
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
         
            <label for="nm_cliente">Nome Completo:</label>
            <input value="<?php echo $cliente['nm_cliente'];?>" type="text" id="nm_cliente" name="nm_cliente">

            <label for="cpf">CPF:</label>
            <input value="<?php echo $cliente['cpf'];?>" type="text" id="cpf" name="cpf" >

            <label for="email">E-mail:</label>
            <input value="<?php echo $cliente['email'];?>" type="text" id="email" name="email" step="0.01" >

            <label for="telefone">Telefone:</label>
            <input value="<?php echo $cliente['telefone'];?>" type="text" id="telefone" name="telefone" placeholder="(48) 99999-9999" ></input>

            <label for="cep_cliente">CEP:</label>
            <input value="<?php echo $cliente['cep'];?>" type="text" id="cep" name="cep" >

            <label for="end_rua">Rua:</label>
            <input value="<?php echo $cliente['end_rua'];?>" type="text" id="end_rua" name="end_rua" >

            <label for="end_nro">Número:</label>
            <input value="<?php echo $cliente['end_nro'];?>" type="number" id="end_nro" name="end_nro" >

            <label for="end_bairro">Bairro:</label>
            <input value="<?php echo $cliente['end_bairro'];?>" type="text" id="end_bairro" name="end_bairro" >

            <label for="estado">Estado: </label>
            <select display="none" name="estado" id="estado">
              <option value="">Selecione o estado</option>
              <?php while ($estado = $sql_query_estado->fetch_assoc()) { ?>
              <option value="<?php echo $estado['id_estado']; ?>"><?php echo $estado['nm_estado']; ?></option>
              <?php }?>
            </select>
            
            
            <label for="cidade">Cidade: </label>
            <select name="cidade" id="cidade" style="margin-left: 32px;"></select>

            <script>
            $("#estado").on("change",function(){
              var idEstado = $("#estado").val();
              
              $.ajax({
                url: 'pega_cidade.php',
                type: 'POST',
                data:{id:idEstado},
                beforeSend: function(){
                  $("#cidade").css({'display':'block'});
                  $("#cidade").html("Carregando...");
                 
                },
                success: function(data){
                  $("#cidade").css({'display':'block'});
                  $("#cidade").html(data);
                },
                error: function(data){
                  $("#cidade").css({'display':'block'});
                  $("#cidade").html("houve um erro ao carregar");
                }
              });

            });

            </script>
            <?php
                    if ($erro) {
                      echo "<p><b>$erro</b></p>";
                  } else {?>
                      <br><br><p>Edição feita com sucesso!</p>
                <?php }
                    ?>
              <br>
            <button type="submit">Confirmar edição</button>     
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
