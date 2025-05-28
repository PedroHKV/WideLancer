<?php
    include "../Utils/Classes/Anuncio.php";

    //dados da sessao
    session_start();
    $id = $_SESSION["id"];

    if( $_SERVER["REQUEST_METHOD"] === "POST"){
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        if ( isset($_FILES["imagem"]) ){
            $img = $_FILES["imagem"];
            $nome_file = str_replace(" ", "+",$img["name"]);
            $caminho = "../Uploads/anuncios/".$nome_file;
            $anuncio = new Anuncio(NULL, $caminho, $nome, $descricao, $id);
            $anuncio->setAtivo(1);
            move_uploaded_file($img["tmp_name"], $caminho);
            $cadastrado = $anuncio->cadastrar();
            if ($cadastrado){
                echo "cadastrado";
            } else {
                echo "falha";
            }
        } else{
            echo "servidor: SEM IMAGEM ???";
        }
    }
?>