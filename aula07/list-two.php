<?php
class Calculator {
    // Realiza adição com diferentes quantidades de parâmetros
    public function add($a, $b = null, $c = null) {
        // Validação dos parâmetros
        if (!is_numeric($a) || ($b !== null && !is_numeric($b)) || ($c !== null && !is_numeric($c))) {
            throw new InvalidArgumentException("Todos os parâmetros devem ser numéricos");
        }
        
        if ($c !== null) {
            return $a + $b + $c;
        } elseif ($b !== null) {
            return $a + $b;
        } else {
            return $a;
        }
    }
    
    // Executa operações matemáticas baseadas no parâmetro $operation
    public function operate($operation, $a, $b = null, $c = null) {
        // Validação dos parâmetros
        if (!is_numeric($a) || ($b !== null && !is_numeric($b)) || ($c !== null && !is_numeric($c))) {
            throw new InvalidArgumentException("Todos os parâmetros devem ser numéricos");
        }
        
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

    // Realiza subtração com diferentes quantidades de parâmetros
    private function subtract($a, $b = null, $c = null) {
        if ($c !== null) {
            return $a - $b - $c;
        } elseif ($b !== null) {
            return $a - $b;
        } else {
            return -$a;
        }
    }
    
    // Realiza multiplicação com diferentes quantidades de parâmetros
    private function multiply($a, $b = null, $c = null) {
        if ($c !== null) {
            return $a * $b * $c;
        } elseif ($b !== null) {
            return $a * $b;
        } else {
            return $a; 
        }
    }
    
    // Realiza divisão entre dois números
    private function divide($a, $b) {
        if ($b == 0) {
            throw new InvalidArgumentException("Divisão por zero não é permitida");
        }
        return $a / $b;
    }
    
    // Soma os valores de um array
    public function addArray(array $numbers) {
        if (empty($numbers)) {
            throw new InvalidArgumentException("O array não pode estar vazio");
        }
        
        foreach ($numbers as $number) {
            if (!is_numeric($number)) {
                throw new InvalidArgumentException("Todos os elementos do array devem ser numéricos");
            }
        }
        
        return array_sum($numbers);
    }
}

$calc = new Calculator();

echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
    .result-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
    h3 { color: #333; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
    p { margin: 8px 0; }
    .error { color: red; }
</style>";

echo "<div class='result-container'>";
echo "<h3>Função add() - Demonstração de Sobrecarga com Parâmetros Opcionais</h3>";
try {
    echo "<p><b>add(5)</b> = " . $calc->add(5) . "</p>";
    echo "<p><b>add(5, 3)</b> = " . $calc->add(5, 3) . "</p>";
    echo "<p><b>add(5, 3, 2)</b> = " . $calc->add(5, 3, 2) . "</p>";
    
    // Teste com array
    echo "<p><b>addArray([2, 4, 6, 8])</b> = " . $calc->addArray([2, 4, 6, 8]) . "</p>";
} catch (InvalidArgumentException $e) {
    echo "<p class='error'>Erro: " . $e->getMessage() . "</p>";
}
echo "</div>";

echo "<div class='result-container'>";
echo "<h3>Função operate() - Multipropósito com Switch</h3>";
try {
    echo "<p><b>operate('add', 10, 5)</b> = " . $calc->operate('add', 10, 5) . "</p>";
    echo "<p><b>operate('subtract', 10, 5)</b> = " . $calc->operate('subtract', 10, 5) . "</p>";
    echo "<p><b>operate('multiply', 10, 5)</b> = " . $calc->operate('multiply', 10, 5) . "</p>";
    echo "<p><b>operate('divide', 10, 5)</b> = " . $calc->operate('divide', 10, 5) . "</p>";
    
    // Teste de erro - divisão por zero
    echo "<p><b>operate('divide', 10, 0)</b> = " . $calc->operate('divide', 10, 0) . "</p>";
} catch (InvalidArgumentException $e) {
    echo "<p class='error'>Erro: " . $e->getMessage() . "</p>";
}
echo "</div>";
?>