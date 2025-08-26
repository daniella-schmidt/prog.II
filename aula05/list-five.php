<?php
class User {
    protected $username;
    private $password;

    // Construtor
    public function __construct($username = "", $password = "") {
        $this->setUsername($username);
        $this->setPassword($password);
    }

    public function setUsername($username){
        // Nome de usuário não pode ser vazio
        if(is_string($username) && strlen(trim($username)) > 0){
            $this->username = $username;
        } else {
            $this->username = "Usuário sem nome";
        }
    }

    public function setPassword($password){
        // Senha deve ter pelo menos 6 caracteres
        if(is_string($password) && strlen($password) >= 6){
            $this->password = $password;
        } else {
            // Senha inválida
            $this->password = ""; 
        }
    }

    // Método para verificar a senha
    public function verifyPassword($inputPassword){
        return $this->password === $inputPassword;
    }

    public function __toString(){
        return "Username: {$this->username} | Senha: " 
            . ($this->password ? str_repeat('*', strlen($this->password)) : 'Nenhuma senha definida') 
            . "<br>";
    }
}

// Instanciação
$user = new User("charles_leclerc", "ferrari16");
echo $user;
echo "Verificação de senha 'ferrari16': " . ($user->verifyPassword("ferrari16") ? "Verdadeiro" : "Falso") . "<br>";
echo "Verificação de senha 'mercedes44': " . ($user->verifyPassword("mercedes44") ? "Verdadeiro" : "Falso") . "<br>";

// Justificativa:
// A classe User utiliza um atributo privado para a senha, garantindo que ela não possa ser acessada diretamente de fora da classe.
// O método verifyPassword permite verificar a senha sem expô-la, retornando apenas verdadeiro ou falso.
// A validação no setter assegura que a senha tenha um comprimento mínimo, aumentando a segurança.
// O atributo username é protegido para permitir herança futura, se necessário.
// O método __toString exibe o nome de usuário e uma representação mascarada da senha para evitar exposição direta.

?>

