<?php
class Usuario {
    private $cpf;
    private $nome;
    private $endereco;
    private $telefone;
    private $emprestimos;

    public function __construct($cpf, $nome, $endereco, $telefone){
        $this->cpf = $cpf;
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->emprestimos = [];
    }

    // Getters
    public function getCpf(){ return $this->cpf; }
    public function getNome(){ return $this->nome; }
    public function getEndereco(){ return $this->endereco; }
    public function getTelefone(){ return $this->telefone; }
    public function getEmprestimos(){
        return $this->emprestimos;
    }

    // Setters
    public function setEndereco($endereco){ $this->endereco = $endereco; }
    public function setTelefone($telefone){ $this->telefone = $telefone; }

    public function adicionarEmprestimo(Emprestimo $emprestimo){
        $this->emprestimos[] = $emprestimo;
    }
}
?>
