<?php
class Calculadora {
    public function somar($a, $b) {
        return $a + $b;
    }

    public function subtrair($a, $b) {
        return $a - $b;
    }

    public function multiplicar($a, $b) {
        return $a * $b;
    }

    public function dividir($a, $b) {
        if ($b == 0) {
            return "Erro: Divisão por zero.";
        }
        return $a / $b;
    }
}
$calc = new Calculadora();
echo "Soma: " . $calc->somar(10, 5) ."";    
echo "". $calc->somar(10,5) . 
" - Subtração: " . $calc->subtrair(10, 5) ."";
echo "". $calc->subtrair(10,5) .
" - Multiplicação: " . $calc->multiplicar(10, 5) ."";
echo "". $calc->multiplicar(10,5) .
"". $calc->subtrair(10,5) .
" - Divisão: " . $calc->dividir(10, 5);
?>