<?php
    include "C:/xampp/htdocs/WideLancer_Artefato/Utils/DatabaseFunctions.php";

    class Usuario{
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
        private $portifolio;

        //construtores
        public function __construct( 
            $id, $email, $senha, $nome, $sobrenome, $foto, $cpf, $vendedor, $curador){
                $this->id = $id;
                $this->email = $email;
                $this->senha = $senha;
                $this->nome = $nome;
                $this->sobrenome = $sobrenome;
                $this->foto = $foto;
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

        public function isVendedor(){
            return $this->vendedor;
        }

        public function isCurador(){
            return $this->curador;
        }

        //metodos publicos
        public function cadastrar(){
            $bd = ConectarSQL();
            $sql = "INSERT INTO Usuario(email, senha, nome, sobrenome, vendedor, curador)
            VALUES (?, ?, ?, ?, false, false)";

            $query = $bd->prepare($sql);
            $query->bind_param(
                "ssss",
                $this->email,$this->senha, $this->nome, $this->sobrenome, 
            );
            $cadastrado = $query->execute();
            $query->close();
            return $cadastrado;

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
            $query->bind_param("i", $email);
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

    }
?>