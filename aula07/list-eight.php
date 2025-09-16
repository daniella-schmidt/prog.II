<?php
class Printer {
    protected $fileName;

    public function __construct($fileName) {
        $this->fileName = $fileName;
    }

    public function print() {
        return "Arquivo generico: " . $this->fileName;
    }

    public function getFileName() {
        return $this->fileName;
    }
}

class PdfPrinter extends Printer {
    public function print() {
        return "PDF <strong>" . $this->fileName . "</strong> está sendo impresso.";
    }
}

class TextPrinter extends Printer {
    public function print() {
        return "Text <strong>" . $this->fileName . "</strong> está sendo impresso.";
    }
}

class ImagePrinter extends Printer {
    public function print() {
        return "Image <strong>" . $this->fileName . "</strong> está sendo impresso.";
    }
}

$printers = [
    new PdfPrinter("report.pdf"),
    new TextPrinter("notes.txt"),
    new ImagePrinter("photo.png"),
    new Printer("generic.dat")
];

echo "<h2>Sistema de Impressão</h2>";
echo "<div style='font-family: Arial; background:#f9f9f9; padding:15px; border-radius:10px; width:400px;'>";

foreach ($printers as $printer) {
    echo "<p style='margin:8px 0; padding:10px; background:#fff; border:1px solid #ddd; border-radius:8px;'>";
    echo "<strong>Arquivo:</strong> " . $printer->getFileName() . "<br>";
    echo "<em>" . $printer->print() . "</em>";
    echo "</p>";
}

echo "</div>";
?>
