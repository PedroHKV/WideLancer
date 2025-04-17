<?php
    include "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Anuncio.php";

    if ($_SERVER["REQUEST_METHOD"] === "GET"){
        $pesquisa = $_GET ["query"]; 
       
        $anuncios = Anuncio::findAnunciosByQuery($pesquisa);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de pesquisa</title>
    <link rel="stylesheet" href="../Stylesheets/pesquisa.css"> 
</head>
<body>
   <header>
    <div class="container">
        <h1><span class="wide">Wide</span><span class="lancer">Lancer</span></h1>
    </div>
    <input type="text" placeholder="Procure um serviço digital! Ex.: Design logos" id="search-bar">
   </header>
   <main>
    <div id="cards">
        <?php
            foreach ($anuncios as $anuncio){
                echo " <div class='card'>".
                          "<img src='".$anuncio->getFoto()."' alt=''>".
                          "<div>".
                                "<p class='titulo'>".$anuncio->getTitulo()."</p>". 
                                "<p class='descricao'>".$anuncio->getDescricao()."</p>".
                          "</div>".
                        "</div>";
            }
        ?>
      
   </main>
</body>
</html>