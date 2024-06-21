<?php
require_once("admin_check.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/CSS/index_adm.css">
    <script src="https://kit.fontawesome.com/3df637a2f2.js" crossorigin="anonymous"></script>
    <script src="app.js" defer></script>
    <title>LancheTime || TCC</title>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <img src="assets/img/LOGOLANCHE.png" alt="LOGOLANCHE" style="width: 60px; height: auto;">
                <h3>LancheTime</h3>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href = "historico.php">
                        <i class="fas fa-history"></i> <!-- Ícone de histórico -->
                        Histórico
                    </a>
                </li>
                <li>
                    <a href="adm_produtos2.php">
                        <i class="fas fa-cog"></i> <!-- Ícone de administração -->
                        Administração de Produtos
                    </a>
                </li>
                <li>
                    <a href="estoque_adm.php">
                        <i class="fas fa-box-open"></i> <!-- Ícone de estoque -->
                        Estoque
                    </a>
                </li>
                <li>
                    <a href="grafico.php">
                        <i class="fas fa-chart-bar"></i> <!-- Ícone de gráficos -->
                        Dashboard de Gráficos
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> <!-- Ícone de logout -->
                        Sair
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Conteúdo principal -->
        <div id="content">
            <div class="welcome-message">
                <h2>Bem-vindo à administração do LancheTime</h2>
                <p>Escolha uma opção na barra lateral para começar.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <h4>DESENVOLVIDO POR -> EQUIPE LANCHE TIME</h4>
    </footer>

    <script src="assets/JS/script.js"></script>
</body>
</html>
