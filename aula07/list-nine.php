<?php
class Message {
    protected $text;

    public function __construct($text) {
        $this->text = $text;
    }

    public function format() {
        return $this->text;
    }

    public function getText() {
        return $this->text;
    }
}

class UpperCaseMessage extends Message {
    public function format() {
        return strtoupper($this->text);
    }
}

class LowerCaseMessage extends Message {
    public function format() {
        return strtolower($this->text);
    }
}

class CapitalizedMessage extends Message {
    public function format() {
        return ucwords(strtolower($this->text));
    }
}

$messages = [
    new UpperCaseMessage("está é a mensagem"),
    new LowerCaseMessage("EsTá É a MeNsAGeM"),
    new CapitalizedMessage("essa é outra mensagem"),
    new Message("Formato generico")
];

echo "<div style='font-family: Arial; background:#f0f8ff; padding:15px; border-radius:10px; width:500px;'>";

foreach ($messages as $msg) {
    echo "<p style='margin:8px 0; padding:10px; background:#fff; border:1px solid #ddd; border-radius:8px;'>";
    echo "<strong>Original:</strong> " . $msg->getText() . "<br>";
    echo "<strong>Formatado:</strong> <em>" . $msg->format() . "</em>";
    echo "</p>";
}

echo "</div>";
?>
