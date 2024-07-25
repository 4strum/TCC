<?php
include('connection.php');

session_start();

$alerta = ""; // Inicialmente, nenhum alerta

// Mensagem padrão
$mensagemPadrao = "Logar no sistema";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = $_POST['nome'];
  $senha = $_POST['senha'];

  $sql_code = "SELECT * FROM tb_usuario WHERE nm_usuario = '$nome'";
  $sql_query = $mysqli->query($sql_code) or die(mysqli_error($mysqli));

  if ($sql_query->num_rows == 0) {
    $alerta = "Usuário não cadastrado"; // Mensagem de usuário não cadastrado
  } else {
    $usuario = $sql_query->fetch_assoc();
    if ($senha != $usuario['senha']) {
      $alerta = "Senha incorreta"; // Mensagem de senha incorreta
    } else {
      
      // Define as variáveis de sessão
      $_SESSION['usuario'] = $usuario['id_usuario'];
      $_SESSION['nm_usuario'] = $usuario['nm_usuario'];
      $_SESSION['tipo'] = $usuario['tipo'];

      $sql_update_sessao = "UPDATE tb_usuario SET ultima_sessao = NOW() WHERE nm_usuario = '$nome'";
      $mysqli->query($sql_update_sessao) or die($mysqli->error);
      // Redireciona para a página conslivro.php se a senha estiver correta
      header("Location: conslivro.php");
    
      exit();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Arcane System</title>
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body>
  <div id="register-container">
    <div id="register-banner">
      <div id="banner-layer">
        <h1>Seja bem-vindo</h1>
      </div>
    </div>
    <div id="register-form">
      <img src="wizard.png" alt="logo" class="logo">
      <h2>ArcaneSystem</h2>
      <p>Tela de login do sistema</p>

      <div class="form-control">
        <form action="" method="POST">
          <label for="nome">Usuário</label>
          <input type="text" name="nome" id="nome" placeholder="Digite seu usuário">
      </div>
      <div class="form-control">
        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha">

        <div class="alert">
  <?php echo !empty($alerta) ? $alerta : '<span class="green-alert">Logar no sistema</span>'; ?>
</div>


        <button type="submit">Entrar</button>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
