<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem_comum.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem_produto.php";


    if ($_SERVER["REQUEST_METHOD"]==="POST"){
        session_start();
        $usuario_id = $_SESSION["id"];
        $chat_id = $_SESSION["chat_id"];
        $mensagem = $_POST["msg_cnt"];
        $imagem = isset($_FILES["img"]) ? $_FILES["img"] : NULL;

        //para fins de cadastro o banco de dados pode prover o tipo, a hora e o id
        $MSG = new MensagemComum(NULL, $mensagem, $imagem, NULL, $chat_id, $usuario_id);

        $cadastrada = $MSG->cadastrar();
        if ($cadastrada){
            echo "cadastrado";
        } else {
            echo "falha";
        }
        
    }
?>