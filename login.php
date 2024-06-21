<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("db.php"); // Inclui o arquivo de conexão com o banco de dados
session_start(); // Inicia a sessão, se ainda não estiver iniciada

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se 'email' e 'senha' estão definidos no array $_POST
    if (isset($_POST['email'], $_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Prepara a consulta SQL para verificar o usuário e senha
        $sql = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_senha = $row['password'];

            // Verifica se a senha fornecida corresponde à senha armazenada no banco de dados
            if (password_verify($senha, $hashed_senha)) {
                // Define a função do usuário na sessão
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $email;

                // Redireciona com base no papel do usuário
                if ($row['role'] === 'admin') {
                    $_SESSION['user_role'] = 'admin';
                    header("Location: tela_index_adm.php");
                    exit();
                } elseif ($row['role'] === 'funcionario') {
                    $_SESSION['user_role'] = 'funcionario';
                    header("Location: tela_cliente_logado.php");
                    exit();
                } elseif ($row['role'] === 'aluno') {
                    $_SESSION['user_role'] = 'aluno';
                    header("Location: tela_cliente_logado.php");
                    exit();
                } else {
                    echo "Papel de usuário não reconhecido.";
                }
            } else {
                echo "Senha incorreta.";
            }
        } else {
            echo "Usuário não encontrado.";
        }

        $sql->close();
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela de Login</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/CSS/login.css">
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
  <div class="login-container">
    <div class="logo-container">
      <img src="assets/img/LOGOLANCHE.png" alt="Logo">
    </div>
    <h2 class="text-center login-title">LOGIN</h2>
    <form class="login-form" method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="senha" placeholder="Senha" required>
      <input type="submit" value="Entrar">
    </form>
    <div class="forgot-password">
      <a href="#">Esqueci a senha</a>
    </div>
    <div class="register-link">
      <a href="registro.php">Registre-se</a>
    </div>
  </div>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
