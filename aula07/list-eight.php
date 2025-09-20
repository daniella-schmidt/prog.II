<?php
class Printer {
    protected $fileName;
    public function __construct($fileName) {
        if (empty(trim($fileName))) {
            throw new InvalidArgumentException("O nome do arquivo não pode estar vazio");
        }
        $this->fileName = $fileName;
    }

    // Retorna a impressão genérica do arquivo
    public function print() {
        return "Arquivo genérico: " . $this->fileName;
    }
    public function getFileName() {
        return $this->fileName;
    }
    
    // Valida se o arquivo existe 
    protected function validateFile() {
        // Simulação de validação de arquivo
        $validExtensions = ['pdf', 'txt', 'png', 'jpg', 'docx'];
        $extension = pathinfo($this->fileName, PATHINFO_EXTENSION);
        
        if (!in_array(strtolower($extension), $validExtensions)) {
            throw new Exception("Tipo de arquivo não suportado: " . $extension);
        }
        
        return true;
    }
}

// Classe para impressão de arquivos PDF
class PdfPrinter extends Printer {
    public function print() {
        try {
            $this->validateFile();
            return "PDF <strong>" . $this->fileName . "</strong> está sendo impresso.";
        } catch (Exception $e) {
            return "Erro ao imprimir PDF: " . $e->getMessage();
        }
    }
    public function preview() {
        return "Visualizando PDF: " . $this->fileName;
    }
    public function protect() {
        return "Protegendo PDF com senha: " . $this->fileName;
    }
}

// Classe para impressão de arquivos de texto
class TextPrinter extends Printer {
    public function print() {
        try {
            $this->validateFile();
            return "Texto <strong>" . $this->fileName . "</strong> está sendo impresso.";
        } catch (Exception $e) {
            return "Erro ao imprimir texto: " . $e->getMessage();
        }
    }
    public function countWords() {
        // Simulação de contagem de palavras
        $wordCount = rand(100, 1000);
        return "Arquivo contém aproximadamente " . $wordCount . " palavras";
    }
}

// Classe para impressão de arquivos de imagem
class ImagePrinter extends Printer {
    public function print() {
        try {
            $this->validateFile();
            return "Imagem <strong>" . $this->fileName . "</strong> está sendo impressa.";
        } catch (Exception $e) {
            return "Erro ao imprimir imagem: " . $e->getMessage();
        }
    }
    public function resize($width, $height) {
        return "Redimensionando imagem para " . $width . "x" . $height . " pixels";
    }
    public function applyFilter($filter) {
        return "Aplicando filtro " . $filter . " na imagem";
    }
}

// Array de impressoras para demonstração
$printers = [
    new PdfPrinter("relatorio_financeiro.pdf"),
    new TextPrinter("documentacao.txt"),
    new ImagePrinter("foto_perfil.png"),
    new Printer("arquivo_generico.dat")
];

// Estilos CSS para melhorar a apresentação
echo "<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 20px;
        min-height: 100vh;
    }
    .container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .printer-list {
        display: grid;
        gap: 20px;
        margin: 30px 0;
    }
    .printer-item {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        border-left: 5px solid #ff9a9e;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .printer-header {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    .printer-name {
        font-weight: bold;
        color: #2d3436;
        margin: 0;
    }
    .printer-output {
        color: #43e856ff;
        font-style: italic;
        margin: 10px 0;
        padding: 10px;
        background: white;
        border-radius: 6px;
        border: 1px solid #79fd80ff;
    }
    .printer-actions {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px dashed #b2bec3;
    }
    .action-btn {
        background: #ff9a9e;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 20px;
        margin-right: 10px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: background 0.3s;
    }
</style>";

echo "<div class='container'>";
echo "<h1> Sistema de Impressão</h1>";

echo "<div class='printer-list'>";
foreach ($printers as $printer) {

    echo "<div class='printer-item'>";
    echo "<div class='printer-header'>";
    echo "<div class='printer-name'>" . $printer->getFileName() . "</div>";
    echo "</div>";
    
    echo "<div class='printer-output'>";
    echo $printer->print();
    echo "</div>";
    
    // Ações específicas para cada tipo de impressora
    echo "<div class='printer-actions'>";
    
    if ($printer instanceof PdfPrinter) {
        echo "<button class='action-btn' onclick=\"alert('" . $printer->preview() . "')\"> Visualizar</button>";
        echo "<button class='action-btn' onclick=\"alert('" . $printer->protect() . "')\"> Proteger</button>";
    }
    
    if ($printer instanceof TextPrinter) {
        echo "<button class='action-btn' onclick=\"alert('" . $printer->countWords() . "')\"> Contar Palavras</button>";
    }
    
    if ($printer instanceof ImagePrinter) {
        echo "<button class='action-btn' onclick=\"alert('" . $printer->resize(800, 600) . "')\"> Redimensionar</button>";
        echo "<button class='action-btn' onclick=\"alert('" . $printer->applyFilter('sepia') . "')\"> Filtro Sepia</button>";
    }
    
    if ($printer instanceof WordPrinter) {
        echo "<button class='action-btn' onclick=\"alert('" . $printer->convertToPdf() . "')\"> Converter para PDF</button>";
    }
    
    if ($printer instanceof Printer && !$printer instanceof PdfPrinter && 
        !$printer instanceof TextPrinter && !$printer instanceof ImagePrinter && !$printer instanceof WordPrinter) {
        echo "<span style='color: #636e72;'>Ações não disponíveis para impressora genérica</span>";
    }
    
    echo "</div>";
    echo "</div>";
}
echo "</div>";
?>