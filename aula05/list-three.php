<?php
class BankAccount {
    private $id;
    private $name;
    private $accountNumber;
    private $accountType;
    private $balance;

    // Construtor
    public function __construct($id, $name, $accountNumber, $accountType, $balance) {
        $this->id = $id;
        $this->name = $name;
        $this->accountNumber = $accountNumber;
        $this->accountType = $accountType;
        $this->setBalance($balance); // Usando o setter para garantir validação
    }

    // Getters para todos os atributos
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function getBankAccount() {
        return $this->accountNumber;
    }
    public function getAccountType() {
        return $this->accountType;
    }
    public function getBalance() {
        return $this->balance;
    }

    // Setter para saldo com validação
    public function setBalance($balance) {
        // Saldo deve ser numérico e não negativo
        if (is_numeric($balance) && $balance >= 0) {
            $this->balance = $balance;
        } else {
            // Caso de entrada inválida
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
        if (is_numeric($amount) && $amount > 0 && $amount <= $this->balance) {
            $this->balance -= $amount;
            return true;
        }
        return false; // Saque inválido
    }
}

// Instanciação
$account1 = new BankAccount(1, "Sebastian Vettel", "7451359", "Corrente", 1000);
$account1->deposit(500);
$account1->withdraw(200);
echo $account1 . "\n";

$account2 = new BankAccount(2, "Kimi Antonelli", "8745632", "Poupança", 1500.50);
$account2->deposit(300.75);
$account2->withdraw(100.25);
echo $account2 . "\n";

// Justificativa:
// Todos os atributos são privados para garantir encapsulamento e segurança dos dados.
// O método setBalance valida o saldo, evitando valores negativos ou inválidos.
// O método withdraw só permite saque se houver saldo suficiente, evitando saldo negativo.
// O construtor usa o setter para saldo, garantindo validação desde a criação do objeto.
?>