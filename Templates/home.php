<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";

    session_start();
    $usuario_id = $_SESSION["id"];
    $usuario = Usuario::findUsuarioById($usuario_id);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WideLancer - Home</title>
    <link rel="icon" href="../imagens/logo.png" type="image/png">
    <link rel="stylesheet" href="../Stylesheets/home.css">
</head>
<body>

    <header>
        <img src="../imagens/logo.png" id="logo" style="width: 90px; height: 80px;">
        <div class="container">
            <h1><span class="wide">Wide</span><span class="lancer">Lancer</span></h1>
        </div>
        <div class="login-container">
            <a href="./login.html" class="btn">Login</a>
        </div>
        <?php
            if( $usuario->isCurador() ){
               echo "<div class='login-container'>".
                        "<a href='./curadoria.php' class='btn'>Curadoria</a>".
                    "</div>";
            }
        ?>
        <div id="perfil-container">
            <a href="./perfil.php" class="btn">Perfil</a>
        </div>
        <div class="login-container">
            <a href="./notificacoes.php" class="btn">Notificações</a>
        </div>
        <div class="login-container">
            <a href="./historico_compra.php" class="btn">Produtos</a>
        </div>
    </header>

    <div class="retangulo">
        <h1>Bem vindo! procure o seu <span class="destaque">serviço freelancer</span> ideal, rapido e seguro!</h1>
        <input type="text" placeholder="Procure um serviço digital! Ex.: Design logos" class="search-bar" id="search-bar">
    </div>

    <div class="categorias">
        <div class="categoria">Design</div>
        <div class="categoria">Marketing</div>
        <div class="categoria">Tradução</div>
        <div class="categoria">Código</div>
        <div class="categoria">Vídeo</div>
        <div class="categoria">Áudio</div>
        <div class="categoria">Redação</div>
        <div class="categoria">Teste</div>
    </div>

    <section class="galeria-anuncios">
        <div class="carousel">
            <button class="carousel-btn left" onclick="moveCarousel('left')">←</button>
            <div class="container-anuncio">
                <img src="anuncios exemplo\23-imagens-de-destaque_anuncio-para-eventos-300x200.png" alt="anuncio 1" class="anuncio">
                <img src="anuncios exemplo\idec_biscoito_mel-300x300.jpg" alt="anuncio 2" class="anuncio">
                <img src="anuncios exemplo\23-imagens-de-destaque_anuncio-para-eventos-300x200.png" alt="anuncio 3" class="anuncio">
                <img src="./anuncios exemplo/a-espera-acabou-chegou-o-t├úo-aguardado-urubu-do-pix-3-agora-v0-9tj8k301gnpb1.png" alt="anuncio 4" class="anuncio">
                <img src="anuncios exemplo\idec_biscoito_mel-300x300.jpg" alt="anuncio 5" class="anuncio">
                <img src="anuncios exemplo\23-imagens-de-destaque_anuncio-para-eventos-300x200.png" alt="anuncio 6" class="anuncio">
                <img src="anuncios exemplo\idec_biscoito_mel-300x300.jpg" alt="anuncio 7" class="anuncio">
            </div>
            <button class="carousel-btn right" onclick="moveCarousel('right')">→</button>
        </div>
    </section>
    <script src="../Configuracoes.js"></script>
    <script src="../Javascripts/home.js"></script>
</body>
</html>
