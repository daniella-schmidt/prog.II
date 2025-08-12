<?php
class Funcionario{
    public $nome;
    public $salario;

    public function __construct($nome, $salario){
        $this->nome = $nome;
        $this->salario = $salario;
    }
    public function reajustarSalario($percentual){
        $this->salario += $this->salario * ($percentual / 100);
    }
    public function exibirDados(){
        echo "<br>Nome: {$this->nome} | Salário: R$ " . number_format($this->salario, 2, ',', '.') . "<br>";
    }
}
$funcionarios = [
    new Funcionario("Alice", 3000),
    new Funcionario("Bob", 4500),
    new Funcionario("Charlie", 6000)
];
echo "<br>Lista após reajuste salarial:<br>";
foreach($funcionarios as $funcionario){
    $funcionario->reajustarSalario(10); // 10%
    $funcionario->exibirDados();
}
?>