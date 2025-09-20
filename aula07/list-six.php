<?php
abstract class Report {
    protected $title;
    public function __construct($title) {
        if (empty(trim($title))) {
            throw new InvalidArgumentException("O título do relatório não pode estar vazio");
        }
        $this->title = $title;
    }

    // Método mágico para simular sobrecarga de métodos
    public function __call($name, $arguments) {
        if ($name === "generate") {
            switch (count($arguments)) {
                case 0:
                    return $this->generateDefault();
                case 1:
                    return $this->generateWithDate($arguments[0]);
                case 2:
                    return $this->generateWithPeriod($arguments[0], $arguments[1]);
                default:
                    throw new BadMethodCallException("Número inválido de parâmetros para o método '$name'");
            }
        }
        throw new BadMethodCallException("Método '$name' não encontrado");
    }
    
    // Gera relatório com configuração padrão
    protected function generateDefault() {
        return "Relatório '{$this->title}' gerado (padrão).";
    }

    // Gera relatório para uma data específica
    protected function generateWithDate($date) {
        // Validação básica da data
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            throw new InvalidArgumentException("Formato de data inválido. Use YYYY-MM-DD");
        }
        
        return "Relatório '{$this->title}' gerado para a data: $date.";
    }

    // Gera relatório para um período específico
    protected function generateWithPeriod($startDate, $endDate) {
        // Validação básica das datas
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $endDate)) {
            throw new InvalidArgumentException("Formato de data inválido. Use YYYY-MM-DD");
        }
        
        if (strtotime($startDate) > strtotime($endDate)) {
            throw new InvalidArgumentException("Data inicial não pode ser maior que data final");
        }
        
        return "Relatório '{$this->title}' gerado para o período: $startDate até $endDate.";
    }
    
    public function getTitle() {
        return $this->title;
    }
}

// Classe para relatórios financeiros
class FinancialReport extends Report {
    private $amount;
    public function __construct($title, $amount) {
        parent::__construct($title);
        
        if (!is_numeric($amount) || $amount < 0) {
            throw new InvalidArgumentException("O valor financeiro deve ser numérico e não negativo");
        }
        
        $this->amount = (float) $amount;
    }
    public function getAmount() {
        return $this->amount;
    }
    
    protected function generateDefault() {
        return "Relatório Financeiro '{$this->title}' gerado (padrão). Valor: R$ " . number_format($this->amount, 2, ',', '.');
    }
    protected function generateWithDate($date) {
        parent::generateWithDate($date); // Valida a data
        return "Relatório Financeiro '{$this->title}' gerado para a data: $date. Valor: R$ " . number_format($this->amount, 2, ',', '.');
    }
}

// Classe para relatórios de funcionários
class EmployeeReport extends Report {
    private $employees;
    public function __construct($title, array $employees) {
        parent::__construct($title);
        
        if (empty($employees)) {
            throw new InvalidArgumentException("A lista de funcionários não pode estar vazia");
        }
        
        $this->employees = $employees;
    }
    public function listEmployees() {
        return "Funcionários: " . implode(", ", $this->employees);
    }
    protected function generateDefault() {
        $count = count($this->employees);
        return "Relatório de Funcionários '{$this->title}' gerado (padrão). {$count} funcionários listados.";
    }
}

// Classe para gerenciamento de relatórios
class ReportManager {
    public function printReport(Report $report) {
        echo "<div style='background: #f5f5f5; padding: 20px; margin: 15px 0; border-radius: 10px; border-left: 5px solid #2196F3;'>";
        echo "<h3 style='margin-top: 0; color: #2196F3;'>Relatório: {$report->getTitle()}</h3>";
        
        try {
            echo "<p><strong>Padrão:</strong> " . $report->generate() . "</p>";
            echo "<p><strong>Com data:</strong> " . $report->generate("2025-09-15") . "</p>";
            echo "<p><strong>Com período:</strong> " . $report->generate("2025-09-01", "2025-09-15") . "</p>";
        } catch (Exception $e) {
            echo "<p style='color: #F44336;'><strong>Erro:</strong> " . $e->getMessage() . "</p>";
        }
        
        // Informações específicas de cada tipo de relatório
        if ($report instanceof FinancialReport) {
            echo "<p><strong>Valor:</strong> R$ " . number_format($report->getAmount(), 2, ',', '.') . "</p>";
        } elseif ($report instanceof EmployeeReport) {
            echo "<p><strong>" . $report->listEmployees() . "</strong></p>";
        }
        
        echo "</div>";
    }
    
    // Teste
    public function testAllReports() {
        $reports = [];
        
        try {
            $reports[] = new FinancialReport("Resumo Financeiro", 15000);
            $reports[] = new EmployeeReport("Lista de Funcionários", ["Doriane", "Lewis", "Charles"]);
            
            // Relatório com dados inválidos para demonstrar tratamento de erro
            $reports[] = new FinancialReport("Relatório Inválido", -100);
            
        } catch (Exception $e) {
            echo "<div style='background: #FFEBEE; padding: 15px; margin: 15px 0; border-radius: 10px; border-left: 5px solid #F44336;'>";
            echo "<h4 style='margin-top: 0; color: #F44336;'>Erro na Criação do Relatório</h4>";
            echo "<p>" . $e->getMessage() . "</p>";
            echo "</div>";
        }
        
        foreach ($reports as $report) {
            $this->printReport($report);
        }
    }
}

// Estilos para melhor apresentação
echo "<style>
    body { 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        margin: 0; 
        padding: 20px; 
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
    h1, h2 {
        color: #333;
        text-align: center;
    }
    h1 {
        margin-bottom: 10px;
        font-size: 32px;
    }
    h2 {
        margin-top: 0;
        margin-bottom: 30px;
        font-weight: normal;
        color: #666;
    }
</style>";

echo "<div class='container'>";

$manager = new ReportManager();

try {
    $financialReport = new FinancialReport("Resumo Financeiro Trimestral", 15000);
    $manager->printReport($financialReport);
} catch (Exception $e) {
    echo "<div style='color: #F44336; padding: 15px; background: #FFEBEE; border-radius: 8px;'>";
    echo "<strong>Erro:</strong> " . $e->getMessage();
    echo "</div>";
}

try {
    $employeeReport = new EmployeeReport("Lista de Funcionários", ["George Russel", "Lewis Hamilton", "Charles Leclerc", "Fernando Alonso", "Alex Albon"]);
    $manager->printReport($employeeReport);
} catch (Exception $e) {
    echo "<div style='color: #F44336; padding: 15px; background: #FFEBEE; border-radius: 8px;'>";
    echo "<strong>Erro:</strong> " . $e->getMessage();
    echo "</div>";
}
echo "</div>";
?>