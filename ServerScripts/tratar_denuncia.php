<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Denuncia.php";


    session_start();
    $usuario_id = $_SESSION["id"];

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $motivo = $_POST["motivo"];
        $anuncio_id = $_POST["id"];

        $denuncia = new Denuncia($motivo, 1, $usuario_id, $anuncio_id, null);
        $cadastrado = $denuncia->cadastrar();

        if ($cadastrado){
            echo "cadastrado";
        } else {
            echo "falha";
        }
    }
?>