<?php
session_start();

if (isset($_SESSION['id'])) {
    session_unset();
    session_destroy();
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Stylesheets/login.css">
    <title>WideLancer - Login</title> 
    <link rel="icon" href="../imagens/logo.png" type="image/png">
</head>
<body>

    <main>
        <div id="esquerda">
            <h1>Divulgue seu serviço web com <br> WideLancer !</h1>
            <p>Há um mundo de oportunidades a sua espera</p>
        </div>
        
        <div id="direita">
            <h3>LOGIN</h3>
            <input type="text" placeholder="email" id="email">
            <input type="password" placeholder="senha" id="senha">
            <div>
                <input type="button" value="Entrar" id="botao">
            </div>
            <p>Ainda não é um WideLancer? <a href="cadastro.html">Cadastre-se</a></p><br><br>
            <div id="statusHTTP">
                
            </div>
        </div>
    </div>
    
    <script src="../Configuracoes.js" ></script>
    <script src="../Javascripts/login.js">

    </script>

    
</body>
</html>