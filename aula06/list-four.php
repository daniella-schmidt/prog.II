<?php
class User{
    private $password;

    public function __construct(){
        $this->password = "";
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function verifyPassword($inputPassword) {
        return $this->getPassword() === $inputPassword;
    }

    public function displayPassword() {
        echo "Senha: " . $this->getPassword() . "<br>";
    }
}
// teste
$user = new User();
$user->setPassword("minhaSenha123");
$user->displayPassword(); // Exibe a senha definida
$input = "minhaSenha123";
if ($user->verifyPassword($input)) {
    echo "Senha correta.<br>";
} else {
    echo "Senha incorreta.<br>";
}
$input = "senhaErrada";
if ($user->verifyPassword($input)) {
    echo "Senha correta.<br>";
} else {
    echo "Senha incorreta.<br>";
}

?>