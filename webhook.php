<?php
include 'db.php';
require __DIR__ . '/vendor/autoload.php';


MercadoPago\SDK::setAccessToken('APP_USR-3745655778760553-061217-1d9b15d69c7d322a25393b583737e119-1233544298');

// Recebe os dados do webhook
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se o tipo de notificação é 'payment'
if (isset($data['type']) && $data['type'] === 'payment') {
    $payment_id = $data['data']['id'];

    // Busca os detalhes do pagamento
    $payment = MercadoPago\Payment::find_by_id($payment_id);

    if ($payment) {
        $status = $payment->status;
        $user_id = $payment->payer->id;

        // Verifica se o pagamento foi aprovado
        if ($status === 'approved') {
            // Atualiza o estoque e remove os produtos do carrinho

            // 1. Atualiza o estoque
            $sql = "SELECT carrinho.produto_id, carrinho.quantidade 
                    FROM carrinho 
                    JOIN estoque ON carrinho.produto_id = estoque.id 
                    WHERE carrinho.usuario_id = '$user_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $produto_id = $row['produto_id'];
                    $quantidade_carrinho = $row['quantidade'];

                    // Atualiza a quantidade no estoque
                    $sql_update_estoque = "UPDATE estoque 
                                           SET quantidade = quantidade - $quantidade_carrinho 
                                           WHERE id = '$produto_id'";
                    $conn->query($sql_update_estoque);
                }
            }

            // 2. Remove os produtos do carrinho
            $sql_delete_carrinho = "DELETE FROM carrinho WHERE usuario_id = '$user_id'";
            $conn->query($sql_delete_carrinho);
        }
    }
}

$conn->close();
?>
