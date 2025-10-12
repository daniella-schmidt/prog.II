<?php
class Emprestimo {
    private $usuario;
    private $livro;
    private $dataEmprestimo;
    private $dataDevolucao;

    // COMPOSIÇÃO: Emprestimo depende de Usuario e Livro que são partes da Biblioteca
    public function __construct(Usuario $usuario, Livro $livro, $dataEmprestimo, $dataDevolucao = null) {
        $this->usuario = $usuario;
        $this->livro = $livro;
        $this->dataEmprestimo = $dataEmprestimo;
        $this->dataDevolucao = $dataDevolucao;

        // Composição bidirecional
        $usuario->adicionarEmprestimo($this);
        $livro->adicionarEmprestimo($this);

        $livro->setDisponivel(false);
    }

    // Getters
    public function getUsuario(){ return $this->usuario; }
    public function getLivro(){ return $this->livro; }
    public function getDataEmprestimo(){ return $this->dataEmprestimo; }
    public function getDataDevolucao(){ return $this->dataDevolucao; }

    // Setters
    public function setDataDevolucao($dataDevolucao){
        $this->dataDevolucao = $dataDevolucao;
        $this->livro->setDisponivel(true);
    }

    // COMPOSIÇÃO: Emprestimo não existe sem Biblioteca
    public function __destruct() {
        echo "Empréstimo do livro '{$this->livro->getTitulo()}' finalizado<br>";
    }

    public function __toString() {
        return "Empréstimo: {$this->usuario->getNome()} - {$this->livro->getTitulo()} ({$this->dataEmprestimo}" . 
               ($this->dataDevolucao ? " até {$this->dataDevolucao}" : " - Pendente") . ")";
    }
}

class Relatorio {
    // DEPENDÊNCIA: uso temporário de Usuario e Livro
    public function gerarRelatorioEmprestimo(Usuario $usuario, Livro $livro, $dataEmprestimo, $dataDevolucao = null) {
        $relatorio = "\n";
        $relatorio .= "Usuário: " . $usuario->getNome() . " (CPF: " . $usuario->getCpf() . ")\n";
        $relatorio .= "Livro: " . $livro->getTitulo() . " - " . $livro->getAutor() . "\n";
        $relatorio .= "Data do Empréstimo: " . $dataEmprestimo . "\n";
        $relatorio .= "Data de Devolução: " . ($dataDevolucao ?? "Pendente") . "\n";
        $relatorio .= "Status: " . ($livro->estaDisponivel() ? "Devolvido" : "Em empréstimo") . "\n";
        
        return $relatorio;
    }
}
?>