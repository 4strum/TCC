<?php

include('connection.php'); //conexao com o banco

$sql_emprestimo = "SELECT e.*, c.nm_cliente, u.nm_usuario, l.nm_livro, DATE_FORMAT(e.dt_devolucao, '%d/%m/%Y') AS dt_devolucao ,DATE_FORMAT(e.dt_emprestimo, '%d/%m/%Y') AS dt_emprestimo
                   FROM tb_emprestimo e
                   INNER JOIN tb_cliente c ON e.fk_id_cliente = c.id_cliente
                   INNER JOIN tb_livro l ON e.fk_id_livro = l.id_livro
                  INNER JOIN tb_usuario u ON e.fk_id_usuario = u.id_usuario";

if (isset($_GET['search'])) {
  $search = $_GET['search'];
  // Adiciona a condição de busca à consulta SQL
  $sql_emprestimo .= " WHERE c.nm_cliente LIKE '%$search%' OR l.nm_livro LIKE '%$search%'";
}


$query_emprestimo = $mysqli->query($sql_emprestimo) or die($mysqli->error);
$num_emprestimo = $query_emprestimo->num_rows;


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
  <title>Clientes - Arcane system</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="style.css">
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
        <h1 class="app-content-headerText">Lista de emprestimos</h1>
        <form action="" method="get" class="app-content-headerForm">
          <input type="text" name="search" placeholder="Pesquisar" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
          <button type="submit"><i class="fas fa-search"></i></button>
        </form>
      </div>
      <table class="tableviewcons">
        <thead class="tableheadercons">
          <th>Id</th>
          <th>Cliente</th>
          <th>Livro</th>
          <th>Data da devolução</th>
          <th>Data de emprestimo</th>
          <th>Preço emprestimo</th>
          <th>Usuario</th>
          <th>Confirmar</th>
          <th>Recibo</th>

        </thead>
        <tbody>

          <?php if ($num_emprestimo == 0) { ?>
            <tr>
              <td colspan="7">Nenhum emprestimo realizado</td>
            </tr>
            <?php } else {
            while ($emprestimo = $query_emprestimo->fetch_assoc()) {
            ?>

              <tr class="itemrowcons">
                <td> <?php echo $emprestimo['id_emprestimo']; ?> </td>
                <td> <?php echo $emprestimo['nm_cliente']; ?> </td>
                <td> <?php echo $emprestimo['nm_livro']; ?> </td>
                <td> <?php echo $emprestimo['dt_devolucao']; ?> </td>
                <td> <?php echo $emprestimo['dt_emprestimo']; ?> </td>
                <td>R$ <?php echo $emprestimo['preco_emprestimo']; ?> </td>
                <td> <?php echo $emprestimo['nm_usuario']; ?> </td>

                <td class="edit-iconcons"> <a href="delemprestimo.php?id=<?php echo $emprestimo['id_emprestimo']; ?>"><i class="fa-solid fa-check"></i></a>
                <td> <a href="pdf.php?id=<?php echo $emprestimo['id_emprestimo']; ?>" target="_blank">
                <i class="fa-solid fa-receipt" style="color: #ffffff;"></i>
                  </a></td>
            <?php
            }
          } ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- partial -->
  <script src="../script.js"></script>



</body>

</html>