<?php
$teste = 'AAAAAA';
session_start();

// Verifique se o usuário está logado
if (!isset($_SESSION['usuario'])) {
  echo '<script>alert("Você precisa estar logado."); window.location.href = "index.php";</script>';
  exit(); // Pare a execução após o redirecionamento
}

// Inclua o arquivo de conexão com o banco de dados
include('connection.php');

// Variável para armazenar os resultados da consulta
$resultados = [];

// Processamento do formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $tipo_relatorio = $_POST['relatorio'];
  $dt_inicio = $_POST['dt_inicio'];
  $dt_fim = $_POST['dt_fim'];

  // Consulta SQL dependendo do tipo de relatório selecionado
  switch ($tipo_relatorio) {
      case 'clientes':
        $sql = "SELECT id_cliente  AS 'ID', nm_cliente AS 'Nome', cpf AS 'CPF', email AS 'E-mail', end_rua AS 'Rua', end_nro AS 'Nº', end_bairro AS 'Bairro' FROM tb_cliente WHERE data_criacao BETWEEN '$dt_inicio' AND DATE_ADD('$dt_fim', INTERVAL 1 DAY) - INTERVAL 1 SECOND";
      break;
    case 'editora':
      $sql = "SELECT id_editora  AS 'ID', editora AS 'Editora' FROM tb_editora";
      break;
    case 'livros':
      $sql = "SELECT id_livro AS 'ID', nm_livro AS 'Título', qtd AS 'Quantidade', ano AS 'Ano', nro_pg AS 'Nº de Paginas', isbn AS 'ISBN' FROM tb_livro";
      break;
    case 'editora':
      $sql = "SELECT id_editora AS 'ID', editora AS 'Editora' FROM tb_editora";
      break;
    case 'genero':
      $sql = "SELECT id_genero AS 'ID', genero AS 'Gênero Literário' FROM tb_genero";
      break;
    case 'autor':
      $sql = "SELECT id_autor AS 'ID', autor AS 'Nome do Autor' FROM tb_autor";
      break;
    case 'emp':
      $sql = "SELECT id_historico_emprestimo AS 'ID', fk_id_cliente AS 'Cliente', fk_id_livro AS 'Livro', dt_emprestimo AS 'Data de Empréstimo' WHERE data_criacao BETWEEN '$dt_inicio' AND DATE_ADD('$dt_fim', INTERVAL 1 DAY) - INTERVAL 1 SECOND";
      break;
    case 'maisEmp':
      $sql = "SELECT fk_id_livro AS 'ID do Livro', COUNT(fk_id_livro) AS 'Número de Empréstimos'
                    FROM tb_historico_emprestimo
                    GROUP BY fk_id_livro
                    ORDER BY COUNT(fk_id_livro) DESC";
      break;
    default:
      die('Tipo de relatório inválido');
      break;
  }

  // Executar consulta SQL e armazenar resultadosx
  $result = $mysqli->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $resultados[] = $row; // Armazena cada linha da consulta
    }
  } else {
    $resultados = false; // Indica que não há resultados
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>CodePen - Products Dashboard UI</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="stylerel.css">
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
        <h1 class="app-content-headerText">Cadastro de empréstimos</h1>
      </div>
      <div class="form-container-relatorio">
        <form id="inputformrelatorio" action="" method="post">
          <label for="relatorio">Relatório: </label>
          <select name="relatorio" id="relatorio">
            <option value="">Selecione o relatório</option>
            <option value="clientes">1 - Clientes cadastrados</option>
            <option value="livros">2 - Livros cadastrados</option>
            <option value="emp">3 - Empréstimos realizados</option>
            <option value="maisEmp">4 - Livros mais emprestados</option>
            <option value="editora">5 - Editoras cadastradas</option>
            <option value="genero">6 - Gêneros cadastrados</option>
            <option value="autor">7 - Autores cadastrados</option>
          </select>
          <label for="dt_inicio" style="margin-right: 30px; margin-left: 20px;">Data de início:</label>
          <input type="date" id="dt_inicio" name="dt_inicio">
          <label for="dt_fim" style="margin-right: 15px; margin-left: 20px;">Data de fim:</label>
          <input type="date" id="dt_fim" name="dt_fim">
          <button type="submit">Emitir relatório</button>
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST") : ?>
          <?php if ($resultados !== false) : ?>
            <div class="result-container-relatorio">
              <h2>Resultados da consulta:</h2>
              <table class="tableviewconsrel">
                <div class="corpotabela">
                  <thead class="tableheaderconsrel">
                    <!-- Cabeçalho da tabela -->
                    <tr>
                      <?php foreach ($resultados[0] as $key => $value) : ?>
                        <th><?php echo $key; ?></th>
                      <?php endforeach; ?>
                    </tr>
                  </thead>

                  <tbody>
                    <!-- Corpo da tabela -->
                    <?php foreach ($resultados as $resultado) : ?>
                      <tr class="itemrowconsrel">
                        <?php foreach ($resultado as $value) : ?>
                          <td><?php echo $value; ?></td>
                        <?php endforeach; ?>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </div>
              </table>
            </div>
          <?php else : ?>
            <p>Nenhum resultado encontrado.</p>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

</body>

</html>