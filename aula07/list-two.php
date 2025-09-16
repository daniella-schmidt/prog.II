<?php
class Calculator {
    public function add($a, $b = null, $c = null) {
        if ($c !== null) {
            return $a + $b + $c;
        } elseif ($b !== null) {
            return $a + $b;
        } else {
            return $a;
        }
    }
    
    public function operate($operation, $a, $b = null, $c = null) {
        switch (strtolower($operation)) {
            case 'add':
                return $this->add($a, $b, $c);
            case 'subtract':
                return $this->subtract($a, $b, $c);
            case 'multiply':
                return $this->multiply($a, $b, $c);
            case 'divide':
                return $this->divide($a, $b);
            default:
                throw new InvalidArgumentException("Operação não suportada: " . $operation);
        }
    }

    private function subtract($a, $b = null, $c = null) {
        if ($c !== null) {
            return $a - $b - $c;
        } elseif ($b !== null) {
            return $a - $b;
        } else {
            return -$a;
        }
    }
    
    private function multiply($a, $b = null, $c = null) {
        if ($c !== null) {
            return $a * $b * $c;
        } elseif ($b !== null) {
            return $a * $b;
        } else {
            return $a; 
        }
    }
    
    private function divide($a, $b) {
        if ($b == 0) {
            throw new InvalidArgumentException("Divisão por zero não é permitida");
        }
        return $a / $b;
    }
    
    public function addArray(array $numbers) {
        return array_sum($numbers);
    }
}
$calc = new Calculator();

echo "<h3>Função add()</h3>";
echo "<p><b>add(5)</b> = " . $calc->add(5) . "</p>";
echo "<p><b>add(5, 3)</b> = " . $calc->add(5, 3) . "</p>";
echo "<p><b>add(5, 3, 2)</b> = " . $calc->add(5, 3, 2) . "</p>";

echo "<hr><h3>Função operate()</h3>";
echo "<p><b>operate('add', 10, 5)</b> = " . $calc->operate('add', 10, 5) . "</p>";
echo "<p><b>operate('subtract', 10, 5)</b> = " . $calc->operate('subtract', 10, 5) . "</p>";
echo "<p><b>operate('multiply', 10, 5)</b> = " . $calc->operate('multiply', 10, 5) . "</p>";
echo "<p><b>operate('divide', 10, 5)</b> = " . $calc->operate('divide', 10, 5) . "</p>";
