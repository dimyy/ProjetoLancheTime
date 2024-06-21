<?php
// Verifica se o usuário está autenticado como administrador
require_once("admin_check.php");

// Inicia a sessão se ainda não estiver iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Agora você pode usar $_SESSION['user_id'] para obter o ID do usuário logado
$usuario_id = $_SESSION['user_id'];

// Conecta ao banco de dados
require_once("db.php");

// Consulta para obter histórico de pedidos ou pagamentos do usuário
// Exemplo:
$sql = "SELECT * FROM pedidos WHERE usuario_id = '$usuario_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Pedidos</title>
    <link rel="stylesheet" href="assets/CSS/historico.css">
</head>
<body>
<a href="tela_index_adm.php" class="voltar-button">Voltar</a>
<h1 class="main-title">Histórico de Pedidos</h1>
<div class="container">
    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table class='pedidos-table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Data do Pedido</th>";
        echo "<th>Total</th>";
        echo "<th>Status</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['data_pedido'] . "</td>";
            echo "<td>R$ " . number_format($row['total'], 2, ',', '.') . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>Nenhum pedido encontrado.</p>";
    }
    ?>
</div>
</body>
</html>

<?php
// Fecha a conexão com o banco de dados
$conn->close();
?>
