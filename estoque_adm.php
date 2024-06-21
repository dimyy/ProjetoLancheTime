<?php
require_once("admin_check.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Estoque</title>
    <link rel="stylesheet" href="assets/CSS/estoque.css">
</head>
<body>
    <a href="tela_index_adm.php" class="back-button">VOLTAR</a>
    <a href="adm_produtos.php" class="admin-button">ADMINISTRAÇÃO DE PRODUTOS</a>

    <h1 class="main-title">SISTEMA DE ESTOQUE</h1>

    <div class="container">
        <h2>Adicionar Item</h2>
        <form id="add-item-form" class="item-form" action="process.php" method="post" enctype="multipart/form-data">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required><br><br>

            <label for="tipo">Tipo:</label>
            <select name="tipo" required>
                <option value="comida">Salgado</option>
                <option value="bebida">Bebida</option>
                <option value="doce">Doce</option>
            </select><br><br>

            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" required><br><br>

            <label for="preco">Preço:</label>
            <input type="text" name="preco" required><br><br>

            <label for="imagem">Imagem do Produto:</label>
            <input type="file" name="imagem" accept="image/*" required><br><br>

            <input type="submit" value="Adicionar Item">
        </form>
    </div>

    <div id="produto-adicionado-popup" class="popup">
        Produto adicionado com sucesso!
    </div>

    <div id="confirm-popup" class="popup">
        <p>Produto adicionado com sucesso!</p>
        <button id="confirm-ok-button">OK</button>
        <button id="confirm-cancel-button">Cancelar</button>
    </div>

    <script src="assets/JS/estoque.js"></script>
</body>
</html>
