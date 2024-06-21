<?php
$servername = "localhost";
$username = "dimy";
$password = "dimymano";
$dbname = "lanchetime";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}
?>
