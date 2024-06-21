<?php
require_once("admin_check.php");

// Conexão com o banco de dados
$servername = "localhost";
$username = "dimy";
$password = "dimymano";
$dbname = "lanchetime";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obter os dados do estoque por tipo de produto
$sql = "SELECT tipo, SUM(quantidade) AS quantidade FROM estoque GROUP BY tipo";
$result = $conn->query($sql);

$data = [
    "estoque" => [],
    "entradas" => []
];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data["estoque"][] = $row["quantidade"];
    }
}

// Se você tiver dados de entradas (novos produtos adicionados), pode adicionar aqui
// Como exemplo, vamos adicionar dados fictícios
$data["entradas"] = [50, 30, 20]; // Exemplos de entradas para 'comida', 'bebida' e 'doce'

$conn->close();

// Retornar os dados como JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
