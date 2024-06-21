<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração de Produtos</title>
    <link rel="stylesheet" href="assets/CSS/adm_produtos.css">
</head>
<body>
    <a href="tela_index_adm.php" class="voltar-button">Voltar</a>
    <div class="container">
        <h1> ADMINISTRAÇÃO DE PRODUTOS</h1>
        <table class="produtos-table">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db.php';

                if (isset($_GET['remover'])) {
                    $id = $_GET['remover'];

                    // Primeiro, deleta os registros da tabela carrinho relacionados ao produto
                    $sql_delete_carrinho = "DELETE FROM carrinho WHERE produto_id = $id";
                    if ($conn->query($sql_delete_carrinho) === TRUE) {
                        // Em seguida, deleta o produto da tabela estoque
                        $sql_delete_estoque = "DELETE FROM estoque WHERE id = $id";
                        if ($conn->query($sql_delete_estoque) === TRUE) {
                            header('Location: adm_produtos.php');
                            exit();
                        } else {
                            echo "Erro ao remover produto do estoque: " . $conn->error;
                        }
                    } else {
                        echo "Erro ao remover produto do carrinho: " . $conn->error;
                    }
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alterar_quantidade'])) {
                    $id = $_POST['id'];
                    $nova_quantidade = $_POST['nova_quantidade'];

                    $sql = "UPDATE estoque SET quantidade = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $nova_quantidade, $id);

                    if ($stmt->execute()) {
                        header('Location: adm_produtos.php');
                        exit();
                    } else {
                        echo "Erro ao alterar quantidade: " . $stmt->error;
                    }
                }

                $sql = "SELECT * FROM estoque";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><img src='uploads/" . $row['imagem'] . "' alt='" . $row['nome'] . "' width='50'></td>";
                        echo "<td>" . $row['nome'] . "</td>";
                        echo "<td>" . $row['tipo'] . "</td>";
                        echo "<td class='quantidade-col'>" . $row['quantidade'] . "</td>";
                        echo "<td>" . $row['preco'] . "</td>";
                        echo "<td class='acao-col'>";
                        echo "<form action='adm_produtos.php' method='post'>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                        echo "<input type='hidden' name='alterar_quantidade' value='1'>";
                        echo "<input type='number' name='nova_quantidade' value='" . $row['quantidade'] . "' required>";
                        echo "<button type='submit' class='alterar-button'>Alterar</button>";
                        echo "</form>";
                        echo "<form action='adm_produtos.php' method='get'>";
                        echo "<input type='hidden' name='remover' value='" . $row['id'] . "'>";
                        echo "<button type='submit' class='remover-button'>Remover</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhum produto encontrado</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        
    </div>
</body>
</html>
