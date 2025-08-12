<?php
class ContaBancaria{
    public $titular;
    public $saldo;
    public function __construct($titular, $saldo){
        $this->titular = $titular;
        $this->saldo = $saldo;
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
        echo "Titular: {$this->titular} | Saldo: R$ {$this->saldo}\n";
    }
}
$conta = new ContaBancaria("Charles Leclerc", 1000);
$conta->depositar(500)->sacar(200)->exibirSaldo();
?>