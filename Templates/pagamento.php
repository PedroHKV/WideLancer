<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem_produto.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Venda.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Chat.php";

    session_start();
    $produto_id = $_SESSION["produto_id"];
    $produto = MensagemProduto::findProdutoById($produto_id);
    $vendedor = Usuario::findUsuarioById($produto->getUsuarioId());
    $chat = Chat::findChatById($produto->getChatId());
    $venda = $chat->getVendaPendente();

    $nome_produto = basename($produto->getCaminho());
    $tamanho_produto = round(filesize($produto->getCaminho()) / 1048576 , 2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WideLancer - Pagamento</title>
    <link rel="icon" href="../imagens/logo.png" type="image/png">
    <link rel="stylesheet" href="../stylesheets/pagamento.css">
</head>
<body>
    <header>
        <div class="container">
            <img src="../imagens/logo.png" id="logo" style="width: 65px; height: 55px;">
            <h1><span class="wide">Wide</span><span class="lancer">Lancer</span></h1>
        </div>
        <div id="botoes">
            <a href="./perfil.php" class="btn">Voltar</a>
        </div>
    </header>
    <main>
        <div id="main">
            <div id="esquerda">
                <div id="anuncio">
                    <h3>Dados do produto:</h3>
                    <div class="info"><b>Nome:</b><?php echo $nome_produto;?></div>
                    <div class="info"><b>Preço:</b><?php echo $venda->getPreco();?> R$</div>
                    <div class="info"><b>tamamho:</b><?php echo $tamanho_produto." MB"; ?></div>
                    <div class="info"><b>entrega:</b><?php echo $produto->getHorario();?></div>
                </div>
            </div>
            <div id="direita">
                <div id="vendedor">
                    <h3>Vendedor</h3>
                    <div id="foto_div"><img id="vend_logo" src="<?php echo $vendedor->getFoto();?>" alt=""></div>
                    <div class="info"><b>Nome:</b><?php echo $vendedor->getNome()." ".$vendedor->getSobrenome();?></div>
                    <div class="info"><b>Email:</b><?php echo $vendedor->getEmail()?></div>
                </div><br>
                <div id="getprd">
                    <img id="anunc_imagem" src="../imagens/pasta.png" alt=""><br>
                    <?php
                        if ($produto->getAdquirido()){
                            echo "<div class='info'><b>Produto Adquirido</b></div>";
                        } else {
                            echo "<div id='payment-form'>".
                                        "<div id='card-element'></div>".
                                        "<div id='btn_conf'><button onClick=\"enviar_pagamento(".$venda->getPreco().", '".$vendedor->getStripeid()."')\" id='submit'>obter produto</button></div>".
                                        "<div id='card-errors' role='alert'></div>".
                                    "</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="https://js.stripe.com/v3/"></script>
<script src="../Configuracoes.js"></script>
<script src="../Javascripts/pagamento.js"></script>
</html>