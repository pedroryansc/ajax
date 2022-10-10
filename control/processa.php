<?php
    require_once("../class/autoload.php");

    // Carregar dados enviados pelo formulário na página "index.php"
    $lado = isset($_POST["lado"]) ? $_POST["lado"] : 1;
    var_dump($_FILES);
    // die();
    $arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : NULL;
    // Mover arquivo
    $destino = "../img/".date("Hisms").".png";
    move_uploaded_file($_FILES["arquivo"]["tmp_name"], $destino);

    if(isset($_POST["id"])) // Se o ID for enviado via POST, é uma edição
        $id = $_POST["id"];
    else // Se o ID for enviado via GET, é uma exclusão
        $id = isset($_GET["id"]) ? $_GET["id"] : 0;

    if(isset($_POST["acao"]))
        $acao = $_POST["acao"];
    else // Se o ação for enviado via GET, é uma exclusão
        $acao = isset($_GET["acao"]) ? $_GET["acao"] : "";

    try{
        // Cria objeto "Tabuleiro" com os valores carregados acima
        $tab = new Tabuleiro($id, $lado, $destino);
        if($acao == "salvar"){
            if($id > 0)
                $tab->alterar();
            else
                $tab->insere();
        } else if($acao == "excluir"){
            $tab->excluir();
        } else if($acao == "consultar"){
            header("location:../pag/consulta.php?id=".$id);
            exit();
        }
        header("location:../pag/index.php");
    } catch(Exception $e){ // Pega todos os erros de execução
        print($e->getMessage()); // Apresenta a mensagem de erro disparada pela classe
    }
?>