<?php
class Config {
	protected $parameters = [];

	// Getter para todos os parâmetros
	public function getParameters() {
		return $this->parameters;
	}

	// Setter para todos os parâmetros 
	public function setParameters($params) {
		// Validação: deve ser array associativo
		if (is_array($params)) {
			$this->parameters = $params;
		}
	}

	// Getter para um parâmetro
	public function getParameter($key) {
		return isset($this->parameters[$key]) ? $this->parameters[$key] : null;
	}

	// Setter para um parâmetro específico com validação de chave e valor
	public function setParameter($key, $value) {
		if (is_string($key) && strlen($key) > 0) {
			$this->parameters[$key] = $value;
		}
	}
}

// Subclasse para configuração de banco de dados
class DatabaseConfig extends Config {
	// Define parâmetros padrão de banco de dados
	public function __construct() {
		$this->parameters = [
			'host' => 'localhost',
			'user' => 'root',
			'password' => '',
			'database' => 'test'
		];
	}

	// Validação extra para host
	public function setHost($host) {
		if (filter_var($host, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
			$this->parameters['host'] = $host;
		}
	}
	public function getHost() {
		return $this->parameters['host'];
	}
}

// Subclasse para configuração de API

// Instânciação
$dbConfig = new DatabaseConfig();
$dbConfig->setHost('127.0.0.1');
echo 'DB Host: ' . $dbConfig->getHost() . '<br>';

// Justificativa:
// O atributo parameters é protegido para garantir encapsulamento e acesso controlado pelas subclasses.
// Getters e setters permitem validação e flexibilidade para diferentes tipos de configuração.
// Subclasses especializadas facilitam a organização e manutenção do código.
?>