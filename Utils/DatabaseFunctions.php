<?php
    include "../Configuracoes.php";

    function ConectarSQL(){
        global $URL_BD, $StdUser, $Password, $DataBaseName;
        
        $BD = new mysqli($URL_BD, $StdUser, $Password, $DataBaseName);
        
        if ($BD->connect_error) {
            die("Falha na conexão ao banco de dados: " . $BD->connect_error);
        }

        return $BD;
    }
?>