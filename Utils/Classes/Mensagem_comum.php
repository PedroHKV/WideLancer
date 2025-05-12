<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/DatabaseFunctions.php";
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Mensagem.php";
    
class MensagemComum extends Mensagem{
    private $texto;
    private $imagem;

    //construtores
    public function __construct($msg_id, $texto, $imagem, $horario, $chat_id, $usuario_id){
        parent::__construct($msg_id, $horario, $chat_id, $usuario_id, "mensagem_comum");
        $this->texto = $texto;
        $this->imagem = $imagem;
    }

    //getters e setters
        public function getTexto() {
            return $this->texto;
        }

        public function setTexto($texto) {
            $this->texto = $texto;
        }

        public function getImagem() {
            return $this->imagem;
        }

        public function setImagem($imagem) {
            $this->imagem = $imagem;
        }

        public function getMensagemId() {
            return parent::getId();
        }


    //metodos publicos 
    public function cadastrar(){
        $bd = ConectarSQL();
        $sql = "CALL cadastrar_msg_comum(?, ?, ?, ?)";

        $query = $bd->prepare($sql);
        echo $this->chat_id;
        $query->bind_param("ssii", $this->texto, $this->imagem, $this->chat_id, $this->usuario_id);
        $cadastrada = $query->execute();

        $bd->close();
        return $cadastrada;
    }

    //metodos estaticos
}

?>