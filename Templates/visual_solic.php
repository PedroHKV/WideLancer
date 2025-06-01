<?php

    include_once "../Utils/Classes/Solicitacao.php";
    include_once "../Utils/Classes/Usuario.php";

    session_start();
    $solicitacao_id = $_SESSION["solicitacao_id"];
    $solicitacao = Solicitacao::findBySolicitacaoById($solicitacao_id);
    $usuario = Usuario::findUsuarioById($solicitacao->getUsuarioId());

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WideLancer - Solicitações</title>
    <link rel="icon" href="../imagens/logo.png" type="image/png">
    <link rel="stylesheet" href="../Stylesheets/visual_solic.css">
</head>
<body>
    <header>
        <div>
            <img src="../imagens/logo.png" id="logo" style="width: 90px; height: 80px;">
            <div class="container">
                <h1><span class="wide">Wide</span><span class="lancer">Lancer</span></h1>
            </div>
        </div>
        <div>
            <div class="login-container">
                <a href="./login.html" class="btn">Login</a>
            </div>
            <div id="perfil-container">
                <a href="./perfil.php" class="btn">Perfil</a>
            </div>
            <div class="login-container">
                <a href="./notificacoes.php" class="btn">Notificações</a>
            </div>
        </div>
    </header>
    <div id="reqStatus">
        <p id="status"></p>
        <input type="button" onclick="translatediv()" id="dispose" value="X">
    </div> 
    <main>
        <div id="horizontal">
            <div id="acoes">
                <div id="status_solicitacao">
                    <?php
                        $decisao = $solicitacao->getDecisao();
                        if ($decisao !== null && $decisao !== "pendente") {
                            echo "<div id='status_denuncia'>Esta solicitação está: " . htmlspecialchars($decisao) . "</div>";
                    }
            ?>
    </div>

    <input type="button" 
           id="aceit" 
           value="aceitar" 
           onclick="aceitar(<?php echo $solicitacao->getUsuarioId() ?>)" 
           <?php echo ($solicitacao->getPendente() ? "" : "disabled"); ?>>

    <input type="button" 
           id="rec" 
           value="recusar" 
           onclick="recusar(<?php echo $solicitacao->getUsuarioId() ?>)" 
           <?php echo ($solicitacao->getPendente() ? "" : "disabled"); ?>>
            </div>
            <div id="dados_solicitante">
                <h3>Informações do candidato:</h3><br>
                <div class="info"><b>Nome:</b> <?php echo $usuario->getNome()." ".$usuario->getSobrenome();?>  </div><br>
                <div class="info"><b>Email:</b> <?php echo $usuario->getEmail();?>  </div><br>
                <div class="info"><b>CPF:</b> <?php echo $solicitacao->getCpf();?>  </div><br>
                <div class="info"><b>Stripe ID:</b> <?php echo $solicitacao->getPix();?> </div><br>
            </div>
            <div id="documento_foto">
                <img id="foto" src="<?php echo $solicitacao->getFoto();?>" alt="">

            </div>
        </div>
    </main>
</body>
<script src="../Configuracoes.js"></script>
<script src="../javascripts/visual_solic.js"></script>
</html>
