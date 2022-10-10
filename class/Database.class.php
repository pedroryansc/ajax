<?php
    class Database{
        public static function iniciaConexao(){
            require_once("Conexao.class.php");
            return Conexao::getInstance();
        }

        public static function vinculaParametros($comando, $parametros = array()){
            foreach($parametros as $chave=>$valor){
                $comando->bindValue($chave, $valor);
            }
            return $comando;
        }

        public static function executaComando($sql, $parametros = array()){
            $conexao = self::iniciaConexao();
            $comando = $conexao->prepare($sql);
            $comando = self::vinculaParametros($comando, $parametros);
            try{
                return $comando->execute();
            } catch(PDOException $e){
                throw new Exception("Erro na execução do comando: ".$e->getMessage());
            }
        }

        public static function buscar($sql, $parametros = array()){
            $conexao = self::iniciaConexao();
            $comando = $conexao->prepare($sql);
            $comando = self::vinculaParametros($comando, $parametros);
            $comando->execute();
            return $comando->fetchAll();
        }
    }
?>