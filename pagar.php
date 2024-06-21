<?php
session_start();
require_once 'db.php'; // Inclui o arquivo de conexão com o banco de dados
require_once __DIR__ . '/vendor/autoload.php'; // Inclui a biblioteca do Mercado Pago

MercadoPago\SDK::setAccessToken('APP_USR-3745655778760553-061217-1d9b15d69c7d322a25393b583737e119-1233544298'); // Substitua pelo seu access token do Mercado Pago

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['user_id'];

// Busca o email do usuário no banco de dados
$sql = "SELECT email FROM users WHERE id = '$usuario_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_email = $row['email'];
} else {
    echo "Erro ao obter o email do usuário.";
    exit();
}

// Calcula o valor total dos itens no carrinho
$sql = "SELECT carrinho.*, estoque.preco FROM carrinho 
        JOIN estoque ON carrinho.produto_id = estoque.id 
        WHERE carrinho.usuario_id = '$usuario_id'";
$result = $conn->query($sql);

$total_preco = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total_preco += $row['preco'] * $row['quantidade'];
    }
} else {
    echo "Nenhum produto no carrinho.";
    exit();
}

// Cria um novo pagamento no Mercado Pago
$payment = new MercadoPago\Payment();
$payment->transaction_amount = $total_preco;
$payment->description = "Compra na Lanchonete";
$payment->payment_method_id = "pix";
$payment->payer = array(
    "email" => $user_email
);

// Salva o pagamento
try {
    $payment->save();
} catch (Exception $e) {
    echo 'Erro ao salvar pagamento: ' . $e->getMessage();
    exit();
}

// Verifica se o pagamento foi salvo com sucesso e obtém o QR code
if ($payment->status == 'pending' && isset($payment->point_of_interaction->transaction_data->qr_code_base64)) {
    $qr_code_base64 = $payment->point_of_interaction->transaction_data->qr_code_base64;
} else {
    echo "Erro ao gerar QR code.";
    exit();
}

// Gera um código de retirada aleatório
$codigo_retirada = rand(100000, 999999);
$_SESSION['codigo_retirada'] = $codigo_retirada;

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
    <link rel="stylesheet" href="assets/CSS/pagar.css">
</head>
<body>

<a href="carrinho.php" class="voltar-button">Voltar ao Carrinho</a>
<h1 class="main-title">Pagamento</h1>

<div class="container">
    <h2>Escaneie o QR code abaixo para pagar:</h2>
    <div class="qr-code-container">
        <img src="data:image/png;base64,<?php echo $qr_code_base64; ?>" alt="QR Code de Pagamento" class="qr-code">
    </div>
    <h2>Guarde o código de retirada:</h2>
    <p><?php echo $codigo_retirada; ?></p>
</div>

</body>
</html>
