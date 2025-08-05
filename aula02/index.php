<?php
class Pessoa {
	// Atributos privados
	private $nome;
	private $email;
	private $idade;
	private $endereco;
	private $telefone;
	private $profissao;
	
	// Construtor
	public function __construct($nome, $email, $idade, $endereco, $telefone = "", $profissao = "") {
		$this->nome = $nome;
		$this->email = $email;
		$this->idade = $idade;
		$this->endereco = $endereco;
		$this->telefone = $telefone;
		$this->profissao = $profissao;
	}
	
	// Métodos getters
	public function getNome() {
		return $this->nome;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function getIdade() {
		return $this->idade;
	}
	
	public function getEndereco() {
		return $this->endereco;
	}
	
	public function getTelefone() {
		return $this->telefone;
	}
	
	public function getProfissao() {
		return $this->profissao;
	}
	
	// Método aniversário - aumenta a idade em 1
	public function aniversario() {
		$this->idade++;
	}
	
	// Método apresentar
	public function apresentar() {
		echo "<br>Apresentação";
		echo "<br><strong>Nome:</strong> $this->nome<br>";
		echo "<strong>Email:</strong> $this->email<br>";
		echo "<strong>Idade:</strong> $this->idade anos<br>";
		echo "<strong>Endereço:</strong> $this->endereco<br>";
		echo "<strong>Telefone:</strong> $this->telefone<br>";
        echo "<strong>Profissão:</strong> $this->profissao<br><br>";
	}
	
	// Método para contato rápido
	public function dadosContato() {
		echo "<br><strong>" . $this->nome . "</strong> - " . $this->email . " - " . $this->telefone;
	}
}

//array 
$pessoas = [
	new Pessoa(
		"Ana Silva", 
		"ana.silva@email.com", 
		25, 
		"Rua das Flores, 123 - Centro", 
		"(11) 99999-1111", 
		"Desenvolvedora"
	),
	new Pessoa(
		"Carlos Santos", 
		"carlos.santos@email.com", 
		32, 
		"Av. Paulista, 456 - São Paulo", 
		"(11) 88888-2222", 
		"Engenheiro"
	),
	new Pessoa(
		"Maria Oliveira", 
		"maria.oliveira@email.com", 
		28, 
		"Rua da Paz, 789 - Vila Madalena", 
		"(11) 77777-3333", 
		"Professora"
	)
];

foreach ($pessoas as $pessoa) {
	$pessoa->apresentar();
}

echo "<hr>";

// Estatísticas do cadastro
echo "Estatísticas do Cadastro:";
$totalPessoas = count($pessoas);
$idadeTotal = 0;
$maioresIdade = 0;

foreach ($pessoas as $pessoa) {
	$idadeTotal += $pessoa->getIdade();
	if ($pessoa->getIdade() >= 18) {
		$maioresIdade++;
	}
}

$idadeMedia = $idadeTotal / $totalPessoas;

echo "<br><strong>Total de pessoas cadastradas:</strong> $totalPessoas";
echo "<br><strong>Idade média:</strong> " . number_format($idadeMedia, 1) . " anos";
echo "<br><strong>Maiores de idade:</strong> $maioresIdade";
echo "<br><strong>Menores de idade:</strong> " . ($totalPessoas - $maioresIdade);

echo "<hr>";

// ------ //
require_once 'produto.php';

// Exemplo mais completo
$produtos = [
    new Produto("arroz", 5.50, 5),
    new Produto("feijão", 7.80, 3),
    new Produto("macarrão", 4.20, 8)
];

echo "<br>Lista de Produtos:";
foreach ($produtos as $produto) {
    $produto->exibirDados();
    echo "<br>";
}

foreach ($produtos as $produto) {
    $produto->exibirDetalhes();
    echo "<br>";
}

$valorTotalCompra = 0;
foreach ($produtos as $produto) {
    $valorTotalCompra += $produto->valorTotal();
}

echo "<br>Valor total da compra: <strong>R$ $valorTotalCompra</strong>";


?>