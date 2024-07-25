<?php
if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['usuario'])) {
  die('Você não está logado <a href="Telalogin/index.php"> Clique aqui</a> para logar');
}

include('connection.php');

$erro = false;
if (count($_POST) > 0) {
  $fk_id_cliente = $_POST['fk_id_cliente'];
  $fk_id_livro = $_POST['fk_id_livro'];
  $dt_devolucao = $_POST['dt_devolucao'];
  $preco_emprestimo = $_POST['preco_emprestimo'];
  $fk_id_usuario = $_SESSION['usuario'];

  // Fetch the current quantity of the book
  $sql_qtd_livro = "SELECT qtd FROM tb_livro WHERE id_livro = '$fk_id_livro'";
  $result_qtd_livro = $mysqli->query($sql_qtd_livro) or die($mysqli->error);
  $row_qtd_livro = $result_qtd_livro->fetch_assoc();
  $qtd_atual = $row_qtd_livro['qtd'];

  if ($qtd_atual - 1 < 0) {
    echo "<script>alert('Este livro está emprestado ou você não possui ele em estoque!'); window.location.href = 'cademprestimo.php';</script>";
    die();
  }

  if (empty($fk_id_livro) || empty($fk_id_cliente)) {
    $erro = "Preencha todos os campos obrigatórios.";
  }

  if (!$erro) {
    $sql_code = "INSERT INTO tb_emprestimo(fk_id_cliente, fk_id_livro, dt_devolucao, dt_emprestimo, preco_emprestimo, fk_id_usuario)
                     VALUES ('$fk_id_cliente', '$fk_id_livro', '$dt_devolucao', NOW(), '$preco_emprestimo', '$fk_id_usuario')";
    $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);

    if ($deu_certo) {
      // Fetch the names of the client and book
      $sql_cliente = "SELECT nm_cliente FROM tb_cliente WHERE id_cliente = '$fk_id_cliente'";
      $result_cliente = $mysqli->query($sql_cliente) or die($mysqli->error);
      $row_cliente = $result_cliente->fetch_assoc();
      $nm_cliente = $row_cliente['nm_cliente'];

      $sql_livro = "SELECT nm_livro FROM tb_livro WHERE id_livro = '$fk_id_livro'";
      $result_livro = $mysqli->query($sql_livro) or die($mysqli->error);
      $row_livro = $result_livro->fetch_assoc();
      $nm_livro = $row_livro['nm_livro'];
    } else {
      echo "Erro ao registrar empréstimo.";
    }
  } else {
    echo "<p><b>$erro</b></p>";
  }
}

// Fetch data for dropdowns
$sql_code_cliente = "SELECT * FROM tb_cliente ORDER BY nm_cliente ASC";
$sql_query_cliente = $mysqli->query($sql_code_cliente) or die($mysqli->error);

$sql_code_livro = "SELECT * FROM tb_livro ORDER BY nm_livro ASC";
$sql_query_livro = $mysqli->query($sql_code_livro) or die($mysqli->error);

$sql_code_usuario = "SELECT * FROM tb_usuario ORDER BY nm_usuario ASC";
$sql_query_usuario = $mysqli->query($sql_code_usuario) or die($mysqli->error);

if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['usuario'])) {
  echo '<script>alert("Você precisa estar logado."); window.location.href = "index.php";</script>';
  exit();
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
        <h1 class="app-content-headerText">Cadastro de emprestimos</h1>
      </div>
      <div class="form-container">
        <form id="inputform" action="" method="post">

          <label for="fk_id_cliente">Cliente: </label>
          <select display="none" name="fk_id_cliente" id="fk_id_cliente">
            <option value="">Selecione o cliente</option>
            <?php while ($cliente = $sql_query_cliente->fetch_assoc()) { ?>
              <option value="<?php echo $cliente['id_cliente']; ?>"><?php echo $cliente['nm_cliente']; ?></option>
            <?php } ?>
          </select>

          <label for="fk_id_livro">livro: </label>
          <select display="none" name="fk_id_livro" id="fk_id_livro">
            <option value="">Selecione o livro</option>
            <?php while ($livro =  $sql_query_livro->fetch_assoc()) { ?>
              <option value="<?php echo $livro['id_livro']; ?>"><?php echo $livro['nm_livro']; ?></option>
            <?php } ?>
          </select>

          <label for="dt_devolucao">Data da devolução:</label>
          <input type="date" id="dt_devolucao" name="dt_devolucao" required>


          <label for="preco_emprestimo">Valor do empréstimo:</label>
          <input type="text" id="preco_emprestimo" name="preco_emprestimo" required>

          <script>
            document.addEventListener('DOMContentLoaded', function() {
              var input = document.getElementById('preco_emprestimo');
              input.value = 'R$ ';

              // Filtra caracteres não numéricos, exceto vírgulas e pontos
              input.addEventListener('input', function() {
                var value = input.value.replace(/[^0-9,.]/g, '');
                input.value = 'R$ ' + value;
              });
            });

            document.querySelector('form').addEventListener('submit', function(evt) {
              var input = document.getElementById('preco_emprestimo');
              input.value = input.value.replace('R$', '').trim();
            });
          </script>
          <br>
          <button type="submit" style="font-size: 14px">Cadastrar empréstimo</button>
        </form>
      </div>
    </div>
  </div>
  </div>
  </div>
</body>

</html>