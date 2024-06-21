<?php
require_once("admin_check.php");

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="grafico.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <a href="tela_index_adm.php" class="back-button">Voltar</a>
        <h1 class="text-center">Quantidade de Produtos por Tipo</h1>
        <canvas id="productChart" width="400" height="200"></canvas>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('data.php')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('productChart').getContext('2d');
                    const productChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Salgados', 'Bebidas', 'Doces'],
                            datasets: [{
                                label: 'Em Estoque',
                                data: data.estoque,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }, {
                                label: 'Entradas',
                                data: data.entradas,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Erro ao carregar os dados:', error));
        });
    </script>
</body>
</html>
