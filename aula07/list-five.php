<?php
abstract class GeometricShape {
    protected $name;
    
    public function __construct($name) {
        $this->name = $name;
    }
    
    abstract public function calculateArea();
    
    public function getShapeInfo() {
        return "Shape: {$this->name} | Area: " . $this->calculateArea();
    }
    
    public function getName() {
        return $this->name;
    }

    public final function processCalculation() {
        $this->validateDimensions();
        $area = $this->calculateArea();
        $this->logCalculation();
        return $area;
    }
    
    protected function validateDimensions() {
        return true;
    }
    
    protected function logCalculation() {
        // Simula logging do cálculo (não exibe para o usuário)
    }
}

class Square extends GeometricShape {
    private $side;
    
    public function __construct($side) {
        parent::__construct("Square");
        $this->side = $side;
    }
    
    public function calculateArea() {
        return $this->side * $this->side;
    }
    
    protected function validateDimensions() {
        if ($this->side <= 0) {
            throw new InvalidArgumentException("Square side must be positive");
        }
        return true;
    }
    
    public function getShapeInfo() {
        return [
            "Shape" => $this->name,
            "Area" => $this->calculateArea(),
            "Side" => $this->side
        ];
    }
}

class Circle extends GeometricShape {
    private $radius;
    const PI = 3.14159;
    
    public function __construct($radius) {
        parent::__construct("Circle");
        $this->radius = $radius;
    }
    
    public function calculateArea() {
        return round(self::PI * $this->radius * $this->radius, 2);
    }
    
    protected function validateDimensions() {
        if ($this->radius <= 0) {
            throw new InvalidArgumentException("Circle radius must be positive");
        }
        return true;
    }
    
    public function getShapeInfo() {
        return [
            "Shape" => $this->name,
            "Area" => $this->calculateArea(),
            "Radius" => $this->radius
        ];
    }
}

class Rectangle extends GeometricShape {
    private $width;
    private $height;
    
    public function __construct($width, $height) {
        parent::__construct("Rectangle");
        $this->width = $width;
        $this->height = $height;
    }
    
    public function calculateArea() {
        return $this->width * $this->height;
    }
    
    protected function validateDimensions() {
        if ($this->width <= 0 || $this->height <= 0) {
            throw new InvalidArgumentException("Rectangle dimensions must be positive");
        }
        return true;
    }
    
    public function getShapeInfo() {
        return [
            "Shape" => $this->name,
            "Area" => $this->calculateArea(),
            "Width" => $this->width,
            "Height" => $this->height
        ];
    }
}

class GeometryCalculator {
    public static function displayResults(array $shapes) {
        echo "<style>
                body { font-family: Arial, sans-serif; background: #f4f4f9; padding: 20px; }
                table { border-collapse: collapse; width: 70%; margin: 20px auto; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
                th, td { border: 1px solid #ddd; padding: 12px; text-align: center; }
                th { background: #4CAF50; color: white; }
                tr:nth-child(even) { background: #f9f9f9; }
                h2 { text-align: center; }
              </style>";
        
        echo "<h2> Geometry Calculator Results</h2>";
        echo "<table>";
        echo "<tr><th>Shape</th><th>Area</th><th>Details</th></tr>";
        
        foreach ($shapes as $shape) {
            try {
                $info = $shape->getShapeInfo();
                $details = "";
                foreach ($info as $key => $value) {
                    if ($key !== "Shape" && $key !== "Area") {
                        $details .= "$key: $value<br>";
                    }
                }
                echo "<tr>
                        <td>{$info['Shape']}</td>
                        <td>{$info['Area']}</td>
                        <td>{$details}</td>
                      </tr>";
            } catch (Exception $e) {
                echo "<tr><td colspan='3'> Error: " . $e->getMessage() . "</td></tr>";
            }
        }
        echo "</table>";
    }
}

$square = new Square(5);
$circle = new Circle(3);
$rectangle = new Rectangle(4, 6);

$shapes = [$square, $circle, $rectangle];

GeometryCalculator::displayResults($shapes);
?>
