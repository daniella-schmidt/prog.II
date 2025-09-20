<?php
abstract class Message {
    protected $text;
    
    public function __construct($text) {
        if (empty(trim($text))) {
            throw new InvalidArgumentException("O texto da mensagem não pode estar vazio");
        }
        $this->text = $text;
    }
    
    abstract public function format();
    
    public function getText() {
        return $this->text;
    }
    
    public function processFormatting() {
        return $this->format();
    }
}

// Mensagens em maiúsculo
class UpperCaseMessage extends Message {
    public function format() {
        return strtoupper($this->text);
    }
}

// Mensagens em minúsculo
class LowerCaseMessage extends Message {
    public function format() {
        return strtolower($this->text);
    }
}

// Mensagens capitalizadas
class CapitalizedMessage extends Message {
    public function format() {
        return ucwords(strtolower($this->text));
    }
}

class MessageFormatter {
    public static function displayFormattedMessages(array $messages) {
        echo "<style>
                body { font-family: Arial, sans-serif; padding: 30px; background: #f0f2f5; }
                .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px;
                             border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
                h2 { text-align: center; margin-bottom: 30px; }
                .message-item { background: #f8f9fa; padding: 20px; border-radius: 12px; margin: 15px 0;
                                border-left: 5px solid #4CAF50; }
                .message-original { color: #666; font-style: italic; margin-bottom: 10px; }
                .message-formatted { font-weight: bold; font-size: 18px; padding: 10px;
                                     background: white; border-radius: 6px; border: 1px solid #ddd; }
                .message-type { display: inline-block; background: #4CAF50; color: white; padding: 5px 10px;
                                border-radius: 20px; font-size: 12px; margin-top: 10px; }
                .error { color: #d32f2f; background: #ffebee; padding: 15px; border-radius: 8px; margin: 15px 0; text-align: center; }
              </style>";
        
        echo "<div class='container'>";
        echo "<h2>Formatador de Mensagens</h2>";
        
        foreach ($messages as $message) {
            try {
                $formattedText = $message->processFormatting();
                
                // Nome mais amigável para exibir
                $messageType = [
                    "UpperCaseMessage" => "Maiúscula",
                    "LowerCaseMessage" => "Minúscula",
                    "CapitalizedMessage" => "Capitalizada"
                ][get_class($message)] ?? get_class($message);
                
                echo "<div class='message-item'>";
                echo "<div class='message-original'><strong>Original:</strong> " . htmlspecialchars($message->getText()) . "</div>";
                echo "<div class='message-formatted'><strong>Formatado:</strong> " . htmlspecialchars($formattedText) . "</div>";
                echo "<div class='message-type'>" . $messageType . "</div>";
                echo "</div>";
                
            } catch (Exception $e) {
                echo "<div class='error'><strong>Erro:</strong> " . $e->getMessage() . "</div>";
            }
        }
        
        echo "</div>";
    }
}

// Teste
$messages = [
    new UpperCaseMessage("php é uma linguagem de programação"),
    new LowerCaseMessage("JAVA É UMA LINGUAGEM ORIENTADA A OBJETOS"),
    new CapitalizedMessage("python é conhecida por sua sintaxe clara"),
    // new UpperCaseMessage(""), // <- Descomente para ver erro
    new LowerCaseMessage("JavaScript é a linguagem da web")
];

MessageFormatter::displayFormattedMessages($messages);
?>
