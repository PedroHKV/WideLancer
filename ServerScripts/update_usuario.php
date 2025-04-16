<?php
    include "../Utils/Classes/Usuario.php";
    //portifolio ja esta incluido em Usuario.php

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        session_start();
        $id = $_SESSION["id"];
        $usuario = Usuario::findUsuarioById($id);

        //para saber se e necessario cadastrar um novo portifolio
        $ja_era_vendedor = $usuario->isVendedor() === 1 ? true : false;

        if (isset( $_POST["nome"] )){
            $nome = $_POST["nome"];
            $usuario->setNome($nome);
        }
        if (isset( $_POST["sobrenome"] )){
            $sobrenome = $_POST["sobrenome"];
            $usuario->setSobrenome( $sobrenome );
        }
        if (isset( $_POST["email"] )){
            $email = $_POST["email"];
            $usuario->setEmail( $email );
        }
        if (isset( $_POST["senha"] )){
            $senha = $_POST["senha"];
            $usuario->setSenha( $senha );
        }
        if (isset( $_POST["pix"] )){
            $pix = $_POST["pix"];
            $usuario->setPix($pix);
        }
        if (isset( $_POST["descricao"] )){
            $descricao = $_POST["descricao"];
        } else { $descricao = Null;}

        if ( isset($_FILES["img"]) ){
            $img = $_FILES["img"];
            $caminho = "../Uploads/anuncios/".$img["name"];
            move_uploaded_file($img["tmp_name"], $caminho);
            $usuario->setFoto($caminho);
            echo "imagem recebida\n";
        } 

        $usuario->salvarUpdates();
        echo "atualizações salvas com sucesso";

        if (!$ja_era_vendedor){
            $usuario->criarPortifolio(Null, Null, $descricao );
            // no mysql o true deve ser passado como 1
            $usuario->setVendedor(1);
            echo "portifolio criado com sucesso\n";
        }
    }
?>