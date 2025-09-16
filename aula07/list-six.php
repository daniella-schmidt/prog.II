<?php
abstract class Report {
    protected $title;

    public function __construct($title) {
        $this->title = $title;
    }

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
                    throw new BadMethodCallException("Invalid number of parameters for method '$name'");
            }
        }
        throw new BadMethodCallException("Method '$name' not found");
    }
    protected function generateDefault() {
        return "Report '{$this->title}' generated (default).";
    }

    protected function generateWithDate($date) {
        return "Report '{$this->title}' generated for date: $date.";
    }

    protected function generateWithPeriod($startDate, $endDate) {
        return "Report '{$this->title}' generated for period: $startDate to $endDate.";
    }
}

class FinancialReport extends Report {
    private $amount;

    public function __construct($title, $amount) {
        parent::__construct($title);
        $this->amount = $amount;
    }

    public function getAmount() {
        return $this->amount;
    }
}

class EmployeeReport extends Report {
    private $employees;

    public function __construct($title, array $employees) {
        parent::__construct($title);
        $this->employees = $employees;
    }

    public function listEmployees() {
        return "Employees: " . implode(", ", $this->employees);
    }
}

class ReportManager {
    public function printReport(Report $report) {
        echo $report->generate() . "<br>";
        echo $report->generate("2025-09-15") . "<br>";
        echo $report->generate("2025-09-01", "2025-09-15") . "<br>";
    }
}

$financialReport = new FinancialReport("Financial Summary", 15000);
$employeeReport = new EmployeeReport("Employee List", ["Doriane", "Lewis", "Charles"]);

$manager = new ReportManager();

echo "<h2>Financial Report</h2>";
$manager->printReport($financialReport);
echo "Total amount: $" . $financialReport->getAmount() . "<br>";

echo "<h2>Employee Report</h2>";
$manager->printReport($employeeReport);
echo $employeeReport->listEmployees();
?>
