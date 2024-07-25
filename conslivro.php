<?php

include('connection.php'); //conexao com o banco

$sql_livro = "SELECT l.*, a.autor, g.genero, gr.grupo, e.editora
             FROM tb_livro l 
             INNER JOIN tb_autor a ON l.fk_id_autor = a.id_autor
             INNER JOIN tb_genero g ON l.fk_id_genero = g.id_genero
             INNER JOIN tb_grupo gr ON l.fk_id_grupo = gr.id_grupo
             INNER JOIN tb_editora e ON l.fk_id_editora = e.id_editora";

// Verifica se há um termo de busca
if (isset($_GET['search'])) {
  $search = $_GET['search'];
  // Adiciona a condição de busca à consulta SQL
  $sql_livro .= " WHERE l.nm_livro LIKE '%$search%' 
                  OR a.autor LIKE '%$search%' 
                  OR g.genero LIKE '%$search%' 
                  OR gr.grupo LIKE '%$search%' 
                  OR e.editora LIKE '%$search%'
                  OR l.localizacao LIKE '%$search%'";
}

$query_livro = $mysqli->query($sql_livro) or die($mysqli->error);
$num_livro = $query_livro->num_rows;

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
        <h1 class="app-content-headerText">Lista de livros</h1>
        <form action="" method="get" class="app-content-headerForm">
          <input type="text" name="search" placeholder="Pesquisar" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
          <button type="submit"><i class="fas fa-search"></i></button>
        </form>
      </div>
      <table class="tableviewcons">
        <thead class="tableheadercons">
          <th>Id</th>
          <th>Livro</th>
          <th>Quantidade</th>
          <th>Grupo</th>
          <th>Nº de pag</th>
          <th>Ano pub</th>
          <th>ISBN</th>
          <th>Editora</th>
          <th>Gênero</th>
          <th>Autor</th>
          <th>Local</th>
          <th>Ações</th>
        </thead>
        <tbody>

          <?php if ($num_livro == 0) { ?>
            <tr>
              <td colspan="7">Nenhum livro cadastrado no sistema</td>
            </tr>
            <?php } else {
            while ($livro = $query_livro->fetch_assoc()) {
            ?>

              <tr class="itemrowcons">
                <td> <?php echo $livro['id_livro']; ?> </td>
                <td> <?php echo $livro['nm_livro']; ?> </td>
                <td> <?php echo $livro['qtd']; ?> </td>
                <td> <?php echo $livro['grupo']; ?> </td>
                <td> <?php echo $livro['nro_pg']; ?> </td>
                <td> <?php echo $livro['ano']; ?> </td>
                <td> <?php echo $livro['isbn']; ?> </td>
                <td> <?php echo $livro['editora']; ?> </td>
                <td> <?php echo $livro['genero']; ?> </td>
                <td> <?php echo $livro['autor']; ?> </td>
                <td> <?php echo $livro['localizacao']; ?> </td>

                <td class="edit-iconcons"> <a href="edtlivro.php?id=<?php echo $livro['id_livro']; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                      <path fill="#ffffff" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                    </svg></a>
                  <a href="dellivro.php?id=<?php echo $livro['id_livro']; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                      <path fill="#ffffff" d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z" />
                    </svg></a>
                </td>

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