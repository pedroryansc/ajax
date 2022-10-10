<!DOCTYPE html>
<?php
    require_once("../class/autoload.php");

    // Pega os dados que vem via GET para edição
    $acao = isset($_GET["acao"]) ? $_GET["acao"] : "";
    $id = isset($_GET["id"]) ? $_GET["id"] : 0;

    if($acao == "editar"){
        try{
            // Busca o tabuleiro pelo "id"
            $lista = Tabuleiro::listar(1, $id);
            $tab = new Tabuleiro($id, $lista[0]["lado"], $lista[0]["fundo"]);
        } catch(Exception $e){
            print($e->getMessage());
        }
    }
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabuleiro</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <script src="../script.js"></script>
</head>
<body>
    <div id="corpo">
        <aside id="menulateral">
            <ul>
                <li>Meu Perfil</li>
                <li>Sair</li>
            </ul>
        </aside>
        <form action="../control/processa.php" method="POST" enctype="multipart/form-data">
            <!-- enctype="multipart/form-data" = No caso de envio de uma imagem em um formulário -->
            <fieldset>
                <legend>Cadastro</legend>
                <label for="Id">ID</label>
                <input type="text" name="id" readonly value="<?php if(isset($tab)) echo $tab->getId(); ?>">
                <label for="lado">Lado</label>
                <input type="text" name="lado" id="lado" value="<?php if(isset($tab)) echo $tab->getLado(); ?>">
                <span id="msg-lado"></span>
                <label for="arquivo">Imagem de fundo:</label>
                <input type="file" name="arquivo" id="arquivo">
                <button type="submit" name="acao" id="salvar" value="salvar">Enviar</button>
            </fieldset>
        </form>
        <br>
        <form>
            <fieldset>
                <legend>Filtro</legend>
                <input type="radio" name="tipo" value="1">ID
                <input type="radio" name="tipo" value="2">Lado
                <input type="text" name="procurar">
                <button type="submit" name="enviar">Busca</button>
            </fieldset>
        </form>
        <?php
            $tipo = isset($_GET["tipo"]) ? $_GET["tipo"] : 0;
            $procurar = isset($_GET["procurar"]) ? $_GET["procurar"] : 0;
            
            $lista = Tabuleiro::listar($tipo, $procurar);
        ?>
        <br>
        <table border="1" id="tabuleiro">
            <thead>
                <th>ID</th>
                <th>Lado</th>
                <th>Fundo</th>
                <th>#</th>
                <th>#</th>
            </thead>
            <?php
                foreach($lista as $linha){
                    $consultar = "../control/processa.php?acao=consultar&id=".$linha["idtabuleiro"];
                    $alterar = "index.php?acao=editar&id=".$linha["idtabuleiro"];
                    $excluir = "../control/processa.php?acao=excluir&id=".$linha["idtabuleiro"];
            ?>
            <tr>
                <td><a href="<?php echo $consultar; ?>"><?php echo $linha["idtabuleiro"]; ?></a></td>
                <td><?php echo $linha["lado"]; ?></td>
                <td><img src="<?php echo $linha["fundo"]; ?>" class="imagem"></td>
                <td><a href="<?php echo $alterar; ?>">Alterar</a></td>
                <td><a href="<?php echo $excluir; ?>">Excluir</a></td>
            </tr>
            <?php
                }
            ?>
        </table>
    </div>
</body>
</html>