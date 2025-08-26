<?php
class Book {
    private $title;
    private $author;
    private $publicationYear;
    private $pagesNumber;
    private $disponibility;

    public function __construct($title, $author, $publicationYear, $pagesNumber, $disponibility = true){
        $this->title = $title;
        $this->author = $author;
        $this->publicationYear = $publicationYear;
        $this->pagesNumber = $pagesNumber;
        $this->disponibility = $disponibility;
    }

    public function setPublicationYear($publicationYear){
        if($publicationYear > date("Y")){
            throw new Exception("Ano de publicação não pode ser no futuro");
        }
        $this->publicationYear = $publicationYear;
    }

    public function setPagesNumber($pagesNumber){
        if($pagesNumber <= 0){
            throw new Exception("Número de páginas deve ser positivo");
        }
        $this->pagesNumber = $pagesNumber;
    }

    public function setTitle($title){
        if(empty($title)){
            throw new Exception("O título não pode ser vazio");
        }
        $this->title = $title;
    }

    public function setAuthor($author){
        if(empty($author)){
            throw new Exception("O autor não pode ser vazio");
        }
        $this->author = $author;
    }

    public function getDetails(){
        return "
            <div style='border:1px solid #ccc; padding:10px; margin:10px; border-radius:8px; font-family:Arial;'>
                <strong>Título:</strong> {$this->title} <br>
                <strong>Autor:</strong> {$this->author} <br>
                <strong>Ano:</strong> {$this->publicationYear} <br>
                <strong>Páginas:</strong> {$this->pagesNumber} <br>
                <strong>Disponibilidade:</strong> " . ($this->disponibility ? "✅ Disponível" : "❌ Indisponível") . "
            </div>
        ";
    }

    public function isAvailable(){
        return $this->disponibility;
    }
}

$book1 = new Book("Dom Casmurro", "Machado de Assis", 1899, 300);
$book2 = new Book("O Guarani", "José de Alencar", 1857, 250, false);

// Exibindo livros
echo $book1->getDetails();
echo $book2->getDetails();

// Testando os métodos set
try {
    $book1->setTitle("Memórias Póstumas de Brás Cubas");
    $book1->setAuthor("Machado de Assis");
    $book1->setPublicationYear(1881);
    $book1->setPagesNumber(320);

    echo "<h3> Após alterações:</h3>";
    echo $book1->getDetails();
} catch (Exception $e) {
    echo "<p style='color:red;'>Erro: " . $e->getMessage() . "</p>";
}
?>
