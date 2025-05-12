<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Proposta.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        session_start();
        $orcamento = $_POST["orcamento"];
        $prazo = $_POST["prazo"];
        $usuario_id = $_SESSION["id"];
        $chat_id = $_SESSION["chat_id"];
        
        $proposta = new Proposta(Null, $orcamento, $prazo, 0, $usuario_id, $chat_id, NULL);
        $cadastrada = $proposta->cadastrar();

        if ($cadastrada){
            echo "cadastrado";
        } else {
            echo "falha";
        }
    }

?>