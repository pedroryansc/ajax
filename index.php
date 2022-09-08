<!DOCTYPE html>
<?php
    require_once("class/autoload.php");
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabuleiro</title>
    <link rel="stylesheet" href="estilo.css">
    <script src="script.js"></script>
</head>
<body>
    <div>
    <?php
        // Pega os dados que vem via GET para edição
        $acao = isset($_GET["acao"]) ? $_GET["acao"] : "";
        $id = isset($_GET["id"]) ? $_GET["id"] : 0;
        if($acao == "editar"){
            try{
                // Busca o tabuleiro pelo "id"
                $lista = 0;
                // [...]
            } catch(Exception $e){
                // [...]
            }
        }
    ?>
    <form action="" method="POST">

    </form>
    <!-- enctype="multipart/form-data" = Envio de uma imagem em um formulário -->
    </div>
</body>
</html>