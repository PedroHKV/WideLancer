<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Stylesheets/curadoria.css">
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
        <div class="login-container">
            <a href="./curadoria.php" class="btn">Curadoria</a>
        </div>
        <div id="perfil-container">
            <a href="./perfil.php" class="btn">Perfil</a>
        </div>
        <div class="login-container">
            <a href="./notificacoes.php" class="btn">Notificações</a>
        </div>
    </header>
    <main>
        <div id="esquerda">
            <button id="solics">Solicitações</button>
            <button id="denuncias">Denuncias</button>
            <button id="forns">Fornecedores</button>
            <button id="curadores">Curadores</button>
            <button id="clientes">Clientes</button>
        </div>
        <div id="direita">
            <input type="search" name="" id="pesquisa" placeholder="pesquisar usuario">
            <div id="caixa">
                <h3>Denûncias</h3><br>

                <div class="info">
                    <p>pedro klein denunciou uma publicação de pedro senn</p>
                    <p class="status">pendente</p>
                </div>
                
            </div>
        </div>
    </main>

</body>
<script src="../Configuracoes.js"></script>
<script src="../Javascripts/curadoria.js"></script>
</html>