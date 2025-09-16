<?php
class Transport {
    protected $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function calculateFare($distance) {
        return 0; // genérico
    }

    public function getName() {
        return $this->name;
    }
}

class Bus extends Transport {
    public function calculateFare($distance) {
        return 4.50 + ($distance * 0.20);
    }
}

class Subway extends Transport {
    public function calculateFare($distance) {
        return 5.00; 
    }
}

class Taxi extends Transport {
    public function calculateFare($distance) {
        return 6.00 + ($distance * 2.50); 
    }
}

$transports = [
    new Bus("Onibus"),
    new Subway("Metro"),
    new Taxi("Taxi")
];

echo "<div style='font-family: Arial; background:#f9f9f9; padding:15px; border-radius:10px; width:550px;'>";

$distances = [2, 5, 10]; // exemplo de distâncias em km

foreach ($transports as $transport) {
    echo "<div style='margin:10px 0; padding:12px; background:#fff; border:1px solid #ddd; border-radius:8px;'>";
    echo "<h3 style='margin:0; color:#333;'>" . $transport->getName() . "</h3>";
    
    foreach ($distances as $d) {
        echo "<p style='margin:5px 0;'>";
        echo "Distância: <strong>{$d} km</strong> → Preço: <em>R$ " . number_format($transport->calculateFare($d), 2, ',', '.') . "</em>";
        echo "</p>";
    }
    
    echo "</div>";
}

echo "</div>";
?>
