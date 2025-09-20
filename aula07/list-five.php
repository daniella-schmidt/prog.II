<?php
abstract class GeometricShape {
    protected $name;

    // Construtor da classe
    public function __construct($name) {
        if (empty(trim($name))) {
            throw new InvalidArgumentException("O nome da figura geométrica não pode estar vazio");
        }
        $this->name = $name;
    }
    
    // Método abstrato que deve ser implementado pelas subclasses
    abstract public function calculateArea();
    
    // Retorna informações da figura geométrica
    public function getShapeInfo() {
        return "Figura: {$this->name} | Área: " . $this->calculateArea();
    }
    public function getName() {
        return $this->name;
    }
    public final function processCalculation() {
        $this->validateDimensions();
        $area = $this->calculateArea();
        return $area;
    }
    
    // Valida as dimensões da figura geométrica
    protected function validateDimensions() {
        return true;
    }
}

// Classe para quadrados
class Square extends GeometricShape {
    private $side;
    public function __construct($side) {
        parent::__construct("Quadrado");
        
        if (!is_numeric($side)) {
            throw new InvalidArgumentException("O lado do quadrado deve ser numérico");
        }
        
        $this->side = (float) $side;
    }
    
    // Calcular a área
    public function calculateArea() {
        return $this->side * $this->side;
    }
    
    // Validade as dimensões
    protected function validateDimensions() {
        if ($this->side <= 0) {
            throw new InvalidArgumentException("O lado do quadrado deve ser positivo");
        }
        return true;
    }
    public function getShapeInfo() {
        return [
            "Figura" => $this->name,
            "Área" => $this->calculateArea(),
            "Lado" => $this->side
        ];
    }
}

// Classe para círculos
class Circle extends GeometricShape {
    private $radius;
    const PI = 3.141592;
    
    public function __construct($radius) {
        parent::__construct("Círculo");
        
        if (!is_numeric($radius)) {
            throw new InvalidArgumentException("O raio do círculo deve ser numérico");
        }
        
        $this->radius = (float) $radius;
    }
    
    // Calculo de área
    public function calculateArea() {
        return round(self::PI * $this->radius * $this->radius, 2);
    }
    
    protected function validateDimensions() {
        if ($this->radius <= 0) {
            throw new InvalidArgumentException("O raio do círculo deve ser positivo");
        }
        return true;
    }
    
    public function getShapeInfo() {
        return [
            "Figura" => $this->name,
            "Área" => $this->calculateArea(),
            "Raio" => $this->radius,
            "PI" => self::PI
        ];
    }
}

// Classe para retângulos
class Rectangle extends GeometricShape {
    private $width;
    private $height;

    public function __construct($width, $height) {
        parent::__construct("Retângulo");
        
        if (!is_numeric($width) || !is_numeric($height)) {
            throw new InvalidArgumentException("As dimensões do retângulo devem ser numéricas");
        }
        
        $this->width = (float) $width;
        $this->height = (float) $height;
    }
    
    // Calcula a área 
    public function calculateArea() {
        return $this->width * $this->height;
    }
    protected function validateDimensions() {
        if ($this->width <= 0 || $this->height <= 0) {
            throw new InvalidArgumentException("As dimensões do retângulo devem ser positivas");
        }
        return true;
    }
    
    public function getShapeInfo() {
        return [
            "Figura" => $this->name,
            "Área" => $this->calculateArea(),
            "Largura" => $this->width,
            "Altura" => $this->height
        ];
    }
}

// Classe para cálculo e exibição de resultados
class GeometryCalculator {
    public static function displayResults(array $shapes) {
        echo "<style>
                body { 
                    font-family: Arial, sans-serif; 
                    padding: 30px; 
                    margin: 0;
                    min-height: 100vh;
                }
                .container {
                    max-width: 1000px;
                    margin: 0 auto;
                    background: white;
                    padding: 30px;
                    border-radius: 15px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                }
                h2 { 
                    text-align: center; 
                    color: #333;
                    margin-bottom: 30px;
                    font-size: 28px;
                }
                table { 
                    border-collapse: collapse; 
                    width: 100%; 
                    margin: 20px auto; 
                    background: white; 
                    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                    border-radius: 10px;
                    overflow: hidden;
                }
                th, td { 
                    border: 1px solid #ddd; 
                    padding: 15px; 
                    text-align: center; 
                }
                th { 
                    background: #4CAF50; 
                    color: white; 
                    font-weight: bold;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                }
                tr:nth-child(even) { 
                    background: #f9f9f9; 
                }
                tr:hover {
                    background: #f1f1f1;
                    transition: background 0.3s;
                }
                .error { 
                    color: #d32f2f; 
                    background: #ffebee;
                    padding: 10px;
                    border-radius: 5px;
                    margin: 10px 0;
                    text-align: center;
                }
                .success {
                    color: #388e3c;
                    background: #e8f5e9;
                    padding: 15px;
                    border-radius: 8px;
                    margin: 20px 0;
                    text-align: center;
                    font-weight: bold;
                }
              </style>";
        
        echo "<div class='container'>";
        echo "<h2>📐 Calculadora Geométrica - Resultados</h2>";
        
        $totalArea = 0;
        $validShapes = 0;
        
        echo "<table>";
        echo "<tr>
                <th>Figura</th>
                <th>Área</th>
                <th>Detalhes</th>
              </tr>";
        
        foreach ($shapes as $shape) {
            try {
                $info = $shape->getShapeInfo();
                $details = "";
                
                foreach ($info as $key => $value) {
                    if ($key !== "Figura" && $key !== "Área") {
                        $details .= "<strong>$key:</strong> $value<br>";
                    }
                }
                
                echo "<tr>
                        <td><strong>{$info['Figura']}</strong></td>
                        <td><strong>{$info['Área']}</strong></td>
                        <td style='text-align: left;'>{$details}</td>
                      </tr>";
                
                $totalArea += $info['Área'];
                $validShapes++;
                
            } catch (Exception $e) {
                echo "<tr>
                        <td colspan='3' class='error'>
                            <strong>Erro:</strong> " . $e->getMessage() . "
                        </td>
                      </tr>";
            }
        }
        
        echo "</table>";
        
        if ($validShapes > 0) {
            echo "<div class='success'>";
            echo "Área total das {$validShapes} figuras válidas: <strong>" . round($totalArea, 2) . "</strong>";
            echo "</div>";
        }
        
        echo "</div>";
    }
    
    // Teste
    public static function testAllShapes() {
        $shapes = [];
        
        // Figuras válidas
        $shapes[] = new Square(5);
        $shapes[] = new Circle(3);
        $shapes[] = new Rectangle(4, 6);
        
        // Figuras inválidas (para demonstrar tratamento de erro)
        try {
            $shapes[] = new Square(-2);
        } catch (Exception $e) {
            // Apenas para demonstrar que será capturado no displayResults
            $shapes[] = new Square(-2);
        }
        
        try {
            $shapes[] = new Circle(0);
        } catch (Exception $e) {
            $shapes[] = new Circle(0);
        }
        
        self::displayResults($shapes);
    }
}

// Executar teste completo
GeometryCalculator::testAllShapes();

?>