<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link rel="stylesheet" href="assets/CSS/carrinho.css">
   
</head>
<body>
<?php
session_start();
include 'db.php';

// Inclui o SDK do Mercado Pago
require __DIR__ . '/vendor/autoload.php';

// Configura o Mercado Pago
MercadoPago\SDK::setAccessToken('APP_USR-3745655778760553-061217-1d9b15d69c7d322a25393b583737e119-1233544298');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remover'])) {
        $produto_id = $_POST['produto_id'];
        $sql = "DELETE FROM carrinho WHERE usuario_id = '$usuario_id' AND produto_id = '$produto_id'";
        $conn->query($sql);
    } elseif (isset($_POST['atualizar'])) {
        $produto_id = $_POST['produto_id'];
        $quantidade = $_POST['quantidade'];

        // Verifica a quantidade em estoque
        $sql = "SELECT quantidade FROM estoque WHERE id = '$produto_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $quantidade_estoque = $row['quantidade'];

            // Verifica se a nova quantidade no carrinho não excede o estoque
            if ($quantidade <= $quantidade_estoque) {
                $sql = "UPDATE carrinho SET quantidade = '$quantidade' WHERE usuario_id = '$usuario_id' AND produto_id = '$produto_id'";
                $conn->query($sql);
            } else {
                echo "<script>alert('Quantidade total no carrinho excede a quantidade em estoque.');</script>";
            }
        }
    } elseif (isset($_POST['pagar'])) {
        // Cria uma preferência de pagamento
        $preference = new MercadoPago\Preference();

        // Cria os itens da preferência
        $items = [];
        $sql = "SELECT carrinho.*, estoque.nome, estoque.preco FROM carrinho 
                JOIN estoque ON carrinho.produto_id = estoque.id WHERE carrinho.usuario_id = '$usuario_id'";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $item = new MercadoPago\Item();
            $item->title = $row['nome'];
            $item->quantity = $row['quantidade'];
            $item->unit_price = $row['preco'];
            $items[] = $item;
        }

        $preference->items = $items;

        // Salva a preferência e obtém o QR code do PIX
        $preference->save();
        $qr_code = $preference->id;

        // Salva o QR code em uma variável de sessão para uso posterior
        $_SESSION['qr_code'] = $qr_code;
        $_SESSION['codigo_retirada'] = uniqid();

        header('Location: pagar.php');
        exit();
    }
}

$sql = "SELECT carrinho.*, estoque.nome, estoque.preco, estoque.imagem FROM carrinho 
        JOIN estoque ON carrinho.produto_id = estoque.id WHERE carrinho.usuario_id = '$usuario_id'";
$result = $conn->query($sql);

$total_preco = 0;
?>

<a href="cardapio.php" class="voltar-button">Voltar ao Cardápio</a>
<h1 class="main-title">Carrinho</h1>

<div class="container">
    <?php
    if ($result->num_rows > 0) {
        echo "<table class='produtos-table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Imagem</th>";
        echo "<th>Nome</th>";
        echo "<th>Preço Unitário</th>";
        echo "<th>Quantidade</th>";
        echo "<th>Preço Total</th>";
        echo "<th>Ação</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while($row = $result->fetch_assoc()) {
            $preco_total_produto = $row['preco'] * $row['quantidade'];
            $total_preco += $preco_total_produto;
            echo "<tr>";
            echo "<td><img src='uploads/" . $row['imagem'] . "' alt='" . $row['nome'] . "' class='produto-imagem'></td>";
            echo "<td>" . $row['nome'] . "</td>";
            echo "<td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>";
            echo "<td>
                    <form method='POST'>
                        <input type='number' name='quantidade' value='" . $row['quantidade'] . "' min='1'>
                        <input type='hidden' name='produto_id' value='" . $row['produto_id'] . "'>
                        <input type='submit' name='atualizar' value='Atualizar'>
                  </td>";
            echo "<td>R$ " . number_format($preco_total_produto, 2, ',', '.') . "</td>";
            echo "<td>
                        <input type='submit' name='remover' value='Remover'>
                    </form>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";

        echo "<h2>Total: R$ " . number_format($total_preco, 2, ',', '.') . "</h2>";
        echo "<form method='POST'>
                <input type='submit' name='pagar' value='Pagar Agora'>
              </form>";
    } else {
        echo "Nenhum produto no carrinho.";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
