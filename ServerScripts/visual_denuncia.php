<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Denuncia.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Anuncio.php";


    session_start();
    $denuncia_id = $_SESSION["denuncia_id"];
    $denuncia = Denuncia::findDenunciaById($denuncia_id);


    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $cmd = $_POST["cmd"];

        if ($cmd === "ignorar"){
            //ignora a denuncia
            $denuncia->setDecisao("ignorada");
            $denuncia->setPendente(0);
            
            $denuncia->salvarUpdates();
            echo "sucesso";
        } else if ( $cmd === "esc_anun" ){
            //exclui o anuncio
            $denuncia->setDecisao("anuncio_excluido");
            $denuncia->setPendente(0);
            
            Anuncio::deleteAnuncioById($denuncia->getId());

            $denuncia->salvarUpdates();
            echo "sucesso";
        } else if ($cmd === "esc_vend"){
            //exclui a conta de quem fez o anuncio
            $denuncia->setDecisao("vendedor_banido");
            $denuncia->setPendente(0);
            
            $anuncio_id = $denuncia->getAnuncioId();
            $anuncio = Anuncio::findAnuncioById($anuncio_id);
            $vendedor_id = $anuncio->getUsuarioId();
            Usuario::deleteUsuarioById($vendedor_id);

            $denuncia->salvarUpdates();
            echo "sucesso";
        }
    }

?>