<?php
abstract class Notification {
    protected $recipient;
    protected $message;
    protected $timestamp;
    
    // Construtor da classe Notification
    public function __construct($recipient, $message) {
        if (empty(trim($recipient))) {
            throw new InvalidArgumentException("Destinatário não pode estar vazio");
        }
        
        if (empty(trim($message))) {
            throw new InvalidArgumentException("Mensagem não pode estar vazia");
        }
        
        $this->recipient = $recipient;
        $this->message = $message;
        $this->timestamp = date('Y-m-d H:i:s');
    }
    
    // Método abstrato que deve ser implementado pelas subclasses
    abstract public function send();
    
    // Retorna informações da notificação
    public function getNotificationInfo() {
        return "Destinatário: {$this->recipient} | Mensagem: {$this->message} | Hora: {$this->timestamp}";
    }
    
    public function getRecipient() {
        return $this->recipient;
    }
    
    public function getMessage() {
        return $this->message;
    }
    public function getTimestamp() {
        return $this->timestamp;
    }
    
    // Processa a notificação
    public final function processNotification() {
        $this->validate();
        $this->formatMessage();
        $result = $this->send();
        return $result;
    }
    
    // Valida os dados da notificação
    protected function validate() {
        if (empty($this->recipient)) {
            throw new InvalidArgumentException("Destinatário não pode estar vazio");
        }
        if (empty($this->message)) {
            throw new InvalidArgumentException("Mensagem não pode estar vazia");
        }
        return true;
    }
    
    protected function formatMessage() {
        $this->message = trim($this->message);
    }
}

// Classe para notificações por email
class Email extends Notification {
    private $subject;
    private $from;    
    private $cc;
    
    // Construtor da classe Email
    public function __construct($recipient, $subject, $message, $from = 'noreply@example.com', $cc = []) {
        parent::__construct($recipient, $message);
        
        if (empty(trim($subject))) {
            throw new InvalidArgumentException("Assunto do e-mail não pode estar vazio");
        }
        
        $this->subject = $subject;
        $this->from = $from;
        $this->cc = $cc;
    }
    
    // Envia a notificação por email
    public function send() {
        // Simula envio de email
        $messageId = uniqid('email_');
        
        return [
            'status' => 'success',
            'message' => 'E-mail enviado com sucesso!',
            'message_id' => $messageId,
            'recipient' => $this->recipient,
            'subject' => $this->subject,
            'from' => $this->from
        ];
    }
    
    // Valida os dados específicos do email
    protected function validate() {
        parent::validate();
        
        if (!filter_var($this->recipient, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("E-mail inválido: " . $this->recipient);
        }
        
        if (empty($this->subject)) {
            throw new InvalidArgumentException("O assunto do e-mail não pode estar vazio");
        }
        
        return true;
    }
    protected function formatMessage() {
        parent::formatMessage();
        $this->message = "<html><body>" . nl2br(htmlspecialchars($this->message)) . "</body></html>";
    }
    
    // Retorna informações da notificação por email/
    public function getNotificationInfo() {
        $info = parent::getNotificationInfo();
        return $info . " | Tipo: E-mail | Assunto: {$this->subject}";
    }
}

// Classe para notificações por SMS
class SMS extends Notification {
    private $senderId;
    
    // Construtor da classe SMS
    public function __construct($recipient, $message, $senderId = 'SERVICE') {
        parent::__construct($recipient, $message);
        $this->senderId = $senderId;
    }
    
    // Envia a notificação por SMS
    public function send() {
        // Simula envio de SMS
        $messageId = uniqid('sms_');
        
        return [
            'status' => 'success',
            'message' => 'SMS enviado com sucesso!',
            'message_id' => $messageId,
            'recipient' => $this->recipient,
            'sender_id' => $this->senderId
        ];
    }
    
    // Valida os dados específicos do SMS
    protected function validate() {
        parent::validate();
        
        if (!preg_match('/^\+?[0-9]{10,15}$/', $this->recipient)) {
            throw new InvalidArgumentException("Número de telefone inválido: " . $this->recipient);
        }
        
        return true;
    }
    protected function formatMessage() {
        parent::formatMessage();
        if (strlen($this->message) > 160) {
            $this->message = substr($this->message, 0, 157) . '...';
        }
    }
    
