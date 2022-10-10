<?php
    require_once("../class/autoload.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Tabuleiro</title>
</head>
<body>
    <?php
        $id = isset($_GET["id"]) ? $_GET["id"] : 0;
        $busca = Tabuleiro::listar(1, $id);
        $tab = new Tabuleiro($id, $busca[0]["lado"], $busca[0]["fundo"]);
        echo $tab->desenha();
    ?>
</body>
</html>