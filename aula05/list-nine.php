<?php
class BankAccount {
    // Todos os atributos são privados
    private $id;
    private $name;
    private $accountNumber;
    private $accountType;
    private $balance;

    // Construtor 
    public function __construct($id, $name, $accountNumber, $accountType, $balance) {
        $this->setId($id);
        $this->setName($name);
        $this->setAccountNumber($accountNumber);
        $this->setAccountType($accountType);
        $this->setBalance($balance);
    }

    // Getters e setters para todos os atributos
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        if (is_numeric($id) && $id > 0) {
            $this->id = $id;
        } else {
            $this->id = 0;
        }
    }

    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        if (is_string($name) && strlen(trim($name)) > 0) {
            $this->name = $name;
        } else {
            $this->name = "Sem nome";
        }
    }

    public function getBankAccount() {
        return $this->accountNumber;
    }
    public function setAccountNumber($accountNumber) {
        if (is_string($accountNumber) && strlen(trim($accountNumber)) > 0) {
            $this->accountNumber = $accountNumber;
        } else {
            $this->accountNumber = "0000000";
        }
    }

    public function getAccountType() {
        return $this->accountType;
    }
    public function setAccountType($accountType) {
        if (is_string($accountType) && strlen(trim($accountType)) > 0) {
            $this->accountType = $accountType;
        } else {
            $this->accountType = "Indefinido";
        }
    }

    public function getBalance() {
        return $this->balance;
    }
    public function setBalance($balance) {
        // Saldo deve ser numérico e não negativo
        if (is_numeric($balance) && $balance >= 0) {
            $this->balance = $balance;
        } else {
            $this->balance = 0;
        }
    }

    // Exibe informações da conta
    public function __toString() {
        return "ID: {$this->id} | Nome: {$this->name} | Conta: {$this->accountNumber} | Tipo: {$this->accountType} | Saldo: R$ "
            . number_format($this->balance, 2, ',', '.')
            . "<br>";
    }

    // Realiza depósito se valor for válido
    public function deposit($amount) {
        if (is_numeric($amount) && $amount > 0) {
            $this->balance += $amount;
            return true;
        }
        return false; // Depósito inválido
    }

    // Realiza saque apenas se saldo for suficiente
    public function withdraw($amount) {
        if (!is_numeric($amount) || $amount <= 0) {
            return false; 
        }
        if ($amount > $this->balance) {
            // Não permite saque se saldo insuficiente
            return false;
        }
        $this->balance -= $amount;
        return true;
    }
}
// Instanciação 
$account1 = new BankAccount(1, "Sebastian Vettel", "7451359", "Corrente", 1000);
$account1->deposit(500);
if ($account1->withdraw(200)) {
    echo "Saque realizado com sucesso!<br>";
} else {
    echo "Saldo insuficiente para saque.<br>";
}
echo $account1 . "\n";

$account2 = new BankAccount(2, "Kimi Antonelli", "8745632", "Poupança", 1500.50);
$account2->deposit(300.75);
if ($account2->withdraw(2000)) {
    echo "Saque realizado com sucesso!<br>";
} else {
    echo "Saldo insuficiente para saque.<br>";
}
echo $account2 . "\n";

// Justificativa:
// Todos os atributos são privados para garantir encapsulamento e segurança dos dados.
// Getters e setters validam e controlam o acesso aos dados.
// O método withdraw só permite saque se houver saldo suficiente, evitando saldo negativo.
// O construtor usa setters para garantir validação desde a criação do objeto.
?>