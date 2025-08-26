<?php
class Display {
    // Exibe informações
    public static function showEmployee(Employee $employee) {
        echo $employee->getName() . " | Salário: R$ " . number_format($employee->getSalary(), 2, ',', '.') . "<br>";
    }
}
class Employee {
    protected $name;
    protected $salary;

    // Construtor 
    public function __construct($name = "", $salary = 0) {
        $this->setName($name);
        $this->setSalary($salary);
    }

    // Getter para name
    public function getName() {
        return $this->name;
    }

    // Setter para name com validação
    public function setName($name) {
        //Nome não pode ser vazio e deve ser string
        if (is_string($name) && strlen(trim($name)) > 0) {
            $this->name = $name;
        } else {
            $this->name = "Funcionário sem nome";
        }
    }

    // Getter para salary
    public function getSalary() {
        return $this->salary;
    }

    // Setter para salary com validação
    public function setSalary($salary) {
        // Salário deve ser numérico, não negativo e condizente com a realidade
        if (is_numeric($salary) && $salary >= 0 && $salary <= 1000000) {
            $this->salary = $salary;
        } else {
            $this->salary = 0;
        }
    }
}
// Classe Manager herda de Employee
class Manager extends Employee {
    // Construtor
    public function __construct($name = "", $salary = 0) {
        parent::__construct($name, $salary);
        $this->setSalary($salary);
    }

    // Gerente é prefixado 
    public function setName($name) {
        if (is_string($name) && strlen(trim($name)) > 0) {
            $this->name = "Gerente: " . $name;
        } else {
            $this->name = "Gerente sem nome";
        }
    }

    // Setter para salary com bônus de 20%
    public function setSalary($salary) {
        // Salário numérico
        if (is_numeric($salary) && $salary >= 0 && $salary <= 1000000) {
            $this->salary = $salary * 1.2; 
        } else {
            $this->salary = 0;
        }
    }
}
// Classe User herda de Employee
class User extends Employee {
    // Construtor exige nome e salário
    public function __construct($name = "", $salary = 0) {
        parent::__construct($name, $salary);
    }

    // Usuário é prefixado
    public function setName($name) {
        if (is_string($name) && strlen(trim($name)) > 0) {
            $this->name = "Usuário: " . $name;
        } else {
            $this->name = "Usuário sem nome";
        }
    }
}
// Instanciação
$manager = new Manager("George Russell", 5000);   
Display::showEmployee($manager); 

$user = new User("Carlos Sainz", 3000);
Display::showEmployee($user); 

// Justificativa:
// - Os atributos foram definidos como protected para garantir encapsulamento e permitir acesso controlado pelas subclasses.
// - Os setters realizam validação rigorosa dos dados, evitando valores inválidos e facilitando manutenção.
// - O bônus do gerente é aplicado diretamente no método setSalary, garantindo clareza e flexibilidade.
// - O prefixo nos nomes facilita a identificação do tipo de funcionário.
?>