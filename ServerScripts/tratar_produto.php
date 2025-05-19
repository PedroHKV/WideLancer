<?php

    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem_produto.php";

    session_start();
    $usuario_id = $_SESSION["id"];
    $chat_id = $_SESSION["chat_id"];

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $cmd = $_POST["cmd"];

        if ($cmd === "entrega"){
            $produto = $_FILES["produto"];
            $nome = basename($produto["name"]);
            $nomeSeguro = uniqid() . "_" . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $nome);
            
            $caminho = "../Uploads/produtos/" . $nomeSeguro;
            $hora = date("Y-m-d H:i:s");

            move_uploaded_file($produto["tmp_name"], $caminho);

            $msg_produto = new MensagemProduto(null, 0, $caminho, $usuario_id, $chat_id, $hora);
            $msg_produto->cadastrar();
        }
    }

?>