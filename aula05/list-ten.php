<?php
class DatabaseConnection {
    // connection é privado 
    private $connection = null;

    // Método para conectar ao banco de dados
    private function connect() {
        $this->connection = "Conexão com banco de dados estabelecida.";
    }

    // Getter público para obter a conexão
    public function getConnection() {
        // Se a conexão ainda não foi estabelecida, conecta
        if ($this->connection === null) {
            $this->connect();
        }
        return $this->connection;
    }
}

// Instanciação 
$db = new DatabaseConnection();
echo $db->getConnection(); 

// Justificativa:
// O método connect() é privado para garantir que a conexão só seja estabelecida de forma controlada, evitando uso indevido externo.
// O método getConnection() é público para fornecer acesso seguro à conexão, criando-a sob demanda.
// O atributo connection é privado para proteger a integridade da conexão e evitar manipulação direta.
?>