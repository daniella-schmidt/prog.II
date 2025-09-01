<?php
class Customer{
    private $name;
    private $cpf;

    public function __construct(){
        $this->name = "";
        $this->cpf = "";
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        if ($this->isValidCpf($cpf)) {
            $this->cpf = $cpf;
        } else {
            echo "CPF inválido.<br>";
        }
    }

    private function isValidCpf($cpf) {
        // remove os não numericos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // verifica se há 11 digitos
        if(strlen($cpf) != 11)
            return false;

        // se todos os digitos são iguais
        if(preg_match('/(\d)\1{10}/', $cpf))
            return false;

        // validação do primeiro digito
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    public function displayCustomer() {
        echo "Nome: " . $this->getName() . "<br>";
        echo "CPF: " . $this->getCpf() . "<br>";
    }
}
// teste
$customer = new Customer();
$customer->setName("Ollie Bearman");
$customer->setCpf("123.456.789-09"); // CPF inválido
$customer->displayCustomer();
$customer->setCpf("390.533.447-05"); // CPF válido
$customer->displayCustomer();
?>