    // Retorna informações da notificação por SMS
    public function getNotificationInfo() {
        $info = parent::getNotificationInfo();
        return $info . " | Tipo: SMS | Remetente: {$this->senderId}";
    }
}

// Classe para notificações push
class Push extends Notification {
    private $deviceToken;
    private $title;
    private $badge;
    private $sound;
    
    // Construtor da classe Push
    public function __construct($deviceToken, $title, $message, $badge = 1, $sound = 'default') {
        parent::__construct($deviceToken, $message);
        
        if (empty(trim($title))) {
            throw new InvalidArgumentException("Título da notificação não pode estar vazio");
        }
        
        $this->deviceToken = $deviceToken;
        $this->title = $title;
        $this->badge = $badge;
        $this->sound = $sound;
    }
    
    // Envia a notificação push
    public function send() {
        // Simula envio de notificação push
        $messageId = uniqid('push_');
        
        return [
            'status' => 'success',
            'message' => 'Notificação push enviada com sucesso!',
            'message_id' => $messageId,
            'device_token' => $this->deviceToken,
            'title' => $this->title,
            'badge' => $this->badge
        ];
    }
    
    // Valida os dados específicos da notificação push
    protected function validate() {
        parent::validate();
        
        if (empty($this->title)) {
            throw new InvalidArgumentException("Título da notificação não pode estar vazio");
        }
        
        if (strlen($this->deviceToken) < 20) {
            throw new InvalidArgumentException("Token do dispositivo inválido: " . $this->deviceToken);
        }
        
        return true;
    }
    public function getNotificationInfo() {
        $info = parent::getNotificationInfo();
        return $info . " | Tipo: Push | Título: {$this->title}";
    }
}

class NotificationManager {
    public static function sendNotification(Notification $notification) {
        try {
            $result = $notification->processNotification();
            
            echo "<div style='border:1px solid #202020ff; padding:15px; margin:15px; border-radius:8px; background:#e8f5e9;'>";
            echo "<h3 style='margin-top:0; color:#2e7d32;'>Notificação Enviada</h3>";
            echo "<p style='margin:8px 0;'><strong>" . $notification->getNotificationInfo() . "</strong></p>";
            
            echo "<ul style='margin:8px 0; padding-left:20px;'>";
            echo "<li>Status: <strong>{$result['status']}</strong></li>";
            echo "<li>Mensagem: {$result['message']}</li>";
            if (isset($result['message_id'])) {
                echo "<li>ID: {$result['message_id']}</li>";
            }
            echo "</ul>";
            echo "</div>";
            
            return $result;
        } catch (Exception $e) {
            echo "<div style='border:1px solid #f44336; padding:15px; margin:15px; border-radius:8px; background:#ffebee;'>";
            echo "<h3 style='margin-top:0; color:#c62828;'>Erro no Envio</h3>";
            echo "<p><strong>" . $e->getMessage() . "</strong></p>";
            echo "</div>";
            
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
    
    // Envia múltiplas notificações
    public static function sendBulkNotifications(array $notifications) {
        $results = [];
        foreach ($notifications as $notification) {
            $results[] = self::sendNotification($notification);
        }
        return $results;
    }
}

echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #fafafa; }
    .container { max-width: 900px; margin: 0 auto; }
</style>";

echo "<div class='container'>";

// Testes com diferentes tipos de notificação
try {
    $emailNotification = new Email('user@example.com', 'Bem-vindo!', 'Obrigado por se cadastrar em nosso sistema!');
    $smsNotification = new SMS('+5511999999999', 'Seu código de verificação é 123456');
    $pushNotification = new Push('device_token_1234567890abcdefg1234567', 'Nova Mensagem', 'Você recebeu uma nova mensagem!');
    
    echo "<h2>Enviando Notificações Individuais</h2>";
    NotificationManager::sendNotification($emailNotification);
    NotificationManager::sendNotification($smsNotification);
    NotificationManager::sendNotification($pushNotification);
    
} catch (InvalidArgumentException $e) {
    echo "<div style='color:red; padding:10px; border:1px solid red; border-radius:5px; margin:10px;'>";
    echo "<strong>Erro:</strong> " . $e->getMessage();
    echo "</div>";
}
echo "</div>";
?>