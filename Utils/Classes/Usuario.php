<?php
    include_once "C:/xampp/htdocs/WideLancer_Artefato/Utils/Classes/Portifolio.php";
    //databasefunctions ja esta incluido neste include acima

    class Usuario implements JsonSerializable{
        //atributos
        private $id;
        private $email;
        private $senha;
        private $nome;
        private $sobrenome;
        private $foto;
        private $cpf;
        private $vendedor; //booleano
        private $curador; //booleano
        private $pix;

        //construtores
        public function __construct( 
            $id, $email, $senha, $nome, $sobrenome, $foto, $cpf, $vendedor, $curador){
                $this->id = $id;
                $this->email = $email;
                $this->senha = $senha;
                $this->nome = $nome;
                $this->sobrenome = $sobrenome;
                $this->foto = $foto;
                $this->vendedor = $vendedor;
                $this->curador = $curador;
                $this->cpf = $cpf;
        }
        //getters
        public function getId(){
            return $this->id;
        }

        public function getEmail(){
            return $this->email;
        }

        public function getSenha(){
            return $this->senha;
        }

        public function getNome(){
            return $this->nome;
        }

        public function getSobrenome(){
            return $this->sobrenome;
        }

        public function getFoto(){
            return $this->foto;
        }
        
        public function getCpf(){
            return $this->cpf;
        }

        public function getPix(){
            return $this->pix;
        }

        public function setEmail( $email){
            $this->email = $email;
        }

        public function setSenha( $senha ){
            $this->senha = $senha;
        }

        public function setNome( $nome ){
            $this->nome = $nome;
        }

        public function setSobrenome( $sobrenome ){
            $this->sobrenome = $sobrenome;
        }

        public function setFoto( $foto ){
            $this->foto = $foto;
        }
        
        public function setCpf( $cpf ){
            $this->cpf = $cpf;
        }
        
        public function setPix( $pix ){
            $this->pix = $pix;
        }
        
        public function isVendedor(){
            return  $this->vendedor;
        }

        public function isCurador(){
            return $this->curador;
        }

        public function setVendedor( $bool ){
            $this->vendedor = $bool;
        }

        public function setCurador( $bool ){
            $this->curador = $bool;
        }


        //metodos publicos
        public function cadastrar(){
            $bd = ConectarSQL();
            $sql = "INSERT INTO Usuario(email, senha, nome, sobrenome, vendedor, curador, foto)
            VALUES (?, ?, ?, ?, false, false, ?)";

            $query = $bd->prepare($sql);
            $query->bind_param(
                "sssss",
                $this->email,$this->senha, $this->nome, $this->sobrenome, $this->foto 
            );
            $cadastrado = $query->execute();
            $query->close();
            $bd->close();
            return $cadastrado;

        }

        //para esse metodo, supoe-se:
        //que o objeto esteja com as alterações do update
        //que a tabela do banco de dados esteja desatualizada e pronta
        //para receber as atualizações que o objeto carrega
        public function salvarUpdates(){
            $bd = ConectarSQL();

            $sql = 
            "UPDATE Usuario SET nome = ?, sobrenome = ?, email = ?, ".
            "senha = ?, foto = ?, vendedor = ?, curador = ?, pix = ?, cpf = ? ".
            "WHERE id = ".$this->getId();

            $query = $bd->prepare($sql);
            $query->bind_param("sssssiiss", 
            $this->nome, $this->sobrenome, $this->email, 
            $this->senha, $this->foto, $this->vendedor, $this->curador,
            $this->pix, $this->cpf
            );
            $atualizado = $query->execute();
            $bd->close();
            return $atualizado;
        }

        //metodo para cadastrar um portifolio no banco de dados
        //para essa finalidade foi definido o metodo dentro da classe
        //usuario e nao portifolio , porque o portifolio prcisa do id de um
        //usuario para existir
        public function criarPortifolio($foto, $titulo, $descricao){
            $bd = ConectarSQL();
            $sql = "INSERT INTO Portifolio(foto, titulo, descricao, usuario_id) ".
            "VALUES (?, ?, ?, ?);";

            $query = $bd->prepare($sql);
            $query->bind_param("sssi", $foto, $titulo, $descricao, $this->id);
            $cadastrado = $query->execute();

            $bd->close();   
            return $cadastrado;
        }

        //metodo para transformar usuario em JSON
        public function jsonSerialize(){
            return [
                "id" => $this->id,
                "email" => $this->email,
                "nome" => $this->nome,
                "sobrenome" => $this->sobrenome,
                "foto" => $this->foto,
                "cpf" => $this->cpf,
                "vendedor" => $this->vendedor,
                "curador" => $this->curador,
                "pix" => $this->pix ?? null
            ];
        }

        //pesquisa um usuario no banco de dados por id
        //retorna o objeto do usuario ou null caso ele nao exista no bd
        public static function findUsuarioById( $id ){
            $BD = ConectarSQL();
            $sql = "SELECT * FROM Usuario WHERE id = ?";

            $query = $BD->prepare($sql);
            $query->bind_param("i", $id);
            $query->execute();
            $resultado = $query->get_result();
            //como o $id é unico:

            if ( $resultado->num_rows > 0){
                $linha = $resultado->fetch_assoc();
                
                $usuario = new Usuario(
                $id,
                $linha["email"],
                $linha["senha"],
                $linha["nome"],
                $linha["sobrenome"],
                $linha["foto"],
                $linha["cpf"],
                $linha["vendedor"],
                $linha["curador"]
                );

                if ( isset($linha["pix"]) ){
                    $usuario->setPix($linha["pix"]);
                }
                 
                 $query->close();
                 $BD->close();
                return $usuario;
            } else {
                $query->close();
                $BD->close();
                return null;
            }

        }

        //metodos publicos e estaticos

        //pesquisa um usuario no banco de dados por email
        //retorna o objeto do usuario ou null caso ele nao exista no bd
        public static function findUsuarioByEmail( $email ){
            $BD = ConectarSQL();
            $sql = "SELECT * FROM Usuario WHERE email = ?";

            $query = $BD->prepare($sql);
            $query->bind_param("s", $email);
            $query->execute();
            $resultado = $query->get_result();
            //como o $id é unico:

            if ( $resultado->num_rows > 0){
                $linha = $resultado->fetch_assoc();

                $usuario = new Usuario(
                $linha["id"],
                $linha["email"],
                $linha["senha"],
                $linha["nome"],
                $linha["sobrenome"],
                $linha["foto"],
                $linha["cpf"],
                $linha["vendedor"],
                $linha["curador"]
                );
                 
                 $query->close();
                 $BD->close();
                return $usuario;
            } else {
                $query->close();
                $BD->close();
                return null;
            }
        }

        public static function findUsuariosByFuncao( $funcao ){
            $BD = ConectarSQL();

            if ($funcao === "curador"){
                $sql = "SELECT * FROM Usuario WHERE curador = 1";
            } else if ($funcao === "vendedor"){
                $sql = "SELECT * FROM Usuario WHERE vendedor = 1";
            } else if ($funcao === "cliente") {
                $sql = "SELECT * FROM Usuario WHERE cpf IS NOT NULL";
            } else {
                $sql = "SELECT * FROM Usuario";
            }


            $query = $BD->prepare($sql);
            $query->execute();
            $resultado = $query->get_result();
            //como o $id é unico:

            if ( $resultado->num_rows > 0){

                $usuarios = [];
                while ($linha = $resultado->fetch_assoc()){
                    $usuario = new Usuario(
                    $linha["id"],
                    $linha["email"],
                    $linha["senha"],
                    $linha["nome"],
                    $linha["sobrenome"],
                    $linha["foto"],
                    $linha["cpf"],
                    $linha["vendedor"],
                    $linha["curador"]
                    );

                    if ( isset($linha["pix"]) ){
                        $usuario->setPix($linha["pix"]);
                    }

                    $usuarios[] = $usuario;
                } 

                $query->close();
                $BD->close();
                return $usuarios;
            } else {
                $query->close();
                $BD->close();
                return null;
            }

        }

        public static function deleteUsuarioById($id) {
            $bd = ConectarSQL();

            $sql = "DELETE FROM Usuario WHERE id = ?";

            $query = $bd->prepare($sql);
            $query->bind_param("i", $id);

            $sucesso = $query->execute();

            $query->close();
            $bd->close();

            return $sucesso;
        }


    }
?>