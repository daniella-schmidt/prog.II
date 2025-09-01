<?php
class BankAccount{
    private $balance;

    public function __construct() {
        $this->balance = 0.0; // Inicializa o saldo com zero
    }

    // getter para saldo
    public function getBalance(){
        return $this->balance;
    }

    // setter para saldo
    private function setBalance($amount){
        if (is_numeric($amount) && $amount >= 0){
            $this->balance = $amount;
        }
    }

    // método para depositar
    public function deposit($amount){
        if (is_numeric($amount) && $amount > 0){
            $this->setBalance($this->getBalance() + $amount);
            echo "Depósito de R$" . number_format($amount, 2) . " realizado com sucesso.<br>";
        } else {
            echo "Valor de depósito inválido.<br>";
        }
    }

    // método para sacar
    public function withdraw($amount){
        if (is_numeric($amount) && $amount > 0){
            if ($this->getBalance() >= $amount){
                $this->setBalance($this->getBalance() - $amount);
                echo "Saque de R$" . number_format($amount, 2) . " realizado com sucesso.<br>";
            } else {
                echo "Saldo insuficiente para saque de R$" . number_format($amount, 2) . ".<br>";
            }
        } else {
            echo "Valor de saque inválido.<br>";
        }
    }

    // método para exibir saldo
    public function displayBalance(){
        echo "Saldo atual: R$" . number_format($this->getBalance(), 2) . "<br>";
    }
}
// Instanciação e testes
$account = new BankAccount();
$account->displayBalance(); // Saldo inicial
$account->deposit(500); // Depósito
$account->displayBalance(); // Saldo após depósito
$account->withdraw(200); // Saque
$account->displayBalance(); // Saldo após saque
$account->withdraw(400); // Tentativa de saque maior que o saldo
$account->displayBalance(); // Saldo final
?>