<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/CSS/style.css">
    <script src="https://kit.fontawesome.com/3df637a2f2.js" crossorigin="anonymous"></script>
    <title>LancheTime || TCC</title>
</head>
<body>
    <header>
        <div class="content">
            <div class="logo">
                <img src="assets/img/LOGOLANCHE.png" alt="LOGOLANCHE">
                <h3>LancheTime</h3>
            </div>
            <ul class="list-menu">
                <li><a href="#home">Home</a></li>
                <li><a href="#sobrenos">Sobre nós</a></li>
                <li><a href="#categorias">Cardápio</a></li>
                <li><a href="#contatos">Contatos</a></li>
                <li><a href="login.php"><i class="fas fa-user"></i> Login</a></li>
            </ul>
            <div class="menu-toggle">
                <div class="one"></div>
                <div class="two"></div>
                <div class="three"></div>
            </div>
        </div>
    </header>
    <section class="first-section" id="home">
        <div class="conteudo-principal">
            <h1>Deixe seu dia mais saboroso!!!</h1>
            <h2>Os lanches mais suculentos do estado</h2>
            <div class="btn">
                <button class="reservar" onclick="scrollToCategories()">Reserve o seu!</button>
            </div>
        </div>    
    </section>    
    <section class="sobre-nos" id="sobrenos">
        <div class="main">
            <h2 class="titulo-sobre-nos">SOBRE NÓS</h2>
            <div class="contentsobre">
                <p>Bem-vindo à nossa lanchonete, onde a conveniência e o sabor se encontram! Na nossa história, uma necessidade simples inspirou uma grande ideia: por que esperar na fila sob o sol escaldante quando você pode pedir online e retirar rapidamente na sua conveniência?
                    Na nossa jornada para redefinir o conceito de lanche rápido, criamos uma experiência que valoriza o seu tempo e conforto. Afinal, você merece mais do que ficar esperando sob o sol enquanto sua barriga ronca de fome.</p>
                <div class="img-cantina">
                    <img src="assets/img/cantinatcc.png" alt="">
                </div>
            </div>
        </div>
    </section>
    <section class="categorias" id="categorias">
        <h2 class="titulo-categorias">CARDÁPIO</h2>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="categoria cardapio">
                        <i class="fas fa-hamburger"></i>
                        <span class="categoria-titulo">CARDÁPIO </span>
                        <button class="redirect-button" onclick="showPopup()">Ver Cardápio</button>
                    </div>
                </div>
            </div>
        </div>
    </section>  
    <section class="contatos" id="contatos">
        <h3>Contatos</h3>
        <div class="contatos-secao">
            <div>
                <i class="fas fa-phone"></i>
                <span>(27) 99999-9999</span>
            </div>
        </div>
    </section>
    <footer>
        <h4>DESENVOLVIDO POR -> EQUIPE LANCHE TIME</h4>
    </footer>
    <script src="assets/JS/script.js"></script>
</body>
</html>
