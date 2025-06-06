<?php
    include "../Utils/Classes/Usuario.php";
    //portifolio.php ja esta incluido em Usuario.php

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        session_start();
        $id = $_SESSION["id"];
        $usuario = Usuario::findUsuarioById($id);

        //para saber se e necessario cadastrar um novo portifolio
        $portifolio  = Portifolio::findPortifolioByUsuario_id($id);
        $ja_tinha_portifolio = ($portifolio->getId() === null) ? false : true;

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
            $pix = (trim($_POST["pix"] === "") ? null : $_POST["pix"]);
            $usuario->setPix($pix);
        }
        if (isset( $_POST["chavePIX"] )){
            $stripeid = $_POST["chavePIX"];
            $usuario->setStripeid( $stripeid );
        }
        if (isset( $_POST["descricao"] )){
            $descricao = $_POST["descricao"];
        } else { $descricao = Null;}

        if (isset( $_POST["titulo"] )){
            $titulo = $_POST["titulo"];
        } else { $titulo = Null;}

        if ( isset($_FILES["img"]) ){
            $img = $_FILES["img"];
            $nome_file = str_replace(" ", "+", $img["name"]);
            $caminho = "../Uploads/portifolio/".$nome_file;
            move_uploaded_file($img["tmp_name"], $caminho);
            $usuario->setFoto($caminho);
        } 

        if (!$ja_tinha_portifolio){
            $usuario->criarPortifolio(Null, Null, $descricao );

        } else {
            $portifolio = Portifolio::findPortifolioByUsuario_id($id);
            $portifolio->setDescricao( $descricao );
            $portifolio->setTitulo( $titulo);

            $portifolio->salvarUpdates();

        }
        
        $usuario->salvarUpdates();
        echo "sucesso";
    }
?>