<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Configuracoes.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Produto.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem_Produto.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Usuario.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Venda.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Chat.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        session_start();
        $produto_id = $_SESSION["produto_id"]; //id da MensagemProduto
        $usuario_id = $_SESSION["id"];

        $paymentMethodId = $_POST["pagamento_id"];
        $preco = $_POST["preco"];
        $vendedor_id = $_POST["vendedor_id"];

        $mensagem_produto = MensagemProduto::findProdutoById($produto_id);
        $usuario = Usuario::findUsuarioById($usuario_id);
        $produto = new Produto( null, $mensagem_produto->getCaminho(), $usuario->getId());
        $data = date("Y-m-d H:i:s");
        $produto->setData( $data);
        $chat = Chat::findChatById($mensagem_produto->getChatId());
        $venda = $chat->getVendaPendente();

        $venda->setAndamento(0);
        $mensagem_produto->setAdquirido(1);
        $mensagem_produto->salvarUpdates();
        $produto->cadastrar();
        $venda->salvarUpdates();

        echo "sucesso";
        
    }
?>