<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/DatabaseFunctions.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem.php";

    class Proposta extends Mensagem{
        private $orcamento;
        private $prazo;
        private $aceita;

        //construtores
        public function __construct($id, $orcamento, $prazo, $aceita, $usuario_id, $chat_id, $horario) {
            parent::__construct($id, $horario, $chat_id, $usuario_id, "proposta");
            $this->orcamento = $orcamento;
            $this->prazo = $prazo;
            $this->aceita = $aceita;
        }


        //getters e setters 
        public function getOrcamento() {
            return $this->orcamento;
        }

        public function setOrcamento($orcamento) {
            $this->orcamento = $orcamento;
        }

        public function getPrazo() {
            return $this->prazo;
        }

        public function setPrazo($prazo) {
            $this->prazo = $prazo;
        }

        public function getAceita() {
            return $this->aceita;
        }

        public function setAceita($aceita) {
            $this->aceita = $aceita;
        }

        public function getId(){
            return parent::getId();
        }
        //metodos publicos 

        public function cadastrar(){
            $bd = ConectarSQL();
            $sql = "CALL cadastrar_proposta(?, ?, ?, ?)";

            $query = $bd->prepare($sql);
            $query->bind_param("sdii", $this->prazo, $this->orcamento, $this->chat_id, $this->usuario_id);
            $cadastrada = $query->execute();

            $bd->close();
            return $cadastrada;
        }

        //metodos estaticos
    }
?>