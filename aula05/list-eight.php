<?php
class Client{
    public $name;
    protected $cpf;
    private $phone;

    // Construtor
    public function __construct($name = "", $cpf = "", $phone = "") {
        $this->setName($name);
        $this->setCpf($cpf);
        $this->setPhone($phone);
    }

    // Getter para name
    public function getName() {
        return $this->name;
    }

    // Setter para name
    public function setName($name) {
        if (is_string($name) && strlen(trim($name)) > 0) {
            $this->name = $name;
        } else {
            $this->name = "Cliente sem nome";
        }
    }

    // Getter para cpf
    public function getCpf() {
        return $this->cpf;
    }

    // Setter para cpf
    public function setCpf($cpf) {
        // CPF deve ter 11 dígitos numéricos
        if (preg_match('/^\d{11}$/', $cpf)) {
            $this->cpf = $cpf;
        } else {
            $this->cpf = "00000000000"; 
        }
    }

    // Getter para phone
    public function getPhone() {
        return $this->phone;
    }

    // Setter para phone
    public function setPhone($phone) {
        // Telefone deve ter 10 ou 11 dígitos numéricos
        if (preg_match('/^\d{10,11}$/', $phone)) {
            $this->phone = $phone;
        } else {
            $this->phone = "0000000000"; 
        }
    }

    public function __toString() {
        return "Nome: " . $this->getName() . " | CPF: " . $this->getCpf() . " | Telefone: " . $this->getPhone();
    }
}
//Instanciação
$client = new Client("Lewis Hamilton", "12345678901", "11987654321");
echo $client . "<br>";

// Acesso direto ao atributo público, é possivel pois sua visibilidade permite
echo "Acesso direto ao nome: " . $client->name . "<br>";
// Acesso ao atributo protegido via método público
echo "Acesso ao CPF via método: " . $client->getCpf() . "<br>";
// Acesso ao atributo privado via método público
echo "Acesso ao telefone via método: " . $client->getPhone() . "<br>";

// Tentativa de acesso direto ao atributo protegido (gera erro), assim como o resto se testar acesso direto ao atributo privado
//echo "Acesso direto ao CPF: " . $client->cpf . "<br>";   

//Justificativa:
// O atributo name é público para permitir acesso direto, facilitando operações simples.
// O atributo cpf é protegido para permitir acesso em subclasses, mas proteger contra acesso externo direto.
// O atributo phone é privado para garantir que apenas métodos controlados possam acessar ou modificar o telefone, aumentando a segurança dos dados.
// A validação nos setters assegura que os dados estejam no formato correto, evitando inconsistências.
// A implementação do método __toString facilita a exibição dos dados do cliente de forma organizada.
?>