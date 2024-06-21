<?php
session_start(); // Inicia a sessão
session_unset(); // Remove todas as variáveis de sessão
session_destroy(); // Destrói a sessão
$_SESSION['logged_out'] = true; // Define uma variável de sessão para indicar que o usuário fez logout
header("Location: index.php"); // Redireciona o usuário para a página index.php
exit(); // Encerra o script
?>
