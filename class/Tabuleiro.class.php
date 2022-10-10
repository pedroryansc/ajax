<?php
    require_once "autoload.php";

    class Tabuleiro extends Database{
        /**
         * Grava o identificador do Tabuleiro, usado para tabuleiros já definidos
         * @access private
         * @name idTabuleiro
         */
        private $idTabuleiro;
        /**
         * Armazena o tamanho em centímetros do lado do tabuleiro, como tem forma de quadrado
         * @access private
         * @name lado
         */
        private $lado;
        private $fundo;
        private $formas;
        /**
         * Construtor da classe. O parâmetro id não é obrigatório
         * @access public
         * @param int identificador
         * @param int lado 
         * @return void
         */
        public function __construct($id,$ld,$fundo){
            $this->setIdTabuleiro($id);
            $this->setLado($ld);
            $this->setFundo($fundo);
            $this->formas = array();
        }

        public function addForma($forma){
            array_push($this->formas,$forma);
        }

        public function setIdTabuleiro($id){
            $this->idTabuleiro = $id;
        }
        public function setLado($ld){
            if ($ld > 0)
                $this->lado = $ld;
            else
                throw new Exception('Deve ser informado um lado maior que zero');
        }
        public function setFundo($fundo){
            $this->fundo = $fundo;
        }

        public function getLado(){  return $this->lado; }
        public function getFundo(){ return $this->fundo; }
        public function getId(){ return $this->idTabuleiro; }

        /**
         * Lista todos os tabuleiros do banco conforme argumentos enviados
         * @access public
         * @param int $tipo tipo de pesquisa
         * @param String $info informação de pesquisa
         * @return Array retorna um array multidimensional com a lista dos tabuleiros
         */
        public static function listar($tipo = 0, $info = ""){
            $sql = "SELECT * FROM tabuleiro";
            // adicionar parâmetros
            if ($tipo > 0)
                switch($tipo){
                    case(1): $sql .= " WHERE idtabuleiro = :info"; break;
                    case(2): $sql .= " WHERE lado like :info"; $info .="%";  break;
                }
            $parans = array();
            if ($tipo > 0)
                $parans = array(':info'=>$info);
            return parent::buscar($sql,$parans);    
            
        }

    /**
         * Insere um tabuleiro no banco de dados
         * @access public
         * @return boolean
         *  */ 
        public function insere(){
            // montar sql - comando para inserir os dados
            $sql = "INSERT INTO tabuleiro (lado,fundo) VALUES(:l, :f)";  
            $parans = array(':l'=>$this->getLado(),
                            ':f'=>$this->getFundo(),);
            return parent::executaComando($sql,$parans);    
        }

        /**
         * Excluir um tabuleiro no banco de dados
         * @access public
         * @return boolean
         *  */ 
        public function excluir(){
            // if ($this->validaRelacao() == 0){

            // montar sql - comando para inserir os dados
            $sql = "DELETE FROM tabuleiro WHERE idtabuleiro = :q";
            $param = array(':q'=>$this->getId());
            return parent::executaComando($sql,$param);   
            
            /*
                }else{
                    throw new Exception('Não pode excluir o tabuleiro '.$this->getId().". Já possui quadrado associado.");
                }
            */

        }

        public function validaRelacao(){
            // montar sql - comando para inserir os dados
            $sql = "SELECT * FROM quadrado WHERE tabuleiro_idtabuleiro = :q";
            $param = array(':q'=>$this->getId());
            // executar e retornar o resultado

            $comando = parent::buscar($sql,$param);
            return count($comando)>0;  // retorna se encontrou algum registro
        }

        /**
         * Alterar um  tabuleiro no banco de dados 
         * @access public
         * @return boolean
         */   
        public function alterar(){
            // montar sql - comando para inserir os dados
            $sql = "UPDATE tabuleiro 
                SET lado = :l, fundo = :f
                WHERE idtabuleiro = :idq";
            
            $param = array(':l'=>$this->getLado(),':f'=>$this->getFundo(),':idq'=>$this->getId());
            // executar e retornar o resultado
            return parent::executaComando($sql,$param);   
        }
        /**
         * Função que retorna uma String com as informações para apresentar a forma
         * @access public
         * @return String
         */
        public function desenha(){
            $str = "<div style='background-image:url(".$this->getFundo().");background-size:cover; display:block;border:1px;width:".$this->getLado()."px;height:".$this->getLado()."px'></div>";
            return $str;
        }
        
        public function getQuantidadeFormas(){
            return count($this->formas);
        }
    }
?>