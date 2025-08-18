<?php
class ContaBancaria{
    public $titular;
    public $saldo;
    public $conta;

    public function __construct($titular, $saldo){
        $this->titular = $titular;
        $this->saldo = $saldo;
       // gera um numero de conta aleatório com 6 digitos
        $this->conta = rand(100000, 999999);
    }

    public function getConta(){
        return $this->conta;
    }

    public function depositar($valor){
        $this->saldo += $valor;
        return $this;
    }

    public function sacar($valor){
        $this->saldo -= $valor;
        return $this;
    }

    public function exibirSaldo(){
        echo "Titular: {$this->titular} | Conta: {$this->conta} | Saldo: R$ {$this->saldo}\n";
    }
}

$conta1 = new ContaBancaria("Charles Leclerc", 1000);
$conta1->depositar(500)->sacar(200)->exibirSaldo();

$conta2 = new ContaBancaria("Carlos Sainz",976.75);
$conta2->depositar(148.45)->sacar(85.5)->exibirSaldo();
?>