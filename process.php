<?php
include 'db.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];
    $imagem = $_FILES['imagem']['name'];
    $imagem_tmp = $_FILES['imagem']['tmp_name'];

    // Verifica se os campos obrigatórios foram preenchidos
    if (!empty($nome) && !empty($tipo) && isset($quantidade) && isset($preco)) {

        // Verifica se o preço é um número válido e maior ou igual a zero
        if (!is_numeric($preco) || $preco < 0) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'O preço deve ser um número válido e maior ou igual a zero.']);
            exit;
        }

        // Converte o preço para um número decimal formatado com duas casas decimais
        $preco_formatado = number_format((float)$preco, 2, '.', '');

        // Diretório para upload da imagem
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($imagem);

        // Move o arquivo de imagem para o diretório de upload
        if (move_uploaded_file($imagem_tmp, $target_file)) {
            // Utiliza prepared statement para evitar SQL injection
            $stmt = $conn->prepare("INSERT INTO estoque (nome, tipo, quantidade, preco, imagem) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssids", $nome, $tipo, $quantidade, $preco_formatado, $imagem);

            // Executa o statement
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Erro ao adicionar item: ' . $stmt->error]);
            }
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Erro ao fazer upload da imagem.']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Nome, Tipo, Quantidade e Preço são campos obrigatórios.']);
    }
}

$conn->close();
?>
