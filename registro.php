<?php
require_once("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Gerando o hash da senha
    $role = $_POST['role'];

    if ($email !== $_POST['confirmEmail']) {
        echo "Erro: Emails não conferem.";
        exit;
    }

    if ($_POST['senha'] !== $_POST['confirmPassword']) {
        echo "Erro: Senhas não conferem.";
        exit;
    }

    $sql = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $name, $email, $senha_hash, $role);

    if ($sql->execute()) {
        echo "<script>
                if(confirm('Registrado com sucesso! Deseja ir para a página de login?')){
                    window.location.href = 'login.php';
                } else {
                    window.location.href = 'index.php';
                }
             </script>";
        exit();
    } else {
        echo "Erro: " . $sql->error;
    }

    $sql->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela de Registro</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/CSS/registro.css">
  <script src="assets/JS/registro.js" defer></script>
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="register-container">
          <div class="logo-container text-center mb-4">
            <img src="assets/img/LOGOLANCHE.png" alt="Logo" class="img-fluid">
          </div>
          <h2 class="text-center register-title">REGISTRO</h2>
          <form class="register-form" method="post" action="registro.php" id="registerForm">
            <div class="form-group">
              <input type="text" name="name" class="form-control" placeholder="Nome" required>
            </div>
            <div class="form-group">
              <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
              <input type="email" name="confirmEmail" class="form-control" placeholder="Confirmação de Email" required>
            </div>
            <div class="form-group">
              <input type="password" name="senha" id="password" class="form-control" placeholder="Senha" required>
            </div>
            <div class="form-group">
              <input type="password" name="confirmPassword" class="form-control" placeholder="Confirmação de Senha" required>
            </div>
            <div class="form-group">
              <select name="role" class="form-control" required>
                <option value="" disabled selected>Selecione o Papel</option>
                <option value="aluno">Aluno</option>
                <option value="funcionario">Funcionário</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
