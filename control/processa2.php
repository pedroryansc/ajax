<?php
    require_once("../class/autoload.php");

    // Carregar dados enviados pelo formulário da página "index.php"
    $lado = isset($_POST["lado"]) ? $_POST["lado"] : 1;
    // $arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : null;
    // $destino = "imagens/".date("Hisms").".png";
    // move_uploaded_file($_FILES["arquivo"]["tmp_name"], $destino);

    $destino = "imagens";
    
    if(isset($_POST["id"])) // Se o "id" for enviado via POST, é uma edição
        $id = $_POST["id"];
    else // Se for exclusão, os dados virão via GET
        $id = isset($_GET["id"]) ? $_GET["id"] : 0;
    $acao = "";

    try{
        // Cria objeto "Tabuleiro" com os valores carregados acima
        $tab = new Tabuleiro($id, $lado, $destino);
        $ultimo = "";
        if($id > 0) // Atualizar existente
            $tab->alterar();
        else // Novo registro, porque o "id" não foi enviado
            $ultimo = $tab->insere();
        $novo = Tabuleiro::listar(1, $ultimo);
        echo json_encode($novo->fetch(PDO::FETCH_ASSOC));
    } catch(Exception $e){ // Pega todos os erros de execução
        $erro = array("ERR"=>$e->getMessage());
        echo json_encode($erro);
    }
?>