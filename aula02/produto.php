<?php
class Produto {
	public $nome;
	public $preco;
	public $quantidade;
	
	public function __construct($nome, $preco, $quantidade) {
		$this->nome = $nome;
		$this->preco = $preco;
		$this->quantidade = $quantidade;
	}
	
	public function valorTotal() {
		return $this->quantidade * $this->preco;
	}
	
	public function exibirDados() {
		$valor = $this->valorTotal();
		echo "<br>Para o item $this->nome, tem cerca de $this->quantidade com preço unitário de R$ $this->preco.
			  <br>Tudo dá cerca de R$ $valor<br>";
	}

    public function exibirDetalhes() {
		echo "<br><strong>Detalhes do Produto:</strong>";
		echo "<br>Nome: $this->nome";
		echo "<br>Preço: R$ $this->preco";
		echo "<br>Estoque: $this->quantidade unidades";
	}
}

?>