<?php
class Aluno {
    public $nome;
    public $nota;

    public function CalcNota() {
        return $this->nota >= 7.0;
    }
}

$aluno1 = new Aluno();
$aluno1->nome = "Kimi Antonelli";
$aluno1->nota = 8.5; 

$aluno2 = new Aluno();
$aluno2->nome = "Ollie Bearman";
$aluno2->nota = 6.0; 

echo $aluno1->nome . ": " . 
    ($aluno1->CalcNota() ? "Aprovado" : "Reprovado") . "<br>";

echo $aluno2->nome . ": " . 
    ($aluno2->CalcNota() ? "Aprovado" : "Reprovado");
?>
