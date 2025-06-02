<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Produto.php";
    session_start();
    $usuario_id = $_SESSION["id"];
    $usuario = Usuario::findUsuarioById($usuario_id);
    $produtos = Produto::findProdutosByUsuarioId($usuario_id);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width: device-width, initial-scale=1" />
    <title>WideLancer - Histórico de Compras</title>
    <link rel="icon" href="../imagens/logo.png" type="image/png">
    <link rel="stylesheet" href="../Stylesheets/hist_compra.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body>
    <header>
        <img src="../imagens/logo.png" id="logo" style="width: 90px; height: 80px;" />
        <div class="container">
            <h1><span class="wide">Wide</span><span class="lancer">Lancer</span></h1>
        </div>
        <div class="login-container">
            <a href="./login.php" class="btn">Login</a>
        </div>
        <div id="perfil-container">
            <a href="./perfil.php" class="btn">Perfil</a>
        </div>
        <div class="login-container">
            <a href="./notificacoes.php" class="btn">Notificações</a>
        </div>
        <div class="login-container">
            <a href="./home.php" class="btn">Home</a>
        </div>
    </header>

    <main>
        <section class="historico-container">
            <h2>Histórico de Compras</h2>
            <table class="historico-table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Produto</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($produtos as $produto){
                            $nome = basename($produto->getCaminho());
                            echo "<tr>".
                                    "<td>".$produto->getData()."</td>".
                                    "<td>".$nome."</td>".
                                    "<td><a href='".$produto->getCaminho()."' download class='btn-download'><i class='fas fa-download'></i></a></td>".
                                "</tr>";
                        }
                    ?>
                    
                </tbody>
            </table>
        </section>
    </main>
</body>
<script src="../Configuracoes.js"></script>
<script src="../javascripts/compras.js"></script>
</html>
