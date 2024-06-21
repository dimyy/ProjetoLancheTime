<?php
session_start();
require_once("db.php");

if (!isset($_SESSION['email']) || $_SESSION['user_role'] !== 'admin') {
    // Usuário não está logado ou não é administrador
    header("Location: login.php");
    exit();
}
?>
