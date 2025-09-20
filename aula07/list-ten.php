<?php
abstract class Transport {
    protected $name;
    protected $baseFare;
    
    // Construtor da classe
    public function __construct($name, $baseFare = 0) {
        if (empty(trim($name))) {
            throw new InvalidArgumentException("O nome do transporte não pode estar vazio");
        }
        
        if (!is_numeric($baseFare) || $baseFare < 0) {
            throw new InvalidArgumentException("A tarifa base deve ser numérica e não negativa");
        }
        
        $this->name = $name;
        $this->baseFare = (float) $baseFare;
    }
    
    // Método abstrato que deve ser implementado pelas subclasses
    abstract public function calculateFare($distance);
    
    // Retorna informações do transporte
    public function getTransportInfo() {
        return "Transporte: {$this->name} | Tarifa Base: R$ " . number_format($this->baseFare, 2, ',', '.');
    }
    
    // Obtém o nome do transporte
    public function getName() {
        return $this->name;
    }
    
    // Obtém a tarifa base
    public function getBaseFare() {
        return $this->baseFare;
    }
    
    // Processa o cálculo da tarifa
    public function processFareCalculation($distance) {
        $this->validateDistance($distance);
        return $this->calculateFare($distance);
    }
    
    // Valida a distância
    protected function validateDistance($distance) {
        if (!is_numeric($distance) || $distance <= 0) {
            throw new InvalidArgumentException("A distância deve ser numérica e positiva");
        }
        return true;
    }
}

// Classe para transporte de ônibus
class Bus extends Transport {
    private $farePerKm;
    
    // Construtor da classe Bus
    public function __construct($name, $baseFare = 4.50, $farePerKm = 0.20) {
        parent::__construct($name, $baseFare);
        
        if (!is_numeric($farePerKm) || $farePerKm < 0) {
            throw new InvalidArgumentException("A tarifa por km deve ser numérica e não negativa");
        }
        
        $this->farePerKm = (float) $farePerKm;
    }
    
    // Calcula a tarifa do ônibus
    public function calculateFare($distance) {
        return $this->baseFare + ($distance * $this->farePerKm);
    }
    
    // Retorna informações específicas do ônibus
    public function getTransportInfo() {
        $info = parent::getTransportInfo();
        return $info . " | Tarifa por Km: R$ " . number_format($this->farePerKm, 2, ',', '.');
    }
}

// Classe para transporte de metrô
class Subway extends Transport {
    // Construtor da classe Subway
    public function __construct($name, $baseFare = 5.00) {
        parent::__construct($name, $baseFare);
    }
    
    // Calcula a tarifa do metrô (tarifa fixa)
    public function calculateFare($distance) {
        return $this->baseFare; // Tarifa fixa independente da distância
    }
}

// Classe para transporte de táxi
class Taxi extends Transport {
    private $farePerKm;
    private $flagFee;
    
    // Construtor da classe Taxi
    public function __construct($name, $baseFare = 6.00, $farePerKm = 2.50, $flagFee = 5.00) {
        parent::__construct($name, $baseFare);
        
        if (!is_numeric($farePerKm) || $farePerKm < 0) {
            throw new InvalidArgumentException("A tarifa por km deve ser numérica e não negativa");
        }
        
        if (!is_numeric($flagFee) || $flagFee < 0) {
            throw new InvalidArgumentException("A bandeirada deve ser numérica e não negativa");
        }
        
        $this->farePerKm = (float) $farePerKm;
        $this->flagFee = (float) $flagFee;
    }
    
    // Calcula a tarifa do táxi
    public function calculateFare($distance) {
        return $this->baseFare + $this->flagFee + ($distance * $this->farePerKm);
    }
    
    // Retorna informações específicas do táxi
    public function getTransportInfo() {
        $info = parent::getTransportInfo();
        return $info . " | Tarifa por Km: R$ " . number_format($this->farePerKm, 2, ',', '.') . 
               " | Bandeirada: R$ " . number_format($this->flagFee, 2, ',', '.');
    }
}

// Classe para gerenciamento de transportes
class TransportManager {
    public static function calculateFares(array $transports, $distance) {
        echo "<style>
                body { 
                    font-family: Arial, sans-serif; 
                    margin: 0;
                    padding: 30px;
                    min-height: 100vh;
                }
              </style>";
    }
    
    // Calcula tarifas para múltiplas distâncias
    public static function calculateMultipleDistances(array $transports, array $distances) {
        echo "<div class='container'>";
        
        echo "<table style='width: 100%; border-collapse: collapse; margin: 20px 0; background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-radius: 10px; overflow: hidden;'>";
        echo "<tr style='background: #2196F3; color: white;'>";
        echo "<th style='padding: 15px; text-align: left;'>Transporte</th>";
        
        foreach ($distances as $distance) {
            echo "<th style='padding: 15px; text-align: center;'>" . number_format($distance, 1, ',', '.') . " km</th>";
        }
        
        echo "</tr>";
        
        foreach ($transports as $transport) {
            echo "<tr style='border-bottom: 1px solid #ddd;'>";
            echo "<td style='padding: 15px; font-weight: bold;'>" . $transport->getName() . "</td>";
            
            foreach ($distances as $distance) {
                try {
                    $fare = $transport->processFareCalculation($distance);
                    echo "<td style='padding: 15px; text-align: center;'>R$ " . number_format($fare, 2, ',', '.') . "</td>";
                } catch (Exception $e) {
                    echo "<td style='padding: 15px; text-align: center; color: #d32f2f;'>Erro</td>";
                }
            }
            
            echo "</tr>";
        }
        
        echo "</table>";
        echo "</div>";
    }
}

// Teste com diferentes tipos de transporte
try {
    $transports = [
        new Bus("Ônibus Municipal"),
        new Subway("Metrô"),
        new Taxi("Táxi Convencional"),
        new Bus("Ônibus Executivo", 6.00, 0.30),
        new Taxi("Táxi Premium", 8.00, 3.50, 7.00)
    ];
    
    $distance = 10; // Distância em km
    
    TransportManager::calculateFares($transports, $distance);
    
    $multipleDistances = [2, 5, 10, 15, 20]; // Distâncias variadas em km
    echo "<h2 style='text-align: center; margin-top: 50px;'>Comparativo para Múltiplas Distâncias</h2>";
    TransportManager::calculateMultipleDistances($transports, $multipleDistances);
    
} catch (InvalidArgumentException $e) {
    echo "<div style='color:red; padding:10px; border:1px solid red; border-radius:5px; margin:10px;'>";
    echo "<strong>Erro:</strong> " . $e->getMessage();
    echo "</div>";
}
?>