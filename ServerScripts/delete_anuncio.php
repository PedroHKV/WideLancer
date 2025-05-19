<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Anuncio.php";

    //recebe o id do anuncio a ser removido
    if (isset($_POST["id"])){
        $id = $_POST["id"];
        //no momento a tabela de anuncios nao possui funcionalidades para
        //criar chats, mas com o passar do tempo , e provavel que este metodo
        //precise ser alterado, ele provavelmente devera chamar uma procedure
        $excluido = Anuncio::deleteAnuncioById($id);
        if ($excluido){
            echo "excluido";
        } else {
            echo "falha na exclusão";
        }
    }
?>