<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/DatabaseFunctions.php";
    
    class Mensagem{
        
        private $id;
        private $texto;
        private $horario;
        private $chat_id;
        private $usuario_id;
        private $proposta;
        private $prazo;
        private $orcamento;

        //construtores
        function __construct($id, $texto, $horario, $chat_id, $usuario_id, $proposta = false, $prazo = NULL, $orcamento = NULL){
            $this->id = $id;
            $this->texto = $texto;
            $this->horario = $horario;
            $this->chat_id = $chat_id;
            $this->usuario_id = $usuario_id;
            $this->prazo = $prazo;
            $this->proposta = $proposta;
            $this->orcamento = $orcamento;
        }


        //getters e setters

        public function getId(){
            return $this->id;
        }

        public function getTexto(){
            return $this->texto;
        }

        public function getHorario(){
            return $this->horario;
        }

        public function getChatId(){
            return $this->chat_id;
        }

        public function getUsuarioId(){
            return $this->usuario_id;
        }

        public function getProposta(){
            return $this->proposta;
        }

        public function getPrazo(){
            return $this->prazo;
        }

        public function getOrcamento(){
            return $this->orcamento;
        }


        //metodos publicos

        public function cadastrar(){
            $bd = ConectarSQL();
            $sql = "INSERT INTO Mensagem(texto, horario, chat_id, usuario_id) VALUES (?, ?, ?, ?);";
            $query = $bd->prepare($sql);
            $proposta = false;
            $query->bind_param("ssii", $this->texto, $this->horario, $this->chat_id, $this->usuario_id);
            $cadastrado =  $query->execute();
            $bd->close();
            return $cadastrado ;
        }

        public function cadastrarComoProposta(){
            $bd = ConectarSQL();
            $sql = "INSERT INTO Mensagem(horario, proposta, orcamento, prazo, chat_id, usuario_id) VALUES (?, ?, ?, ?, ?, ?);";
            $query = $bd->prepare($sql);
            $query->bind_param("sidsii", $this->horario, $this->proposta, $this->orcamento, $this->prazo, $this->chat_id, $this->usuario_id);
            $cadastrado =  $query->execute();
            $bd->close();
            return $cadastrado ;
        }
        
        //metodos estaticos
        
        public static function findMensagensByChatId( $id ){
            $bd = ConectarSQL();
            $sql = "SELECT * FROM Mensagem WHERE chat_id = ?";
            $query = $bd->prepare($sql);
            $query->bind_param("i", $id);
            $query->execute();

            $mensagens = [];
            $result = $query->get_result();
            while ( $linha = $result->fetch_assoc() ){
                $mensagem = new Mensagem(
                    $linha["id"],
                    $linha["texto"],
                    $linha["horario"],
                    $linha["chat_id"],
                    $linha["usuario_id"],
                    $linha["proposta"],
                    $linha["prazo"],
                    $linha["orcamento"]
                );

                $mensagens[] = $mensagem;
            }

            $bd->close();
            return $mensagens;
        }

    }

?>